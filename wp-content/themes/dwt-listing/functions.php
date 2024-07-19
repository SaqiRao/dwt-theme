<?php
/**
* dwt listing functions and definitions.
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package dwt listing
*/
add_action( 'after_setup_theme', 'dwt_listing_theme_setup' );
if ( !function_exists( 'dwt_listing_theme_setup' ) ) {

    /* dwt listing Theme Settings */

    function dwt_listing_theme_setup()
 {
        /* Theme Settings */
        require trailingslashit( get_template_directory() ) . 'inc/theme_settings.php';
        /* Register Custom Navigation Walker */
        require trailingslashit( get_template_directory() ) . 'inc/nav.php';
        /* Load Essential Functions */
        require trailingslashit( get_template_directory() ) . 'inc/theme-functions.php';
        /* Load Theme Functions */
        require trailingslashit( get_template_directory() ) . 'inc/utilities.php';
        /* Load Theme Widgets */
        require trailingslashit( get_template_directory() ) . 'inc/widgets.php';
        /* Theme Classes */
        require trailingslashit( get_template_directory() ) . 'inc/classes/index.php';
        /* Theme Shortcodes */
        require trailingslashit( get_template_directory() ) . 'inc/theme_shortcodes/shortcodes.php';
        /* Load Redux Options */
        require trailingslashit( get_template_directory() ) . 'inc/options.php';
        /* Load Theme Widgets */
        require trailingslashit( get_template_directory() ) . 'inc/listing-widgets.php';
        /* TGM */
        require trailingslashit( get_template_directory() ) . 'tgm/tgm-init.php';
        /* Woo Commerece Additional Wallet Functions */
        require trailingslashit( get_template_directory() ) . 'inc/woo-functions.php';


    }

}

/**
* Register custom fonts.
*/

function dwt_listing_fonts_url( $font_call = '' )
 {
    $fonts_url = '';
    if ( is_rtl() ) {
        if ( $font_call == 'xb-niloofar' ) {
            $font_families = 'xb-niloofar';
        }
        if ( $font_call == 'droid-arabic-naskh' ) {
            $font_families = 'droid-arabic-naskh';
        }
        if ( $font_call == 'popins' ) {
            $fonts_url = 'https://fonts.googleapis.com/css?family=Open+Sans:400,600';
        } else {
            $fonts_url = 'https://fontlibrary.org/face/' . $font_families;
        }
    }
    return esc_url_raw( $fonts_url );
}

/* ------------------------------------------------ */
/* Enqueue scripts and styles. */
/* ------------------------------------------------ */
add_action( 'wp_enqueue_scripts', 'dwt_listing_scripts' );

