<?php
/* Template Name: Home Template */

/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */
get_header(); ?>
<?php global $dwt_listing_options;
if (have_posts()) {
    the_post();
    $post = get_post();

    if (dwt_check_is_elementor($post->ID)) {
        the_content();
    } else if ($post && (preg_match('/vc_row/', $post->post_content) || preg_match('/post_job/', $post->post_content))) {
        the_content();
    } else {
        ?>
        <section class="static-page blog-post-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="single-blog blog-detial">
                            <div class="blog-post">
                                <div class="post-excerpt post-desc">
                                    <?php the_content(); ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
?>
<?php get_footer(); ?>