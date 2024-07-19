<?php
// Our custom post type function
function create_posttype_tickets() {
    $args = array(
        'labels' => array(
            'name' => __( 'Event Tickets' ),
            'singular_name' => __( 'Event Ticket' )
        ),
        'key' => 'dwt_listing_author',
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'evet_tickets'),
        'show_in_rest' => true
    );
  
    register_post_type( 'tickets', $args
    // // CPT Options
    //     array(
    //         'labels' => array(
    //             'name' => __( 'Event Tickets' ),
    //             'singular_name' => __( 'Event Ticket' )
    //         ),
    //         'key' => 'dwt_listing_author',
    //         'public' => true,
    //         'has_archive' => true,
    //         'rewrite' => array('slug' => 'evet_tickets'),
    //         'show_in_rest' => true
    //     )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_tickets' );
function create_event_ticket_posttype( $post_id ) {

    global $post;   

    if(isset($_POST['user_name']) ){
        update_post_meta( $post_id, 'user_name' , $_POST['user_name']);
    }      
    if(isset($_POST['ticket_quantity']) ){
        update_post_meta( $post_id, 'ticket_quantity' ,$_POST['ticket_quantity']);
    } 
    if(isset($_POST['tickets_price']) ){
        update_post_meta( $post_id, 'tickets_price' ,$_POST['tickets_price']);
    }      
    if(isset($_POST['extra_services']) ){
        update_post_meta( $post_id, 'extra_services' ,$_POST['extra_services']);
    }      
    if(isset($_POST['grand_total']) ){
        update_post_meta( $post_id, 'grand_total' ,$_POST['grand_total']);
    }    
    if(isset($_POST['dwt_listing_admin_commission']) ){
        update_post_meta( $post_id, 'dwt_listing_admin_commission' ,$_POST['dwt_listing_admin_commission']);
    }  
    if(isset($_POST['event_id']) ){
        update_post_meta( $post_id, 'event_id' ,$_POST['event_id']);
    }      
    if(isset($_POST['dwt_listing_event_name']) ){
        update_post_meta( $post_id, 'dwt_listing_event_name' ,$_POST['dwt_listing_event_name']);
    }
    if(isset($_POST['event_date']) ){
        update_post_meta( $post_id, 'event_date' ,$_POST['event_date']);
    }
    if(isset($_POST['order_status']) ){
        update_post_meta( $post_id, 'order_status' ,$_POST['order_status']);
    }     
}
add_action( 'save_post', 'create_event_ticket_posttype' );


add_filter('manage_tickets_posts_columns', function($columns) {
     
    $columns['name']    =   __('Name', 'dwt-listing-framework');
    $columns['no_of_tickets']  =   __('Total Tickets', 'dwt-listing-framework');
    $columns['price_of_tickets']  =   __('Ticket Price', 'dwt-listing-framework');
    $columns['extra_service']  =   __('Extra Service Price', 'dwt-listing-framework');
    $columns['grand_total']   =   __('Grand Total', 'dwt-listing-framework');
    $columns['admin_commision']   =   __('Admin Commisson', 'dwt-listing-framework');
    $columns['event_title']   =   __('Event Name', 'dwt-listing-framework');
    $columns['event_date']   =   __('Date', 'dwt-listing-framework');
    $columns['event_id']  =   __('Event ID', 'dwt-listing-framework');
    $columns['order_status']   =   __('Status', 'dwt-listing-framework');

    unset( $columns['date'] );
    unset( $columns['title'] );
    
    return $columns;
    
});
add_action('manage_tickets_posts_custom_column', function($column_key, $my_event_tickets_post) {
    if ($column_key == 'name') {
        echo get_post_meta( $my_event_tickets_post, 'dwt_event_user_name', true );
    }
    if($column_key == 'no_of_tickets'){
        echo get_post_meta( $my_event_tickets_post, 'dwt_event_no_of_tickets', true );
    }
    if ($column_key == 'price_of_tickets') {
        echo get_post_meta($my_event_tickets_post, 'dwt_event_ticket_price', true);
    }
    if ($column_key == 'extra_service') {
        echo get_post_meta($my_event_tickets_post, 'dwt_event_extra_services_price', true);
    }
    if ($column_key == 'grand_total'){
        echo get_post_meta( $my_event_tickets_post, 'dwt_listing_event_grand_total_price', true );
    }
    if ($column_key == 'admin_commision'){
        echo get_post_meta( $my_event_tickets_post, 'dwt_listing_admin_commission', true );
    }
    if ($column_key == 'event_title'){
        echo get_post_meta( $my_event_tickets_post, 'dwt_listing_event_name', true );
    }
    if ($column_key == 'event_date'){
        echo get_post_meta($my_event_tickets_post, 'dwt_listing_event_date', true);
    }
    if ($column_key == 'event_id'){
        echo get_post_meta( $my_event_tickets_post, 'dwt_listing_event_id', true );   
    }
    if ($column_key == 'order_status'){
        echo get_post_meta( $my_event_tickets_post, 'order_status', true );   
    }
}, 10, 2,);