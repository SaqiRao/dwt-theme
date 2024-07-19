<?php
/**
 * Event Categories
 */
namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Event_Categories extends Widget_Base
{
    public function get_name()
    {
        return 'event-categories';
    }

    public function get_title()
    {
        return __('Event Categories', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-product-categories';
    }

    public function get_categories()
    {
        return ['dwttheme'];
    }

    public function get_script_depends()
    {
        return [''];
    }
    protected function _register_controls()
    {
        /* for Basic tab */
        $this->start_controls_section(
            'event_categories_basic',
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
                'default' => __('Filter Events', 'dwt-elementor'),
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

        /* for Categories tab */
        $this->start_controls_section(
            'event_categories',
            [
                'label' => __('Event Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'event_select',
			[
				'label' => __('Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_get_parests_cats('l_event_cat'),
                'label_block' => true,
			]
        );
        $repeater->add_control(
			'category_img',
			[
				'label' => __( 'Choose Image', 'dwt-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __( 'Image Size must be 265X280 px', 'dwt-elementor' ),
				'default' => [
                    'id'=> '',
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'label_block' => true,
			]
        );
        $this->add_control(
            'event_categories_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'event_select' => '',
                        'category_img' => '',
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
        $params['event_categories_repeater'] = $settings['event_categories_repeater'] ? $settings['event_categories_repeater'] : array();
        
        echo dwt_elementor_category_events($params);
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