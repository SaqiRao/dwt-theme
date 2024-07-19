<?php
global $dwt_listing_options;
$style_typez = '_grid';
$append_div = $map_listings = $fetch_output = '';
//Masonry layout
$fetch_output .= '<div class="list-boxes">';
$eventz = new dwt_listing_events();
while ($results->have_posts()) {
    $results->the_post();
    $event_id = get_the_ID();
    $function = "dwt_listing_event_type$style_typez";
    $fetch_output .= $eventz->$function($event_id, true);

    //for map events
    if (get_post_meta($event_id, 'dwt_listing_event_lat', true) != "" && get_post_meta($event_id, 'dwt_listing_event_long', true) != "") {
        $function = "dwt_listing_event_type_map_ajax";
        $map_listings .= $eventz->$function($event_id);
    }
}
$fetch_output .= '</div>';
echo '<script>var event_markers_ajax = [' . $map_listings . '];</script>';