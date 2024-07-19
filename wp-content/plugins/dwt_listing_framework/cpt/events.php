<?php
// Register post  type and taxonomy
add_action('init', 'dwt_listing_listing_events', 0);

function dwt_listing_listing_events() {
    // Register Post Eveny
    $event_slug = 'events';
    if (class_exists('Redux')) {
        $data = $event_slug_val = '';
        $data = get_option('dwt_listing_options');
        if (!empty($data)) {
            if (isset($data['dwt_listing_event_slug']) && $data['dwt_listing_event_slug'] != "") {
                $event_slug_val = $data['dwt_listing_event_slug'];
                if (!empty($event_slug_val)) {
                    $event_slug = trim($event_slug_val);
                }
            }
        }
    }
    $args = array(
        'public' => true,
        'menu_icon' => 'dashicons-calendar',
        'label' => __('Events', 'dwt-listing-framework'),
        'supports' => array('title', 'editor', 'comments'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => $event_slug)
    );
    register_post_type('events', $args);
    //Categories
    $final_slug = 'category';
    if (class_exists('Redux')) {
        $data = $cat_slug = '';
        $data = get_option('dwt_listing_options');
        if (!empty($data)) {
            if (isset($data['dwt_event_cat_slug']) && $data['dwt_event_cat_slug'] != "") {
                $cat_slug = $data['dwt_event_cat_slug'];
                if (!empty($cat_slug)) {
                    $final_slug = trim($cat_slug);
                }
            }
        }
    }
    register_taxonomy('l_event_cat', array('events'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Event Categories', 'dwt-listing-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => $final_slug),
    ));
    //Tags
    register_taxonomy('l_event_tags', array('events'), array(
        'hierarchical' => true,
        'label' => __('Tags', 'dwt-listing-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'l_event_tags'),
    ));
    //Tickets
    
}

// Email on ad publish
add_action('transition_post_status', 'dwt_listing_send_mails_on_publish_events', 10, 3);

function dwt_listing_send_mails_on_publish_events($new_status, $old_status, $post) {
    if ('publish' !== $new_status or 'publish' === $old_status
            or 'events' !== get_post_type($post))
        return;
    global $dwt_listing_options;
    if (isset($dwt_listing_options['dwt_listing_event_send_email']) && $dwt_listing_options['dwt_listing_event_send_email']) {
        dwt_listing_notify_on_new_event($post);
    }
}