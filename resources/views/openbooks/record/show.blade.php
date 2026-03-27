@extends('layouts.openbooks')

@section('title', $recordTitle.' - '.config('skylight.fullname'))

@section('content')
@php
    $creatorFilterKey = collect(['Author', 'Maker', 'Artist'])->first(fn ($k) => array_key_exists($k, config('skylight.filters', []))) ?? 'Author';
    $filters = array_keys(config('skylight.filters', []));
    $schema = config('skylight.schema_links', []);
    $subjectField = str_replace('.', '', $fieldMappings['Subject'] ?? '');
    $linkField = str_replace('.', '', $fieldMappings['Link'] ?? '');
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
                    $manifest = \App\Support\CollectionUrl::url("record/{$bHandleId}/{$bSeq}/{$bFilename}");
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
<div class="content">
        <h1 class="itemtitle">{{ $recordTitle }}</h1>
        <div itemscope itemtype="http://schema.org/CreativeWork">

            {{-- Skylight openbooks record.php: Subject tags under title --}}
            <div class="tags">
                @if($subjectField !== '' && isset($record[$subjectField]) && ! empty($record[$subjectField]))
                    @php
                        $subjects = is_array($record[$subjectField]) ? $record[$subjectField] : [$record[$subjectField]];
                    @endphp
                    @foreach($subjects as $subject)
                        @php
                            $origFilter = urlencode($subject);
                            $lowerFilter = urlencode(strtolower($subject));
                        @endphp
                        <a href="{{ $collectionUrl('search/*:*/Subject:%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}">{{ str_replace('|', "\u{00A0}", $subject) }}</a>
                    @endforeach
                @endif
            </div>

            {{-- Skylight: table with th (label) / td (values), dashed borders from style.css --}}
            <table>
                <tbody>
                @foreach($recordDisplay as $key)
                    @php
                        $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                    @endphp
                    @if($element !== '' && isset($record[$element]) && ! empty($record[$element]))
                        <tr>
                            <th>{{ $key }}</th>
                            <td>
                                @php
                                    $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                                @endphp
                                @foreach($values as $idx => $metadataValue)
                                    @php
                                        $metadataValue = str_replace('|', "\u{00A0}", $metadataValue);
                                        $schemaAttr = $schema[$key] ?? null;
                                    @endphp
                                    @if(in_array($key, $filters, true))
                                        @php
                                            $origFilter = urlencode($metadataValue);
                                            $lowerFilter = urlencode(strtolower($metadataValue));
                                        @endphp
                                        @if($schemaAttr)
                                            <span itemprop="{{ $schemaAttr }}"><a href="{{ $collectionUrl('search/*:*/'.$key.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a></span>
                                        @else
                                            <a href="{{ $collectionUrl('search/*:*/'.$key.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>
                                        @endif
                                    @else
                                        @if($schemaAttr)
                                            <span itemprop="{{ $schemaAttr }}">{{ $metadataValue }}</span>
                                        @else
                                            {{ $metadataValue }}
                                        @endif
                                    @endif
                                    @if($idx < count($values) - 1){{ '; ' }}@endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if($linkField !== '' && isset($record[$linkField]) && ! empty($record[$linkField]))
                    @php
                        $linkValues = is_array($record[$linkField]) ? $record[$linkField] : [$record[$linkField]];
                    @endphp
                    @foreach($linkValues as $idx => $uri)
                        @if(str_contains(strtolower((string) $uri), 'hdl.handle.net'))
                            @continue
                        @endif
                        <tr>
                            <th>Link</th>
                            <td>
                                @if(str_contains(strtolower((string) $uri), 'discovered.ed.ac.uk'))
                                    <a href="{{ $uri }}" title="Link to Library catalogue entry" target="_blank" rel="noopener noreferrer">Library Catalogue Entry<span class="visually-hidden"> (opens in a new tab)</span></a>
                                @else
                                    <a href="{{ $uri }}" title="Link to {{ $uri }}" target="_blank" rel="noopener noreferrer">{{ $uri }}<span class="visually-hidden"> (opens in a new tab)</span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>

            {{-- Skylight: record_bitstreams wraps viewers, images, PDF, audio, video --}}
            <div class="record_bitstreams">

            @if(isset($record[$imageUriField]) && ! empty($record[$imageUriField]) && $manifest)
                <div class="img-container">
                    <iframe class="img-frame" src="{{ $collectionUrl('mirador') }}?manifest={{ urlencode($manifest) }}" height="100%" width="100%" title="Image Showcase"></iframe>
                </div>

                <div class="json-link">
                    <p>{!! $jsonLink !!}</p>
                    <p>(Note: Each icon above opens in a new tab.)</p>
                </div>
            @endif

            @if(! $manifest && ! empty($bitstreams['main_image']))
                <div class="main-image">
                    <div id="openseadragon" style="width: 100%; height: 600px;"></div>
                    @if(! empty($bitstreams['main_image']['description']))
                        <div><p><i>Image: {{ $bitstreams['main_image']['description'] }}</i></p></div>
                    @endif
                    <script type="text/javascript">
                        OpenSeadragon({
                            id: "openseadragon",
                            prefixUrl: "{{ asset('collections/openbooks/images/buttons') }}/",
                            preserveViewport: false,
                            visibilityRatio: 1,
                            minZoomLevel: 0,
                            defaultZoomLevel: 0,
                            panHorizontal: true,
                            sequenceMode: true,
                            tileSources: [{
                                type: 'image',
                                url: @json($collectionUrl(ltrim($bitstreams['main_image']['uri'], '/')))
                            }]
                        });
                    </script>
                </div>
                <div class="clearfix"></div>
            @endif

            @if(! empty($bitstreams['images']))
                @foreach($bitstreams['images'] as $img)
                    <div class="bitstream-image">
                        <a title="{{ $recordTitle }}" class="fancybox" rel="group" href="{{ $collectionUrl(ltrim($img['uri'], '/')) }}">
                            <img id="second-image" class="record-image" src="{{ $collectionUrl(ltrim($img['uri'], '/')) }}" alt="">
                        </a>
                    </div>
                @endforeach
            @endif

            @if(! empty($bitstreams['pdf']))
                @foreach($bitstreams['pdf'] as $pdf)
                    @php
                        $pdfViewerSrc = asset('collections/openbooks/addons/PDF_Viewer/pdf_reader.php');
                        $pdfAbsolute = $collectionUrl(ltrim($pdf['uri'], '/'));
                    @endphp
                    <br>
                    <iframe src="{{ $pdfViewerSrc }}?url={{ urlencode($pdfAbsolute) }}" title="PDF Viewer" width="700" height="900"></iframe>
                    <br>
                    Click <a href="{{ $collectionUrl(ltrim($pdf['uri'], '/')) }}" target="_blank" rel="noopener noreferrer">{{ $pdf['filename'] }}<span class="visually-hidden"> (opens in a new tab)</span></a> to download.
                    (<span class="bitstream_size">{{ $pdf['size'] }}</span>)<br><br>
                @endforeach
            @endif

            @if(! empty($bitstreams['audio']))
                @foreach($bitstreams['audio'] as $audio)
                    <audio controls>
                        <source src="{{ $collectionUrl(ltrim($audio['uri'], '/')) }}" type="audio/mpeg">Audio loading...</source>
                    </audio>
                @endforeach
            @endif

            @if(! empty($bitstreams['video']))
                @foreach($bitstreams['video'] as $video)
                    <video preload="auto" loop width="100%" height="auto" controls>
                        <source src="{{ $collectionUrl(ltrim($video['uri'], '/')) }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">Video loading...</source>
                    </video>
                @endforeach
            @endif

            <div class="clearfix"></div>
            </div>{{-- end record_bitstreams --}}

        </div>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
