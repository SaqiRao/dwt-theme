<?php get_header(); ?>
<?php global $dwt_listing_options; ?>
<?php
if (have_posts()): while (have_posts()) {
        the_post();
        ?>
        <section class="blog-post-container">
            <div class="container">
                <div class="row">
                    <?php
                    $layout = isset($dwt_listing_options['dwt_listing_blog-singlelayout']['enabled']) ? $dwt_listing_options['dwt_listing_blog-singlelayout']['enabled'] : '';
                    if ($layout): foreach ($layout as $key => $value) {
                            switch ($key) {
                                case 'singlepost': get_template_part('template-parts/blog/blog-detial/content', 'area');
                                    break;

                                case 'singlesidebar': get_template_part('template-parts/blog/blog-detial/sidebar', 'blog');
                                    break;
                            }
                        }
                    else:
                        get_template_part('template-parts/blog/blog-detial/content', 'area');
                        get_template_part('template-parts/blog/blog-detial/sidebar', 'blog');
                    endif;
                    ?>
                </div>
            </div>
        </section>
        <?php
    }
else:
    get_template_part('template-parts/content', 'none');
endif;
?>
<?php get_footer(); ?>