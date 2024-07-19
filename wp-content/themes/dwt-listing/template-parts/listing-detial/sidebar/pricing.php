<?php
global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<?php
$pricing = '';
if (get_post_meta($listing_id, 'dwt_listing_listing_pricefrom', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_priceto', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true) != "") {
    if (get_post_meta($listing_id, 'dwt_listing_listing_priceType', true) != "") {
        $pricing = get_post_meta($listing_id, 'dwt_listing_listing_priceType', true);
    }
    $listing_currency = get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true);
    ?>
    <div class="widget">
        <div class="pricing-widget"> 
            <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/price.png'); ?>" alt="<?php echo esc_html__('Pricing', 'dwt-listing'); ?>">
            <span class="tool-tip" title="<?php echo esc_attr($pricing); ?>" ><?php echo esc_html__('Pricing', 'dwt-listing'); ?></span> 
            <span class="price-status  pull-right"> <strong><?php echo esc_attr($listing_currency) . ' ' . get_post_meta($listing_id, 'dwt_listing_listing_pricefrom', true); ?>  - <?php echo esc_attr($listing_currency) . ' ' . get_post_meta($listing_id, 'dwt_listing_listing_priceto', true); ?></strong> </span>
        </div>
    </div>
    <?php
}
?>