<?php

namespace App\Support;

/**
 * Thin wrapper around config('cms.*') so view code, composers and tests
 * stay readable. The single source of truth for "is this page managed by
 * the CMS, and how" remains config/cms.php.
 */
class Cms
{
    /**
     * Is the CMS globally enabled? Pages flagged `always_cms` ignore this
     * and render the DB body unconditionally — see pageAlwaysCms().
     */
    public static function enabled(): bool
    {
        return (bool) config('cms.enabled', false);
    }

    /**
     * Per-page registry entry, or null when the page is not managed.
     *
     * @return array<string, mixed>|null
     */
    public static function page(string $collection, string $slug): ?array
    {
        $entry = config("cms.pages.{$collection}.{$slug}");

        return is_array($entry) ? $entry : null;
    }

    /**
     * Pages flagged `always_cms` render the DB body even when CMS_ENABLED
     * is false (their Blade fallback has already been stripped).
     */
    public static function pageAlwaysCms(string $collection, string $slug): bool
    {
        return (bool) (static::page($collection, $slug)['always_cms'] ?? false);
    }

    /**
     * How many editable image slots a page exposes (0, 1 or 2).
     */
    public static function pageImageCount(string $collection, string $slug): int
    {
        return (int) (static::page($collection, $slug)['images'] ?? 0);
    }

    /**
     * Should the CMS body be used for this page on the current request?
     * True when the global toggle is on or when the page is always_cms.
     */
    public static function shouldRenderCms(string $collection, string $slug): bool
    {
        return static::enabled() || static::pageAlwaysCms($collection, $slug);
    }
}
