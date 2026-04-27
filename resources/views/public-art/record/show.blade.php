@extends('layouts.public-art')

@section('title', $recordTitle . ' - Public Art')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $titleField = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $imageUriField = str_replace('.', '', $fieldMappings['Image URI'] ?? '');
    $locationField = str_replace('.', '', $fieldMappings['Map Reference'] ?? '');

    $imageUris = $record[$imageUriField] ?? [];
    if (! is_array($imageUris)) {
        $imageUris = [$imageUris];
    }

    $imageSources = [];
    $primaryImageUrl = '';
    $primaryJsonId = '';
    $primaryHeight = 0;
    $primaryWidth = 0;

    foreach ($imageUris as $i => $uri) {
        $uri = str_replace('http://', 'https://', $uri);
        $jsonUrl = str_replace('/full/full/0/default.jpg', '/info.json', $uri);
        $osJsonId = str_replace('/info.json', '', $jsonUrl);

        $info = null;
        try {
            $ctx = stream_context_create(['http' => ['timeout' => 5], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
            $body = @file_get_contents($jsonUrl, false, $ctx);
            if ($body !== false) {
                $info = json_decode($body, true);
            }
        } catch (\Throwable $e) {
            $info = null;
        }
        $h = $info['height'] ?? 0;
        $w = $info['width'] ?? 0;
        $size = max($h, $w);

        $imageSources[] = [
            'osJsonId' => $osJsonId,
            'height' => $h,
            'width' => $w,
            'tileSize' => $size,
        ];

        if ($i === 0) {
            $primaryImageUrl = $uri;
            $primaryJsonId = $osJsonId;
            $primaryHeight = $h;
            $primaryWidth = $w;
        }
    }

    $mapLat = null;
    $mapLon = null;
    if (! empty($record[$locationField][0])) {
        $parts = explode(',', $record[$locationField][0]);
        if (count($parts) === 2) {
            $mapLat = trim($parts[0]);
            $mapLon = trim($parts[1]);
        }
    }
@endphp

<div class="container content col-xs-12">
    @if(! empty($imageSources))
        <script>var imageSource = [];</script>
        @foreach($imageSources as $i => $src)
            @php
                $iiifJson = [
                    '@context' => 'http://iiif.io/api/image/2/context.json',
                    '@id' => $src['osJsonId'],
                    'height' => (int) $src['height'],
                    'width' => (int) $src['width'],
                    'profile' => ['http://iiif.io/api/image/2/level2.json', ['formats' => ['jpg']]],
                    'protocol' => 'http://iiif.io/api/image',
                    'tiles' => [[
                        'scaleFactors' => [1, 2, 8, 16, 32],
                        'width' => (string) $src['width'],
                        'height' => (string) $src['height'],
                    ]],
                    'tileSize' => (int) $src['tileSize'],
                ];
            @endphp
            <script>
                imageSource[{{ $i }}] = {!! json_encode($iiifJson) !!};
            </script>
        @endforeach
    @endif

    <script src="{{ asset('collections/public-art/js/scrollify.js') }}"></script>
    <script>
        $(function () {
            if (!(/Android|webOS|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i.test(navigator.userAgent))) {
                $.scrollify({
                    section: ".scroll",
                    offset: -50,
                    updateHash: false,
                    standardScrollElements: "#openseadragon, .record-info",
                    interstitialSection: ".footer"
                });
            }
        });
    </script>

    <section class="image-view full-height-section scroll">
        <div id="toolbarDiv" class="toolbar">
            <h2 id="previous-pic"></h2>
            <h2 id="next-pic"></h2>
        </div>

        <div id="openseadragon" class="cover-image-container full-width"></div>
        <script>
            var imageURL = @json($primaryJsonId);
            var imageHeight = {{ (int) $primaryHeight }};
            var imageWidth = {{ (int) $primaryWidth }};
        </script>
        <script src="{{ asset('collections/public-art/js/openseadragon.min.js') }}"></script>
        <script src="{{ asset('collections/public-art/js/openseadragonconfig.js') }}"></script>
        <h3 class="more-info" onclick="$.scrollify.next();">Information</h3>
    </section>
    <section class="section-divisor hidden-sm hidden-xs"></section>

    <section class="info-view full-height-section scroll">
        <div class="record-info col-md-4 col-md-offset-2">
            <h2 class="itemtitle">{{ $recordTitle }}</h2>
            @if($primaryImageUrl)
                <img style="display: block; box-shadow: 5px 5px 5px rgb(220, 220, 220); margin-bottom: 10px;" width="100%" src="{{ $primaryImageUrl }}" alt="{{ $recordTitle }}" />
            @endif
            <div class="description">
                @foreach($recordDisplay as $key)
                    @php
                        $field = str_replace('.', '', $fieldMappings[$key] ?? '');
                        $value = $record[$field][0] ?? null;
                    @endphp
                    @if($value !== null && $value !== '')
                        <div class="row"><span class="field">{{ $key }}</span>{!! $value !!}</div>
                    @endif
                @endforeach
            </div>
        </div>

        <script>
            (function ($) {
                $(window).on("load", function () {
                    $(".record-info").mCustomScrollbar({
                        theme: "light-thick",
                        scrollInertia: 100,
                        mouseWheel: { preventDefault: true }
                    });
                });
            })(jQuery);
        </script>

        <div id="map" class="col-md-2"></div>

        @if($mapLat !== null && $mapLon !== null)
            <script>
                lon = {{ $mapLon }};
                lat = {{ $mapLat }};
            </script>
            <script src="{{ asset('collections/public-art/map/bundle.js') }}"></script>
        @endif

        <h4 class="back-to-search" value="Back to Search Results" onClick="history.go(-1);">Back to search</h4>
    </section>
</div>
@endsection
