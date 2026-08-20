# Laravel Upgrade and Patching Guide

This repository does not currently have a dedicated guide for patching or upgrading Laravel itself, so this note records the project-specific process.

## Current baseline

- `composer.json` currently allows Laravel `^13.0`.
- `composer.lock` currently resolves `laravel/framework` to `v13.11.2`.
- Composer already runs a few useful follow-up steps after updates:
  - `php artisan filament:upgrade`
  - `php artisan vendor:publish --tag=laravel-assets --force`
  - `php artisan boost:update`

That means most Laravel framework updates here should be handled through Composer first, with the application-specific Artisan hooks allowed to run afterwards.

## Before updating

1. Check the working tree is in a good state and commit or stash anything unrelated.
2. Review the current Laravel upgrade guide if you are changing major versions.
3. Check what Composer thinks is out of date:

```bash
composer outdated laravel/framework
composer outdated "laravel/*"
```

4. If Composer refuses a target version, inspect the blocker:

```bash
composer why-not laravel/framework 13.12.0
```

Replace `13.12.0` with the version you are trying to reach.

## Patching Laravel within the current major

If the goal is to move from one Laravel 13 release to another without changing the major constraint in `composer.json`, the usual path is a targeted Composer update.

### Option A: update just Laravel and closely-related dependencies

```bash
composer update laravel/framework laravel/tinker --with-all-dependencies --minimal-changes
```

Use this when you want Composer to keep the change set small while still allowing dependency resolution to succeed.

### Option B: patch-only update across the project

```bash
composer update --patch-only
```

Use this when you want Composer to refresh locked packages but stay at patch-level changes only.

### Option C: dry run first

```bash
composer update laravel/framework laravel/tinker --with-all-dependencies --minimal-changes --dry-run
```

This is a good first pass when you want to see the solver result before touching `composer.lock`.

## Upgrading Laravel to a new major

Major upgrades are different from patching. The safe pattern is:

1. Read the official Laravel upgrade guide for the target version.
2. Update the relevant version constraints in `composer.json`.
3. Run a targeted Composer update with dependencies.
4. Fix any framework-level breaking changes.
5. Run the test suite and smoke-test the affected collection pages.

In practice that usually means adjusting `laravel/framework` first, then matching any first-party or test packages called out by the Laravel upgrade guide.

Example pattern:

```bash
composer update laravel/framework laravel/tinker laravel/boost pestphp/pest pestphp/pest-plugin-laravel --with-all-dependencies
```

Do not use that exact package list blindly for every major upgrade; confirm the target Laravel guide first and update the command to match the packages it requires.

## What already happens after `composer update`

This project's Composer scripts already help with framework updates:

- `post-autoload-dump` runs `php artisan package:discover` and `php artisan filament:upgrade`.
- `post-update-cmd` runs `php artisan vendor:publish --tag=laravel-assets --force` and `php artisan boost:update`.

That is useful because a Laravel or Filament update often needs fresh published assets and any Boost-maintained scaffolding to stay aligned.

## Where `deploy.sh` fits

Composer is the tool used to decide and lock the Laravel version, but `deploy.sh` is what applies that locked version on the server.

The normal flow is:

1. Run `composer update ...` locally to update `composer.lock`.
2. Commit the changed lock file and any related app code.
3. Run `./deploy.sh` on the server.

That script uses:

```bash
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
```

So production does **not** resolve new Laravel versions for itself. It installs the exact versions already recorded in `composer.lock`.

This distinction matters:

- `composer update` chooses new versions and rewrites `composer.lock`.
- `composer install` installs the versions already locked and committed.

In this repository, `deploy.sh` also runs:

- `php artisan migrate --force --no-interaction`
- `npm install`
- `npm run build`
- cache-clearing commands

So if a Laravel patch or upgrade includes migrations or frontend asset changes, the deployment script is already part of finishing that rollout.

## Recommended verification after updating

Run the smallest checks that still prove the update is safe:

```bash
php artisan optimize:clear
php artisan test --compact
```

If the update touched a specific area, prefer the relevant test file or `--filter` first. For example:

```bash
php artisan test --compact tests/Feature/SearchControllerPaginationTest.php
```

Then do a quick browser smoke test of the pages most likely to reveal upgrade regressions:

- home page
- one search results page
- one record page
- one Filament/admin screen if the update touched Filament

## Notes for this repo

- The README is older and still refers to Laravel 12 in a few places, but Composer is the source of truth for the current framework version.
- The README deployment section had fallen slightly behind `deploy.sh`; the script does run database migrations.
- Because the root constraint is `^13.0`, patch and minor Laravel 13 releases do not require editing `composer.json`; they only require updating the lock file.
- If you want to keep the guide next to migration notes, this file should live in `docs/` alongside `collection-migration.md`.
