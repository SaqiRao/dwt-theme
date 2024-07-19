<?php if ( in_array( 'dwt_listing_framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	   require trailingslashit( get_template_directory () )  . 'inc/classes/registration/authentication.php';
	   require trailingslashit( get_template_directory () )  . 'inc/classes/profile/profile.php';
	   require trailingslashit( get_template_directory () )  . 'inc/classes/submit-listing/submit-listing.php';
	   require trailingslashit( get_template_directory () )  . 'inc/classes/reviews/submit-review.php';
	   require trailingslashit( get_template_directory () )  . 'inc/classes/listings/listings.php';
	   require trailingslashit( get_template_directory () )  . 'inc/classes/events/events.php';
}
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )) ) || class_exists( 'WooCommerce' ))
{
	 require trailingslashit( get_template_directory () )  . 'inc/classes/shop/products.php';
}