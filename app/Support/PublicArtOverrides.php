<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Site-wide presentation overrides for the V2 Public Art collection.
 *
 * Per-artwork content (Artist, Dates, Description, etc.) is managed
 * upstream in DSpace; this helper only controls site-wide layout
 * decisions: the recorddisplay label rename and the curated browse-by-date
 * ordering.
 */
final class PublicArtOverrides
{
    /**
     * Normalise a title for case-insensitive lookup against the browse-order list.
     */
    public static function lookupKey(?string $title): string
    {
        if ($title === null) {
            return '';
        }

        return Str::lower(Str::squish(strip_tags($title)));
    }

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return (array) config('public-art-overrides.labels', []);
    }

    /**
     * @return array<int, string>
     */
    public static function browseOrder(): array
    {
        return (array) config('public-art-overrides.browse_order', []);
    }

    /**
     * Sort key for a title in the browse list. Lower values appear first;
     * unknown titles sort to the end.
     */
    public static function browseSortKey(?string $title): int
    {
        $key = self::lookupKey($title);

        if ($key === '') {
            return PHP_INT_MAX;
        }

        foreach (self::browseOrder() as $index => $orderTitle) {
            if (self::lookupKey($orderTitle) === $key) {
                return $index;
            }
        }

        return PHP_INT_MAX;
    }

    /**
     * Sort an array of search docs in browse order (newest first), with
     * unknown titles preserved in their upstream relative order at the end.
     *
     * @param  array<int, array<string, mixed>>  $docs
     * @return array<int, array<string, mixed>>
     */
    public static function sortBrowse(array $docs, string $titleField): array
    {
        $indexed = [];
        foreach ($docs as $i => $doc) {
            $title = $doc[$titleField][0] ?? '';
            $indexed[] = [
                'doc' => $doc,
                'sort' => self::browseSortKey($title),
                'original' => $i,
            ];
        }

        usort($indexed, function (array $a, array $b): int {
            return $a['sort'] <=> $b['sort']
                ?: $a['original'] <=> $b['original'];
        });

        return array_map(fn (array $entry) => $entry['doc'], $indexed);
    }

    /**
     * First human-readable value from a Solr field (string or multi-valued array).
     */
    public static function firstFieldValue(array $record, string $field): ?string
    {
        $raw = $record[$field] ?? null;

        if ($raw === null) {
            return null;
        }

        if (! is_array($raw)) {
            $value = trim((string) $raw);

            return $value !== '' ? $value : null;
        }

        $value = trim((string) ($raw[0] ?? ''));

        return $value !== '' ? $value : null;
    }

    /**
     * Parse the first map coordinate pair from a record (lat, lon).
     *
     * Records may carry multiple coordinates in Solr; the record page and map
     * pin should only ever use the first entry.
     *
     * @return array{lat: string, lon: string}|null
     */
    public static function firstMapCoordinates(array $record, string $locationField): ?array
    {
        $raw = $record[$locationField] ?? [];

        if (! is_array($raw)) {
            $raw = [$raw];
        }

        $first = trim((string) ($raw[0] ?? ''));

        if ($first === '') {
            return null;
        }

        $parts = array_map(trim(...), explode(',', $first, 2));

        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            return null;
        }

        return [
            'lat' => $parts[0],
            'lon' => $parts[1],
        ];
    }
}
