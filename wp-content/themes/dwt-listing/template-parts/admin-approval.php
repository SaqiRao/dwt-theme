<?php
$listing_id = get_the_ID();
$listing_author_id = get_post_field('post_author', $listing_id);
if (get_post_status($listing_id) != 'publish' && get_post_status($listing_id) != 'trash' ) {
    ?>
    <div class="alert custom-alert custom-alert--info" role="alert">
        <div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
            <div class="custom-alert__body">
                <h6 class="custom-alert__heading">
                    <?php echo esc_html__('Waiting For Admin Approval', 'dwt-listing'); ?>
                </h6>
                <div class="custom-alert__content">
                    <?php echo esc_html__("Approval required, waiting for admin approval.", 'dwt-listing'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}