@extends('layouts.fairbairn')

@section('title', 'Search Results - W. Ronald D. Fairbairn')

@section('content')
@if($total > 0)
    <div class="listing-filter">
        <span class="no-results">
            <strong>{{ $startRow }}-{{ $endRow }}</strong> of
            <strong>{{ number_format($total) }}</strong> results
        </span>

        <span class="sort">
            <strong>Sort by</strong>
            @foreach($sort_options as $label => $field)
                <em>{{ $label }}</em>
                @php
                    $sortPrefix = ($base_parameters ?? '') === '' ? '?sort_by=' : '&sort_by=';
                @endphp
                <a href="{{ ($base_search ?? '') . ($base_parameters ?? '') . $sortPrefix . $field . '+asc' }}">A-Z</a> |
                <a href="{{ ($base_search ?? '') . ($base_parameters ?? '') . $sortPrefix . $field . '+desc' }}">Z-A</a>
            @endforeach
        </span>
    </div>

    <ul class="listing">
        @foreach($docs as $index => $doc)
            @php
                $fullId = $doc['Id'] ?? $doc['id'] ?? '';
                $idParts = explode('/', $fullId);
                $numericId = end($idParts);

                $rawTypes = $doc['_raw']['types'] ?? [];
                $type = is_array($rawTypes) ? ($rawTypes[0] ?? 'archival_object') : ($rawTypes ?: 'archival_object');

                $title = is_array($doc['Title'] ?? null) ? ($doc['Title'][0] ?? 'Untitled') : ($doc['Title'] ?? 'Untitled');
                $componentId = $doc['_raw']['component_id'] ?? $doc['Identifier'] ?? null;
                $componentId = is_array($componentId) ? ($componentId[0] ?? null) : $componentId;

                $creators = $doc['Creator'] ?? [];
                $creators = is_array($creators) ? $creators : [$creators];

                $subjects = $doc['Subject'] ?? [];
                $subjects = is_array($subjects) ? $subjects : [$subjects];
            @endphp
            <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                <div class="item-div">
                    <h3><a href="{{ $collectionUrl('record/'.$numericId.'/'.$type) }}">{{ strip_tags($title) }}</a></h3>
                    @if($componentId)
                        <div class="component_id">{{ $componentId }}</div>
                    @endif
                    <div class="iteminfo">
                        @foreach($creators as $creatorIndex => $creator)
                            @if(is_string($creator) && $creator !== '')
                                @php $origFilter = urlencode($creator); @endphp
                                <a class="agent" href="{{ $collectionUrl('search/*:*/Agent:%22'.$origFilter.'%22') }}">{{ $creator }}</a>@if($creatorIndex < count($creators) - 1) @endif
                            @endif
                        @endforeach

                        @if(count(array_filter($subjects, 'is_string')) > 0)
                            <div class="tags">
                                @foreach($subjects as $subject)
                                    @if(is_string($subject) && $subject !== '')
                                        @php $origFilter = urlencode($subject); @endphp
                                        <a class="subject" href="{{ $collectionUrl('search/*:*/Subject:%22'.$origFilter.'%22') }}">{{ $subject }}</a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="pagination">
        <span class="no-results">
            <strong>{{ $startRow }}-{{ $endRow }}</strong> of
            <strong>{{ number_format($total) }}</strong> results
        </span>
        {!! $paginationLinks !!}
    </div>
@else
    <h3>No results found</h3>
    <p>Your search for &ldquo;{{ urldecode($query) }}&rdquo; returned no results.</p>
@endif
@endsection

@section('sidebar')
<div class="col-sidebar">
    @include('fairbairn.search.partials.facets')
</div>
@endsection
