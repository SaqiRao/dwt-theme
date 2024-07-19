<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
if (!empty($_GET['order_id']) && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
    $order_items = '';
    $order_id = $_GET['order_id'];
    
    if (!$order = wc_get_order($order_id)) {
        get_template_part('template-parts/profile/invoices/invoices');
    }
    $order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
    
    $logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo.png';
    if (isset($dwt_listing_options["dwt_listing_logo"])) {
        $logo = $dwt_listing_options["dwt_listing_logo"]["url"];
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="panel invoice-full-detail">
                    <div id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo esc_html__('Invoice Detail', 'dwt-listing'); ?></h3>
                            <p>
                                <?php
                                printf(
                                        __('Order #%1$s was placed on %2$s and is currently %3$s.', 'dwt-listing'), '<mark class="order-number">' . $order->get_order_number() . '</mark>', '<mark class="order-date">' . wc_format_datetime($order->get_date_created()) . '</mark>', '<mark class="order-status">' . wc_get_order_status_name($order->get_status()) . '</mark>'
                                );
                                ?>
                            </p>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr__('Logo', 'dwt-listing'); ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>      
                            <hr>
                            <div class="row"> 
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <p>
                                        <b><?php echo esc_html__('Invoice Info', 'dwt-listing'); ?></b>
                                    </p>
                                    <p><span class="lnr lnr-calendar-full"></span> <?php echo esc_html__('Date', 'dwt-listing'); ?> : <?php echo wc_format_datetime($order->get_date_created()); ?></p>
                                    <?php if ($order->get_billing_phone()) : ?>
                                        <p><span class="lnr lnr-phone"></span> <?php echo esc_html__('Phone', 'dwt-listing'); ?> : <?php echo esc_html($order->get_billing_phone()); ?></p>
                                    <?php endif; ?>
                                    <?php if ($order->get_billing_first_name()) : ?>
                                        <p><span class="lnr lnr-envelope"></span> <?php echo esc_html__('Name', 'dwt-listing'); ?> : <?php echo esc_html($order->get_billing_first_name() ." " . $order->get_billing_last_name()); ?></p>
                                    <?php endif; ?>
                                    <?php if ($order->get_billing_email()) : ?>
                                        <p><span class="lnr lnr-envelope"></span> <?php echo esc_html__('Email', 'dwt-listing'); ?> : <?php echo esc_html($order->get_billing_email()); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo esc_html__('Description', 'dwt-listing'); ?></th>
                                            <th class="text-right"><?php echo esc_html__('Quantity', 'dwt-listing'); ?></th>
                                            <th class="text-right"><?php echo esc_html__('Price', 'dwt-listing'); ?></th>
                                            <th class="text-right"><?php echo esc_html__('Total', 'dwt-listing'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php
    $count = 1;
    foreach ($order_items as $item_id => $item) {
        $product = $item->get_product();
        if ($product->get_type() == 'dwt_listing_pkgs' || $product->get_type() == 'subscription') {
            $link = dwt_listing_pagelink('dwt_listing_packages');
        } else {
            $link = $product->get_permalink($item);
        }
        ?>	  
                                            <tr class="text-right">
                                                <td class="text-left"><?php echo esc_html($count); ?></td>
                                                <th class="text-left"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($item->get_name()); ?></a></th>
                                                <td><?php echo esc_html($item->get_quantity()); ?></td>
                                                <td>
                                                    <?php
                                                        // echo get_woocommerce_currency_symbol() . ' ' . esc_attr($product->get_price());

                                                        // code added by me for getting total price from formated html tag then divid it on quantity 
                                                        $price = $order->get_formatted_line_subtotal($item); 
                                                        $cleaned_price = html_entity_decode($price);
                                                        
                                                        // $xml = simplexml_load_string($cleaned_price);
                                                        
                                                        // $final_price = (float) $xml->bdi;
                                                        $final_price = preg_replace('/[^0-9]/', '', $cleaned_price);

                                                        echo get_woocommerce_currency_symbol() . ' ' . esc_attr($final_price/$item->get_quantity()); 
                                                        // <========================== --------- ==========================>

                                                ?></td>
                                                <td><?php echo $order->get_formatted_line_subtotal($item); ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>  
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <div class="invoice-calc">
                                <p class="text-right"><strong><?php echo esc_html__('Subtotal', 'dwt-listing'); ?></strong> : <?php echo $order->get_formatted_order_total(); ?></p>
                                    <?php if ($order->get_shipping_to_display() != "Free!") { ?>
                                        <p class="text-right"><strong><?php echo esc_html__('Shipping', 'dwt-listing'); ?></strong> : <?php echo $order->get_shipping_to_display(); ?></p>
                                    <?php } ?>
                                <p class="text-right"><strong><?php echo esc_html__('Payment Method', 'dwt-listing'); ?></strong> : <?php echo $order->get_payment_method_title(); ?></p>
                                <h4 class="text-right"><?php echo esc_html__('Total', 'dwt-listing'); ?> : <?php echo $order->get_formatted_order_total(); ?></h4>
                            </div>          
                            <hr>
                            <a href="javascript:void(0)" onclick="printDiv('printableArea')" class="btn-invoice btn btn-primary"><span class="lnr lnr-printer"></span> <?php echo esc_html__('Print Invoice', 'dwt-listing'); ?></a>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <script>
        function printDiv(printableArea) {
            var printContents = document.getElementById(printableArea).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <?php
}