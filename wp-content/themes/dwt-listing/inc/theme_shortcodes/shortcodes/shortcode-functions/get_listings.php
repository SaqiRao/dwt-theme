<?php
global $dwt_listing_options;
extract(shortcode_atts(array(
    'ad_type' => '',
    'layout_type' => '',
    'ad_order' => '',
    'no_of_ads' => '',
), $atts));

$cats = array();
if (function_exists('vc_param_group_parse_atts')) {
$rows = vc_param_group_parse_atts($atts['cats']);
if (count($rows) > 0) {
    foreach ($rows as $row) {
        if (isset($row['cat'])) {
            if ($row['cat'] == 'all') {
                break;
            } else {
                $cats[] = $row['cat'];
            }
        }
    }
}
}


$category = '';
if (count($cats) > 0) {
    $category = array(
        array(
            'taxonomy' => 'l_category',
            'field' => 'term_id',
            'terms' => $cats,
        ),
    );
}

$custom_location = '';
if (dwt_listing_countires_cookies() != "") {
    $lang_switch_term_id = dwt_listing_translate_object_id(dwt_listing_countires_cookies(), 'l_location');
    $custom_location = array(
        array(
            'taxonomy' => 'l_location',
            'field' => 'term_id',
            'terms' => $lang_switch_term_id,
        ),
    );
}
/* post status active only */
$active_listings = array(
    'key' => 'dwt_listing_listing_status',
    'value' => '1',
    'compare' => '='
);
$is_feature = '';
if ($ad_type == 'feature') {
    $is_feature = array(
        'key' => 'dwt_listing_is_feature',
        'value' => 1,
        'compare' => '=',
    );
} else if ($ad_type == 'both') {
    $is_feature = '';
} else {
    $is_feature = array(
        'key' => 'dwt_listing_is_feature',
        'value' => 0,
        'compare' => '=',
    );
}
$order = 'DESC';
$order_by = 'date';
if ($ad_order == 'asc') {
    $order = 'ASC';
} else if ($ad_order == 'desc') {
    $order = 'DESC';
} else if ($ad_order == 'rand') {
    $order_by = 'rand';
}

/* query args */
$args = array(
    'post_type' => 'listing',
    'post_status' => 'publish',
    'posts_per_page' => $no_of_ads,
    'tax_query' => array(
        $category,
        $custom_location,
    ),
    'meta_query' => array(
        $active_listings,
        $is_feature,
    ),
    'order' => $order,
    'orderby' => $order_by,
);
$fetch_listingz = '';
$args = dwt_listing_wpml_show_all_posts_callback($args);
$listingz = new dwt_listing_listings();
$results = new WP_Query($args);
if (isset($layout_type) && $layout_type != "") {
    $layout_type = $layout_type;
} else {
    $layout_type = 'grid2';
}
if ($results->have_posts()) {
    $fetch_listingz_get = (isset($fetch_listingz_get) && $fetch_listingz_get != "") ? $fetch_listingz_get : 3;
    //Masonry layout
    $fetch_listingz .= '<div class="masonery_wrap">';
    while ($results->have_posts()) {
        $results->the_post();
        $listing_id = get_the_ID();
        $function = "dwt_listing_listing_styles_$layout_type";
        $fetch_listingz .= $listingz->$function($listing_id, $fetch_listingz_get);
    }
    $fetch_listingz .= '</div>';
}

wp_reset_postdata();