<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo esc_html__('Events Overview', 'dwt-listing'); ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
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
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-ame text-ame">
                    <span class="icon "><i class="lnr lnr-rocket"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_pending_events_count($user_id); ?></span>
                        <span class="title"><?php echo esc_html__('Pending Events', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12">
                <div class="dwt-admin-stats bg-blue text-blue">
                    <span class="icon"><i class="lnr lnr-cog"></i></span>
                    <p>
                        <span class="number"><?php echo dwt_listing_get_events_status_count($user_id, '0'); ?></span>
                        <span class="title"><?php echo esc_html__('Expired Events', 'dwt-listing'); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>