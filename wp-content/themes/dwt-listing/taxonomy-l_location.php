<?php
/**
 * The template for displaying Listing category.
 */
global $dwt_listing_options;
	get_header();
//pagination	
if ( get_query_var( 'paged' ) ){$paged = get_query_var( 'paged' );}else if ( get_query_var( 'page' ) ) {$paged = get_query_var( 'page' );}
else 
{
	$paged = 1;
}
$args = dwt_listing_search_query($paged);
$args = dwt_listing_wpml_show_all_posts_callback($args);
$results = new WP_Query( $args );
$listing_page_style = $dwt_listing_options['dwt_listing_seacrh_layout'];
switch($listing_page_style)
{
	case 'sidebar': require trailingslashit( get_template_directory () ) . 'template-parts/listing-search/search-with-'. $listing_page_style.'.php';
	break;

	case 'map': require trailingslashit( get_template_directory () ) . 'template-parts/listing-search/search-with-'. $listing_page_style.'.php';
	break;
	
	case 'topbar': require trailingslashit( get_template_directory () ) . 'template-parts/listing-search/search-with-'. $listing_page_style.'.php';
	break;

}
get_footer();