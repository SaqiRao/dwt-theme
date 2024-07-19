<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<section class="single-post dwt_listing_listing-detialz type-minimal ">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="short-detail">
                    <?php get_template_part('template-parts/admin', 'approval'); ?>
                    <div class="list-detail">
                        <article>
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
                                <div class="panel" role="tab" id="ed-slot-1">
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
                            $layout = $dwt_listing_options['dwt_listing_view-layout-manager-minimal']['enabled'];
                            if ($layout): foreach ($layout as $key => $value) {
                                switch ($key) {

                                    case 'ad_slot_1':
                                        get_template_part('template-parts/listing-detial/ad_slots/slot', '1');
                                        break;

                                    case 'desc':
                                        get_template_part('template-parts/listing-detial/description/desc');
                                        break;

                                    case 'menu':
                                        get_template_part('template-parts/listing-detial/menu/menu');
                                        break;

                                    case 'listing_features':
                                        get_template_part('template-parts/listing-detial/features/features');
                                        break;

                                    case 'location':
                                        get_template_part('template-parts/listing-detial/location/location');
                                        break;

                                    case 'form_fields':
                                        get_template_part('template-parts/listing-detial/custom-fields/custom', 'fields');
                                        break;

                                    case 'video':
                                        get_template_part('template-parts/listing-detial/video/video');
                                        break;

                                    case 'ad_slot_2':
                                        get_template_part('template-parts/listing-detial/ad_slots/slot', '2');
                                        break;

                                    case 'reviews':
                                        get_template_part('template-parts/listing-detial/reviews/reviews');
                                        break;
                                }
                            }
                            endif;
                            ?>
                        </article>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?php get_template_part('template-parts/listing-detial/sidebar/sidebar'); ?>
            </div>
        </div>
    </div>
</section>