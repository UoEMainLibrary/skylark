@extends('layouts.mimed')

@section('title', $recordTitle . ' - MIMEd')

@section('content')
@php
    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $accNoField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
    $titleFieldKey = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $link_bitstream = config('skylight.link_bitstream', true);
    $accno = '';
    $manifest = '';

    if (isset($record[$accNoField])) {
        $accValues = is_array($record[$accNoField]) ? $record[$accNoField] : [$record[$accNoField]];
        $accno = $accValues[0] ?? '';
    }

    // Find JSON manifest from bitstreams
    if (isset($record[$bitstreamField])) {
        $bitstreamList = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];
        foreach ($bitstreamList as $bs) {
            $segments = explode('##', $bs);
            $bFilename = $segments[1] ?? '';
            $bHandle = $segments[3] ?? '';
            $bSeq = $segments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', $bHandle);
            if (str_contains($bFilename, '.json') || str_contains($bFilename, '.JSON')) {
                $manifest = url("/mimed/record/{$bHandleId}/{$bSeq}/{$bFilename}");
            }
        }
    }

    $jsonLink = '';
    if ($manifest) {
        $jsonLink .= '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
        $jsonLink .= '<span class="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest=' . $manifest . '" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
        if ($accno) {
            $jsonLink .= '<span class="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" class="lunalogo" title="View in LUNA" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
        }
        $jsonLink .= '<span class="json-link-item"><a href="' . $manifest . '" target="_blank" class="iiiflogo" title="IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
        $jsonLink .= '<span class="json-link-item"><a href="https://creativecommons.org/licenses/by/3.0/" class="ccbylogo" title="All images CC-BY" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
    }

    $schema = config('skylight.schema_links', []);
@endphp

<div class="col-main">
<div class="content">
    <h1 class="itemtitle">{{ $recordTitle }}</h1>
    <div itemscope itemtype="http://schema.org/CreativeWork">

    <div class="tags">
        @if(isset($record[$authorField]))
            @php $authors = is_array($record[$authorField]) ? $record[$authorField] : [$record[$authorField]]; @endphp
            @foreach($authors as $author)
                @php
                    $origFilter = urlencode($author);
                    $lowerFilter = urlencode(strtolower($author));
                @endphp
                <a class="maker" href="{{ url('/mimed/search/*:*/Maker:%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $author }}">{{ $author }}</a>
            @endforeach
        @endif
    </div>

    @if($manifest)
        <div class="img-container">
            <iframe class="img-frame" src="{{ url('/mimed/mirador') }}?manifest={{ urlencode($manifest) }}" height="100%" width="100%" title="Image Showcase"></iframe>
        </div>

        <div class="json-link">
            <p>{!! $jsonLink !!}</p>
            <p>(Note: Each icon above opens in a new tab.)</p>
        </div>
    @endif

    <div class="record-content">
    <div class="full-metadata">
        <table>
            <tbody>
            @foreach($recordDisplay as $key)
                @php
                    $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                @endphp
                @if(isset($record[$element]) && !empty($record[$element]))
                    <tr><td{!! $key === 'Maker' ? ' class="first"' : '' !!}><h4>{{ $key }}</h4>@php $values = is_array($record[$element]) ? $record[$element] : [$record[$element]]; @endphp
@foreach($values as $index => $metadatavalue)
@php $metadatavalue = str_replace('|', "\u{00A0}", $metadatavalue); @endphp
@if(in_array($key, $filters))
@php
    $origFilter = urlencode($metadatavalue);
    $lowerFilter = urlencode(strtolower($metadatavalue));
    $schemaAttr = $schema[$key] ?? null;
@endphp
@if($schemaAttr)<span itemprop="{{ $schemaAttr }}"><a href="{{ url('/mimed/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a></span>@else<a href="{{ url('/mimed/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a>@endif
@else
@php $schemaAttr = $schema[$key] ?? null; @endphp
@if($schemaAttr)<span itemprop="{{ $schemaAttr }}">{{ $metadatavalue }}</span>@else{{ $metadatavalue }}@endif
@endif
@if($index < count($values) - 1); @endif
@endforeach</td></tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    </div>

    {{-- Audio --}}
    @if(!empty($bitstreams['audio']))
        <div class="record_bitstreams">
            <h2>Audio</h2>
            @foreach($bitstreams['audio'] as $audio)
                <audio controls>
                    <source src="{{ $audio['uri'] }}" type="audio/mpeg">Audio loading...</source>
                </audio>
            @endforeach
        </div>
    @endif

    {{-- Video --}}
    @if(!empty($bitstreams['video']))
        <div class="record_bitstreams">
            <h2>Video</h2>
            @foreach($bitstreams['video'] as $video)
                <video preload="auto" loop width="100%" height="auto" controls>
                    <source src="{{ $video['uri'] }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">Video loading...</source>
                </video>
            @endforeach
        </div>
    @endif

    <div class="clearfix"></div>
    </div>
</div>
</div>
<div class="col-sidebar">
    <h4>Related Items</h4>
    <ul class="related">
        @if(count($relatedItems) > 0)
            @foreach($relatedItems as $index => $doc)
                <li @class(['first' => $index === 0, 'last' => $index === count($relatedItems) - 1])>
                    @php
                        $relTitle = 'No title';
                        if (isset($doc[$titleFieldKey])) {
                            $relTitleVal = is_array($doc[$titleFieldKey]) ? ($doc[$titleFieldKey][0] ?? 'No title') : $doc[$titleFieldKey];
                            $relTitle = $relTitleVal;
                        }
                        $relId = $doc['id'] ?? '';
                        if (empty($relId) && isset($doc['handle'])) {
                            $handleStr = is_array($doc['handle']) ? $doc['handle'][0] : $doc['handle'];
                            $handleParts = explode('/', trim($handleStr));
                            $relId = end($handleParts);
                        }
                    @endphp
                    <a class="related-record" href="{{ url('/mimed/record/' . $relId) }} " title="{{ $relTitle }}">{{ $relTitle }}</a>
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
    </ul>
</div>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
@endsection
