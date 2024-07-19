<?php
/**
 * FAQS
 */
namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Faqs extends Widget_Base
{
    public function get_name()
    {
        return 'faqs-one';
    }

    public function get_title()
    {
        return __('FAQ\'s', 'dwt-elementor');
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
            'faq_tab_basic',
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
                'rows' => 5,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* FAQs tab */
        $this->start_controls_section(
            'faq_tab_faqs',
            [
                'label' => __('FAQ\'s', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'faq_question',
            [
                'label' => __('Question', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'faq_answer',
            [
                'label' => __('Answer', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put Description here', 'dwt-elementor'),
                'rows' => 5,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'faq_question_repeater',
            [
                'label' => __('Question & Answer', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'faq_question' => '',
                        'faq_answer' => '',
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        /* Safety tab */
        $this->start_controls_section(
            'faq_tab_safety',
            [
                'label' => __('Safety Tips', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'safety_title',
            [
                'label' => __('Section Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'safety_description',
            [
                'label' => __('Section Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put Description here', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 5,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'safety_tips',
            [
                'label' => __('Tips', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'safety_tips_repeater',
            [
                'label' => __('Add Tips', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'safety_tips' => '',
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
        $params['faq_question_repeater'] = $settings['faq_question_repeater'];
        $params['safety_title'] = $settings['safety_title'] ? $settings['safety_title'] : '';
        $params['safety_description'] = $settings['safety_description'] ? $settings['safety_description'] : '';
        $params['safety_tips_repeater'] = $settings['safety_tips_repeater'];

        echo dwt_elementor_faqs($params);
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