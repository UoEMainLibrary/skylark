@extends('layouts.speccoll')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}"
    @else
        Search Results
    @endif
@endsection

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $shelfmarkField = str_replace('.', '', $fieldMappings['Shelfmark'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['ImageURI'] ?? '');
    $imagesField = str_replace('.', '', $fieldMappings['Images'] ?? '');
    $bitstreamField = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
    $thumbnailField = str_replace('.', '', $fieldMappings['Thumbnail'] ?? '');

    $cleanBaseParameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters ?? '');
    $sortSep = $cleanBaseParameters === '' ? '?sort_by=' : '&sort_by=';

    $facetLimit = (int) config('skylight.facet_limit', 30);
@endphp

<div class="container-fluid content">
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="container-fluid">
            @if(isset($message))
                <div class="message">{!! $message !!}</div>
            @endif

            @if($total === 0)
                <div class="searchFoundRow">
                    <span class="searchFound">No results found</span>
                </div>
                <p>Your search for <strong>{{ urldecode($query) }}</strong> did not return any results.</p>
            @else
                <div class="searchFoundRow">
                    <span class="searchFound">{{ number_format($total) }} volumes found </span>
                </div>

                <div id="results-grid" class="grid">
                    <div class="grid-sizer col-xs-3"></div>

                    @foreach($docs as $index => $doc)
                        @php
                            $docId = $doc['id'] ?? '';
                            if (is_array($docId)) {
                                $docId = $docId[0] ?? '';
                            }

                            $title = $doc[$titleField][0] ?? ($doc[$titleField] ?? 'Untitled');
                            $author = $doc[$authorField][0] ?? null;
                            $shelfmark = $doc[$shelfmarkField][0] ?? '';
                            $imagesCount = $doc[$imagesField][0] ?? 0;
                            $plural = ((int) $imagesCount) > 1 ? 's' : '';

                            $thumbnailSrc = asset('collections/speccoll/images/comingsoon1.gif');
                            if ($imageUriField && ! empty($doc[$imageUriField][0])) {
                                $linkUri = $doc[$imageUriField][0];
                                $linkUri = str_replace('full/full', '1000,1000,300,300/300,300', $linkUri);
                                if (strpos($linkUri, 'luna') !== false) {
                                    $thumbnailSrc = $linkUri;
                                }
                            }
                        @endphp

                        <div class="grid-item col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <a href="./record/{{ $docId }}" title="{{ $title }}">
                                <div class="grid-item-container">
                                    <div class="grid-item-content box">
                                        <img class="img-responsive record-thumbnail-search" src="{{ $thumbnailSrc }}" title="{{ $title }}" alt="{{ $title }}" />
                                        <figcaption>
                                            <span class="searchTitle">{{ mb_substr($title, 0, 20) }}</span><br>
                                            <span class="searchDate">{{ $author ? mb_substr($author, 0, 20) : 'unknown' }}</span><br>
                                            <span class="searchDate">{{ $imagesCount }} digitised image{{ $plural }}</span><br>
                                            <span class="searchDate">{{ $shelfmark }}</span>
                                        </figcaption>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="centered text-center">
                        <nav>
                            {!! $paginationLinks !!}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs" id="side_facet">
        @if(! empty($facets) && $total > 0)
            <h3>Refine Results</h3>

            @foreach($facets as $index => $facet)
                @php
                    $activeTerms = [];
                    $inactiveTerms = [];
                    $numTerms = 0;

                    foreach (($facet['terms'] ?? []) as $term) {
                        if (! empty($term['active'])) {
                            $activeTerms[] = $term;
                        } else {
                            $inactiveTerms[] = $term;
                        }
                        $numTerms++;
                    }
                @endphp

                <div class="panel-group" id="accordion{{ $index }}">
                    <div class="panel panel-facets">
                        <div class="panel-heading">
                            <span class="facet_title">
                                <a data-toggle="collapse" data-parent="#accordion" href="?query=h#collapse{{ $index }}">
                                    {{ $facet['name'] }}<i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </a>
                            </span>
                        </div>

                        <div id="collapse{{ $index }}" class="panel-collapse collapse in">
                            <div class="panel-body" id="{{ $index }}_container">
                                @if(count($activeTerms) > 0)
                                    @foreach($activeTerms as $term)
                                        @php
                                            $pattern = '#/'.rawurlencode($facet['name']).':%22'.preg_quote($term['name'] ?? '', '#').'%22#';
                                            $remove = preg_replace($pattern, '', $base_search);
                                        @endphp
                                        {{ $term['display_name'] ?? '' }}
                                        <a class="deselect" href="{{ $remove }}"><i class="fa fa-close" aria-hidden="true"></i>&nbsp;<span>{{ $term['count'] ?? 0 }}</span></a><br><br>
                                    @endforeach
                                @endif

                                @foreach($inactiveTerms as $term)
                                    @php
                                        $termName = str_replace(["\r\n", "\r", "\n"], ' ', (string) ($term['name'] ?? ''));
                                    @endphp
                                    <a href="{{ $base_search }}/{{ rawurlencode($facet['name']) }}:%22{{ urlencode($termName) }}%22{{ $base_parameters }}">
                                        {{ $term['display_name'] ?? '' }}
                                        <span>{{ $term['count'] ?? 0 }}</span>
                                    </a>
                                    <br><br>
                                @endforeach

                                @if(empty($facet['terms'] ?? []))
                                    No matches<br><br>
                                @elseif($numTerms === $facetLimit)
                                    <a href="./browse/{{ $facet['name'] }}">More ...</a><br><br>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
    $(function () {
        var $grid = $('#results-grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true
        });
        $grid.imagesLoaded().progress(function () {
            $grid.masonry('layout');
        });
    });
</script>
@endsection
