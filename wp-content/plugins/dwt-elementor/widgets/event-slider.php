<?php
/**
 * Event Slider
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Event_slider extends Widget_Base
{
    public function get_name()
    {
        return 'event-slider';
    }

    public function get_title()
    {
        return __('Event Slider', 'dwt-elementor');
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
            'event_slider_basic',
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
                'default' => __('Upcoming Events', 'dwt-elementor'),
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for Events Settings tab */
        $this->start_controls_section(
            'event_slider_settings',
            [
                'label' => __('Event Slider Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'layout_type',
            [
                'label' => __('Layout Type', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '_slider' => __('Slider', 'dwt-elementor'),
                ],
                'default' => '_slider',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'ad_order',
            [
                'label' => __('Order By', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'asc' => __('Oldest', 'dwt-elementor'),
                    'desc' => __('Latest', 'dwt-elementor'),
                    'rand' => __('Random', 'dwt-elementor'),
                ],
                'default' => 'desc',
                'label_block' => true,
            ]
        );
        $this->add_control(
			'no_of_ads',
			[
				'label' => __( 'Number fo Events', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 2000,
				'step' => 1,
				'default' => 8,
                'label_block' => true,
			]
		);
        $this->end_controls_section();

        /* for event form tab */
        $this->start_controls_section(
            'hero_four_event_form',
            [
                'label' => __('Event Form', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'event_cat',
            [
                'label' => __('Event Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('l_event_cat'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'event_cat_repeater',
            [
                'label' => __('Select Event Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'event_cat' => '',
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
        $params['layout_type'] = $settings['layout_type'] ? $settings['layout_type'] : '_slider';
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : 'desc';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : 8;

        /*============ Event  Category ============*/
        $event_category_ = array();
        if (!empty($settings['event_cat_repeater'])) {
            foreach ($settings['event_cat_repeater'] as $item) {
                if ($item['event_cat'] != '') {
                    $event_category_[] = $item['event_cat'];
                }
            }
        }
        $params['event_categories'] = $event_category_;



        echo dwt_elementor_event_slider($params);
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