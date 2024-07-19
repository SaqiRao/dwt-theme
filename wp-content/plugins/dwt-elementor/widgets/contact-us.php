<?php
/**
 * contact us
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Contact_Us extends Widget_Base
{
    public function get_name()
    {
        return 'contact-us';
    }

    public function get_title()
    {
        return __('Contact Us', 'dwt-elementor');
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
            'contact_form_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'contact_short_code',
            [
                'label' => __('Contact form 7 shortcode', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put shortcode here', 'dwt-elementor'),
                'rows' => 3,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for Address tab */
        $this->start_controls_section(
            'contact_form_address',
            [
                'label' => __('Address', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'con_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'con_address',
            [
                'label' => __('Address', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put address here', 'dwt-elementor'),
                'rows' => 3,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for working hours tab */
        $this->start_controls_section(
            'contact_form_working_hour',
            [
                'label' => __('Working Hours', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'con_work_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'con_work_time',
            [
                'label' => __('Hours', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put hours here', 'dwt-elementor'),
                'rows' => 3,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for title tab */
        $this->start_controls_section(
            'contact_form_contacting',
            [
                'label' => __('Contacts', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'con_num_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'con_number',
            [
                'label' => __('Contact Number', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put contact number here', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 3,
            ]
        );
        $this->end_controls_section();

        /* for Email tab */
        $this->start_controls_section(
            'contact_form_email',
            [
                'label' => __('Email', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'con_email_title',
            [
                'label' => __('Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'con_email',
            [
                'label' => __('Your Email', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put your email here', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 3,
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['contact_short_code'] = $settings['contact_short_code'] ? $settings['contact_short_code'] : '';
        $params['con_title'] = $settings['con_title'] ? $settings['con_title'] : '';
        $params['con_address'] = $settings['con_address'] ? $settings['con_address'] : '';
        $params['con_work_title'] = $settings['con_work_title'] ? $settings['con_work_title'] : '';
        $params['con_work_time'] = $settings['con_work_time'] ? $settings['con_work_time'] : '';
        $params['con_num_title'] = $settings['con_num_title'] ? $settings['con_num_title'] : '';
        $params['con_number'] = $settings['con_number'] ? $settings['con_number'] : '';
        $params['con_email_title'] = $settings['con_email_title'] ? $settings['con_email_title'] : '';
        $params['con_email'] = $settings['con_email'] ? $settings['con_email'] : '';

        echo dwt_elementor_contact_us($params);
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