<?php
/**
 * Slider
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Slider extends Widget_Base
{
    public function get_name()
    {
        return 'slider';
    }

    public function get_title()
    {
        return __('Slider', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-slider-3d';
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
            'slider_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'overlay_effect',
            [
                'label' => __('Overlay Effect', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'dwt-elementor'),
                'label_off' => __('No', 'dwt-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* slides tab */
        $this->start_controls_section(
            'slider_slides',
            [
                'label' => __('Slides', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'slide_tagline',
            [
                'label' => __('Slide Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_title',
            [
                'label' => __('Slide Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'slide_desc',
            [
                'label' => __('Slide Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put Description here', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 5,
            ]
        );

        $repeater->add_control(
            'btn_title',
            [
                'label' => __('View', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('Button Link', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
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
        $repeater->add_control(
            'slide_img',
            [
                'label' => __('Slide Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'slider_slides_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_tagline' => '',
                        'slide_title' => '',
                        'btn_title' => '',
                        'btn_link' => '',
                        'slide_img' => '',
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
        $params['overlay_effect'] = $settings['overlay_effect'] ? $settings['overlay_effect'] : 'no';
        $params['slider_slides_repeater'] = $settings['slider_slides_repeater'];

        echo dwt_elementor_slider($params);
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