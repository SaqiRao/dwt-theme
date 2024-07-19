<?php
get_header();

global $dwt_listing_options;
if (have_posts()) {
    $my_url = '';
    $my_url = dwt_listing_get_current_url();
    while (have_posts()) {
        the_post();
        $listing_id = get_the_ID();
        if (strpos($my_url, 'listing.downtown-directory.com') !== false) {
            
        } else {
            //check the listing expiry.
            dwt_listing_listing_expiry_checker($listing_id);
        }
        //check the expiry of feature listing
        dwt_listing_feature_listign_expiry_checker($listing_id);
        if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
            get_template_part('template-parts/listing-detial/style-type/elegent');
        } else if (dwt_listing_text('dwt_listing_lp_style') == 'minimal') {
            get_template_part('template-parts/listing-detial/style-type/minimal');
        } else if (dwt_listing_text('dwt_listing_lp_style') == 'classic') {
            get_template_part('template-parts/listing-detial/style-type/classic');
        }
        //sticky action buttons
        get_template_part('template-parts/listing-detial/sticky-buttons/sticky', 'buttons');
    }
} else {
    get_template_part('template-parts/content', 'none');
}

get_footer();
