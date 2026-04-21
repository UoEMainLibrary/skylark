<?php

namespace App\Helpers;

use App\Support\CollectionUrl;

class BitstreamHelper
{
    /**
     * Parse bitstream metadata string
     * Format: mime##filename##bytes##handle##seq##md5##description
     */
    public static function parse(string $metadataValue): array
    {
        return explode('##', $metadataValue);
    }

    /**
     * Get bitstream filename
     */
    public static function getFilename(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);

        return $segments[1] ?? '';
    }

    /**
     * Get bitstream size in bytes
     */
    public static function getSizeInBytes(string $metadataValue): int
    {
        $segments = self::parse($metadataValue);

        return (int) ($segments[2] ?? 0);
    }

    /**
     * Get bitstream size formatted (Kb, Mb, Gb)
     */
    public static function getFormattedSize(string $metadataValue): string
    {
        $size = self::getSizeInBytes($metadataValue);

        if ($size > 1024 * 1024 * 1024) {
            return round($size / 1024 / 1024 / 1024, 2).' Gb';
        } elseif ($size > 1024 * 1024) {
            return round($size / 1024 / 1024, 2).' Mb';
        } elseif ($size > 1024) {
            return round($size / 1024, 2).' Kb';
        }

        return $size.'b';
    }

    /**
     * Get bitstream handle
     */
    public static function getHandle(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);
        $handle = $segments[3] ?? '';

        return preg_replace('/^.*\//', '', $handle);
    }

    /**
     * Get bitstream sequence number
     */
    public static function getSequence(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);

        return $segments[4] ?? '';
    }

    /**
     * Get bitstream MIME type
     */
    public static function getMimeType(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);

        return $segments[0] ?? '';
    }

    /**
     * Get bitstream MD5 hash
     */
    public static function getMd5(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);

        return $segments[5] ?? '';
    }

    /**
     * Get bitstream description
     */
    public static function getDescription(string $metadataValue): string
    {
        $segments = self::parse($metadataValue);

        return $segments[6] ?? '';
    }

    /**
     * Get bitstream URI for the image proxy
     */
    public static function getUri(string $metadataValue): string
    {
        $handleId = self::getHandle($metadataValue);
        $seq = self::getSequence($metadataValue);
        $filename = self::getFilename($metadataValue);

        return "/record/{$handleId}/{$seq}/{$filename}";
    }

    /**
     * Absolute URL to the app bitstream proxy for the active collection (e.g. /openbooks/record/.../file.pdf).
     */
    public static function getCollectionProxiedUrl(string $metadataValue): string
    {
        return CollectionUrl::url(ltrim(self::getUri($metadataValue), '/'));
    }

    /**
     * Rewrite external digitalpreservation URLs to use the app's own domain.
     * Enabled via REWRITE_BITSTREAM_URLS=true in .env (for Caddy proxy on the server).
     */
    public static function rewriteBitstreamUrl(string $url): string
    {
        if (! config('services.dspace.rewrite_bitstream_urls')) {
            return $url;
        }

        return str_replace(
            'https://digitalpreservation.is.ed.ac.uk',
            rtrim(config('app.url'), '/'),
            $url
        );
    }

    /**
     * Check if bitstream is an image
     */
    public static function isImage(string $metadataValue): bool
    {
        $filename = strtolower(self::getFilename($metadataValue));

        return str_ends_with($filename, '.jpg')
            || str_ends_with($filename, '.jpeg')
            || str_ends_with($filename, '.png')
            || str_ends_with($filename, '.gif')
            || str_ends_with($filename, '.webp');
    }

    /**
     * Whether this bitstream should be treated as a downloadable PDF.
     *
     * DSpace/Solr sometimes attach a misleading ".pdf" filename to non-PDF payloads
     * (e.g. IIIF presentation JSON). The MIME segment in the metadata string is authoritative when set.
     */
    public static function isPdf(string $metadataValue): bool
    {
        $mime = strtolower(trim(self::getMimeType($metadataValue)));
        $filename = strtolower(self::getFilename($metadataValue));

        if ($mime !== '') {
            if (str_contains($mime, 'pdf')) {
                return true;
            }
            if (str_contains($mime, 'json') || str_contains($mime, 'javascript') || str_contains($mime, 'text/html')) {
                return false;
            }
            if ($mime !== 'application/octet-stream') {
                return false;
            }
        }

        return str_contains($filename, '.pdf');
    }

    /**
     * Lower = preferred for "Download PDF" when multiple bitstreams match {@see isPdf()}.
     */
    public static function pdfDownloadPriority(string $metadataValue): int
    {
        $mime = strtolower(trim(self::getMimeType($metadataValue)));
        if (str_contains($mime, 'pdf')) {
            return 0;
        }
        if ($mime === 'application/octet-stream' || $mime === '') {
            return 1;
        }

        return 2;
    }

    /**
     * @param  list<string>  $metadataValues
     * @return list<string>
     */
    public static function orderPdfBitstreamsForDownload(array $metadataValues): array
    {
        $pdfs = array_values(array_filter(
            $metadataValues,
            static fn (string $b): bool => self::isPdf($b)
        ));

        usort($pdfs, function (string $a, string $b): int {
            $prio = self::pdfDownloadPriority($a) <=> self::pdfDownloadPriority($b);
            if ($prio !== 0) {
                return $prio;
            }

            return (int) self::getSequence($a) <=> (int) self::getSequence($b);
        });

        return $pdfs;
    }

    /**
     * Check if bitstream is audio
     */
    public static function isAudio(string $metadataValue): bool
    {
        $filename = self::getFilename($metadataValue);

        return str_contains(strtolower($filename), '.mp3');
    }

    /**
     * Check if bitstream is video
     */
    public static function isVideo(string $metadataValue): bool
    {
        $filename = self::getFilename($metadataValue);
        $lower = strtolower($filename);

        return str_contains($lower, '.mp4') || str_contains($lower, '.webm');
    }
}
