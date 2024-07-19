<?php
/**
 * Custom location fancy
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Custom_Location_Fancy extends Widget_Base
{
    public function get_name()
    {
        return 'fancy-locations';
    }

    public function get_title()
    {
        return __('Fancy Location', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-google-maps';
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
            'fancy_location_basic',
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
        $this->end_controls_section();
        /* location tab */
        $this->start_controls_section(
            'fancy_locations',
            [
                'label' => __('Locations', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'location_select',
            [
                'label' => __('Select Location', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('l_location'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'location_description',
            [
                'label' => __('Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put Description here', 'dwt-elementor'),
                'rows' => 3,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'loc_img',
            [
                'label' => __('Location Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => '',
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'location_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'location_select' => '',
                        'location_description' => '',
                        'loc_img' => '',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['location_repeater'] = $settings['location_repeater'] ? $settings['location_repeater'] : array();

        echo dwt_elementor_custom_location_fancy($params);
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