@extends('layouts.pointsofarrival')

@section('title', '"' . $recordTitle . '" — ' . config('skylight.fullname', "Points Of Arrival"))

@section('body_class', 'record')

@section('content')
    @php
        // Mirror the legacy pointsofarrival/views/record.php data preparation.
        // Translate field-mapping config (e.g. "dc.title.en") into Solr-side
        // keys (with the dots stripped, matching what DSpace returns).
        $mappings = config('skylight.field_mappings', []);
        $fieldKey = function (string $name) use ($mappings): string {
            return str_replace('.', '', $mappings[$name] ?? '');
        };

        $titleField = $fieldKey('Title');
        $authorField = $fieldKey('Maker') ?: $fieldKey('Author');
        $bitstreamField = $fieldKey('Bitstream');
        $thumbnailField = $fieldKey('Thumbnail');
        $linkUriField = $fieldKey('ImageURI');
        $accNoField = $fieldKey('Accession Number');

        $filters = array_keys(config('skylight.filters', []));
        $schema = config('skylight.schema_links', []);

        $recordDisplay = config('skylight.recorddisplay', []);
        $descriptionDisplay = config('skylight.descriptiondisplay', []);
        $descriptionDataDisplay = config('skylight.descriptiondatadisplay', []);
        $identificationDisplay = config('skylight.identificationdisplay', []);
        $locationDisplay = config('skylight.locationdisplay', []);
        $datedisplay = config('skylight.datedisplay', []);
        $creatorDisplay = config('skylight.creatordisplay', []);
        $placeDisplay = config('skylight.placedisplay', []);
        $typeDisplay = config('skylight.typedisplay', []);

        $mediaUriPrefix = config('skylight.media_url_prefix', '');

        // Record-summary fields used in the page title (sub-heading line).
        $title = $recordTitle;
        $maker = 'Unknown maker';
        $date = 'Undated';
        if (! empty($record[$authorField])) {
            $maker = is_array($record[$authorField]) ? ($record[$authorField][0] ?? $maker) : $record[$authorField];
        }
        $dateMadeField = $fieldKey('Date Made');
        if (! empty($record[$dateMadeField])) {
            $date = is_array($record[$dateMadeField]) ? ($record[$dateMadeField][0] ?? $date) : $record[$dateMadeField];
        }

        // Walk bitstreams to discover audio/video clips and a IIIF JSON
        // manifest. The legacy site renders an inline <audio>/<video> tag and
        // a UV / Mirador / LUNA / IIIF / CC-BY badge row for each manifest.
        $audioLink = '';
        $videoLink = '';
        $manifest = null;
        $jsonLink = '';
        $accNo = '';
        if (! empty($record[$accNoField])) {
            $accNo = is_array($record[$accNoField]) ? ($record[$accNoField][0] ?? '') : $record[$accNoField];
        }

        if (! empty($record[$bitstreamField])) {
            $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];
            $byOrder = [];
            foreach ($bitstreams as $bs) {
                $segs = explode('##', $bs);
                if (count($segs) >= 5) {
                    $byOrder[(int) $segs[4]] = $bs;
                }
            }
            ksort($byOrder);
            foreach ($byOrder as $bs) {
                $segs = explode('##', $bs);
                $bFilename = $segs[1] ?? '';
                $bHandle = $segs[3] ?? '';
                $bSeq = $segs[4] ?? '';
                $bHandleId = preg_replace('/^.*\//', '', $bHandle);
                $localUri = url("/pointsofarrival/record/{$bHandleId}/{$bSeq}/{$bFilename}");
                $remoteUri = $mediaUriPrefix !== ''
                    ? rtrim($mediaUriPrefix, '/') . "/{$bHandleId}/{$bSeq}/{$bFilename}"
                    : $localUri;

                $lower = strtolower($bFilename);
                if (str_ends_with($lower, '.mp3')) {
                    $audioLink .= '<div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject"></div>';
                    $audioLink .= '<audio controls><source src="' . e($localUri) . '" type="audio/mpeg" />Audio loading...</audio>';
                } elseif (str_ends_with($lower, '.mp4')) {
                    $videoLink .= '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                    $videoLink .= '<div class="flowplayer" data-analytics="' . e(config('skylight.ga_code')) . '" title="' . e($recordTitle . ': ' . $bFilename) . '"><video preload="auto" loop controls width="100%" height="auto"><source src="' . e($remoteUri) . '" type="video/mp4" />Video loading...</video></div>';
                } elseif (str_ends_with($lower, '.webm')) {
                    $videoLink .= '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                    $videoLink .= '<div class="flowplayer" data-analytics="' . e(config('skylight.ga_code')) . '" title="' . e($recordTitle . ': ' . $bFilename) . '"><video preload="auto" loop controls width="100%" height="auto"><source src="' . e($remoteUri) . '" type="video/webm" />Video loading...</video></div>';
                } elseif (str_ends_with($lower, '.json')) {
                    $manifest = url("/pointsofarrival/record/{$bHandleId}/{$bSeq}/{$bFilename}");
                    $jsonLink .= '<span class="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . e($manifest) . '" target="_blank" rel="noopener" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a target="_blank" rel="noopener" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest=' . e($manifest) . '" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . e($accNo) . '" target="_blank" rel="noopener" class="lunalogo" title="View in LUNA"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="' . e($manifest) . '" target="_blank" rel="noopener" class="iiiflogo" title="IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                    $jsonLink .= '<span class="json-link-item"><a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="noopener" class="ccbylogo" title="All images CC-BY"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
                }
            }
        }

        // Image URIs and tile sources for OpenSeadragon.
        $imageUris = [];
        if (! empty($record[$linkUriField])) {
            $imageUris = is_array($record[$linkUriField]) ? $record[$linkUriField] : [$record[$linkUriField]];
        }
        $imageCounter = count($imageUris);
        $tileSources = array_map(
            fn ($uri) => str_replace('http://', 'https://', str_replace('full/full/0/default.jpg', 'info.json', $uri)),
            $imageUris
        );

        $numThumbnails = $imageCounter;
        $numRel = is_array($relatedItems ?? null) ? count($relatedItems) : 0;

        // Wrapping class for the metadata panel mirrors the legacy
        // "$numThumbnails >= 2 ? meta-mid : meta-smol" branching in
        // record.php (the meta-big branch is dead code in the original).
        $metaWrapClass = $numThumbnails >= 2 ? 'meta-mid' : 'meta-smol';

        // Inline closure that emits the legacy "<div class='child-meta'>...
        // <h4>Key</h4><p>value(s)</p></div>" block for one display group,
        // honouring filter links and Schema.org itemprops.
        $renderChildGroup = function (array $displayKeys, ?string $keyOverride = null) use ($record, $mappings, $filters, $schema): string {
            $out = '';
            $infoFound = false;
            foreach ($displayKeys as $key) {
                $element = str_replace('.', '', $mappings[$key] ?? '');
                if ($element === '' || empty($record[$element])) {
                    continue;
                }
                $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];
                $out .= '<div class="child-meta">';
                $out .= '<h4>' . e($key) . '</h4>';
                $out .= '<p>';
                foreach ($values as $idx => $val) {
                    $val = (string) $val;
                    if (in_array($key, $filters, true)) {
                        $orig = urlencode($val);
                        $lower = urlencode(strtolower($val));
                        $href = url('/pointsofarrival/search/*:*/' . urlencode($key) . ':%22' . $lower . '+%7C%7C%7C+' . $orig . '%22');
                        if (isset($schema[$key])) {
                            $out .= '<span itemprop="' . e($schema[$key]) . '"><a href="' . e($href) . '" title="Read more about ' . e($val) . '">' . e($val) . '</a></span>';
                        } else {
                            $out .= '<a href="' . e($href) . '" title="Read more about ' . e($val) . '">' . e($val) . '</a>';
                        }
                    } else {
                        if (isset($schema[$key])) {
                            $out .= '<span itemprop="' . e($schema[$key]) . '">' . e($val) . '</span>';
                        } else {
                            $out .= e($val);
                        }
                    }
                    if ($idx < count($values) - 1) {
                        $out .= '; ';
                    }
                }
                $out .= '</p></div>';
                $infoFound = true;
            }
            if (! $infoFound) {
                $out .= '<h4 class="no-meta">No information recorded.</h4><p></p>';
            }

            return $out;
        };
    @endphp

    <div class="container-fluid content">

        {{-- ============================================================
             stc-section1 : page title
             ============================================================ --}}
        <div id="stc-section1" class="container-fluid record-content">
            <h2 class="itemtitle hidden-sm hidden-xs">{{ $title }} | {{ $maker }} | {{ $date }}</h2>
            <h4 class="itemtitle hidden-lg hidden-md">{{ $title }} | {{ $maker }} | {{ $date }}</h4>
        </div>

        {{-- ============================================================
             stc-section1 (anchor nav)
             ============================================================ --}}
        <div id="stc-section1" class="container-fluid record-content">
            <ul class="center-nav">
                @if(! empty($imageUris))
                    <li><a class="cnav-link" href="{{ request()->getRequestUri() }}#stc-section2" title="Skip to instruments image(s)">Image</a></li>
                @endif
                @if($audioLink !== '' || $videoLink !== '')
                    <li><a class="cnav-link" href="{{ request()->getRequestUri() }}#stc-section4" title="Skip to instruments audio or video recordings">Audio Clips</a></li>
                @endif
                @if(! empty($recordDisplay))
                    <li><a class="cnav-link" href="{{ request()->getRequestUri() }}#stc-section3" title="Skip to instruments category tags">Categories</a></li>
                @endif
                @if(! empty($identificationDisplay))
                    <li><a class="cnav-link" href="{{ request()->getRequestUri() }}#stc-section5" title="Skip to instruments full information">Instrument Data</a></li>
                @endif
                @if($numRel > 0)
                    <li><a class="cnav-link" href="{{ request()->getRequestUri() }}#stc-section6" title="Skip to related instruments">Related Items</a></li>
                @endif
            </ul>
        </div>

        {{-- ============================================================
             stc-section2 : main image (OpenSeadragon viewers + thumbs)

             Note: this section deliberately does NOT close until the
             end of the page. The legacy pointsofarrival/views/record.php
             never closes #stc-section2 (or its .itemscope child); the
             browser auto-closes them at body boundary. The result is
             that .json-link, #stc-section3, #stc-section4 and
             .full-metadata > #stc-section5 are all rendered as
             children of .itemscope, and #stc-section6 (related items)
             is a sibling of .itemscope inside #stc-section2. We mirror
             that nesting one-for-one so the rendered DOM matches
             Skylight exactly.
             ============================================================ --}}
        <div id="stc-section2" class="container-fluid">
            @if(! empty($imageUris))
                <div class="col-lg-12 main-image">
                    @foreach($tileSources as $i => $tile)
                        <div id="openseadragon{{ $i }}" class="image-toggle" style="display: {{ $i === 0 ? 'block' : 'none' }};">
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon{{ $i }}",
                                    prefixUrl: "{{ asset('collections/pointsofarrival/images/buttons') }}/",
                                    zoomPerScroll: 1.2,
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["{{ $tile }}"]
                                });
                            </script>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="itemscope" itemscope itemtype="http://schema.org/CreativeWork">
                <div class="thumb-strip">
                    @if($imageCounter > 1)
                        @foreach($imageUris as $i => $uri)
                            @php $linkURI = str_replace('http://', 'https://', $uri); @endphp
                            <label class="image-toggler" data-image-id="#openseadragon{{ $i }}">
                                <input type="radio" name="options" id="option{{ $i }}">
                                <img src="{{ $linkURI }}" class="record-thumb-strip" title="{{ $title }}" alt="{{ $title }} thumbnail {{ $i + 1 }}">
                            </label>
                        @endforeach
                    @endif
                </div>

        {{-- IIIF / Mirador / LUNA / UV / CC-BY link badges --}}
        <div class="json-link">
            <p>{!! $jsonLink !!}</p>
            <p style="color: black;">(Note: Each icon above opens in a new tab.)</p>
        </div>

        {{-- ============================================================
             stc-section4 : audio clips
             ============================================================ --}}
        @if($audioLink !== '')
            <div id="stc-section4" class="container-fluid">
                <h3 class="inst-desc">Audio Clips</h3>
                {!! $audioLink !!}
            </div>
        @endif

        @if($videoLink !== '')
            <div id="stc-section4" class="container-fluid">
                <h3 class="inst-desc">Video Clips</h3>
                {!! $videoLink !!}
            </div>
        @endif

        {{-- ============================================================
             stc-section3 : categories (Short Description + clickable tags)
             ============================================================ --}}
        @if(! empty($descriptionDisplay) || ! empty($recordDisplay))
            <div id="stc-section3" class="container-fluid">
                <div class="col-description{{ $numThumbnails > 1 ? '' : ' desc-smol' }}">
                    @foreach($descriptionDisplay as $key)
                        @php $element = $fieldKey($key); @endphp
                        @if($element !== '' && ! empty($record[$element]))
                            @foreach((is_array($record[$element]) ? $record[$element] : [$record[$element]]) as $metadatavalue)
                                @if($key === 'Short Description' || $key === 'Description')
                                    <span class="description">{!! $metadatavalue !!}</span>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                @foreach($recordDisplay as $key)
                    @php $element = $fieldKey($key); @endphp
                    @if($element !== '' && ! empty($record[$element]))
                        @foreach((is_array($record[$element]) ? $record[$element] : [$record[$element]]) as $metadatavalue)
                            <div class="stc-tags">
                                @if(in_array($key, $filters, true) && strpos($metadatavalue, '/') === false)
                                    @php
                                        $orig = urlencode($metadatavalue);
                                        $lower = urlencode(strtolower($metadatavalue));
                                        $href = url('/pointsofarrival/search/*:*/' . urlencode($key) . ':%22' . $lower . '+%7C%7C%7C+' . $orig . '%22');
                                    @endphp
                                    <a href="{{ $href }}" title="Read more about {{ $metadatavalue }}">{{ $metadatavalue }}</a>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endif

        {{-- ============================================================
             stc-section5 : Instrument Data (full metadata panel)
             ============================================================ --}}
        <div class="full-metadata">
            <div id="stc-section5" class="panel panel-default container-fluid">
                <div class="panel-heading straight-borders">
                    <h3 class="panel-title hidden-sm hidden-xs inst-desc">Instrument Data</h3>
                    <h4 class="panel-title hidden-md hidden-lg">Instrument Data</h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-sm-6 col-xs-12 col-md-8 col-lg-12 {{ $metaWrapClass }}" itemscope itemtype="https://schema.org/instrument">

                            {{-- Instrument Information --}}
                            <div class="info-box">
                                <h3>Instrument Information</h3>
                                <div class="meta-container">
                                    <div class="child-meta-container">
                                        {!! $renderChildGroup($identificationDisplay) !!}
                                    </div>

                                    <h3 class="meta-spacing">Date Information</h3>
                                    <div class="child-meta-container">
                                        {!! $renderChildGroup($datedisplay) !!}
                                    </div>

                                    <h3 class="meta-spacing">Gallery Information</h3>
                                    <div class="child-meta-container">
                                        {!! $renderChildGroup($locationDisplay) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Maker Information --}}
                            <div class="info-box">
                                <h3>Maker Information</h3>
                                <div class="meta-container" id="table-text-desc">
                                    <div class="child-meta-container-wide">
                                        @php $creatorInfoFound = false; @endphp
                                        @foreach($creatorDisplay as $key)
                                            @php $element = $fieldKey($key); @endphp
                                            @if($element !== '' && ! empty($record[$element]))
                                                @php $creatorInfoFound = true; @endphp
                                                <h4>{{ $key }}</h4>
                                                <p class="table-text-justify {{ $key === 'Maker Biography' ? '' : 'maker' }}">
                                                    @php $values = is_array($record[$element]) ? $record[$element] : [$record[$element]]; @endphp
                                                    @foreach($values as $idx => $val)
                                                        @if(in_array($key, $filters, true))
                                                            @php
                                                                $orig = urlencode($val);
                                                                $lower = urlencode(strtolower($val));
                                                                $href = url('/pointsofarrival/search/*:*/' . urlencode($key) . ':%22' . $lower . '+%7C%7C%7C+' . $orig . '%22');
                                                            @endphp
                                                            @if(isset($schema[$key]))
                                                                <span itemprop="{{ $schema[$key] }}" class="offset-dd"><a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a></span>
                                                            @else
                                                                <a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a>
                                                            @endif
                                                        @else
                                                            @if(isset($schema[$key]))
                                                                <span itemprop="{{ $schema[$key] }}" class="offset-dd">{{ $val }}</span>
                                                            @else
                                                                {{ $val }}
                                                            @endif
                                                        @endif
                                                        @if($idx < count($values) - 1); @endif
                                                    @endforeach
                                                </p>
                                            @endif
                                        @endforeach
                                        @if(! $creatorInfoFound)
                                            <h4 class="no-meta">No information recorded.</h4><p></p>
                                        @endif
                                    </div>

                                    <h3 class="meta-spacing">Made In</h3>
                                    <div class="child-meta-container">
                                        {!! $renderChildGroup($placeDisplay) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="info-box">
                                <h3>Description</h3>
                                <div class="meta-container" id="table-text-desc">
                                    <div class="child-meta-container-wide">
                                        @php $descInfoFound = false; @endphp
                                        @foreach($descriptionDataDisplay as $key)
                                            @php $element = $fieldKey($key); @endphp
                                            @if($element !== '' && ! empty($record[$element]))
                                                @php $descInfoFound = true; @endphp
                                                <h4>{{ $key }}</h4>
                                                <p class="table-text-justify">
                                                    @php $values = is_array($record[$element]) ? $record[$element] : [$record[$element]]; @endphp
                                                    @foreach($values as $idx => $val)
                                                        @if(in_array($key, $filters, true))
                                                            @php
                                                                $orig = urlencode($val);
                                                                $lower = urlencode(strtolower($val));
                                                                $href = url('/pointsofarrival/search/*:*/' . urlencode($key) . ':%22' . $lower . '+%7C%7C%7C+' . $orig . '%22');
                                                            @endphp
                                                            @if(isset($schema[$key]))
                                                                <span itemprop="{{ $schema[$key] }}"><a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a></span>
                                                            @else
                                                                <a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a>
                                                            @endif
                                                        @else
                                                            @if(isset($schema[$key]))
                                                                <span itemprop="{{ $schema[$key] }}">{!! nl2br(e($val)) !!}</span>
                                                            @else
                                                                {!! nl2br(e($val)) !!}
                                                            @endif
                                                        @endif
                                                        @if($idx < count($values) - 1); @endif
                                                    @endforeach
                                                </p>
                                            @endif
                                        @endforeach
                                        @if(! $descInfoFound)
                                            <h4 class="no-meta">No information recorded.</h4><p></p>
                                        @endif
                                    </div>

                                    <h3 class="meta-spacing">Classification</h3>
                                    <div class="child-meta-container">
                                        @php
                                            $classInfoFound = false;
                                            $instrumentFound = false;
                                            $familyFound = false;
                                        @endphp
                                        @foreach($typeDisplay as $key)
                                            @php $element = $fieldKey($key); @endphp
                                            @if($element !== '' && ! empty($record[$element]))
                                                @php
                                                    if ($key === 'Instrument') { $instrumentFound = true; }
                                                    if ($key === 'Instrument Family') { $familyFound = true; }
                                                    $skip = ($key === 'Genus' && $instrumentFound) || ($key === 'Grouping' && $familyFound);
                                                @endphp
                                                @unless($skip)
                                                    @php $classInfoFound = true; @endphp
                                                    <div class="child-meta">
                                                        <h4>{{ $key }}</h4>
                                                        <p>
                                                            @php $values = is_array($record[$element]) ? $record[$element] : [$record[$element]]; @endphp
                                                            @foreach($values as $idx => $val)
                                                                @if(in_array($key, $filters, true))
                                                                    @php
                                                                        $orig = urlencode($val);
                                                                        $lower = urlencode(strtolower($val));
                                                                        $href = url('/pointsofarrival/search/*:*/' . urlencode($key) . ':%22' . $lower . '+%7C%7C%7C+' . $orig . '%22');
                                                                    @endphp
                                                                    @if(isset($schema[$key]))
                                                                        <span itemprop="{{ $schema[$key] }}"><a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a></span>
                                                                    @else
                                                                        <a href="{{ $href }}" title="Read more about {{ $val }}">{{ $val }}</a>
                                                                    @endif
                                                                @else
                                                                    @if(isset($schema[$key]))
                                                                        <span itemprop="{{ $schema[$key] }}" title="Read more about {{ $val }}"><a href="{{ url('/pointsofarrival/search/%22' . $val . '%22') }}" title="Read more about {{ $val }}">{{ $val }}</a></span>
                                                                    @else
                                                                        {{ $val }}
                                                                    @endif
                                                                @endif
                                                                @if($idx < count($values) - 1); @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                @endunless
                                            @endif
                                        @endforeach
                                        @if(! $classInfoFound)
                                            <h4 class="no-meta">No information recorded.</h4><p></p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

            </div> {{-- closes .itemscope (mirrors the implicit close emitted
                       by div_sidebar_end.php's stray </div> in legacy) --}}

            {{-- ============================================================
                 stc-section6 : related items (mirrors related_items.php).
                 In the legacy theme `div_sidebar.php` is overridden empty
                 and `div_sidebar_end.php` falls through to the global
                 single-</div> file, so #stc-section6 ends up as a sibling
                 of .itemscope inside #stc-section2 — no .col-sidebar
                 wrapper. We reproduce that here.
                 ============================================================ --}}
            @if($numRel > 0)
                <div id="stc-section6" class="col-xs-12 related inactive container-fluid">
                    <h2 class="itemtitle hidden-sm hidden-xs">Related Instruments</h2>
                    <h4 class="itemtitle hidden-md hidden-lg">Related Instruments</h4>
                    <div id="results-container">
                        <div class="results-row">
                            @foreach($relatedItems as $relIndex => $relDoc)
                                @php
                                    $relTitle = $relDoc[$titleField][0] ?? ($relDoc[$titleField] ?? 'Untitled');
                                    if (is_array($relTitle)) { $relTitle = $relTitle[0] ?? 'Untitled'; }
                                    $relId = $relDoc['id'] ?? '';
                                    if (is_array($relId)) { $relId = $relId[0] ?? ''; }
                                    $relImageUri = null;
                                    if (! empty($relDoc[$linkUriField])) {
                                        $imgs = is_array($relDoc[$linkUriField]) ? $relDoc[$linkUriField] : [$relDoc[$linkUriField]];
                                        foreach ($imgs as $imgUri) {
                                            if (str_contains($imgUri, 'luna')) {
                                                $relImageUri = str_replace('http://', 'https://', $imgUri);
                                                break;
                                            }
                                        }
                                    }

                                    // Mirror legacy related_items.php: getimagesize() per
                                    // image to choose .record-thumbnail-portrait vs
                                    // .record-thumbnail-landscape (height: 200px / width:
                                    // 200px). Cache for 24h so we don't hit the IIIF
                                    // server on every page render. Default to portrait if
                                    // we can't read the image — Skylight does the same
                                    // (its $portrait flag starts true and only flips when
                                    // width > height is observed).
                                    $relThumbClass = 'record-thumbnail-portrait';
                                    if ($relImageUri) {
                                        $cacheKey = 'pointsofarrival.thumb.orientation.'.md5($relImageUri);
                                        $relThumbClass = \Illuminate\Support\Facades\Cache::remember(
                                            $cacheKey,
                                            now()->addDay(),
                                            function () use ($relImageUri): string {
                                                try {
                                                    $size = @getimagesize($relImageUri);
                                                    if (is_array($size) && $size[0] > $size[1]) {
                                                        return 'record-thumbnail-landscape';
                                                    }
                                                } catch (\Throwable $e) {
                                                    // Network blip / VPN drop → fall through.
                                                }

                                                return 'record-thumbnail-portrait';
                                            }
                                        );
                                    }
                                @endphp
                                <div class="column related-col">
                                    <div class="thumbnail-cont">
                                        @if($relImageUri)
                                            <a href="{{ url('/pointsofarrival/record/' . $relId) }}" title="Read more about the {{ $relTitle }}">
                                                <img src="{{ $relImageUri }}" class="{{ $relThumbClass }} related-img" title="Read more about the {{ $relTitle }}" alt="{{ $relTitle }}">
                                            </a>
                                        @else
                                            <a href="{{ url('/pointsofarrival/record/' . $relId) }}" title="Read more about the {{ $relTitle }}">No Image for this</a>
                                        @endif
                                        <p class="text-center hidden-xs reated-p">{{ $relTitle }}</p>
                                        <p class="text-center hidden-md hidden-sm hidden-lg reated-p"><small>{{ $relTitle }}</small></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div> {{-- closes #stc-section2 --}}

    </div> {{-- closes .container-fluid.content --}}
@endsection
