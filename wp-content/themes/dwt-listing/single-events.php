<?php get_header(); ?>
<?php

global $dwt_listing_options;

if (have_posts()) {
    $my_url = '';
    $my_url = dwt_listing_get_current_url();
    while (have_posts()) {
        the_post();
        $event_id = get_the_ID();
        if (strpos($my_url, 'listing.downtown-directory.com') !== false) {
            
        } else {
            dwt_listing_check_event_ending($event_id);
        }


        
        if (isset($dwt_listing_options['dwt_listing_event_view']) && $dwt_listing_options['dwt_listing_event_view'] == 'modern') {
            get_template_part('template-parts/events/event-detial/detial', 'modern');
        } else {
            get_template_part('template-parts/events/event-detial/detial');
        }
    }
    //sticky action buttons
    get_template_part('template-parts/events/event-detial/edit', 'event');
} else {
    get_template_part('template-parts/content', 'none');
}
?>
<?php get_footer(); ?>