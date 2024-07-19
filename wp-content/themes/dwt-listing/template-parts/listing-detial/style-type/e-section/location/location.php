<?php global $dwt_listing_options;
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
if(dwt_listing_text('dwt_listing_enable_map') == "1")
{
	//check map type
	if(dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "")
	{
	?>
		<?php   										
        if( get_post_meta($listing_id, 'dwt_listing_listing_lat', true ) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true ) != "" )
        {
        ?> 
        <div class="panel panel-default" id="dstreet-loc">
            <div class="panel-heading" role="tab" id="d_locs">
              <h4 class="panel-title"> <a href="javascript:void(0)"><i class="ti-location-pin"></i> <?php echo dwt_listing_text('dl_location'); ?> </a> </h4>
            </div>
            <div class="panel-collapse">
              <div class="panel-body">
              <?php if(get_post_meta($listing_id, 'dwt_listing_listing_street', true) !=""){?>	  
              <p class="street-adr"><i class="ti-location-pin"></i> <?php echo get_post_meta($listing_id, 'dwt_listing_listing_street', true); ?></p>
             <?php } ?>

               	 <div class="street_address">
                 <?php if(dwt_listing_text('dwt_listing_show_street_view') == 1) {?>
                <div class="is-street">
                    <a class="listing_street_address" href="javascript:void(0)"><i class="fa fa-street-view" aria-hidden="true"></i> <?php echo esc_html__('Street View','dwt-listing'); ?></a>
                </div> 
           <?php } ?> 
             		 <div class="map" id="map"></div>
                    <input type="hidden" id="listing_latt" value="<?php echo get_post_meta($listing_id, 'dwt_listing_listing_lat', true ); ?>" />
                    <input type="hidden" id="listing_long" value="<?php echo get_post_meta($listing_id, 'dwt_listing_listing_long', true ); ?>" />
                    <div class="get-directions">
                        <a href="https://www.google.com/maps?daddr=<?php echo get_post_meta($listing_id, 'dwt_listing_listing_lat', true ); ?>,<?php echo get_post_meta($listing_id, 'dwt_listing_listing_long', true ); ?>" target="_blank" >
                                <i class="ti-map-alt"></i>
                                <?php echo esc_html__('Get Directions', 'dwt-listing'); ?>
                        </a>
                    </div>
             </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
<?php
	}
	else
	{
		if( get_post_meta($listing_id, 'dwt_listing_listing_lat', true ) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true ) != "" )
        {
		?>
        <div class="panel panel-default" id="dstreet-loc">
            <div class="panel-heading" role="tab" id="d_locs">
              <h4 class="panel-title"> <a  href="javascript:void(0)"><i class="  ti-location-pin   "></i> <?php echo dwt_listing_text('dl_location'); ?> </a> </h4>
            </div>
            <div class="panel-collapse">
              <div class="panel-body">
              <?php if(get_post_meta($listing_id, 'dwt_listing_listing_street', true) !=""){?>	  
              <p class="street-adr"><i class="ti-location-pin"></i> <?php echo get_post_meta($listing_id, 'dwt_listing_listing_street', true); ?></p>
             <?php } ?>
               	 <div class="street_address">
             		<div class="map" id="static_map"></div>
                    <input type="hidden" id="listing_latt" value="<?php echo get_post_meta($listing_id, 'dwt_listing_listing_lat', true ); ?>" />
                    <input type="hidden" id="listing_long" value="<?php echo get_post_meta($listing_id, 'dwt_listing_listing_long', true ); ?>" />
                    <div class="get-directions">
                        <a href="https://www.google.com/maps?daddr=<?php echo get_post_meta($listing_id, 'dwt_listing_listing_lat', true ); ?>,<?php echo get_post_meta($listing_id, 'dwt_listing_listing_long', true ); ?>" target="_blank" >
                                <i class="ti-map-alt"></i>
                                <?php echo esc_html__('Get Directions', 'dwt-listing'); ?>
                        </a>
                    </div>
             </div>
              </div>
            </div>
          </div>
        <?php
		}
	}
}