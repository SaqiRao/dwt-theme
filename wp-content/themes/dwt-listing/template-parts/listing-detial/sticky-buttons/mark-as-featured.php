<?php
global $dwt_listing_options;
$listing_id = get_the_ID();
$user_id = get_current_user_id();
if($user_id != 0 && $user_id!= ''){
if (get_current_user_id() != "" && get_post_meta($listing_id, 'dwt_listing_is_feature', true) == '0' && get_post_meta($listing_id, 'dwt_listing_listing_status', true) == '1') {
    if (get_post_field('post_author', $listing_id) == $user_id) {
        if (get_user_meta($user_id, 'dwt_listing_featured_listing', true) != 0) {
            if (get_user_meta($user_id, 'dwt_listing_package_expiry', true) != '-1') {
                if (get_user_meta($user_id, 'dwt_listing_package_expiry', true) < date('Y-m-d')) {
                    echo "<div class='sticky-button-feature'>
        				<a href='" . dwt_listing_pagelink('dwt_listing_packages') . "'>" . esc_html__('Package Expire', 'dwt-listing') . "</a>
    				</div>";
                } else {
                    echo dwt_listing_mark_listing_featured($listing_id);
                }
            } else {
                echo dwt_listing_mark_listing_featured($listing_id);
            }
        } else {
            echo "<div class='sticky-button-feature'>
        		<a href='" . dwt_listing_pagelink('dwt_listing_packages') . "'>" . esc_html__('Buy Package', 'dwt-listing') . "</a>
    		</div>";
        }
    }
}
}