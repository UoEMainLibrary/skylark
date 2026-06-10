import Map from 'ol/Map.js';
import View from 'ol/View.js';
import OSM from 'ol/source/OSM.js';
import Feature from 'ol/Feature.js';
import Point from 'ol/geom/Point.js';
import {fromLonLat} from 'ol/proj.js';
import VectorSource from 'ol/source/Vector.js';
import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer.js';
import {Icon, Style} from 'ol/style.js';
import {defaults as defaultInteractions, MouseWheelZoom} from 'ol/interaction.js';
import {focus} from 'ol/events/condition.js';

var recordPinIcon = window.publicArtRecordPinIcon || '/collections/public-art/map/pinpoint.png';

var poi = new Feature({
        geometry: new Point(fromLonLat([Number(lon), Number(lat)]))
      });
poi.setStyle(new Style({
        image: new Icon(/** @type {module:ol/style/Icon~Options} */ ({
          crossOrigin: 'anonymous',
          src: recordPinIcon,
          scale: 1.25
        }))
      }));

var vectorSource = new VectorSource({
      features: [poi]
      });
var vectorLayer = new VectorLayer({
      source: vectorSource
      });

new Map({
       interactions: defaultInteractions({mouseWheelZoom: false}).extend([
         new MouseWheelZoom({
           constrainResolution: true, // force zooming to a integer zoom
           condition: focus // only wheel/trackpad zoom when the map has the focus
         })
      ]),
      layers: [
        new TileLayer({
          source: new OSM()
        }),
        vectorLayer
      ],
      target: 'map',
      view: new View({
        //projection: 'EPSG:4326',
        center: fromLonLat([Number(lon), Number(lat)]),
        zoom: 18
      })
    });
