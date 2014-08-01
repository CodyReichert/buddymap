<html>
<head>

  <title>Google Maps Integration</title>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCnG2OidRj-9tJe5AN3-gxRy0s_c8qdoCA&sensor=false"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
  <?php wp_head(); ?>

</head>
<body>

    <!-- Create map -->
    <div id="map" style="width: 50%; height: 50%;"></div>

    <!-- Loop through members and get address -->
    <div id-"members">

      <!-- do we have members? -->
      <?php if ( bp_has_members( bp_ajax_querystring( 'members') ) ) : ?>
        <p>Yay, there are members!</p>
        <?php bp_members_pagination_count(); ?>

        <!-- print out some user info -->
        <?php $i=1; while ( bp_members() ) : bp_the_member(); ?>
          <ul>
            <li><?php bp_member_name(); ?></li>
            <li><?php bp_member_profile_data('field=address') ?></li>
          </ul>

          <!-- Create the members info window -->
          <div style="display: none;" class="infowindow">
            <?php if ( bp_member_profile_data('field=address') !== '' ) : ?>
              <div id="item<?php echo $i; ?>">
                <p><?php bp_member_profile_data('field=address') ?></p>
              </div>
            <?php endif; ?>
          </div>

        <?php $i++; endwhile; ?>

      <!-- No members found -->
      <?php else : ?>
          <p>Boo, no members found.</p>
      <?php endif; ?>
    </div>

  <?php wp_footer(); ?>

  <script>

    //main map function
    function initialize() {

      var addresses = [];
      var infos = [];
      function getAddresses() {
          <?php if ( bp_has_members( bp_ajax_querystring( 'members') ) ) : ?>
            <?php $i=1; while ( bp_members() ) : bp_the_member(); ?>
                addresses.push("<?php bp_member_profile_data('field=address') ?>");
                infos.push(document.getElementById('item<?php echo $i; ?>'));
            <?php $i++; endwhile; ?>
          <?php endif; ?>
      }
      getAddresses();
      console.log(infos);

      // Initialize marker info windows
      var infowindow = new google.maps.InfoWindow();

      // Initialize geocoder
      var geocoder = new google.maps.Geocoder();

      //intialize list of lat/longs and google Bounds for default map zoom
      var locations = [];
      var bounds = new google.maps.LatLngBounds();

      //Create new map
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(29.760615, -95.364075),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      for (var x = 0; x < addresses.length; x++) {

        $.ajaxSetup({
          async: false
        });
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function(data, status) {
          var p = data.results[0].geometry.location;
          var latlng = new google.maps.LatLng(p.lat, p.lng);
          locations.push(latlng);
          console.log(latlng);

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
      $.ajaxSetup({
        async: true
      });
      map.fitBounds(bounds);
    }
    initialize();

  </script>

</body>
</html>
