<?php
/**
 * Hero four
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Four extends Widget_Base
{
    public function get_name()
    {
        return 'hero-four';
    }

    public function get_title()
    {
        return __('Hero Four(Listing & Event)', 'dwt-elementor');
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
            'hero_four_basic',
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
        $this->end_controls_section();

        /* for listing form tab */
        $this->start_controls_section(
            'hero_four_listing_form',
            [
                'label' => __('Listing Form', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'category_select',
            [
                'label' => __('Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_get_parests_cats('l_category'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'categories_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'category_select' => '',
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        /* for listing location tab */
        $this->start_controls_section(
            'hero_four_listing_location',
            [
                'label' => __('Listing Location', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'google_or_custom',
            [
                'label' => __('Google location or custom location?', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'google' => __('Google location', 'dwt-elementor'),
                    'custom' => __('Custom location', 'dwt-elementor'),
                ],
                'default' => 'custom',
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'location_select',
            [
                'label' => __('Location', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('l_location'),
            ]

        );
        $this->add_control(
            'location_repeater',
            [
                'label' => __('Select Location', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => [
                    'google_or_custom' => 'custom',
                ],
                'default' => [
                    [
                        'location_select' => '',
                    ]
                ]
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
                    ]
                ]
            ]
        );
        $this->end_controls_section();
    }


    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        /*========== Listing form ============*/
        if (!empty($settings['categories_repeater'])) {
            foreach ($settings['categories_repeater'] as $item) {
                if ($item['category_select'] != '') {
                    $blocks_form_cat[] = array(
                        'cat' => $item['category_select'],
                    );
                } else {
                    $blocks_form_cat[] = array(
                        'cat' => 'all',
                    );
                }
            }
        }
        $params['form_categories'] = $blocks_form_cat;
        /*=========== listing location ============*/
        $params['google_or_custom'] = $settings['google_or_custom'] ? $settings['google_or_custom'] : 'custom';
        if ($params['google_or_custom'] == 'custom') {

            if (!empty($settings['location_repeater'])) {
                foreach ($settings['location_repeater'] as $item) {
                    if ($item['location_select'] != '') {
                        $blocks_location_[] = array(
                            'name' => $item['location_select'],
                        );
                    } else {
                        $blocks_location_[] = array();
                    }
                }
            }
            $params['location_repeater'] = $blocks_location_;
        }
        /*============ Event  Category ============*/
        if (!empty($settings['event_cat_repeater'])) {
            foreach ($settings['event_cat_repeater'] as $item) {
                if ($item['event_cat'] != '') {
                    $event_category_[] = array(
                        'grid_cat' => $item['event_cat'],
                    );
                } else {
                    $event_category_[] = array(
                        'grid_cat' => 'all',
                    );
                }
            }
        }
        $params['event_categories'] = $event_category_;

        echo dwt_elementor_hero_four($params);
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