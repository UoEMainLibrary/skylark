@extends('layouts.public-art-v2')

@section('title', $recordTitle . ' | Art on Campus')

@push('styles')
<style>
    /* Pale grey-out for embedded map */
    #record-map img,
    #record-map .ol-layer canvas {
        filter: grayscale(0.55) saturate(0.7) brightness(1.02);
    }
</style>
@endpush

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['Image URI'] ?? '');
    $locationField = str_replace('.', '', $fieldMappings['Map Reference'] ?? '');
    $locationNameField = str_replace('.', '', $fieldMappings['Location'] ?? '');
    $artistField = str_replace('.', '', $fieldMappings['Artist'] ?? '');

    $imageUris = $record[$imageUriField] ?? [];
    if (! is_array($imageUris)) {
        $imageUris = [$imageUris];
    }

    $images = [];
    $primaryImageUrl = '';

    foreach ($imageUris as $i => $uri) {
        $uri = str_replace('http://', 'https://', $uri);
        $display = str_replace('/full/full/', '/full/,1200/', $uri);
        $images[] = ['display' => $display, 'full' => $uri];
        if ($i === 0) {
            $primaryImageUrl = $display;
        }
    }

    // Map coords
    $mapLat = null;
    $mapLon = null;
    if (! empty($record[$locationField][0])) {
        $parts = explode(',', $record[$locationField][0]);
        if (count($parts) === 2) {
            $mapLat = trim($parts[0]);
            $mapLon = trim($parts[1]);
        }
    }

    $locationName = $record[$locationNameField][0] ?? null;
    $artistName = $record[$artistField][0] ?? null;

    // Optional Mediahopper embed lookup by artwork title (case-insensitive).
    // Currently only Ideas (Katie Paterson) has a confirmed embed.
    $videoEmbeds = config('skylight.public_art_videos', [
        'ideas' => '1_lh3jbplo',
    ]);
    $videoKey = strtolower(trim(strip_tags($recordTitle)));
    $videoId = $videoEmbeds[$videoKey] ?? null;
@endphp

{{-- Breadcrumb / back nav --}}
<nav class="mb-6 text-sm" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-2 text-pa-ink-500">
        <li><a href="{{ url('/public-art') }}" class="hover:text-pa-ink-900">Art on Campus</a></li>
        <li aria-hidden="true">&rsaquo;</li>
        <li><a href="{{ url('/public-art/search/*:*') }}" class="hover:text-pa-ink-900">Browse</a></li>
        <li aria-hidden="true">&rsaquo;</li>
        <li class="text-pa-ink-800" aria-current="page">{{ $recordTitle }}</li>
    </ol>
</nav>

