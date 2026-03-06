@extends('layouts.eerc')

@section('title', 'Interactive Map - EERC')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/css/ol.css" type="text/css">
<style>
    .map {
        height: 650px;
        width: 100%;
    }
    .ol-popup {
        position: absolute;
        background-color: white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        left: -50px;
        min-width: 200px;
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
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }
    .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 2px;
        right: 8px;
    }
    .ol-popup-closer:after {
        content: "✖";
    }
</style>
@endpush

@section('content')
<div class="col-md-9 col-sm-9 col-xs-12" style="margin-top: 20px;">
    <br>
    <div id="map" class="map"></div>
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>

    <br>
    <br>
    <div class="content byEditor">
        <h1 class="itemtitle">Explore our interactive map</h1>

        <div style="float: left;">
            <p>The above map displays key geographical locations mentioned in RESP interviews. Pan, zoom, and click on a pin to reveal the place name. Click on the link in the pop-up window to view all interviews relating to the chosen pin.</p>
            <p>More places will be added to the map as the digital catalogue grows.</p>
            <p style="color:#C20000; text-align:center;">Please bear with us if you find the map is running a little slow. We have been experiencing some technical difficulties but we are working on it.</p>
        </div>
    </div>
</div>

<div class="col-sidebar">
    <div class="col-md-3 col-sm-3 hidden-xs">
        <div class="sidebar-nav">
            @if(isset($subjectFacet) && !empty($subjectFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ url('/eerc/browse/Subject') }}">
                        Subject
                    </h4>
                </li>
                
                @foreach($subjectFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Subject:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($subjectFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ url('/eerc/browse/Subject') }}">More ...</a></li>
                @endif
            </ul>
            @endif
            
            @if(isset($personFacet) && !empty($personFacet['terms']))
            <ul class="list-group">
                <li class="list-group-item active">
                    <h4 href="{{ url('/eerc/browse/Person') }}">
                        Person
                    </h4>
                </li>
                
                @foreach($personFacet['terms'] as $term)
                <li class="list-group-item">
                    <span class="badge">{{ $term['count'] }}</span>
                    <a href='{{ url('/eerc/search/*:*/Person:"' . str_replace(' ', '+', urldecode($term['name'])) . '"') }}'>{{ $term['display_name'] }}</a>
                </li>
                @endforeach
                
                @if(count($personFacet['terms']) >= 10)
                <li class="list-group-item"><a href="{{ url('/eerc/browse/Person') }}">More ...</a></li>
                @endif
            </ul>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.15.1/build/ol.js"></script>
<script type="text/javascript">
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');

    var overlay = new ol.Overlay({
        element: container,
        autoPan: {
            animation: {
                duration: 250,
            },
        },
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
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
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
        const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
            return feature;
        });

        if (feature) {
            var coordinate = evt.coordinate;
            var Name = feature.get('title');

            content.innerHTML = '<p><b>' + Name + '</b></p><a href="/eerc/search/*:*/Subject:%22' + encodeURIComponent(Name) + '%22">Click here for related interviews</a>';
            overlay.setPosition(coordinate);
        }
    });

    map.on('pointermove', function (e) {
        var hit = this.forEachFeatureAtPixel(e.pixel, function(feature, layer) {
            return true;
        });
        if (hit) {
            this.getTargetElement().style.cursor = 'pointer';
        } else {
            this.getTargetElement().style.cursor = '';
        }
    });

    fetch('{{ asset('data/eerc_map_locations.json') }}')
        .then(response => response.json())
        .then(data => {
            data.locations.forEach(function(location) {
                addLocation(location.longitude, location.latitude, location.name);
            });
        })
        .catch(error => {
            console.error('Error loading map data:', error);
        });
</script>
@endpush
@endsection
