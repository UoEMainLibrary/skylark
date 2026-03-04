<?php

namespace App\Contracts;

interface RepositoryInterface
{
    /**
     * Search the repository with the given parameters
     *
     * @param  string  $query  The search query
     * @param  array  $filters  Additional filters
     * @param  int  $page  Current page number
     * @param  string|null  $sortBy  Sort field and direction
     * @return array Search results with total, records, and facets
     */
    public function search(string $query, array $filters = [], int $page = 1, ?string $sortBy = null): array;

    /**
     * Get a single record by ID
     *
     * @param  string  $id  The record identifier
     * @return array|null Record data or null if not found
     */
    public function getRecord(string $id): ?array;

    /**
     * Get related items for a record
     *
     * @param  array  $record  The record data
     * @param  int  $limit  Maximum number of related items
     * @return array Related items
     */
    public function getRelatedItems(array $record, int $limit = 10): array;

    /**
     * Build facets with active state
     *
     * @param  array  $facetData  Raw facet data from repository
     * @param  array  $activeFilters  Currently active filters
     * @param  array  $configFilters  Filter configuration
     * @return array Processed facets with active states
     */
    public function buildFacetsWithActiveState(array $facetData, array $activeFilters, array $configFilters): array;

    /**
     * Transform field names from repository schema to display names
     *
     * @param  array  $record  Raw record data
     * @return array Record with transformed field names
     */
    public function transformFieldNames(array $record): array;
}
