"""Isolated deployment checks: fake external commands, no network or real deployment."""
import os
from pathlib import Path
import subprocess
import tempfile
import unittest

SCRIPT = Path(__file__).resolve().parents[1] / 'deploy-staging.sh'


class DeploymentTest(unittest.TestCase):
    def run_deploy(self, scenario='', museum=False):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            binary = root / 'bin'
            binary.mkdir()
            (root / 'vendor/filament/filament/src').mkdir(parents=True)
            (root / 'vendor/filament/filament/src/PanelProvider.php').touch()
            (root / '.env').write_text('STCECILIAS_MUSEUM_ENABLED=true\n' if scenario != 'disabled' else '')
            for name in ['concert-room', 'laigh-hall', 'saltire', 'luke-wright', 'cello']:
                image = root / f'public/storage/stcecilias/{name}.jpg'
                image.parent.mkdir(parents=True, exist_ok=True)
                image.touch()
            stub = '''#!/usr/bin/env bash
printf '%s %s\\n' "${0##*/}" "$*" >> "$TRACE"
case "${0##*/}:$*" in
  git:status*) [[ "$SCENARIO" != dirty ]] || echo ' M app.php';;
  git:rev-parse*) if [[ "$SCENARIO" == ahead && "$*" == 'rev-parse HEAD' ]]; then echo local; else echo target; fi;;
  npm:'run build') [[ "$SCENARIO" != build-failure ]];;
  curl:*) if [[ "$SCENARIO" == http-failure ]]; then printf 500; else printf 200; fi;;
esac
'''
            for command in ['git', 'composer', 'php', 'npm', 'curl', 'flock']:
                path = binary / command
                path.write_text(stub)
                path.chmod(0o755)
            env = dict(os.environ, PATH=f'{binary}:{os.environ["PATH"]}', DEPLOY_ROOT=str(root), TRACE=str(root / 'trace'), SCENARIO=scenario)
            args = ['bash', str(SCRIPT), 'staging', 'https://example.test']
            if museum:
                args.append('--museum')
            result = subprocess.run(args, env=env, capture_output=True, text=True)
            return result, (root / 'trace').read_text()

    def test_staging_promotion_preserves_both_branches_and_rejects_unsafe_updates(self):
        promotion = SCRIPT.parent / 'promote-staging.sh'
        for scenario in ['success', 'conflict', 'dirty', 'push-rejected']:
            with self.subTest(scenario=scenario), tempfile.TemporaryDirectory() as directory:
                root = Path(directory)
                remote = root / 'remote.git'
                repo = root / 'local'
                repo.mkdir()
                subprocess.run(['git', 'init', '--bare', str(remote)], check=True, capture_output=True)
                def git(*args, check=True):
                    return subprocess.run(['git', *args], cwd=repo, check=check, capture_output=True, text=True).stdout.strip()
                git('init', '-b', 'staging')
                git('config', 'user.email', 'deploy-test@example.test')
                git('config', 'user.name', 'Deployment Test')
                (repo / 'shared.txt').write_text('base\n')
                git('add', '.')
                git('commit', '-m', 'Base')
                git('remote', 'add', 'origin', str(remote))
                git('push', '-u', 'origin', 'staging')
                git('checkout', '-b', 'feature/museum')
                (repo / 'museum.txt').write_text('museum content\n')
                if scenario == 'conflict':
                    (repo / 'shared.txt').write_text('feature change\n')
                git('add', '.')
                git('commit', '-m', 'Museum')
                git('push', '-u', 'origin', 'feature/museum')
                git('checkout', 'staging')
                (repo / 'existing-staging.txt').write_text('other staging work\n')
                if scenario == 'conflict':
                    (repo / 'shared.txt').write_text('staging change\n')
                git('add', '.')
                git('commit', '-m', 'Other staging work')
                git('push', 'origin', 'staging')
                previous_staging = git('rev-parse', 'staging')
                git('checkout', 'feature/museum')
                previous_feature = git('rev-parse', 'HEAD')
                if scenario == 'dirty':
                    (repo / 'uncommitted.txt').write_text('keep this\n')
                if scenario == 'push-rejected':
                    hook = remote / 'hooks/pre-receive'
                    hook.write_text('#!/bin/sh\nexit 1\n')
                    hook.chmod(0o755)
                result = subprocess.run(['bash', str(promotion), 'feature/museum'], env=dict(os.environ, DEPLOY_ROOT=str(repo)), capture_output=True, text=True)
                self.assertEqual(result.returncode == 0, scenario == 'success', result.stderr)
                self.assertEqual(git('branch', '--show-current'), 'feature/museum')
                self.assertEqual(git('rev-parse', 'HEAD'), previous_feature)
                self.assertEqual(len(git('worktree', 'list', '--porcelain').split('worktree ')) - 1, 1)
                git('fetch', 'origin', 'staging')
                if scenario == 'success':
                    self.assertEqual(git('show', 'origin/staging:museum.txt'), 'museum content')
                    self.assertEqual(git('show', 'origin/staging:existing-staging.txt'), 'other staging work')
                    self.assertEqual(git('status', '--porcelain'), '')
                else:
                    self.assertEqual(git('rev-parse', 'origin/staging'), previous_staging)

    def test_server_refuses_feature_branch_checkout(self):
        result = subprocess.run(['bash', str(SCRIPT), 'feature/museum', 'https://example.test'], capture_output=True, text=True)
        self.assertNotEqual(result.returncode, 0)
        self.assertIn('managed by Puppet on staging', result.stderr)

    def test_generated_map_survives_real_branch_switch(self):
        for fail_fetch in [False, True]:
            with self.subTest(fail_fetch=fail_fetch), tempfile.TemporaryDirectory() as directory:
                root = Path(directory)
                repo = root / 'checkout'
                repo.mkdir()
                def git(*args):
                    return subprocess.run(['git', *args], cwd=repo, check=True, capture_output=True, text=True).stdout.strip()
                git('init', '-b', 'old')
                git('config', 'user.email', 'deploy-test@example.test')
                git('config', 'user.name', 'Deployment Test')
                generated = repo / 'public/data/eerc_map_locations.json'
                generated.parent.mkdir(parents=True)
                generated.write_text('old tracked map')
                (repo / '.gitignore').write_text('/storage/\n/vendor/\n/.env\n')
                git('add', '.')
                git('commit', '-m', 'Tracked map')
                git('checkout', '-b', 'staging')
                git('rm', 'public/data/eerc_map_locations.json')
                with (repo / '.gitignore').open('a') as handle:
                    handle.write('/public/data/eerc_map_locations.json\n')
                git('add', '.gitignore')
                git('commit', '-m', 'Untrack generated map')
                git('checkout', 'old')
                git('remote', 'add', 'origin', str(repo) if not fail_fetch else str(root / 'missing'))
                current = b'{"locations":[{"name":"Current staging data"}]}\n'
                generated.parent.mkdir(parents=True, exist_ok=True)
                generated.write_bytes(current)
                (repo / '.env').write_text('STCECILIAS_MUSEUM_ENABLED=true\n')
                panel = repo / 'vendor/filament/filament/src/PanelProvider.php'
                panel.parent.mkdir(parents=True)
                panel.touch()
                binary = root / 'bin'
                binary.mkdir()
                for command in ['composer', 'php', 'npm', 'curl', 'flock']:
                    stub = binary / command
                    stub.write_text('#!/bin/sh\n' + ('printf 200\n' if command == 'curl' else 'exit 0\n'))
                    stub.chmod(0o755)
                result = subprocess.run(['bash', str(SCRIPT), 'staging', 'https://example.test'], env=dict(os.environ, PATH=f'{binary}:{os.environ["PATH"]}', DEPLOY_ROOT=str(repo)), capture_output=True, text=True)
                self.assertEqual(result.returncode == 0, not fail_fetch, result.stderr)
                self.assertEqual(generated.read_bytes(), current)
                backups = list((repo / 'storage/app/deploy-backups').glob('eerc-map-*'))
                self.assertEqual(len(backups), 1)
                self.assertEqual(backups[0].read_bytes(), current)
                if not fail_fetch:
                    self.assertEqual(git('status', '--porcelain'), '')
                    self.assertEqual(git('ls-files', 'public/data/eerc_map_locations.json'), '')

    def test_success_checks_all_pages_and_images(self):
        result, trace = self.run_deploy(museum=True)
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertIn('Deployment complete: target', result.stdout)
        self.assertIn('npm ci --no-audit --no-fund', trace)
        self.assertIn('db:seed --class=StceciliasMuseumSeeder', trace)
        self.assertEqual(trace.count('curl '), 10)
        self.assertLess(trace.index('npm run build'), trace.index('php artisan migrate'))

    def test_dirty_checkout_stops_before_fetch(self):
        result, trace = self.run_deploy('dirty')
        self.assertNotEqual(result.returncode, 0)
        self.assertNotIn('git fetch', trace)

    def test_disabled_museum_stops_before_fetch(self):
        result, trace = self.run_deploy('disabled', museum=True)
        self.assertNotEqual(result.returncode, 0)
        self.assertNotIn('git fetch', trace)

    def test_build_failure_stops_before_migrations(self):
        result, trace = self.run_deploy('build-failure')
        self.assertNotEqual(result.returncode, 0)
        self.assertNotIn('php artisan migrate', trace)
        self.assertIn('Deployment failed', result.stderr)

    def test_bad_http_status_fails_deployment(self):
        result, _ = self.run_deploy('http-failure')
        self.assertNotEqual(result.returncode, 0)
        self.assertIn('HTTP 500', result.stderr)

    def test_local_commit_ahead_is_rejected(self):
        result, trace = self.run_deploy('ahead')
        self.assertNotEqual(result.returncode, 0)
        self.assertNotIn('composer install', trace)

    def test_ordinary_deploy_does_not_seed(self):
        result, trace = self.run_deploy()
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertNotIn('db:seed', trace)
        self.assertEqual(trace.count('curl '), 1)

    def test_launcher_constructs_valid_detached_command(self):
        self.check_launcher()

    def test_launcher_can_configure_without_deploying(self):
        self.check_launcher(configure=True)

    def test_launcher_enters_keychain_password_without_displaying_it(self):
        self.check_launcher(configure=True, authenticate=True)

    def check_launcher(self, configure=False, authenticate=False):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            ssh = root / 'ssh'
            ssh.write_text("#!/usr/bin/env python3\nimport os,sys\nfrom pathlib import Path\nprint('$ ', end='', flush=True)\nsys.stdin.readline()\nprint('$ ', end='', flush=True)\nsys.stdin.readline()\nprint('# ', end='', flush=True)\nsys.stdin.readline()\nprint('\\n__UOE_USER__lacddt\\n', flush=True)\ncommand=''\nwhile True:\n line=sys.stdin.readline()\n command+=line\n if line.strip()=='SKYLARK_LAUNCH' or (not command.startswith('bash ') and line.startswith('cd /apps/')): break\nPath(os.environ['CAPTURE']).write_text(command)\n")
            if authenticate:
                content = ssh.read_text()
                content = content.replace("sys.stdin.readline()\nprint('# ',", "sys.stdin.readline()\nprint('Password: ', end='', flush=True)\npassword=sys.stdin.readline().strip()\nassert password=='FAKE_KEYCHAIN_PASSWORD', password\nprint('# ',")
                ssh.write_text(content)
            ssh.chmod(0o755)
            env = dict(os.environ, PATH=f'{root}:{os.environ["PATH"]}', CAPTURE=str(root / 'command'))
            launcher = root / 'deploy-staging'
            launcher.write_bytes((SCRIPT.parent.parent / 'deploy-staging').read_bytes())
            launcher.chmod(0o755)
            (root / 'skylark').mkdir()
            (root / 'skylark/deploy-staging.sh').write_bytes(SCRIPT.read_bytes())
            (root / 'skylark/promote-staging.sh').write_text('echo "simulated promotion: $1"\n')
            capture = (root / 'output').open('w+b')
            arguments = ['--configure-museum'] if configure else ['feature/museum', '--museum']
            launch = [str(launcher), *arguments]
            if authenticate:
                harness = root / 'keychain-test.exp'
                harness.write_text('rename exec real_exec\nproc exec {args} { if {[lindex $args 0] eq "/usr/bin/security"} { return "FAKE_KEYCHAIN_PASSWORD" }; return [uplevel 1 [linsert $args 0 real_exec]] }\nset script [lindex $argv 0]\nset argv [lrange $argv 1 end]\nset argc [llength $argv]\nsource $script\n')
                launch = ['/usr/bin/expect', str(harness), str(launcher), *arguments]
            process = subprocess.Popen(launch, env=env, stdin=subprocess.PIPE, stdout=capture, stderr=subprocess.PIPE)
            try:
                try:
                    process.wait(timeout=10)
                except subprocess.TimeoutExpired:
                    process.kill()
                    output, errors = process.communicate()
                    self.fail((root / 'output').read_text() + errors.decode())
                output, errors = process.communicate()
                self.assertEqual(process.returncode, 0, errors.decode())
                if authenticate:
                    self.assertNotIn('FAKE_KEYCHAIN_PASSWORD', (root / 'output').read_text())
                command = (root / 'command').read_text()
                check = subprocess.run(['bash', '-n'], input=command, text=True, capture_output=True)
                self.assertEqual(check.returncode, 0, check.stderr)
                if configure:
                    self.assertIn('STCECILIAS_MUSEUM_ENABLED=true', command)
                    self.assertIn('php artisan config:clear', command)
                    self.assertNotIn('nohup', command)
                else:
                    self.assertIn('simulated promotion: feature/museum', (root / 'output').read_text())
                    self.assertIn('nohup env DEPLOY_ROOT=', command)
                    self.assertLess(command.index(': > "$log" || exit 1'), command.index('nohup env DEPLOY_ROOT='))
                    self.assertIn('tail --pid=', command)
                    self.assertIn("'staging' 'https://test.collections.ed.ac.uk' '--museum'", command)
            finally:
                capture.close()
                if process.poll() is None:
                    process.kill()
                    process.communicate()

    def test_missing_arguments_are_rejected(self):
        result = subprocess.run(['bash', str(SCRIPT)], capture_output=True, text=True)
        self.assertEqual(result.returncode, 2)


if __name__ == '__main__':
    unittest.main()
