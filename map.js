var pinmarker = new google.maps.MarkerImage('/googlemaps/wp-content/themes/mytheme/pin.png', new google.maps.Size(20, 34) );

var infowindow = new google.maps.InfoWindow();

var latlngLst = [];
var bounds = new google.maps.LatLngBounds();

function initialize() {
  map = new google.maps.Map(document.getElementById('map'), { 
    zoom: 12, 
    center: new google.maps.LatLng(29.760615, -95.364075),
    mapTypeId: google.maps.MapTypeId.ROADMAP 
  });

  for (var i=0; i < locations.length; i++) {
    var marker = new google.maps.Marker({
      position: locations[i].latlng,
      map: map
    });
    latlngLst.push(marker.position);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i].info);
        infowindow.open(map, marker);
      }
    })(marker, i));

  }

  for (var i=0; i < latlngLst.length; i++) {
   bounds.extend (latlngLst[i]);
  }
  map.fitBounds(bounds); 
}
