<?php

namespace App\Console\Commands;

use App\Services\SolrService;
use Illuminate\Console\Command;

class SolrProofOfConcept extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:solr-poc {--query= : Search query to execute (default: *:*)}';

    /**
     * The console command description.
     */
    protected $description = 'Proof-of-concept demonstrating Solr integration with search, facets, and record retrieval';

    /**
     * Execute the console command.
     */
    public function handle(SolrService $solr): int
    {
        $query = $this->option('query') ?: '*:*';

        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║           Solr Proof-of-Concept Demonstration               ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        try {
            // 1. Simple Search
            $this->demonstrateSimpleSearch($solr, $query);
            $this->newLine(2);

            // 2. Faceted Search
            $this->demonstrateFacetedSearch($solr, $query);
            $this->newLine(2);

            // 3. Single Record Retrieval
            $this->demonstrateSingleRecordRetrieval($solr, $query);

            $this->newLine();
            $this->info('✓ All demonstrations completed successfully!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: '.$e->getMessage());
            $this->newLine();
            $this->line('Stack trace:');
            $this->line($e->getTraceAsString());

            return Command::FAILURE;
        }
    }

    /**
     * Demonstrate simple search functionality
     */
    protected function demonstrateSimpleSearch(SolrService $solr, string $query): void
    {
        $this->info('━━━ 1. Simple Search ━━━');
        $this->line("Query: {$query}");
        $this->newLine();

        $results = $solr->search($query, [], ['rows' => 5]);

        $this->line("Total results found: <fg=green;options=bold>{$results['total']}</>");
        $this->line("Showing first {$results['rows']} results:");
        $this->newLine();

        if (empty($results['docs'])) {
            $this->warn('No results found.');

            return;
        }

        $tableData = [];
        foreach ($results['docs'] as $index => $doc) {
            $tableData[] = [
                'No.' => $index + 1,
                'ID' => $this->getFieldValue($doc, ['id', 'handle']),
                'Title' => $this->truncate($this->getFieldValue($doc, ['dc.title.en', 'dctitleen', 'title']), 40),
                'Author' => $this->truncate($this->getFieldValue($doc, ['dc.contributor.author', 'dccontributorauthor', 'author']), 30),
                'Date' => $this->getFieldValue($doc, ['dc.date.issued', 'dcdateissued', 'date']),
            ];
        }

        $this->table(
            ['No.', 'ID', 'Title', 'Author', 'Date'],
            $tableData
        );
    }

    /**
     * Demonstrate faceted search functionality
     */
    protected function demonstrateFacetedSearch(SolrService $solr, string $query): void
    {
        $this->info('━━━ 2. Faceted Search ━━━');
        $this->line("Query: {$query}");
        $this->newLine();

        $results = $solr->searchWithFacets($query);

        $this->line("Total results: <fg=green;options=bold>{$results['total']}</>");
        $this->newLine();

        if (empty($results['facets'])) {
            $this->warn('No facets available.');

            return;
        }

        foreach ($results['facets'] as $facetName => $facetData) {
            $this->line("<fg=cyan;options=bold>Facet: {$facetName}</>");

            if (empty($facetData)) {
                $this->line('  (no values)');
                $this->newLine();

                continue;
            }

            $tableData = [];
            $count = 0;
            foreach ($facetData as $term) {
                if ($count >= 5) {
                    break;
                }
                $tableData[] = [
                    'Value' => $this->truncate($term['value'], 50),
                    'Count' => $term['count'],
                ];
                $count++;
            }

            $this->table(['Value', 'Count'], $tableData);
            $this->newLine();
        }
    }

    /**
     * Demonstrate single record retrieval
     */
    protected function demonstrateSingleRecordRetrieval(SolrService $solr, string $query): void
    {
        $this->info('━━━ 3. Single Record Retrieval ━━━');
        $this->newLine();

        // First, get a record ID from the search results
        $results = $solr->search($query, [], ['rows' => 1]);

        if (empty($results['docs'])) {
            $this->warn('No records available to retrieve.');

            return;
        }

        $firstDoc = $results['docs'][0];
        $recordId = $this->getFieldValue($firstDoc, ['handle', 'id']);

        $this->line("Retrieving record: <fg=yellow>{$recordId}</>");
        $this->newLine();

        $record = $solr->getRecord($recordId);

        if (! $record) {
            $this->error("Could not retrieve record: {$recordId}");

            return;
        }

        // Display key fields
        $this->line('<fg=cyan;options=bold>Key Fields:</>');
        $keyFields = [
            'ID' => $this->getFieldValue($record, ['id', 'handle']),
            'Title' => $this->getFieldValue($record, ['dc.title.en', 'dctitleen', 'title']),
            'Author' => $this->getFieldValue($record, ['dc.contributor.author', 'dccontributorauthor', 'author']),
            'Subject' => $this->getFieldValue($record, ['dc.subject.en', 'dcsubjecten', 'subject']),
            'Type' => $this->getFieldValue($record, ['dc.type.en', 'dctypeen', 'type']),
            'Date' => $this->getFieldValue($record, ['dc.date.issued', 'dcdateissued', 'date']),
        ];

        foreach ($keyFields as $label => $value) {
            if ($value) {
                $displayValue = is_array($value) ? implode(', ', array_slice($value, 0, 3)) : $value;
                $this->line("  <fg=green>{$label}:</> {$this->truncate($displayValue, 80)}");
            }
        }

        $this->newLine();
        $this->line('<fg=cyan;options=bold>All Available Fields:</>');
        $this->line('Total fields: <fg=yellow>'.count($record).'</>');

        // Show a sample of all fields
        $fieldList = array_keys($record);
        $sampleFields = array_slice($fieldList, 0, 10);
        foreach ($sampleFields as $field) {
            $this->line("  • {$field}");
        }

        if (count($fieldList) > 10) {
            $remaining = count($fieldList) - 10;
            $this->line("  ... and {$remaining} more fields");
        }
    }

    /**
     * Get field value from document, trying multiple possible field names
     */
    protected function getFieldValue(array $doc, array $possibleFields): mixed
    {
        foreach ($possibleFields as $field) {
            if (isset($doc[$field])) {
                $value = $doc[$field];

                // If it's an array with one element, return that element
                if (is_array($value) && count($value) === 1) {
                    return $value[0];
                }

                return $value;
            }
        }

        return null;
    }

    /**
     * Truncate a string to a maximum length
     */
    protected function truncate(mixed $value, int $length): string
    {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }

        if (! is_string($value)) {
            $value = (string) $value;
        }

        if (strlen($value) <= $length) {
            return $value;
        }

        return substr($value, 0, $length - 3).'...';
    }
}
