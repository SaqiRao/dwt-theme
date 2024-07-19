<?php
global $dwt_listing_options;
/*
  Theme Settings.
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on Leisure Sols, use a find and replace
 * to change ''rane to the name of your theme in all the template files.
 */
load_theme_textdomain('dwt-listing', trailingslashit(get_template_directory()) . 'languages/');
// Content width
if (!isset($content_width)) {
    $content_width = 600;
}

if(isset($dwt_listing_options['dwt_block_widget']) &&  !$dwt_listing_options['dwt_block_widget']){
  remove_theme_support( 'widgets-block-editor');
}
//WooCommrce
add_theme_support('woocommerce');
//product suport
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');
// Add default posts and comments RSS feed links to head.
add_theme_support('automatic-feed-links');
add_theme_support('custom-header');
/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support('title-tag');
// Theme editor style
add_editor_style('editor.css');
/*
 * Enable support for Post Thumbnails on posts and pages.
 *
 * @link https://developer.wordpress.org/themes/functionality/featured-SB_TAMEER_IMAGES-post-thumbnails/
 */

paginate_comments_links();
the_post_thumbnail();

add_theme_support('post-thumbnails', array('post', 'listing', 'events'));
add_image_size('dwt_listing_blogpost-thumb', 360, 238, true);
add_image_size('dwt_listing_locations-thumb', 360, 400, true);
add_image_size('dwt_listing_listing-grids', 395, 275, true);
add_image_size('dwt_listing_blogsingle-post', 750, 400, true);
add_image_size('dwt_listing_recent-posts', 100, 66, true);
add_image_size('dwt_listing_listing_thumb', 100, 45, true);
add_image_size('dwt_listing_list-view1', 282, 264, true);
add_image_size('dwt_listing_user-dp', 100, 100, true);
add_image_size('dwt_listing_mylistings', 236, 220, true);
add_image_size('dwt_listing_slider-img', 750, 450, true);
add_image_size('dwt_listing_single-event', 880, 450, true);
add_image_size('dwt_listing_slider-thumb', 90, 54, true);
add_image_size('dwt_listing_woo-thumb', 265, 280, true);
add_image_size('dwt_listing_woo-single-thumb', 600, 600, true);
add_image_size('dwt_listing_elegent', 550, 410, true);
add_image_size('dwt_listing_small_thumb', 32, 32, true);
add_image_size('dwt_listing_related_imgz', 212, 120, true);
add_image_size('dwt_listing_image_icon', 64, 64, true);
add_image_size('dwt_listing_about_image', 260, 260, true);
add_image_size('dwt_listing_about_image_for_comparison', 355, 230, true);



// This theme uses wp_nav_menu() in one location.
register_nav_menus(array(
    'main_menu' => esc_html__('DWT Listing Main Menu', 'dwt-listing'),
));
/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));
add_theme_support('customize-selective-refresh-widgets');
/*
 * Enable support for Post Formats.
 * See https://developer.wordpress.org/themes/functionality/post-formats/
 */
// Set up the WordPress core custom background feature.
the_tags();
add_theme_support('custom-background', apply_filters('dwt_listing_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
)));
// Register side bar for widgets
add_action('widgets_init', 'dwt_listing_widgets_init');
if (!function_exists('dwt_listing_widgets_init')) {

    function dwt_listing_widgets_init()
    {
        //Blog Sidebar		
        register_sidebar(array(
            'name' => esc_html__('Blog Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_blog-sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));

        register_sidebar(array(
            'name' => esc_html__('Listing Search', 'dwt-listing'),
            'id' => 'dwt_listing_search_sidebar',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Home Page Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_home_sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));


        register_sidebar(array(
            'name' => esc_html__('Listing Detial Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_listing_detial_sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));


        register_sidebar(array(
            'name' => esc_html__('DWT Listing Shop Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_shop-sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));

        register_sidebar(array(
            'name' => esc_html__('Events Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_events-sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));
        
        register_sidebar(array(
            'name' => esc_html__('Events Speakers Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_events_speakers-sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));

        //Blog Sidebar		
        register_sidebar(array(
            'name' => esc_html__('Author Page Sidebar', 'dwt-listing'),
            'id' => 'dwt_listing_author-sidebar',
            'before_widget' => '<div class="widget"><div id="%1$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
            'after_title' => '</a></h4></div>'
        ));
    }

}