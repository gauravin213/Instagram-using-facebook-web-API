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


//require_once 'api/instagram/InstagramApiClass.php';


add_action('admin_enqueue_scripts', 'GsInstagram_admin_enqueue_scripts_fun', 10, 1);
function GsInstagram_admin_enqueue_scripts_fun(){

}


add_action( 'admin_menu', 'GsInstagram_admin_menu');
function GsInstagram_admin_menu(){

    $title = "Gs instagram";
    add_options_page($title, $title, 'manage_options', 'gs-instagram', 'GsInstagram_add_menu_page_fun');

}


function GsInstagram_add_menu_page_fun(){

    $client_id = get_option('GsInstagram_clientid');
    $client_secret = get_option('GsInstagram_client_secret');
    $redirect_url = get_option('GsInstagram_redirect_url');
    $access_token = get_option('GsInstagram_access_token');
    $GsInstagram_user_id = get_option('GsInstagram_user_id');

    $GsInstagram_access_token_status = get_option('GsInstagram_access_token_status');

    $get_code_url = 'https://api.instagram.com/oauth/authorize?client_id='.$client_id.'&redirect_uri='.$redirect_url.'&scope=user_profile,user_media&response_type=code';

    global $GsInstagram_instagram_response, $GsInstagram_user_profile;
    

    //
   /* $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://graph.instagram.com/".$GsInstagram_user_id."?fields=id,username,media_count&access_token=".$access_token,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
      ),
    ));

    $response2 = curl_exec($curl);
    curl_close($curl);
    $response2 = json_decode($response2);
    $GsInstagram_user_profile = $response2;*/
    //

    //echo "<pre>"; print_r($GsInstagram_user_profile); echo "</pre>";




    ?>
    <div class="wrap">

        <h1 class="wp-heading-inline"><?php _e( 'Gs Instagram Settings', 'tmm-desred' ); ?></h1><hr class="wp-header-end">

        <form action="options.php" method="post">
        <?php wp_nonce_field('update-options') ?>


        <div id="InnerPageBannerOverlayLoader"></div>

        <div id="GsInstagram_msg_body"></div>


        <a href="javascript://" id="GsInstagramFeedsSaveToDatabase">Save to database</a>

        <table class="form-table">

            <tbody>

            <?php /* unset($GsInstagram_user_profile->media_count);*/ if (empty($GsInstagram_user_profile->error)) {  ?>

                <?php  foreach ($GsInstagram_user_profile as $key => $value) { $column_name = ucwords(str_replace("_"," ",$key)); ?>
        
                    <tr>
                        <th scope="row">
                            <label><?php echo $column_name;?></label>
                        </th>
                    
                        <td>
                         <?php echo $value;?>
                        </td>
                    
                    </tr>

                <?php  } ?>
         
            <?php }else{
                 //echo "<pre>"; print_r($GsInstagram_user_profile); echo "</pre>";
            } ?>


            <tr>
                <th scope="row">
                    <label><?php echo _e('Token Type', 'my-insta-feed');?></label>
                </th>
            
                <td>
                    <?php
                     if ($GsInstagram_access_token_status == 'short_live_access_token') {
                       ?>   
                        <label class="access_token_msg1">Short lived access token valid for one hour</label>
                       <?php
                    }else if ($GsInstagram_access_token_status == 'long_live_access_token') {
                       ?>   
                        <label class="access_token_msg2">Long lived access token valid for 60 Days</label>
                       <?php
                    }else{
                       //
                    }
                    ?>
                   
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('Get Short Live Access Token', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <a href="<?php echo $get_code_url;?>" class="button button-primary" id="myGetAccessTokenLink">Get Short Lived Access Token</a>
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label><?php echo _e('Get Long Live Access Token ', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <a href="javascript://" class="button button-primary" id="GsInstagramLongLiveAccessToken">Get Long Lived Access Token</a>
                </td>
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('For Developer', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <pre>User global $GsInstagram_instagram_response;</pre>
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('Shortcode', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <pre>[GsInstagram_feed]</pre>
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('Client Id', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <input name="GsInstagram_clientid" id="GsInstagram_clientid" type="text" class="regular-text" value="<?php if (get_option('GsInstagram_clientid')) echo get_option('GsInstagram_clientid'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label><?php echo _e('Client Secret', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <input name="GsInstagram_client_secret" id="GsInstagram_client_secret" type="text" class="regular-text" value="<?php if (get_option('GsInstagram_client_secret')) echo get_option('GsInstagram_client_secret'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label><?php echo _e('redirect_url', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <input name="GsInstagram_redirect_url" id="GsInstagram_redirect_url" type="text" class="regular-text" value="<?php if (get_option('GsInstagram_redirect_url')) echo get_option('GsInstagram_redirect_url'); ?>">
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('Access Token', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <input name="GsInstagram_access_token" id="GsInstagram_access_token" type="text" class="regular-text" value="<?php if (get_option('GsInstagram_access_token')) echo get_option('GsInstagram_access_token'); ?>">
                </td>
            
            </tr>


            <tr>
                <th scope="row">
                    <label><?php echo _e('User ID', 'my-insta-feed');?></label>
                </th>
            
                <td>
                <input name="GsInstagram_user_id" id="GsInstagram_user_id" type="text" class="regular-text" value="<?php if (get_option('GsInstagram_user_id')) echo get_option('GsInstagram_user_id'); ?>">
                </td>
            
            </tr>

            </tbody>

        </table>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="GsInstagram_clientid, GsInstagram_client_secret, GsInstagram_redirect_url, GsInstagram_access_token,GsInstagram_user_id" />
      
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>

    </form>

    <style type="text/css">
    .access-token-succ-msg{
        background-color: #447944;
        color: #fff;
        padding: 5px;
        border-radius: 2px;
        font-size: 14px;
        width: 100%;
    }

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
        background-image: url('<?php echo GsInstagram_URL?>/spinner-2x.gif');
        background-repeat: no-repeat;
        background-position: center;
    }


    .GsInstagram-Error-mag{
        background-color: #c55757;
        color: #fff;
        padding: 5px;
        border-radius: 2px;
        margin-top: 15px;
    }

    .access_token_msg1{
        background-color: #dd5757;color: #ffff;font-weight: 400;padding: 10px;
    }
    .access_token_msg2{
        background-color: #77b477;color: #ffff;font-weight: 400;padding: 10px;
    }
    </style>

    <script type="text/javascript">
      jQuery(document).ready(function(){

        var gs_insta_handle = localStorage.getItem("gs_insta_handle");

        if (gs_insta_handle !="" && gs_insta_handle == "succ") {

            jQuery('#GsInstagram_msg_body').html('<div class="access-token-succ-msg">Access token and user id updated successfully</div>');

            setTimeout(function(){ 
                 jQuery('.access-token-succ-msg').remove();
                 localStorage.setItem("gs_insta_handle", "");
            }, 6000);

        }

        jQuery(document).on('click', '#myGetAccessTokenLink', function(){

            jQuery('#InnerPageBannerOverlayLoader').addClass('InnerPageBannerOverlayLoaderClass');

        });


        jQuery(document).on('click', '#GsInstagramLongLiveAccessToken', function(e){

            e.preventDefault();

            jQuery('#InnerPageBannerOverlayLoader').addClass('InnerPageBannerOverlayLoaderClass');

            var short_live_access_token = jQuery('#GsInstagram_access_token').val(); 
            var client_secret = jQuery('#GsInstagram_client_secret').val();
            //Ajax
            jQuery.ajax({
                url: '<?php echo admin_url( 'admin-ajax.php');?>',
                type: "POST",
                data: {'action': 'get_long_live_access_token_my_action', 'short_live_access_token': short_live_access_token, 'client_secret': client_secret},
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function (response) { 

                    jQuery('#InnerPageBannerOverlayLoader').removeClass('InnerPageBannerOverlayLoaderClass');
                    jQuery('#GsInstagram_msg_body').html('<div class="access-token-succ-msg">Long live Access token updated successfully</div>');

                    setTimeout(function(){ 
                        jQuery('.access-token-succ-msg').remove();
                    }, 6000);

                    window.location.href =window.location.href;

                    console.log(response);
                }
                //Ajax

            });
            //Ajax

        });



        jQuery(document).on('click', '#GsInstagramFeedsSaveToDatabase', function(e){ 

            e.preventDefault();

            jQuery('#InnerPageBannerOverlayLoader').addClass('InnerPageBannerOverlayLoaderClass');

            var GsInstagram_access_token = jQuery('#GsInstagram_access_token').val(); 
            var GsInstagram_user_id = jQuery('#GsInstagram_user_id').val();

            //Ajax
            jQuery.ajax({
                url: '<?php echo admin_url( 'admin-ajax.php');?>',
                type: "POST",
                data: {'action': 'save_instagram_data_my_action', 'GsInstagram_access_token': GsInstagram_access_token, 'GsInstagram_user_id': GsInstagram_user_id},
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                },
                complete: function(){
                },
                success: function (response) { console.log(response);

                    jQuery('#InnerPageBannerOverlayLoader').removeClass('InnerPageBannerOverlayLoaderClass');
                    jQuery('#GsInstagram_msg_body').html('<div class="access-token-succ-msg">Data save successfully</div>');

                    setTimeout(function(){ 
                        jQuery('.access-token-succ-msg').remove();
                    }, 6000);

                    window.location.href =window.location.href;

                    
                }
                //Ajax

            });
            //Ajax

        });



        

      });
    </script>

    </div>
    <?php
}




add_action( 'wp_ajax_next_url_instagram_data_my_action', 'next_url_instagram_data_my_action_function');
add_action( 'wp_ajax_nopriv_next_url_instagram_data_my_action', 'next_url_instagram_data_my_action_function');
function next_url_instagram_data_my_action_function(){

    $next_url = $_POST['next_url'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $next_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    //echo $response;

    $response = json_decode($response);

    /*global $GsInstagram_instagram_response;
    $response = $GsInstagram_instagram_response;*/

    $htm = "";

    foreach ($response->data as $data) {
        

        if ($data->media_type == 'VIDEO') {   
         
           $htm2 = '<div class="new-media-option" style="background-image:url('.$data->thumbnail_url.');"></div>';

             //$htm2 = '<div class="new-media-option"><img src="" alt="Video">Video</div>';     
                   
        }else if($data->media_type == 'IMAGE'){
    
           $htm2 = '<div class="new-media-option" style="background-image:url('.$data->media_url.');"></div>';

            //$htm2 = '<div class="new-media-option">IMAGE</div>';
                
        }else if($data->media_type == 'CAROUSEL_ALBUM'){

            $htm2 = '<div class="new-media-option" style="background-image:url('.$data->media_url.');"></div>';

            //$htm2 = '<div class="new-media-option">CAROUSEL_ALBUM</div>';
                    
        } 


        $htm .= '<div class="col-md-4 insta-col-4 grid-boxs li">
                <div class="thumbnail">
                  <a href="<?php echo $data->permalink;?>" target="_blank">
                    <div class="media-cont-new">'.$htm2.'</div>
                    <div class="caption">
                      <p>'.$data->caption.'</p>
                    </div>
                  </a>
                </div>
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





add_action( 'wp_ajax_save_instagram_data_my_action', 'save_instagram_data_my_action_function');
add_action( 'wp_ajax_nopriv_save_instagram_data_my_action', 'save_instagram_data_my_action_function');
function save_instagram_data_my_action_function(){

    $GsInstagram_access_token = $_POST['GsInstagram_access_token'];

    $GsInstagram_user_id =  $_POST['GsInstagram_user_id']; 

    $access_token = get_option('GsInstagram_access_token');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://graph.instagram.com/me/media?fields=id,username,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token=".$GsInstagram_access_token,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
      ),
    ));

    $response1 = curl_exec($curl);

    curl_close($curl);

    $response1 = json_decode($response1);

    update_option('GsInstagram_feed_save', $response1);

    //Get user account info
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://graph.instagram.com/".$GsInstagram_user_id."?fields=id,username,media_count&access_token=".$GsInstagram_access_token,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
      ),
    ));

    $response2 = curl_exec($curl);
    curl_close($curl);
    $response2 = json_decode($response2);
    update_option('GsInstagram_profile_save', $response2);
    //Get user account info

    $myArr = array(
        'response' => 'save data',
        'response1' => $response1,
        'response2' => $response2
    );
    $myJSON = json_encode($myArr); 
    echo $myJSON;
    die();
}


add_action( 'wp_ajax_get_long_live_access_token_my_action', 'get_long_live_access_token_my_action_ajax_function');
add_action( 'wp_ajax_nopriv_get_long_live_access_token_my_action', 'get_long_live_access_token_my_action_ajax_function');
function get_long_live_access_token_my_action_ajax_function(){

    $short_live_access_token = $_POST['short_live_access_token'];

    $client_secret =  $_POST['client_secret']; 

    //Get long live accress token 
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=".$client_secret."&access_token=".$short_live_access_token,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
      ),
    ));

    $response1 = curl_exec($curl);

    curl_close($curl);

    $response1 = json_decode($response1);

    $get_long_live_access_token = $response1->access_token;


    //Refresh Long live access token
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=".$get_long_live_access_token,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
      ),
    ));

    $response2 = curl_exec($curl);

    curl_close($curl);
    
    $response2 = json_decode($response2);

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





