@extends('layouts.openbooks')

@section('title', 'Browse "'.$browseFacet.'" - Open Books')

@section('content')
<div class="content">
    @if($collectionTotal === 0)
        <h1>Browse "{{ $browseFacet }}"</h1>
        <p>No items are available in this collection.</p>
    @else
        <div class="pagination browse_pagination">
            <span class="no-results">
                <strong>{{ $startRow }}-{{ $endRow }}</strong> of
                <strong>{{ number_format($totalFacetValues) }}</strong> values
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
                <form method="get" action="{{ $collectionUrl('browse/'.$browseFacet) }}">
                    <label for="prefix">Starts with: (case sensitive) </label>
                    <input name="prefix" id="prefix" value="{{ $prefix }}" />
                    <input type="submit" value="Filter" />
                </form>
            </div>
            <br />
            <div class="browse_facets">
                <ul class="browse_facet_list">
                    @foreach($facet['terms'] ?? [] as $term)
                        <li>
                            <a href="{{ $base_search }}/{{ $facet['name'] }}{{ $delimiter }}%22{{ $term['name'] }}%22">{{ $term['display_name'] }} ({{ $term['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection
