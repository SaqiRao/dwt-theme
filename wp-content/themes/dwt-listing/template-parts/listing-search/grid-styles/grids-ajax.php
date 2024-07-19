<?php
global $dwt_listing_options;
$style_typez = 'grid1';
$fetch_output = '';
$style_typez = dwt_listing_text('dwt_listing_search_layout_style');
//starting div
if ($style_typez == 'grid1') {
    $fetch_output .= '<div class="papular-listing-2">';
}

//Masonry layout
$map_listings = '<script> listing_markersz = [';
while ($results->have_posts()) {
    $results->the_post();
    $listing_id = get_the_ID();
    $listingz = new dwt_listing_listings();
    $function = "dwt_listing_listing_styles_$style_typez";
    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
        $fetch_output .= $listingz->$function($listing_id, '6', true, 'no');
    } else {
        $fetch_output .= $listingz->$function($listing_id, '3', true, 'yes');
    }
    //for map
    if (get_post_meta($listing_id, 'dwt_listing_listing_lat', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true) != "") {
        $posted_date = esc_html__('Posted on ', 'dwt-listing') . ' ' . get_the_date(get_option('date_format'), $listing_id);
        $is_featured = dwt_listing_is_listing_featured($listing_id, true);
        $lat = get_post_meta($listing_id, 'dwt_listing_listing_lat', true);
        $long = get_post_meta($listing_id, 'dwt_listing_listing_long', true);
        //get media
        $media = dwt_listing_fetch_listing_gallery($listing_id);
        //Ratings
        $ratings = '';
        if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
            $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
            if (isset($get_percentage) && count((array) $get_percentage['ratings']) > 0 && count((array) $get_percentage['rated_no_of_times']) > 0) {
                $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . $get_percentage['average'] . '</i></div>';
            }
        }
        $icon = '';
        $icon = dwt_listing_iconfor_map($listing_id);

        $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($listing_id))));
        $map_listings .= '{
						"icon":\'' . $icon . '\',
						"title":"' . $replace_title . '",
						"img":"' . dwt_listing_return_listing_idz($media, 'dwt_listing_blogpost-thumb') . '",
						"listing_link":"' . get_the_permalink($listing_id) . '",
						"posted_on":"' . $posted_date . '",
						"is_featured":\'' . $is_featured . '\',
						"ratings":\'' . $ratings . '\',
						"lat":' . $lat . ',
						"lng":' . $long . '
		  },';
    }
}
$map_listings .= ']; </script>';

//closing div
if ($style_typez == 'grid1') {
    $fetch_output .= '</div>';
}
echo '' . $map_listings;