@extends('layouts.eerc-v2')

@section('title', 'Interactive Map - RESP Archive')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css" type="text/css">
<style>
    .ol-popup {
        position: absolute;
        background-color: white;
        box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.15), 0 4px 10px -3px rgb(0 0 0 / 0.1);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        min-width: 240px;
        max-width: 300px;
        overflow: hidden;
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
        top: 8px;
        right: 10px;
        font-size: 0.875rem;
        z-index: 10;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        color: #6b7280;
        transition: all 150ms;
    }
    .ol-popup-closer:hover {
        color: #111827;
        background: #f3f4f6;
    }
    .ol-popup-closer:after { content: "✕"; }
    .popup-thumb {
        width: 100%;
        height: 120px;
        object-fit: cover;
        display: block;
    }
    .popup-body {
        padding: 0.75rem 1rem 1rem;
    }
    .popup-placeholder {
        width: 100%;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        color: white;
    }
    .popup-placeholder svg { width: 2.5rem; height: 2.5rem; opacity: 0.6; }
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

        <div class="mt-6 prose prose-lg max-w-none">
            <p>The above map displays key geographical locations mentioned in RESP interviews. Pan, zoom, and click on a pin to reveal the place name. Click on the link in the pop-up window to view all interviews relating to the chosen pin.</p>
            <p>Map data is refreshed automatically. More places will be added as the digital catalogue grows.</p>
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
    var mapLocations = {};

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

    function buildPopupHtml(name, data) {
        var html = '';
        var searchUrl = '/eerc/search/*:*/Subject:%22' + encodeURIComponent(name) + '%22';

        if (data && data.thumbnail_url) {
            html += '<a href="' + searchUrl + '"><img src="' + data.thumbnail_url + '" alt="' + name + '" class="popup-thumb" onerror="this.parentNode.outerHTML=buildPlaceholderSvg()"></a>';
        } else {
            html += '<div class="popup-placeholder"><svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg></div>';
        }

        html += '<div class="popup-body">';
        html += '<h3 style="margin:0 0 0.25rem; font-size:1rem; font-weight:700; color:#111827;">' + name + '</h3>';

        if (data && data.interview_count > 0) {
            html += '<p style="margin:0 0 0.5rem; font-size:0.8125rem; color:#6b7280;">';
            html += '<svg style="display:inline; width:0.875rem; height:0.875rem; vertical-align:-2px; margin-right:2px;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>';
            html += data.interview_count + ' record' + (data.interview_count !== 1 ? 's' : '') + '</p>';
        }

        html += '<a href="' + searchUrl + '" style="display:inline-flex; align-items:center; gap:0.25rem; font-size:0.8125rem; font-weight:600; color:#0d9488; text-decoration:none;">';
        html += 'Browse interviews';
        html += '<svg style="width:0.75rem; height:0.75rem;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>';
        html += '</a>';
        html += '</div>';

        return html;
    }

    function buildPlaceholderSvg() {
        return '<div class="popup-placeholder"><svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg></div>';
    }

    map.on('singleclick', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) { return feature; });
        if (feature) {
            var coordinate = evt.coordinate;
            var name = feature.get('title');
            var data = mapLocations[name] || null;
            content.innerHTML = buildPopupHtml(name, data);
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
                mapLocations[location.name] = location;
                addLocation(location.longitude, location.latitude, location.name);
            });
        })
        .catch(function(error) {
            console.error('Error loading map data:', error);
        });
</script>
@endpush
@endsection
