<?php
namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class About_Us extends Widget_Base {

    public function get_name() {
        return 'about-us-one';
    }

    public function get_title() {
        return __('About Us', 'dwt-elementor');
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    public function get_categories() {
        return ['dwttheme'];
    }

    public function get_script_depends() {
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
    protected function _register_controls() {
        /* for About Us tab */
        $this->start_controls_section(
                'aboutus_section',
                [
                    'label' => __('About Us', 'dwt-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );



        $this->add_control(
                'section_title',
                [
                    'label' => __('About Heading', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('About DWT Listing Directory', 'dwt-elementor'),
                    'label_block' => true,
                    'placeholder' => __('About DWT Listing Directory', 'dwt-elementor'),
                ]
        );


        $this->add_control(
                'section_tag_line',
                [
                    'label' => __('Your Tagline', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ],
        );

        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );

        $this->add_control(
                'bg_img',
                [
                    'label' => __('About Image', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                        'id' => '',
                    ],
                    'label_block' => true,
                ]
        );

        $this->add_control(
                'img_postion',
                [
                    'label' => __('Image Position', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'options' => [
                        'right' => __('Right', 'dwt-elementor'),
                        'left' => __('Left', 'dwt-elementor'),
                    ],
                    'default' => 'right',
                    'label_block' => true,
                ]
        );

        $this->end_controls_section();

        /* for Feature tab */
        $this->start_controls_section(
                'about_feature_section',
                [
                    'label' => __('Features', 'dwt-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'features_title',
                [
                    'label' => __('Title', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'features_desc',
                [
                    'label' => __('Description', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'label_block' => true,
                ]
        );
        $repeater->add_control(
                'features_img',
                [
                    'label' => __('Location Image', 'dwt-elementor'),
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
                'features',
                [
                    'label' => __('Feature List', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'features_title' => __('Your Title', 'dwt-elementor'),
                            'features_desc' => __('Some Description', 'dwt-elementor'),
                        ],
                    ],
                    'features_title' => '{{ { features_title }}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['bg_img'] = $settings['bg_img']['id'] ? $settings['bg_img']['id'] : '';
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : '';
        $params['features'] = $settings['features'] ? $settings['features'] : array();
        echo dwt_elementor_about_us($params);
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
    protected function _content_template() {
        
    }

}