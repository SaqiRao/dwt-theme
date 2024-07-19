<?php
/**
 * Hero six
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Six extends Widget_Base
{
    public function get_name()
    {
        return 'hero-six';
    }

    public function get_title()
    {
        return __('Hero Six', 'dwt-elementor');
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
            'hero_six_basic',
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
                'default' => __('Find Out', 'dwt-elementor'),
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_tag_line',
            [
                'label' => __('Section Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for Button settings tab */
        $this->start_controls_section(
            'hero_six_button_settings',
            [
                'label' => __('Button Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'btn1_title',
            [
                'label' => __('View All', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('Button Link', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'btn1_link',
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
        $this->add_control(
            'btn2_title',
            [
                'label' => __('View All', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('Button Link', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'btn2_link',
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
        $this->add_control(
            'app_img',
            [
                'label' => __('Section Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
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
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        /* button one */
        $params['btn1_title'] = $settings['btn1_title'] ? $settings['btn1_title'] :'';
        $params['btn1_link'] = $settings['btn1_link']['url'] ? $settings['btn1_link']['url'] : '#';
        $params['target_one'] = $settings['btn1_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn1_link']['nofollow'] ? ' rel="nofollow"' : '';
        /* button two */
        $params['btn2_title'] = $settings['btn2_title'] ? $settings['btn2_title'] : '';
        $params['btn2_link'] = $settings['btn2_link']['url'] ? $settings['btn2_link']['url'] : '#';
        $params['target_two'] = $settings['btn2_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_two'] = $settings['btn2_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['app_img'] = $settings['app_img']['id'] ? $settings['app_img']['id'] : '';

        echo dwt_elementor_hero_six($params);
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