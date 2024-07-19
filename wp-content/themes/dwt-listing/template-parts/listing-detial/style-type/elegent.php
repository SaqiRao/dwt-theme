<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
global $wpdb;
$get_custom_fields = $listing_features = $get_results = '';
$get_results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '" . $listing_id . "' AND meta_key LIKE 'dwt_listing_menutype_%' ORDER BY meta_id ASC");
$listing_features = wp_get_object_terms($listing_id, array('l_category'), array('orderby' => 'name', 'order' => 'ASC'));
$get_custom_fields = $wpdb->get_results("SELECT meta_value , meta_key FROM $wpdb->postmeta WHERE post_id = '$listing_id' AND meta_key LIKE 'field_multi_%' ORDER BY meta_id ASC");

$layout = $dwt_listing_options['dwt_listing_elegent_manager']['enabled'];
get_template_part('template-parts/listing-detial/style-type/e-section/slider/slider');
get_template_part('template-parts/listing-detial/style-type/e-section/title/title');
?>
<div class="new-title-button-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-md-12">
                <div class="single-title-buttons">
                    <ul class="list-inline new-title-page-button-section">
                        <?php
                        if ($layout): foreach ($layout as $key => $value) {
                            switch ($key) {
                                case 'desc':
                                    echo '<li> <a href="#d-desc"  class="scroller">' . dwt_listing_text('dl_desc') . '</a> </li>';
                                    break;

                                case 'menu':
                                    if (!empty($get_results) && count($get_results) > 0) {
                                        echo '<li> <a href="#dfoodz-menu"  class="scroller">' . dwt_listing_text('dl_menu') . '</a> </li>';
                                    };
                                    break;

                                case 'listing_features':
                                    if (is_array($listing_features) && count($listing_features) > 1) {
                                        echo '<li> <a href="#listing_features" class="scroller">' . dwt_listing_text('dl_amenties') . '</a> </li>';
                                    }
                                    break;

                                case 'location':
                                    if (get_post_meta($listing_id, 'dwt_listing_listing_lat', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true) != "") {
                                        echo '<li> <a href="#dstreet-loc"  class="scroller">' . dwt_listing_text('dl_location') . '</a> </li>';
                                    }
                                    break;

                                case 'form_fields':
                                    if (count($get_custom_fields) > 0) {
                                        echo ' <li> <a href="#dcustom-fields"  class="scroller">' . dwt_listing_text('dl_custom') . '</a> </li>';
                                    }
                                    break;

                                case 'video':
                                    if (get_post_meta($listing_id, 'dwt_listing_listing_video', true) != "") {
                                        echo '<li> <a href="#dlisting-video"  class="scroller">' . dwt_listing_text('dl_video') . '</a> </li>';
                                    }
                                    break;

                                case 'reviews':
                                    echo ' <li> <a href="#d-comments"  class="scroller">' . dwt_listing_text('dl_reviews') . '</a> </li>';
                                    break;
                            }
                        }
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="single-post single-detail-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xs-12 col-md-8 col-sm-12">
                <div class="list-detail">
                    <?php get_template_part('template-parts/admin', 'approval'); ?>
                    <div class="panel-group" id="accordion_listing_detial" role="tablist" aria-multiselectable="true">
                        <?php
                        $listing_custom_menu_link_title = get_post_meta(get_the_ID(), 'dwt_listing_custom_menu_link_title', true);
                        $listing_custom_menu_link_title = !empty($listing_custom_menu_link_title) ? $listing_custom_menu_link_title : '';
                        $listing_custom_menu_link_desc = get_post_meta(get_the_ID(), 'dwt_listing_custom_menu_link_desc', true);
                        $listing_custom_menu_link_desc = !empty($listing_custom_menu_link_desc) ? $listing_custom_menu_link_desc : '';

                        if ($listing_custom_menu_link_title != '' && $listing_custom_menu_link_desc != '') {
                            $listing_custom_order_btn_title = get_post_meta(get_the_ID(), 'dwt_listing_custom_order_btn_title', true);
                            $listing_custom_order_btn_title = !empty($listing_custom_order_btn_title) ? esc_html($listing_custom_order_btn_title) : '';
                            $listing_custom_order_btn_link = get_post_meta(get_the_ID(), 'dwt_listing_custom_order_btn_link', true);
                            $listing_custom_order_btn_link = !empty($listing_custom_order_btn_link) ? $listing_custom_order_btn_link : '';
                            ?>
                            <div class="panel custom-menu-link">
                                <div class="row">
                                    <div class="col-md-9 custom-title-desc-menu">
                                        <span class="shoping-icon"><i class="ti-bag"></i></span>
                                        <h4><?php echo $listing_custom_menu_link_title; ?></h4>
                                        <p><?php echo $listing_custom_menu_link_desc; ?></p>
                                    </div>
                                    <?php if ($listing_custom_order_btn_title != '') { ?>
                                        <div class="col-md-3 custom-btn-linkurl">
                                            <a href="<?php echo esc_url($listing_custom_order_btn_link); ?>"
                                               target="_blank"
                                               class="btn btn-theme"><?php echo esc_html($listing_custom_order_btn_title); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                        if ($layout): foreach ($layout as $key => $value) {
                            switch ($key) {
                                case 'ad_slot_1':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/ad_slots/slot', '1');
                                    break;

                                case 'desc':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/description/desc');
                                    break;

                                case 'menu':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/menu/menu');
                                    break;

                                case 'listing_features':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/features/features');
                                    break;

                                case 'location':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/location/location');
                                    break;

                                case 'form_fields':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/custom-fields/custom', 'fields');
                                    break;

                                case 'video':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/video/video');
                                    break;

                                case 'ad_slot_2':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/ad_slots/slot', '2');
                                    break;

                                case 'reviews':
                                    get_template_part('template-parts/listing-detial/style-type/e-section/reviews/reviews');
                                    break;
                            }
                        }
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 dwt_listing_listing-detialz">
                <?php get_template_part('template-parts/listing-detial/sidebar/sidebar'); ?>
            </div>
        </div>
    </div>
</section>