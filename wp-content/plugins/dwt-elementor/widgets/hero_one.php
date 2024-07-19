<?php
/**
 * Hero One
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_One extends Widget_Base
{
    public function get_name()
    {
        return 'hero-one';
    }

    public function get_title()
    {
        return __('Hero One', 'dwt-elementor');
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
            'hero_one_basic',
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
        $this->add_control(
            'form_text',
            [
                'label' => __('Search Form Text', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put Search text here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'pattern_chk',
            [
                'label' => __('Show Clody Image', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'your-plugin'),
                'label_off' => __('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'no',
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for Search From tab */
        $this->start_controls_section(
            'hero_one_search_form',
            [
                'label' => __('Search Form', 'dwt-elementor'),
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

        /* for Location tab */
        $this->start_controls_section(
            'hero_one_location',
            [
                'label' => __('Location', 'dwt-elementor'),
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
                'label' => __('Select Location', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('l_location'),
            ]

        );
        $this->add_control(
            'location_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
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

        /* for category tab */
        $this->start_controls_section(
            'hero_one_category',
            [
                'label' => __('Grid Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'grid_cat',
            [
                'label' => __('Categories', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_location_data_shortcode('l_category'),
            ]

        );
        $this->add_control(
            'grid_category_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'grid_cat' => '',
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
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['form_text'] = $settings['form_text'] ? $settings['form_text'] : '';
        $params['pattern_chk'] = $settings['pattern_chk'] ? $settings['pattern_chk'] : 'no';
        /*========== search form ============*/
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
        /*=========== location ============*/
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
        /*============ grid category ============*/
        if (!empty($settings['grid_category_repeater'])) {
            foreach ($settings['grid_category_repeater'] as $item) {
                if ($item['grid_cat'] != '') {
                    $grid_category_[] = array(
                        'grid_cat' => $item['grid_cat'],
                    );
                } else {
                    $grid_category_[] = array(
                        'grid_cat' => 'all',
                    );
                }
            }
        }
        $params['grid_categories'] = $grid_category_;

        echo dwt_elementor_hero_one($params);
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