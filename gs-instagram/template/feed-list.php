<?php
    
    defined( 'ABSPATH' ) || exit;

    global $GsInstagram_instagram_response;
    
    /*$GsInstagram_access_token = get_option('GsInstagram_access_token');
    $GsInstagram_instagram_response = $this->Instagram_obj->get_user_media($GsInstagram_access_token);
    echo "<pre>"; print_r($GsInstagram_instagram_response); echo "</pre>";*/

?>


<?php if (empty($GsInstagram_instagram_response->error)) {  ?>

<div class="grid"> 

  <div class="grid-sizer"></div>

    <?php foreach ($GsInstagram_instagram_response->data as $data) { ?>

      <div class="grid-item">

        <a href="<?php echo $data->permalink;?>" target="_blank">

          <?php if ($data->media_type == 'VIDEO') { ?>    

              <img src="<?php echo $data->thumbnail_url;?>" alt="Video">
             
          <?php }else if($data->media_type == 'IMAGE'){?>

              <img src="<?php echo $data->media_url;?>" alt="IMAGE">

          <?php }else if($data->media_type == 'CAROUSEL_ALBUM'){?>

              <img src="<?php echo $data->media_url;?>" alt="CAROUSEL_ALBUM">
              
          <?php } ?>

          <p><?php echo $data->caption;?></p>
        </a>

      </div>

    <?php } ?>

</div>



<?php
  $paging = $GsInstagram_instagram_response->paging;
  $next_url = $paging->next;
?>

<input type="hidden" name="next_url" id="next_url" value="<?php echo $next_url;?>">
<a href="javascript://" id="loadMore2">Load More</a>


<?php }else{
    echo "<pre>"; print_r($GsInstagram_instagram_response); echo "</pre>";
} ?>