<?php
global $dwt_listing_options;
$event_id = get_the_ID();
$media = dwt_listing_fetch_event_gallery($event_id);
?>
<?php if (count((array) $media) > 0) { ?>
    <div class="owl-wrapper">
        <div class="event_type2 owl-carousel owl-theme">
            <?php
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $thumb_imgs = wp_get_attachment_image_src($mid, 'dwt_listing_blogsingle-post');
                if ($thumb_imgs != '') {
                    ?>
                    <div class="item">
                        <img class="img-responsive" src="<?php echo esc_url($thumb_imgs[0]); ?>" alt="<?php echo get_the_title($event_id); ?>">
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
<?php } ?>