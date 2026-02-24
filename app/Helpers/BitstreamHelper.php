<?php

namespace App\Helpers;

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
     * Check if bitstream is an image
     */
    public static function isImage(string $metadataValue): bool
    {
        $filename = self::getFilename($metadataValue);

        return str_contains(strtolower($filename), '.jpg') || str_contains(strtolower($filename), '.jpeg');
    }

    /**
     * Check if bitstream is a PDF
     */
    public static function isPdf(string $metadataValue): bool
    {
        $filename = self::getFilename($metadataValue);

        return str_contains(strtolower($filename), '.pdf');
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
