@extends('layouts.mimed-catalogue')

@section('title', $recordTitle . ' - Musical Instrument Museums Edinburgh')

@section('head')
    @if(!empty($bitstreams['main_image']))
        <script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>
    @endif
@endsection

@section('content')
<div class="mimed-record-heading"><div class="mimed-wrap">
    <a class="mimed-back" id="mimed-back" href="{{ route('mimed.search.index', ['query' => '*:*']) }}">← Browse the catalogue</a>
    <h1>{{ $recordTitle }}</h1>
</div></div>
<div class="mimed-wrap mimed-record-layout">
    <article itemscope itemtype="https://schema.org/CreativeWork">

            {{-- Maker tags --}}
            @php
                $makerField = str_replace('.', '', $fieldMappings['Maker'] ?? $fieldMappings['Author'] ?? '');
                $filters = array_keys(config('skylight.filters', []));
                $schema = config('skylight.schema_links', []);
            @endphp

            <div class="mimed-record-makers">
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
                            }
                        }
                    }
                }
            @endphp

            @if(isset($record[$imageUriField]) && !empty($record[$imageUriField]) && $manifest)
                <div class="img-container">
                    <iframe class="img-frame" src="{{ url('/mimed/mirador') }}?manifest={{ urlencode($manifest) }}" height="100%" width="100%" title="Zoomable images of {{ $recordTitle }}"></iframe>
                </div>

                <div class="json-link">
                    <a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest={{ urlencode($manifest) }}" aria-label="Universal Viewer" title="Universal Viewer"><img src="{{ asset('collections/mimed/images/uv.png') }}" alt="Universal Viewer" height="50"></a>
                    <a href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest={{ urlencode($manifest) }}" aria-label="Mirador" title="Mirador"><img src="{{ asset('collections/mimed/images/mirador-logo.png') }}" alt="Mirador" height="50"></a>
                    <a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&amp;q={{ urlencode($accno) }}" aria-label="LUNA" title="LUNA"><img src="{{ asset('collections/mimed/images/LUNAIIIF.png') }}" alt="LUNA" height="50"></a>
                    <a href="{{ $manifest }}" aria-label="IIIF manifest" title="IIIF manifest"><img src="{{ asset('collections/mimed/images/iiiflogo.png') }}" alt="IIIF manifest" height="50"></a>
                    <a href="https://creativecommons.org/licenses/by/3.0/" aria-label="Image licence (CC BY)" title="Image licence (CC BY)"><img src="{{ asset('collections/mimed/images/cc-by.png') }}" alt="Image licence (CC BY)" height="50"></a>
                </div>
            @endif

            {{-- Main Image (OpenSeadragon fallback for non-Mirador records) --}}
            @if(!$manifest && !empty($bitstreams['main_image']))
                <div class="main-image">
                    <div id="openseadragon" class="mimed-zoom"></div>
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
                                url: {{ Illuminate\Support\Js::from($bitstreams['main_image']['uri']) }}
                            }]
                        });
                    </script>
                </div>

            @endif

            {{-- Record metadata --}}
            <div class="record-content">
                <div class="full-metadata">
                    <h2>Instrument details</h2>
                    <dl class="mimed-metadata">
                        @foreach($recordDisplay as $key)
                            @php
                                $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                            @endphp
                            @if(isset($record[$element]) && !empty($record[$element]))
                                <div>
                                    <dt>{{ $key }}</dt>
                                    <dd>
                                        @php
                                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                                        @endphp
                                        @foreach($values as $idx => $metadataValue)
                                            @php
                                                $metadataValue = str_replace('|', "\u{00A0}", $metadataValue);
                                                $schemaAttr = $schema[$key] ?? null;
                                            @endphp
                                            @if(in_array($key, $filters))
                                                @php
                                                    $origFilter = urlencode($metadataValue);
                                                    $lowerFilter = urlencode(strtolower($metadataValue));
                                                @endphp
                                                @if($schemaAttr)<span itemprop="{{ $schemaAttr }}"><a href="{{ url('/mimed/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a></span>@else<a href="{{ url('/mimed/search/*:*/' . $key . ':%22' . $lowerFilter . '+%7C%7C%7C+' . $origFilter . '%22') }}" title="{{ $metadataValue }}">{{ $metadataValue }}</a>@endif
                                            @else
                                                @if($schemaAttr)<span itemprop="{{ $schemaAttr }}">{{ $metadataValue }}</span>@else{{ $metadataValue }}@endif
                                            @endif
                                            @if($idx < count($values) - 1); @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                </div>


            </div>

            {{-- Audio and Video --}}
            @if(!empty($bitstreams['audio']) || !empty($bitstreams['video']))
                <div class="record_bitstreams">
                    @if(!empty($bitstreams['audio']))
                        <h2>Audio</h2>
                        @foreach($bitstreams['audio'] as $audio)
                            <audio controls preload="none">
                                <source src="{{ $audio['uri'] }}" type="audio/mpeg">
                            </audio>
                        @endforeach
                    @endif

                    @if(!empty($bitstreams['video']))
                        <h2>Video</h2>
                        @foreach($bitstreams['video'] as $video)
                            <video preload="metadata" loop controls>
                                <source src="{{ $video['uri'] }}" type="video/{{ pathinfo($video['filename'], PATHINFO_EXTENSION) }}">
                            </video>
                        @endforeach
                    @endif
                </div>

            @endif

            {{-- PDF files --}}
            @if(!empty($bitstreams['pdf']))
                @foreach($bitstreams['pdf'] as $pdf)
                    <p><a href="{{ $pdf['uri'] }}">Download {{ $pdf['filename'] ?? 'PDF' }}</a> ({{ $pdf['size'] }})</p>
                @endforeach
            @endif
    </article>

    <aside class="mimed-record-sidebar">
        @include('mimed.search.partials.form')
        <h2>Related instruments</h2>
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
                </li>
            @endforeach
        @else
            <li>None.</li>
        @endif
        </ul>
    </aside>
</div>
@endsection

@push('scripts')
<script>
    if (document.referrer) {
        const previousPage = new URL(document.referrer);
        if (previousPage.origin === location.origin && /^\/mimed\/(?:search|advanced\/search)\//.test(previousPage.pathname)) {
            const backLink = document.getElementById('mimed-back');
            backLink.href = previousPage.href;
            backLink.textContent = '← Back to search results';
        }
    }
</script>
@endpush
