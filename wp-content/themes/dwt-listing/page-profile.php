<?php
/* Template Name: Author Dashboard */
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
check_if_not_logged();
if(is_user_logged_in()){
    ?>
    <div id="dwt-admin-wrap" class="dwt-listing-admin">
        <?php get_template_part('template-parts/profile/admin-header/navigation'); ?>
        <?php get_template_part('template-parts/profile/sidebar/sidebar'); ?>
        <div class="main">
            <div class="main-content">
                <?php get_template_part('template-parts/profile/author-dashboard/main'); ?>
            </div>
        </div>
    </div>
<?php }else{
    echo dwt_listing_redirect(home_url('/'));
} get_footer(); ?>