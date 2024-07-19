<?php global $dwt_listing_options;
//listing id
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	$listing_id = $_GET['review_id'];	
}
else
{
	$listing_id	=	get_the_ID();
}
?>
<div class="alert custom-alert custom-alert--danger" role="alert">
          <div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon ti-server "></span>
            <div class="custom-alert__body">
              <h6 class="custom-alert__heading"> <?php echo esc_html__('Listing Expired','dwt-listing'); ?></h6>
              <div class="custom-alert__content">
                <?php echo esc_html__('Listing has been expired by author or admin','dwt-listing'); ?>  
              </div>
            </div>
          </div>
        </div>