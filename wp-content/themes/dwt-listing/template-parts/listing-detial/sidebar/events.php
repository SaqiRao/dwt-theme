<?php
global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
echo dwt_listing_check_event_against_listing($listing_id);
