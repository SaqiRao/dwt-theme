<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit;
}
if (dwt_listing_text('related_products') == 1) { ?>
    <?php
    $cats = wp_get_post_terms(get_the_ID(), 'product_cat');
    if (!empty($cats)) {
        $categories = array();
        foreach ($cats as $cat) {
            $categories[] = $cat->term_id;
        }
        $loop_args = array(
            'post_type' => 'product',
            'posts_per_page' => dwt_listing_text('max_related_products'),
            'order' => 'DESC',
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $categories
                )));
        $related_products = new WP_Query($loop_args);
        if ($related_products->have_posts()) {
            ?>
            <section id="dwt_listing_products-related">
                <div class="container">
                    <div class="row">
                        <?php if (dwt_listing_text('related_products_title') != '') { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="heading-2 left">
                                    <h2><?php echo dwt_listing_text('related_products_title'); ?></h2>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 products ">
                            <div class="related-produt-slider owl-carousel owl-theme">
                                <?php
                                $productz = new dwt_listing_products_shop();
                                $layout_type = 'shop_slider';
                                $fetch_products = '';
                                while ($related_products->have_posts()) {
                                    $related_products->the_post();
                                    $product_id = get_the_ID();
                                    $function = "dwt_listing_shop_listings_$layout_type";
                                    echo '' . $fetch_products = $productz->$function($product_id);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php }
        wp_reset_postdata(); ?>
    <?php } ?>
<?php } ?>