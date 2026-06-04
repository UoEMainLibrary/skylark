@extends('layouts.geddes')

@section('title', $recordTitle !== 'Untitled' ? $recordTitle : ($record[str_replace('.', '', $fieldMappings['Identifier'] ?? '')][0] ?? 'Record'))

@section('content')
@php
    $identifierField = str_replace('.', '', $fieldMappings['Identifier'] ?? '');
    $linkField = str_replace('.', '', $fieldMappings['Link'] ?? '');
    $imageField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $identifierFallback = $identifierField !== '' ? ($record[$identifierField][0] ?? null) : null;
    $displayTitle = $recordTitle === 'Untitled' && !empty($identifierFallback) ? $identifierFallback : $recordTitle;
@endphp
<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <h1 class="itemtitle">{{ strip_tags($displayTitle) }}</h1>
    </div>

    @if($linkField !== '' && isset($record[$linkField][0]))
        <div class="row">
            <div class="btn btn-info"><a href="{{ $record[$linkField][0] }}" target="_blank" rel="noopener">More information</a></div>
        </div>
    @endif

    <div class="row full-metadata">
        <table class="table">
            <tbody>
            @foreach($recordDisplay as $label)
                @php
                    $mappedField = str_replace('.', '', $fieldMappings[$label] ?? '');
                    $recordValues = $mappedField !== '' ? ($record[$mappedField] ?? null) : null;
                @endphp
                @if(!empty($recordValues))
                    <tr>
                        <th>{{ $label }}</th>
                        <td>
                            @foreach((array) $recordValues as $value)
                                {{ is_array($value) ? implode(', ', $value) : $value }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    @if($imageField !== '' && isset($record[$imageField][0]))
        <div class="main-image">
            <img class="responsive" src="{{ is_array($record[$imageField]) ? $record[$imageField][0] : $record[$imageField] }}" alt="{{ strip_tags($recordTitle) }}">
        </div>
    @endif

    <div class="row">
        <button class="btn btn-info" onClick="history.go(-1);"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results</button>
    </div>
</div>
@endsection
