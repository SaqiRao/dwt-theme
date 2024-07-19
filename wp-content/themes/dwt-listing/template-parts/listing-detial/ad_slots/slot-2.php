<?php global $dwt_listing_options; 
//Ad slots
if( isset( $dwt_listing_options['dwt_listing_slot_2'] ) && $dwt_listing_options['dwt_listing_slot_2'] != "")
{
?>
	<div class="eds-list">
		<?php echo ''.$dwt_listing_options['dwt_listing_slot_2']; ?>
	</div>
	<div class="clearfix"></div>
<?php
}