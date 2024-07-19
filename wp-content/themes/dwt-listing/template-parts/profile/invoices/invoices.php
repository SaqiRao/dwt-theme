<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;

// print_r($user_id);
// die;
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
    $customer_orders = '';
    // $customer_orders = get_posts(apply_filters('woocommerce_my_account_my_orders_query', array(
    //     'numberposts' => -1,
    //     'meta_key' => '_customer_user',
    //     'meta_value' => $user_id,
    //     'post_type' => wc_get_order_types('view-orders'),
    //     'post_status' => array_keys(wc_get_order_statuses()),
    // )));


    $customer_orders = wc_get_orders(array(
        'customer' => $user_id,
        'status'   => array_keys(wc_get_order_statuses()),
    ));

    // print_r($customer_orders);
    // die;
    ?>
    <div class="container-fluid">
        <?php get_template_part('template-parts/profile/author-stats/stats'); ?>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="panel admin-panel-scroll">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo esc_html__('List Of All Orders', 'dwt-listing'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (!empty($customer_orders) && count($customer_orders) > 0) {
                            ?>
                            <div class="table-responsive dwt-admin-tabelz">
                                <table class="dwt-admin-tabelz-panel table-hover my-order-history">
                                    <thead>
                                        <tr>
                                            <th><?php echo esc_html__('Order', 'dwt-listing'); ?></th>
                                            <th><?php echo esc_html__('Date', 'dwt-listing'); ?></th>
                                            <th><?php echo esc_html__('Status', 'dwt-listing'); ?></th>
                                            <th><?php echo esc_html__('Total', 'dwt-listing'); ?></th>
                                            <th><?php echo esc_html__('Action', 'dwt-listing'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($customer_orders as $customer_order) {
                                            
                                            // print_r($customer_order->ID);
                                            // die;
                                            // $order = wc_get_order($customer_order->ID);
                                            $order = wc_get_order($customer_order);
                                            if($order)
                                            {
                                                $item_count = $order->get_item_count();
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo '#' . $order->get_order_number(); ?>
                                                    </td>
                                                    <td>
                                                        <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($order->get_status() == 'completed') {
                                                            echo '<label class="label label-completed">' . esc_html__('Completed', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'pending') {
                                                            echo '<label class="label label-pending">' . esc_html__('Pending', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'processing') {
                                                            echo '<label class="label label-processing">' . esc_html__('Processing', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'on-hold') {
                                                            echo '<label class="label label-hold">' . esc_html__('On hold', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'cancelled') {
                                                            echo '<label class="label label-cancled">' . esc_html__('Cancelled', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'refunded') {
                                                            echo '<label class="label label-refunded">' . esc_html__('Refunded', 'dwt-listing') . '</label>';
                                                        }
                                                        if ($order->get_status() == 'failed') {
                                                            echo '<label class="label label-failed">' . esc_html__('Failed', 'dwt-listing') . '</label>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php printf(esc_html__('%1$s for %2$s item', $item_count, 'dwt-listing'), $order->get_formatted_order_total(), $item_count); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $obj_id = get_queried_object_id();
                                                        $current_url = get_permalink($obj_id);
                                                        $invoice_update_url = dwt_listing_set_url_params_multi($current_url, array('listing-type' => 'invoices', 'order_id' => esc_attr($order->get_order_number())));
                                                        ?>
                                                        <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($invoice_update_url)); ?>" class="label label-info tool-tip" title="<?php echo esc_html__('View Invoice', 'dwt-listing'); ?>"> <i class="lnr lnr-menu"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            get_template_part('template-parts/profile/invoices/none');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="container-fluid">
        <?php get_template_part('template-parts/profile/author-stats/stats'); ?>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo esc_html__('List Of All Orders', 'dwt-listing'); ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php get_template_part('template-parts/profile/invoices/none'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>