function dwt_listing_scripts()
 {
    global $dwt_listing_options;
    $assets_dir = trailingslashit( get_template_directory_uri() ) . 'assets/';
    /* Enqueue scripts. */
    wp_enqueue_script( 'bootstrap', $assets_dir . 'js/bootstrap.min.js', false, false, true );
    wp_enqueue_script( 'dropzone', $assets_dir . 'js/dropzone.js', false, false, true );
    wp_enqueue_script( 'dwt-listing-plugins', $assets_dir . 'js/plugins.js', false, false, true );
    wp_enqueue_script( 'dwt-register-hello', $assets_dir . 'js/hello.js', false, false, true );
    wp_enqueue_script( 'validator', $assets_dir . 'js/validator.min.js', false, false, true );
    wp_enqueue_script( 'dwt-listing-registration', $assets_dir . 'js/registration.js', false, false, true );
    if ( is_page_template( 'page-profile.php' ) ) {
        wp_enqueue_script( 'slimscroll', $assets_dir . 'js/jquery.slimscroll.min.js', false, false, true );
    }
    wp_enqueue_script( 'dwt-listing-profile', $assets_dir . 'js/profile.js', false, false, true );
    wp_enqueue_script( 'dwt-listing-listing', $assets_dir . 'js/listing.js', false, false, true );
    wp_enqueue_script( 'jquery-confirm', $assets_dir . 'js/jquery-confirm.js', false, false, true );
    wp_enqueue_script( 'typeahead-adv', $assets_dir . 'js/typeahead.adv.js', false, false, true );
    wp_enqueue_script( 'leaflet', $assets_dir . 'js/map/leaflet.js', false, false, true );
    wp_enqueue_script( 'leaflet-search', $assets_dir . 'js/map/leaflet-search.min.js', false, false, true );
    wp_enqueue_script( 'leaflet-fullscreen', $assets_dir . 'js/map/leaflet-fullscreen.js', false, false, true );
    wp_enqueue_script( 'leaflet-autoComplete', $assets_dir . 'js/map/leaflet-autocomplete.js', false, false, true );
    wp_enqueue_script( 'leaflet-github-corner', $assets_dir . 'js/map/github-corner.js', false, false, true );
    wp_enqueue_script( 'leaflet-script', $assets_dir . 'js/map/script.js', false, false, true );
    if ( dwt_listing_text( 'dwt_listing_recaptcha' ) == 1 ) {
        wp_enqueue_script( 'recaptcha', '//www.google.com/recaptcha/api.js', false, false, true );
    }
    if ( $dwt_listing_options[ 'dwt_listing_enable_map' ] == '1' && $dwt_listing_options[ 'dwt_map_selection' ] == 'google_map' && $dwt_listing_options[ 'gmap_api_key' ] != '' ) {
        $map_lang = 'en';
        if ( isset( $dwt_listing_options[ 'dwt_listing_gmap_lang' ] ) && $dwt_listing_options[ 'dwt_listing_gmap_lang' ] != '' ) {
            $map_lang = $dwt_listing_options[ 'dwt_listing_gmap_lang' ];
        }
        wp_enqueue_script( 'google-map', '//maps.googleapis.com/maps/api/js?key=' . $dwt_listing_options[ 'gmap_api_key' ] . '&language=' . $map_lang, false, false, true );
        /* call back */
        wp_register_script( 'google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $dwt_listing_options[ 'gmap_api_key' ] . '&libraries=geometry,places&language=' . $map_lang . '&callback=' . 'dwt_listing_location', false, false, true );
    }
    if ( is_singular() )
    wp_enqueue_script( 'comment-reply', '', true );
    if ( isset( $dwt_listing_options[ 'dwt_listing_enable_video_option' ] ) && $dwt_listing_options[ 'dwt_listing_enable_video_option' ] != '' ) {
        wp_enqueue_style( 'popup-video-iframe-style', $assets_dir . 'css/video_player.css' );
        wp_enqueue_script( 'popup-video-iframe', $assets_dir . 'js/video_player.js', false, false, true );
    }

    wp_enqueue_script( 'theia-sticky-sidebar', $assets_dir . 'js/theia-sticky-sidebar.js', false, false, true );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'imagesloaded' );
    //only for search page
    if ( isset( $dwt_listing_options[ 'dwt_listing_seacrh_page' ] ) && $dwt_listing_options[ 'dwt_listing_seacrh_page' ] != '' && is_page() || is_tax( array( 'l_category', 'l_tags', 'l_location' ) ) ) {
        if ( get_page_template_slug( $dwt_listing_options[ 'dwt_listing_seacrh_page' ] ) == get_page_template_slug( get_the_ID() ) || is_tax( array( 'l_category', 'l_tags', 'l_location' ) ) ) {
            //leaflet
            if ( dwt_listing_text( 'dwt_listing_seacrh_layout' ) == 'map' ) {
                wp_enqueue_script( 'leaflet-loader', $assets_dir . 'js/map/leafloader.js', false, false, true );
                wp_enqueue_script( 'leaflet-cluster', $assets_dir . 'js/map/leaflet.markercluster.js', false, false, true );
                wp_enqueue_script( 'dwt-listing-search', $assets_dir . 'js/listing-search/search_map.js', false, false, true );
            } else if ( dwt_listing_text( 'dwt_listing_seacrh_layout' ) == 'topbar' ) {
                //for sidebar
                wp_enqueue_script( 'dwt-listing-search', $assets_dir . 'js/listing-search/search_topbar.js', false, false, true );
            } else {
                //for sidebar
                wp_enqueue_script( 'dwt-listing-search', $assets_dir . 'js/listing-search/search_sidebar.js', false, false, true );
            }
        }
    }
    if ( is_page_template( 'page-events.php' ) && is_page() || is_tax( array( 'l_event_cat', 'l_event_tags', 'l_event_tickets' ) ) ) {
        if ( dwt_listing_text( 'dwt_listing_event_layout' ) == 'map' ) {
            wp_enqueue_script( 'leaflet-loader', $assets_dir . 'js/map/leafloader.js', false, false, true );
            wp_enqueue_script( 'leaflet-cluster', $assets_dir . 'js/map/leaflet.markercluster.js', false, false, true );
            wp_enqueue_script( 'dwt-listing-search', $assets_dir . 'js/event-search/events_map.js', false, false, true );
        } else {
            wp_enqueue_script( 'dwt-listing-search', $assets_dir . 'js/event-search/events_simple.js', false, false, true );
        }

    }

    if ( is_page_template( 'page-listing.php' ) && is_page() ) {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'date-en', $assets_dir . 'js/submit-listing/date-en-US.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'timeselect', $assets_dir . 'js/submit-listing/jquery.ui.timeselect.js', array( 'jquery' ), false, true );
    }

    if ( isset( $dwt_listing_options[ 'dwt_listing_lp_style' ] ) && $dwt_listing_options[ 'dwt_listing_lp_style' ] != '' && $dwt_listing_options[ 'dwt_listing_lp_style' ] == 'minimal' && is_page_template( 'page-listing.php' ) ) {
        wp_enqueue_script( 'bootstrap-fileinput', $assets_dir . 'js/bootstrap-imageupload.min.js', array( 'jquery' ), false, true );
    }
    if ( !empty( $dwt_listing_options[ 'dwt_listing_locationz' ] ) && $dwt_listing_options[ 'dwt_listing_locationz' ] == '1' ) {
        wp_enqueue_script( 'cookies', $assets_dir . 'js/js.cookie.js', array( 'jquery' ), false, true );
    }
    if ( is_singular( 'listing' ) ) {
        /* == enqueue timekit js for fast load == */
        if ( isset( $dwt_listing_options[ 'dwt_listing_booking_time_kit' ] ) && ( $dwt_listing_options[ 'dwt_listing_booking_time_kit' ] != 0 || $dwt_listing_options[ 'dwt_listing_booking_time_kit' ] != false ) ) {
            wp_enqueue_script( 'timekit', $assets_dir . 'js/booking.min.js', array( 'jquery' ), false, true );
        }
    }

    wp_enqueue_script( 'dwt-listing-custom', $assets_dir . 'js/custom.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'dwt-listing-custom-lang', $assets_dir . 'js/date-picker-lang/datepicker.en.js', array( 'jquery' ), false, true );
    // wp_enqueue_script( 'dwt-listing-datepicker', $assets_dir . 'js/datepicker.min.js', array( 'jquery' ), false, true );
    
    wp_enqueue_script('jquery-air-datepicker', $assets_dir .'js/air-datepicker.min.js');
    wp_enqueue_style('jquery-air-datepicker-css', $assets_dir .'css/air-datepicker.min.css');
        
    
     /* Load the stylesheets. */
    wp_enqueue_style( 'dwt-listing-style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap_min', $assets_dir . 'css/bootstrap.min.css' );
    if ( is_rtl() ) {
        wp_enqueue_style( 'bootstrap-rtl', $assets_dir . 'css/rtl/bootstrap-rtl.min.css' );
        wp_enqueue_style( 'dwt-listing-mega-menu', $assets_dir . 'css/rtl/mega-menu-rtl.css' );
    } else {
        wp_enqueue_style( 'dwt-listing-mega-menu', $assets_dir . 'css/mega-menu.css' );
    }
    wp_enqueue_style( 'dwt_listing_plugins_styles', $assets_dir . 'css/plugins.css' );
    if ( is_rtl() ) {
        wp_enqueue_style( 'dwt-listing-fonts-xb-niloofar', dwt_listing_fonts_url( 'xb-niloofar' ), array(), null );
        wp_enqueue_style( 'dwt-listing-fonts-droid-arabic-naskh', dwt_listing_fonts_url( 'droid-arabic-naskh' ), array(), null );
        wp_enqueue_style( 'dwt-listing-fonts-popins', dwt_listing_fonts_url( 'popins' ), array(), null );
        wp_enqueue_style( 'dwt-listing-woo', $assets_dir . 'css/rtl/woocommerce-rtl.css' );
    } else {
        wp_enqueue_style( 'dwt-listing-woo', $assets_dir . 'css/woocommerce.css' );
    }
    if ( is_page_template( 'page-profile.php' ) ) {
        wp_enqueue_style( 'dwt-listing-admin-styling', $assets_dir . 'css/admin/dwt-admin.css' );
        wp_enqueue_style( 'dwt-listing-admin-icons', $assets_dir . 'css/admin/admin-fonts.css' );
        if ( is_rtl() ) {
            wp_enqueue_style( 'dwt-listing-admin-rtl', $assets_dir . 'css/admin/rtl/admin-rtl.css' );
        }
    } else {
        wp_enqueue_style( 'dwt-listing-styling', $assets_dir . 'css/dwt-listing.css' );
    }
    if ( is_rtl() ) {
        wp_enqueue_style( 'leaflet', $assets_dir . 'css/map/leaflet-rtl.css' );
        wp_enqueue_style( 'leaflet-search', $assets_dir . 'css/map/leaflet-search-rtl.min.css' );
        wp_enqueue_style( 'dwt-listing-style-rtl', $assets_dir . 'css/rtl/dwt-listing-rtl.css' );
        wp_enqueue_style( 'dwt-listing-custom', $assets_dir . 'css/rtl/custom-rtl.css' );
        wp_enqueue_style( 'dwt-listing-responsive', $assets_dir . 'css/rtl/responsive-rtl.css' );
    } else {
        wp_enqueue_style( 'leaflet', $assets_dir . 'css/map/leaflet.css' );
        wp_enqueue_style( 'leaflet-search', $assets_dir . 'css/map/leaflet-search.min.css' );
        wp_enqueue_style( 'dwt-listing-custom', $assets_dir . 'css/custom.css' );
        wp_enqueue_style( 'dwt-listing-responsive', $assets_dir . 'css/responsive.css' );
        wp_enqueue_style( 'leaflet-fullscreen', $assets_dir . 'css/map/leaflet-fullscreen.css' );
        wp_enqueue_style( 'leaflet-autoComplete', $assets_dir . 'css/map/leaflet-autocomplete.css' );
        // wp_enqueue_style( 'leaflet-global', $assets_dir . 'css/map/leaflet-global.css' );
    }

    wp_enqueue_style( 'dwt-listing-icons', $assets_dir . 'css/all-icons.css' );
    wp_enqueue_style( 'dwt-flat-icons', $assets_dir . 'css/flaticons.css' );
}

add_action('admin_enqueue_scripts', 'dwt_load_date_picker');

function dwt_load_date_picker() {
    $assets_dir = trailingslashit( get_template_directory_uri() ) . 'assets/';
    wp_enqueue_script( 'datepicker', $assets_dir . 'js/map/datepicker.min.js', false, false, true );
   
}

/* ==  get current page url == */
if ( !function_exists( 'dwt_listing_get_current_url' ) ) {

    function dwt_listing_get_current_url()
 {
        return $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

}

function dwt_listing_custom_theme_setup()
 {
    add_theme_support( 'html5', array( 'comment-list' ) );
}

add_action( 'after_setup_theme', 'dwt_listing_custom_theme_setup' );
add_action( 'after_setup_theme', 'dwt_listing_hide_adminbar' );
if ( !function_exists( 'dwt_listing_hide_adminbar' ) ) {

    function dwt_listing_hide_adminbar()
 {
        if ( is_user_logged_in() && !is_admin() && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            $user = wp_get_current_user();
            if ( in_array( 'subscriber', $user->roles ) ) {
                // user has subscriber role
                show_admin_bar( false );
            }
        }
    }

}
add_action( 'get_header', 'dwt_listing_remove_admin_login_header' );

function dwt_listing_remove_admin_login_header()
 {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

/* = Cron Jobs = */
$my_url = '';
$my_url = dwt_listing_get_current_url();
if ( strpos( $my_url, 'listing.downtown-directory.com' ) !== false ) {

} else {
    // delete_post_revisions will be call when the Cron is executed
    add_action( 'dwt_listing_event_expire', 'dwt_listing_event_status_expire' );
}
// This function will run once the 'dwt_listing_event_status_expire' is called

function dwt_listing_event_status_expire()
 {
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'dwt_listing_event_status',
                'value' => 1,
                'compare' => '=',
            ),
        ),
    );
    $result = new WP_Query( $args );
    while ( $result->have_posts() ) {
        $result->the_post();
        $eventID = get_the_ID();
        //call the function for change event status if event has been expire.
        dwt_listing_check_event_ending( $eventID );
    }
}

