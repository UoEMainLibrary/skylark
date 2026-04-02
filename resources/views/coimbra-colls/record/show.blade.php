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
<div id="content"></div>
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
    <br><br>
<div class="record-info">
    <br>
    <br>
    <h1 class="itemtitle">
        <div class="backbtn">
            <i class="fa fa-arrow-left" aria-hidden="true" type="button" value="Back to Search Results" title="Back to Search Results" onClick="history.go(-1);"></i>
        </div>
        {{ $title }}
    </h1>
    <div class="description">

        @foreach($recordDisplay as $key)
            @php $element = str_replace('.', '', $fieldMappings[$key] ?? '');
            @endphp
            @if(isset($record[$element]))
               <div class="row"><span class="field">{{$key}}</span></div>
               @foreach($record[$element] as $index => $metadatavalue)
               <p>Hello</p>
               @endforeach

            @endif
        @endforeach

    </div>
</div>


@endsection
