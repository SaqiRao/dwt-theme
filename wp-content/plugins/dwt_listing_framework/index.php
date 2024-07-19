<?php
/**
 * Plugin Name: DWT Listing Framework
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: This plugin is essential for the proper theme funcationality.
 * Version: 2.3.0
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: dwt-listing-framework
 */
/* Load text domain */

// print_r(plugin_dir_url(__FILE__));
// die;
add_action('plugins_loaded', 'dwt_listing_framework_load_plugin_textdomain');

function dwt_listing_framework_load_plugin_textdomain()
{
    load_plugin_textdomain('dwt-listing-framework', FALSE, basename(dirname(__FILE__)) . '/languages/');
}

define('SB_PLUGIN_FRAMEWORK_PATH', plugin_dir_path(__FILE__));
define('SB_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SB_THEMEURL_PLUGIN', get_template_directory_uri() . '/');
define('SB_IMAGES_PLUGIN', SB_THEMEURL_PLUGIN . 'images/');
define('SB_CSS_PLUGIN', SB_THEMEURL_PLUGIN . 'css/');
/* For Add to Cart */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require SB_PLUGIN_PATH . 'js/woo_variable_product.php';
}
require SB_PLUGIN_PATH . 'functions.php';
require SB_PLUGIN_PATH . 'cpt/post_types.php';
require SB_PLUGIN_PATH . 'cpt/listing.php';
require SB_PLUGIN_PATH . 'cpt/events-tickets.php';
require SB_PLUGIN_PATH . 'cpt/payouts.php';
require SB_PLUGIN_PATH . 'cpt/events.php';
require SB_PLUGIN_PATH . 'cpt/event-speakers.php';
require SB_PLUGIN_PATH . 'cpt/users.php';
require SB_PLUGIN_PATH . 'metaboxes/google_map.php';
require SB_PLUGIN_PATH . 'metaboxes/claim.php';
require SB_PLUGIN_PATH . 'metaboxes/listings.php';
require SB_PLUGIN_PATH . 'metaboxes/form_fields.php';
require SB_PLUGIN_PATH . 'metaboxes/categories.php';
require SB_PLUGIN_PATH . 'metaboxes/packages.php';
require SB_PLUGIN_PATH . 'metaboxes/locations.php';
require SB_PLUGIN_PATH . 'metaboxes/events.php';
require SB_PLUGIN_PATH . 'metaboxes/speakers.php';


/*DATABASE TABLES*/
require_once ( SB_PLUGIN_PATH.'/inc/dwt-db.php' );
register_activation_hook(__FILE__, array('fl_db_tables','fl_create_db_tables'));

if (class_exists('Redux')) {
    require SB_PLUGIN_PATH . 'redux-extensions/extensions-init.php';
}

add_action('admin_enqueue_scripts', 'dwt_listing_framework_scripts');

function dwt_listing_framework_scripts()
{
    /* Enqueue scripts in wp admin */
    wp_enqueue_style("admin-dwt-listing-icons", plugin_dir_url(__FILE__) . "css/all-icons.css");
    wp_enqueue_style("admin-typehead", plugin_dir_url(__FILE__) . "css/jquery.typeahead.min.css");
    wp_enqueue_style('dwt_listing_admin_css', plugin_dir_url(__FILE__) . 'css/admin.css');
    wp_enqueue_style('dwt_admin_select2', plugin_dir_url(__FILE__) . 'css/select2.min.css');
    wp_enqueue_style("admin-leaflet", plugin_dir_url(__FILE__) . "css/map/leaflet.css");
    wp_enqueue_style("admin-datepicker", plugin_dir_url(__FILE__) . "css/datepicker.min.css");
    wp_enqueue_style("admin-leaflet-search", plugin_dir_url(__FILE__) . "css/map/leaflet-search.min.css");
    wp_enqueue_style("dwt-listing-admin-skin", plugin_dir_url(__FILE__) . "css/flat.css");
    wp_enqueue_script('dwt_listing_admin_select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', false, false, true);
    wp_enqueue_script('admin-leaflet', plugin_dir_url(__FILE__) . 'js/map/leaflet.js', false, false, true);
    wp_enqueue_script('admin-leaflet-search', plugin_dir_url(__FILE__) . 'js/map/leaflet-search.min.js', false, false, true);
    if ('product' != get_post_type()) {
        wp_enqueue_script('admin-datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.min.js', false, false, true);
    }
    wp_enqueue_script('admin-datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.min.js');
    wp_enqueue_script('admin-icheck', plugin_dir_url(__FILE__) . 'js/icheck.min.js', false, false, true);
    wp_enqueue_script('admin-tabz', plugin_dir_url(__FILE__) . 'js/tabz.js', false, false, true);
    wp_enqueue_script("dwt-timepicker-en", plugin_dir_url(__FILE__) . "js/date-en-US.js");
    wp_enqueue_script("dwt-timepicker", plugin_dir_url(__FILE__) . "js/jquery.ui.timeselect.js");
    wp_enqueue_script("dwt-listing-admin-typehead", plugin_dir_url(__FILE__) . "js/typeahead.min.js");
    wp_enqueue_script('dwt_listing_custom_admin_js', plugin_dir_url(__FILE__) . 'js/custom_admin.js', false, false, true);
}

