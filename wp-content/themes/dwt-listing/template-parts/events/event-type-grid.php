<?php
global $dwt_listing_options;
$style_typez = '_grid';
$append_div = $map_listings = $fetch_output = '';
//Masonry layout
$fetch_output .= '<div class="masonery_wrap">';
$eventz = new dwt_listing_events();
while ($results->have_posts()) {
    $results->the_post();
    $event_id = get_the_ID();

    $function = "dwt_listing_event_type$style_typez";
    $fetch_output .= $eventz->$function($event_id);

    /* for map events */
    if (dwt_listing_text("dwt_listing_event_layout") == "map" && is_page_template('page-events.php') || is_tax(array('l_event_cat', 'l_event_tags'))) {
        if (get_post_meta($event_id, 'dwt_listing_event_lat', true) != "" && get_post_meta($event_id, 'dwt_listing_event_long', true) != "") {
            $function = "dwt_listing_event_type_map";
            $map_listings .= $eventz->$function($event_id);
        }
    }
}
$fetch_output .= '</div>';
if (dwt_listing_text("dwt_listing_event_layout") == "map" && is_page_template('page-events.php') || is_tax(array('l_event_cat', 'l_event_tags'))) {
    echo '<script>var event_markers = [' . $map_listings . '];</script>';
}