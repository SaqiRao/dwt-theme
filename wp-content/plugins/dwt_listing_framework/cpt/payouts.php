<?php
// Our custom post type function
function create_posttype_payouts() {
  
    register_post_type( 'payouts',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'payouts', 'dwt-listing-framework' ),
                'singular_name' => __( 'payout', 'dwt-listing-framework' )
            ),
            'key' => 'dwt_listing_author',
            'public' => true,
            'has_archive' => true,
            'menu_icon' => SB_PLUGIN_URL.'/images/wallet.png',
            'rewrite' => array('slug' => 'payouts'),
            'show_in_rest' => true,
        ),
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_payouts' );

function create_event_payout_posttype( $post_id ) {

    global $post;   

    if(isset($_POST['user_name']) ){
        update_post_meta( $post_id, 'user_name' , $_POST['user_name']);
    }      
    if(isset($_POST['ticket_quantity']) ){
        update_post_meta( $post_id, 'ticket_quantity' ,$_POST['ticket_quantity']);
    } 
    if(isset($_POST['payout_price']) ){
        update_post_meta( $post_id, 'payout_price' ,$_POST['payout_price']);
    }      
    if(isset($_POST['extra_services']) ){
        update_post_meta( $post_id, 'extra_services' ,$_POST['extra_services']);
    }  
    if(isset($_POST['event_payout_status']) ){
        update_post_meta( $post_id, 'event_payout_status' ,$_POST['event_payout_status']);
    }
}
add_action( 'save_post', 'create_event_payout_posttype' );


add_filter('manage_payouts_posts_columns', function($columns) {
     
    $columns['description']    =   __('Message', 'dwt-listing-framework');
    $columns['amount']  =   __('Amount', 'dwt-listing-framework');
    $columns['author']  =   __('Author', 'dwt-listing-framework');
    $columns['status']  =   __('Payout Status', 'dwt-listing-framework');
    $columns['payout_date']  =   __('Date', 'dwt-listing-framework');

    unset( $columns['date'] );
    unset( $columns['title'] );
    
    return $columns;
    
});
add_action('manage_payouts_posts_custom_column', function($column_key, $my_event_payout_post) {
    if ($column_key == 'description') {
        echo get_post_meta( $my_event_payout_post, 'dwt_listing_payout_message', true );
    }
    if($column_key == 'amount'){
        echo get_post_meta( $my_event_payout_post, 'dwt_listing_payout_amount', true );
    }
    if ($column_key == 'author') {
        echo get_post_meta($my_event_payout_post, 'dwt_listing_payout_name', true);
    }
    if ($column_key == 'payout_date'){
        echo get_post_meta( $my_event_payout_post, 'dwt_listing_payout_date', true );
    }
    if ($column_key == 'status'){
        //echo get_post_meta($my_event_payout_post, 'payout_status', true );  
        $payout_status = get_post_meta($my_event_payout_post, 'payout_status', true );
            if($payout_status == "1"){
               echo $payout_status  =  esc_html__('processd','');
            }
            else {
                echo $payout_status  =  esc_html__('Pending','');
            } 
    }
}, 10, 2,);