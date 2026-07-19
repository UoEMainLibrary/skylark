@extends('layouts.iconics')

@section('title', $recordTitle . ' - Library and University Collections - Iconics')

@section('content')
@php
    $fieldMappings = config('skylight.field_mappings', []);
    $filters       = array_keys(config('skylight.filters', []));
    $schema        = config('skylight.schema_links', []);
    $mediaUri      = (string) config('skylight.media_url_prefix', '');

    $fieldKey = static function (string $displayName) use ($fieldMappings): string {
        return str_replace('.', '', $fieldMappings[$displayName] ?? '');
    };

    $titleField       = $fieldKey('Title');
    $authorField      = $fieldKey('Author');
    $typeField        = $fieldKey('Type');
    $dateField        = $fieldKey('Date');
    $bitstreamField   = $fieldKey('Bitstream');
    $thumbnailField   = $fieldKey('Thumbnail');
    $descriptionField = $fieldKey('Description');
    $abstractField    = $fieldKey('Abstract');
    $linkField        = $fieldKey('Link');
    $tagsField        = $fieldKey('Tags');

    // Legacy record.php iterates luna image URIs to build an OpenSeadragon tile
    // source (info.json) and remember an image_id for the crowd-sourcing form.
    $tileSource   = null;
    $imageId      = '';
    $mainImageTest = false;

    if ($linkField !== '' && ! empty($record[$linkField])) {
        $linkUris = is_array($record[$linkField]) ? $record[$linkField] : [$record[$linkField]];
        foreach ($linkUris as $linkURI) {
            if (str_contains((string) $linkURI, 'luna')) {
                $candidate = str_replace('detail', 'iiif', (string) $linkURI);
                $candidate = str_replace('http://', 'https://', $candidate);
                $tileSource = $candidate.'/info.json';
                // Legacy also derives a `manifestURI` for the IIIF logo links from
                // the same URI, using `detail` → `iiif/m`.
                $manifestUri = str_replace('detail', 'iiif/m', (string) $linkURI).'/manifest';
                $mainImageTest = true;
                break;
            }
        }
    }

    // Bitstream loop: mirror legacy behaviour for image_id + audio/video output.
    $audioLink = '';
    $videoLink = '';
    $audioFile = false;
    $videoFile = false;

    if (! empty($record[$bitstreamField])) {
        $bitstreams = is_array($record[$bitstreamField]) ? $record[$bitstreamField] : [$record[$bitstreamField]];
        $bitstreamArray = [];
        foreach ($bitstreams as $bitstreamForArray) {
            $segments = explode('##', (string) $bitstreamForArray);
            $seq = $segments[4] ?? null;
            if ($seq !== null) {
                $bitstreamArray[$seq] = $bitstreamForArray;
            }
        }
        ksort($bitstreamArray);

        foreach ($bitstreamArray as $bitstream) {
            $bSegments = explode('##', (string) $bitstream);
            $bFilename = $bSegments[1] ?? '';
            if ($imageId === '') {
                $imageId = substr($bFilename, 0, 7);
            }
            $bHandle   = $bSegments[3] ?? '';
            $bSeq      = $bSegments[4] ?? '';
            $bHandleId = preg_replace('/^.*\//', '', (string) $bHandle);
            $bUri      = './record/'.$bHandleId.'/'.$bSeq.'/'.$bFilename;

            $lower = strtolower($bFilename);

            if (str_contains($lower, '.mp3')) {
                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="'.$bUri.'" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;
            } elseif (str_contains($lower, '.mp4')) {
                $mediaBUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                $ua = (string) request()->userAgent();
                $mp4ok = ! str_contains($ua, 'Chrome') || str_contains($ua, 'Edge');
                if ($mp4ok) {
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$mediaBUri.'" type="video/mp4" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            } elseif (str_contains($lower, '.webm')) {
                $ua = (string) request()->userAgent();
                if (! str_contains($ua, 'Edge') && str_contains($ua, 'Chrome')) {
                    $mediaBUri = $mediaUri.$bHandleId.'/'.$bSeq.'/'.$bFilename;
                    $videoLink .= '<div class="flowplayer" title="'.e($recordTitle).': '.e($bFilename).'">';
                    $videoLink .= '<video preload="auto" loop width="100%" height="auto" controls width="660">';
                    $videoLink .= '<source src="'.$mediaBUri.'" type="video/webm" />Video loading...';
                    $videoLink .= '</video></div>';
                    $videoFile = true;
                }
            }
        }
    }

    $navigationPrev = $navigation['prev'] ?? null;
    $navigationNext = $navigation['next'] ?? null;

    $abstractValue = '';
    if ($abstractField !== '' && ! empty($record[$abstractField])) {
        $abstractValue = is_array($record[$abstractField])
            ? ($record[$abstractField][0] ?? '')
            : $record[$abstractField];
    }

    $descriptionValue = '';
    if ($descriptionField !== '' && ! empty($record[$descriptionField])) {
        $descriptionValue = is_array($record[$descriptionField])
            ? ($record[$descriptionField][0] ?? '')
            : $record[$descriptionField];
    }

    $dateValue = '';
    if ($dateField !== '' && ! empty($record[$dateField])) {
        $dateValue = is_array($record[$dateField])
            ? ($record[$dateField][0] ?? '')
            : $record[$dateField];
    }
@endphp

@if($tileSource)
    <div class="full-image">
        <div id="openseadragon">
            <script type="text/javascript">
                OpenSeadragon({
                    id: "openseadragon",
                    prefixUrl: "{{ asset('assets/openseadragon/images/') }}/",
                    preserveViewport: false,
                    visibilityRatio: 1,
                    minZoomLevel: 0.7,
                    defaultZoomLevel: 3,
                    panHorizontal: true,
                    sequenceMode: true,
                    tileSize: 500,
                    tileSources: ["{{ $tileSource }}"]
                });
            </script>
        </div>
    </div>
@endif

<div class="content">
    <div itemscope itemtype="http://schema.org/CreativeWork">

        @if($mainImageTest)
            <div class="full-title">
        @endif
                <div class="title-header">
                    <h1 class="itemprev">
                        @if($navigationPrev)
                            <a href="./record/{{ $navigationPrev }}" title="View Previous Item"><i class="fa fa-arrow-left">&nbsp;&nbsp;</i></a>
                        @endif
                    </h1>
                    <h1 class="item-title">
                        {{ $recordTitle }}@if($dateValue !== '') ({{ $dateValue }})@endif
                    </h1>
                    <h1 class="itemnext">
                        @if($navigationNext)
                            <a href="./record/{{ $navigationNext }}" title="View Next Item"><i class="fa fa-arrow-right"></i></a>
                        @endif
                    </h1>
                </div>
                <div class="clearfix"></div>
                <div class="item-abstract">
                    {!! $abstractValue !!}
                </div>
        @if($mainImageTest)
            </div>
        @endif

        @if($mainImageTest)
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="maintext">
                        {!! $descriptionValue !!}
                    </div>
        @endif

                    @php
                        $excludes = [''];
                        $metadataRows = '';
                        foreach ($recordDisplay as $key) {
                            $element = $fieldKey($key);
                            if ($element === '' || ! isset($record[$element]) || in_array($key, $excludes, true)) {
                                continue;
                            }
                            $values = is_array($record[$element]) ? $record[$element] : [$record[$element]];

                            $isFilter   = in_array($key, $filters, true) && $key !== 'Author';
                            $schemaProp = $schema[$key] ?? null;

                            $row = '<div class="metadatarow"><div class="metadatakey">'.e($key).'</div><div class="metadatavalue">';
                            $count = count($values);
                            foreach ($values as $index => $metadatavalue) {
                                $orig  = urlencode($metadatavalue);
                                $lower = urlencode(strtolower($metadatavalue));
                                $inner = '';
                                if ($isFilter) {
                                    $inner = '<a href="./search/*:*/'.$key.':%22'.$lower.'+%7C%7C%7C+'.$orig.'%22" title="'.e($metadatavalue).'">'.e($metadatavalue).'</a>';
                                    if ($schemaProp !== null) {
                                        $inner = '<span itemprop="'.e($schemaProp).'">'.$inner.'</span>';
                                    }
                                } else {
                                    $inner = e($metadatavalue);
                                    if ($schemaProp !== null) {
                                        $inner = '<span itemprop="'.e($schemaProp).'">'.$inner.'</span>';
                                    }
                                }
                                $row .= $inner;
                                if ($index < $count - 1) {
                                    $row .= '; ';
                                }
                            }
                            $row .= '</div></div>';
                            $metadataRows .= $row;
                        }
                    @endphp
                    {!! $metadataRows !!}
        @if($mainImageTest)
                </div>
            </div>
        @endif

        @if(isset($manifestUri))
            <div>
                <p>
                    <a target="_blank" href="{{ $manifestUri }}">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/International_Image_Interoperability_Framework_logo.png" class="iiiflogo" title="Right-click, Copy Link to get the full IIIF manifest for the collection.">
                    </a>
                    <a target="_blank" href="{{ $manifestUri }}">
                        <img src="https://images.is.ed.ac.uk/luna/images/LUNAIIIF80.png" class="lunaiiif" title="Right-click, Copy Link to get the full IIIF manifest for the collection.">
                    </a>
                    This collection is IIIF-compliant. <a href="./iiif">See more</a>.
                </p>
            </div>
        @endif

        <div class="clearfix"></div>

        {{-- Crowd-sourced tags block, matching legacy theme/iconics/views/record.php --}}
        @if($tagsField !== '' && ! empty($record[$tagsField]))
            <div class="crowd-tags">
                <span class="crowd-title" title="User generated tags created through crowd sourcing games"><i class="fa fa-users fa-lg">&nbsp;</i>Tags:</span>
                @foreach((is_array($record[$tagsField]) ? $record[$tagsField] : [$record[$tagsField]]) as $tag)
                    @php
                        $orig  = urlencode($tag);
                        $lower = urlencode(strtolower($tag));
                    @endphp
                    <span class="crowd-tag"><a href="./search/*:*/Tags:%22{{ $lower }}+%7C%7C%7C+{{ $orig }}%22"><i class="fa fa-tags fa-lg">&nbsp;</i>{{ $tag }}</a></span>
                @endforeach
                <div class="crowd-info">
                    <form id="libraylabs" method="get" action="https://librarylabs.ed.ac.uk/games/gameCrowdSourcing.php" target="_blank">
                        <input type="hidden" name="image_id" value="{{ $imageId }}">
                        <input type="hidden" name="theme" value="classic">
                        Add more tags at <a href="#" onclick="document.forms[1].submit();return false;" title="University of Edinburgh, Library Labs Metadata Games">Library Labs Games</a>
                        (Create a login at <a href="https://www.ease.ed.ac.uk/friend/" target="_blank" title="EASE Friend">Edinburgh Friend Account</a>)
                    </form>
                </div>
            </div>
        @else
            <div class="crowd-tags">
                <div class="crowd-info">
                    <form id="libraylabs" method="get" action="https://librarylabs.ed.ac.uk/games/gameCrowdSourcing.php" target="_blank">
                        <input type="hidden" name="image_id" value="{{ $imageId }}">
                        <input type="hidden" name="theme" value="classic">
                        Add tags to this image at <a href="#" onclick="document.forms[1].submit();return false;" title="University of Edinburgh, Library Labs Metadata Games">Library Labs Games</a>
                        (Create a login at <a href="https://www.ease.ed.ac.uk/friend/" target="_blank" title="EASE Friend">Edinburgh Friend Account</a>)
                    </form>
                </div>
            </div>
        @endif

        <div class="record_bitstreams">
            @if($audioFile)<br><br>{!! $audioLink !!}@endif
            @if($videoFile)<br><br>{!! $videoLink !!}@endif
        </div>
        <div class="clearfix"></div>
    </div>
    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
@endsection
