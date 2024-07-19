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
<?php 
	if(dwt_listing_check_coupon_expiry($listing_id) == '1')
	{
		$coupon_end_date	= get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true);
?>
<div class="listing-coupon-block">
  <ul class="list-unstyled">
    <li> <a class="coupon-deal-button" href="javascript:void(0)" data-toggle="modal" data-target=".dwt_listing_coupon-deal"><span><?php echo esc_html__('GET COUPON DEAL','dwt-listing'); ?></span></a></li>
    <li class="dwt_listing_coupon-validity">
        <p class="dwt_listing_coupon-exp-title"><?php echo esc_html__('Expires in','dwt-listing'); ?></p>
        <div class="dwt_listing_countdown-timer">
            <div class="timer-countdown-box">
                <div class="countdown dwt_listing_custom-timer" data-countdown-time="<?php echo esc_attr($coupon_end_date); ?>"></div>
            </div>
        </div>
    </li>
  </ul>
</div>  
<?php
}