global $dwt_listing_options;
$cron_switch = $cron_interval = '';
$dwt_listing_options = get_option( 'dwt_listing_options' );
if ( is_array( $dwt_listing_options ) && !empty( $dwt_listing_options ) ) {
    if ( isset( $dwt_listing_options[ 'dwt_listing_event_cron_switch' ] ) && $dwt_listing_options[ 'dwt_listing_event_cron_switch' ] != '' ) {
        $cron_switch = $dwt_listing_options[ 'dwt_listing_event_cron_switch' ];
        if ( $dwt_listing_options[ 'dwt_listing_events_cron_interval' ] != '' ) {
            $cron_interval = $dwt_listing_options[ 'dwt_listing_events_cron_interval' ];
        } else {
            $cron_interval = 'daily';
        }
        if ( isset( $cron_switch ) && $cron_switch ) {
            // Make sure this event hasn't been scheduled
            if (!wp_next_scheduled('dwt_listing_event_expire')) {
                // Schedule the event
                wp_schedule_event(time(), $cron_interval, 'dwt_listing_event_expire');
            }
        }
        /* =  Un-scheduling Events = */
        if (isset($cron_switch) && !$cron_switch) {
            // Get the timestamp of the next scheduled run
            $timestamp = wp_next_scheduled('dwt_listing_event_expire');
            // Un-schedule the event
            wp_unschedule_event($timestamp, 'dwt_listing_event_expire');
        }
    }
}
/* == hide admin bar  == */
if (is_array($dwt_listing_options) && !empty($dwt_listing_options)) {
    if (isset($dwt_listing_options['dwt_listing_admin_bar_switch']) && $dwt_listing_options['dwt_listing_admin_bar_switch'] == false) {
        add_filter('show_admin_bar', '__return_false');
    }
}

