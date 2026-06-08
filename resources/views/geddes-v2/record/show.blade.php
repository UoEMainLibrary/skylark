@extends('layouts.geddes-v2')

@section('title', $recordTitle !== 'Untitled' ? $recordTitle : ($record[str_replace('.', '', $fieldMappings['Identifier'] ?? '')][0] ?? 'Record'))

@section('content')
@php
    $identifierField = str_replace('.', '', $fieldMappings['Identifier'] ?? '');
    $linkField = str_replace('.', '', $fieldMappings['Link'] ?? '');
    $imageField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $identifierFallback = $identifierField !== '' ? ($record[$identifierField][0] ?? null) : null;
    $displayTitle = $recordTitle === 'Untitled' && !empty($identifierFallback) ? $identifierFallback : $recordTitle;
@endphp

<div class="geddes-content max-w-4xl">
    <h1 class="mb-4 text-[22px] leading-8 text-geddes-heading">{{ strip_tags($displayTitle) }}</h1>

    @if($linkField !== '' && isset($record[$linkField][0]))
        <div class="mb-4">
            <span class="geddes-btn"><a href="{{ $record[$linkField][0] }}" target="_blank" rel="noopener">More information</a></span>
        </div>
    @endif

    <div class="mb-6 overflow-x-auto">
        <table class="geddes-record-table w-full border-collapse text-sm">
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
        <div class="mb-6">
            <img class="h-auto max-w-full" src="{{ is_array($record[$imageField]) ? $record[$imageField][0] : $record[$imageField] }}" alt="{{ strip_tags($recordTitle) }}">
        </div>
    @endif

    <button type="button" class="geddes-btn" onclick="history.go(-1);">Back to Search Results</button>
</div>
@endsection
