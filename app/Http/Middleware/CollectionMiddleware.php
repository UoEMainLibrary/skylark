<?php

namespace App\Http\Middleware;

use App\Support\CollectionUrl;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CollectionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $collection = $this->detectCollection($request);

        // Load the collection-specific configuration
        $this->loadCollectionConfig($collection);

        // Set the current collection in the app config and request
        config(['app.current_collection' => $collection]);
        $request->attributes->set('collection', $collection);

        $host = $request->getHost();
        $domainMap = config('collections.domains', []);
        $atDedicatedHost = isset($domainMap[$host]) && $domainMap[$host] === $collection;

        $pathPrefix = '';
        if (! $atDedicatedHost) {
            $urlPrefix = config('skylight.url_prefix');
            if ($urlPrefix !== null && $urlPrefix !== '') {
                $pathPrefix = '/'.$urlPrefix;
            }
        }

        config([
            'app.collection_path_prefix' => $pathPrefix,
            'app.collection_at_dedicated_host' => $atDedicatedHost,
        ]);

        // Share collection with all views
        view()->share('current_collection', $collection);
        view()->share('collection_at_dedicated_host', $atDedicatedHost);
        view()->share('collectionUrl', static fn (string $path = ''): string => CollectionUrl::url($path));

        return $next($request);
    }

    /**
     * Detect which collection is being accessed based on the URL
     */
    protected function detectCollection(Request $request): string
    {
        $host = $request->getHost();
        $domainMap = config('collections.domains', []);

        if (isset($domainMap[$host])) {
            return $domainMap[$host];
        }

        $detectionMethod = config('collections.detection', 'prefix');

        switch ($detectionMethod) {
            case 'prefix':
                return $this->detectFromPrefix($request);

            case 'subdomain':
                return $this->detectFromSubdomain($request);

            case 'domain':
                return $this->detectFromDomain($request);

            default:
                return config('collections.default', 'clds');
        }
    }

    /**
     * Detect collection from URL prefix (e.g., /eerc/search)
     */
    protected function detectFromPrefix(Request $request): string
    {
        $path = $request->path();
        $firstSegment = explode('/', $path)[0];

        $prefixes = config('collections.prefixes', []);

        // Check if the first segment matches a registered collection prefix
        if (isset($prefixes[$firstSegment])) {
            return $prefixes[$firstSegment];
        }

        // Check if first segment is directly in available collections
        $available = config('collections.available', []);
        if (in_array($firstSegment, $available)) {
            return $firstSegment;
        }

        return config('collections.default', 'clds');
    }

    /**
     * Detect collection from subdomain (e.g., eerc.collections.ed.ac.uk)
     */
    protected function detectFromSubdomain(Request $request): string
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $available = config('collections.available', []);

        if (in_array($subdomain, $available)) {
            return $subdomain;
        }

        return config('collections.default', 'clds');
    }

    /**
     * Detect collection from full domain (e.g., eerc.ed.ac.uk)
     */
    protected function detectFromDomain(Request $request): string
    {
        $host = $request->getHost();

        // Map domains to collections
        $domainMap = config('collections.domains', []);

        if (isset($domainMap[$host])) {
            return $domainMap[$host];
        }

        return config('collections.default', 'clds');
    }

    /**
     * Load collection-specific configuration and merge into 'skylight' config
     */
    protected function loadCollectionConfig(string $collection): void
    {
        $configPath = config_path("collections/{$collection}.php");

        if (! file_exists($configPath)) {
            // Fall back to default collection if config doesn't exist
            $collection = config('collections.default', 'clds');
            $configPath = config_path("collections/{$collection}.php");
        }

        if (file_exists($configPath)) {
            $collectionConfig = require $configPath;

            // Merge collection config into 'skylight' config namespace
            // This allows existing code to access config('skylight.field_mappings') etc.
            config(['skylight' => array_merge(
                config('skylight', []),
                $collectionConfig
            )]);
        }
    }
}