/* check page build with elementor */
if (!function_exists('dwt_check_is_elementor')) {

    function dwt_check_is_elementor($page_id)
    {
        if (class_exists('Elementor\Plugin')) {
            return \Elementor\Plugin::$instance->documents->get( $page_id )->is_built_with_elementor($page_id);

        } else {
            return false;
        }
    }

}
/*
 * Woocommerce template overwride
 */
/* Remove breadcrumbs from shop & categories */
add_filter('woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs()
{
    if (is_product()) {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    }
}

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

add_action('send_headers', 'dwt_block_iframes');
if (!function_exists('dwt_block_iframes')) {
    function dwt_block_iframes()
    {

        header('X-FRAME-OPTIONS: SAMEORIGIN');
    }
}

/*
 * Elementor Header and Footer
 */
if (in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))){
    add_action( 'elementor/theme/register_locations', 'theme_prefix_register_elementor_locations' );
    function theme_prefix_register_elementor_locations( $elementor_theme_manager ) {

        $elementor_theme_manager->register_location( 'header' );
        $elementor_theme_manager->register_location( 'footer' );
        }
    }

    //Get Template Slug
if( !function_exists('dwt_framework_get_options') )
{
	function dwt_framework_get_options($get_text)
	{
		global $maxwheels_options;
		if(isset($maxwheels_options[$get_text]) &&  $maxwheels_options[$get_text] !=""):
			return $maxwheels_options[$get_text];
		else:
			return false;
		endif;
	}
}

