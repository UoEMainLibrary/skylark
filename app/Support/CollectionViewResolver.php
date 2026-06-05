<?php

namespace App\Support;

/**
 * Skin-version-aware view name resolution for collections that ship more than
 * one Blade tree (currently EERC, Public Art, and Geddes).
 *
 * The legacy versions of these helpers lived as `public static` methods on
 * `PageController` and were called from `SearchController`, `RecordController`,
 * `routes/web.php`, and Public Art tests. Pulling them out here breaks the
 * cross-controller import so per-collection controllers don't have to depend
 * on each other.
 */
class CollectionViewResolver
{
    /**
     * Resolve an EERC view name based on the active RESP skin version.
     * e.g. 'eerc.home' becomes 'eerc-v2.home' when skin version is 2.
     */
    public static function eerc(string $view): string
    {
        if (config('skylight.resp_skin_version') === 2) {
            return preg_replace('/^eerc\./', 'eerc-v2.', $view);
        }

        return $view;
    }

    /**
     * Resolve a Public Art view name based on the active skin version.
     * e.g. 'public-art.home' becomes 'public-art-v2.home' when skin version
     * is 2.
     */
    public static function publicArt(string $view): string
    {
        if ((int) config('skylight.public_art_skin_version') === 2) {
            return preg_replace('/^public-art\./', 'public-art-v2.', $view);
        }

        return $view;
    }

    /**
     * Resolve a Geddes view name based on the active skin version.
     * e.g. 'geddes.home' becomes 'geddes-v2.home' when skin version is 2.
     */
    public static function geddes(string $view): string
    {
        if ((int) config('skylight.geddes_skin_version') === 2) {
            return preg_replace('/^geddes\./', 'geddes-v2.', $view);
        }

        return $view;
    }
}
