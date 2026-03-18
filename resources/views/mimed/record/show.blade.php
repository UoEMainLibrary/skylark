@extends('layouts.mimed')

@section('title', $recordTitle . ' - Musical Instrument Museums Edinburgh')

@section('content')
<div class="col-main">
    <div class="content">
        <h1 class="itemtitle">{{ $recordTitle }}</h1>
        <div itemscope itemtype="http://schema.org/CreativeWork">

            {{-- Maker tags --}}
            @php
                $makerField = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
                $filters = array_keys(config('skylight.filters', []));
            @endphp

            <div class="tags">
                @if(isset($record[$makerField]) && !empty($record[$makerField]))
                    @php $makers = is_array($record[$makerField]) ? $record[$makerField] : [$record[$makerField]]; @endphp
                    @foreach($makers as $maker)
                        @php
                            $origFilter = urlencode($maker);
                            $lowerFilter = urlencode(strtolower($maker));
                        @endphp
                        <a class="maker" href="{{ url('/mimed/search/*:*/Maker:%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $maker }}">{{ $maker }}</a>
                    @endforeach
                @endif
            </div>

            {{-- IIIF Image Viewer (Mirador) --}}
            @php
                $imageUriField = str_replace('.', '', $fieldMappings['ImageUri'] ?? '');
                $accNoField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
                $bitstreamFieldName = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');
                $accno = '';
                $manifest = null;
                $jsonLink = '';

                if (isset($record[$accNoField])) {
                    $accnoVal = is_array($record[$accNoField]) ? $record[$accNoField][0] : $record[$accNoField];
                    $accno = $accnoVal;
                }

                if (isset($record[$bitstreamFieldName])) {
                    $bitstreamArray = is_array($record[$bitstreamFieldName]) ? $record[$bitstreamFieldName] : [$record[$bitstreamFieldName]];
                    foreach ($bitstreamArray as $bs) {
                        $bSegments = explode('##', $bs);
                        if (count($bSegments) >= 5) {
                            $bFilename = $bSegments[1] ?? '';
                            $bHandle = $bSegments[3] ?? '';
                            $bSeq = $bSegments[4] ?? '';
                            $bHandleId = preg_replace('/^.*\//', '', $bHandle);

                            if (str_contains(strtolower($bFilename), '.json')) {
                                $manifest = url("/mimed/record/{$bHandleId}/{$bSeq}/{$bFilename}");
                                $jsonLink .= '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                                $jsonLink .= '<span class="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest=' . $manifest . '" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                                $jsonLink .= '<span class="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" class="lunalogo" title="View in LUNA" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                                $jsonLink .= '<span class="json-link-item"><a href="' . $manifest . '" target="_blank" class="iiiflogo" title="IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                                $jsonLink .= '<span class="json-link-item"><a href="https://creativecommons.org/licenses/by/3.0/" class="ccbylogo" title="All images CC-BY" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                            }
                        }
                    }
                }
            @endphp

            @if(isset($record[$imageUriField]) && !empty($record[$imageUriField]) && $manifest)
                <div class="img-container">
                    <iframe class="img-frame" src="{{ url('/mimed/mirador') }}?manifest={{ urlencode($manifest) }}" height="100%" width="100%" title="Image Showcase"></iframe>
                </div>

                <div class="json-link">
                    <p>{!! $jsonLink !!}</p>
                    <p>(Note: Each icon above opens in a new tab.)</p>
                </div>
            @endif

            {{-- Main Image (OpenSeadragon fallback for non-Mirador records) --}}
            @if(!$manifest && !empty($bitstreams['main_image']))
                <div class="main-image">
                    <div id="openseadragon" style="width: 100%; height: 600px;"></div>
                    @if(!empty($bitstreams['main_image']['description']))
                        <div><p><i>Image: {{ $bitstreams['main_image']['description'] }}</i></p></div>
                    @endif
                    <script type="text/javascript">
                        OpenSeadragon({
                            id: "openseadragon",
                            prefixUrl: "{{ asset('collections/mimed/images/buttons') }}/",
                            preserveViewport: false,
                            visibilityRatio: 1,
                            minZoomLevel: 0,
                            defaultZoomLevel: 0,
                            panHorizontal: true,
                            sequenceMode: true,
                            tileSources: [{
                                type: 'image',
                                url: '{{ $bitstreams['main_image']['uri'] }}'
                            }]
                        });
                    </script>
                </div>
                <div class="clearfix"></div>
            @endif

            {{-- Record metadata --}}
            <div class="record-content">
                <div class="full-metadata">
                    <table>
                        <tbody>
                        @foreach($recordDisplay as $key)
                            @php
                                $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                            @endphp
                            @if(isset($record[$element]) && !empty($record[$element]))
                                <tr>
                                    <td @if($key === 'Maker') class="first" @endif>
                                        <h4>{{ $key }}</h4>
                                        @php
                                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                                        @endphp
                                        @foreach($values as $idx => $metadataValue)
                                            @php $metadataValue = str_replace('|', "\u{00A0}", $metadataValue); @endphp
                                            @if(in_array($key, $filters))
                                                @php
                                                    $origFilter = urlencode($metadataValue);
                                                    $lowerFilter = urlencode(strtolower($metadataValue));
                                                @endphp
                                                <a href="{{ url('/mimed/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>
                                            @else
                                                {{ $metadataValue }}
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

                <div class="clearfix"></div>
            </div>

            {{-- Audio and Video --}}
            @if(!empty($bitstreams['audio']) || !empty($bitstreams['video']))
                <div class="record_bitstreams">
                    @if(!empty($bitstreams['audio']))
                        <h2>Audio</h2>
                        @foreach($bitstreams['audio'] as $audio)
                            <audio controls>
                                <source src="{{ $audio['uri'] }}" type="audio/mpeg">Audio loading...</source>
                            </audio>
                        @endforeach
                    @endif

                    @if(!empty($bitstreams['video']))
                        <h2>Video</h2>
                        @foreach($bitstreams['video'] as $video)
                            <video preload="auto" loop width="100%" height="auto" controls>
                                <source src="{{ $video['uri'] }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">Video loading...</source>
                            </video>
                        @endforeach
                    @endif
                </div>
                <div class="clearfix"></div>
            @endif

            {{-- PDF files --}}
            @if(!empty($bitstreams['pdf']))
                @foreach($bitstreams['pdf'] as $pdf)
                    <p>Click <a href="{{ $pdf['uri'] }}" target="_blank">here</a> to download. (<span class="bitstream_size">{{ $pdf['size'] }}</span>)</p>
                @endforeach
            @endif
        </div>
    </div>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>

<div class="col-sidebar">
    {{-- Related items --}}
    <h4>Related Items</h4>
    <ul class="related">
        @if(!empty($relatedItems) && count($relatedItems) > 0)
            @php
                $titleFieldName = str_replace('.', '', $fieldMappings['Title'] ?? '');
                $authorFieldName = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
            @endphp
            @foreach($relatedItems as $rIndex => $relDoc)
                @php
                    $relTitle = $relDoc[$titleFieldName][0] ?? 'Untitled';
                    $relId = $relDoc['id'] ?? '';
                    if (is_array($relId)) { $relId = $relId[0] ?? ''; }
                @endphp
                <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ url('/mimed/record/' . $relId) }}" title="{{ $relTitle }}">{{ $relTitle }}</a>
                    <div class="tags">
                        @if(isset($relDoc[$authorFieldName]) && !empty($relDoc[$authorFieldName]))
                            @php $relAuthors = is_array($relDoc[$authorFieldName]) ? $relDoc[$authorFieldName] : [$relDoc[$authorFieldName]]; @endphp
                            @foreach($relAuthors as $relAuthor)
                                @php
                                    $relOrigFilter = urlencode($relAuthor);
                                    $relLowerFilter = urlencode(strtolower($relAuthor));
                                @endphp
                                <a href="{{ url('/mimed/search/*:*/Maker:%22' . $relLowerFilter . '+%7C%7C%7C+' . $relOrigFilter . '%22') }}">{{ $relAuthor }}</a>
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
