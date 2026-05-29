@extends('layouts.jlss')

@section('title', 'Search - Jewish Lives Scottish Spaces')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? 'dctitleen');
    $identifierField = str_replace('.', '', $fieldMappings['Accession Number'] ?? 'dcidentifieren');
    $itemImageField = str_replace('.', '', $fieldMappings['ItemImage'] ?? '');
    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
    $searchDisplay = config('skylight.searchresult_display', []);
@endphp
<div class="col-md-9 col-sm-9 col-xs-12">
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
                $itemImageValue = $itemImageField !== '' ? ($doc[$itemImageField] ?? null) : null;
                $itemImage = is_array($itemImageValue) ? ($itemImageValue[0] ?? null) : $itemImageValue;
                $dateValue = $dateField !== '' ? ($doc[$dateField] ?? null) : null;
                $date = is_array($dateValue) ? ($dateValue[0] ?? null) : $dateValue;
            @endphp
            <div class="row search-row" title="An item from this collection">
                @if($itemImage)
                    <div class="collection-image-box">
                        <figure class="clickbox">
                            <img class="component_image" src="{{ config('skylight.image_server').'/iiif/2/'.$itemImage.'/square/96,/0/default.jpg' }}" alt="{{ $title }}">
                            <div class="clickbox-text"><i class="fa fa-camera"></i><div class="curl"></div><a class="component_image_link" href="{{ url('/jlss/record/'.$recordId) }}"></a></div>
                        </figure>
                    </div>
                @endif
                <h3><a href="{{ url('/jlss/record/'.$recordId) }}">{{ $title }}</a>@if($date) ({{ $date }}) @endif</h3>
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
                    <li class="list-group-item active"><a href="{{ url('/jlss/browse/'.$facet['name']) }}">{{ $facet['name'] }}</a></li>
                    @forelse($facet['terms'] as $term)
                        <li class="list-group-item"><span class="badge">{{ $term['count'] }}</span>{{ $term['display_name'] }}</li>
                    @empty
                        <li class="list-group-item">No matches</li>
                    @endforelse
                </ul>
            @endforeach
        </div>
    </div>
@endif
@endsection
