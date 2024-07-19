<?php global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo esc_html__('Stats Overview', 'dwt-listing'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-purple">
                    <span class="icon text-purple"><i class="lnr lnr-layers"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_listing_status_count($user_id, '1'); ?></span>
                        <span class="title"><?php echo esc_html__('Published', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-primary">
                    <span class="icon text-primary"><i class="lnr lnr-hourglass"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_pending_listing_count($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Pending', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-danger text-danger">
                    <span class="icon "><i class="lnr lnr-rocket"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_featured_count($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Featured', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-success text-success">
                    <span class="icon"><i class="lnr lnr-cog"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_listing_status_count($user_id, '0'); ?></span>
                        <span class="title"><?php echo esc_html__('Expired', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-rise">
                    <span class="icon text-rise"><i class="lnr lnr-bubble"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_received_reviews($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Received Reviews', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-amber">
                    <span class="icon text-amber"><i class="lnr lnr-sort-amount-asc"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_submitted_reviews($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Submitted Reviews', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-pink text-pink">
                    <span class="icon "><i class="lnr lnr-calendar-full"></i></span>
                    <p>
                        <?php
                        $publish_events = $pending_events = $expired_events = $total_events = 0;
                        $publish_events = dwt_listing_get_events_status_count($user_id, '1');
                        $pending_events = dwt_listing_get_pending_events_count($user_id);
                        $expired_events = dwt_listing_get_events_status_count($user_id, '0');
                        $total_events = $publish_events + $pending_events + $expired_events;
                        ?>
                        <span class="number"><?php echo $total_events; ?></span>
                        <span class="title"><?php echo esc_html__('Total Events', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-purples text-purples">
                    <span class="icon"><i class="lnr lnr-clock"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_events_status_count($user_id, '1'); ?></span>
                        <span class="title"><?php echo esc_html__('Published Events', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>