@endsection

@section('sidebar')
    <h4>Related Items</h4>
    <ul class="related">
        @if(! empty($relatedItems) && count($relatedItems) > 0)
            @php
                $titleFieldName = str_replace('.', '', $fieldMappings['Title'] ?? '');
                $authorFieldName = str_replace('.', '', $fieldMappings['Author'] ?? '');
            @endphp
            @foreach($relatedItems as $rIndex => $relDoc)
                @php
                    $relTitle = $relDoc[$titleFieldName][0] ?? 'Untitled';
                    $relId = $relDoc['id'] ?? '';
                    if (is_array($relId)) {
                        $relId = $relId[0] ?? '';
                    }
                @endphp
                <li @class(['first' => $rIndex === 0, 'last' => $rIndex === count($relatedItems) - 1])>
                    <a class="related-record" href="{{ $collectionUrl('record/'.$relId) }}" title="{{ $relTitle }}">{{ $relTitle }}</a>

                    <div class="tags">
                        @if($authorFieldName !== '' && isset($relDoc[$authorFieldName]) && ! empty($relDoc[$authorFieldName]))
                            @php
                                $relAuthors = is_array($relDoc[$authorFieldName]) ? $relDoc[$authorFieldName] : [$relDoc[$authorFieldName]];
                            @endphp
                            @foreach($relAuthors as $author)
                                {!! $loop->first ? '' : ' ' !!}
                                @php
                                    $origFilter = urlencode($author);
                                    $lowerFilter = urlencode(strtolower($author));
                                @endphp
                                <a href="{{ $collectionUrl('search/*:*/'.$creatorFilterKey.':%22'.$lowerFilter.'+%7C%7C%7C+'.$origFilter.'%22') }}">{{ $author }}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
    </ul>
@endsection
