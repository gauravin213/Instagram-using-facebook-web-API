/*
*  GsInstagram Admin Script
*/

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
            url: datab.ajaxurl,
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



    //Save data
    jQuery(document).on('click', '#GsInstagramFeedsSaveToDatabase', function(e){ 

        e.preventDefault();

        jQuery('#InnerPageBannerOverlayLoader').addClass('InnerPageBannerOverlayLoaderClass');

        var GsInstagram_access_token = jQuery('#GsInstagram_access_token').val(); 
        var GsInstagram_user_id = jQuery('#GsInstagram_user_id').val();

        //Ajax
        jQuery.ajax({
            url: datab.ajaxurl,
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