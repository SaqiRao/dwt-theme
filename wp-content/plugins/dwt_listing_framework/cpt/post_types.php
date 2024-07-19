<?php
// Register post  type and taxonomy
add_action('init', 'dwt_listing_themes_custom_types', 0);

function dwt_listing_themes_custom_types() {
    // Register Post type for Map Countries
    $args = array(
        'public' => true,
        'menu_icon' => 'dashicons-location',
        'label' => __('Map Countries', 'dwt-listing-framework'),
        'supports' => array('thumbnail', 'title')
    );
    register_post_type('downtown_map_address', $args);


    // Register claim post  type
    $args = array(
        'public' => true,
        'menu_icon' => 'dashicons-shield',
        'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => false, // false < WP 4.5, credit @Ewout
        ),
        'map_meta_cap' => true,
        'label' => __('Claims', 'dwt-listing-framework'),
        'supports' => array('title')
    );
    register_post_type('l_claims', $args);


    ///Form Fields
    $args = array(
        'public' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => 'l_form_fields',
        'menu_icon' => 'dashicons-location',
        'label' => __('Form Fields', 'dwt-listing-framework'),
        'supports' => array('title'),
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'exclude_from_search' => true,
        'show_in_menu' => 'edit.php?post_type=listing',
    );
    register_post_type('l_form_fields', $args);
}

/**
 * A filter to add custom columns and remove built-in
 * columns from the edit.php screen.
 * 
 * @access public
 * @param Array $columns The existing columns
 * @return Array $filtered_columns The filtered columns
 */
function dwt_listing_l_claims_admin_tables($columns) {

    // New columns to add to table
    $new_columns = array(
        'dwt_listing_claim_status' => __('Claim Status', 'dwt-listing-framework'),
        'dwt_listing_claimner' => __('Claimer', 'dwt-listing-framework'),
        'dwt_listing_claimner_no' => __('Contact No', 'dwt-listing-framework')
    );

    // Remove unwanted publish date column
    // unset( $columns['date'] );
    // Combine existing columns with new columns
    $filtered_columns = array_merge($columns, $new_columns);

    // Return our filtered array of columns
    return $filtered_columns;
}

// Let WordPress know to use our filter
add_filter('manage_l_claims_posts_columns', 'dwt_listing_l_claims_admin_tables');

function dwt_listing_l_claims_admin_tables_content($column, $dynamic_data = '', $post_type_id = '') {
    $user_info = '';
    $claimer_name = '';
    $claimer_url = '';
    //get post
    $posts = get_post($post_type_id);
    if ($posts != "") {
        $post_type_id = $posts->ID;
        $user_info = get_userdata($posts->post_author);
        $claimer_name = $user_info->display_name;
        $claimer_url = get_edit_user_link($posts->post_author);
    } else {
        $post_type_id = $post_type_id;
    }

    // Check to see if $column matches our custom column names
    switch ($column) {
        case 'dwt_listing_claim_status' :
            // Retrieve post meta
            if (get_post_meta($post_type_id, 'd_listing_claim_status', true) != "") {
                echo get_post_meta($post_type_id, 'd_listing_claim_status', true);
            } else {
                update_post_meta($post_type_id, 'd_listing_claim_status', $dynamic_data);
            }
            break;

        case 'dwt_listing_claimner' :
            // Retrieve post meta
            echo ('<a href="' . esc_url($claimer_url) . '">' . $claimer_name . '</a>');
            break;

        case 'dwt_listing_claimner_no' :
            // Retrieve post meta
            if (get_post_meta($post_type_id, 'd_listing_claimer_contact', true) != "") {
                echo get_post_meta($post_type_id, 'd_listing_claimer_contact', true);
            } else {
                update_post_meta($post_type_id, 'd_listing_claimer_contact', $dynamic_data);
            }
            break;
    }
}

// Let WordPress know to use our action
add_action('manage_l_claims_posts_custom_column', 'dwt_listing_l_claims_admin_tables_content');

function dwt_listing_l_claims_admin_tables_sort($columns) {
    // Add our columns to $columns array
    $columns['dwt_listing_claim_status'] = 'dwt_listing_claim_status';
    $columns['dwt_listing_claimner'] = 'dwt_listing_claimner';
    $columns['dwt_listing_claimner_no'] = 'contact';

    return $columns;
}

// Let WordPress know to use our filter
add_filter('manage_edit-l_claims_sortable_columns', 'dwt_listing_l_claims_admin_tables_sort');