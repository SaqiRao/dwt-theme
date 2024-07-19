<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $product;
?>

<div class="usefull-info">
    <ul class="list-unstyled">
        <?php if (wc_get_product_category_list($product->get_id()) != '') { ?>
            <li><?php echo esc_html__('Category : ', 'dwt-listing'); ?> <span><?php echo wc_get_product_category_list($product->get_id()); ?></span></li>
        <?php } ?>
        <?php if (wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') )) { ?>
            <li><?php echo esc_html__('SKU', 'dwt-listing'); ?> : <span><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__('N/A', 'dwt-listing'); ?></span></li>
        <?php } ?>
        <?php
        $stock = esc_html__('Out of stock', 'dwt-listing');
        if ($product->is_in_stock()) {
            $stock = esc_html__('In stock', 'dwt-listing');
        }
        ?>
        <li><?php echo esc_html__('Availability', 'dwt-listing'); ?> : <span><?php echo esc_attr($stock); ?></span></li>
        <?php if (wc_get_product_tag_list($product->get_id()) != '') { ?>
            <li><?php echo esc_html__('Tags : ', 'dwt-listing'); ?><span><?php echo wc_get_product_tag_list($product->get_id()); ?></span></li>
        <?php } ?>
    </ul>
</div>
<div class="clearfix"></div>