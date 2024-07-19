<?php
/**
 * App Section
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class App_Sections extends Widget_Base
{
    public function get_name()
    {
        return 'app-section';
    }

    public function get_title()
    {
        return __('App Section', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-posts-group';
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
            'app_section_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'app_bg_img',
            [
                'label' => __('Background Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('image Size Should Be 1280X800', 'dwt-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'app_img',
            [
                'label' => __('App Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('image Size Should Be 400X500', 'dwt-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_tagline',
            [
                'label' => __('Section Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
                'label_block' => true,
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
            'app_section_android',
            [
                'label' => __('Android Dwonload Link', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put download link here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'app_section_ios',
            [
                'label' => __('IOS Dwonload Link', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put download link here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['section_tagline'] = $settings['section_tagline'] ? $settings['section_tagline'] : '';
        $params['app_bg_img'] = $settings['app_bg_img']['id'] ? $settings['app_bg_img']['id'] : '';
        $params['app_img'] = $settings['app_img']['id'] ? $settings['app_img']['id'] : '';
        $params['app_section_android'] = $settings['section_tagline'] ? $settings['app_section_android'] : '';
        $params['app_section_ios'] = $settings['section_tagline'] ? $settings['app_section_ios'] : '';

        echo dwt_elementor_app_section($params);
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