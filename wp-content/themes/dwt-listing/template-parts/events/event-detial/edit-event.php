<?php
global $dwt_listing_options;
$event_id = get_the_ID();
$user_id = get_current_user_id();
// Edit Listing
if (get_post_field('post_author', $event_id) == get_current_user_id() || is_super_admin(get_current_user_id())) {

    $listing_update_url = '';
    $listing_update_url = dwt_listing_set_url_params_multi(dwt_listing_pagelink('dwt_listing_profile-page'), array('listing-type'=> 'create-events', 'edit_event'=> $event_id  ));
    ?>
    <div class="sticky-button-edit">
        <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>" class="tool-tip" title="<?php echo esc_html__('Edit Event', 'dwt-listing'); ?>">
            <i class="ti-pencil-alt"></i>
        </a>
    </div>
    <?php
}