// Get Specific Page Link
if (!function_exists('dwt_framwork_get_link'))
{
    function dwt_framwork_get_link($page_name)
	{
		if(!empty($page_name))
		{
			$archive_id = $archive_page = '';
			$archive_page = get_pages(
				array(
					'meta_key' => '_wp_page_template',
					'meta_value' => $page_name
				)
			);
			if(!empty($archive_page))
			{
				$archive_id = $archive_page[0]->ID;
				return  get_permalink( $archive_id );
			}
		}
	}
}

//Return dynamic data
if (!function_exists('dwt_params'))
{
    function dwt_params($param)
    {
        if(!empty($param))
        {
          return $param;  
        }
    }
}


//for meeting type

add_action('wp_ajax_store_meeting_type', 'store_meeting_type');
add_action('wp_ajax_nopriv_store_meeting_type', 'store_meeting_type');

function store_meeting_type() {


    if(isset($_POST['meetingType']) && isset($_POST['postID'])) {
        $meeting_type = sanitize_text_field($_POST['meetingType']);
        $post_id = intval($_POST['postID']);

        
        update_post_meta($post_id, 'meeting_listing_type', $meeting_type);

        
        echo json_encode(array('success' => true));
    } else {
    
        echo json_encode(array('error' => 'Meeting type or post ID is missing.'));
    }
}



//for virtual meeting type

add_action('wp_ajax_store_meeting_type', 'store_meeting_type_callback');

function store_meeting_type_callback() {
    
    $meeting_type = $_POST['meetingType'];
    $meeting_link = $_POST['meetingLink'];
    $post_id = $_POST['postID'];


    
    update_post_meta($post_id, 'meeting_type', $meeting_type);
    update_post_meta($post_id, 'meeting_link', $meeting_link);

    
    echo 'Meeting type stored successfully.';

    wp_die();
}





//for cart hooks

add_filter( 'woocommerce_cart_item_name', 'just_a_test', 0, 3 );
function just_a_test( $item_name,  $cart_item,  $cart_item_key ) {
    // print_r($cart_item);
    

    if(isset($cart_item['appointment_id']) && !empty($cart_item['appointment_id'])){
        $booking_id = $cart_item['appointment_id'];
        $item_name .= '</br><small>Appointment ID: ' .esc_html($booking_id) . '</small>';

    }
    
    if(isset($cart_item['listing_id']) && !empty($cart_item['listing_id'])){
        $listing_id = $cart_item['listing_id'];
        $item_name .= '</br><small>Listing id: ' .esc_html($listing_id) . '</small>';
        $listing_title = get_the_title( $listing_id );
        $listing_permalink = get_permalink( $listing_id );
    
       if ( $listing_title ) {
                $item_name .= '</br><small>Listing Title:<a href="' . esc_url( $listing_permalink ) . '">' . esc_html( $listing_title ) . '</a></small>';
        }
    }
    return $item_name;
}

//global $booking_id, $order_id;

add_action( 'woocommerce_order_status_changed', 'retrieve_order_meta_on_status_change', 10, 4 );
function retrieve_order_meta_on_status_change( $order_id, $old_status, $new_status, $order ) {
  $order = wc_get_order($order_id);
   foreach ($order->get_items() as $item_id => $item) {


   
     // Loop through order items
        // Get booking ID from order item meta
         $appointment_id = $item->get_meta('appointment_id');
        // Check if booking ID exists
        if ($appointment_id) {
           update_post_meta($appointment_id , 'order_id' , $order_id );
        }
    }
}

//
add_action('woocommerce_checkout_create_order_line_item', 'save_booking_id_to_order_meta', 10, 4);

function save_booking_id_to_order_meta($item, $cart_item_key, $values, $order) {
    // Check if the cart item has booking ID data
    if (!empty($values['appointment_id'])) {
        // Get the booking ID from the cart item
        $booking_id = $values['appointment_id'];

        // Save booking ID as order meta
        $item->add_meta_data('appointment_id', $booking_id);
    }
}





