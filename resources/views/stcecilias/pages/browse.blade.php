@extends('layouts.stcecilias')

@section('title', 'Browse ' . $browseFacet . " — St Cecilia's Hall")

@section('body_class', 'browse')

@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 inst-results">
        <div class="container-fluid">
            <h2>Browse {{ $browseFacet }}</h2>

            @if($totalFacetValues === 0)
                <p>No values are available for this facet.</p>
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
                        <form method="get" action="{{ url('/stcecilias/browse/' . $browseFacet) }}">
                            <div class="input-group">
                                <input name="prefix" class="form-control" id="prefix" value="{{ $prefix }}" placeholder="Starts with: (case sensitive)" />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search"></span>&nbsp; Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <br />

                    <div class="browse_facets">
                        <ul class="list-group">
                            @foreach($facet['terms'] ?? [] as $term)
                                <li class="list-group-item">
                                    <span class="badge">{{ $term['count'] }}</span>
                                    <a href='{{ $base_search }}/{{ $facet['name'] }}{{ $delimiter }}"{{ $term['name'] }}"'>
                                        {{ $term['display_name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
