@extends('layouts.fairbairn')

@php
    $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
    $displayTitle = strip_tags($titleValue);
    $filterKeys = array_keys(config('skylight.filters', []));
    $identifierValue = $record['Identifier'] ?? $record['_raw']['component_id'] ?? null;
    $identifierValue = is_array($identifierValue) ? ($identifierValue[0] ?? '') : (string) $identifierValue;
    $isNlsRecord = str_starts_with($identifierValue, 'MS');
    $eadNoteFields = [
        'Notes',
        'Physical',
        'Physical Description',
        'Scope and Contents',
        'Related',
        'Access',
        'Bibliography',
        'Alternative Format',
        'Rights',
    ];
    $eadNoteTags = '<dimensions><extent><physfacet><physloc><a><em><strong><br><p>';
@endphp

@section('title', $displayTitle)

@section('content')
<div class="content">
    <div itemscope itemtype="http://schema.org/CreativeWork">
        <div class="full-title">
            <h1 class="itemtitle">{{ $displayTitle }}</h1>
        </div>

        @php
            $parentId = $record['Parent_Id'] ?? $record['_raw']['parent_id'] ?? null;
            $parentType = $record['Parent_Type'] ?? $record['_raw']['parent_type'] ?? null;
            $parentId = is_array($parentId) ? ($parentId[0] ?? null) : $parentId;
            $parentType = is_array($parentType) ? ($parentType[0] ?? null) : $parentType;
        @endphp
        @if($parentId && $parentType)
            <a href="{{ $collectionUrl('record/'.$parentId.'/'.$parentType) }}">Parent Record</a>
        @endif

        <div class="full-metadata">
            <table>
                <tbody>
                @php $idShown = false; @endphp
                @foreach($recordDisplay as $displayField)
                    @if(isset($record[$displayField]) && !empty($record[$displayField]))
                        <tr>
                            <th>{{ $displayField }}</th>
                            <td>
                                @php $values = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]]; @endphp
                                @foreach($values as $index => $metadatavalue)
                                    @if(in_array($displayField, $filterKeys, true) && is_string($metadatavalue))
                                        @php $origFilter = urlencode($metadatavalue); @endphp
                                        <a href="{{ $collectionUrl('search/*:*/'.$displayField.':%22'.$origFilter.'%22') }}" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a>
                                    @elseif($displayField === 'Identifier')
                                        @if(! $idShown)
                                            {{ $metadatavalue }}
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
                                            {{ $metadatavalue['number'] ?? '' }}
                                        @else
                                            {{ $metadatavalue }}
                                        @endif
                                    @elseif(in_array($displayField, $eadNoteFields, true))
                                        {!! nl2br(strip_tags((string) $metadatavalue, $eadNoteTags)) !!}
                                    @else
                                        {!! nl2br(e((string) (is_array($metadatavalue) ? implode(', ', array_filter($metadatavalue, 'is_string')) : $metadatavalue))) !!}
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
                        @if($isNlsRecord)
                            <a href="https://www.nls.uk/" target="_blank" rel="noopener" title="National Library of Scotland">National Library of Scotland</a>
                        @else
                            <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" target="_blank" rel="noopener" title="University of Edinburgh, Centre for Research Collections">University of Edinburgh, Centre for Research Collections</a>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>

        <input type="button" value="Back to Search Results" class="backbtn" onclick="history.go(-1);">
    </div>
</div>
@endsection

@section('sidebar')
<div class="col-sidebar">
    <h4>Related Items</h4>
    <ul class="related">
        @if(!empty($relatedItems))
            @foreach($relatedItems as $index => $item)
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
                    $relatedDates = $item['Dates'][0]['expression'] ?? ($item['_raw']['dates'][0]['expression'] ?? null);
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ $collectionUrl('record/'.$relatedNumericId.'/'.$relatedType) }}">{{ $relatedTitle }}</a>
                    @if($relatedComponentId)
                        <div class="component_id">{{ $relatedComponentId }}</div>
                    @endif
                    @if(is_string($relatedDates) && $relatedDates !== '')
                        {{ $relatedDates }}
                    @endif
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
    </ul>
</div>
@endsection
