@extends('layouts.geddes')

@section('title', 'Search - Evergreen - Geddes Project')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $identifierField = str_replace('.', '', $fieldMappings['Identifier'] ?? 'dcidentifieren');
    $imageField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $searchDisplay = config('skylight.searchresult_display', []);
@endphp
<div class="col-md-9 col-sm-9 col-xs-12">
    <div>
        <p>This is the online portal to the Patrick Geddes Archives held by the Universities of Edinburgh and Strathclyde.  Search the collections by using the free text search box above, using a keyword or a phrase.
        You can also browse by author, subject, place or date using the navigation panels on the right of the page.</p>
        <p>Please note that, at this time, the author, subject, place and date browse facility is indicative of only a proportion of the collections holdings and is not exhaustive.
        Search results are displayed in lists of up to 30 items per page.  If you wish the search results to be displayed alphabetically by title, click the ‘Sort by A-Z’ at the top right of the search results list.
        You can view more detailed document descriptions by clicking on the item title on the search results page; each display will give you the title, description, reference number, date and access information.  Some search results will include a digital image of the document.
        You can see more information and view the individual item in context by clicking ‘see more’.  This will take you to the holding institution’s online catalogue in a new browser tab.
        To view the actual document it is necessary to visit the holding institution’s reading rooms in person.</p>
    </div>
    @if($total > 0)
        <div class="row search-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num">
                <h5 class="text-muted">Showing {{ $total }} results</h5>
            </div>
        </div>

        @foreach($docs as $doc)
            @php
                $titleValue = $doc[$titleField] ?? $doc['title'] ?? null;
                $identifierValue = $doc[$identifierField] ?? null;
                $identifierFallback = is_array($identifierValue) ? ($identifierValue[0] ?? null) : $identifierValue;
                $title = strip_tags(
                    is_array($titleValue)
                        ? ($titleValue[0] ?? ($identifierFallback ?: 'Untitled'))
                        : ($titleValue ?: ($identifierFallback ?: 'Untitled'))
                );
                $recordId = $doc['id'] ?? '';
                $imageValue = $imageField !== '' ? ($doc[$imageField] ?? null) : null;
                $image = is_array($imageValue) ? ($imageValue[0] ?? null) : $imageValue;
            @endphp
            <div class="row search-row">
                <div class="text">
                    <h3><a href="{{ url('/geddes/record/'.$recordId) }}">{{ $title }}</a></h3>
                    @foreach($searchDisplay as $label)
                        @continue($label === 'Title')
                        @php
                            $mappedField = str_replace('.', '', $fieldMappings[$label] ?? '');
                            $rawValue = $mappedField !== '' ? ($doc[$mappedField] ?? null) : null;
                            $displayValue = is_array($rawValue) ? ($rawValue[0] ?? null) : $rawValue;
                        @endphp
                        @if(!empty($displayValue))
                            <div class="search-meta"><strong>{{ $label }}:</strong> {{ strip_tags((string) $displayValue) }}</div>
                        @endif
                    @endforeach
                </div>
                @if($image)
                    <div class="thumbnail-image">
                        <a href="{{ url('/geddes/record/'.$recordId) }}"><img src="{{ str_replace('/full/0/', '/,40/0/', $image) }}" class="record-thumbnail-search" alt="{{ $title }}"></a>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="row"><div class="centered text-center">{!! $paginationLinks !!}</div></div>
    @else
        <h3>No results found</h3>
    @endif
</div>

@if(!empty($facets))
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @foreach($facets as $facet)
                <ul class="list-group">
                    <li class="list-group-item active"><a href="{{ url('/geddes/browse/'.$facet['name']) }}">{{ $facet['name'] }}</a></li>
                    @forelse($facet['terms'] as $term)
                        @php
                            $normalizedFacetValue = str_replace(["\r\n", "\n", "\r"], ' ', $term['name']);
                            $encodedFacetValue = urlencode($normalizedFacetValue);
                            $facetUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedFacetValue . '%22' . $base_parameters;
                        @endphp
                        <li class="list-group-item"><span class="badge">{{ $term['count'] }}</span><a href="{{ $facetUrl }}">{{ $term['display_name'] }}</a></li>
                    @empty
                        <li class="list-group-item">No matches</li>
                    @endforelse
                </ul>
            @endforeach
        </div>
    </div>
@endif
@endsection
