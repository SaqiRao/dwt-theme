<?php global $dwt_listing_options; 
//Ad slots
if( isset( $dwt_listing_options['dwt_listing_slot_1'] ) && $dwt_listing_options['dwt_listing_slot_1'] != "")
{
?>
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="ed-slot-1">
      <h4 class="panel-title"> <a  href="javascript:void(0)"><i class="ti-blackboard"></i> <?php echo dwt_listing_text('dl_advert'); ?> </a> </h4>
    </div>
    <div class="panel-collapse" role="tabpanel">
      <div class="eds-list">
		<?php echo ''.$dwt_listing_options['dwt_listing_slot_1']; ?>
	</div>
		<div class="clearfix"></div>
    </div>
</div>
<?php
}
?>