<?php

defined( 'ABSPATH' ) || exit;

$client_id = get_option('GsInstagram_clientid');
$client_secret = get_option('GsInstagram_client_secret');
$redirect_url = get_option('GsInstagram_redirect_url');
$access_token = get_option('GsInstagram_access_token');
$GsInstagram_user_id = get_option('GsInstagram_user_id');

$GsInstagram_access_token_status = get_option('GsInstagram_access_token_status');

$get_code_url = 'https://api.instagram.com/oauth/authorize?client_id='.$client_id.'&redirect_uri='.$redirect_url.'&scope=user_profile,user_media&response_type=code';

global $GsInstagram_instagram_response, $GsInstagram_user_profile;


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

        <?php if (empty($GsInstagram_user_profile->error)) {  ?>

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
             echo "<pre>"; print_r($GsInstagram_user_profile); echo "</pre>";
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
</div>