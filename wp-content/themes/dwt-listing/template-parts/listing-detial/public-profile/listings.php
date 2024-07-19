<?php global $dwt_listing_options; ?>
<div role="tabpanel" class="tab-pane fade in active" id="my-listingz">
    <?php
    //pagination
    $paged = 1;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    //fetch listings
    $listing_status = 'publish';
    $get_args = dwt_listing_public_profile_listings($listing_status, $paged, $user_id);
    $my_listings = new WP_Query($get_args);
    if ($my_listings->have_posts()) {
        $listingz = new dwt_listing_listings();
        while ($my_listings->have_posts()) {
            $my_listings->the_post();
            $listing_id = get_the_ID();
            echo($listingz->dwt_listing_listing_styles_list1($listing_id));
        }
        echo dwt_listing_listing_pagination($my_listings);
        wp_reset_postdata();
    } else {
        $notify = esc_html__("don't have any listing yet!", 'dwt-listing');
        ?>
        <div class="alert custom-alert custom-alert--warning" role="alert">
            <div class="custom-alert__top-side">
                <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                <div class="custom-alert__body">
                    <h6 class="custom-alert__heading"><?php echo esc_html__('No Listing Yet!', 'dwt-listing'); ?></h6>
                    <div class="custom-alert__content"><?php echo '' . $user_name . ' ' . $notify; ?></div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>