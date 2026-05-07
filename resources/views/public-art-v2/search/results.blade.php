@extends('layouts.public-art-v2')

@section('title', 'Browse Art on Campus | University of Edinburgh')

@push('styles')
<style>
    .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.25rem;
        height: 2.25rem;
        padding: 0 0.625rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 150ms;
        border: 1px solid var(--color-pa-ink-200);
        color: var(--color-pa-ink-700);
        background-color: white;
    }
    .pagination li a:hover {
        border-color: var(--color-pa-ink-800);
        color: var(--color-pa-ink-900);
    }
    .pagination li.active span {
        background-color: var(--color-pa-ink-800);
        border-color: var(--color-pa-ink-800);
        color: white;
    }
    .pagination li.disabled span {
        color: var(--color-pa-ink-300);
        cursor: not-allowed;
    }

    /* Pale, accessible Leaflet/OpenLayers map look */
    #map img,
    .ol-layer canvas {
        filter: grayscale(0.55) saturate(0.7) brightness(1.02);
    }
</style>
@endpush

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $imageField = str_replace('.', '', $fieldMappings['Image URI'] ?? 'dcidentifierimageUri');
    $altImageField = str_replace('.', '', $fieldMappings['Alt Image'] ?? 'dcimageprimaryen');
    $locationField = str_replace('.', '', $fieldMappings['Map Reference'] ?? 'dccoveragespatialcoorden');
    $artistField = str_replace('.', '', $fieldMappings['Artist'] ?? 'dccontributorauthorfullen');
    $datesField = str_replace('.', '', $fieldMappings['Dates'] ?? 'dccoveragetemporalen');

    $type = request()->boolean('map') ? 'map' : 'images';

    // For the "Browse all artworks" view (*:* / *), reorder docs newest-first
    // using the curated browse_order list. Other queries keep Solr's order.
    if (in_array($query, ['*:*', '*'], true)) {
        $docs = \App\Support\PublicArtOverrides::sortBrowse($docs, $titleField);
    }
@endphp

<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-medium uppercase tracking-[0.2em] text-pa-ink-600">University Art Collection</p>
        <h1 class="mt-1 text-3xl font-semibold tracking-tight text-pa-ink-900 sm:text-4xl">Art on Campus</h1>
        @if($total > 0)
            <p class="mt-2 text-sm text-pa-ink-700">{{ number_format($total) }} {{ \Illuminate\Support\Str::plural('artwork', $total) }} found.</p>
        @endif
    </div>

    {{-- View toggle --}}
    <div class="flex items-center gap-1 rounded border border-pa-ink-200 bg-white p-1 text-sm" role="tablist" aria-label="Result view">
        <a href="{{ request()->fullUrlWithoutQuery('map') }}"
           role="tab"
           aria-selected="{{ $type === 'images' ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 rounded px-3 py-1.5 font-medium {{ $type === 'images' ? 'bg-pa-ink-800 text-white' : 'text-pa-ink-600 hover:text-pa-ink-900' }}">
            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
            <span>Grid</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['map' => 'true']) }}"
           role="tab"
           aria-selected="{{ $type === 'map' ? 'true' : 'false' }}"
           class="inline-flex items-center gap-2 rounded px-3 py-1.5 font-medium {{ $type === 'map' ? 'bg-pa-ink-800 text-white' : 'text-pa-ink-600 hover:text-pa-ink-900' }}">
            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m-.75-9.75-3.75-2.25-4.5 2.25-4.5-1.5v15.75l4.5 1.5 4.5-2.25 4.5 2.25 4.5-1.5V5.25l-4.5 1.5Z" /></svg>
            <span>Map</span>
        </a>
    </div>
</div>

@if(isset($message))
    <div class="mt-6 rounded border border-pa-ink-200 bg-pa-ink-50 px-4 py-3 text-sm text-pa-ink-700" role="status">
        {!! $message !!}
    </div>
@endif

@if($total === 0)
    <div class="mt-10 rounded border border-pa-ink-100 bg-white p-10 text-center">
        <h2 class="text-lg font-medium text-pa-ink-900">No artworks found</h2>
        <p class="mt-2 text-pa-ink-700">Your search for &ldquo;{{ urldecode($query) }}&rdquo; returned no results.</p>
        <p class="mt-4">
            <a href="{{ url('/art-on-campus/search/*:*') }}" class="text-pa-accent underline underline-offset-4">Browse all artworks</a>
        </p>
    </div>