// add_action('woocommerce_checkout_create_order_line_item', 'save_booking_id_to_order_meta', 10, 4);
// function save_booking_id_to_order_meta($item, $cart_item_key, $values, $order) {
//     // Check if the cart item has booking ID data
//     if (!empty($values['booking_id'])) {
//         // Get the booking ID from the cart item
//         $booking_id = $values['booking_id'];

//         // Save booking ID as order meta
//         $item->add_meta_data('booking_id', $booking_id);
//     }
// }

// Hook into order received page to display booking ID for each item
























// // Hook into WooCommerce's item data to display custom data in the cart
// add_filter('woocommerce_get_item_data', 'custom_data_to_cart_item', 10, 2);
// function custom_data_to_cart_item($cart_data, $cart_item) {
//     // Get the session data
//     $appointment_id = WC()->session->get('appointment_id');
//     $listing_id = WC()->session->get('listing_id');

//     // Add custom data to the cart item
//     if ($appointment_id) {
//         $cart_data[] = array(
//             'name' => __('Appointment ID', 'your-text-domain'),
//             'value' => $appointment_id
//         );
//     }

//     if ($listing_id) {
//         $cart_data[] = array(
//             'name' => __('Listing ID', 'your-text-domain'),
//             'value' => $listing_id
//         );
//     }

//     return $cart_data;
// }














// Display custom cart item meta data (in cart and checkout)
// add_filter( 'woocommerce_get_item_data', 'display_cart_item_custom_meta_data', 10, 2 );
function display_cart_item_custom_meta_data($item_data, $cart_item) 
{

    print_r($item_data);
    if ( isset($cart_item['data_id']) && isset($cart_item['data_id']) ) {
        $item_data[] = array(
            'key'       => 'data_id',
            'value'     => $cart_item['data_id'],
        );
    }



    return $item_data;
}

//change title hook
// add_filter('woocommerce_product_title', 'custom_product_title', 10, 2);
// function custom_product_title($title, $product) {

//     if ($product->get_name() === 'Service booking') {
        
//         $new_title = 'Car Services';
//         return $new_title;
//     }

















// Save cart item custom meta as order item meta data and display it everywhere on orders and email notifications.
add_action( 'woocommerce_checkout_create_order_line_item', 'save_cart_item_custom_meta_as_order_item_meta', 10, 4 );
function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
    if ( isset($values['data_id']) && isset($values['data_id']) ) {
        $item->update_meta_data( 'data_id', $values['data_id']);
    }
}

//For Auto Approval order

