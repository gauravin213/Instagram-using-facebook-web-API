<?php

/*
Plugin Name: Gs Instagram Web Api
Description: This is the Custom Gs Instagram Web Api plugin
Author: Dev
Text Domain: gs-instagram
*/

//prefix: GsInstagram  

defined( 'ABSPATH' ) or die();

define( 'GsInstagram_VERSION', '1.0.0' );
define( 'GsInstagram_URL', plugin_dir_url( __FILE__ ) );
define( 'GsInstagram_PATH', plugin_dir_path( __FILE__ ) );

require_once 'api/instagram/InstagramApiClass.php';
require_once 'includes/gs-instagram-class.php';



add_shortcode('GsInstagram_pppppppppppppppppppppp', 'pppppppppppppppppppppp');

function pppppppppppppppppppppp(){

	?>

	<div class="grid">
  <div class="grid-sizer"></div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
  <div class="grid-item">
    <a href="#">
      <img src="http://127.0.0.1/wordpress/wp-content/uploads/2020/03/lb7-1.jpg">
      <p>This is the first post artical about you</p>
    </a>
  </div>
</div>


<style type="text/css">
/*.grid {
    max-width: 80%;
    margin: auto;
}*/
.grid-item img{
  width:100%;
}
.grid-item a p{
  text-align: center;
}

.grid-item {
  width: 30%;
  height: auto;
  border: 1px solid hsla(0, 0%, 0%, 0.5);
  margin-bottom: 10px;
}
</style>


<script type="text/javascript">
// init Masonry
var $grid = jQuery('.grid').masonry({
  itemSelector: '.grid-item',
  columnWidth: 20
});
// layout Masonry after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.masonry('layout');
});


</script>

	<?php

}