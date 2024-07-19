<?php global $dwt_listing_options;
	$profile	= new dwt_listing_profile();
	$user_id	=	$profile->user_info->ID;
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo esc_html__('Listing Overview','dwt-listing'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-purple">
                    <span class="icon text-purple"><i class="lnr lnr-layers"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_listing_status_count($user_id,'1'); ?></span>
                        <span class="title"><?php echo esc_html__('Published','dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-primary">
                    <span class="icon text-primary"><i class="lnr lnr-hourglass"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_pending_listing_count_update($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Pending','dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-danger text-danger">
                    <span class="icon "><i class="lnr lnr-rocket"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_featured_count($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Featured','dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-success text-success">
                    <span class="icon"><i class="lnr lnr-cog"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_listing_status_count($user_id,'0'); ?></span>
                        <span class="title"><?php echo esc_html__('Expired','dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>