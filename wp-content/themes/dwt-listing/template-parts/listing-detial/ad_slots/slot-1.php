<?php global $dwt_listing_options; 
//Ad slots
if( isset( $dwt_listing_options['dwt_listing_slot_1'] ) && $dwt_listing_options['dwt_listing_slot_1'] != "")
{
?>
	<div class="eds-list">
		<?php echo ''.$dwt_listing_options['dwt_listing_slot_1']; ?>
	</div>
	<div class="clearfix"></div>
<?php
}