<div class="grid gap-10 lg:grid-cols-12">
    {{-- Main column: image + info, single scroll --}}
    <article class="lg:col-span-8">
        {{-- Hero image (plain bg) --}}
        @if(! empty($images))
            <figure class="overflow-hidden rounded border border-pa-ink-100 bg-white">
                <div class="flex aspect-[4/3] items-center justify-center bg-white p-4">
                    <img src="{{ $primaryImageUrl }}"
                         alt="{{ $recordTitle }}"
                         class="max-h-full max-w-full object-contain">
                </div>
            </figure>

            @if(count($images) > 1)
                <ul role="list" class="mt-4 grid grid-cols-4 gap-3 sm:grid-cols-6">
                    @foreach($images as $img)
                        <li>
                            <a href="{{ $img['full'] }}" target="_blank" rel="noopener" class="block overflow-hidden rounded border border-pa-ink-100 hover:border-pa-ink-400">
                                <img src="{{ str_replace('/full/full/', '/full/200,/', $img['full']) }}"
                                     alt=""
                                     loading="lazy"
                                     class="aspect-square w-full object-contain p-1">
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif

        {{-- Title & artist --}}
        <header class="mt-8">
            @if($artistName)
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-pa-ink-400">{{ $artistName }}</p>
            @endif
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-pa-ink-900 sm:text-4xl">{{ $recordTitle }}</h1>
        </header>

        {{-- Optional video embed for featured artworks (Ideas, etc.) --}}
        @if($videoId)
            <section class="mt-8" aria-labelledby="video-heading">
                <h2 id="video-heading" class="sr-only">Video about {{ $recordTitle }}</h2>
                <div class="aspect-video w-full overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
                    <iframe src="https://media.ed.ac.uk/embed/secure/iframe/entryId/{{ $videoId }}/showInfo/false/showTitle/false/embedPlaceholder/true"
                            title="Video about {{ $recordTitle }}"
                            allow="autoplay *; fullscreen *; encrypted-media *"
                            allowfullscreen
                            frameborder="0"
                            class="h-full w-full"></iframe>
                </div>
            </section>
        @endif

        {{-- Description / metadata, all on one scroll --}}
        <section class="mt-10" aria-label="About this artwork">
            <dl class="divide-y divide-pa-ink-100 border-t border-pa-ink-100">
                @foreach($recordDisplay as $key)
                    @php
                        $field = str_replace('.', '', $fieldMappings[$key] ?? '');
                        $value = $record[$field][0] ?? null;
                    @endphp
                    @if($value !== null && $value !== '' && $key !== 'Title')
                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-4 sm:gap-6">
                            <dt class="text-sm font-medium uppercase tracking-wider text-pa-ink-500">{{ $key }}</dt>
                            <dd class="prose prose-sm max-w-none text-pa-ink-800 sm:col-span-3">
                                {!! $value !!}
                            </dd>
                        </div>
                    @endif
                @endforeach
            </dl>
        </section>

        <div class="mt-10 flex flex-wrap gap-3">
            <a href="{{ url('/public-art/search/*:*') }}"
               class="inline-flex items-center gap-2 rounded border border-pa-ink-300 px-4 py-2 text-sm font-medium text-pa-ink-700 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900">
                <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                Back to all artworks
            </a>
            <a href="{{ url('/public-art/search/*:*/?map=true') }}"
               class="inline-flex items-center gap-2 rounded border border-pa-ink-300 px-4 py-2 text-sm font-medium text-pa-ink-700 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900">
                <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m-.75-9.75-3.75-2.25-4.5 2.25-4.5-1.5v15.75l4.5 1.5 4.5-2.25 4.5 2.25 4.5-1.5V5.25l-4.5 1.5Z" /></svg>
                View map of all artworks
            </a>
        </div>
    </article>

    {{-- Sidebar: location & map --}}
    <aside class="lg:col-span-4" aria-labelledby="location-heading">
        <div class="sticky top-6 space-y-6">
            <div class="rounded border border-pa-ink-100 bg-white p-5">
                <h2 id="location-heading" class="text-sm font-semibold uppercase tracking-[0.2em] text-pa-ink-700">Location</h2>

                @if($locationName)
                    <p class="mt-3 text-base text-pa-ink-800">{{ $locationName }}</p>
                @else
                    <p class="mt-3 text-sm text-pa-ink-500">Location details are not available for this artwork.</p>
                @endif

                @if($mapLat !== null && $mapLon !== null)
                    <div id="record-map" class="mt-4 h-64 w-full overflow-hidden rounded bg-pa-ink-50"></div>

                    <ul class="mt-4 space-y-1 text-sm">
                        <li>
                            <a href="https://www.openstreetmap.org/?mlat={{ $mapLat }}&amp;mlon={{ $mapLon }}#map=18/{{ $mapLat }}/{{ $mapLon }}"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 text-pa-accent hover:underline">
                                Open in OpenStreetMap
                                <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.google.com/maps/search/?api=1&amp;query={{ $mapLat }},{{ $mapLon }}"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 text-pa-accent hover:underline">
                                Open in Google Maps
                                <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                        </li>
                    </ul>
                @endif
            </div>

            @if(! empty($images) && count($images) === 1)
                <div class="rounded border border-pa-ink-100 bg-white p-5">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-pa-ink-700">Image</h2>
                    <a href="{{ $images[0]['full'] }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-1 text-sm text-pa-accent hover:underline">
                        View full image
                        <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                </div>
            @endif
        </div>
    </aside>
</div>

@push('scripts')
@if($mapLat !== null && $mapLon !== null)
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" type="text/css">
    <script>
        window.lon = {{ $mapLon }};
        window.lat = {{ $mapLat }};
    </script>
    <script>
        // Move existing #map div ID expectation to #record-map
        // The legacy bundle expects a #map div; alias it.
        (function () {
            var legacy = document.getElementById('record-map');
            if (legacy && !document.getElementById('map')) {
                legacy.id = 'map';
                legacy.dataset.recordMap = 'true';
            }
        })();
    </script>
    <script src="{{ asset('collections/public-art/map/bundle.js') }}"></script>
@endif
@endpush
@endsection
