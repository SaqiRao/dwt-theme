<?php
global $dwt_listing_options;
$listing_status = '';
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
if (get_post_meta($listing_id, 'dwt_listing_listing_status', true) != "") {
    $listing_status = get_post_meta($listing_id, 'dwt_listing_listing_status', true);
}
$sidebar_class = 'sidebar transparen-listing-sidebar';
if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
    $sidebar_class = 'sidebar transparen-listing-sidebar solid';
}
if (dwt_listing_text('dwt_listing_header-layout') == 2 || dwt_listing_text('dwt_listing_header-layout') == 3 || dwt_listing_text('dwt_listing_header-layout') == 4) {
    $sidebar_class = 'sidebar transparen-listing-sidebar solid';
}
?>
<aside class="<?php echo esc_attr($sidebar_class); ?>">
    <?php
// listing is not expired
    if ($listing_status == '1') {
        ?>
        <?php
        $layout = $dwt_listing_options['dwt_listing_sidebar-layout-manager']['enabled'];

        // print_r($layout);
        if ($layout): foreach ($layout as $key => $value) {
                switch ($key) {
                    case 'card': get_template_part('template-parts/listing-detial/sidebar/profile');
                        break;

                    case 'coupon': get_template_part('template-parts/listing-detial/sidebar/coupon');
                        break;

                    case 'events': get_template_part('template-parts/listing-detial/sidebar/events');
                        break;

                    case 'hours': get_template_part('template-parts/listing-detial/sidebar/hours');
                        break;

                    case 'claim': get_template_part('template-parts/listing-detial/sidebar/claim');
                        break;

                    case 'pricing': get_template_part('template-parts/listing-detial/sidebar/pricing');
                        break;

                    case 'tags': get_template_part('template-parts/listing-detial/sidebar/tags');
                        break;
                    case 'booking_timekit': get_template_part('template-parts/listing-detial/sidebar/booking-timekit');
                        break;
                    case 'nearby_listing': get_template_part('template-parts/listing-detial/sidebar/listing-nearby');
                        break;
                }
            }
        endif;
        ?>
        <?php
    } else {
        //expired listing
        get_template_part('template-parts/listing-detial/sidebar/expired');
    }
    ?>
    <?php
    if (is_active_sidebar('dwt_listing_listing_detial_sidebar')) {
        dynamic_sidebar('dwt_listing_listing_detial_sidebar');
    }
    ?>
</aside>