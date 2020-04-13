<?php

defined( 'ABSPATH' ) || exit;


/**
 * 
 */
class GsInstagramClass{

	protected $Instagram_obj;
	
	function __construct(){

		$this->Instagram_obj = new InstagramApiClass;

		add_action('admin_enqueue_scripts', array($this, 'GsInstagram_admin_enqueue_scripts_fun'), 10, 1);
		add_action('wp_enqueue_scripts', array($this, 'GsInstagram_wp_enqueue_scripts_fun'), 10, 1);

		add_action( 'admin_menu', array($this, 'GsInstagram_admin_menu'));
		add_action('wp_footer', array($this, 'GsInstagram_footer_catch_code_fun'));

		//Ajax
		add_action( 'wp_ajax_next_url_instagram_data_my_action', array($this, 'next_url_instagram_data_my_action_function'));
		add_action( 'wp_ajax_nopriv_next_url_instagram_data_my_action', array($this, 'next_url_instagram_data_my_action_function'));

		add_action( 'wp_ajax_get_long_live_access_token_my_action', array($this, 'get_long_live_access_token_my_action_ajax_function'));
		add_action( 'wp_ajax_nopriv_get_long_live_access_token_my_action', array($this, 'get_long_live_access_token_my_action_ajax_function'));

		add_action( 'wp_ajax_save_instagram_data_my_action', array($this, 'save_instagram_data_my_action_function'));
		add_action( 'wp_ajax_nopriv_save_instagram_data_my_action', array($this, 'save_instagram_data_my_action_function'));

		//Shortcode
		add_shortcode('GsInstagram_feed', array($this, 'GsInstagram_feed_shortcode_function'));
		add_action( 'init',  array($this, 'GsInstagram_init_fun' ));

	}

	public function GsInstagram_admin_enqueue_scripts_fun(){

		wp_enqueue_style('GsInstagram_admin_style', GsInstagram_URL.'/assets/css/GsInstagram-admin.css', array(), '1.0', 'all' );

		wp_register_script( 'GsInstagram_admin_js', GsInstagram_URL.'assets/js/GsInstagram-admin.js', array( 'jquery' ), '1.0', true );

		$data = array(
	        'ajaxurl'=> admin_url( 'admin-ajax.php')
	    );
	    wp_localize_script( 'GsInstagram_admin_js', 'datab', $data );

	    wp_enqueue_script( 'GsInstagram_admin_js' );

	}

