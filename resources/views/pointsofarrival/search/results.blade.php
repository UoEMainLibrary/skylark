@extends('layouts.pointsofarrival')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" — Points Of Arrival
    @else
        Search Results — Points Of Arrival
    @endif
@endsection

@section('content')
    @php
        $fieldMappings = config('skylight.field_mappings', []);
        $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
        $makerField = str_replace('.', '', $fieldMappings['Maker'] ?? '');
        $dateField = str_replace('.', '', $fieldMappings['Date Made'] ?? '');
        $accField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
        $imageUriField = str_replace('.', '', $fieldMappings['ImageURI'] ?? '');
    @endphp

    {{-- Mirror the legacy pointsofarrival layout: the entire results column +
         facet sidebar live inside .container-fluid.content, which provides
         the white #fff page background that distinguishes search/static
         pages from the home tile grid. --}}
    <div class="container-fluid content">
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 inst-results">
        <div class="container-fluid">
            <div class="searchFoundRow">
                <span class="searchFound" title="Number of items found related to your search">
                    {{ number_format($total) }} items found
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
                                            // The legacy theme picks /180, for landscapes and /,220 for
                                            // portraits after sniffing each thumbnail's aspect ratio
                                            // (one extra HTTP per row). IIIF's "!w,h" size constraint
                                            // gives the same visual cap in a single request.
                                            $thumbnailUri = str_replace('full/full', 'full/!180,220', $uri);
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            <div class="column">
                                <div class="thumbnail-cont">
                                    <a href="{{ url('/pointsofarrival/record/' . $docId) }}" title="View {{ $title }}">
                                        @if($thumbnailUri)
                                            <img class="img-responsive record-thumbnail-search" src="{{ $thumbnailUri }}" title="Read more about the {{ $title }}" loading="lazy" alt="{{ $title }}" />
                                        @else
                                            <img class="img-responsive record-thumbnail-search" src="{{ asset('collections/pointsofarrival/images/comingsoon.gif') }}" title="Read more about the {{ $title }}" alt="{{ $title }}" />
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
                    <p>Try broadening your search or <a href="{{ url('/pointsofarrival/search/*:*') }}">browse all items</a>.</p>
                </div>
            @endif
        </div>
    </div>

    @include('pointsofarrival.search.partials.facets')
    </div>{{-- end of .container-fluid.content --}}

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
