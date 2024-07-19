<?php 
function dwt_listing_register_custom_walletd_packages()
{
    if (class_exists('WooCommerce')) {

        class WC_Product_dwt_listing_custom_wallet_packages extends WC_Product
        {
            public $product_type = 'dwt_listing_wallet_pkgs';
            public function __construct($product)
            {
                parent::__construct($product);
            }
        }
    }
}

add_action('init', 'dwt_listing_register_custom_walletd_packages', 0);

function dwt_listing_add_wallets_packages_type($types)
{
    // Key should be exactly the same as in the class product_type parameter
    $types['dwt_listing_wallet_pkgs'] = __('DWT Wallet');
    return $types;
}

add_filter('product_type_selector', 'dwt_listing_add_wallets_packages_type', 0);

//class for custom product type
function dwt_listing_woocommerce_product_wallets_class($classname, $product_type)
{
    if ($product_type == 'dwt_listing_wallet_pkgs') { // notice the checking here.
        $classname = 'WC_Product_dwt_listing_custom_wallet_packages';
    }
    return $classname;
}

add_filter('woocommerce_product_class', 'dwt_listing_woocommerce_product_wallets_class', 10, 2);

/**
 * Show pricing fields for simple_rental product.
 */
function dwt_listing_render_package_custom_wallet_js()
{

    if ('product' != get_post_type()) :
        return;
    endif;
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function ($) {
            jQuery('#dwt_l_packages').hide();
            jQuery('.options_group.pricing').addClass('show_if_dwt_listing_wallet_pkgs').show();
            /*jQuery('#product-type').on('change', function () {
                if (jQuery(this).val() == 'dwt_listing_wallet_pkgs' || jQuery(this).val() == 'subscription') {
                    jQuery('#dwt_l_packages').show();
                    $("._subscription_sign_up_fee_field").hide();
                    $("._subscription_trial_length_field").hide();
                } else {
                    jQuery('#dwt_l_packages').hide();
                    $("._subscription_sign_up_fee_field").show();
                    $("._subscription_trial_length_field").show();
                }
            });*/
            jQuery('#product-type').trigger('change');
        });

    </script>
    <?php
}

add_action('admin_footer', 'dwt_listing_render_package_custom_wallet_js');

function dwt_listing_wallet_hide_attributes_data_panel($tabs)
{
    // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
    $tabs['attribute']['class'][] = 'hide_if_dwt_listing_wallet_pkgs';
    $tabs['shipping']['class'][] = 'hide_if_dwt_listing_wallet_pkgs';
    $tabs['linked_product']['class'][] = 'hide_if_dwt_listing_wallet_pkgs';
    $tabs['advanced']['class'][] = 'hide_if_dwt_listing_wallet_pkgs';
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'dwt_listing_wallet_hide_attributes_data_panel');



/*DEPOSIT CUSTOM FUNDS CALLBACK*/
add_action('wp_ajax_fl_deposit_custom_funds_callback', 'fl_deposit_custom_funds_callback');
if ( ! function_exists( 'fl_deposit_custom_funds_callback' ) )
{
    function fl_deposit_custom_funds_callback()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_deposit_funds_secure', 'security' );

        parse_str($_POST['deposit_custom_fund_data'], $params);
        $custom_amount = $params['custom_funds_amount'];


       setcookie("wallet_amount", $custom_amount, time() + (86400 * 30), "/") ?? true; // 86400 = 1 day

        $product_id = dwt_framework_get_options('wallet_custom_deposit_package');

        if ( class_exists( 'WooCommerce' ) )
        {
            global $woocommerce;
            $qty = 1;
            if( $woocommerce->cart->add_to_cart($product_id, $qty) )
            {
                $checkout_url = wc_get_checkout_url();
                $return = array('message' => esc_html__( 'Redirecting to payment page', 'dwt-listing' ),'cart_page' => $checkout_url);
                wp_send_json_success($return);

            }
        }
        else
        {
            $return = array('message' => esc_html__( 'WooCommerce plugin is not active', 'dwt-listing' ));
            wp_send_json_error($return);
            exit();
        }
    }
}

/*ONLY FOR THE CUSTOM WALLET AMOUNT*/
add_action( 'woocommerce_before_calculate_totals', 'woo_add_custom_amount_hook');
function woo_add_custom_amount_hook()
{
    global $woocommerce;
    global $dwt_listing_options;
    $deposit_type = $dwt_listing_options;('wallet_custom_deposit_package');
    if(isset($deposit_type) && $deposit_type == 1)
    {
        $saved_product_id = $dwt_listing_options('wallet_custom_deposit_package');

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
        {
            $product_detail = wc_get_product( $cart_item['product_id'] );
            $prduct_type = $product_detail->get_type();

            if(isset($prduct_type) && $prduct_type == 'wallet')
            {
                if($cart_item['product_id'] == $saved_product_id && ! empty($_COOKIE['wallet_amount']))
                {
                    $cart_item['data']->set_price($_COOKIE['wallet_amount']);
                }
            }

        }
    }
}

//adding hook for commision of admin
add_action('woocommerce_cart_calculate_fees', function() {
    
        global $wpdb;
        global $dwt_listing_options;
        // To be declared only once at the begining before the foreach loop
        foreach(WC()->cart->get_cart() as $cart_item_key ){
            $product_id = $cart_item_key['product_id'];
            $product = wc_get_product( $product_id );
            $product_type = $product->get_type();
      
            if(isset ($dwt_listing_options['dwt_listing_event_admin_disable_commission']) && $dwt_listing_options['dwt_listing_event_admin_disable_commission'] == 1){
                $product_id = $cart_item_key['product_id'];
                $product = wc_get_product( $product_id );
                $product_type = $product->get_type();

                if ( $product_type == 'simple'){

            $event_commission_from =  isset($dwt_listing_options['event_commission_from']) ?  $dwt_listing_options['event_commission_from'] : "";    
            if($event_commission_from == "2"){
            $services_charges =  $dwt_listing_options['service_charges']; 
            $percentage = $services_charges/100;

            $percentage_fee = (WC()->cart->get_cart_contents_total() + WC()->cart->get_shipping_total()) * $percentage ;
            WC()->cart->add_fee(__('Service Charges', 'dwt-listing'), $percentage_fee);
        }
    }
}
     
            }
});