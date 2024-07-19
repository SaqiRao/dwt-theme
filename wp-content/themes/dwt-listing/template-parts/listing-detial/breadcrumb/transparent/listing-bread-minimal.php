<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
if (is_singular('listing')) {
    dwt_listing_feature_listign_expiry_checker($listing_id);
}
$dark_defore = '';
if (isset($dwt_listing_options['dwt_listing_header-layout']) && $dwt_listing_options['dwt_listing_header-layout'] == '1') {
    $dark_defore = 'dark-before';
}
$style = $get_cover_img = '';
$get_cover_img = dwt_listing_get_cover_img($listing_id, 'full');
$style = ( $get_cover_img != "" ) ? ' style="background-image: url(' . $get_cover_img . '); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-repeat: no-repeat; background-position: center center;"' : "";
?>
<div class="dwt-listingz-detail-minimal <?php echo esc_attr($dark_defore); ?> single-listing" <?php echo ($style); ?>>
    <div class="container">
        <div class="row page-section short-detail">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="short-detail">
                    <span class="dwt-listingz-detail-minimal-cat"><?php echo dwt_listing_listing_assigned_cats($listing_id); ?></span>
                    <div class="list-heading">
                        <h2><?php echo dwt_listing_bread_crumb_heading(); ?> <?php echo dwt_listing_is_listing_featured($listing_id); ?></h2>
                    </div>
<?php
if (get_post_meta($listing_id, 'dwt_listing_listing_lat', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true) != "") {
    ?>
                        <div class="m-listing-addr">
                            <p><i class="fa fa-map-marker"></i> <?php echo get_post_meta($listing_id, 'dwt_listing_listing_street', true); ?>  <a class="m-listing-map" href="https://www.google.com/maps?daddr=<?php echo get_post_meta($listing_id, 'dwt_listing_listing_lat', true); ?>,<?php echo get_post_meta($listing_id, 'dwt_listing_listing_long', true); ?>" target="_blank" ><?php echo esc_html__('Get Directions', 'dwt-listing'); ?></a></p>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="list-meta">
                    <?php get_template_part('template-parts/listing-detial/listing-meta/listing-meta', 'minimal'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 minimal-btnz-dwt text-right">
                <div class="margin-from-top-minimal">
                    <button class="btn btn-gallery" id="fancyLaunch"><i class="fa fa-picture-o" aria-hidden="true"></i>
<?php echo esc_html__('View Gallery', 'dwt-listing'); ?></button>
                    <a class="btn-default-wishlist sonu-button-<?php echo esc_attr($listing_id); ?> bookmark-listing" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>" href="javascript:void(0)" data-listing-id="<?php echo esc_attr($listing_id); ?>"><i class="fa fa-heart"></i><?php echo esc_html__('Add to favorites', 'dwt-listing'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$media = dwt_listing_fetch_listing_gallery($listing_id);
$title = get_the_title();
if (count((array) $media) > 0) {
    foreach ($media as $m) {
        $mid = '';
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $img = wp_get_attachment_image_src($mid, 'dwt_listing_slider-img');
        $full_img = wp_get_attachment_image_src($mid, 'full');
        $thumb_imgs = wp_get_attachment_image_src($mid, 'dwt_listing_slider-thumb');
        ?>    
        <a class="minimal fancybox" data-fancybox="images" href="<?php echo esc_url($full_img[0]); ?>"><img class="hide-minimal" src="<?php echo esc_url($thumb_imgs[0]); ?>" alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>" /></a>
        <?php
    }
}
?>