add_action( 'woocommerce_thankyou', 'create_post_on_order_complete' );
if(!function_exists( 'create_post_on_order_complete') ){
    function create_post_on_order_complete($order_id ){
        global $wpdb;
        $order = wc_get_order( $order_id );
        if( !$order->get_id() ){
            return;
        }  
       
        $row_id = "";
        foreach ( $order->get_items() as  $item_key => $item_values ) {
            $item_data = $item_values->get_data();
            $formatted_meta_data = $item_values->get_formatted_meta_data( '_', true );
            foreach( $formatted_meta_data as $data ){
                if(isset($data->key )  &&  $data->key == "data_id"){
                    $row_id =  $data->value;             
                }
            }
        }
        global $wpdb;
      
        $mylink = $wpdb->get_row( "SELECT id FROM dwt_listing_events_tickets WHERE id="."'".$row_id."'" );
        $current_user = get_current_user_id();
        // $current_user_id = $current_user->display_name;
        // $post_title = $order_id.' - '.$current_user_id;
    
            global $dwt_listing_options;
            $row_data   =  $wpdb->get_row( "SELECT * FROM dwt_listing_events_tickets WHERE id="."'".$row_id."'" ); 

            $event_id = '';
            if(isset($row_data->event_id) && !empty($row_data)){
                $event_id = $row_data->event_id;
            }
            $event_author_id = get_post_field('post_author', $event_id);

            $no_of_tickets = '';
           if(isset($row_data->no_of_tickets) && !empty($row_data)){
                $no_of_tickets = $row_data->no_of_tickets;
            }
            $tickets_price = '';
            if(isset($row_data->tickets_price) && !empty($row_data)){
                $tickets_price = $row_data->tickets_price;
            }
            $extra_service_price = '';
            if(isset($row_data->extra_service_price) && !empty($row_data)){
            $extra_service_price = $row_data->extra_service_price;
            }
            $event_user_name = '';
            if(isset($row_data->event_user_name) && !empty($row_data)){
                $event_user_name = $row_data->event_user_name;
                }
                $event_grand_total = '';
            if(isset($row_data->event_grand_total) && !empty($row_data)){
                $event_grand_total = $row_data->event_grand_total;
            }
            $admin_percentage = '';
            if(isset($row_data->admin_commission) && !empty($row_data)){
                $admin_percentage = $row_data->admin_commission;
            }
            $event_name = '';
            if(isset($row_data->event_name) && !empty($row_data)){
                $event_name = $row_data->event_name;
            }
            $event_date = '';
            if(isset($row_data->event_date) && !empty($row_data)){
                $event_date = $row_data->event_date;
            }
            $event_tickets_status = '';
            if(isset($row_data->event_tickets_status) && !empty($row_data)){
                $event_tickets_status = $row_data->event_tickets_status;
            }
            
        
            $check_order_meta =get_post_meta( $order_id, 'avoid_duplication_of_tickets', true );
            if ( isset($check_order_meta) && $check_order_meta != ''  ) {
                
            }else{
            $tickets_price_ = $tickets_price;
            $extra_service_price_ = $extra_service_price;
            $number_of_Tickets = $no_of_tickets;
            $admin_commissions = $admin_percentage;
            $user_name = $event_user_name;
            $current_user = get_current_user_id();
            $event_name_ = $event_name;
            $event_date_ = $event_date;
            $event_tickets_status_ = $event_tickets_status;
            $grand_total = $event_grand_total;
            
            $my_event_tickets_post = array(
                    'post_title' => $user_name, 
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                    'post_type' => 'tickets',
                );

                $user_id = get_current_user_id( );
            // Insert the post into the database.

                $booking_id = wp_insert_post($my_event_tickets_post);
             
            if(!is_wp_error( $booking_id ))
            {

                update_post_meta($booking_id, 'dwt_event_status', '1');
                update_post_meta($booking_id, 'dwt_event_user_name', $user_name);
                update_post_meta($booking_id, 'dwt_event_no_of_tickets', $number_of_Tickets);
                update_post_meta($booking_id, 'dwt_event_ticket_price', $tickets_price_);
                update_post_meta($booking_id, 'dwt_event_extra_services_price', $extra_service_price_);
                update_post_meta($booking_id, 'dwt_listing_event_grand_total_price', $grand_total);
                update_post_meta($booking_id, 'dwt_listing_event_id', $event_id);
                update_post_meta($booking_id, 'dwt_listing_author', $event_author_id);
                update_post_meta($booking_id, 'dwt_listing_event_name', $event_name_);
                update_post_meta($booking_id, 'dwt_listing_event_date', $event_date_);
                update_post_meta($booking_id, 'dwt_listing_admin_commission', $admin_percentage);   
                update_post_meta( $order_id, 'ticket_id', $booking_id );
                update_post_meta( $booking_id, 'order_id', $order_id );
                
                $previous_grand_total = get_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', true);
           
               if(isset ($dwt_listing_options['dwt_listing_event_admin_disable_commission']) && $dwt_listing_options['dwt_listing_event_admin_disable_commission'] == 1){

                    $event_commission_from =  isset($dwt_listing_options['event_commission_from']) ?  $dwt_listing_options['event_commission_from'] : "";    
                    
                    //deduct commission from user
                    if($event_commission_from == "1"){
                        $services_charges =  $dwt_listing_options['service_charges']; 
                        $percentage = $services_charges/100;
                    
                        $commission_amount = $event_grand_total * $percentage ;
                        $new_price_after_commission = (float)$event_grand_total - (float)$commission_amount;
                        if($previous_grand_total != ''){
                            $grand_price = ((float)$previous_grand_total + (float)$new_price_after_commission);    
                            update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $grand_price);            
                            }
                            else{
                                update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $new_price_after_commission);
                            }
                    }

                    // deduct commission from Author
                    if($event_commission_from == "2"){

                        $services_charges_aurhor =  $dwt_listing_options['service_charges']; 
                        $percentage = $services_charges_aurhor/100;

                        if($previous_grand_total != ''){
                            $grand_price = (((float)$previous_grand_total) + ((float)$event_grand_total));    
                            update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $grand_price);            
                            }
                            else{
                                update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $grand_total);
                            }
                    }
                }else{
                    if($previous_grand_total != ''){
                        $grand_price = (((float)$previous_grand_total) + ((float)$event_grand_total));    
                        update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $grand_price);            
                        }
                        else{
                            update_user_meta($event_author_id, 'dwt_listing_user_wallet_amount', $grand_total);
                        }
                }
            }
            else {
                $returns = array('message' => esc_html__('0|'.'You are not Logged In', 'dwt-listing'));
                wp_send_json_error($returns);
            }
                    update_post_meta( $order_id, 'avoid_duplication_of_tickets', $booking_id );
        }
    }
}