add_action('wp_enqueue_scripts', 'dwt_listing_framework_theme_scripts');

function dwt_listing_framework_theme_scripts()
{
    /* Enqueue scripts in wp site */
}

if (class_exists('Redux')) {
    if (get_option('dwt_listing_options') == "") {
        $sb_option_name = 'dwt_listing_options';
        // Header Options
        Redux::setOption($sb_option_name, 'dwt_listing_header-layout', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_site-spinner', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_spinner-text', 'Please Wait');
        Redux::setOption($sb_option_name, 'dwt_listing_spinner-logo', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/loader.gif'));
        Redux::setOption($sb_option_name, 'dwt_listing_logo', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/logo-white.png'));
        Redux::setOption($sb_option_name, 'dwt_listing_logo-transparent', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/logo-white.png'));
        Redux::setOption($sb_option_name, 'dwt_listing_sticky-header', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_header-btn', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_header-bg', array('background-image' => trailingslashit(get_template_directory_uri()) . 'assets/images/collage.jpg', 'background-repeat' => 'no-repeat', 'background-size' => 'cover', 'background-position' => 'center center', 'background-attachment' => 'fixed'));
        Redux::setOption($sb_option_name, 'dwt_listing_header-text', 'Add Listing');
        //Users
        Redux::setOption($sb_option_name, 'dwt_listing_profile-dashboard', '2');
        Redux::setOption($sb_option_name, 'dwt_listing_profile-page', array('1917'));
        Redux::setOption($sb_option_name, 'dwt_listing_profile_edit', array('1920'));
        Redux::setOption($sb_option_name, 'dwt_listing_user-default-image', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/users/defualt.jpg'));
        //Typography
        Redux::setOption($sb_option_name, 'typography-body', array('color' => '#444', 'font-size' => '14px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '26px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_nav-typo', array('color' => '#555', 'font-size' => '14px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '50px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_h2_typo', array('color' => '#444', 'font-size' => '30px', 'font-family' => 'Poppins', 'font-weight' => '500', 'line-height' => '35px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_h3_typo', array('color' => '#444', 'font-size' => '20px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_h4_typo', array('color' => '#444', 'font-size' => '18px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '18px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_h5_typo', array('color' => '#444', 'font-size' => '16px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '22px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_h6_typo', array('color' => '#444', 'font-size' => '14px', 'font-family' => 'Poppins', 'font-weight' => '400', 'line-height' => '18px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_p_typo', array('color' => '#999', 'font-size' => '16px', 'font-family' => 'Open Sans', 'font-weight' => '', 'line-height' => '30px', 'google' => true));

        Redux::setOption($sb_option_name, 'dwt_primary_clr', '#e52d27');

        Redux::setOption($sb_option_name, 'dwt_btnz_plate', array('regular' => '#242424', 'hover' => '#e52d27', 'active' => '#ea5652'));

        Redux::setOption($sb_option_name, 'dwt_naviagtion_solid_color', array('color' => '#fff', 'alpha' => '1'));

        Redux::setOption($sb_option_name, 'dwt_listing_enable_geo', '1');
        Redux::setOption($sb_option_name, 'dwt_geo_api_settings', 'ip_api');
        //Profile Settings
        Redux::setOption($sb_option_name, 'dwt_listing_show_pkg', '1');

        //Submit Listing
        Redux::setOption($sb_option_name, 'wo_pack_approve', '2');
        Redux::setOption($sb_option_name, 'dwt_listing_allow_loc', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_gmap_lang', 'en');
        Redux::setOption($sb_option_name, 'dwt_listing_show_street_view', '1');
        //Blog
        Redux::setOption($sb_option_name, 'dwt_listing_blog-post-title', 'Latest News & Trends');
        Redux::setOption($sb_option_name, 'dwt_listing_single-title', 'Detailed Analysis');
        Redux::setOption($sb_option_name, 'dwt_listing_share-blogpost', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_blog-layout', array('content' => 'Content Area ', 'sidebar' => 'Sidebar'));
        Redux::setOption($sb_option_name, 'dwt_listing_blog-singlelayout', array('singlepost' => 'Post Detail', 'singlesidebar' => 'Sidebar'));


        //Reviews
        Redux::setOption($sb_option_name, 'dwt_listing_review_send_email', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_review_rating_limit', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_review_permission', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_review_enable_stars', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_review_enable_gallery', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_review_enable_emoji', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_review_upload_limit', '5');
        Redux::setOption($sb_option_name, 'dwt_listing_review_images_size', '0');
        Redux::setOption($sb_option_name, 'dwt_listing_review_send_email', '2097152-2MB');
        Redux::setOption($sb_option_name, 'review_limit_listing_page', '5');
        Redux::setOption($sb_option_name, 'dwt_listing_review_limit_btn_text', 'View All Reviews');
        Redux::setOption($sb_option_name, 'dwt_listing_review_all_pagination_limit', '8');
        Redux::setOption($sb_option_name, 'dwt_listing_review_taglines_limit', '8');
        Redux::setOption($sb_option_name, 'dwt_listing_review_all_pagination_limit', '20|40|60|80');
        Redux::setOption($sb_option_name, 'dwt_listing_review_taglines_titles', 'Rookie|Amateur|Elite|Professional');
        Redux::setOption($sb_option_name, 'dwt_listing_enable_names', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_show_total_ratings', '1');
        //Listing General Settings
        Redux::setOption($sb_option_name, 'wo_pack_approve', '2');
        Redux::setOption($sb_option_name, 'dwt_listing_allow_loc', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_gmap_lang', 'en');
        Redux::setOption($sb_option_name, 'dwt_listing_ad_approval', 'auto');
        Redux::setOption($sb_option_name, 'dwt_listing_up_approval', 'auto');
        Redux::setOption($sb_option_name, 'dwt_listing_email_on_listing', '1');
        Redux::setOption($sb_option_name, 'email_on_ad_approval', '1');
        Redux::setOption($sb_option_name, 'report_options', 'Spam|Offensive|Duplicated|Fake');
        Redux::setOption($sb_option_name, 'report_limit', '50');
        Redux::setOption($sb_option_name, 'report_action', '2');
        Redux::setOption($sb_option_name, 'dwt_listing_is_claim', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_is_admin_email', '1');

        //Listing Post Settings
        Redux::setOption($sb_option_name, 'dwt_listing_title_limit', '45');
        Redux::setOption($sb_option_name, 'dwt_listing_image_up_size', '2097152-2MB');
        Redux::setOption($sb_option_name, 'dwt_listing_allow_lat_lon', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_default_lat', '40.7127837');
        Redux::setOption($sb_option_name, 'dwt_listing_default_long', '-74.00594130000002');
        Redux::setOption($sb_option_name, 'dwt_listing_allow_country_location', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_bad_words_filter', '');
        Redux::setOption($sb_option_name, 'dwt_listing_bad_words_replace', '');
        Redux::setOption($sb_option_name, 'dwt_listing_coupon_admin_note', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_coupon_desc_limit', '170');


        //Search Settings
        Redux::setOption($sb_option_name, 'dwt_listing_seacrh_layout', 'sidebar');
        Redux::setOption($sb_option_name, 'dwt_listing_search_layout_style', 'grid1');
        Redux::setOption($sb_option_name, 'dwt_listing_sidebar_position', 'right');
        Redux::setOption($sb_option_name, 'dwt_listing_enable_video_option', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_video_icon', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/play-button.png'));

        //Listing View Settings
        Redux::setOption($sb_option_name, 'dwt_listing_layout_style', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_sidebar-layout-manager', array('card' => 'Profile Card', 'coupon' => 'Coupon', 'events' => 'Related Event', 'hours' => 'Business Hours', 'claim' => 'Claim', 'pricing' => 'Pricing', 'tags' => 'Tags', 'booking_timekit' => 'Booking Timekit'));
        Redux::setOption($sb_option_name, 'dwt_listing_view-layout-manager', array('slider' => 'Slider', 'ad_slot_1' => 'Ad Slot 1', 'desc' => 'Description', 'listing_features' => 'Features', 'location' => 'Location', 'form_fields' => 'Custom Fields', 'video' => 'Video', 'ad_slot_2' => 'Ad Slot 2', 'reviews' => 'Reviews'));
        Redux::setOption($sb_option_name, 'dwt_listing_slot_1', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/eds/720x120-1.jpg'));
        Redux::setOption($sb_option_name, 'dwt_listing_slot_2', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/eds/720x90-2.png'));
        Redux::setOption($sb_option_name, 'dwt_listing_form-layout-manager', array('title_cat' => 'Title & Category Section', 'price_type' => 'Price Type Section', 'buiness_hours' => 'Business Hours Section', 'social_links' => 'Social Media Section', 'desc_sec' => 'Description & Gallery', 'coupon' => 'Coupon Section', 'location' => 'Location Section'));


        //Slugs Settings
        Redux::setOption($sb_option_name, 'dwt_listing_cat_slug', 'categories');
        Redux::setOption($sb_option_name, 'dwt_listing_tags_slug', 'tags');
        Redux::setOption($sb_option_name, 'dwt_listing_loc_slug', 'location');
        Redux::setOption($sb_option_name, 'dwt_listing_listing_slug', 'listing');
        Redux::setOption($sb_option_name, 'dwt_event_cat_slug', 'event-categories');
        Redux::setOption($sb_option_name, 'dwt_listing_event_slug', 'events');

        //Footer
        Redux::setOption($sb_option_name, 'dwt_listing_footer-layout', '1');
        Redux::setOption($sb_option_name, 'dwt_listing_footer-logo', array('url' => SB_THEMEURL_PLUGIN . 'assets/images/logo-white.png'));
        Redux::setOption($sb_option_name, 'dwt_listing_footer-copyrights', 'Copyright 2017 &copy; Theme Created By ScriptsBundle, All Rights Reserved.');
        Redux::setOption($sb_option_name, 'dwt_listing_footer-bg1', array('background-image' => trailingslashit(get_template_directory_uri()) . 'assets/images/footer.jpg', 'background-repeat' => 'no-repeat', 'background-size' => 'cover', 'background-position' => 'left top', 'background-attachment' => 'fixed'));
        Redux::setOption($sb_option_name, 'dwt_listing_footer-social-media', array('Facebook' => '', 'Twitter' => '', 'Linkedin' => '', 'Google' => '', 'YouTube' => ''));
        Redux::setOption($sb_option_name, 'dwt_listing_footer-text', 'Cu qui probo malorum saperet. Ne admodum apeirian iracundia usu, eam cu agam ludus, eum munere accusam molestie ut. Alienum percipitur ne est, pri quando iriure ad. Alienum percipitur ne est, pri quando iriure ad. Alienum percipitur ne est, pri quando iriure ad.');
        Redux::setOption($sb_option_name, 'dwt_listing_layout-sorter', array('logo' => 'Logo & Desc ', 'quciklinks' => 'Quick Links'));
        Redux::setOption($sb_option_name, 'dwt_listing_footer-links-text', 'Quick Links');
        Redux::setOption($sb_option_name, 'dwt_listing_footer-posts-text', 'Recent Posts');
        Redux::setOption($sb_option_name, 'dwt_listing_footer-posts-text', 'Contact Information');
        Redux::setOption($sb_option_name, 'dwt_listing_footer-address', array('address' => ' B-Floor,Arcade Model Town, USA', 'email' => 'contact@scriptsbundle.com', 'phone' => '(0092)+ 124 45 78 678 ', 'clock' => ' Mon - Sun: 8:00 - 16:00'));
        Redux::setOption($sb_option_name, 'dwt_listing_layout-sorter-3', array('logo' => 'Your Detials ', 'quciklinks' => 'Quick Links', 'post' => 'Blog Post', 'info' => 'Contact Info'));
    }
}

if (!function_exists('dwt_listing_admin_js_valz')) {

    function dwt_listing_admin_js_valz($hook)
    {

        wp_localize_script(
            'dwt_listing_custom_admin_js', // name of js file
            'admin_varible', array(
                'p_path' => plugin_dir_url(__FILE__),
                'timepicker' => __('Timepicker', 'dwt-listing-framework'),
                'Sunday' => __('Sunday', 'dwt-listing-framework'),
                'Monday' => __('Monday', 'dwt-listing-framework'),
                'Tuesday' => __('Tuesday', 'dwt-listing-framework'),
                'Wednesday' => __('Wednesday', 'dwt-listing-framework'),
                'Thursday' => __('Thursday', 'dwt-listing-framework'),
                'Friday' => __('Friday', 'dwt-listing-framework'),
                'Saturday' => __('Saturday', 'dwt-listing-framework'),
                'Sun' => __('Sun', 'dwt-listing-framework'),
                'Mon' => __('Mon', 'dwt-listing-framework'),
                'Tue' => __('Tue', 'dwt-listing-framework'),
                'Wed' => __('Wed', 'dwt-listing-framework'),
                'Thu' => __('Thu', 'dwt-listing-framework'),
                'Fri' => __('Fri', 'dwt-listing-framework'),
                'Sat' => __('Sat', 'dwt-listing-framework'),
                'Su' => __('Su', 'dwt-listing-framework'),
                'Mo' => __('Mo', 'dwt-listing-framework'),
                'Tu' => __('Tu', 'dwt-listing-framework'),
                'We' => __('We', 'dwt-listing-framework'),
                'Th' => __('Th', 'dwt-listing-framework'),
                'Fr' => __('Fr', 'dwt-listing-framework'),
                'Sa' => __('Sa', 'dwt-listing-framework'),
                'January' => __('January', 'dwt-listing-framework'),
                'February' => __('February', 'dwt-listing-framework'),
                'March' => __('March', 'dwt-listing-framework'),
                'April' => __('April', 'dwt-listing-framework'),
                'May' => __('May', 'dwt-listing-framework'),
                'June' => __('June', 'dwt-listing-framework'),
                'July' => __('July', 'dwt-listing-framework'),
                'August' => __('August', 'dwt-listing-framework'),
                'September' => __('September', 'dwt-listing-framework'),
                'October' => __('October', 'dwt-listing-framework'),
                'November' => __('November', 'dwt-listing-framework'),
                'December' => __('December', 'dwt-listing-framework'),
                'Jan' => __('Jan', 'dwt-listing-framework'),
                'Feb' => __('Feb', 'dwt-listing-framework'),
                'Mar' => __('Mar', 'dwt-listing-framework'),
                'Apr' => __('Apr', 'dwt-listing-framework'),
                'May' => __('May', 'dwt-listing-framework'),
                'Jun' => __('Jun', 'dwt-listing-framework'),
                'Jul' => __('July', 'dwt-listing-framework'),
                'Aug' => __('Aug', 'dwt-listing-framework'),
                'Sep' => __('Sep', 'dwt-listing-framework'),
                'Oct' => __('Oct', 'dwt-listing-framework'),
                'Nov' => __('Nov', 'dwt-listing-framework'),
                'Dec' => __('Dec', 'dwt-listing-framework'),
                'Today' => __('Today', 'dwt-listing-framework'),
                'Clear' => __('Clear', 'dwt-listing-framework'),
                'dateFormat' => __('dateFormat', 'dwt-listing-framework'),
                'img_del' => __('Are you sure you want to remove this image?', 'dwt-listing-framework'),
                'select_imgz' => __('Select Images', 'dwt-listing-framework'),
            )
        );
    }

}
add_action('admin_enqueue_scripts', 'dwt_listing_admin_js_valz');

add_filter('manage_users_columns', 'dwt_listing_modify_user_table');

function dwt_listing_modify_user_table($columns)
{
    $columns['registration_date'] = 'Reg date'; // add new
    $columns['packages'] = 'Package'; // add new
    return $columns;
}

add_filter('manage_users_custom_column', 'dwt_listing_modify_user_table_row', 10, 3);

function dwt_listing_modify_user_table_row($row_output, $column_id_attr, $user)
{
    $date_format = 'j M, Y';
    switch ($column_id_attr) {
        case 'registration_date' :
            return date($date_format, strtotime(get_the_author_meta('registered', $user)));
            break;
        case 'packages' :
            if (get_user_meta($user, 'd_user_package_id', true) != "") {
                $package_id = get_user_meta($user, 'd_user_package_id', true);
                return '<a href="' . get_edit_post_link($package_id) . '">' . get_the_title($package_id) . '</a>';
            }
            break;
        default:
    }
    return $row_output;
}

add_filter('manage_users_sortable_columns', 'dwt_listing_make_registered_column_sortable');

function dwt_listing_make_registered_column_sortable($columns)
{

    $columns['registration_date'] = 'registered';
    $columns['packages'] = 'package';
    return $columns;

    return wp_parse_args(array('registration_date' => 'registered'), $columns);
    return wp_parse_args(array('packages' => 'package-type'), $columns);
}

//Custom column for Location image Meta
function dwt_listing_location_term_meta_column($columns)
{
    $columns['loc_img'] = 'Image';
    //unset($columns['description']);
    return $columns;
}

add_filter("manage_edit-l_location_columns", 'dwt_listing_location_term_meta_column', 10);

function dwt_listing_location_term_meta_column_content($value, $column_name, $tax_id)
{
    if ($column_name === 'loc_img') {
        $image_id = get_term_meta($tax_id, 'location_term_meta_img', true);
        if ($image_id) {
            echo wp_get_attachment_image($image_id, 'thumbnail');
        } else {
            $img = plugin_dir_url(__FILE__) . "css/placeholder.png";
            return '<img src="' . esc_url($img) . '">';
        }
    }
}

add_action("manage_l_location_custom_column", 'dwt_listing_location_term_meta_column_content', 10, 3);
//mone custom colum to first place
add_filter('manage_edit-l_location_columns', 'dwt_listing_location_order', 10, 3);

function dwt_listing_location_order($columns)
{
    $new = array();
    foreach ($columns as $key => $title) {
        if ($key == 'name') // Put the Thumbnail column before the Author column
            $new['loc_img'] = 'Image';
        $new[$key] = $title;
    }
    return $new;
}

/*
 * add location column in listing
 * f.k
 * Add the custom columns to the Listing post type:
 */
add_filter('manage_listing_posts_columns', 'set_custom_edit_listing_columns');

function set_custom_edit_listing_columns($columns)
{
    $columns['listing_location'] = esc_html__('Location', 'dwt-listing-framework');
    return $columns;
}

// Add the data to the custom columns for the listing post type:
add_action('manage_listing_posts_custom_column', 'custom_listing_column', 10, 3);

function custom_listing_column($column, $listing_id)
{
    switch ($column) {
        case 'listing_location' :
            $locations = dwt_listing_listing_custom_location($listing_id);
            if (is_string($locations))
                echo $locations;
            else
                _e('N/A', 'dwt-listing-framework');
            break;
    }
}

/* == wpml == */
add_action('dwt_listing_wpml_terms_filters', 'dwt_listing_wpml_terms_filters_callback');

function dwt_listing_wpml_terms_filters_callback()
{
    global $sitepress;
    remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
    remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
    remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
}