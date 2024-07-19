<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID();
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
$author_id = get_post_field('post_author', $my_listing_ID);
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/stats'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Received Appointments & Amount', 'dwt-listing'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="amount_in_wallet">
                        <h3><?php echo esc_html__('Total Amount in Wallet:', 'dwt-listing'); ?></h3>
                        <?php
                        $currency_symbol = get_woocommerce_currency_symbol();
                        $amount_in_wallet = get_user_meta($current_user, 'dwt_listing_user_wallet_amount', true);
                        if ($amount_in_wallet != '') { ?>
                        <?php } else {
                            $amount_in_wallet = 0;
                            ?>
    
                                <?php
                        }
                        ?>
                        <h3><?php echo esc_html($currency_symbol . (float) $amount_in_wallet); ?></h3>
    
                        <div class="create_payout_button">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create_payout"
                                data-whatever="@mdo"><?php echo esc_html__('Create Payout', 'dwt-listing'); ?></button>
                        </div>
                    </div>
                    <div class="events_payouts">
                        <div class="payout_modale">
                            <div class="modal fade" id="create_payout" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header payout_modale_header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <?php echo esc_html__('Make Payout', 'dwt-listing'); ?></h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="payout_form">
                                                <div class="form-group">
                                                    <label for="payout_amount"
                                                        class="col-form-label"><?php echo esc_html__('Payout Amount', 'dwt-listing') . '(' . get_woocommerce_currency_symbol() . ')'; ?></label>
                                                    <input type="number" class="form-control" id="payout_amount"
                                                        name="enter_payout_amount" min='1' required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text"
                                                        class="col-form-label"><?php echo esc_html__('Message:', 'dwt-listing'); ?></label>
                                                    <textarea class="form-control" id="message-text"
                                                        name="message_for_payout" required></textarea>
                                                    <input type="hidden" name="users_name" id="user_name"
                                                        value="<?php echo esc_attr__($user_name); ?> " />
                                                </div>
                                                <div class="payout_form_buttons">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><?php echo esc_html__('Close', 'dwt-listing'); ?></button>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="payout_button"><?php echo esc_html__('Send Payout', 'dwt-listing'); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $paged = 1;
        $query_args = array(
            'post_type' => 'reservation',
            'posts_per_page' => 10,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_author',
                    'compare' => '=',
                    'value' => get_current_user_id(),
                ),
            ),
        );
        $loop = new WP_Query($query_args);
        ?>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Recieved Appointments', 'dwt-listing');
                    ?></h3>
                </div>
                <div class="panel-body">
        <?php
        if (isset($_GET['reservation_id'])) {
            $reservation_id = intval($_GET['reservation_id']);
            // Retrieve booking details
            $reservation_name = get_post_meta($reservation_id, 'dwt_listing_reserver_name', true);
            $reservation_number = get_post_meta($reservation_id, 'dwt_listing_reserver_number', true);
            $reservation_email = get_post_meta($reservation_id, 'dwt_listing_reserver_email', true);
            $reservation_day = get_post_meta($reservation_id, 'dwt_listing_reservation_day', true);
            $reservation_time = get_post_meta($reservation_id, 'dwt_listing_reservation_time', true);
            $reservation_listing_id = get_post_meta($reservation_id, 'dwt_listing_reservation_id', true);
            $reservation_listing_title = get_post_meta($reservation_id, 'dwt_listing_reservation_title', true);
            $reservation_status = get_post_meta($reservation_id, 'booked_listings_reservations', true);
            $meeting_type = get_post_meta($reservation_id, 'res_app_meeting_type', true);

            // $message_text = get_post_meta($reservation_id, 'message_text', true );
            $link_text = get_post_meta($reservation_id, 'link_text', true);
            // print_r(get_post_meta($reservation_listing_id, 'meeting_listing_type', true));
        
            $order_id = get_post_meta($reservation_id, 'order_id', true);
            $order = wc_get_order($order_id);
            $order_status = '';
            if ($order) {
                $order_status = $order->get_status();
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

            .booking-details, .payment-details {
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
                } else {
                    echo 'Virtual Meeting';
                } ?></p>

            <?php
            if ($meeting_type === 'virtual_meeting') {
                echo '<p><strong>Meeting Link:</strong> <a href="' . esc_url($link_text) . '" target="_blank">' . esc_html__("Open Meeting", 'dwt-listing') . '</a></p>';
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
                            // $new11212 = get_post_meta($reservation_id);
                            // print_r($booking_order_id);

                            //echo "Amount: $" . $booking_price;
                            ?>
                            <br>
                            <?php
                            if ($booking_type === 'paid') {
                                ?>
                                        <p><strong>Order Number: </strong> <?php echo $booking_order_id; ?></p>
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
                                            echo '<button class="btn btn-primary" id="make_payment_button">Make Payment</button>';
                            
                                            ?>
                                            <!-- <button class="btn btn-primary pay_buttomn" id="make_payment_button" data-listing-id="<?php echo $reservation_listing_id; ?>" type="submit"><?php echo esc_html('Payment', 'dwt-listing'); ?></button> -->
                                            <?php
                                        } else {
                                            echo '<strong id="paid_button" disabled>Already Paid!</strong>';
                                        }
                            } else {

                                echo '<p><strong>Free Booking</strong></p>';
                            }
                            ?>
                <?php } ?>
            </div>
        </div>
    <?php
        } else { ?>
        <div class="table-responsive dwt-admin-tabelz">
            <div class="recieved-booking">
                <table class="dwt-admin-tabelz-panel table-hover">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Client Name', 'dwt-listing'); ?></th>
                            <th><?php echo esc_html__('Date/Time', 'dwt-listing'); ?></th>
                            <th><?php echo esc_html__('Lisitng Name', 'dwt-listing'); ?></th>
                            <th><?php echo esc_html__('Payment Status', 'dwt-listing'); ?></th>
                            <th><?php echo esc_html__('Status', 'dwt-listing'); ?></th>
                            <th><?php echo esc_html__('Details', 'dwt-listing'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    while ($loop->have_posts()):
                        $loop->the_post();
                        $theid = get_the_ID();
                        $listing_title = get_the_title();
                        $lsiting = get_post_meta($theid);
                        $reservation_name = get_post_meta($theid, 'dwt_listing_reserver_name', true);
                        $reservation_time = get_post_meta($theid, 'dwt_listing_reservation_time', true);
                        $reservation_day = get_post_meta($theid, 'dwt_listing_reservation_day', true);
                        $reservation_payment_status = get_post_meta($theid, 'dwt_listing_reservation_payment_status', true);

                        $reservation_listing_title = get_post_meta($theid, 'dwt_listing_reservation_title', true);
                        $reservation_details = get_post_meta($theid, 'dwt_listing_reservation_details', true);
                        $reservation_meeting_type = get_post_meta($theid, 'res_app_meeting_type', true);


                        $order_id = get_post_meta($theid, 'order_id', true);
                        $order = wc_get_order($order_id);
                        $order_status = '';
                        if ($order) {
                            $order_status = $order->get_status();
                        }

                        /*---------addding table for recieved booking--------------*/
                        ?>
                            <tbody>
                                <tr class="unique-key->">
                                    <td>
                                        <?php echo $reservation_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $reservation_day . ' / ' . $reservation_time; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo get_permalink($reservation_id); ?> ">
                                            <?php echo $reservation_listing_title; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $booking_type = get_post_meta($theid, 'booking_type', true);
                                        if ($booking_type === 'paid') {
                                            // If booking type is 'paid', show the order status
                                            if (!empty($order_status)) {
                                                echo ucfirst($order_status);
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
                                        <div class="dropdown">
                                            <!-- Modal for email -->
                                            <div class="modal fade booking_status_email" id="exampleModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                <?php echo esc_html__('New message', 'dwt-listing'); ?>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form_booking_email" id="form_booking_email">
                                                                <div class="form-group">
                                                                    <label for="message-text" class="col-form-label">
                                                                        <?php echo esc_html__('Message:', 'dwt-listing'); ?>
                                                                    </label>
                                                                    <textarea class="form-control" id="message-text" rows="10" required></textarea>
                                                                    <input type="hidden" id="current_booking_id">
                                                                    <input type="hidden" id="current_booking_status">
                                                                </div>
                                                                <div class="form-meeting">
                                                                    <label for="link-text" class="col-form-label">
                                                                        <?php echo esc_html__('Meeting Link:', 'dwt-listing'); ?>
                                                                    </label>
                                                                    <input class="form-control" id="link-text" required></input>
                                                                    <input type="hidden" id="listing_id" value="<?php echo get_the_ID(); ?>">
                                                                    <input type="hidden" id="">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" id="send_email">
                                                                    <?php echo esc_html__('Send', 'dwt-listing'); ?>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                <?php echo esc_html__('Close', 'dwt-listing'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Dropdown -->
                                            <label for="cars">
                                                <?php //echo esc_html__('Status', 'dwt-listing');    ?>
                                            </label>
                                            <?php
                                            $current_status = get_post_meta($theid, 'booked_listings_reservations', true);
                                            $current_status = $current_status == "" ? esc_html__('Pending', 'dwt-listing') : $current_status;
                                            ?>
                                            <select name="reserving_status" data-meeting="<?php print_r($reservation_meeting_type); ?>" data-type="<?php echo $booking_type ?>" data-id="<?php echo $theid; ?>"
                                                class="booking_status" id="booking_status">
                                                <option value="Pending" <?php if ($current_status == 'Pending') {
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo esc_html__('Pending', 'dwt-listing'); ?>
                                                </option>
                                                <option value="Approved" <?php if ($current_status == 'Approved') {
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo esc_html__('Approved', 'dwt-listing'); ?>
                                                </option>
                                                <option value="rejected" <?php if ($current_status == 'rejected') {
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo esc_html__('Rejected', 'dwt-listing'); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        //    require trailingslashit( get_template_directory() ) . 'profile/reservation/booking_details.php?reservation_id=' . $reservation_id;
                                        //   $reservation_permalink = get_template_directory()  . 'profile/reservation/booking-details.php?reservation_id=' . $reservation_id;
                                        $reservation_listing_title = get_post_meta($theid, 'dwt_listing_reservation_title', true);
                                        $page_permalink = get_bloginfo('url') . "/profile?listing-type=booking-recieved&reservation_id=" . $theid;
                                        ?>
                                        <a href="<?php echo esc_url($page_permalink); ?>">View Details</a>
                                    </td>
                                    <td>
                                        <?php if ($dwt_listing_options['dwt_zoom_meeting_btn'] == true) {
                                            if ($reservation_meeting_type === 'virtual_meeting') { ?>
                                                <?php 
                                                $meeting_button = 'Create Meeting';

                                                if (isset($lsiting['dwt_listing_zoom_meeting'])) {
                                                    $meeting_button = 'Update Meeting';
                                                }
                                                ?>
                                                <div class="meeting-container">
                                                    <input type="hidden" class="reservation_id_listing" value="<?php echo $theid; ?>">
                                                    <button type="button" id="<?php echo esc_attr($theid); ?>" class="btn btn-admin sonu-button meeting_authorization"
                                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__($meeting_button, 'dwt-listing'); ?>
                                                    </button>
                                                </div>
                                            <?php }
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                                wp_reset_postdata();
                                ?>
                            </tbody>
                                       <?php endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="admin-pagination">
                        <?php echo dwt_listing_listing_pagination($loop); ?>
                    </div>
            <?php } ?>
             </div>
            </div>
            <?php
            wp_reset_postdata(); ?>
            
            <?php $paged = 1;
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                the_excerpt();
                wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
<!-- <script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     var meetingLinkBox = document.querySelector('.form-meeting');
    //     var statusDropdown = document.getElementById('booking_status');   
    //     if (statusDropdown.value !== 'Approved') {
    //         meetingLinkBox.style.display = 'none';
    //     }   
    //     statusDropdown.addEventListener('change', function () {
    //         if (this.value === 'Approved') {   
    //             meetingLinkBox.style.display = 'block';
    //         } else {          
    //             meetingLinkBox.style.display = 'none';
    //         }
    //     });
    // });
</script> -->