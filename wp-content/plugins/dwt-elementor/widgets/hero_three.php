<?php
/**
 * Hero Three
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Three extends Widget_Base
{
    public function get_name()
    {
        return 'hero-three';
    }

    public function get_title()
    {
        return __('Hero Three', 'dwt-elementor');
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
            'hero_three_basic',
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
                'default' => __('Find Events Near', 'dwt-elementor'),
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_tag_line',
            [
                'label' => __('Section Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        /* for Event Or Listing tab */
        $this->start_controls_section(
            'hero_three_event_listing',
            [
                'label' => __('Event Or Listing', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'event_or_listing',
            [
                'label' => __('Google location or custom location?', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'd_events' => __('For Events Search', 'dwt-elementor'),
                    'd_listing' => __('For Listing Search', 'dwt-elementor'),
                ],
                'default' => 'd_listing',
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
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['event_or_listing'] = $settings['event_or_listing'] ? $settings['event_or_listing'] : 'd_listing';

        echo dwt_elementor_hero_three($params);
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