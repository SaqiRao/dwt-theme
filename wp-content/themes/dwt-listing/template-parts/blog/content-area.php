<?php global $dwt_listing_options; ?>
<div class="col-md-8 col-sm-8 col-xs-12  nopadding">
    <div class="downotwn-blog ">
        <div class=" masonry_container">
            <div class="masonery_wrap">
                <?php get_template_part('template-parts/blog/get-blog', 'posts'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 ">
        <div class="extra-sec">
            <?php dwt_listing_pagination(); ?>
        </div>
    </div>
</div>