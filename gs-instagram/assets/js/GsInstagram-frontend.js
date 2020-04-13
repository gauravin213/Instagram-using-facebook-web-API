/*
* GsInstagram frontend script
*/

jQuery(window).load(function () {

    jQuery.fn.mymasonry = function(){
      // init Masonry
      var $grid = jQuery('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: 20
      });
      // layout Masonry after each image loads
      $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
      });
    }

    jQuery(this).mymasonry();


    jQuery(document).on('click', '#loadMore2', function(e){  

        e.preventDefault();

        var next_url = jQuery('#next_url').val(); 

        //Ajax
        jQuery.ajax({
            url: datab.ajaxurl,
            type: "POST",
            data: {'action': 'next_url_instagram_data_my_action', 'next_url': next_url},
            cache: false,
            dataType: 'json',
            beforeSend: function(){
              jQuery('#loadMore2').prop('disabled', true);
              jQuery('#loadMore2').attr('disabled', true);
              jQuery('#loadMore2').text('Loading...');
            },
            complete: function(){
              jQuery('#loadMore2').text('Load More');
              jQuery('#loadMore2').prop('disabled', false);
              jQuery('#loadMore2').attr('disabled', false);
            },
            success: function (response) { console.log(response); 
            	
              jQuery('#next_url').val(response['next_url']);

              jQuery(".grid").append(response['htm']).each(function(){
                  jQuery('.grid').masonry('reloadItems');
              });

              jQuery('.grid').masonry();

              jQuery(this).mymasonry();

            }
            //Ajax

        });
        //Ajax

    });

});