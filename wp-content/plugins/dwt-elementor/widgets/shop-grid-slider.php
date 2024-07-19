<?php
/**
 * Shop Slider
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Shop_Grid_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'shop-with-grid-slider';
    }

    public function get_title()
    {
        return __('Shop With Grid Slider', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-post-slider';
    }

    public function get_categories()
    {
        return ['dwttheme'];
    }

    public function get_script_depends()
    {
        return [''];
    }
    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */


    protected function _register_controls()
    {
        /* for Basic tab */
        $this->start_controls_section(
            'shop_grid_slider_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put Description here', 'dwt-elementor'),
                'rows' => 5,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for product settings tab */
        $this->start_controls_section(
            'shop_grid_product_settings',
            [
                'label' => __('Product Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'max_limit',
            [
                'label' => __('Number fo Products', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 2000,
                'step' => 1,
                'default' => 8,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'shop_layout_type',
            [
                'label' => __('Product Layout Type', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => [
                    'grid' => __('Grid', 'dwt-elementor'),
                    'slider' => __('Slider', 'dwt-elementor'),
                ],
                'default' => 'slider',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'ad_order',
            [
                'label' => __('Order By', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '' => __('Select Listing order', 'dwt-elementor'),
                    'asc' => __('Oldest', 'dwt-elementor'),
                    'desc' => __('Latest', 'dwt-elementor'),
                    'rand' => __('Random', 'dwt-elementor'),
                ],
                'default' => 'desc',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'btn_title',
            [
                'label' => __('View All', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('Button Link', 'dwt-elementor'),
                'label_block' => true,
                'condition' => [
                    'shop_layout_type' => 'grid'
                ],
            ]
        );
        $this->add_control(
            'btn_link',
            [
                'label' => __('View All Button Link', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'dwt-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => [
                    'shop_layout_type' => 'grid'
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        /* shop category tab */
        $this->start_controls_section(
            'shop_categories',
            [
                'label' => __('Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'shop_cat_selects',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('product_cat'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'shop_cat_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'shop_cat_selects' => '',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        //get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['max_limit'] = $settings['max_limit'] ? $settings['max_limit'] : 8;
        $params['shop_layout_type'] = $settings['shop_layout_type'] ? $settings['shop_layout_type'] : 'slider';
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : 'desc';
        if ($params['shop_layout_type'] == 'grid') {
            $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
            $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
            $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
            $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        }
        $product_cats = $settings['shop_cat_repeater'];

        /*===== create shop categ array =====*/
        $cats = array();
        if (is_array($product_cats) && count($product_cats) > 0) {
            foreach ($product_cats as $product_cat) {
                if (isset($product_cat) && !empty($product_cat['shop_cat_selects'])) {
                    $cats[] = $product_cat['shop_cat_selects'];
                }
            }
        }

        $params['shop_cat_repeater'] = $cats;

        echo dwt_elementor_shop_grid_slider($params);
    }
    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template()
    {
    }
}