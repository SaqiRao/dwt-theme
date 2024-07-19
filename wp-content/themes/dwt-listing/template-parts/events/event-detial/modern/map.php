<?php global $dwt_listing_options;
	 $event_id	=	get_the_ID();
?>
<?php
if(dwt_listing_text('dwt_listing_enable_map') == "1")
{
	//check map type
	if(dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "")
	{
		if( get_post_meta($event_id, 'dwt_listing_event_lat', true ) != "" && get_post_meta($event_id, 'dwt_listing_event_long', true ) != "" )
		{
		?>
                 
					<input type="hidden" id="listing_latt" value="<?php echo get_post_meta($event_id, 'dwt_listing_event_lat', true ); ?>" />
					<input type="hidden" id="listing_long" value="<?php echo get_post_meta($event_id, 'dwt_listing_event_long', true ); ?>" />
					<div id="map"></div>
				<div class="clearfix"></div>
                <?php if(get_post_meta($event_id, 'dwt_listing_event_venue', true) !=""){?>	  
              <p class="street-adr"><i class="ti-location-pin"></i> <?php echo get_post_meta($event_id, 'dwt_listing_event_venue', true); ?></p>
             <?php } ?>
		<?php
		}
	}
	else
	{
		if( get_post_meta($event_id, 'dwt_listing_event_lat', true ) != "" && get_post_meta($event_id, 'dwt_listing_event_long', true ) != "" )
		{
		?>
             
				<input type="hidden" id="listing_latt" value="<?php echo get_post_meta($event_id, 'dwt_listing_event_lat', true ); ?>" />
				<input type="hidden" id="listing_long" value="<?php echo get_post_meta($event_id, 'dwt_listing_event_long', true ); ?>" />
				<div class="map" id="static_map"></div>
			<div class="clearfix"></div>
            <?php if(get_post_meta($event_id, 'dwt_listing_event_venue', true) !=""){?>	  
              <p class="street-adr"><i class="ti-location-pin"></i> <?php echo get_post_meta($event_id, 'dwt_listing_event_venue', true); ?></p>
             <?php } ?>
		<?php
		}
	}
}