<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
get_template_part('template-parts/listing-detial/with_transparent/listing-detial', 'minimal');
