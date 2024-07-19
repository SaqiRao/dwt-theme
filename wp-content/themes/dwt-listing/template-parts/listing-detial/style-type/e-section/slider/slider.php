<?php global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
$media = dwt_listing_fetch_listing_gallery($listing_id);

$title = get_the_title();
if (count((array)$media) > 0) {
    ?>
    <div class="dwt-carousal-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="listing-page-slider owl-carousel owl-theme">
                            <?php
                            foreach ($media as $m) {
                                $mid = '';
                                if (isset($m->ID)) {
                                    $mid = $m->ID;
                                } else {
                                    $mid = $m;
                                }
                                if (wp_attachment_is_image($mid)) {
                                    $img = wp_get_attachment_image_src($mid, 'dwt_listing_elegent');
                                    $full_img = wp_get_attachment_image_src($mid, 'full');
                                    ?>
                                    <div class="item">
                                        <div class="carosual-content"><a href="<?php echo esc_url($full_img[0]); ?>"
                                                                         data-fancybox="group"> <img
                                                        src="<?php echo esc_url($img[0]); ?>" class="img-responsive"
                                                        alt="<?php echo esc_attr($title); ?> "/> </a>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="item">
                                        <div class="carosual-content"><a
                                                    href="<?php echo esc_url(dwt_listing_defualt_img_url()); ?>"
                                                    data-fancybox="group"> <img
                                                        src="<?php echo esc_url(dwt_listing_defualt_img_url()); ?>"
                                                        class="img-responsive" alt="<?php echo esc_attr($title); ?> "/>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>