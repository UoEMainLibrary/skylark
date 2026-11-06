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
            args = ['bash', str(SCRIPT), 'feature/museum', 'https://example.test']
            if museum:
                args.append('--museum')
            result = subprocess.run(args, env=env, capture_output=True, text=True)
            return result, (root / 'trace').read_text()

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

    def check_launcher(self, configure=False):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            ssh = root / 'ssh'
            ssh.write_text("#!/usr/bin/env python3\nimport os,sys\nfrom pathlib import Path\nprint('$ ', end='', flush=True)\nsys.stdin.readline()\nprint('$ ', end='', flush=True)\nsys.stdin.readline()\nprint('# ', end='', flush=True)\ncommand=''\nwhile True:\n line=sys.stdin.readline()\n command+=line\n if line.strip()=='SKYLARK_LAUNCH' or (not command.startswith('bash ') and line.startswith('cd /apps/')): break\nPath(os.environ['CAPTURE']).write_text(command)\n")
            ssh.chmod(0o755)
            env = dict(os.environ, PATH=f'{root}:{os.environ["PATH"]}', CAPTURE=str(root / 'command'))
            launcher = SCRIPT.parent.parent / 'deploy-staging'
            capture = (root / 'output').open('w+b')
            arguments = ['--configure-museum'] if configure else ['feature/museum', '--museum']
            process = subprocess.Popen([str(launcher), *arguments], env=env, stdin=subprocess.PIPE, stdout=capture, stderr=subprocess.PIPE)
            try:
                try:
                    process.wait(timeout=10)
                except subprocess.TimeoutExpired:
                    process.kill()
                    output, errors = process.communicate()
                    self.fail((root / 'output').read_text() + errors.decode())
                output, errors = process.communicate()
                self.assertEqual(process.returncode, 0, errors.decode())
                command = (root / 'command').read_text()
                check = subprocess.run(['bash', '-n'], input=command, text=True, capture_output=True)
                self.assertEqual(check.returncode, 0, check.stderr)
                if configure:
                    self.assertIn('STCECILIAS_MUSEUM_ENABLED=true', command)
                    self.assertIn('php artisan config:clear', command)
                    self.assertNotIn('nohup', command)
                else:
                    self.assertIn('nohup env DEPLOY_ROOT=', command)
                    self.assertIn('tail --pid=', command)
                    self.assertIn("'feature/museum' 'https://test.collections.ed.ac.uk' '--museum'", command)
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
