<?php
/**
 * how it work
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class How_It_Work_New extends Widget_Base
{
    public function get_name()
    {
        return 'how-it-work-new';
    }

    public function get_title()
    {
        return __('How It Work (New)', 'dwt-elementor');
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
            'how_it_work_new_basic',
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
            'steps_bg_img',
            [
                'label' => __('Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for steps tab */
        $this->start_controls_section(
            'how_it_work_new_steps',
            [
                'label' => __('Steps', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'steps_process_num',
            [
                'label' => __('Process Number', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Like 01', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'steps_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'steps_desc',
            [
                'label' => __('Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Description here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'steps_img',
            [
                'label' => __('Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('size must be 64X64', 'dwt-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'steps_repeat',
            [
                'label' => __('Steps', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'steps_process_num' => '',
                        'steps_title' => '',
                        'steps_desc' => '',
                        'steps_img' => '',
                    ],
                ],
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
        $params['steps_bg_img'] = $settings['steps_bg_img']['id'] ? $settings['steps_bg_img']['id'] : '';
        $params['steps_repeat'] = $settings['steps_repeat'];

        echo dwt_elementor_how_it_work_new($params);
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