<?php

/* Template Name: Events Search Page */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */

get_header();
//enquie google
dwt_listing_google_locations();
wp_enqueue_script("google-map-callback");
//pagination	
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
//Listing Title
$event_title = '';
if (isset($_GET['by_title']) && $_GET['by_title'] != "") {
    $event_title = $_GET['by_title'];
}
//Categories
$category = '';
if (isset($_GET['event_cat']) && $_GET['event_cat'] != "") {
    $category = array(
        array(
            'taxonomy' => 'l_event_cat',
            'field' => 'slug',
            'terms' => $_GET['event_cat'],
        ),
    );
}
//Listing Street Address
$venue = '';
if (isset($_GET['by_location']) && $_GET['by_location'] != "") {
    $venue = array(
        'key' => 'dwt_listing_event_venue',
        'value' => trim($_GET['by_location']),
        'compare' => 'LIKE',
    );
}
//only active events
$active_events = array(
    'key' => 'dwt_listing_event_status',
    'value' => '1',
    'compare' => '='
);


$order = 'desc';
$orderBy = 'date';
if (isset($_GET['sort_by']) && $_GET['sort_by'] != "") {
    $orde_arr = explode('-', $_GET['sort_by']);
    $order = isset($orde_arr[1]) ? $orde_arr[1] : 'desc'; {
        $orderBy = isset($orde_arr[0]) ? $orde_arr[0] : 'ID';
    }
}

//query 
$args = array
    (
    's' => $event_title,
    'post_type' => 'events',
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'meta_query' => array(
        $active_events,
        $venue,

    ),
    'tax_query' => array(
        $category,
    ),
    'order' => $order,
    'orderby' => $orderBy,
    'paged' => $paged,
);
$args = dwt_listing_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);
//search layout type
$layout_type = 'topbar';
$layout_type = dwt_listing_text('dwt_listing_event_layout');
require trailingslashit(get_template_directory()) . 'template-parts/events/events-with-' . $layout_type . '.php';
?>
<?php get_footer(); ?>