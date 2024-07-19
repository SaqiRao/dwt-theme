<?php
/**
 * All listings
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Blogs extends Widget_Base
{
    public function get_name()
    {
        return 'all-blogs';
    }

    public function get_title()
    {
        return __('Blogs', 'dwt-elementor');
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
            'dwt_blogs',
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
                'default' => __('Recent Aticles', 'dwt-elementor'),
                'placeholder' => __('Put description here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('From The Blog', 'dwt-elementor'),
                'label_block' => true,
                'rows' => 5,
            ]
        );
        $this->add_control(
			'max_limit',
			[
				'label' => __( 'Number fo Blogs', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => 8,
                'label_block' => true,
			]
        );
        $this->add_control(
			'all_posts_btn_title',
			[
				'label' => __( 'Button Title', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Button title here', 'dwt-elementor' ),
                'default' =>    __( 'View All Listings', 'dwt-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'all_posts_btn_link',
			[
				'label' => __( 'View All Button Link', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'dwt-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'label_block' => true,
			]
		);
        $this->add_control(
			'pattern_chk',
			[
				'label' => __( 'Show Pattern Image', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'dwt-elementor' ),
				'label_off' => __( 'Hide', 'dwt-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
                'label_block' => true,
			]
		);
        $this->end_controls_section();

         /* for Blog Category */
         $this->start_controls_section(
            'all_blogs_cats',
            [
                'label' => __('Blog Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'blog_cats',
			[
				'label' => __('Blog Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_get_parests_cats('category'),
                'label_block' => true,
			]
        );
        $this->add_control(
            'blog_cats_repeater',
            [
                'label' => __('Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'blog_cats' => '',
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
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '' ;
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['max_limit'] = $settings['max_limit'] ? $settings['max_limit'] : 8;
        $params['all_posts_btn_title'] = $settings['all_posts_btn_title'] ? $settings['all_posts_btn_title'] : '';
        $params['all_posts_btn_link'] = $settings['all_posts_btn_link']['url'] ? $settings['all_posts_btn_link']['url'] : '';
        $params['target_one'] = $settings['all_posts_btn_link']['is_external'] ? ' target="_blank"' : '';
		$params['nofollow_one'] = $settings['all_posts_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['pattern_chk'] = $settings['pattern_chk'] ? $settings['pattern_chk'] : 'no';
        $params['blog_cats_repeater'] = $settings['blog_cats_repeater'] ? $settings['blog_cats_repeater'] : array();
        
        echo dwt_elementor_all_blogs($params);
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