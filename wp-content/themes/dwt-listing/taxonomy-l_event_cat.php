<?php
/**
 * The template for displaying Listing category.
 */
global $dwt_listing_options;
get_header();
if ( get_query_var( 'paged' ) ){$paged = get_query_var( 'paged' );}else if ( get_query_var( 'page' ) ) {$paged = get_query_var( 'page' );}
else 
{
	$paged = 1;
}
$args = dwt_listing_events_query($paged);
$args = dwt_listing_wpml_show_all_posts_callback($args);
$results = new WP_Query( $args );
$listing_page_style = 'map';
$listing_page_style = $dwt_listing_options['dwt_listing_event_layout'];
switch($listing_page_style)
{
	case 'map': require trailingslashit( get_template_directory () ) . 'template-parts/events/events-with-'. $listing_page_style.'.php';
	break;
	
	case 'topbar': require trailingslashit( get_template_directory () ) . 'template-parts/events/events-with-'. $listing_page_style.'.php';
	break;
}
get_footer();