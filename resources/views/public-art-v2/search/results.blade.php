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

    $type = request()->boolean('map') ? 'map' : 'images';
@endphp

<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-medium uppercase tracking-[0.2em] text-pa-ink-400">University Art Collection</p>
        <h1 class="mt-1 text-3xl font-semibold tracking-tight text-pa-ink-900 sm:text-4xl">Art on Campus</h1>
        @if($total > 0)
            <p class="mt-2 text-sm text-pa-ink-500">{{ number_format($total) }} {{ \Illuminate\Support\Str::plural('artwork', $total) }} found.</p>
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
        <p class="mt-2 text-pa-ink-500">Your search for &ldquo;{{ urldecode($query) }}&rdquo; returned no results.</p>
        <p class="mt-4">
            <a href="{{ url('/public-art/search/*:*') }}" class="text-pa-accent underline-offset-4 hover:underline">Browse all artworks</a>
        </p>
    </div>
@elseif($type === 'images')
    {{-- Grid: equal-sized square tiles, MIT-listart style --}}
    <ul role="list" class="mt-8 grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach($docs as $doc)
            @php
                $title = $doc[$titleField][0] ?? 'Untitled';
                $rawImg = $doc[$imageField][0] ?? ($doc[$altImageField][0] ?? '');
                $imgUrl = str_replace('/full/full/', '/full/,400/', $rawImg);
                $artist = $doc[$artistField][0] ?? '';
                $docId = is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? '');
            @endphp
            <li>
                <a href="{{ url('/public-art/record/' . $docId) }}"
                   class="group block focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2"
                   title="{{ $title }}">
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
                        <h3 class="text-sm font-medium leading-snug text-pa-ink-900 group-hover:text-pa-accent">{{ $title }}</h3>
                        @if($artist)
                            <p class="mt-0.5 text-xs text-pa-ink-500">{{ $artist }}</p>
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
    <div class="mt-8 overflow-hidden rounded border border-pa-ink-100 bg-white">
        <div id="map" class="h-[70vh] min-h-[500px] w-full bg-pa-ink-50"></div>
    </div>
    <p class="mt-3 text-xs text-pa-ink-500">Click a marker to view the artwork. Map data &copy; OpenStreetMap contributors.</p>

    <script>
        var locationsArray = [];
        @foreach($docs as $doc)
            @php
                $title = addslashes($doc[$titleField][0] ?? 'Untitled');
                $locStr = $doc[$locationField][0] ?? '';
                $rawImg = $doc[$imageField][0] ?? '';
                $thumb = str_replace('/full/full/', '/full/80,/', $rawImg);
                $docId = is_array($doc['id'] ?? '') ? ($doc['id'][0] ?? '') : ($doc['id'] ?? '');
            @endphp
            @if($locStr !== '')
                @php $parts = explode(',', $locStr); @endphp
                @if(count($parts) === 2)
                    locationsArray.push([{{ trim($parts[1]) }}, {{ trim($parts[0]) }}, '{{ url('/public-art/record/' . $docId) }}', '{{ $title }}', '{{ $thumb }}']);
                @endif
            @endif
        @endforeach
    </script>
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" type="text/css">
    <script src="{{ asset('collections/public-art/locations/bundle.js') }}"></script>
@endif
@endsection
