// Initialize marker info windows
var infowindow = new google.maps.InfoWindow();

// Initialize geocoder
var geocoder = new google.maps.Geocoder();

//intialize list of lat/longs and google Bounds for default map zoom
var latlngLst = [];
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
    geocoder.geocode( { 'address': addresses[i]}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        locations.push(results[0].geometry.location);
      } else {
        console.log("geocoding failed");
        console.log(addresses[i]);
      }
    });
  }

  //place markers on map
  for (var i=0; i < locations.length; i++) {
    var marker = new google.maps.Marker({
      position: locations[i].latlng,
      map: map
    });
    //push locations to list for map zooming
    latlngLst.push(marker.position);

    //create info window and open on click
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i].info);
        infowindow.open(map, marker);
      }
    })(marker, i));
  }

  // create boundries for map zoom
  for (var i=0; i < latlngLst.length; i++) {
   bounds.extend (latlngLst[i]);
  }
  // fit map to created bounds
  map.fitBounds(bounds); 
}
