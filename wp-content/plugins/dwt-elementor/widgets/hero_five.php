<?php
/**
 * Hero Five
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Five extends Widget_Base
{
    public function get_name()
    {
        return 'hero-five';
    }

    public function get_title()
    {
        return __('Hero Five', 'dwt-elementor');
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
            'hero_five_basic',
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
                "description" => __("%count% for total ads.", 'dwt-elementor'),
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
            'is_display_tags',
            [
                'label' => __('Display tags?', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '0',
                'label_block' => true,
                'options' => [
                    '1'  => __('Yes', 'dwt-elementor'),
                    '0' => __('No', 'dwt-elementor'),
                ]
            ]
        );
        $this->add_control(
            'max_tags_limit',
            [
                'label' => __('Max number of tags', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 10,
                'condition' => [
                    'is_display_tags' => '1'
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        /* for Search From tab */
        $this->start_controls_section(
            'hero_two_search_form',
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
    }


    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        //$params['bg_img'] = $settings['bg_img']['url'] ? $settings['bg_img']['url'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['is_display_tags'] = $settings['is_display_tags'] ? $settings['is_display_tags'] : '0';
        if ($params['is_display_tags'] == '1') {
            $params['max_tags_limit'] = $settings['max_tags_limit'] ? $settings['max_tags_limit'] : 10;
        }
        /*========== Search form ============*/
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

        echo dwt_elementor_hero_five($params);
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