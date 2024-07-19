<?php get_header(); ?>
<?php

global $dwt_listing_options;

if (have_posts()) {
    $my_url = '';
    $my_url = dwt_listing_get_current_url();
    while (have_posts()) {
        the_post();

    
    }
    //sticky action buttons
    get_template_part('template-parts/events/event-detial/speakers/event-speakers');
} else {
//     get_template_part('template-parts/content', 'none');
}
?>
<?php get_footer(); ?>