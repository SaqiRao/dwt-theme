<?php
extract(shortcode_atts(array(
    'layout_type' => '',
    'ad_order' => '',
    'no_of_ads' => '',
                ), $atts));

$cats = array();
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
$category = '';
if (count($cats) > 0) {
    $category = array(
        array(
            'taxonomy' => 'l_event_cat',
            'field' => 'term_id',
            'terms' => $cats,
        ),
    );
}
//post status active only
$active_listings = array(
    'key' => 'dwt_listing_event_status',
    'value' => '1',
    'compare' => '='
);
$order = 'DESC';
$order_by = 'date';
if ($ad_order == 'asc') {
    $order = 'ASC';
} else if ($ad_order == 'desc') {
    $order = 'DESC';
} else if ($ad_order == 'rand') {
    $order_by = 'rand';
}
//query 
$args = array
    (
    'post_type' => 'events',
    'post_status' => 'publish',
    'posts_per_page' => $no_of_ads,
    'tax_query' => array(
        $category,
    ),
    'meta_query' => array(
        $active_listings,
    ),
    'order' => $order,
    'orderby' => $order_by,
);

$masnory = $masnory_end = '';
$masnory = '<div class="masonery_wrap">';
$masnory_end = '</div>';

if ($layout_type == '') {
    $layout_type = '_grid';
}

if ($layout_type == '_slider') {
    $masnory = $masnory_end = '';
}

$args = dwt_listing_wpml_show_all_posts_callback($args);
$fetch_listingz = '';
$eventz = new dwt_listing_events();
$results = new WP_Query($args);
if ($results->have_posts()) {
    //Masonry layout
    $fetch_listingz .= $masnory;
    while ($results->have_posts()) {
        $results->the_post();
        $event_id = get_the_ID();
        $function = "dwt_listing_event_type$layout_type";
        $fetch_listingz .= $eventz->$function($event_id);
    }
    $fetch_listingz .= $masnory_end;
}
wp_reset_postdata();