<?php
    
    defined( 'ABSPATH' ) || exit;

    global $GsInstagram_instagram_response;
    
    /*$GsInstagram_access_token = get_option('GsInstagram_access_token');
    $GsInstagram_instagram_response = $this->Instagram_obj->get_user_media($GsInstagram_access_token);
    echo "<pre>"; print_r($GsInstagram_instagram_response); echo "</pre>";*/

?>


<?php if (empty($GsInstagram_instagram_response->error)) {  ?>


<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>

<div class="container container-new-feed">
<div class="row grid masonarys" id="myList">
    <?php foreach ($GsInstagram_instagram_response->data as $data) { ?>

      <div class="col-md-4 insta-col-4 grid-boxs li">
        <div class="thumbnail">
          <a href="<?php echo $data->permalink;?>" target="_blank">
            <div class="media-cont-new">
                <?php if ($data->media_type == 'VIDEO') { ?>    
    
                    <div class="new-media-option" style="background-image:url(<?php echo $data->thumbnail_url;?>);">
                        <!-- <img src="<?php //bloginfo('template_directory');?>/images/arrow-play.png" alt="Video"> -->
                    </div>
                   
                <?php }else if($data->media_type == 'IMAGE'){?>
    
                    <div class="new-media-option" style="background-image:url(<?php echo $data->media_url;?>);"></div>
                
                <?php }else if($data->media_type == 'CAROUSEL_ALBUM'){?>

                    <div class="new-media-option" style="background-image:url(<?php echo $data->media_url;?>);"></div>
                    
                <?php } ?>
            </div>
            <div class="caption">
              <p><?php echo $data->caption;?></p>
            </div>
          </a>
        </div>
      </div>
   

    <?php } ?>
     </div>
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