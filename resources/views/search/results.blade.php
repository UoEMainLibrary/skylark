@extends('layouts.app')

@section('title')
    @if($query !== '*' && $query !== '*:*')
        Search Results for "{{ urldecode($query) }}" - University of Edinburgh Collections
    @else
        Search Results - University of Edinburgh Collections
    @endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!-- Main results column -->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="search-results">
            @if($total === 0)
                <!-- Zero results -->
                @include('search.partials.no_results')
            @else
                <!-- Results grid -->
                <div class="container-fluid">
                    <div class="row">
                        @foreach($docs as $doc)
                            @include('search.partials.result_item', ['doc' => $doc])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="centered text-center">
                            <nav>
                                {!! $paginationLinks !!}
                            </nav>
                        </div>
                    </div>

                    <!-- Results count (below pagination) -->
                    <div class="row">
                        <div class="centered text-center">
                            <nav>
                                <span class="searchFound">{{ number_format($total) }} results found</span>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Facets sidebar -->
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs" id="side_facet">
            @include('search.partials.facets')
        </div>
    </div>
</div>
@endsection
