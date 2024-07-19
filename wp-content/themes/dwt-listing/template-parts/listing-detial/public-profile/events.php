<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
?>
<div role="tabpanel" class="tab-pane fade in active" id="my-eventz">
    <?php
    //pagination
    $page_no = 1;
    $page_no = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    //fetch listings
    $event_status = 'publish';
    $get_args = $profile->dwt_listing_users_public_eventz($event_status, $page_no, $user_id);
    $my_events = new WP_Query($get_args);
    if ($my_events->have_posts()) {
        $listingz = new dwt_listing_listings();
        while ($my_events->have_posts()) {
            $my_events->the_post();
            $event_id = get_the_ID();
            echo($listingz->dwt_listing_public_events($event_id));
        }
        echo dwt_listing_listing_pagination($my_events);
        wp_reset_postdata();
    } else {
        $notify_event = esc_html__("don't have any event yet!", 'dwt-listing');
        ?>
        <div class="alert custom-alert custom-alert--warning" role="alert">
            <div class="custom-alert__top-side">
                <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                <div class="custom-alert__body">
                    <h6 class="custom-alert__heading"><?php echo esc_html__('No Event Yet!', 'dwt-listing'); ?></h6>
                    <div class="custom-alert__content"><?php echo '' . $user_name . ' ' . $notify_event; ?></div>
                </div>
            </div>
        </div>
    <?php
}
?>
</div>