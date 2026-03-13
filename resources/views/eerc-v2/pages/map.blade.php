@extends('layouts.eerc-v2')

@section('title', 'Interactive Map - RESP Archive')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css" type="text/css">
<style>
    .ol-popup {
        position: absolute;
        background-color: white;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        min-width: 180px;
    }
    .ol-popup:after, .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }
    .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
    }
    .ol-popup:before {
        border-top-color: #e5e7eb;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }
    .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 4px;
        right: 8px;
        font-size: 1.25rem;
        color: #6b7280;
    }
    .ol-popup-closer:hover { color: #111827; }
    .ol-popup-closer:after { content: "✕"; }
</style>
@endpush

@section('content')
<div class="lg:grid lg:grid-cols-4 lg:gap-8">
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Interactive Map</h1>

        <div class="mt-6 overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <div id="map" style="height: 600px; width: 100%;"></div>
        </div>
        <div id="popup" class="ol-popup">
            <a href="#" id="popup-closer" class="ol-popup-closer"></a>
            <div id="popup-content"></div>
        </div>

        <div class="mt-6 prose max-w-none">
            <p>The above map displays key geographical locations mentioned in RESP interviews. Pan, zoom, and click on a pin to reveal the place name. Click on the link in the pop-up window to view all interviews relating to the chosen pin.</p>
            <p>More places will be added to the map as the digital catalogue grows.</p>
        </div>
    </div>

    <div class="mt-8 lg:mt-0">
        @include('eerc-v2.partials.sidebar')
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
<script>
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');

    var overlay = new ol.Overlay({
        element: container,
        autoPan: { animation: { duration: 250 } },
    });

    closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    };

    var vectorSource = new ol.source.Vector();
    var vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: new ol.style.Style({
            image: new ol.style.Icon(({
                scale: 0.5,
                rotateWithView: false,
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                opacity: 1,
                src: 'https://raw.githubusercontent.com/jonataswalker/map-utils/master/images/marker.png'
            })),
            zIndex: 5
        })
    });

    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({ source: new ol.source.OSM() }),
            vectorLayer
        ],
        overlays: [overlay],
        view: new ol.View({
            center: ol.proj.fromLonLat([-3.55, 57.7901]),
            zoom: 6
        })
    });

    function addLocation(lon, lat, title) {
        var poi = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([Number(lon), Number(lat)])),
            title: title
        });
        vectorSource.addFeature(poi);
    }

    map.on('singleclick', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) { return feature; });
        if (feature) {
            var coordinate = evt.coordinate;
            var Name = feature.get('title');
            content.innerHTML = '<p class="font-semibold text-gray-900">' + Name + '</p><a href="/eerc/search/*:*/Subject:%22' + encodeURIComponent(Name) + '%22" class="text-sm text-resp-teal-600 hover:underline">Related interviews &rarr;</a>';
            overlay.setPosition(coordinate);
        }
    });

    map.on('pointermove', function(e) {
        var hit = this.forEachFeatureAtPixel(e.pixel, function() { return true; });
        this.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });

    fetch('{{ asset('data/eerc_map_locations.json') }}')
        .then(function(response) { return response.json(); })
        .then(function(data) {
            data.locations.forEach(function(location) {
                addLocation(location.longitude, location.latitude, location.name);
            });
        })
        .catch(function(error) {
            console.error('Error loading map data:', error);
        });
</script>
@endpush
@endsection
