@extends('layouts.coimbra-colls')

@section('title', $recordTitle . ' - Coimbra Colls Collection')

@section('content')
@php
    $title = str_replace('.', '', $fieldMappings['Title'] ?? '');
    $coverImageName = str_replace('.', '', $fieldMappings['Image File Name'] ?? '');
    $logoImageName =  str_replace('.', '', $fieldMappings['Logo'] ?? '');
    $imageURI = str_replace('.', '', $fieldMappings['Image URL'] ?? '');
    $location = str_replace('.', '', $fieldMappings['Institutional Map Reference'] ?? '');
    $filters = array_keys(config('skylight.filters', []));
    $institutionUri = str_replace('.', '', $fieldMappings['Institutional Web URL'] ?? '');
    $title = isset( $record[$title] ) ? $record[$title][0] : "Untitled";
    $institutionUri = isset( $record[$institutionUri] ) ? $record[$institutionUri][0] : "";
    $iiifJson = isset( $record[$imageURI] ) ? $record[$imageURI][0] : "";

    //Image setup

    $image_name = isset( $record[$coverImageName][0] ) ? $record[$coverImageName][0] : "missing.jpg";
    $imageServer = config('skylight.image_server');

    if (isset($record[$coverImageName][0]))
    {
        if (strpos($record[$coverImageName][0], 'ttps') > 0)
        {
            $coverImageJSON = str_replace("/full/full/0/default.jpg", '/info.json', $record[$coverImageName][0]);
            $coverImageURL = $record[$coverImageName][0];
        }
        else
        {
            $coverImageJSON = $imageServer . "/iiif/2/" . $record[$coverImageName][0]."/info.json";
            $coverImageURL = $coverImageJSON . '/full/full/0/default.jpg';

        }
    }
@endphp
<script src="{{ asset('assets/openseadragon/openseadragon.min.js') }}"></script>
<div id="content" class="container content col-xs-12">
    <div id="openseadragon" class="cover-image-container full-width" ></div>
    <script type="text/javascript">
        OpenSeadragon({
            id: "openseadragon",
            prefixUrl: "{{ asset('collections/coimbra-colls/images/buttons') }}/",
            preserveViewport: false,
            visibilityRatio: 1,
            minZoomLevel: 0,
            defaultZoomLevel: 0,
            panHorizontal: true,
            sequenceMode: true,
            tileSources: ["{{ $coverImageJSON }}"]
        });
    </script>
    <!--Record information-->
    <div class="record-info">
        <h1 class="itemtitle">
            <div class="backbtn">
                <i class="fa fa-arrow-left" aria-hidden="true" type="button" value="Back to Search Results" title="Back to Search Results" onClick="history.go(-1);"></i>
            </div>
            {{ $title }}
        </h1>
        <div class="description">

        @foreach($recordDisplay as $key)
            @php $element = str_replace('.', '', $fieldMappings[$key] ?? '');
            $n = 0;
            @endphp
            @if(isset($record[$element]))
               <div class="row"><span class="field">{{$key}}</span></div>
               @foreach($record[$element] as $index => $metadatavalue)
                  @if(in_array($key, $filters))
                     @php
                        $orig_filter = urlencode($metadatavalue);
                        $lower_orig_filter = urlencode(strtolower($metadatavalue));
                     @endphp
                     <a href="/coimbra-colls/search/*:*/{{ $key }}:%22{{ $lower_orig_filter }}+%7C%7C%7C+{{ $orig_filter}}%22">{{ $metadatavalue }}</a><br>
                  @else
                     @if(stripos($element, 'uri') !== false)
                        @php
                            $uriValue = $record[$element][$n];
                            if (stripos($uriValue, 'http') === false) {
                               $uriValue = 'https://' . $uriValue;
                            }
                        @endphp
                        <a title="URL Links for item" target="_blank" rel="noopener noreferrer" href="{{ $uriValue }}">
                            {{ $uriValue }} (Opens in a new tab)
                        </a>
                     @else
                        {{ $record[$element][$n] }}<br>
                     @endif
                  @endif

                  @php $n++; @endphp
             @endforeach

        @endif
      @endforeach
        <div id="map"></div>
            @php
                $mapLocation = $record[$location][0] ?? '';
            @endphp
            <script>
                 $(window).on('load', function () {
                    const coords = "58.376935, 26.721221";
                    const pin = "{{ asset('collections/coimbra-colls/images/pinpoint.png') }}";

                    console.log('map element:', document.getElementById('map'));
                    console.log('google exists:', typeof google !== 'undefined');
                    console.log('google.maps exists:', typeof google !== 'undefined' && typeof google.maps !== 'undefined');
                    console.log('parsed coords:', convertToCoordinates(coords));

                    initMap(convertToCoordinates(coords));
                    console.log('map after init:', map);

                    addLocation(coords, "Art collection", 0, pin, 1);
                    console.log('markers after add:', markers);
                });
            </script>
            <div class="institution-logo row">
                @if (isset($record[$logoImageName]))
                    @php
                    //echo $record[$logoImageName][0];
                    $t_segments = explode("##", $record[$logoImageName][0]);
                    $t_filename = $t_segments[1];

                    $t_handle = $t_segments[3];
                    $t_handle_id = preg_replace('/^.*\//', '',$t_handle);
                    $t_seq = $t_segments[4];
                    //$t_uri = './record/' . $t_handle_id . '/' . $t_seq . '/' . $t_filename;
                    $thumbnailUrl = url("/record/{$t_handle_id}/{$t_seq}/{$t_filename}");
                    $LogoLink = '<a title="Link to Institution" target="_blank" href="' . $institutionUri . '"><img src = "' . $thumbnailUrl . '" class="uni-thumbnail" /><span class="visually-hidden"> (opens in a new tab)</span></a>';
                    echo $LogoLink;
                    @endphp
                @endif
            </div><!--logo-->

             @foreach($descriptionDisplay as $key)
                @php $element = str_replace('.', '', $fieldMappings[$key] ?? '');
                    $n = 0;
                @endphp

                @if (isset($record[$element]))
                    <div class="row"><span class="field">{{ $key }}</span>
                    @foreach ($record[$element] as $index => $metadatavalue)
                        @if (in_array($key, $filters))
                            @php
                                $orig_filter = urlencode($metadatavalue);
                                $lower_orig_filter = strtolower($metadatavalue);
                                $lower_orig_filter = urlencode($lower_orig_filter);
                            @endphp
                            <a href="coimbra/search/*:*/ {{ $key }}:%22 {{ $lower_orig_filter }} +%7C%7C%7C+ {{ $orig_filter }}%22" title="{{ $metadatavalue }}">{{ $metadatavalue }}</a>

                        @else
                            @if (stripos($element, "uri") !== FALSE)
                               <a href="{{ $record[$element][0] }}" title="URL Links for item" target="_blank">{{ $record[$element][0] }}  (Opens in a new tab)</a>
                            @else
                               {{ $record[$element][0] }}
                            @endif
                        @endif
                    @endforeach
                    </div>
               @endif
             @endforeach
        </div><!--description-->
    </div><!--record-info-->
</div><!--content-->

@endsection
