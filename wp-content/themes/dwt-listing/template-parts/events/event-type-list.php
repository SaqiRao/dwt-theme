<?php
global $dwt_listing_options;
$style_typez = '_list';
$fetch_output = '';
//Masonry layout
$fetch_output .= '<div class="masonery_wrap">';
$eventz = new dwt_listing_events();
while ($results->have_posts()) {
    $results->the_post();
    $event_id = get_the_ID();
    $function = "dwt_listing_event_type$style_typez";
    $fetch_output .= $eventz->$function($event_id);
}
$fetch_output .= '</div>';