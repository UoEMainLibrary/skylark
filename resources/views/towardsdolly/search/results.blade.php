@extends('layouts.towardsdolly')

@section('title', 'Search Results')

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
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => $field . ' asc']) }}">A-Z</a> |
                <a href="{{ request()->fullUrlWithQuery(['sort_by' => $field . ' desc']) }}">Z-A</a>
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

                $agents = $doc['Agent'] ?? [];
                $agents = is_array($agents) ? $agents : [$agents];

                $subjects = $doc['Subject'] ?? [];
                $subjects = is_array($subjects) ? $subjects : [$subjects];
            @endphp
            <li @class(['first' => $index === 0, 'last' => $index === count($docs) - 1])>
                <div class="item-div">
                    <h3><a href="{{ url('/towardsdolly/record/' . $numericId . '/' . $type) }}">{{ strip_tags($title) }}</a></h3>
                    @if($componentId)
                        <div class="component_id">{{ $componentId }}</div>
                    @endif

                    <div class="iteminfo">
                        @foreach($agents as $agent)
                            @php $agentFilter = urlencode($agent); @endphp
                            <a class="agent" href="{{ url('/towardsdolly/search/*:*/Agent:%22' . $agentFilter . '%22') }}">{{ $agent }}</a>
                        @endforeach

                        @if(count($subjects) > 0)
                            <div class="tags">
                                @foreach($subjects as $subject)
                                    @php $subjectFilter = urlencode($subject); @endphp
                                    <a class="subject" href="{{ url('/towardsdolly/search/*:*/Subject:%22' . $subjectFilter . '%22') }}">{{ $subject }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="pagination search">
        <span class="no-results">
            <strong>{{ $startRow }}-{{ $endRow }}</strong> of
            <strong>{{ number_format($total) }}</strong> results
        </span>
        <div class="page-links">{!! $paginationLinks !!}</div>
    </div>
@else
    <h3>No results found</h3>
    <p>Your search for "{{ urldecode($query) }}" returned no results.</p>
@endif
@endsection
