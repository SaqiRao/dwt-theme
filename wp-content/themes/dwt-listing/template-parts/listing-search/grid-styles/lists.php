<?php
global $dwt_listing_options;
$fetch_output = '';
$style_typez = 'list1';
$style_typez = dwt_listing_text('dwt_listing_search_layout_style');
//Masonry layout
$fetch_output .= '<div class="masonery_wrap">';
while ($results->have_posts()) {
    $results->the_post();
    $listing_id = get_the_ID();
    $listingz = new dwt_listing_listings();
    $function = "dwt_listing_listing_styles_$style_typez";
    $fetch_output .= $listingz->$function($listing_id);
}
$fetch_output .= '</div>';