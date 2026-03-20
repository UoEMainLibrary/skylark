@extends('layouts.art')

@section('title', $recordTitle . ' - University of Edinburgh Art Collection')

@section('content')
@php
    $authorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
    $artistField = str_replace('.', '', $fieldMappings['Artist'] ?? '');
    $dateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
    $accNoField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
    $bitstreamFieldName = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
    $permalinkField = str_replace('.', '', $fieldMappings['Permalink'] ?? '');
    $sketchfabField = str_replace('.', '', $fieldMappings['SketchFabURI'] ?? '');
    $tagsField = str_replace('.', '', $fieldMappings['Tags'] ?? '');
    $filters = array_keys(config('skylight.filters', []));
    $schema = config('skylight.schema_links', []);

    $accno = '';
    $manifest = null;
    $jsonLink = '';

    if (isset($record[$accNoField])) {
        $accnoVal = is_array($record[$accNoField]) ? $record[$accNoField][0] : $record[$accNoField];
        $accno = $accnoVal;
    }

    if (isset($record[$bitstreamFieldName])) {
        $bitstreamArray = is_array($record[$bitstreamFieldName]) ? $record[$bitstreamFieldName] : [$record[$bitstreamFieldName]];
        $sortedBitstreams = [];
        foreach ($bitstreamArray as $bs) {
            $bSegments = explode('##', $bs);
            if (count($bSegments) >= 5) {
                $sortedBitstreams[$bSegments[4]] = $bs;
            }
        }
        ksort($sortedBitstreams);

        foreach ($sortedBitstreams as $bitstream) {
            $bSegments = explode('##', $bitstream);
            if (count($bSegments) >= 5) {
                $bFilename = $bSegments[1] ?? '';
                $bHandle = $bSegments[3] ?? '';
                $bSeq = $bSegments[4] ?? '';
                $bHandleId = preg_replace('/^.*\//', '', $bHandle);

                if (str_contains(strtolower($bFilename), '.json')) {
                    $manifest = url("/art/record/{$bHandleId}/{$bSeq}/{$bFilename}");
                    $jsonLink  = '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a target="_blank" href="' . url('/art/mirador') . '?manifest=' . urlencode($manifest) . '&display=full" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" class="lunalogo" title="View in LUNA" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="' . $manifest . '" target="_blank" class="iiiflogo" title="View IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                }
            }
        }
    }

    // Permalink authority links
    $viafvalue = '';
    $isnivalue = '';
    $lcvalue = '';
    $artistcount = 0;
    foreach ($recordDisplay as $key) {
        if ($key === 'Artist') { $artistcount++; }
    }
    if (isset($record[$permalinkField]) && $artistcount === 1) {
        $permalinks = is_array($record[$permalinkField]) ? $record[$permalinkField] : [$record[$permalinkField]];
        foreach ($permalinks as $pval) {
            if (str_contains($pval, 'viaf')) { $viafvalue = $pval; }
            elseif (str_contains($pval, 'isni')) { $isnivalue = $pval; }
            elseif (str_contains($pval, 'gov')) { $lcvalue = $pval; }
        }
    }
@endphp
<div class="row">
<div class="col-lg-9">
<div class="content record">
    <div itemscope itemtype="https://schema.org/CreativeWork">
        <div class="full-title">
            <h1 class="itemtitle">{{ $recordTitle }}
                @if(isset($record[$dateField]))
                    ({{ is_array($record[$dateField]) ? $record[$dateField][0] : $record[$dateField] }})
                @endif
            </h1>
            <div class="tags">
                @if(isset($record[$authorField]) && !empty($record[$authorField]))
                    @php $authors = is_array($record[$authorField]) ? $record[$authorField] : [$record[$authorField]]; @endphp
                    @foreach($authors as $author)
                        @php
                            $origFilter = urlencode($author);
                            $lowerFilter = urlencode(strtolower($author));
                        @endphp
                        <a class="artist" href="{{ url('/art/search/*:*/Artist:%22' . $lowerFilter . '%7C%7C%7C' . $origFilter . '%22') }}" title="{{ $author }}">{{ $author }}</a>
                    @endforeach
                @endif
            </div>
        </div>

        @if(isset($record[$imageUriField]) && !empty($record[$imageUriField]) && $manifest)
            <div class="img-container">
                <iframe class="img-frame" src="{{ url('/art/mirador') }}?manifest={{ urlencode($manifest) }}" height="100%" width="100%" title="Image Showcase"></iframe>
            </div>

            <div class="json-link">
                <p>{!! $jsonLink !!}</p>
                <p>(Note: Each icon above opens in a new tab.)</p>
            </div>
        @endif

        <div class="full-metadata">
            <table>
                <tbody>
                @foreach($recordDisplay as $key)
                    @php $element = str_replace('.', '', $fieldMappings[$key] ?? ''); @endphp
                    @if($key !== 'Permalink' && isset($record[$element]) && !empty($record[$element]))
                        <tr>
                            <th>{{ $key }}</th>
                            <td>
                                @php $values = is_array($record[$element]) ? $record[$element] : [$record[$element]]; @endphp
                                @foreach($values as $idx => $metadataValue)
                                    @php $schemaAttr = $schema[$key] ?? null; @endphp
                                    @if(in_array($key, $filters) && $key !== 'Artist')
                                        @php
                                            $origFilter = urlencode($metadataValue);
                                            $lowerFilter = urlencode(strtolower($metadataValue));
                                        @endphp
                                        @if($schemaAttr)<span itemprop="{{ $schemaAttr }}"><a href="{{ url('/art/search/*:*/' . $key . ':%22' . $lowerFilter . '%7C%7C%7C' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a></span>@else<a href="{{ url('/art/search/*:*/' . $key . ':%22' . $lowerFilter . '%7C%7C%7C' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>@endif
                                    @elseif($key === 'Artist')
                                        @php
                                            $viaf = $viafvalue ? '<a href="' . $viafvalue . '" title="' . $viafvalue . '" target="_blank"><sup>VIAF</sup></a>' : '';
                                            $isni = $isnivalue ? '<a href="' . $isnivalue . '" title="' . $isnivalue . '" target="_blank"><sup>ISNI</sup></a>' : '';
                                            $lc = $lcvalue ? '<a href="' . $lcvalue . '" title="' . $lcvalue . '" target="_blank"><sup>LC</sup></a>' : '';
                                        @endphp
                                        @if($schemaAttr)<span itemprop="{{ $schemaAttr }}">{!! $metadataValue . ' ' . $viaf . ' ' . $isni . ' ' . $lc !!}</span>@else{!! $metadataValue . ' ' . $viaf . ' ' . $isni . ' ' . $lc !!}@endif
                                    @else
                                        @if($schemaAttr)<span itemprop="{{ $schemaAttr }}">{{ $metadataValue }}</span>@else{{ $metadataValue }}@endif
                                    @endif
                                    @if($idx < count($values) - 1); @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>

    {{-- Sketchfab embed --}}
    @if(isset($record[$sketchfabField]) && !empty($record[$sketchfabField]))
        @php
            $sketchfabUri = is_array($record[$sketchfabField]) ? $record[$sketchfabField][0] : $record[$sketchfabField];
            $sketchfabHash = substr($sketchfabUri, -32);
            $sketchfabEmbed = 'https://sketchfab.com/models/' . $sketchfabHash . '/embed';
        @endphp
        <br>
        <div class="sketchfab-embed-wrapper">
            <iframe width="660" height="480" src="{{ $sketchfabEmbed }}" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
            <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;">
                <a href="{{ $sketchfabUri }}" target="blank">See {{ $recordTitle }} at Sketchfab</a>
            </p>
        </div>
    @endif

    {{-- Crowdsourced tags --}}
    @if(isset($record[$tagsField]) && !empty($record[$tagsField]))
        <div class="crowd-tags">
            <span class="crowd-title" title="User generated tags created through crowd sourcing games"><i class="fa fa-users fa-lg">&nbsp;</i>Tags:</span>
            @php $tags = is_array($record[$tagsField]) ? $record[$tagsField] : [$record[$tagsField]]; @endphp
            @foreach($tags as $tag)
                @php
                    $origFilter = urlencode($tag);
                    $lowerFilter = urlencode(strtolower($tag));
                @endphp
                <span class="crowd-tag"><a href="{{ url('/art/search/*:*/Tags:%22' . $lowerFilter . '%7C%7C%7C' . $origFilter . '%22') }}" title="{{ $tag }}"><i class="fa fa-tags fa-lg">&nbsp;</i>{{ $tag }}</a></span>
            @endforeach
        </div>
    @endif

    <div class="clearfix"></div>

    {{-- Audio and Video --}}
    @if(!empty($bitstreams['audio']) || !empty($bitstreams['video']))
        <div class="record_bitstreams">
            @if(!empty($bitstreams['audio']))
                @foreach($bitstreams['audio'] as $audio)
                    <br>.<br>
                    <audio controls>
                        <source src="{{ $audio['uri'] }}" type="audio/mpeg">Audio loading...</source>
                    </audio>
                @endforeach
            @endif
            @if(!empty($bitstreams['video']))
                @foreach($bitstreams['video'] as $video)
                    <br>.<br>
                    <video preload="auto" loop width="100%" height="auto" controls>
                        <source src="{{ $video['uri'] }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">Video loading...</source>
                    </video>
                @endforeach
            @endif
        </div>
        <div class="clearfix"></div>
    @endif

    <br/>
    <input type="button" value="Back to Search Results" class="backbtn record" onClick="history.go(-1);">
    <br/>
    <br/>
</div>
</div>

<div class="col-lg-3 search">
    <h4 class="related-header">Related Items</h4>
    <ul class="related">
        @if(!empty($relatedItems) && count($relatedItems) > 0)
            @php
                $titleFieldName = str_replace('.', '', $fieldMappings['Title'] ?? '');
                $relDateField = str_replace('.', '', $fieldMappings['Date'] ?? '');
                $relAuthorField = str_replace('.', '', $fieldMappings['Author'] ?? '');
            @endphp
            @foreach($relatedItems as $rIndex => $relDoc)
                @php
                    $relTitle = $relDoc[$titleFieldName][0] ?? 'Untitled';
                    $relId = $relDoc['id'] ?? '';
                    if (is_array($relId)) { $relId = $relId[0] ?? ''; }
                    $relDate = isset($relDoc[$relDateField]) ? (is_array($relDoc[$relDateField]) ? $relDoc[$relDateField][0] : $relDoc[$relDateField]) : null;
                @endphp
                <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ url('/art/record/' . $relId) }}" title="{{ $relTitle }}">{{ $relTitle }}@if($relDate) ({{ $relDate }})@endif</a>
                    <div class="tags">
                        @if(isset($relDoc[$relAuthorField]) && !empty($relDoc[$relAuthorField]))
                            @php $relAuthors = is_array($relDoc[$relAuthorField]) ? $relDoc[$relAuthorField] : [$relDoc[$relAuthorField]]; @endphp
                            @foreach($relAuthors as $relAuthor)
                                @php
                                    $relOrigFilter = urlencode($relAuthor);
                                    $relLowerFilter = urlencode(strtolower($relAuthor));
                                @endphp
                                <a href="{{ url('/art/search/*:*/Artist:%22' . $relLowerFilter . '%7C%7C%7C' . $relOrigFilter . '%22') }}" title="{{ $relAuthor }}">{{ $relAuthor }}</a>
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
</div>
@endsection
