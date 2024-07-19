<?php
/**
 * Hero Seven
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Seven extends Widget_Base
{
    public function get_name()
    {
        return 'hero-seven';
    }

    public function get_title()
    {
        return __('Hero Seven (YouTube)', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-image';
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
            'hero_seven_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'section_title',
            [
                'label' => __('Heading One', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put heading here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'form_text',
            [
                'label' => __('Heading Two', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put heading here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_tag_line',
            [
                'label' => __('Hero Section Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 5,
            ]
        );
        $this->add_control(
            'section_video',
            [
                'label' => __('BG Video', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                "description" => __("Youtube video url.", 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'btn_title',
            [
                'label' => __('Button Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('Button Link', 'dwt-elementor'),
                'label_block' => true
            ]
        );
        $this->add_control(
            'btn_link',
            [
                'label' => __('Button Link', 'dwt-elementor'),
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
    }


    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['form_text'] = $settings['form_text'] ? $settings['form_text'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['section_video'] = $settings['section_video'] ? $settings['section_video'] : '';
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] :'';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';


        echo dwt_elementor_hero_seven($params);
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