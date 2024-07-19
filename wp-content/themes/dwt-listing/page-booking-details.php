<!-- <?php
global $dwt_listing_options;
get_header();
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
    $meeting_type = get_post_meta( $reservation_listing_id, 'meeting_type', true );
    $message_text = get_post_meta($reservation_id, 'message_text', true );
    $link_text = get_post_meta($reservation_id, 'link_text', true );
//print_r($message_text);
//print_r($link_text);
    //var_dump($link_text);
    
   // $meeting_type = get_post_meta($meeting_type, 'meeting_reservations', true);

    // $table_price = get_post_meta($reservation_id, 'price_of_table', true);


    print_r($reservation_listing_id);

    $order_id = get_post_meta($reservation_id , 'order_id' , true);
    $order = wc_get_order( $order_id );
    $order_status ='';
if ( $order ) {
    $order_status = $order->get_status();
    // echo "Order Status: $order_status";
}


    if (empty($reservation_status)) {
        $reservation_status = 'pending';
    }

    $current_status = get_post_meta($reservation_id , 'booked_listings_reservations', true);
                                
    $current_status  =  $current_status == ""   ?  esc_html__('Pending','dwt-listing') : $current_status;

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
            <p><strong>Meeting Type:</strong> <?php echo $meeting_type; ?></p>
           <?php
           if ($meeting_type === 'virtual_meeting') {
            
            echo '<p><strong>Meeting Link:</strong> ' . $link_text . '</p>';
        }
           ?>
        </div>

        <div class="payment-details">
            <h2>Payment Details</h2>
            
            <p><strong>Order Number:</strong> <?php echo $order_id; ?></p>
            <p><strong>Order Status:</strong> <?php echo $order_status; ?></p>
            

            <?php
            
            
             if(isset($dwt_listing_options['Appointment_paid_booking']) && $dwt_listing_options['Appointment_paid_booking'] == 1) {?>
                <?php
                global $woocommerce;
                
                $booking_price = get_post_meta($reservation_id, 'booking_price', true);
                $booking_type = get_post_meta($reservation_id, 'booking_type', true);
                $booking_order_id = get_post_meta($reservation_id, 'order_id', true);

                //echo "Amount: $" . $booking_price;
                ?>
                <br>
                <?php
                if ($booking_type === 'paid') {
                   // echo "Amount: $" . $booking_price;
                  echo "<strong>Amount:</strong> " . get_woocommerce_currency_symbol() . $booking_price;
                    ?>
                    <br>
                    <?php
                    if (empty($booking_order_id)) {
                        ?>
                        <input type="hidden" id="price_of_table" value="<?php echo $booking_price ;?>">
                        <input type="hidden" id="Appointment_id" value="<?php echo $reservation_id ;?>">
                        <?php
                        // echo '<button id="make_payment_button">Make Payment</button>';
                       
                         ?>
                        <button class="btn btn-primary pay_buttomn" id="make_payment_button" data-listing-id="<?php echo $reservation_listing_id;?>" type="submit"><?php echo esc_html('Payment', 'dwt-listing'); ?></button>
                       <?php
                    } else {
                        
                        echo '<strong id="paid_button" disabled>Already Paid!</strong>';
                    }
                } else {
                  
                    echo '<p>Free Booking</p>';
                }
                ?>
                  
                
            <?php } ?>
        </div>
    </div>
    <?php
                    } else {
    
    ?>
    <div class="error">
        <p>Reservation ID not provided.</p>
    </div>
    <?php
}

get_footer();
?> -->
