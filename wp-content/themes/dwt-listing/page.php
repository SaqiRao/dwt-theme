<?php get_header(); ?>
<?php
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
                                    <?php
                                    $args = array(
                                        'before' => '<div class="col-md-12 add-pages">',
                                        'after' => '</div>',
                                        'link_before' => '<span class="btn btn-default">',
                                        'link_after' => '</span>',
                                        'next_or_number' => 'number',
                                        'separator' => ' ',
                                        'nextpagelink' => esc_html__('Next >>', 'dwt-listing'),
                                        'previouspagelink' => esc_html__('<< Prev', 'dwt-listing'),
                                        'highlight' => esc_html__('Active', 'dwt-listing'),
                                    );
                                    wp_link_pages($args);
                                    ?>
                                    <div class="clearfix"></div>
                                    <?php comments_template('', true); ?>
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
get_footer();
?>