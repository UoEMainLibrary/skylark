#!/usr/bin/env bash
set -Eeuo pipefail

# DEPLOY_ROOT allows the staging launcher to run this script from a temporary copy.
cd "${DEPLOY_ROOT:-$(dirname "$0")}"

branch=${1:-}
base_url=${2:-}
museum=${3:-}
if [[ -z "$branch" || ! "$base_url" =~ ^https?://[A-Za-z0-9.-]+(:[0-9]+)?$ || ( -n "$museum" && "$museum" != --museum ) ]]; then
    echo 'Usage: deploy-staging.sh BRANCH https://staging-host [--museum]' >&2
    exit 2
fi
git check-ref-format --branch "$branch" >/dev/null
if [[ "$branch" != staging ]]; then
    echo 'ERROR: This server is managed by Puppet on staging. Promote the feature branch with the local deploy-staging launcher first.' >&2
    exit 1
fi
for command in git composer php npm curl flock; do
    command -v "$command" >/dev/null || { echo "Missing required command: $command" >&2; exit 1; }
done
mkdir -p storage/logs
exec 9>storage/logs/deploy.lock
flock -n 9 || { echo 'Another deployment is already running.' >&2; exit 1; }
trap 'code=$?; echo "ERROR: Deployment failed at line $LINENO (exit $code). See the deployment log. Staging may be partially updated." >&2; exit "$code"' ERR

# This scheduled output is the only permitted server-side checkout difference.
generated_map=public/data/eerc_map_locations.json
map_backup=
restore_generated_map() {
    if [[ -n "$map_backup" ]]; then
        mkdir -p public/data
        cp -p "$map_backup" "$generated_map"
    fi
}
trap restore_generated_map EXIT

if [[ -n "$(git status --porcelain -- . ":!$generated_map")" ]]; then
    echo 'ERROR: Server checkout has local changes or untracked files. Review them before deploying.' >&2
    exit 1
fi
if [[ "$museum" == --museum ]] && ! grep -Eq '^STCECILIAS_MUSEUM_ENABLED=(true|"true"|\x27true\x27)[[:space:]]*$' .env; then
    echo 'ERROR: Set STCECILIAS_MUSEUM_ENABLED=true in the staging .env before using --museum.' >&2
    exit 1
fi

if [[ -f "$generated_map" ]]; then
    mkdir -p storage/app/deploy-backups
    map_backup="$(pwd)/$(mktemp storage/app/deploy-backups/eerc-map-XXXXXXXX)"
    cp -p "$generated_map" "$map_backup"
    echo "==> Preserved generated EERC map: $map_backup"
fi

echo "==> Fetching branch: $branch"
git fetch origin "refs/heads/$branch"
target=$(git rev-parse FETCH_HEAD)
echo "==> Previous commit: $(git rev-parse HEAD)"
echo "==> Target commit: $target ($branch)"
# Git must see the original tracked copy while moving to the branch that untracks it.
if [[ -n "$map_backup" ]] && git ls-files --error-unmatch "$generated_map" >/dev/null 2>&1; then
    git restore --source=HEAD --staged --worktree -- "$generated_map"
fi
if git show-ref --verify --quiet "refs/heads/$branch"; then
    git checkout "$branch"
    git merge --ff-only "$target"
else
    git checkout -b "$branch" "$target"
fi
[[ "$(git rev-parse HEAD)" == "$target" ]] || { echo 'ERROR: Local branch is ahead of the requested remote commit.' >&2; exit 1; }

restore_generated_map
map_backup=

echo '==> Installing dependencies and building assets'
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
[[ -f vendor/filament/filament/src/PanelProvider.php ]] || { echo 'ERROR: Filament was not installed.' >&2; exit 1; }
npm ci --no-audit --no-fund
npm run build

echo '==> Applying database migrations'
php artisan config:clear
php artisan migrate --force --no-interaction
if [[ "$museum" == --museum ]]; then
    php artisan db:seed --class=StceciliasMuseumSeeder --force --no-interaction
    if [[ ! -e public/storage && ! -L public/storage ]]; then
        php artisan storage:link --no-interaction
    fi
    [[ -r public/storage/stcecilias/concert-room.jpg ]] || { echo 'ERROR: Public museum images are not readable.' >&2; exit 1; }
fi
php artisan view:clear
php artisan route:clear
php artisan cache:clear

echo '==> Checking website responses'
paths=(/up)
if [[ "$museum" == --museum ]]; then
    paths+=(/stcecilias /stcecilias/planning-your-visit /stcecilias/venue-hire /stcecilias/whats-on /storage/stcecilias/concert-room.jpg /storage/stcecilias/laigh-hall.jpg /storage/stcecilias/saltire.jpg /storage/stcecilias/luke-wright.jpg /storage/stcecilias/cello.jpg)
fi
for path in "${paths[@]}"; do
    status=$(curl --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 15 --max-time 60 --retry 2 "$base_url$path")
    [[ "$status" == 200 ]] || { echo "ERROR: $path returned HTTP $status (expected 200)." >&2; exit 1; }
    echo "OK $path"
done
echo "==> Deployment complete: $target ($branch) at $(date -u +%FT%TZ)"
