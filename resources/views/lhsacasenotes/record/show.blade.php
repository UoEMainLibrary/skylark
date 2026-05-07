@extends('layouts.lhsacasenotes')

@php
    $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
    $displayTitle = strip_tags($titleValue);
@endphp

@section('title', $displayTitle . ' - Lothian Health Service Archives: Medical Case Notes')

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <h1 class="itemtitle">{{ $displayTitle }}</h1>
    </div>

    <div class="row full-metadata">
        <table class="table">
            <tbody>
                @php
                    $parentId = $record['Parent_Id'] ?? $record['_raw']['parent_id'] ?? null;
                    $parentType = $record['Parent_Type'] ?? $record['_raw']['parent_type'] ?? null;
                    $parentId = is_array($parentId) ? ($parentId[0] ?? null) : $parentId;
                    $parentType = is_array($parentType) ? ($parentType[0] ?? null) : $parentType;
                @endphp
                @if($parentId && $parentType)
                    <tr>
                        <th>Hierarchy</th>
                        <td>
                            <a href="{{ url('/lhsacasenotes/record/' . $parentId . '/' . $parentType) }}">Parent Record</a>
                        </td>
                    </tr>
                @endif

                @php $idShown = false; @endphp
                @foreach($recordDisplay as $displayField)
                    @php
                        $value = $record[$displayField] ?? null;
                    @endphp
                    @if(!empty($value))
                        <tr>
                            <th>{{ $displayField }}</th>
                            <td>
                                @php
                                    $values = is_array($value) ? $value : [$value];
                                @endphp
                                @foreach($values as $index => $metadatavalue)
                                    @if(in_array($displayField, $filters, true) && is_string($metadatavalue))
                                        @php $orig = urlencode($metadatavalue); @endphp
                                        <a href='{{ url('/lhsacasenotes/search/*:*/' . $displayField . ':"' . $orig . '"') }}'>{{ $metadatavalue }}</a>
                                    @elseif($displayField === 'Identifier')
                                        @if(!$idShown)
                                            {{ is_array($metadatavalue) ? ($metadatavalue[0] ?? '') : $metadatavalue }}
                                            @php $idShown = true; @endphp
                                        @endif
                                    @elseif($displayField === 'Dates')
                                        @if(is_array($metadatavalue))
                                            {{ $metadatavalue['expression'] ?? ($metadatavalue['begin'] ?? '') }}
                                        @else
                                            {{ $metadatavalue }}
                                        @endif
                                    @elseif($displayField === 'Extent')
                                        @if(is_array($metadatavalue))
                                            {{ trim(($metadatavalue['number'] ?? '') . ' ' . ($metadatavalue['extent_type'] ?? '')) }}
                                        @else
                                            {{ $metadatavalue }}
                                        @endif
                                    @elseif(is_array($metadatavalue))
                                        {{ implode(', ', array_filter($metadatavalue, 'is_string')) }}
                                    @else
                                        {!! nl2br(e($metadatavalue)) !!}
                                    @endif

                                    @if($index < count($values) - 1)
                                        <br />
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <th>Consult at</th>
                    <td>
                        <a href="http://www.lhsa.lib.ed.ac.uk/" target="_blank" rel="noopener" title="Lothian Health Services Archive">Lothian Health Services Archive</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <button class="btn btn-info" onClick="history.go(-1);">
            <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results
        </button>
    </div>
</div>

{{-- Related Items sidebar (replaces the standard browse facets sidebar on record pages) --}}
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="sidebar-nav related-items">
        <ul class="list-group">
            <li class="list-group-item active">Related Items</li>
            @if(!empty($relatedItems))
                @foreach($relatedItems as $item)
                    @php
                        $relatedTitleRaw = is_array($item['Title'] ?? null) ? ($item['Title'][0] ?? 'Untitled') : ($item['Title'] ?? 'Untitled');
                        $relatedTitle = strip_tags($relatedTitleRaw);

                        $relatedFullId = $item['Id'] ?? $item['id'] ?? '';
                        $relatedIdParts = explode('/', $relatedFullId);
                        $relatedNumericId = end($relatedIdParts);
                        $relatedTypes = $item['_raw']['types'] ?? [];
                        $relatedType = is_array($relatedTypes) ? ($relatedTypes[0] ?? 'archival_object') : ($relatedTypes ?: 'archival_object');

                        $relatedComponentId = $item['_raw']['component_id'] ?? $item['Identifier'] ?? null;
                        $relatedComponentId = is_array($relatedComponentId) ? ($relatedComponentId[0] ?? null) : $relatedComponentId;

                        $relatedDates = $item['_raw']['dates'] ?? null;
                        $relatedDates = is_array($relatedDates) ? ($relatedDates[0] ?? null) : $relatedDates;
                    @endphp
                    <li class="list-group-item">
                        <a class="related-record" href="{{ url('/lhsacasenotes/record/' . $relatedNumericId . '/' . $relatedType) }}">{{ $relatedTitle }}</a>
                        @if(!empty($relatedComponentId))
                            <div class="component_id">{{ $relatedComponentId }}</div>
                        @endif
                        @if(!empty($relatedDates))
                            {{ $relatedDates }}
                        @endif
                    </li>
                @endforeach
            @else
                <li class="list-group-item">None.</li>
            @endif
        </ul>
    </div>
</div>
@endsection
