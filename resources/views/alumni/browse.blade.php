@extends('layouts.alumni')

@section('title', 'Browse "'.$browseFacet.'" - University of Edinburgh Historical Alumni')

@section('content')
<div class="col-main">
    @if($collectionTotal === 0)
        <h1>Browse "{{ $browseFacet }}"</h1>
        <p>No items are available in this collection.</p>
    @else
        <div class="pagination browse_pagination">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ number_format($totalFacetValues) }}</strong> results
            </span>
            @if($hasPrev || $hasNext)
                <span class="browse-paging">
                    @if($hasPrev)
                        <a href="{{ $prevUrl }}">&laquo; Previous</a>
                    @endif
                    @if($hasPrev && $hasNext)
                        &nbsp;|&nbsp;
                    @endif
                    @if($hasNext)
                        <a href="{{ $nextUrl }}">Next &raquo;</a>
                    @endif
                </span>
            @endif
        </div>
        <br />
        <div class="browse_results">
            <div class="term_search">
                <form method="get" action="{{ \App\Support\CollectionUrl::url('browse/'.$browseFacet) }}">
                    <label for="prefix">Starts with: (case sensitive) </label>
                    <input name="prefix" id="prefix" value="{{ $prefix }}" />
                    <input type="submit" value="Filter" />
                </form>
            </div>
            <br />
            <div class="browse_facets">
                <ul class="browse_facet_list">
                    @foreach($facet['terms'] ?? [] as $term)
                        {{-- DSpaceService::browseTerms already returns $term['name'] rawurlencoded
                             with newlines collapsed to spaces, so emit it as-is. --}}
                        <li>
                            <a href="{{ $base_search }}/{{ $facet['name'] }}{{ $delimiter }}%22{{ $term['name'] }}%22">{{ $term['display_name'] }} ({{ $term['count'] }})</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
</div>
{{-- Matches the legacy CI /alumni/browse/* pages, which intentionally render
     only the single main column with no facet sidebar. --}}
<div class="clearfix"></div>
@endsection
