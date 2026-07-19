@extends('layouts.bodylanguage')

@php
    $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
    $displayTitle = strip_tags($titleValue);
    $filterKeys = array_keys(config('skylight.filters', []));

    $identifierValue = $record['Identifier'] ?? $record['_raw']['component_id'] ?? null;
    $identifierValue = is_array($identifierValue) ? ($identifierValue[0] ?? '') : (string) $identifierValue;

    $recordAspaceId = $record['Id'] ?? $record['id'] ?? null;
    $recordAspaceId = is_array($recordAspaceId) ? ($recordAspaceId[0] ?? '') : (string) $recordAspaceId;

    $linkUrlPrefix = rtrim((string) config('skylight.link_url', ''), '/');

    // EAD note fields we allow tags in (mirrors legacy nl2br + limited-tag output).
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

    <div class="full-title">
        <h1 class="itemtitle">{{ $displayTitle }}</h1>
    </div>

    <div class="smol-divider"></div>
    @if($linkUrlPrefix !== '' && $recordAspaceId !== '')
        <a class="results-link" href="{{ $linkUrlPrefix.$recordAspaceId }}" title="Full record at archive collections online" target="_blank">View full record in University of Edinburgh archives catalogue</a>
    @endif
    <div class="divider"></div>

    <div class="full-metadata">
        <table>
            <tbody>
                @php $idShown = false; @endphp
                @foreach($recordDisplay as $displayField)
                    @if(isset($record[$displayField]) && ! empty($record[$displayField]))
                        <tr>
                            <th>{{ $displayField }}</th>
                            <td>
                                @php $values = is_array($record[$displayField]) ? $record[$displayField] : [$record[$displayField]]; @endphp
                                @foreach($values as $index => $metadatavalue)
                                    @if(in_array($displayField, $filterKeys, true) && is_string($metadatavalue))
                                        @php $origFilter = urlencode($metadatavalue); @endphp
                                        <a href="./search/*:*/{{ $displayField }}:%22{{ $origFilter }}%22" class="resultslist-link">{{ $metadatavalue }}</a>
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
                        <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/cultural-heritage-collections/crc/visitor-information/opening-times-location" target="_blank" title="University of Edinburgh, Centre for Research Collections">University of Edinburgh, Centre for Research Collections</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>

    <input type="button" value="Back to Search Results" class="backbtn" onclick="history.go(-1);">

    <div class="big-divider"></div>
</div>
@endsection

@section('sidebar')
<h4>Related Items</h4>
<ul class="related">
    @if(! empty($relatedItems))
        @foreach($relatedItems as $index => $item)
            @php
                $relatedTitleRaw = is_array($item['Title'] ?? null) ? ($item['Title'][0] ?? 'Untitled') : ($item['Title'] ?? 'Untitled');
                $relatedTitle = strip_tags($relatedTitleRaw);

                $relatedFullId = $item['Id'] ?? $item['id'] ?? '';
                $relatedFullId = is_array($relatedFullId) ? ($relatedFullId[0] ?? '') : $relatedFullId;
                $relatedIdParts = explode('/', (string) $relatedFullId);
                $relatedNumericId = end($relatedIdParts);

                $relatedTypes = $item['_raw']['types'] ?? [];
                $relatedType = is_array($relatedTypes) ? ($relatedTypes[0] ?? 'archival_object') : ($relatedTypes ?: 'archival_object');
            @endphp
            <li @class(['first' => $index === 0, 'last' => $index === count($relatedItems) - 1])>
                <a href="./record/{{ $relatedNumericId }}/{{ $relatedType }}">{{ $relatedTitle }}</a>
                <div class="sidebar-overlay"></div>
            </li>
        @endforeach
    @else
        <li>None.</li>
    @endif
</ul>
@endsection
