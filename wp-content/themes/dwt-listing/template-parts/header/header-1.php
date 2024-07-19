<?php
global $dwt_listing_options;

if (is_page_template('page-search.php') && is_page()) {
    //for search page with transparent header
    if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
        if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
            get_template_part('template-parts/header/transparent-header/with-sidebar');
        } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
            get_template_part('template-parts/header/transparent-header/with-sidebar');
        } else {
            get_template_part('template-parts/header/transparent-header/with-map');
        }
    } else {
        get_template_part('template-parts/header/transparent-header/with-sidebar');
    }
} else if (is_page_template('page-events.php') && is_page()) {
    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {
        get_template_part('template-parts/header/transparent-header/with-map');
    } else {
        get_template_part('template-parts/header/transparent-header/with-sidebar');
    }
} else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
        get_template_part('template-parts/header/transparent-header/with-map');
    } else {
        get_template_part('template-parts/header/transparent-header/with-sidebar');
    }
} else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
    //for event search
    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {
        get_template_part('template-parts/header/transparent-header/with-map');
    } else {
        get_template_part('template-parts/header/transparent-header/with-sidebar');
    }
} else {
    get_template_part('template-parts/header/transparent-header/with-sidebar');
}