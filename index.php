<html>
<head>

  <title>Google Maps Integration</title>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/map.js"></script>
  <?php wp_head(); ?>

</head>
<body onload="initialize()">

  <?php if ( have_posts() ) : ?>

    <!-- Wordpress has matching posts -->
    <h1>Posts found! yay!</h1>
    <!-- Info windows for map markers -->
    <div style="display: none;">
      <?php $i = 1; ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php if ( get_post_meta($post->ID, 'latlng', true) !== '' ) : ?>
          <div id="item<?php echo $i; ?>">
            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
          </div>
        <?php endif; ?>
        <?php $i++; ?>
      <?php endwhile; ?>
    </div>

    <!-- Create map -->
    <div id="map" style="width: 50%; height: 50%;"></div>

      <!-- Loop through members and get address -->
    <div id-"members">
      <?php if ( bp_has_members( bp_ajax_querystring( 'members') ) ) : ?>
        <p>Yay, there are members!</p>
        <?php while ( bp_members() ) : bp_the_member(); ?>
          <ul>
            <li><?php bp_member_name(); ?></li>
            <li><?php bp_member_profile_data('field=address') ?></li>
          </ul>
        <?php endwhile; ?>
      <?php else : ?>
          <p>Boo, no members found.</p>
      <?php endif; ?>
    </div>

  <?php else : ?>
    <!-- Wordpress did not find posts -->
    <h1>Sorry there are no posts to show</h1>
  <?php endif; ?>

  <?php wp_footer(); ?>

  <script>
  <!-- Get latlng field from posts and store it in locations -->

    var locations = [
      <?php $i=1; while ( have_posts() ) : the_post(); ?>
        <?php if ( get_post_meta($post->ID, 'latlng', true) !== '' ) : ?>
          {
            latlng: new google.maps.LatLng<?php echo get_post_meta($post->ID, 'latlng', true); ?>,
            info : document.getElementById('item<?php echo $i; ?>')
          },
        <?php endif; ?>
      <?php $i++; endwhile; ?>
    ];

  </script>
    
</body>
</html>