function wporg_add_custom_box() {
    $screens = [ 'post', 'payouts' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 // Unique ID
            'Status For Payouts',      // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {
   
        $get_amount  = get_post_meta($post->ID, "dwt_listing_payout_amount", true);
        $user_name  = get_post_meta($post->ID, "dwt_listing_payout_name", true);
    ?>
    <p> <?php //echo  esc_html__('Payout Amount:', 'dwt-listing');?>  <b><?php echo esc_attr($get_amount) ?></b></p>
     <p><?php echo  esc_html__('User:', 'dwt-listing');?>  <b><?php echo esc_attr($user_name) ?></b></p>
         <?php   
           $current_status = get_post_meta( $post->ID , 'payout_status', true );    
       
       if($current_status == '1'){
         echo  '<input type="checkbox" class="update_payout_status" checked disabled><span> '.esc_html__("processed","dwt-listing").'</span>';    
       }
       else {
        echo  '<input type="checkbox" name ="payout_status" class="update_payout_status"><span> '.esc_html__('', 'dwt-listing').'</span>';    
       }
       ?>
    <label for="tickets_payouts_status"><?php echo esc_html__('Check this and update to process payout. ', 'dwt-listing');?></label>

        <?php
}

function wporg_save_postdata( $post_id ) {
    global $post; 
    if (isset($post-> post_type) && $post-> post_type != 'payouts'){
        return;
    }
    $status  =  isset($_POST['payout_status'])  ?  $_POST['payout_status'] : "";
    if(isset($status) && $status == 'on')
         {  
             update_post_meta($post_id, 'payout_status', '1');
             invio_payout_approved_mail($post_id);
         }    
}
add_action( 'save_post', 'wporg_save_postdata' );


add_action('wp_ajax_check_my_key', 'check_my_key_callback');
add_action('wp_ajax_nopriv_check_my_key', 'check_my_key_callback');

if(!function_exists('check_my_key_callback')){
    function check_my_key_callback() {
        $userIP = $_SERVER['REMOTE_ADDR'];
        $api_url = '';
        if($userIP == '::1'){
            $api_url = 'http://ip-api.com/json/';
        }
        else{
            $api_url = 'http://ip-api.com/json/' . $userIP;
        }
        $response = wp_remote_get($api_url);

        // Check if the request was successful
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            wp_send_json_error(array('message' => $error_message));
        }

        // Convert the JSON response to an array
        $data = json_decode(wp_remote_retrieve_body($response), true);

        if ($data['country'] === null) {
            wp_send_json_error(array('message' => 'Country information is null.'));
        }
        // Prepare the response
        $response_data = array(
            'country' => $data['country'],
            'city' => $data['city'],
            'latitude' => $data['lat'],
            'longitude' => $data['lon']
            // Add other data fields as needed
        );

        // Send the response
        wp_send_json_success($response_data);
    }
}

function get_tickets_booked($log_id)
{
    global $wpdb;
    $result = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT no_of_tickets FROM dwt_listing_events_tickets WHERE id = %d",
            $log_id
        )
    );
    return $result ? intval($result) : 0;
}

function deduct_tickets_from_stock($event_id, $number_of_tickets)
{
    global $wpdb;

    $available_tickets = get_available_tickets($event_id);

    $new_available_tickets = max(0, $available_tickets - $number_of_tickets);

    $wpdb->update(
        'dwt_listing_events_tickets',
        array('total_number_of_tickets' => $new_available_tickets),
        array('event_id' => $event_id),
        array('%d'), 
        array('%d')  
    );

    $event = get_post_meta($event_id, 'event_tickets_boking', true);
    $event[0]['no_of_tickets'] = $new_available_tickets;
    update_post_meta($event_id, 'event_tickets_boking', $event);
}


function get_available_tickets($event_id)
{
    global $wpdb;
    $result = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT total_number_of_tickets FROM dwt_listing_events_tickets WHERE event_id = %d",
            $event_id
        )
    );
    return $result ? intval($result) : 0;
}

function get_event_id_from_log_id($log_id)
{
    global $wpdb;
    $event_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT event_id FROM dwt_listing_events_tickets WHERE id = %d",
            $log_id
        )
    );
    return $event_id ? intval($event_id) : 0;
}

add_action('woocommerce_order_status_completed', 'dwt_listing_update_tickets_on_order_completion', 10, 1);

if (!function_exists('dwt_listing_update_tickets_on_order_completion')) {
    function dwt_listing_update_tickets_on_order_completion($order_id) {
        $order = wc_get_order($order_id);

        if (!$order) {
            return;
        }

        $items = $order->get_items();

        foreach ($items as $item) {
            $custom_data = $item->get_meta('data_id', true);

            if ($custom_data) {
                $log_id = intval($custom_data);

                $number_of_tickets = get_tickets_booked($log_id);

                if ($number_of_tickets > 0) {
                    $event_id = get_event_id_from_log_id($log_id);

                    if ($event_id) {
                        deduct_tickets_from_stock($event_id, $number_of_tickets);
                    }
                }
            }
        }
    }
}

add_action('wp_footer', 'dwt_footer_function');

if (!function_exists('dwt_footer_function')) {

    function dwt_footer_function()
    {

        if (in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins')))) { ?>
                    <div id="zoom_meeting_container"></div>
                    <?php

        }

    }
}