function GsInstagram_init_fun() {
    global $GsInstagram_instagram_response, $GsInstagram_user_profile;
    $GsInstagram_instagram_response = get_option('GsInstagram_feed_save');
    $GsInstagram_user_profile = get_option('GsInstagram_profile_save');
}
add_action( 'init', 'GsInstagram_init_fun' );



function GsInstagram_feed_shortcode_function(){

ob_start();

require_once 'template/feed-list.php';

//echo "<pre>"; print_r($GsInstagram_instagram_response); echo "</pre>";

return ob_get_clean();
}
add_shortcode('GsInstagram_feed', 'GsInstagram_feed_shortcode_function');






add_action('wp_footer', 'GsInstagram_footer_catch_code_fun');
function GsInstagram_footer_catch_code_fun(){

    //echo "<p>Catch code</p>";

    $code = $_GET['code'];

    if (isset($code)) {

        $client_id = get_option('GsInstagram_clientid');
        $client_secret = get_option('GsInstagram_client_secret');
        $redirect_url = get_option('GsInstagram_redirect_url');

        //$code2 = substr($code,0,-2);
        //echo "code1: ".$code; echo "<br>";
        //echo "code2: ".$code2; echo "<br>";

        //Get accress token
        $curl = curl_init();

        $post_fields = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_url,
            'code' => $code
        );

        //echo "<pre>post_fields:"; print_r($post_fields); echo "</pre>";

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.instagram.com/oauth/access_token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $post_fields,
          CURLOPT_HTTPHEADER => array(
            "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

        $response = json_decode($response);

        //echo "<pre>"; print_r($response); echo "</pre>";
      
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
                background-image: url('<?php echo GsInstagram_URL?>/spinner-2x.gif');
                background-repeat: no-repeat;
                background-position: center;
            }
        </style>
        <?php
    }


}