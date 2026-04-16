import Map from 'ol/Map.js';
import View from 'ol/View.js';
import OSM from 'ol/source/OSM.js';
import Feature from 'ol/Feature.js';
import Point from 'ol/geom/Point.js';
import {fromLonLat} from 'ol/proj.js';
import VectorSource from 'ol/source/Vector.js';
import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer.js';
import {Icon, Style, Text, Fill} from 'ol/style.js';
import {defaults as defaultInteractions, MouseWheelZoom} from 'ol/interaction.js';
import {focus} from 'ol/events/condition.js';

//create map

var map = new Map({
       interactions: defaultInteractions({mouseWheelZoom: true}).extend([
         new MouseWheelZoom({
           constrainResolution: true, // force zooming to a integer zoom
           condition: focus // only wheel/trackpad zoom when the map has the focus
         })
      ]),
      layers: [
        new TileLayer({
          source: new OSM()
        }),
      ],
      target: 'map',
      view: new View({
        //projection: 'EPSG:4326',
        center: fromLonLat([-3.2011654948030355,55.86597723885854]),
        zoom: 12
      })
    });

//read in features from json
var lon;
var lat;
var title;
var oldFeature;
function addLocation(lon, lat, record, title, image){
    var poi = new Feature({
        geometry: new Point(fromLonLat([Number(lon), Number(lat)])),
        title: title,
        record: record,
        image: image
        });
    poi.setStyle(new Style({
          image: new Icon(/** @type {module:ol/style/Icon~Options} */ ({
            crossOrigin: null,
            src: 'https://collections.ed.ac.uk/theme/public-art/locations/pinpoint.png',
            scale: 1.25
          })),
          overflow: true
        }));

    var vectorSource = new VectorSource({
        features: [poi]
        });
    var vectorLayer = new VectorLayer({
        source: vectorSource
        });
    map.addLayer(vectorLayer);
    oldFeature = poi;
    }


    var arrayLength = locationsArray.length;
    for (var i = 0; i < arrayLength; i++) {
        addLocation(locationsArray[i][0], locationsArray[i][1], locationsArray[i][2], locationsArray[i][3], locationsArray[i][4]);
    }
    map.on('singleclick', function(e) {
        map.forEachFeatureAtPixel(e.pixel, function(feature) {
              window.location.href = feature.values_.record
              });
        })
    map.on('pointermove', function(e){
      map.forEachFeatureAtPixel(e.pixel, function(feature) {
        oldFeature.setStyle(new Style({
              image: new Icon(/** @type {module:ol/style/Icon~Options} */ ({
                crossOrigin: null,
                src: 'https://collections.ed.ac.uk/theme/public-art/locations/pinpoint.png',
                scale: 1.25
              })),
              overflow: true
            }));
        feature.setStyle(new Style({
              image: new Icon(/** @type {module:ol/style/Icon~Options} */ ({
                crossOrigin: null,
                src: 'https://collections.ed.ac.uk/theme/public-art/locations/pinpoint2.png',
                scale: 1.50
              })),
              overflow: true,
              text: new Text({
                text: feature.values_.title,
                font: '12px helvetica',
                offsetY: -30,
                padding: [5,5,5,5],
                backgroundFill: new Fill({
                    color: '#fff'
                })
              })
            }));
            oldFeature = feature;
            });
    })
