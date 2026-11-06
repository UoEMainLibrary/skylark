#!/usr/bin/env bash
set -Eeuo pipefail

cd "${DEPLOY_ROOT:-$(dirname "$0")}"
source_branch=${1:-}
if [[ -z "$source_branch" ]]; then
    echo 'Usage: promote-staging.sh SOURCE_BRANCH' >&2
    exit 2
fi
git check-ref-format --branch "$source_branch" >/dev/null
if [[ -n "$(git status --porcelain)" ]]; then
    echo 'ERROR: Commit or set aside local changes before promoting to staging.' >&2
    exit 1
fi

echo "==> Preparing $source_branch for the Puppet-managed staging branch"
git fetch origin 'refs/heads/staging:refs/remotes/origin/staging'
if [[ "$source_branch" != staging ]]; then
    git fetch origin "refs/heads/$source_branch:refs/remotes/origin/$source_branch"
fi
source_commit=$(git rev-parse "refs/remotes/origin/$source_branch")
staging_commit=$(git rev-parse refs/remotes/origin/staging)
echo "==> Source commit: $source_commit; existing staging: $staging_commit"

# Merge in an isolated, temporary checkout; the user's working branch stays put.
worktree=$(mktemp -d "${TMPDIR:-/tmp}/skylark-staging-XXXXXXXX")
rmdir "$worktree"
cleanup() {
    if [[ -d "$worktree" ]]; then
        git worktree remove --force "$worktree"
    fi
}
trap cleanup EXIT
git worktree add --detach "$worktree" "$staging_commit"
if ! git -C "$worktree" merge --no-edit "$source_commit"; then
    echo 'ERROR: Staging merge conflicted. Nothing was pushed; resolve the branches before retrying.' >&2
    exit 1
fi
promoted_commit=$(git -C "$worktree" rev-parse HEAD)
# A normal push rejects concurrent/divergent staging updates; never force-push.
git -C "$worktree" push origin HEAD:refs/heads/staging
echo "==> Staging ready: $promoted_commit (includes $source_branch)"
