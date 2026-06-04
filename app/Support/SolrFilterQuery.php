<?php

namespace App\Support;

/**
 * Helpers for Skylight-style Solr filter query (fq) strings built from URL facets.
 */
final class SolrFilterQuery
{
    /**
     * @param  array<int, string>  $filters
     * @return array<int, string>
     */
    public static function deduplicate(array $filters): array
    {
        return array_values(array_unique($filters));
    }

    /**
     * Reject fq values that Solr cannot parse (e.g. truncated facet URLs).
     */
    public static function isValid(string $filter): bool
    {
        if ($filter === '') {
            return false;
        }

        $colonPos = strpos($filter, ':');

        if ($colonPos === false) {
            return false;
        }

        $value = substr($filter, $colonPos + 1);
        $trimmed = ltrim($value);

        if (! str_starts_with($trimmed, '"')) {
            return true;
        }

        return str_ends_with($trimmed, '"') && strlen($trimmed) >= 2;
    }

    /**
     * @param  array<int, string>  $filters
     * @return array<int, string>
     */
    public static function onlyValid(array $filters): array
    {
        return array_values(array_filter(
            self::deduplicate($filters),
            fn (string $filter): bool => self::isValid($filter)
        ));
    }
}
