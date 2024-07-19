<?php
// After Successfull payment
add_action('woocommerce_order_status_completed', 'dwt_listing_after_buy_package');
if (!function_exists('dwt_listing_after_buy_package')) {

    function dwt_listing_after_buy_package($order_id) {
        global $dwt_listing_options;
        $order = new WC_Order($order_id);
        $user = $order->get_user();
        $uid = $order->get_user_id();
        $items = $order->get_items();
		$now = date('Y-m-d');
        if (count($items) > 0) {
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $product_type = wc_get_product($product_id);
                if ($product_type->get_type() == 'dwt_listing_pkgs' || $product_type->get_type() == 'subscription') {
                    //store package id
                    update_user_meta($uid, 'd_user_package_id', $product_id);
					if(get_user_meta($uid, 'package_expiry_logic_date', true) !="")
					{
					}
					else
					{
						update_user_meta($uid, 'package_expiry_logic_date', $now);
					}
					
					/*if(get_user_meta($uid, 'd_user_package_id', true) !="")
					{
						if (get_post_meta($product_id, 'listing_expiry', true) != '' && get_post_meta($packg_id, 'listing_expiry', true) != '-1')
						{
							 update_user_meta($uid, 'is_active_expiry', 'yes');
						}
					}*/
                    dwt_listing_store_user_package($uid, $product_id);
                }
            }
        }
    }

}

//For Auto Approval order
add_filter('woocommerce_thankyou', 'dwt_listing_approve_order_auto', 10, 4);
if (!function_exists('dwt_listing_approve_order_auto')) {

    function dwt_listing_approve_order_auto($order_id) {
        global $dwt_listing_options;
        $order = new WC_Order($order_id);
        if ($order->has_status('processing') || $order->has_status('on-hold')) {
            if (isset($dwt_listing_options['wo_pack_approve']) && $dwt_listing_options['wo_pack_approve'] == 1) {
                $order->update_status('completed');
            }
        }
    }

}