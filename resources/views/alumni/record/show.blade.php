@extends('layouts.alumni')

@section('title', '"'.$recordTitle.'"')

@section('content')
@php
    $subjectField = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $recordTitleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
    // Alumni does not expose an Author-labelled field mapping in recorddisplay;
    // the legacy controller falls back to `dccontributorauthoren` for the
    // related-items byline, so we mirror that here.
    $relatedAuthorField = 'dccontributorauthoren';
    $dateField = str_replace('.', '', $fieldMappings['Year'] ?? '');
    $filters = array_keys(config('skylight.filters', []));
    $staticPages = config('skylight.static_pages', []);
@endphp

<div class="col-main">
    <h1 class="itemtitle">{{ $recordTitle }}</h1>

    <div class="tags">
        @if($subjectField !== '' && isset($record[$subjectField]))
            @php $subjects = is_array($record[$subjectField]) ? $record[$subjectField] : [$record[$subjectField]]; @endphp
            @foreach($subjects as $subject)
                @php
                    $origFilter = urlencode($subject);
                    $lowerFilter = urlencode(strtolower($subject));
                @endphp
                <a href="{{ \App\Support\CollectionUrl::url('search/*:*') }}/%22Subject{{ $lowerFilter }}+%7C%7C%7C+{{ $origFilter }}%22">{{ $subject }}</a>
            @endforeach
        @endif
    </div>

    <div class="content">
        <table>
            <tbody>
            @foreach($recordDisplay as $key)
                @php $element = str_replace('.', '', $fieldMappings[$key] ?? ''); @endphp
                @if($element !== '' && isset($record[$element]))
                    <tr>
                        <th>{{ $key }}</th>
                        <td>
                            @php
                                $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                                $count = count($values);
                            @endphp
                            @foreach($values as $index => $metadataValue)
                                @if(in_array($key, $filters))
                                    @if($key === 'Collection' && isset($staticPages[$metadataValue]))
                                        @php
                                            $origFilter = urlencode($metadataValue);
                                            $lowerFilter = urlencode(strtolower($metadataValue));
                                            $staticPageSlug = $staticPages[$metadataValue];
                                        @endphp
                                        {{ $metadataValue }}: <a href="{{ \App\Support\CollectionUrl::url('search/*:*') }}/{{ $metadataValue }}:%22{{ $lowerFilter }}+%7C%7C%7C+{{ $origFilter }}%22/Collection:%22{{ $lowerFilter }}+%7C%7C%7C+{{ $origFilter }}%22"><i class="fa fa-search fa-lg">&nbsp;</i>See All Records</a> | <a href="{{ \App\Support\CollectionUrl::url($staticPageSlug) }}"><i class="fa fa-info-circle fa-lg">&nbsp;</i>More Info</a>
                                    @endif
                                @else
                                    {{ $metadataValue }}
                                @endif
                                @if($index < $count - 1); @endif
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
    </div>
</div>

<div class="col-sidebar">
    <h4>Related Items</h4>
    <ul class="related">
        @if(!empty($relatedItems) && count($relatedItems) > 0)
            @foreach($relatedItems as $rIndex => $relDoc)
                @php
                    $relTitle = $relDoc[$recordTitleField][0] ?? 'Untitled';
                    $relId = $relDoc['id'] ?? '';
                    if (is_array($relId)) { $relId = $relId[0] ?? ''; }
                    $relDate = ($dateField !== '' && isset($relDoc[$dateField])) ? (is_array($relDoc[$dateField]) ? $relDoc[$dateField][0] : $relDoc[$dateField]) : null;
                @endphp
                <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ \App\Support\CollectionUrl::url('record/'.$relId) }}" title="{{ $relTitle }}">{{ $relTitle }}@if($relDate) ({{ $relDate }})@endif</a>
                    <div class="tags">
                        @if(isset($relDoc[$relatedAuthorField]))
                            @php $relAuthors = is_array($relDoc[$relatedAuthorField]) ? $relDoc[$relatedAuthorField] : [$relDoc[$relatedAuthorField]]; @endphp
                            @foreach($relAuthors as $relAuthor)
                                @php
                                    $origFilter = urlencode(ucwords($relAuthor));
                                    $lowerFilter = urlencode(strtolower($relAuthor));
                                @endphp
                                <a href="{{ \App\Support\CollectionUrl::url('search/*:*') }}/Artist:%22{{ $lowerFilter }}+%7C%7C%7C+{{ $origFilter }}%22" title="{{ $relAuthor }}">{{ $relAuthor }}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
    </ul>
</div>
@endsection
