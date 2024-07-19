<?php global $dwt_listing_options; ?>
<?php
if (have_posts()): while (have_posts()) {
        the_post();
        ?>
        <div class="col-md-6 col-sm-6 col-xs-12 masonery_item">
            <div <?php post_class(); ?> >
                <div class="blog-inner-box">
                    <?php
                    if (has_post_thumbnail()):
                        $get_img_src = '';
                        $get_img_src = dwt_listing_get_feature_image(get_the_ID(), 'dwt_listing_blogpost-thumb');
                        ?>
                        <div class="image">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url($get_img_src[0]); ?>" alt="<?php the_title(); ?>" class="img-responsive">
                            </a>
                        </div>
                    <?php endif; ?>	
                    <div class="blog-lower-box">
                        <p class="blog-date"><?php echo dwt_listing_get_date(get_the_ID()); ?></p>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if (get_the_excerpt() != ""): ?>
                            <div class="text"><?php echo dwt_listing_words_count(get_the_excerpt(), 95); ?></div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-theme"><?php echo esc_html__('Read more', 'dwt-listing'); ?></a> 
                        <?php endif; ?>	
                    </div>
                </div>
            </div> 
        </div>          
        <?php
    }
else:
    get_template_part('template-parts/content', 'none');
endif;