<?php

namespace App\Support;

/**
 * Build Nominatim search strings for EERC geographic subject headings.
 *
 * ArchivesSpace place subjects are often long, bilingual, and parenthetical
 * (e.g. "Shawbost (Siabost), Isle of Lewis (Eilean Leòdhais), Scotland").
 * OpenStreetMap works better with simplified variants.
 */
final class EercGeocodeQuery
{
    /**
     * Ordered Nominatim queries to attempt for a geographic subject label.
     *
     * @return array<int, string>
     */
    public static function searchQueries(string $placeName): array
    {
        $placeName = trim($placeName);

        if ($placeName === '') {
            return [];
        }

        $queries = [];

        $append = function (string $candidate) use (&$queries): void {
            $candidate = trim(preg_replace('/\s+/', ' ', $candidate) ?? '');
            $candidate = trim($candidate, " \t\n\r\0\x0B,");

            if ($candidate === '') {
                return;
            }

            $lower = strtolower($candidate);

            if (! str_contains($lower, 'scotland') && ! str_contains($lower, 'uk')) {
                $candidate .= ', Scotland, UK';
            } elseif (str_contains($lower, 'scotland') && ! str_contains($lower, 'uk')) {
                $candidate .= ', UK';
            }

            $queries[] = $candidate;
        };

        $append(str_replace('Ilsle', 'Isle', $placeName));

        $withoutParens = trim(preg_replace('/\s*\([^)]*\)/', '', $placeName) ?? '');
        $withoutParens = preg_replace('/\s+/', ' ', $withoutParens) ?? '';
        $append($withoutParens);

        if (preg_match('/Isle of\s+[^,]+/i', $placeName, $matches) === 1) {
            $append(trim($matches[0]));
        }

        if (preg_match('/Outer Hebrides/i', $placeName) === 1) {
            $append('Outer Hebrides, Scotland');
        }

        if (str_contains($placeName, '--')) {
            foreach (explode('--', $placeName) as $part) {
                $append(trim($part));
            }
        }

        $commaParts = array_values(array_filter(
            array_map(trim(...), explode(',', $withoutParens)),
            fn (string $part): bool => $part !== ''
        ));

        if (count($commaParts) >= 2) {
            $append($commaParts[0].', '.$commaParts[1]);
            $append($commaParts[0]);
        } elseif (count($commaParts) === 1) {
            $append($commaParts[0]);
        }

        return array_values(array_unique($queries));
    }
}
