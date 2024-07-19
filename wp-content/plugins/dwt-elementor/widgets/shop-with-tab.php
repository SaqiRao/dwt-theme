<?php
/**
 * shop with tabs
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Shop_With_Tab extends Widget_Base
{
    public function get_name()
    {
        return 'shop-with-tabs';
    }

    public function get_title()
    {
        return __('Shop With Tabs', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
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
            'shop_with_tabs_basic',
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
                'label_block' => true,
                'rows' => 5,
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
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'shop_grid_product_settings',
            [
                'label' => __('Product Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
            'shop_cat_select',
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
                        'shop_cat_select' => '',
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
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : 'desc';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] :'';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['shop_cat_repeater'] = $settings['shop_cat_repeater'];
        echo dwt_elementor_shop_with_tabs($params);
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