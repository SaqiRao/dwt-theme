<?php
/**
 * Hero Nine
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Hero_Nine extends Widget_Base
{
    public function get_name()
    {
        return 'hero-nine';
    }

    public function get_title()
    {
        return __('Hero Nine (New)', 'dwt-elementor');
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
            'hero_nine_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'form_text',
            [
                'label' => __('First Heading', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put heading here', 'dwt-elementor'),
                'label_block' => true,
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
        $this->end_controls_section();

        /* for video tab */
        $this->start_controls_section(
            'hero_nine_video',
            [
                'label' => __('Video Options', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'pattern_chk',
            [
                'label' => __('Want to show background video', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'dwt-elementor'),
                'label_off' => __('Hide', 'dwt-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_video',
            [
                'label' => __('BG Video', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Put Youtube video url.', 'dwt-elementor'),
                'condition' => [
                    'pattern_chk' => 'yes'
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
    }


    protected function render()
    {
        // // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['form_text'] = $settings['form_text'] ? $settings['form_text'] : '';
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['pattern_chk'] = $settings['pattern_chk'] ? $settings['pattern_chk'] : 'no';
        if($params['pattern_chk'] == 'yes'){
        $params['section_video'] = $settings['section_video'] ? $settings['section_video'] : '';
        }


        echo dwt_elementor_hero_nine($params);
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