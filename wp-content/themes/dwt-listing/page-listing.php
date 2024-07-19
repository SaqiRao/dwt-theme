<?php
/* Template Name: Ad Listing Page */
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
if (is_user_logged_in()) {
    dwt_listing_check_pkg();
    ?>
    <section class="submit-listing">
        <div class="container">
            <div class="row">
                <?php get_template_part('template-parts/submit-listing/submit'); ?>
                <?php
                if (isset($dwt_listing_options['sell-for-me']) && $dwt_listing_options['sell-for-me'] == 1) {

                    ?>
                    <a href=" <?php echo get_the_permalink(isset($dwt_listing_options['sell-for-me']) ? $dwt_listing_options['sell-for-me'] : '#' ); ?>"
                        target="_blank" class="sell_for_me"
                        id="sell-for-me"><?php echo esc_html__("Sell For Me", 'dwt-listing'); ?> </a>

                <?php }


                ?>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="submit-listing">
        <div class="container">
            <div class="row"></div>
            <h1><?php echo esc_html('Please Login First to Submit Listing.', 'dwt-listing') ?></h1>
            <a href="javascript:void(0)" data-toggle="modal"
                data-target="#myModal"><?php echo esc_html('Login', 'dwt-listing') ?></a>
        </div>
    </section>
<?php } ?>
<?php get_footer(); ?>

<?php if (!is_user_logged_in()): ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#myModal').modal('show');
        });
    </script>
<?php endif; ?>