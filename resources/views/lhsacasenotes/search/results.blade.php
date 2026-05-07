@extends('layouts.lhsacasenotes')

@section('title', 'Search Results - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    @if($total > 0)
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination pagination-sm pagination-xs">
                        {!! $paginationLinks !!}
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row search-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num">
                <h5 class="text-muted">Showing {{ number_format($total) }} results</h5>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num sort">
                @php
                    $currentSort = request('sort_by', '');
                    $isAscending = $currentSort && str_contains($currentSort, 'asc');
                    $isDescending = $currentSort && str_contains($currentSort, 'desc');
                @endphp
                <h5 class="text-muted">Sort By: <em>Title</em>
                    @if($isAscending)
                        <em>A-Z</em> |
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort desc']) }}">Z-A</a>
                    @elseif($isDescending)
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort asc']) }}">A-Z</a> |
                        <em>Z-A</em>
                    @else
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort asc']) }}">A-Z</a> |
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title_sort desc']) }}">Z-A</a>
                    @endif
                </h5>
            </div>
        </div>

        @foreach($docs as $doc)
            @php
                $fullId = $doc['Id'] ?? $doc['id'] ?? '';
                $idParts = explode('/', $fullId);
                $numericId = end($idParts);

                $rawTypes = $doc['_raw']['types'] ?? [];
                $type = is_array($rawTypes) ? ($rawTypes[0] ?? 'archival_object') : ($rawTypes ?: 'archival_object');

                $title = is_array($doc['Title'] ?? null) ? ($doc['Title'][0] ?? 'Untitled') : ($doc['Title'] ?? 'Untitled');
            @endphp
            <div class="row search-row">
                <h3>
                    <a href="{{ url('/lhsacasenotes/record/' . $numericId . '/' . $type) }}">{{ strip_tags($title) }}</a>
                </h3>

                @php
                    $componentId = $doc['_raw']['component_id'] ?? $doc['Identifier'] ?? null;
                    $componentId = is_array($componentId) ? ($componentId[0] ?? null) : $componentId;
                @endphp
                @if(!empty($componentId))
                    <div class="component_id">{{ $componentId }}</div>
                @endif

                @php
                    $authors = $doc['Creator'] ?? null;
                    $authors = is_array($authors) ? $authors : ($authors ? [$authors] : []);
                @endphp
                @foreach($authors as $author)
                    @php $orig = urlencode($author); @endphp
                    <a class="agent" href='{{ url('/lhsacasenotes/search/*:*/Agent:"' . $orig . '"') }}'>{{ $author }}</a>
                @endforeach

                @php
                    $subjects = $doc['Subject'] ?? null;
                    $subjects = is_array($subjects) ? $subjects : ($subjects ? [$subjects] : []);
                @endphp
                @if(!empty($subjects))
                    <div class="tags">
                        @foreach($subjects as $subject)
                            @php $orig = urlencode($subject); @endphp
                            <a class="subject" href='{{ url('/lhsacasenotes/search/*:*/Subject:"' . $orig . '"') }}'>{{ $subject }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

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
            <p>Your search for &ldquo;{{ $query }}&rdquo; returned no results.</p>
        </div>
    @endif
</div>

{{-- Active-state facets from SearchController --}}
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav">
        @if(count($facets ?? []) > 0)
            @foreach($facets as $facet)
                @if(count($facet['terms'] ?? []) > 0)
                    <ul class="list-group">
                        <li class="list-group-item active">{{ $facet['name'] }}</li>
                        @foreach($facet['terms'] as $term)
                            <li class="list-group-item">
                                <span class="badge">{{ $term['count'] }}</span>
                                @if($term['active'])
                                    {{ $term['display_name'] }}
                                    @php
                                        $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                        $pattern = '/' . rawurlencode($facet['name']) . ':"' . $encodedTerm . '"';
                                        $removeUrl = str_replace($pattern, '', request()->path());
                                        $removeUrl = rtrim($removeUrl, '/');
                                        if (empty($removeUrl) || $removeUrl === 'lhsacasenotes/search') {
                                            $removeUrl = 'lhsacasenotes/search/*:*';
                                        }
                                    @endphp
                                    <a class="deselect" href='{{ url($removeUrl) }}'><i class="fa fa-close"></i>&nbsp;</a>
                                @else
                                    @php
                                        $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                        $addUrl = request()->path() . '/' . $facet['name'] . ':"' . $encodedTerm . '"';
                                    @endphp
                                    <a href='{{ url($addUrl) }}'>{{ $term['display_name'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @endif
    </div>
</div>
@endsection
