<?php
if (!defined('ABSPATH'))
    exit;
/* ------------------Blog Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('URL Rewriting', 'dwt-listing'),
    'id' => 'dwt_listing_slug',
    'desc' => '',
    'icon' => 'el el-refresh',
    'fields' => array(
        array(
            'id' => 'dwt_listing_notification_warning',
            'type' => 'info',
            'title' => esc_html__('URL Rewrite', 'dwt-listing'),
            'style' => 'critical',
            'desc' => esc_html__('Need to update permalinks ( under Settings Tab ) after any changes you make in  slugs ( to avoid 404 error page )', 'dwt-listing')
        ),
        array(
            'id' => 'dwt_listing_cat_slug',
            'type' => 'text',
            'title' => esc_html__('Listing Category Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "categories"', 'dwt-listing'),
            'default' => 'categories',
        ),
        array(
            'id' => 'dwt_listing_tags_slug',
            'type' => 'text',
            'title' => esc_html__('Listing Tags Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "tags"', 'dwt-listing'),
            'default' => 'tags',
        ),
        array(
            'id' => 'dwt_listing_loc_slug',
            'type' => 'text',
            'title' => esc_html__('Listing Location Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "location"', 'dwt-listing'),
            'default' => 'location',
        ),
        array(
            'id' => 'dwt_listing_listing_slug',
            'type' => 'text',
            'title' => esc_html__('Listing Detial Page Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "listing"', 'dwt-listing'),
            'default' => 'listing',
        ),
        array(
            'id' => 'dwt_listing_notification_warningz',
            'type' => 'info',
            'title' => esc_html__('URL Rewrite Events', 'dwt-listing'),
            'style' => 'critical',
            'desc' => esc_html__('Need to update permalinks ( under Settings Tab ) after any changes you make in  slugs ( to avoid 404 error page )', 'dwt-listing')
        ),
        array(
            'id' => 'dwt_event_cat_slug',
            'type' => 'text',
            'title' => esc_html__('Events Category Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "event-categories"', 'dwt-listing'),
            'default' => 'event-categories',
        ),
        array(
            'id' => 'dwt_listing_event_slug',
            'type' => 'text',
            'title' => esc_html__('Event Detial Page Slug', 'dwt-listing'),
            'subtitle' => esc_html__('Default is "events"', 'dwt-listing'),
            'default' => 'events',
        ),
    )
));