<?php global $dwt_listing_options;?>
<div class="col-md-4 col-xs-12 col-sm-12">
    <div class="blog-sidebar">
    <?php if ( is_active_sidebar( 'dwt_listing_blog-sidebar' ) ) { ?>
    	<?php dynamic_sidebar( 'dwt_listing_blog-sidebar' ); ?>
    <?php } ?>    
    </div>
</div>