<?php
global $dwt_listing_options;
$flip = '';
if (is_rtl()) {
    $flip = 'flip';
}
?>
<div class="col-md-8 col-xs-12 col-sm-12">
    <div class="single-blog blog-detial">
        <div class="blog-post">
            <?php
            if (has_post_thumbnail()):
                $get_img_src = '';
                $get_img_src = dwt_listing_get_feature_image(get_the_ID(), 'dwt_listing_blogsingle-post');
                ?>
                <div class="post-img">
                    <a href="<?php echo esc_url($get_img_src[0]); ?>" data-fancybox="group" > 
                        <img class="img-responsive" src="<?php echo esc_url($get_img_src[0]); ?>" alt="<?php the_title(); ?>">
                    </a>
                </div>
            <?php endif; ?>	  
            <div class="post-info"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"><?php the_author(); ?></a> <?php echo esc_html__('on', 'dwt-listing'); ?> <?php echo dwt_listing_get_date(get_the_ID()); ?> <a class="pull-right <?php echo esc_attr($flip); ?>" href="javascript:void(0)"><i class="ti-comments"></i><?php echo dwt_listing_get_comments(); ?></a> </div>
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
                    'highlight' => 'iAmActive'
                );
                wp_link_pages($args);
                ?>

                <?php comments_template('', true); ?>
            </div>
        </div>
    </div>
</div>