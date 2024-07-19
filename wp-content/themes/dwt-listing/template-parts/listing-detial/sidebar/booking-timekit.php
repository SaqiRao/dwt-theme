<?php
$listing_id = '';
$listing_id = get_the_ID();
$listing_booking_status = get_post_meta($listing_id, 'dwt-listing-timekit-booking-status', true);
$dwt_listing_timekit_booking = get_post_meta($listing_id, 'dwt-listing-timekit-booking', true);
?>
<?php
if (isset($listing_booking_status) && $listing_booking_status == '1' && $listing_booking_status != '') {
    ?>
    <?php
    echo '<div id="bookingjs"></div>';
    echo htmlspecialchars_decode($dwt_listing_timekit_booking);
    ?>
<?php } ?>