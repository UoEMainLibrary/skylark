<?php

namespace App\Support;

class CollectionUrl
{
    /**
     * Path prefix for the active collection (e.g. '' or '/openbooks'), set by CollectionMiddleware.
     */
    public static function pathPrefix(): string
    {
        $explicit = config('app.collection_path_prefix');

        if ($explicit !== null) {
            return $explicit;
        }

        $urlPrefix = config('skylight.url_prefix');
        if ($urlPrefix === null || $urlPrefix === '') {
            return '';
        }

        return '/'.$urlPrefix;
    }

    /**
     * Absolute URL for a path under the current collection (no leading slash on $path).
     */
    public static function url(string $path = ''): string
    {
        $prefix = self::pathPrefix();
        $path = ltrim($path, '/');

        if ($prefix === '') {
            return $path === '' ? url('/') : url('/'.$path);
        }

        return $path === '' ? url($prefix) : url($prefix.'/'.$path);
    }

    /**
     * Trailing-slash base URL for the HTML base element.
     */
    public static function baseHref(): string
    {
        return rtrim(self::url(''), '/').'/';
    }
}
