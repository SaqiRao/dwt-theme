<?php global $dwt_listing_options;
$profile	= new dwt_listing_profile();
$user_id	=	$profile->user_info->ID;
?>
<div class="profile-states">
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="state-box">
                <div class="icon">
                    <i class="ti-star"></i>
                </div>
                <div class="content">
                    <div class="numb"><?php echo dwt_listing_received_reviews($user_id); ?></div>
                    <div class="text"><?php echo esc_html__('Received Reviews','dwt-listing'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="state-box">
                <div class="icon">
                    <i class="ti-star"></i>
                </div>
                <div class="content">
                    <div class="numb"><?php echo dwt_listing_submitted_reviews($user_id); ?></div>
                    <div class="text"><?php echo esc_html__('Submited Reviews','dwt-listing'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>