	public function GsInstagram_wp_enqueue_scripts_fun(){

		wp_enqueue_style('GsInstagram_frontend_style', GsInstagram_URL.'/assets/css/GsInstagram-frontend.css', array(), '1.0', 'all' );

		wp_register_script( 'GsInstagram_frontend_js', GsInstagram_URL.'assets/js/GsInstagram-frontend.js', array( 'jquery' ), '1.0', true );

		$data = array(
	        'ajaxurl'=> admin_url( 'admin-ajax.php')
	    );
	    wp_localize_script( 'GsInstagram_frontend_js', 'datab', $data );

	    wp_enqueue_script( 'GsInstagram_frontend_js' );


	    //masonry CDN
	    wp_enqueue_script( 'GsInstagram_masonry_js', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js');
	    wp_enqueue_script( 'GsInstagram_imagesloaded_js', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js');

	}


	public function GsInstagram_admin_menu(){

	    $title = "Gs instagram";
	    add_options_page($title, $title, 'manage_options', 'gs-instagram', array($this, 'GsInstagram_add_menu_page_fun'));

	}

	public function GsInstagram_add_menu_page_fun(){

		require_once GsInstagram_PATH.'admin/admin-settings-options-page.php';
	}

	public function next_url_instagram_data_my_action_function(){

	    $next_url = $_POST['next_url'];

	    $response = $this->Instagram_obj->get_user_media_paging($next_url);

	    $htm = "";

	    foreach ($response->data as $data) {
	        
	        if ($data->media_type == 'VIDEO') {   

            	$htm2 = '<img src="'.$data->thumbnail_url.'" alt="Video">';

	        }else if($data->media_type == 'IMAGE'){
	    
	        	$htm2 = '<img src="'.$data->media_url.'" alt="IMAGE">';

	        }else if($data->media_type == 'CAROUSEL_ALBUM'){

	            $htm2 = '<img src="'.$data->media_url.'" alt="CAROUSEL_ALBUM">';
	                    
	        } 

	        $htm .= '<div class="grid-item">
	                  <a href="'.$data->permalink.'" target="_blank">'.$htm2.'<p>'.$data->caption.'</p></a>
	              </div>';

	    }

	    
	    $paging = $response->paging;
	    $next_url = $paging->next;

	    $myArr = array(
	        'response' => $response,
	        'htm' => $htm,
	        'next_url' => $next_url
	    );
	    $myJSON = json_encode($myArr); 
	    echo $myJSON;
	    die();
	}


	public function get_long_live_access_token_my_action_ajax_function(){

	    $short_live_access_token = $_POST['short_live_access_token'];

	    $client_secret =  $_POST['client_secret']; 

	    //Get long live accress token 
	    $response1 = $this->Instagram_obj->get_long_lived_access_token($client_secret, $short_live_access_token);
	    $get_long_live_access_token = $response1->access_token;


	    //Refresh Long live access token
	    $response2 = $this->Instagram_obj->refresh_long_lived_access_token($get_long_live_access_token);
	    $get_refresh_long_live_access_token = $response2->access_token;

	    update_option('GsInstagram_access_token', $get_refresh_long_live_access_token);
	    update_option('GsInstagram_access_token_status', 'long_live_access_token');

	    $myArr = array(
	        'response1' => $response1,
	        'response2' => $response2,
	        'short_live_access_token' => $short_live_access_token,
	        'client_secret' => $client_secret,
	        'get_long_live_access_token' => $get_long_live_access_token,
	        'get_refresh_long_live_access_token' => $get_refresh_long_live_access_token,
	    );
	    $myJSON = json_encode($myArr); 
	    echo $myJSON;
	    die();
	}


	public function GsInstagram_feed_shortcode_function(){

		ob_start();

		require_once GsInstagram_PATH.'template/feed-list.php';

		return ob_get_clean();
	}

	public function GsInstagram_footer_catch_code_fun(){

	    $code = $_GET['code'];

	    if (isset($code)) {

	        $client_id = get_option('GsInstagram_clientid');

	        $client_secret = get_option('GsInstagram_client_secret');

	        $redirect_url = get_option('GsInstagram_redirect_url');

	        $response = $this->Instagram_obj->get_short_lived_access_token($client_id, $client_secret, $redirect_url, $code);

	        $access_token = $response->access_token;

	        $access_token_user_id = $response->user_id;
	    }


	    $flag = 0;

	    if (!empty($access_token) && !empty($access_token_user_id)) { 
	        $flag = 1;
	        update_option('GsInstagram_access_token', $access_token);
	        update_option('GsInstagram_user_id', $access_token_user_id);
	        update_option('GsInstagram_access_token_status', 'short_live_access_token');
	    }else{ 
	        $flag = 0;
	        echo "<pre>"; print_r($response); echo "</pre>";
	    }


	    if ($flag) {

	        $admin_url = admin_url().'options-general.php?page=gs-instagram';

	        ?>
	        <script type="text/javascript">
	            jQuery(document).ready(function(){
	                setTimeout(function(){ 
	                   window.location.href = '<?php echo $admin_url;?>';
	                }, 3000);
	                localStorage.setItem("gs_insta_handle", "succ");
	            });
	        </script>

	        <div class="InnerPageBannerOverlayLoaderClass"></div>

	        <style type="text/css">
	            .InnerPageBannerOverlayLoaderClass{
	                position: absolute;
	                display: block;
	                width: 100%;
	                height: 100%;
	                top: 0;
	                left: 0;
	                right: 0;
	                bottom: 0;
	                background-color: rgba(167, 159, 159, 0.5);
	                z-index: 9999;
	                cursor: pointer;
	                background-image: url('<?php echo GsInstagram_URL?>/assets/images/spinner-2x.gif');
	                background-repeat: no-repeat;
	                background-position: center;
	            }
	        </style>
	        <?php
	    }

	}


	public function GsInstagram_init_fun() {
	    global $GsInstagram_instagram_response, $GsInstagram_user_profile;
	    $GsInstagram_instagram_response = get_option('GsInstagram_feed_save');
	    $GsInstagram_user_profile = get_option('GsInstagram_profile_save');
	}
	

	public function save_instagram_data_my_action_function(){

	    $GsInstagram_access_token = $_POST['GsInstagram_access_token'];

	    $GsInstagram_user_id =  $_POST['GsInstagram_user_id']; 

	    $access_token = get_option('GsInstagram_access_token');

	    //Get user profile
	    $response1 = $this->Instagram_obj->get_user_media($GsInstagram_access_token);
	    update_option('GsInstagram_feed_save', $response1);

	    //Get user account info
	    $response2 = $this->Instagram_obj->get_user_profile($GsInstagram_user_id, $GsInstagram_access_token);
	    update_option('GsInstagram_profile_save', $response2);
	  
	    $myArr = array(
	        'response' => 'save data 22',
	        'response1' => $response1,
	        'response2' => $response2
	    );
	    $myJSON = json_encode($myArr); 
	    echo $myJSON;
	    die();
	}	
}
new GsInstagramClass;