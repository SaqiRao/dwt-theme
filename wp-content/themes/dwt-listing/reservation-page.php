<?php
/* Template Name: Reservation Page */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */
?>
<?php
get_header();
global $dwt_listing_options;
   $user_info = get_userdata(get_current_user_id());

?>



<?php get_footer(); ?>