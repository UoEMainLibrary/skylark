@extends('layouts.towardsdolly')

@php
    $titleValue = is_array($record['Title'] ?? null) ? ($record['Title'][0] ?? 'Untitled') : ($record['Title'] ?? 'Untitled');
    $displayTitle = strip_tags($titleValue);
    $fullId = $record['Id'] ?? $record['_raw']['id'] ?? '';
    $aspaceUrl = $fullId ? 'https://archives.collections.ed.ac.uk'.$fullId : null;
@endphp

@section('title', '"' . $displayTitle . '"')

@section('content')
<div class="content">
    <div class="full-title">
        <h1 class="itemtitle">{{ $displayTitle }}</h1>
    </div>

    @if($aspaceUrl)
        <a href="{{ $aspaceUrl }}" title="Full record at archive collections online" target="_blank" rel="noopener">
            View full record in University of Edinburgh archives catalogue
        </a>
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
                            @foreach($values as $index => $value)
                                @if($displayField === 'Identifier')
                                    @if(! $idShown)
                                        {{ is_array($value) ? ($value[0] ?? '') : $value }}
                                        @php $idShown = true; @endphp
                                    @endif
                                @elseif($displayField === 'Dates')
                                    @if(is_array($value))
                                        {{ $value['expression'] ?? ($value['begin'] ?? '') }}
                                    @else
                                        {{ $value }}
                                    @endif
                                @elseif($displayField === 'Extent')
                                    @if(is_array($value))
                                        {{ trim(($value['number'] ?? '') . ' ' . ($value['extent_type'] ?? '')) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                @elseif($displayField === 'Subject')
                                    @php $subjectFilter = urlencode((string) $value); @endphp
                                    <a href="{{ url('/towardsdolly/search/*:*/Subject:%22' . $subjectFilter . '%22') }}">{{ $value }}</a>
                                @elseif(is_array($value))
                                    {{ implode(', ', array_filter($value, 'is_string')) }}
                                @else
                                    {!! nl2br(e((string) $value)) !!}
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
                    <a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/visitor-information/opening-times-location" target="_blank" rel="noopener" title="University of Edinburgh, Centre for Research Collections">University of Edinburgh, Centre for Research Collections</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
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
                    $relatedDates = $item['Dates'][0]['expression'] ?? ($item['_raw']['dates'][0] ?? null);
                @endphp
                <li @class(['first' => $index === 0, 'last' => $index === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ url('/towardsdolly/record/' . $relatedNumericId . '/' . $relatedType) }}">{{ $relatedTitle }}</a>
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
