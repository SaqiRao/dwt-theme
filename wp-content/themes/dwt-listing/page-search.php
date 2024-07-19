<?php
/* Template Name: Listing Search */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */

get_header();
/* enquie google */
dwt_listing_google_locations();
wp_enqueue_script("google-map-callback");


/* Listing Title */
$listing_title = '';
if (isset($_GET['by_title']) && $_GET['by_title'] != "") {
    $listing_title = $_GET['by_title'];
}
/* Categories */
$category = '';
if (isset($_GET['l_category']) && $_GET['l_category'] != "") {
    $category = array(
        array(
            'taxonomy' => 'l_category',
            'field' => 'term_id',
            'terms' => $_GET['l_category'],
        ),
    );
}
/* Tags */
$tags = '';
if (isset($_GET['l_tag']) && $_GET['l_tag'] != "") {
    $tags = array(
        array(
            'taxonomy' => 'l_tags',
            'field' => 'term_id',
            'terms' => $_GET['l_tag'],
        ),
    );
}
/* Amenties */
$amenties = '';
if (isset($_GET['amenties']) && is_array($_GET['amenties']) && $_GET['amenties'] != "") {
    $amenties = array(
        'taxonomy' => 'l_category',
        'field' => 'term_id',
        'terms' => $_GET['amenties'],
    );
}
/* Price Type */
$price_type = '';
if (isset($_GET['l_price_type']) && $_GET['l_price_type'] != "") {
    $price_type = array(
        array(
            'taxonomy' => 'l_price_type',
            'field' => 'term_id',
            'terms' => $_GET['l_price_type'],
        ),
    );
}
/* Listing Status */
$listing_id = array();
if (isset($_GET['l_listing_status']) && $_GET['l_listing_status'] != "") {
    if ($_GET['l_listing_status'] == 'all') {
        $listing_id = array();
    } else {
        $listing_id = dwt_listing_search_listing_status();
        if (count((array)$listing_id) == 0) {
            $listing_id = array(0);
        }
    }
}

/* Listing Street Address */

$user_city_location = isset($_COOKIE['user_city_location_custom']) ? $_COOKIE['user_city_location_custom'] : '';
$street_address_ = '';
if (isset($_GET['street_address']) &&  $_GET['street_address'] != '') {
    $street_address_ = $_GET['street_address'];
} else {
    $street_address_ = $user_city_location;
}


$street_address = '';
if (isset($street_address_) && $street_address_ != "") {
    $street_address = array(
        'key' => 'dwt_listing_listing_street',
        'value' => trim($street_address_),
        'compare' => 'LIKE',
    );
}

/* Custom Location */
$custom_location = '';
if (dwt_listing_countires_cookies() != "") {
    $custom_location = array(
        array(
            'taxonomy' => 'l_location',
            'field' => 'term_id',
            'terms' => dwt_listing_countires_cookies(),
        ),
    );
} else {
    if (isset($_GET['l_location']) && $_GET['l_location'] != "") {
        $location_array = array();
        if (isset($_GET['l_location']) && $_GET['l_location'] != "")
            $location_array[] = $_GET['l_location'];
        if (isset($_GET['l_state']) && $_GET['l_state'] != "")
            $location_array[] = $_GET['l_state'];
        if (isset($_GET['l_city']) && $_GET['l_city'] != "")
            $location_array[] = $_GET['l_city'];
        if (isset($_GET['l_town']) && $_GET['l_town'] != "")
            $location_array[] = $_GET['l_town'];
        $custom_location = array(
            array(
                'taxonomy' => 'l_location',
                'field' => 'term_id',
                'terms' => $location_array,
            ),
        );
    }
}

/* Listing By Rated */
$order = 'DESC';
$order_by = 'date';
$key = '';
if (isset($_GET['l_rating']) && $_GET['l_rating'] != "") {
    $order = 'DESC';
    if ($_GET['l_rating'] == 'low_rated') {
        $order = 'ASC';
    }
    $key = 'listing_total_average';
    $order_by = 'meta_value_num';
}

if (isset($_GET['sort_by']) && $_GET['sort_by'] != "") {
    $orde_arr = explode('-', $_GET['sort_by']);
    $order = isset($orde_arr[1]) ? $orde_arr[1] : 'DESC';
    $order_by = isset($orde_arr[0]) ? $orde_arr[0] : 'ID';
}

/* post status active only */
$active_listings = array(
    'key' => 'dwt_listing_listing_status',
    'value' => '1',
    'compare' => '='
);
$featured_or_simple = '';
/* condition based featured ads */
if (dwt_listing_text('feature_or_simple') == 0) {
    $featured_or_simple = array(
        'key' => 'dwt_listing_is_feature',
        'value' => '0',
        'compare' => '='
    );
}


/* pagination	 */
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

/* query  */
$args = array
(
    's' => $listing_title,
    'post_type' => 'listing',
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'post__in' => $listing_id,
    'tax_query' => array(
        $category,
        $amenties,
        $price_type,
        $custom_location,
        $tags,
    ),
    'meta_query' => array(
        $active_listings,
        $street_address,
        $featured_or_simple
    ),
    'meta_key' => $key,
    'order' => $order,
    'orderby' => $order_by,
    'paged' => $paged,
);
$args = dwt_listing_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);

/* search layout type */
$layout_type = 'sidebar';
$layout_type = dwt_listing_text('dwt_listing_seacrh_layout');
require trailingslashit(get_template_directory()) . 'template-parts/listing-search/search-with-' . $layout_type . '.php';
get_footer();