<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
$additional_class = $no_padding = '';
if (dwt_listing_text('dwt_listing_header-layout') == 4 && dwt_listing_text('dwt_listing_lp_style') == 'classic') {
    $additional_class = 'no-slider-margin';
    $no_padding = 'nopadding';
}
?>
<?php if (dwt_listing_text('dwt_listing_header-layout') == 5) { ?>
    <div><?php  get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing', 'bread'); ?></div>
<?php } ?>
<section class="single-post <?php echo esc_attr($additional_class); ?> dwt_listing_listing-detialz">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 <?php echo esc_attr($no_padding); ?>">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="short-detail">
                        <?php get_template_part('template-parts/admin', 'approval'); ?>
                        <div class="list-detail">
                            <article>
                                <?php
                                $layout = $dwt_listing_options['dwt_listing_view-layout-manager']['enabled'];
                                if ($layout): foreach ($layout as $key => $value) {
                                        switch ($key) {
                                            case 'slider': get_template_part('template-parts/listing-detial/slider/slider', '1');
                                                break;

                                            case 'ad_slot_1': get_template_part('template-parts/listing-detial/ad_slots/slot', '1');
                                                break;

                                            case 'desc': get_template_part('template-parts/listing-detial/description/desc');
                                                break;

                                            case 'menu': get_template_part('template-parts/listing-detial/menu/menu');
                                                break;

                                            case 'listing_features': get_template_part('template-parts/listing-detial/features/features');
                                                break;

                                            case 'location': get_template_part('template-parts/listing-detial/location/location');
                                                break;

                                            case 'form_fields': get_template_part('template-parts/listing-detial/custom-fields/custom', 'fields');
                                                break;

                                            case 'video': get_template_part('template-parts/listing-detial/video/video');
                                                break;

                                            case 'ad_slot_2': get_template_part('template-parts/listing-detial/ad_slots/slot', '2');
                                                break;

                                            case 'reviews': get_template_part('template-parts/listing-detial/reviews/reviews');
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
    </div>
</section>