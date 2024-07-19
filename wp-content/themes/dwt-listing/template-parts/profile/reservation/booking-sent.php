<?php
global $dwt_listing_options;
global $woocommerce;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID();
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/stats'); ?>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('My Appointments', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['reservation_id'])) {
                        $reservation_id = intval($_GET['reservation_id']);
                        // print_r($reservation_id);
                        // Retrieve booking details
                        $reservation_name = get_post_meta($reservation_id, 'dwt_listing_reserver_name', true);
                        $reservation_number = get_post_meta($reservation_id, 'dwt_listing_reserver_number', true);
                        $reservation_email = get_post_meta($reservation_id, 'dwt_listing_reserver_email', true);
                        $reservation_day = get_post_meta($reservation_id, 'dwt_listing_reservation_day', true);
                        $reservation_time = get_post_meta($reservation_id, 'dwt_listing_reservation_time', true);
                        $reservation_listing_id = get_post_meta($reservation_id, 'dwt_listing_reservation_id', true);
                        $reservation_listing_title = get_post_meta($reservation_id, 'dwt_listing_reservation_title', true);
                        $reservation_status = get_post_meta($reservation_id, 'booked_listings_reservations', true);
                        $meeting_type = get_post_meta($reservation_listing_id, 'meeting_listing_type', true);
                        $message_text = get_post_meta($reservation_id, 'message_text', true);
                        $link_text = get_post_meta($reservation_id, 'link_text', true);
                        //print_r($message_text);
                        //print_r($link_text);
                        //var_dump($link_text);
                        // $meeting_type = get_post_meta($meeting_type, 'meeting_reservations', true);
                        // $table_price = get_post_meta($reservation_id, 'price_of_table', true);
                        // print_r($reservation_listing_id);
                        $order_id = get_post_meta($reservation_id, 'order_id', true);
                        $order = wc_get_order($order_id);
                        $order_status = '';
                        if ($order) {
                            $order_status = $order->get_status();
                            // echo "Order Status: $order_status";
                        }
                        if (empty($reservation_status)) {
                            $reservation_status = 'pending';
                        }
                        $current_status = get_post_meta($reservation_id, 'booked_listings_reservations', true);
                        $current_status = $current_status == "" ? esc_html__('Pending', 'dwt-listing') : $current_status;
                        ?>
                        <style>
                            .booking-payment-container {
                                display: flex;
                            }

                            .booking-details,
                            .payment-details {
                                flex: 1;
                                margin-right: 20px;
                            }
                        </style>
                        <div class="booking-payment-container">
                            <div class="booking-details">
                                <h2>Booking Details</h2>
                                <p><strong>Client Name:</strong> <?php echo $reservation_name; ?></p>
                                <p><strong>Number:</strong> <?php echo $reservation_number; ?></p>
                                <p><strong>Email:</strong> <?php echo $reservation_email; ?></p>
                                <p><strong>Date:</strong> <?php echo $reservation_day; ?></p>
                                <p><strong>Time:</strong> <?php echo $reservation_time; ?></p>
                                <p><strong>Listing ID:</strong> <?php echo $reservation_listing_id; ?></p>
                                <p><strong>Listing Name:</strong> <?php echo $reservation_listing_title; ?></p>
                                <p><strong>Status:</strong> <?php echo $reservation_status; ?></p>
                                <p><strong>Meeting Type:</strong> <?php if ($meeting_type === 'physical_meeting') {
                                    echo 'Physical Meeting';
                                } elseif ($meeting_type === 'virtual_meeting') {
                                    echo 'Virtual Meeting';
                                } ?></p>

                                <?php
                                if ($meeting_type === 'virtual_meeting') {
                                    echo '<p><strong>Meeting Link:</strong> <a href="' . esc_url($link_text) . '" target="_blank">' . $link_text . '</a></p>';
                                    // echo '<p><strong>Meeting Link:</strong> ' . $link_text . '</p>';
                                }
                                ?>
                            </div>
                            <div class="payment-details">
                                <h2>Payment Details</h2>
                                <?php
                                if (isset($dwt_listing_options['Appointment_paid_booking']) && $dwt_listing_options['Appointment_paid_booking'] == 1) { ?>
                                    <?php
                                    global $woocommerce;
                                    $booking_type = get_post_meta($reservation_id, 'booking_type', true);
                                    $booking_price = get_post_meta($reservation_id, 'booking_price', true);
                                    $booking_order_id = get_post_meta($reservation_id, 'order_id', true);
                                    $current_user = get_current_user_id();
                                    //echo "Amount: $" . $booking_price;
                                    ?>
                                    <br>
                                    <?php
                                    if ($booking_type === 'paid') {
                                        ?>
                                        <p><strong>Order Number: </strong> <?php echo $order_id; ?></p>
                                        <p><strong>Order Status: </strong> <?php echo ucfirst($order_status); ?></p>
                                        <?php
                                        // echo "Amount: $" . $booking_price;
                                        echo "<strong>Amount: </strong> " . get_woocommerce_currency_symbol() . " " . $booking_price;
                                        ?>
                                        <br>
                                        <?php
                                        if (empty($booking_order_id)) {
                                            ?>
                                            <input type="hidden" id="price_of_table" value="<?php echo $booking_price; ?>">
                                            <input type="hidden" id="Appointment_id" value="<?php echo $reservation_id; ?>">
                                            <?php
                                            // echo '<button id="make_payment_button">Make Payment</button>';
                                            ?>
                                            <button class="btn btn-primary pay_buttomn" id="make_payment_button"
                                                data-listing-id="<?php echo $reservation_listing_id; ?>"
                                                type="submit"><?php echo esc_html('Payment', 'dwt-listing'); ?></button>
                                            <?php
                                            ?>
                                            <?php
                                        } else {
                                            echo '<strong id="paid_button" disabled>Already Paid!</strong>';
                                        }
                                    } else {
                                        echo '<p>Free Booking</p>';
                                    }
                                    ?>
                                <?php } ?>
                            <?php } else {
                        $paged = 1;
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        //fetch listings
                        $listing_status = '';
                        $query_args = $profile->dwt_listing_fetch_owner_listings($listing_status, $paged);

                        //fetch listings
                        $query_args = array(
                            'post_type' => 'reservation',
                            'author' => get_current_user_id(),
                            'posts_per_page' => 10,
                            'paged' => $paged,

                        );

                        $the_query = new WP_Query($query_args);
                        if ($the_query->have_posts()) {
                            ?>
                                    <div class="table-responsive dwt-admin-tabelz">
                                        <table class="dwt-admin-tabelz-panel table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?php echo esc_html__('Client Name', 'dwt-listing'); ?></th>
                                                    <th><?php echo esc_html__('Date/Time', 'dwt-listing'); ?>

                                                    </th>

                                                    <th><?php echo esc_html__('Lisitng Name', 'dwt-listing'); ?></th>
                                                    <th><?php echo esc_html__('Payment Status', 'dwt-listing'); ?></th>
                                                    <th><?php echo esc_html__('Status', 'dwt-listing'); ?></th>

                                                    <th><?php echo esc_html__('Details', 'dwt-listing'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                while ($the_query->have_posts()):
                                                    $the_query->the_post();
                                                    $theid = get_the_ID();

                                                    //  print_r(get_post_meta($theid));
                                                    $listing_title = get_the_title();

                                                    $reservation_name = get_post_meta($theid, 'dwt_listing_reserver_name', true);
                                                    $reservation_time = get_post_meta($theid, 'dwt_listing_reservation_time', true);
                                                    $reservation_day = get_post_meta($theid, 'dwt_listing_reservation_day', true);
                                                    $reservation_id = get_post_meta($theid, 'dwt_listing_reservation_id', true);
                                                    $reservation_listing_title = get_post_meta($theid, 'dwt_listing_reservation_title', true);
                                                    $reservation_payment_status = get_post_meta($theid, 'dwt_listing_reservation_payment_status', true);
                                                    $current_status = get_post_meta($theid, 'booked_listings_reservations', true);
                                                    $reservation_details = get_post_meta($theid, 'dwt_listing_reservation_details', true);

                                                    $current_status = $current_status == "" ? esc_html__('Pending', 'dwt-listing') : $current_status;
                                                    /*---------addding table for Sent Appointments--------------*/

                                                    $order_id = get_post_meta($theid, 'order_id', true);
                                                    $order = wc_get_order($order_id);
                                                    $order_status = '';
                                                    if ($order) {
                                                        $order_status = $order->get_status();
                                                    }
                                                    // $order_status = get_post_meta($theid, 'woo_order_complete', true);
                                        
                                                    $booking_price = get_post_meta($theid, 'booking_price', true);
                                                    $booking_type = get_post_meta($theid, 'booking_type', true);
                                                    $booking_order_id = get_post_meta($theid, 'order_id', true);

                                                    ?>
                                                    <tr class="unique-key->">
                                                        <td><?php echo $reservation_name; ?></td>
                                                        <td>
                                                            <?php echo $reservation_day . ' / ' . $reservation_time; ?>
                                                        </td>


                                                        <td><a
                                                                href="<?php echo get_permalink($reservation_id); ?>"><?php echo $reservation_listing_title; ?></a>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $booking_type = get_post_meta($theid, 'booking_type', true);
                                                            if ($booking_type === 'paid') {
                                                                // If booking type is 'paid', show the order status
                                                                if (!empty($order_status)) {
                                                                    echo $order_status;
                                                                } else {
                                                                    echo "No payment yet";
                                                                }
                                                            } else {
                                                                // If booking type is not 'paid', indicate it's a free booking
                                                                echo "Free Booking";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $current_status; ?>
                                                        </td>
                                                        <?php if (isset($dwt_listing_options['Appointment_paid_booking']) && $dwt_listing_options['Appointment_paid_booking'] == 1) { ?>
                                                            <td>
                                                                <?php

                                                        // print_r($woocommerce);
                                                    }
                                                    ?>

                                                        <td>
                                                            <?php
                                                            $page_permalink = get_bloginfo('url') . "/profile?listing-type=booking-sent&reservation_id=" . $theid;
                                                            //  $page_permalink = get_bloginfo('url') . "/booking-details?reservation_id=" . $theid;
                                                            ?>
                                                            <a href="<?php echo esc_url($page_permalink); ?>">View Details</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endwhile;
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                    <?php
                        } else {
                            get_template_part('template-parts/profile/my-listings/content', 'none');
                        }
                        ?>
                                <div class="admin-pagination">
                                    <?php echo dwt_listing_listing_pagination($the_query); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>