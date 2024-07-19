<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
//select layout type only for transparent header
if (dwt_listing_text('dwt_listing_header-layout') == 1) {
    get_template_part('template-parts/listing-detial/with_transparent/listing-detial', '1');
}
//solid headers
if (dwt_listing_text('dwt_listing_header-layout') == 2 || dwt_listing_text('dwt_listing_header-layout') == 3 || dwt_listing_text('dwt_listing_header-layout') == 4 || dwt_listing_text('dwt_listing_header-layout') == 5) {
    get_template_part('template-parts/listing-detial/with_solid/listing-detial', '1');
}