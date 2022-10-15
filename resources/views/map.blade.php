<?php
$css1 = 'http://local-next-lara.com' .'/css/MarkerCluster.css';
$css2 = 'http://local-next-lara.com'  .'/css/MarkerCluster.Default.css';
?>


<html>
    <head>
    <link rel="stylesheet" href="<?php echo $css1 ?>"/>
    <link rel="stylesheet" href="<?php echo $css2 ?>"/>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
     integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
     crossorigin=""/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<style>
#map { height: 500px; }
</style>

</head>
    <body>
<div id="map"></div>

<button class='set-btn'>Set</button>

<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
     integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
     crossorigin=""></script>

<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<script src="http://local-next-lara.com/js/test_data.js"></script>

<script>
var leafletMapSettings = {};
/* leafletMapSettings.center = [that.lat, that.lng]; */
leafletMapSettings.zoomControl = false;
leafletMapSettings.attributionControl = false;
/* leafletMapSettings.crs = L.CRS[that.settings.leaflet_settings.crs]; */

var map = L.map('map',leafletMapSettings).setView([46.963458, 31.986759], 13);

var markerLayer = L.layerGroup().addTo(map);


var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


/* L.circle([46.967737, 31.978481], { */
/*    interactive: false, */
/*    color: '#4285F4', */
/*    opacity: 0.3, */
/*    fillColor: '#4285F4', */
/*    fillOpacity: 0.15, */
/* radius: 500 */
/* }).addTo(map); */





let html1 =`<div><a href="/node/92" hreflang="uk">Ординці</a></div>
  <button class='popup-set-btn' id='home'>Обрати місто</button>`

let home = L.marker([46.963458, 31.986759]);
home.bindPopup(html1)




let dc = L.marker([46.967737, 31.978481]);
let dc1 = L.marker([46.967537, 31.978481]);

let dot3 = L.marker([46.95283440223558, 32.03293655932938]).addTo(map); 


/* let geoJson =  L.geoJSON('test_data', */ 

let group = L.layerGroup([dc, dc1,home,dot3]);


var options = {
            spiderfyOnMaxZoom:false,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            disableClusteringAtZoom: 15
          };

            /* options.zoomToBoundsOnClick = false; */
            /* options.iconCreateFunction = function (cluster) { */
            /*   var childCount = cluster.getChildCount(); */
            /*   var customMarkers = featureSettings.customMarkerSettings; */
            /*   var className = ' marker-cluster-'; */
            /*   var radius = 40; */

            /*   for (var size in customMarkers) { */
            /*     if (childCount < customMarkers[size].limit) { */
            /*       className += size; */
            /*       radius = customMarkers[size].radius; */
            /*       break; */
            /*     } */
            /*   } */

            /*   return new L.DivIcon({ */
            /*     html: '<div><span>' + childCount + '</span></div>', */
            /*     className: 'marker-cluster' + className, */
            /*     iconSize: new L.Point(radius, radius) */
            /*   }); */
            /* }; */

let cluster = L.markerClusterGroup(options);
/* cluster.addLayer(group); */
cluster.addLayer(group)
cluster.addTo(map);
// Add more layers

/* dc.bindPopup("Дикий сад"); */

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng)
        .openOn(map);
    console.log(e);
}

map.on('click', onMapClick);

$('body').on("click", ".popup-set-btn", function() {

console.log($(this).attr('id'))


});

$('body').on("click", ".set-btn", function() {
selectMarker(46.963458, 31.986759)


});

function selectMarker(lat,lng) {
map.flyTo([lat, lng], 15);
      /* map.panTo({lat: lat, lng: lng}); */
      /* map.setZoom(15); */
      /* map.panTo({lat: lat, lng: lng}); */
      /* map.setZoom(15); */
      /* map.panTo({lat: lat, lng: lng}); */

}

</script>

    </body>
</html>
