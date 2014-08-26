// Initialize marker info windows
var infowindow = new google.maps.InfoWindow();

// Initialize geocoder
var geocoder = new google.maps.Geocoder();

//intialize list of lat/longs and google Bounds for default map zoom
var locations = [];
var bounds = new google.maps.LatLngBounds();

//main map function
function initialize() {

  //Create new map
  map = new google.maps.Map(document.getElementById('map'), { 
    zoom: 12, 
    center: new google.maps.LatLng(29.760615, -95.364075),
    mapTypeId: google.maps.MapTypeId.ROADMAP 
  });

  for (var x = 0; x < addresses.length; x++) {

    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function(data) {
      var p = data.results[0].geometry.location;
      var latlng = new google.maps.LatLng(p.lat, p.lng);
      locations.push(latlng);
      console.log(latlng);

      //new google.maps.Marker({
      //  position: latlng,
      //  map: map
      //});

      var marker = new google.maps.Marker({
        position: latlng,
        map: map
      });

      bounds.extend(marker.position);

      google.maps.event.addListener(marker, 'click', (function(marker, x) {
        return function() {
          infowindow.setContent(infos[x].innerText);
          infowindow.open(map, marker);
        };
      })(marker, x));

    });
  }
  map.fitBounds(bounds);

  var listener = google.maps.event.addListener(map, "idle", function() {
      map.setZoom(3);
      google.maps.event.removeListener(listener);
  });
}
