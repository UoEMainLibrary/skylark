@extends('layouts.stcecilias')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" — St Cecilia's Hall
    @else
        Search Results — St Cecilia's Hall
    @endif
@endsection

@section('body_class', 'search')

@section('content')
    @php
        $fieldMappings = config('skylight.field_mappings', []);
        $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
        $makerField = str_replace('.', '', $fieldMappings['Maker'] ?? '');
        $dateField = str_replace('.', '', $fieldMappings['Date Made'] ?? '');
        $accField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
        $imageUriField = str_replace('.', '', $fieldMappings['ImageURI'] ?? '');
    @endphp

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 inst-results">
        <div class="container-fluid">
            <div class="searchFoundRow">
                <span class="searchFound" title="Number of instruments found related to your search">
                    {{ number_format($total) }} instruments found
                </span>
            </div>

            @if($total > 0)
                <div id="results-container">
                    <div class="results-row">
                        @foreach($docs as $doc)
                            @php
                                $docId = $doc['id'] ?? '';
                                if (is_array($docId)) { $docId = $docId[0] ?? ''; }
                                $title = $doc[$titleField][0] ?? 'Untitled';
                                $maker = $doc[$makerField][0] ?? '';
                                $date = $doc[$dateField][0] ?? '';
                                $accession = $doc[$accField][0] ?? '';

                                $thumbnailUri = null;
                                if (!empty($imageUriField) && !empty($doc[$imageUriField])) {
                                    $candidates = is_array($doc[$imageUriField]) ? $doc[$imageUriField] : [$doc[$imageUriField]];
                                    foreach ($candidates as $uri) {
                                        $uri = str_replace('http://', 'https://', $uri);
                                        if (str_contains($uri, 'luna')) {
                                            // Match the legacy IIIF size hint so thumbnails come back
                                            // sensibly sized rather than full resolution.
                                            $thumbnailUri = str_replace('full/full', 'full/,220', $uri);
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            <div class="column">
                                <div class="thumbnail-cont">
                                    <a href="{{ url('/stcecilias/record/' . $docId) }}" title="View {{ $title }}">
                                        @if($thumbnailUri)
                                            <img class="img-responsive record-thumbnail-search" src="{{ $thumbnailUri }}" title="Read more about the {{ $title }}" loading="lazy" alt="{{ $title }}" />
                                        @else
                                            <img class="img-responsive record-thumbnail-search" src="{{ asset('collections/stcecilia/images/comingsoon.gif') }}" title="Read more about the {{ $title }}" alt="{{ $title }}" />
                                        @endif
                                    </a>
                                    <figcaption>
                                        <span class="searchTitle">{{ $title }}</span><br>
                                        <span class="searchDate">{{ $maker !== '' ? $maker : 'unknown' }}</span><br>
                                        <span class="searchDate">{{ $date !== '' ? $date : 'unknown' }}</span><br>
                                        <span class="searchDate">Accession Number: <strong>{{ $accession !== '' ? $accession : 'unnumbered' }}</strong></span>
                                    </figcaption>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="centered text-center">
                        <nav>
                            <ul class="pagination pagination-sm pagination-xs">
                                {!! $paginationLinks !!}
                            </ul>
                        </nav>
                    </div>
                </div>
            @else
                <div class="row">
                    <h3>No results found</h3>
                    <p>Your search for &ldquo;{{ urldecode($query) }}&rdquo; did not return any results.</p>
                    <p>Try broadening your search or <a href="{{ url('/stcecilias/search/*:*') }}">browse all items</a>.</p>
                </div>
            @endif
        </div>
    </div>

    @include('stcecilias.search.partials.facets')

    @push('scripts')
        <script>
            (function () {
                if (typeof jQuery === 'undefined') { return; }
                var $grid = jQuery('.results-row').masonry({
                    itemSelector: '.column',
                    percentPosition: true
                });
                $grid.imagesLoaded().progress(function () {
                    $grid.masonry('layout');
                });
            })();
        </script>
    @endpush
@endsection
