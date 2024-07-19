<?php
/**
 * Fun Facts
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Fun_Facts extends Widget_Base
{
    public function get_name()
    {
        return 'fun-facts';
    }

    public function get_title()
    {
        return __('Fun Facts', 'dwt-elementor');
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
         /* for Fun Facts tab */
         $this->start_controls_section(
            'fun_facts',
            [
                'label' => __('Fun Facts', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'fun_fact_number',
            [
                'label' => __('Number', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('3000', 'dwt-elementor'),
                'default' => 3000,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'fun_fact_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'fun_fact_img',
            [
                'label' => __('Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('Size must be 64X64', 'dwt-elementor'),
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id' => ''
                ],
                'label_block' => true,
            ]
        );
        $this->add_control(
            'fun_fact_repeater',
            [
                'label' => __('Fun Facts', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'fun_fact_number' => '',
                        'fun_fact_title' => '',
                        'fun_fact_img' => ''
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['fun_fact_repeater'] = $settings['fun_fact_repeater'] ? $settings['fun_fact_repeater'] : array();
        
        echo dwt_elementor_fun_facts($params);
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