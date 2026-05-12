@extends('layouts.stcecilias')

@section('title', $recordTitle . " — St Cecilia's Hall")

@section('body_class', 'record')

@section('content')
    @php
        $filtersList = array_keys(config('skylight.filters', []));
        $schema = config('skylight.schema_links', []);

        $titleFieldName = str_replace('.', '', $fieldMappings['Title'] ?? '');
        $makerFieldName = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
        $accNoField = str_replace('.', '', $fieldMappings['Accession Number'] ?? '');
        $imageUriField = str_replace('.', '', $fieldMappings['ImageURI'] ?? '');
        $bitstreamFieldName = str_replace('.', '', $fieldMappings['Bitstream'] ?? '');

        $accno = '';
        if (isset($record[$accNoField])) {
            $accnoVal = is_array($record[$accNoField]) ? ($record[$accNoField][0] ?? '') : $record[$accNoField];
            $accno = $accnoVal;
        }

        // Walk the bitstream pipe-delimited entries to discover a IIIF JSON
        // manifest. The legacy site renders a Universal Viewer / Mirador / LUNA
        // / IIIF / CC-BY badge row when one is present.
        $manifest = null;
        $jsonLink = '';
        if (isset($record[$bitstreamFieldName])) {
            $bitstreamArray = is_array($record[$bitstreamFieldName]) ? $record[$bitstreamFieldName] : [$record[$bitstreamFieldName]];
            foreach ($bitstreamArray as $bs) {
                $bSegments = explode('##', $bs);
                if (count($bSegments) < 5) {
                    continue;
                }
                $bFilename = $bSegments[1] ?? '';
                $bHandle = $bSegments[3] ?? '';
                $bSeq = $bSegments[4] ?? '';
                $bHandleId = preg_replace('/^.*\//', '', $bHandle);

                if (str_contains(strtolower($bFilename), '.json')) {
                    $manifest = url("/stcecilias/record/{$bHandleId}/{$bSeq}/{$bFilename}");
                    $jsonLink .= '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" rel="noopener" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a target="_blank" rel="noopener" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest=' . $manifest . '" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" target="_blank" rel="noopener" class="lunalogo" title="View in LUNA"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="' . $manifest . '" target="_blank" rel="noopener" class="iiiflogo" title="IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="noopener" class="ccbylogo" title="All images CC-BY"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    break;
                }
            }
        }
    @endphp

    <div class="container-fluid record-page">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 record-main" itemscope itemtype="http://schema.org/CreativeWork">
                <h1 class="itemtitle" itemprop="name">{{ $recordTitle }}</h1>

                <div class="tags makers">
                    @if(isset($record[$makerFieldName]) && !empty($record[$makerFieldName]))
                        @php $makers = is_array($record[$makerFieldName]) ? $record[$makerFieldName] : [$record[$makerFieldName]]; @endphp
                        @foreach($makers as $maker)
                            @php
                                $origFilter = urlencode($maker);
                                $lowerFilter = urlencode(strtolower($maker));
                            @endphp
                            <a class="maker" href="{{ url('/stcecilias/search/*:*/Maker:%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $maker }}">{{ $maker }}</a>
                        @endforeach
                    @endif
                </div>

                {{-- IIIF / Mirador manifest viewer --}}
                @if($manifest)
                    <div class="img-container">
                        <iframe class="img-frame" src="{{ url('/stcecilias/mirador') }}?manifest={{ urlencode($manifest) }}" height="600" width="100%" title="Image Showcase"></iframe>
                    </div>

                    <div class="json-link">
                        <p>{!! $jsonLink !!}</p>
                        <p>(Note: Each icon above opens in a new tab.)</p>
                    </div>
                @endif

                {{-- OpenSeadragon fallback for a single main image when there's no IIIF manifest --}}
                @if(!$manifest && !empty($bitstreams['main_image']))
                    <div class="main-image">
                        <div id="openseadragon" style="width: 100%; height: 600px;"></div>
                        @if(!empty($bitstreams['main_image']['description']))
                            <div><p><i>Image: {{ $bitstreams['main_image']['description'] }}</i></p></div>
                        @endif
                        <script type="text/javascript">
                            OpenSeadragon({
                                id: "openseadragon",
                                prefixUrl: "{{ asset('collections/stcecilia/images/buttons') }}/",
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

                {{-- Audio --}}
                @if(!empty($bitstreams['audio']))
                    <div class="record_bitstreams audio-block">
                        <h2>Audio</h2>
                        @foreach($bitstreams['audio'] as $audio)
                            <div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject"></div>
                            <audio controls>
                                <source src="{{ $audio['uri'] }}" type="audio/mpeg">Audio loading...
                            </audio>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                @endif

                {{-- Video --}}
                @if(!empty($bitstreams['video']))
                    <div class="record_bitstreams video-block">
                        <h2>Video</h2>
                        @foreach($bitstreams['video'] as $video)
                            @php $ext = strtolower(pathinfo($video['filename'] ?? '', PATHINFO_EXTENSION) ?: 'mp4'); @endphp
                            <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>
                            <div class="flowplayer" data-analytics="{{ config('skylight.ga_code') }}" title="{{ $recordTitle }}: {{ $video['filename'] ?? '' }}">
                                <video preload="auto" loop controls width="100%" height="auto">
                                    <source src="{{ $video['uri'] }}" type="video/{{ $ext }}">Video loading...
                                </video>
                            </div>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                @endif

                {{-- Record metadata --}}
                <div class="record-content">
                    <div class="full-metadata">
                        <table class="record-metadata">
                            <tbody>
                                @foreach($recordDisplay as $key)
                                    @php
                                        $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                                    @endphp
                                    @if($element !== '' && isset($record[$element]) && !empty($record[$element]))
                                        <tr>
                                            <td>
                                                <h4>{{ $key }}</h4>
                                                @php
                                                    $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                                                @endphp
                                                @foreach($values as $idx => $metadataValue)
                                                    @php
                                                        $metadataValue = str_replace('|', "\u{00A0}", $metadataValue);
                                                        $schemaAttr = $schema[$key] ?? null;
                                                    @endphp
                                                    @if(in_array($key, $filtersList))
                                                        @php
                                                            $origFilter = urlencode($metadataValue);
                                                            $lowerFilter = urlencode(strtolower($metadataValue));
                                                        @endphp
                                                        @if($schemaAttr)
                                                            <span itemprop="{{ $schemaAttr }}"><a href="{{ url('/stcecilias/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a></span>
                                                        @else
                                                            <a href="{{ url('/stcecilias/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>
                                                        @endif
                                                    @else
                                                        @if($schemaAttr)
                                                            <span itemprop="{{ $schemaAttr }}">{{ $metadataValue }}</span>
                                                        @else
                                                            {{ $metadataValue }}
                                                        @endif
                                                    @endif
                                                    @if($idx < count($values) - 1)<br>@endif
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

                {{-- PDF download links --}}
                @if(!empty($bitstreams['pdf']))
                    <div class="record_pdfs">
                        @foreach($bitstreams['pdf'] as $pdf)
                            <p>Click <a href="{{ $pdf['uri'] }}" target="_blank" rel="noopener">here</a> to download. <span class="bitstream_size">({{ $pdf['size'] ?? '' }})</span></p>
                        @endforeach
                    </div>
                @endif

                <input type="button" value="Back to Search Results" class="backbtn btn btn-default" onClick="history.go(-1);">
            </div>

            {{-- Related items sidebar --}}
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 record-sidebar">
                <h4>Related Items</h4>
                <ul class="related">
                    @if(!empty($relatedItems))
                        @foreach($relatedItems as $rIndex => $relDoc)
                            @php
                                $relTitle = $relDoc[$titleFieldName][0] ?? ($relDoc[$titleFieldName] ?? 'Untitled');
                                if (is_array($relTitle)) { $relTitle = $relTitle[0] ?? 'Untitled'; }
                                $relId = $relDoc['id'] ?? '';
                                if (is_array($relId)) { $relId = $relId[0] ?? ''; }
                            @endphp
                            <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                                <a class="related-record" href="{{ url('/stcecilias/record/' . $relId) }}" title="{{ $relTitle }}">{{ $relTitle }}</a>
                            </li>
                        @endforeach
                    @else
                        <li>None.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
