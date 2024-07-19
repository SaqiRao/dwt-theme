<?php global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
if (dwt_listing_text('dwt_listing_header-layout') == 2 || dwt_listing_text('dwt_listing_header-layout') == 3) {
    ?>
    <div class="list-category">
        <ul>
            <li>  <?php echo 'THIS IS THE SLIDER PAGE' . dwt_listing_listing_assigned_cats($listing_id); ?> </li>
        </ul>
    </div>
    <div class="list-heading">
        <h2><?php echo get_the_title($listing_id); ?><?php echo dwt_listing_is_listing_featured($listing_id); ?></h2>
    </div>
    <div class="list-meta">
        <?php get_template_part('template-parts/listing-detial/listing-meta/listing', 'meta'); ?>
    </div>
<?php } ?>
<div class="list-images">
    <div class="flexslider">
        <ul class="slides">
            <?php
            $listing_id = get_the_ID();
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            $title = get_the_title();
            if (count((array)$media) > 0) {
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
                    if (wp_attachment_is_image($mid)) {
                        ?>
                        <li data-thumb="<?php echo esc_url($thumb_imgs[0]); ?>"><a
                                    href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group"> <img
                                        src="<?php echo esc_url($img[0]); ?>"
                                        alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>"/> </a></li>
                        <?php
                    } else {
                        ?>
                        <li data-thumb="<?php echo esc_url(dwt_listing_defualt_img_url()); ?>"><a
                                    href="<?php echo esc_url(dwt_listing_defualt_img_url()); ?>" data-fancybox="group">
                                <img src="<?php echo esc_url(dwt_listing_defualt_img_url()); ?>"
                                     alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>"/> </a></li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>