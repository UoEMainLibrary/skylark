@extends('layouts.mimed-catalogue')

@section('title', 'Search results - Musical Instrument Museums Edinburgh')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}?v=2.1.4">
@endsection

@section('content')
@php
    $isStCeciliasLocation = urldecode($query) === 'dc.coverage.spatialloc:"St Cecilia\'s Hall"';
@endphp
<div class="mimed-search-band">
    <div class="mimed-wrap">
        <h1>{{ isset($searchFields) ? 'Advanced search results' : 'Catalogue search' }}</h1>
        @if($isStCeciliasLocation)
            <p class="mimed-search-scope">Collection location: <strong>St Cecilia’s Hall</strong></p>
        @endif
        @include('mimed.search.partials.form', ['searchbox_query' => $isStCeciliasLocation ? '' : ($searchbox_query ?? '')])
    </div>
</div>

<div class="mimed-wrap mimed-results-layout">
    @if(!empty($facets))
        <aside class="mimed-filters" aria-labelledby="filters-title">
            <h2 id="filters-title">Refine results</h2>
            @include('mimed.search.partials.facets')
        </aside>
    @endif

    <section class="mimed-results" aria-label="Search results">
        @if(isset($searchFields))
            @if(!empty($savedSearch))
                <ul class="mimed-advanced-terms" aria-label="Active search criteria">
                    @foreach($savedSearch as $label => $value)
                        @php
                            $searchPath = parse_url($base_search, PHP_URL_PATH);
                            $segments = explode('/', $searchPath);
                            $remainingSegments = array_filter($segments, function (string $segment) use ($label, $delimiter): bool {
                                return explode($delimiter, urldecode($segment), 2)[0] !== $label;
                            });
                            $removeCriterionUrl = url(implode('/', $remainingSegments)).$base_parameters;
                        @endphp
                        <li>
                            <span><strong>{{ $label }}</strong><span>{{ $value }}</span></span>
                            <a href="{{ $removeCriterionUrl }}" aria-label="Remove {{ $label }} criterion: {{ $value }}" title="Remove {{ $label }} criterion"><span aria-hidden="true">×</span></a>
                        </li>
                    @endforeach
                </ul>
            @endif
            <details class="mimed-advanced-options">
                <summary>Change advanced search options</summary>
                @include('mimed.search.partials.advanced-form')
            </details>
        @endif
        @if($total === 0)
            <div class="mimed-empty">
                <h2>No results found</h2>
                <p>Try broadening your search or <a href="{{ route('mimed.search.index', ['query' => '*:*']) }}">browse all instruments</a>.</p>
            </div>
        @else
            <div class="mimed-result-toolbar">
                <p>Showing <strong>{{ $startRow }}–{{ $endRow }}</strong> of <strong>{{ number_format($total) }}</strong> results</p>
                <details>
                    <summary>Sort results</summary>
                    <div class="mimed-sort-options">
                        @foreach(config('skylight.sort_fields', []) as $label => $field)
                            @php
                                $sortUrl = $base_search.$base_parameters.(str_contains($base_parameters, '?') ? '&' : '?').'sort_by='.urlencode($field);
                            @endphp
                            @if($label === 'Relevancy')
                                <a href="{{ $sortUrl }}+desc">{{ $label }}</a>
                            @else
                                <span>{{ $label }} <a href="{{ $sortUrl }}+asc" aria-label="{{ $label }}, ascending">A–Z</a> · <a href="{{ $sortUrl }}+desc" aria-label="{{ $label }}, descending">Z–A</a></span>
                            @endif
                        @endforeach
                    </div>
                </details>
            </div>

            @php
                $fieldMappings = config('skylight.field_mappings', []);
                $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
                $makerField = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
                $abstractField = str_replace('.', '', $fieldMappings['Abstract'] ?? '');
                $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
            @endphp
            <ul class="mimed-result-list">
                @foreach($docs as $doc)
                    @php
                        $title = Illuminate\Support\Arr::wrap($doc[$titleField] ?? [])[0] ?? 'Untitled';
                        $docId = Illuminate\Support\Arr::wrap($doc['id'] ?? [])[0] ?? '';
                        $abstract = Illuminate\Support\Arr::wrap($doc[$abstractField] ?? [])[0] ?? '';
                        $makers = Illuminate\Support\Arr::wrap($doc[$makerField] ?? []);
                        $imageUri = collect(Illuminate\Support\Arr::wrap($doc[$imageUriField] ?? []))
                            ->first(fn (string $uri): bool => str_contains($uri, 'luna'));
                        $recordUrl = route('mimed.record.show', ['id' => $docId, 'highlight' => $query]);
                    @endphp
                    <li class="mimed-result">
                        <div class="mimed-result-image">
                            @if($imageUri)
                                @php $imageUri = str_replace('http://', 'https://', $imageUri); @endphp
                                <a href="{{ $imageUri }}" class="mimed-photo" data-fancybox-group="catalogue" aria-label="Enlarge image of {{ $title }}">
                                    <img src="{{ str_replace('/full/full/', '/full/!360,360/', $imageUri) }}" alt="" loading="lazy">
                                </a>
                            @endif
                        </div>
                        <div>
                            <h2><a href="{{ $recordUrl }}">{{ $title }}</a></h2>
                            @if($makers)
                                <p class="mimed-result-makers">
                                    @foreach($makers as $maker)
                                        <a href="{{ url('/mimed/search/*:*/Maker:%22'.urlencode(strtolower($maker)).'+%7C%7C%7C+'.urlencode($maker).'%22') }}">{{ str_replace('|', "\u{00A0}", $maker) }}</a>@unless($loop->last) · @endunless
                                    @endforeach
                                </p>
                            @endif
                            @if($abstract)<p>{{ Str::words(str_replace('|', "\u{00A0}", $abstract), 40, '…') }}</p>@endif
                        </div>
                    </li>
                @endforeach
            </ul>
            @if($paginationLinks)
                <nav class="mimed-pagination" aria-label="Search results pages">{!! $paginationLinks !!}</nav>
            @endif
        @endif
    </section>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/fancybox/lib/jquery-1.9.0.min.js') }}"></script>
    <script src="{{ asset('assets/fancybox/source/jquery.fancybox.pack.js') }}?v=2.1.4"></script>
    <script>if (window.jQuery?.fn.fancybox) { jQuery('.mimed-photo').fancybox(); }</script>
@endpush
