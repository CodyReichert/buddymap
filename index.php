<html>
<head>

  <title>Google Maps Integration</title>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/map.js"></script>
  <?php wp_head(); ?>

</head>
<body onload="initialize()">

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

    var addresses = [];
    function codeAddress() {
        <?php if ( bp_has_members( bp_ajax_querystring( 'members') ) ) : ?>
          <?php $i=1; while ( bp_members() ) : bp_the_member(); ?>
              addresses.push("<?php bp_member_profile_data('field=address') ?>");
          <?php $i++; endwhile; ?>
        <?php endif; ?>
    }
    codeAddress();

    var locations = [
      <?php if ( bp_has_members( bp_ajax_querystring( 'members') ) ) : ?>
        <?php $i=1; while ( bp_members() ) : bp_the_member(); ?>
            {
              latlng: new google.maps.LatLng<?php bp_member_profile_data('field=address') ?>,
              info : document.getElementById('item<?php echo $i; ?>')
            },
        <?php $i++; endwhile; ?>
      <?php endif; ?>
    ];

  </script>

</body>
</html>
