<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RefreshMapData extends Command
{
    protected $signature = 'app:refresh-map-data
        {--dry-run : Show what would be done without writing the file}
        {--skip-geocode : Skip geocoding and only update counts/thumbnails}';

    protected $description = 'Refresh the EERC interactive map data from ArchivesSpace';

    protected string $solrBase;

    protected string $solrCore;

    protected string $cacheFile;

    protected string $outputFile;

    public function handle(): int
    {
        $eercConfig = config('collections.eerc', []);

        $this->solrBase = rtrim($eercConfig['solr_base'] ?? '', '/');
        $this->solrCore = $eercConfig['solr_core'] ?? 'solr/archivesspace';
        $this->cacheFile = storage_path('app/map_geocode_cache.json');
        $this->outputFile = public_path('data/eerc_map_locations.json');

        if (empty($this->solrBase)) {
            $this->error('EERC Solr base URL not configured.');

            return self::FAILURE;
        }

        $this->info('Refreshing EERC map data...');

        $geocodeCache = $this->loadGeocodeCache();

        $this->info('Step 1: Fetching all subjects from Solr...');
        $allSubjects = $this->fetchAllSubjects($eercConfig);

        if (empty($allSubjects)) {
            $this->error('No subjects found. Is the Solr server reachable?');

            return self::FAILURE;
        }

        $this->info(sprintf('  Found %d unique subjects.', count($allSubjects)));

        $this->info('Step 2: Identifying geographic subjects via ArchivesSpace API...');
        $geoSubjects = $this->filterGeographicSubjects($allSubjects, $eercConfig);
        $this->info(sprintf('  Found %d geographic subjects.', count($geoSubjects)));

        if (empty($geoSubjects)) {
            $this->warn('No geographic subjects found. Keeping existing map data.');

            return self::SUCCESS;
        }

        $this->info('Step 3: Geocoding place names...');
        $locations = $this->geocodeSubjects($geoSubjects, $geocodeCache);
        $this->info(sprintf('  Geocoded %d locations.', count($locations)));

        $this->info('Step 4: Fetching interview counts and thumbnails...');
        $locations = $this->enrichWithInterviewData($locations, $eercConfig);

        if ($this->option('dry-run')) {
            $this->info('Dry run — not writing file. Sample output:');
            $this->line(json_encode(array_slice($locations, 0, 3), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return self::SUCCESS;
        }

        $this->saveGeocodeCache($geocodeCache);

        $output = [
            'locations' => $locations,
            'generated_at' => now()->toIso8601String(),
        ];

        file_put_contents($this->outputFile, json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->info(sprintf('Written %d locations to %s', count($locations), $this->outputFile));

        return self::SUCCESS;
    }

    /**
     * Fetch all unique subject terms from the EERC resource via Solr faceting.
     *
     * @return array<string, int> Subject name => count
     */
    protected function fetchAllSubjects(array $config): array
    {
        $containerField = $config['container_field'] ?? 'resource';
        $containerIds = $config['container_id'] ?? [];

        $url = "{$this->solrBase}/{$this->solrCore}/select?q=*:*&rows=0&wt=json";
        $url .= '&facet=true&facet.field=subjects&facet.limit=5000&facet.mincount=1';
        $url .= '&fq=-id:*pui';
        $url .= '&fq=types:"archival_object"+types:"resource"';

        foreach ($containerIds as $containerId) {
            $url .= '&fq='.urlencode("{$containerField}:{$containerId}");
        }

        try {
            $response = Http::timeout(30)->get($url);

            if (! $response->successful()) {
                $this->error('Solr query failed: '.$response->status());

                return [];
            }

            $data = $response->json();
            $facetData = $data['facet_counts']['facet_fields']['subjects'] ?? [];

            $subjects = [];
            for ($i = 0; $i < count($facetData); $i += 2) {
                if (isset($facetData[$i + 1])) {
                    $subjects[$facetData[$i]] = $facetData[$i + 1];
                }
            }

            return $subjects;
        } catch (\Exception $e) {
            $this->error('Solr query exception: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Filter subjects to only those with term_type "geographic" by querying Solr subject records.
     *
     * @param  array<string, int>  $allSubjects
     * @return array<int, array{name: string, uri: string, count: int}>
     */
    protected function filterGeographicSubjects(array $allSubjects, array $config): array
    {
        $geoSubjects = [];
        $bar = $this->output->createProgressBar(count($allSubjects));

        foreach ($allSubjects as $subjectName => $count) {
            $bar->advance();

            try {
                $escapedTitle = str_replace('"', '\\"', $subjectName);
                $response = Http::timeout(10)->get(
                    "{$this->solrBase}/{$this->solrCore}/select",
                    [
                        'q' => "title:\"{$escapedTitle}\"",
                        'fq' => 'primary_type:subject',
                        'wt' => 'json',
                        'rows' => 5,
                        'fl' => 'id,title,json',
                    ]
                );

                if (! $response->successful()) {
                    continue;
                }

                $docs = $response->json()['response']['docs'] ?? [];

                foreach ($docs as $doc) {
                    if (($doc['title'] ?? '') !== $subjectName) {
                        continue;
                    }

                    $jsonField = $doc['json'] ?? null;
                    if (! $jsonField) {
                        continue;
                    }

                    $parsed = is_string($jsonField) ? json_decode($jsonField, true) : $jsonField;
                    $terms = $parsed['terms'] ?? [];

                    foreach ($terms as $term) {
                        if (($term['term_type'] ?? '') === 'geographic') {
                            $geoSubjects[] = [
                                'name' => $subjectName,
                                'uri' => $doc['id'] ?? '',
                                'count' => $count,
                            ];
                            break 2;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Failed to check subject '{$subjectName}': ".$e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();

        return $geoSubjects;
    }

    /**
     * Fallback: use the geocode cache to identify known geographic subjects
     * when the ArchivesSpace API is unreachable.
     *
     * @param  array<string, int>  $allSubjects
     * @return array<int, array{name: string, uri: string, count: int}>
     */
    protected function fallbackGeographicFilter(array $allSubjects): array
    {
        $cache = $this->loadGeocodeCache();
        $geoSubjects = [];

        foreach ($allSubjects as $subjectName => $count) {
            if (isset($cache[$subjectName])) {
                $geoSubjects[] = [
                    'name' => $subjectName,
                    'uri' => $cache[$subjectName]['uri'] ?? '',
                    'count' => $count,
                ];
            }
        }

        return $geoSubjects;
    }

    /**
     * Geocode place names, using the cache for previously resolved entries.
     *
     * @param  array<int, array{name: string, uri: string, count: int}>  $geoSubjects
     * @param  array<string, array>  $geocodeCache
     * @return array<int, array>
     */
    protected function geocodeSubjects(array $geoSubjects, array &$geocodeCache): array
    {
        $locations = [];
        $newGeocodes = 0;

        $bar = $this->output->createProgressBar(count($geoSubjects));

        foreach ($geoSubjects as $subject) {
            $bar->advance();
            $name = $subject['name'];

            if (isset($geocodeCache[$name]) && isset($geocodeCache[$name]['latitude'])) {
                $locations[] = [
                    'subject_uri' => $subject['uri'],
                    'name' => $name,
                    'longitude' => $geocodeCache[$name]['longitude'],
                    'latitude' => $geocodeCache[$name]['latitude'],
                    'interview_count' => $subject['count'],
                ];

                continue;
            }

            if ($this->option('skip-geocode')) {
                continue;
            }

            $coords = $this->geocodePlace($name);

            if ($coords) {
                $geocodeCache[$name] = [
                    'uri' => $subject['uri'],
                    'latitude' => $coords['lat'],
                    'longitude' => $coords['lon'],
                ];

                $locations[] = [
                    'subject_uri' => $subject['uri'],
                    'name' => $name,
                    'longitude' => $coords['lon'],
                    'latitude' => $coords['lat'],
                    'interview_count' => $subject['count'],
                ];

                $newGeocodes++;
                sleep(1); // Nominatim requires 1s between requests
            } else {
                $this->warn("  Could not geocode: {$name}");
            }
        }

        $bar->finish();
        $this->newLine();

        if ($newGeocodes > 0) {
            $this->info("  Geocoded {$newGeocodes} new place names via Nominatim.");
        }

        return $locations;
    }

    /**
     * Geocode a single place name using OpenStreetMap Nominatim.
     *
     * @return array{lat: float, lon: float}|null
     */
    protected function geocodePlace(string $placeName): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'RESP-Archive-Map/1.0 (University of Edinburgh)'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $placeName.', Scotland, UK',
                    'format' => 'json',
                    'limit' => 1,
                    'addressdetails' => 0,
                ]);

            if ($response->successful()) {
                $results = $response->json();

                if (! empty($results)) {
                    return [
                        'lat' => (float) $results[0]['lat'],
                        'lon' => (float) $results[0]['lon'],
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning("Geocoding failed for '{$placeName}': ".$e->getMessage());
        }

        return null;
    }

    /**
     * Enrich locations with representative thumbnail URLs from Solr.
     *
     * @param  array<int, array>  $locations
     * @return array<int, array>
     */
    protected function enrichWithInterviewData(array $locations, array $config): array
    {
        $containerField = $config['container_field'] ?? 'resource';
        $containerIds = $config['container_id'] ?? [];

        $bar = $this->output->createProgressBar(count($locations));

        foreach ($locations as &$location) {
            $bar->advance();

            try {
                $encodedSubject = str_replace(' ', '+', $location['name']);
                $url = "{$this->solrBase}/{$this->solrCore}/select";
                $url .= '?q=*:*&wt=json&rows=5&fl=json,title,digital_object_uris';
                $url .= '&fq=subjects:"'.urlencode($location['name']).'"';
                $url .= '&fq=-id:*pui';
                $url .= '&fq=types:"archival_object"';

                foreach ($containerIds as $containerId) {
                    $url .= '&fq='.urlencode("{$containerField}:{$containerId}");
                }

                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    $location['interview_count'] = $data['response']['numFound'] ?? 0;

                    $thumbnail = $this->findThumbnailInResults($data['response']['docs'] ?? []);
                    if ($thumbnail) {
                        $location['thumbnail_url'] = $thumbnail;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Failed to enrich location '{$location['name']}': ".$e->getMessage());
            }

            usleep(50000); // 50ms between Solr calls
        }

        $bar->finish();
        $this->newLine();

        return $locations;
    }

    /**
     * Scan Solr results for the first available image thumbnail URL.
     */
    protected function findThumbnailInResults(array $docs): ?string
    {
        foreach ($docs as $doc) {
            $digitalObjectUris = $doc['digital_object_uris'] ?? [];

            if (empty($digitalObjectUris)) {
                continue;
            }

            foreach ($digitalObjectUris as $doUri) {
                try {
                    $url = "{$this->solrBase}/{$this->solrCore}/select";
                    $doResponse = Http::timeout(5)->get($url, [
                        'q' => 'id:"'.$doUri.'"',
                        'wt' => 'json',
                        'rows' => 1,
                    ]);

                    if (! $doResponse->successful()) {
                        continue;
                    }

                    $doData = $doResponse->json();
                    $jsonField = $doData['response']['docs'][0]['json'] ?? null;

                    if (! $jsonField) {
                        continue;
                    }

                    $jsonArray = is_array($jsonField) ? $jsonField : [$jsonField];

                    foreach ($jsonArray as $digitalObj) {
                        $digitalObj = is_string($digitalObj) ? json_decode($digitalObj, true) : $digitalObj;

                        if (isset($digitalObj['file_versions'][0])) {
                            $fileName = $digitalObj['title'] ?? '';
                            $fileUrl = $digitalObj['file_versions'][0]['file_uri'] ?? '';

                            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $fileName) && $fileUrl) {
                                return $fileUrl;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * @return array<string, array>
     */
    protected function loadGeocodeCache(): array
    {
        if (! file_exists($this->cacheFile)) {
            return [];
        }

        $data = json_decode(file_get_contents($this->cacheFile), true);

        return is_array($data) ? $data : [];
    }

    /**
     * @param  array<string, array>  $cache
     */
    protected function saveGeocodeCache(array $cache): void
    {
        $dir = dirname($this->cacheFile);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
