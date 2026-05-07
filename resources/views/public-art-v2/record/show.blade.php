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

    // Site-wide V2 label rename (Format -> Media, Format Extent -> Dimensions).
    // Per-artwork content (artist, dates, description, etc.) is managed upstream
    // in DSpace and is rendered straight from the Solr record.
    $labelMap = \App\Support\PublicArtOverrides::labels();

    $imageUris = $record[$imageUriField] ?? [];
    if (! is_array($imageUris)) {
        $imageUris = [$imageUris];
    }

    /**
     * Luna's IIIF endpoint rejects any size larger than the source image, and
     * source dimensions in this collection vary widely (smallest seen is
     * 480x640, largest 7360x4912). '!600,600' is the largest best-fit
     * constraint that stays within every known source image, so we use it for
     * the hero. The zoom dialog requests '/full/full/' (source resolution) -
     * the only universally safe choice - and only loads when the user opens
     * it. Thumbnails use '200,' (width 200) which is safely below all sources.
     */
    $images = [];
    $primaryImageUrl = '';

    foreach ($imageUris as $i => $uri) {
        $uri = str_replace('http://', 'https://', $uri);
        $display = str_replace('/full/full/', '/full/!600,600/', $uri);
        $thumb = str_replace('/full/full/', '/full/200,/', $uri);
        $images[] = [
            'display' => $display,
            'thumb' => $thumb,
            'zoom' => $uri,
            'full' => $uri,
        ];
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
    <ol class="flex flex-wrap items-center gap-2 text-pa-ink-700">
        <li><a href="{{ url('/art-on-campus') }}" class="underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-ink-900 hover:decoration-pa-accent">Art on Campus</a></li>
        <li aria-hidden="true">&rsaquo;</li>
        <li><a href="{{ url('/art-on-campus/search/*:*') }}" class="underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-ink-900 hover:decoration-pa-accent">Browse</a></li>
        <li aria-hidden="true">&rsaquo;</li>
        <li class="text-pa-ink-900" aria-current="page">{{ $recordTitle }}</li>
    </ol>
</nav>

<div class="grid gap-10 lg:grid-cols-12">
    {{-- Main column: image + info, single scroll --}}
    <article class="lg:col-span-8">
        {{-- Image gallery --}}
        @if(! empty($images))
            <div data-image-gallery>
                <figure class="overflow-hidden rounded border border-pa-ink-100 bg-white">
                    <div class="flex aspect-[4/3] items-center justify-center bg-white p-4">
                        <img data-hero
                             src="{{ $primaryImageUrl }}"
                             data-display="{{ $primaryImageUrl }}"
                             data-zoom="{{ $images[0]['zoom'] }}"
                             alt="{{ $recordTitle }}"
                             class="max-h-full max-w-full object-contain">
                    </div>
                    <figcaption class="flex flex-wrap items-center justify-between gap-2 border-t border-pa-ink-100 bg-pa-ink-50 px-4 py-2">
                        <span class="text-xs text-pa-ink-700">
                            <span data-hero-counter>
                                @if(count($images) > 1)
                                    Image 1 of {{ count($images) }}
                                @else
                                    Image
                                @endif
                            </span>
                        </span>
                        {{--
                            Progressive enhancement: with JS this opens the inline <dialog>;
                            without JS the link follows target="_blank" to the source image.
                            The sr-only suffix accurately describes both behaviours.
                        --}}
                        <a href="{{ $images[0]['zoom'] }}"
                           target="_blank"
                           rel="noopener"
                           data-zoom-trigger
                           class="inline-flex items-center gap-1.5 rounded text-sm font-medium text-pa-ink-800 underline underline-offset-2 decoration-pa-ink-300 hover:text-pa-accent hover:decoration-pa-accent focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2">
                            <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                            </svg>
                            <span>View larger image<span class="sr-only"> (opens in a dialog, or a new tab if JavaScript is disabled)</span></span>
                        </a>
                    </figcaption>
                </figure>

                @if(count($images) > 1)
                    <p data-hero-status class="sr-only" aria-live="polite"></p>
                    <ul role="list" class="mt-4 grid grid-cols-4 gap-3 sm:grid-cols-6">
                        @foreach($images as $i => $img)
                            <li>
                                <button type="button"
                                        data-thumb
                                        data-index="{{ $i }}"
                                        data-display="{{ $img['display'] }}"
                                        data-zoom="{{ $img['zoom'] }}"
                                        @if($i === 0) aria-pressed="true" @else aria-pressed="false" @endif
                                        aria-label="Show image {{ $i + 1 }} of {{ count($images) }}"
                                        class="group block w-full overflow-hidden rounded border border-pa-ink-100 bg-white transition-colors hover:border-pa-ink-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2 aria-pressed:border-pa-accent aria-pressed:ring-2 aria-pressed:ring-pa-accent">
                                    <img src="{{ $img['thumb'] }}"
                                         alt=""
                                         loading="lazy"
                                         class="aspect-square w-full object-contain p-1">
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        {{-- Title & artist --}}
        <header class="mt-8">
            @if($artistName)
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-pa-ink-700">{{ $artistName }}</p>
            @endif
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-pa-ink-900 sm:text-4xl">{{ $recordTitle }}</h1>
        </header>

        {{-- Optional video embed for featured artworks (Ideas, etc.) --}}
        @if($videoId)
            <section class="mt-8" aria-labelledby="video-heading">
                <h2 id="video-heading" class="sr-only">Video about {{ $recordTitle }}</h2>
                <div class="aspect-video w-full overflow-hidden rounded border border-pa-ink-100 bg-pa-ink-50">
                    <iframe src="https://media.ed.ac.uk/embed/secure/iframe/entryId/{{ $videoId }}/showInfo/false/showTitle/false/embedPlaceholder/true"
                            title="Video about {{ $recordTitle }} (Media Hopper)"
                            allow="autoplay *; fullscreen *; encrypted-media *"
                            loading="lazy"
                            frameborder="0"
                            class="h-full w-full"></iframe>
                </div>
                <p class="mt-2 text-sm text-pa-ink-700">
                    Captions are available within the video player. The
                    @include('public-art-v2.partials.external-link', [
                        'href' => 'https://media.ed.ac.uk/media/'.$videoId,
                        'label' => 'full-page version of this video',
                        'class' => 'text-pa-accent',
                    ])
                    on Media Hopper offers transcript and download links where provided by the publisher.
                </p>
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
                        @php
                            // Override descriptions arrive as plain text with \n\n between
                            // paragraphs; upstream Solr values are single-line strings that
                            // may contain inline HTML, so we only rebuild paragraphs when
                            // the value actually contains a paragraph break.
                            $paragraphs = preg_split('/\R\R+/', trim((string) $value)) ?: [];
                        @endphp
                        <div class="grid grid-cols-1 gap-2 py-4 sm:grid-cols-4 sm:gap-6">
                            <dt class="text-sm font-medium uppercase tracking-wider text-pa-ink-700">{{ $labelMap[$key] ?? $key }}</dt>
                            <dd class="prose prose-sm max-w-none text-pa-ink-800 sm:col-span-3">
                                @if(count($paragraphs) > 1)
                                    @foreach($paragraphs as $para)
                                        <p>{!! nl2br(e($para)) !!}</p>
                                    @endforeach
                                @else
                                    {!! $value !!}
                                @endif
                            </dd>
                        </div>
                    @endif
                @endforeach
            </dl>
        </section>

        <div class="mt-10 flex flex-wrap gap-3">
            <a href="{{ url('/art-on-campus/search/*:*') }}"
               class="inline-flex items-center gap-2 rounded border border-pa-ink-400 px-4 py-2 text-sm font-medium text-pa-ink-800 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2">
                <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                Back to all artworks
            </a>
            <a href="{{ url('/art-on-campus/search/*:*/?map=true') }}"
               class="inline-flex items-center gap-2 rounded border border-pa-ink-400 px-4 py-2 text-sm font-medium text-pa-ink-800 transition-colors hover:border-pa-ink-800 hover:text-pa-ink-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-ink-800 focus-visible:ring-offset-2">
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
                    <p class="mt-3 text-base text-pa-ink-900">{{ $locationName }}</p>
                @else
                    <p class="mt-3 text-sm text-pa-ink-700">Location details are not available for this artwork.</p>
                @endif

                @if($mapLat !== null && $mapLon !== null)
                    {{-- Skip map (WCAG 2.4.1 / 2.1.1 — keyboard users escape map keyboard handlers) --}}
                    <a href="#location-after-map"
                       class="sr-only focus:not-sr-only focus:mt-3 focus:inline-block focus:rounded focus:bg-pa-ink-800 focus:px-3 focus:py-1.5 focus:text-sm focus:text-white focus:outline-none">
                        Skip interactive map
                    </a>

                    <div id="record-map"
                         role="region"
                         aria-label="Interactive map showing the location of {{ $recordTitle }}"
                         class="mt-4 h-64 w-full overflow-hidden rounded bg-pa-ink-50"></div>

                    <p class="mt-2 text-xs text-pa-ink-700">
                        Approximate coordinates: <span class="font-mono">{{ $mapLat }}, {{ $mapLon }}</span>.
                    </p>

                    <ul id="location-after-map" class="mt-4 space-y-1 text-sm">
                        <li>
                            <a href="https://www.openstreetmap.org/?mlat={{ $mapLat }}&amp;mlon={{ $mapLon }}#map=18/{{ $mapLat }}/{{ $mapLon }}"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 text-pa-accent underline underline-offset-2 hover:decoration-2">
                                Open in OpenStreetMap<span class="sr-only"> (opens in a new tab)</span>
                                <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.google.com/maps/search/?api=1&amp;query={{ $mapLat }},{{ $mapLon }}"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1 text-pa-accent underline underline-offset-2 hover:decoration-2">
                                Open in Google Maps<span class="sr-only"> (opens in a new tab)</span>
                                <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            </a>
                        </li>
                    </ul>
                @endif
            </div>

            @if(! empty($images) && count($images) === 1)
                <div class="rounded border border-pa-ink-100 bg-white p-5">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-pa-ink-700">Image</h2>
                    <a href="{{ $images[0]['full'] }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-1 text-sm text-pa-accent underline underline-offset-2 hover:decoration-2">
                        View full image<span class="sr-only"> (opens in a new tab)</span>
                        <svg class="h-3.5 w-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    </a>
                </div>
            @endif
        </div>
    </aside>
</div>

@if(! empty($images))
    <dialog id="image-zoom"
            data-zoom-dialog
            aria-labelledby="image-zoom-title"
            class="m-auto max-h-[95vh] max-w-[95vw] overflow-visible rounded border-0 bg-white p-0 shadow-2xl backdrop:bg-pa-ink-900/85">
        <div class="relative">
            <h2 id="image-zoom-title" class="sr-only">Larger view of {{ $recordTitle }}</h2>
            <img data-zoom-image
                 src=""
                 alt="{{ $recordTitle }}"
                 class="block max-h-[95vh] max-w-[95vw] object-contain">
            <button type="button"
                    data-zoom-close
                    class="absolute top-2 right-2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-pa-ink-900 shadow-lg ring-1 ring-pa-ink-200 transition-colors hover:bg-pa-ink-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-pa-accent focus-visible:ring-offset-2"
                    aria-label="Close larger image">
                <svg class="h-5 w-5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </dialog>
@endif

@push('scripts')
@if(! empty($images))
    <script>
        (function () {
            var gallery = document.querySelector('[data-image-gallery]');
            if (! gallery) {
                return;
            }

            var hero = gallery.querySelector('[data-hero]');
            var counter = gallery.querySelector('[data-hero-counter]');
            var status = gallery.querySelector('[data-hero-status]');
            var thumbs = gallery.querySelectorAll('[data-thumb]');
            var trigger = gallery.querySelector('[data-zoom-trigger]');

            thumbs.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var display = btn.getAttribute('data-display');
                    var zoom = btn.getAttribute('data-zoom');
                    var index = parseInt(btn.getAttribute('data-index'), 10) || 0;

                    if (! display || ! hero) {
                        return;
                    }

                    hero.src = display;
                    hero.setAttribute('data-display', display);
                    hero.setAttribute('data-zoom', zoom);

                    thumbs.forEach(function (b) {
                        b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
                    });

                    var label = 'Image ' + (index + 1) + ' of ' + thumbs.length;
                    if (counter) { counter.textContent = label; }
                    if (status) { status.textContent = 'Showing ' + label.toLowerCase() + '.'; }
                    if (trigger) { trigger.setAttribute('href', zoom); }
                });
            });

            var dialog = document.getElementById('image-zoom');
            if (! dialog || typeof dialog.showModal !== 'function') {
                return;
            }

            var dialogImg = dialog.querySelector('[data-zoom-image]');
            var closeBtn = dialog.querySelector('[data-zoom-close]');

            if (trigger && dialogImg) {
                trigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    dialogImg.src = hero.getAttribute('data-zoom') || hero.src;
                    dialog.showModal();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () { dialog.close(); });
            }

            // Close when clicking the backdrop (clicks land on the dialog element itself)
            dialog.addEventListener('click', function (event) {
                if (event.target === dialog) {
                    dialog.close();
                }
            });

            dialog.addEventListener('close', function () {
                if (dialogImg) { dialogImg.src = ''; }
            });
        })();
    </script>
@endif

@if($mapLat !== null && $mapLon !== null)
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" type="text/css">
    <script>
        window.lon = {{ $mapLon }};
        window.lat = {{ $mapLat }};
    </script>
    <script>
        // The legacy OpenLayers bundle expects a #map div; alias #record-map to it.
        (function () {
            var legacy = document.getElementById('record-map');
            if (legacy && ! document.getElementById('map')) {
                legacy.id = 'map';
                legacy.dataset.recordMap = 'true';
            }
        })();
    </script>
    <script src="{{ asset('collections/public-art/map/bundle.js') }}"></script>
@endif
@endpush
@endsection
