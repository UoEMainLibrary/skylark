@extends('layouts.geddes-v2')

@section('title', 'Search - Evergreen - Geddes Project')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $identifierField = str_replace('.', '', $fieldMappings['Identifier'] ?? 'dcidentifieren');
    $imageField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $searchDisplay = config('skylight.searchresult_display', []);
@endphp

<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
    <div class="geddes-content lg:col-span-9">
        <p>This is the online portal to the Patrick Geddes Archives held by the Universities of Edinburgh and Strathclyde. Search the collections by using the free text search box above, using a keyword or a phrase.
            You can also browse by author, subject, place or date using the navigation panels on the right of the page.</p>
        <p>Please note that, at this time, the author, subject, place and date browse facility is indicative of only a proportion of the collections holdings and is not exhaustive.
            Search results are displayed in lists of up to 30 items per page. If you wish the search results to be displayed alphabetically by title, click the ‘Sort by A-Z’ at the top right of the search results list.
            You can view more detailed document descriptions by clicking on the item title on the search results page; each display will give you the title, description, reference number, date and access information. Some search results will include a digital image of the document.
            You can see more information and view the individual item in context by clicking ‘see more’. This will take you to the holding institution’s online catalogue in a new browser tab.
            To view the actual document it is necessary to visit the holding institution’s reading rooms in person.</p>

        @if($total > 0)
            <div class="geddes-search-row flex items-center justify-between">
                <h5 class="text-sm text-gray-500">Showing {{ $total }} results</h5>
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
                <div class="geddes-search-row flex flex-col gap-4 sm:flex-row sm:items-start">
                    <div class="min-w-0 flex-1">
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
                        <div class="shrink-0 sm:w-20">
                            <a href="{{ url('/geddes/record/'.$recordId) }}">
                                <img src="{{ str_replace('/full/0/', '/,40/0/', $image) }}" class="h-auto w-full max-w-20" alt="{{ $title }}">
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="mt-6 text-center">{!! $paginationLinks !!}</div>
        @else
            <h3>No results found</h3>
        @endif
    </div>

    @if(!empty($facets))
        <aside class="lg:col-span-3">
            @foreach($facets as $facet)
                <ul class="geddes-facet-list mb-6 list-none p-0">
                    <li><a href="{{ url('/geddes/browse/'.$facet['name']) }}">{{ $facet['name'] }}</a></li>
                    @forelse($facet['terms'] as $term)
                        @php
                            $normalizedFacetValue = str_replace(["\r\n", "\n", "\r"], ' ', $term['name']);
                            $encodedFacetValue = urlencode($normalizedFacetValue);
                            $facetUrl = $base_search . '/' . $facet['name'] . ':%22' . $encodedFacetValue . '%22' . $base_parameters;
                        @endphp
                        <li class="flex items-center justify-between gap-2">
                            <a href="{{ $facetUrl }}">{{ $term['display_name'] }}</a>
                            <span class="shrink-0 rounded bg-gray-500 px-2 py-0.5 text-xs text-white">{{ $term['count'] }}</span>
                        </li>
                    @empty
                        <li>No matches</li>
                    @endforelse
                </ul>
            @endforeach
        </aside>
    @endif
</div>
@endsection
