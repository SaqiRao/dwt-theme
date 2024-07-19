<?php
namespace ElementorDwt;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /* call constructor */

    public function __construct() {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        /* include custom functions */
        require_once(__DIR__ . '/elementor-fucntions.php');
        /* include render html file */
        require_once(__DIR__ . '/shortcodes-html.php');
    }

    /**
     * Include Widgets files
     *
     */
    private function include_widgets_files() {
        require_once(__DIR__ . '/widgets/about-us.php');
        require_once(__DIR__ . '/widgets/about-us-two.php');
        require_once(__DIR__ . '/widgets/all-listings.php');
        require_once(__DIR__ . '/widgets/blogs.php');
        require_once(__DIR__ . '/widgets/call-to-action-one.php');
        require_once(__DIR__ . '/widgets/call_to_action_two.php');
        require_once(__DIR__ . '/widgets/call_to_action_modern.php');
        require_once(__DIR__ . '/widgets/call_to_action_elegent.php');
        require_once(__DIR__ . '/widgets/categories.php');
        require_once(__DIR__ . '/widgets/categories-elegant.php');
        require_once(__DIR__ . '/widgets/event-categories.php');
        require_once(__DIR__ . '/widgets/category-minimal.php');
        require_once(__DIR__ . '/widgets/clients.php');
        require_once(__DIR__ . '/widgets/contact-us.php');
        require_once(__DIR__ . '/widgets/custom-locations.php');
        require_once(__DIR__ . '/widgets/custom-location-fancy.php');
        require_once( __DIR__ . '/widgets/all-events.php' );
        require_once( __DIR__ . '/widgets/event-slider.php' );
        require_once(__DIR__ . '/widgets/shop-categories.php');
        require_once(__DIR__ . '/widgets/faqs.php');
        require_once(__DIR__ . '/widgets/fun-facts-new.php');
        require_once( __DIR__ . '/widgets/fun-facts.php' );
        require_once(__DIR__ . '/widgets/listing-gallery.php');
        require_once(__DIR__ . '/widgets/listing-slider.php');
        require_once(__DIR__ . '/widgets/listing-advertisement.php');
        require_once(__DIR__ . '/widgets/listing-with-sidebar.php');
        require_once(__DIR__ . '/widgets/app-sections.php');
        require_once(__DIR__ . '/widgets/newsletter.php');
        require_once(__DIR__ . '/widgets/packages.php');
        require_once(__DIR__ . '/widgets/how-it-work.php');
        require_once(__DIR__ . '/widgets/how-it-work-new.php');
        require_once(__DIR__ . '/widgets/shop-grid-slider.php');
        require_once(__DIR__ . '/widgets/shop-with-tab.php');
        require_once(__DIR__ . '/widgets/slider.php');
        require_once(__DIR__ . '/widgets/testimonials.php');
        require_once(__DIR__ . '/widgets/testimonials_new.php');
        require_once(__DIR__ . '/widgets/text-block.php');
        require_once(__DIR__ . '/widgets/hero_one.php');
        require_once(__DIR__ . '/widgets/hero_two.php');
        require_once(__DIR__ . '/widgets/hero_three.php');
        require_once(__DIR__ . '/widgets/hero_four.php');
        require_once(__DIR__ . '/widgets/hero_five.php');
        require_once(__DIR__ . '/widgets/hero_six.php');
        require_once(__DIR__ . '/widgets/hero_seven.php');
        require_once(__DIR__ . '/widgets/hero_eight.php');
        require_once(__DIR__ . '/widgets/hero_nine.php');
        require_once(__DIR__ . '/widgets/hero_ten.php');
    }

    //Ad Shortcode Category
    public function add_elementor_widget_categories($category_manager) {
        $category_manager->add_category(
                'dwttheme',
                [
                    'title' => __('DWT Listing Widgets', 'dwt-elementor'),
                    'icon' => 'fa fa-home',
                ]
        );
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();

        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\About_Us());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\About_Us_Two());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\All_Listings());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Blogs());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Call_To_Action_One());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Call_To_Action_Two());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Call_To_Action_Modern());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Call_To_Action_Elegent());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Categories());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Categories_Elegent());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Event_Categories());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Category_Minimal());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Clients());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Contact_Us());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Custom_locations());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Custom_Location_Fancy());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\All_Events());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Event_slider());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Shop_Categories());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Faqs());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Fun_Facts_New());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Fun_Facts());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Listing_Gallery());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Listing_Slider());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Listing_Advertisement());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Listing_With_Sidebar());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\App_Sections());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\News_Letter());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Packages());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\How_It_Work());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\How_It_Work_New());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Shop_Grid_Slider());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Shop_With_Tab());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Slider());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Testimonials());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Testimonials_New());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Text_Block());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_One());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Two());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Three());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Four());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Five());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Six());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Seven());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Eight());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Nine());
        \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Hero_Ten());
    }

}

Plugin::instance();