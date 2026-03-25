@extends('layouts.eerc')

@section('title', 'Search Results - Regional Ethnology of Scotland Project')

@section('content')
<!-- Search results -->
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
                <h5 class="text-muted">Sort By: Title
                    @php
                        $currentSort = request('sort_by', '');
                        $isAscending = $currentSort && str_contains($currentSort, 'asc');
                        $isDescending = $currentSort && str_contains($currentSort, 'desc');
                    @endphp
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
                // Skip specific records and their descendants (matching CodeIgniter logic)
                $uri = $doc['_raw']['uri'] ?? $doc['uri'] ?? '';
                $ancestors = $doc['_raw']['ancestors'] ?? $doc['ancestors'] ?? [];
                $excludedUris = [
                    '/repositories/15/archival_objects/190197',
                    '/repositories/15/archival_objects/208190',
                    '/repositories/15/archival_objects/228537',
                ];
                
                $skip = in_array($uri, $excludedUris);
                if (!$skip && is_array($ancestors)) {
                    foreach ($ancestors as $ancestor) {
                        if (in_array($ancestor, $excludedUris)) {
                            $skip = true;
                            break;
                        }
                    }
                }
            @endphp
            
            @if(!$skip)
            <div class="row search-row">
                <h3>
                    @php
                        // Extract numeric ID from URI path (e.g., /repositories/15/archival_objects/165250 -> 165250)
                        $fullId = $doc['Id'] ?? $doc['id'] ?? '';
                        $idParts = explode('/', $fullId);
                        $numericId = end($idParts);
                        
                        // Get the type from raw Solr data (e.g., archival_object)
                        $rawTypes = $doc['_raw']['types'] ?? [];
                        $type = is_array($rawTypes) ? ($rawTypes[0] ?? 'archival_object') : ($rawTypes ?? 'archival_object');
                        
                        $title = is_array($doc['Title'] ?? null) ? ($doc['Title'][0] ?? 'Untitled') : ($doc['Title'] ?? 'Untitled');
                        // Remove date information from ArchivesSpace titles (e.g., ", , , bulk: 20th century")
                        $cleanTitle = preg_replace('/,\s*,.*$/', '', $title);
                    @endphp
                    <a href="{{ url('/eerc/record/' . $numericId . '/' . $type) }}">
                        {{ $cleanTitle }}
                    </a>
                </h3>
                
                @if(isset($doc['Component Unique Identifier']) && !empty($doc['Component Unique Identifier']))
                    <div class="component_id">
                        {{ is_array($doc['Component Unique Identifier']) ? ($doc['Component Unique Identifier'][0] ?? '') : ($doc['Component Unique Identifier'] ?? '') }}
                    </div>
                @endif
                
                @if(isset($doc['Subject']) && !empty($doc['Subject']))
                    <div class="tags">
                        @php
                            $subjects = is_array($doc['Subject']) ? $doc['Subject'] : [$doc['Subject']];
                        @endphp
                        @foreach($subjects as $subject)
                            @php
                                $encodedSubject = str_replace(' ', '+', urlencode($subject));
                            @endphp
                            <a class="subject" href="{{ url('/eerc/search/*:*/Subject:\"' . $encodedSubject . '\"') }}">{{ $subject }}</a>
                        @endforeach
                    </div>
                @endif
                
                @if(isset($doc['Interview summary']) && !empty($doc['Interview summary']))
                    <div class="interview_summary">
                        {{ is_array($doc['Interview summary']) ? ($doc['Interview summary'][0] ?? '') : ($doc['Interview summary'] ?? '') }}
                    </div>
                @endif
            </div>
            @endif
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
            <p>Your search for "{{ $query }}" returned no results.</p>
        </div>
    @endif
</div>

<!-- Facets sidebar -->
<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @if(count($facets) > 0)
                @foreach($facets as $facet)
                    @if(count($facet['terms']) > 0)
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <h4 href="{{ route('eerc.browse', ['facet' => $facet['name']]) }}">
                                    {{ $facet['name'] }}
                                </h4>
                            </li>

                            @foreach($facet['terms'] as $term)
                                <li class="list-group-item">
                                    <span class="badge">{{ $term['count'] }}</span>
                                    @if($term['active'])
                                        {{ $term['display_name'] }}
                                        @php
                                            $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                            $pattern = '/' . rawurlencode($facet['name']) . ':\"' . $encodedTerm . '\"';
                                            $removeUrl = str_replace($pattern, '', request()->path());
                                            $removeUrl = rtrim($removeUrl, '/');
                                            if (empty($removeUrl) || $removeUrl === 'eerc/search') {
                                                $removeUrl = '/eerc/search/*:*';
                                            }
                                        @endphp
                                        <a class="deselect" href='{{ url($removeUrl) }}'><i class="fa fa-close"></i>&nbsp;</a>
                                    @else
                                        @php
                                            $encodedTerm = str_replace(["\r\n", "\n", "\r", ' '], '+', $term['name']);
                                            $currentPath = request()->path();
                                            $addUrl = $currentPath . '/' . $facet['name'] . ':"' . $encodedTerm . '"';
                                        @endphp
                                        <a href='{{ url($addUrl) }}'>{{ $term['display_name'] }}</a>
                                    @endif
                                </li>
                            @endforeach
                            
                            @if(count($facet['terms']) >= 10)
                                <li class="list-group-item"><a href="{{ route('eerc.browse', ['facet' => $facet['name']]) }}">More ...</a></li>
                            @endif
                        </ul>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