@elseif($type === 'images')
    {{-- Grid: equal-sized square tiles, MIT-listart style --}}
    <ul role="list" class="mt-8 grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach($docs as $doc)
            @php
                $title = $doc[$titleField][0] ?? 'Untitled';
                $rawImg = $doc[$imageField][0] ?? ($doc[$altImageField][0] ?? '');
                $imgUrl = str_replace('/full/full/', '/full/!400,400/', $rawImg);
                $artist = $doc[$artistField][0] ?? '';
                $year = $doc[$datesField][0] ?? null;
                $docId = is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? '');
            @endphp
            <li>
                <a href="{{ url('/art-on-campus/record/' . $docId) }}"
                   class="group block focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2"
                   title="{{ $title }}{{ $year ? ' ' . $year : '' }}">
                    <div class="aspect-square w-full overflow-hidden bg-pa-ink-50">
                        @if($imgUrl)
                            <img src="{{ $imgUrl }}"
                                 alt="{{ $title }}"
                                 loading="lazy"
                                 class="h-full w-full object-contain p-2 transition-transform duration-300 group-hover:scale-[1.03]">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-pa-ink-300">
                                <svg class="h-12 w-12" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h3 class="text-sm font-medium leading-snug text-pa-ink-900 group-hover:text-pa-accent">
                            {{ $title }}@if($year) <span class="font-normal text-pa-ink-700">{{ $year }}</span>@endif
                        </h3>
                        @if($artist)
                            <p class="mt-0.5 text-xs text-pa-ink-700">{{ $artist }}</p>
                        @endif
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    <nav class="mt-12 flex justify-center" aria-label="Pagination">
        <div class="flex gap-1 text-sm">{!! $paginationLinks !!}</div>
    </nav>
@else
    {{-- Map view --}}
    @php
        // Build the textual location list once, in PHP, so we can use it as
        // both the screen-reader / keyboard alternative and the JS marker source.
        $mappedLocations = [];
        foreach ($docs as $doc) {
            $locStr = $doc[$locationField][0] ?? '';
            if ($locStr === '') {
                continue;
            }
            $parts = explode(',', $locStr);
            if (count($parts) !== 2) {
                continue;
            }
            $mappedLocations[] = [
                'title' => $doc[$titleField][0] ?? 'Untitled',
                'lat' => trim($parts[0]),
                'lon' => trim($parts[1]),
                'id' => is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? ''),
                'thumb' => str_replace('/full/full/', '/full/80,/', $doc[$imageField][0] ?? ''),
            ];
        }
    @endphp

    {{-- Skip-map link for keyboard users (the OpenLayers map traps arrow keys) --}}
    <a href="#map-textual-list"
       class="sr-only focus:not-sr-only focus:fixed focus:left-2 focus:top-2 focus:z-50 focus:rounded focus:bg-pa-ink-800 focus:px-3 focus:py-1.5 focus:text-sm focus:text-white focus:outline-none">
        Skip interactive map
    </a>

    <div class="mt-8 overflow-hidden rounded border border-pa-ink-100 bg-white">
        <div id="map"
             role="region"
             aria-label="Interactive map of artworks across the University of Edinburgh campuses. A textual list of the same artworks follows below."
             class="h-[70vh] min-h-[500px] w-full bg-pa-ink-50"></div>
    </div>
    <p class="mt-3 text-xs text-pa-ink-700">Select a marker to view the artwork. Map data &copy; OpenStreetMap contributors.</p>

    {{-- Text alternative to the map (WCAG 1.1.1 / 2.1.1 / 2.4.1) --}}
    <section id="map-textual-list" class="mt-10" aria-labelledby="map-textual-list-heading">
        <h2 id="map-textual-list-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-pa-ink-700">
            Artworks on the map ({{ count($mappedLocations) }})
        </h2>
        <p class="mt-2 text-sm text-pa-ink-700">
            This list mirrors every marker on the map above for keyboard and screen-reader users.
        </p>
        @if(count($mappedLocations) === 0)
            <p class="mt-4 text-sm text-pa-ink-700">No artworks have mapped locations.</p>
        @else
            <ul role="list" class="mt-4 grid gap-x-6 gap-y-2 sm:grid-cols-2 lg:grid-cols-3 text-sm">
                @foreach($mappedLocations as $loc)
                    <li>
                        <a href="{{ url('/art-on-campus/record/'.$loc['id']) }}"
                           class="text-pa-ink-800 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent">
                            {{ $loc['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <script>
        var locationsArray = [
            @foreach($mappedLocations as $loc)
                [{{ $loc['lon'] }}, {{ $loc['lat'] }}, '{{ url('/art-on-campus/record/'.$loc['id']) }}', '{{ addslashes($loc['title']) }}', '{{ $loc['thumb'] }}'],
            @endforeach
        ];
    </script>
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" type="text/css">
    <script src="{{ asset('collections/public-art/locations/bundle.js') }}"></script>
@endif
@endsection
