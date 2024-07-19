<?php
/**
 * Hero Ten
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Ten extends Widget_Base
{
    public function get_name()
    {
        return 'hero-ten';
    }

    public function get_title()
    {
        return __('Hero Ten', 'dwt-elementor');
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
            'hero_ten_basic',
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
                'label_block' => true,
                'placeholder' => __('Put title here', 'dwt-elementor'),
            ]
        );
        $this->add_control(
            'section_tag_line',
            [
                'label' => __('Section Tagline', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __('Put tagline here', 'dwt-elementor'),
            ]
        );
        $this->end_controls_section();

        /* for Settings tab */
        $this->start_controls_section(
            'hero_ten_settings',
            [
                'label' => __('Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'rotating_words',
            [
                'label' => __('Hero Section Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Use | sign to add more words eg ( Attratction|Explore City|Food ).', 'dwt-elementor'),
                'label_block' => true,
                'placeholder' => __('Put title here', 'dwt-elementor'),
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
                'label_block' => true,
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
                'label_block' => true,
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
    }


    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['rotating_words'] = $settings['rotating_words'] ? $settings['rotating_words'] : '';

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
        echo dwt_elementor_hero_ten($params);
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