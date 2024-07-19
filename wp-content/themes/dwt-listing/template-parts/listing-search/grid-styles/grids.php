<?php
global $dwt_listing_options;
$style_typez = 'grid1';
$fetch_output = '';
$style_typez = dwt_listing_text('dwt_listing_search_layout_style');
//starting div
if ($style_typez == 'grid1') {
    $fetch_output .= '<div class="papular-listing-2">';
}
$additinal_col = '';
if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
    $additinal_col = '3';
}
//Masonry layout
$fetch_output .= '<div class="row"><div class="masonry_container"><div class="masonery_wrap">';
while ($results->have_posts()) {
    $results->the_post();
    $listing_id = get_the_ID();
    $listingz = new dwt_listing_listings();
    $function = "dwt_listing_listing_styles_$style_typez";
    $fetch_output .= $listingz->$function($listing_id, $additinal_col);
}
$fetch_output .= '</div></div></div>';

//closing div
if ($style_typez == 'grid1') {
    $fetch_output .= '</div>';
}