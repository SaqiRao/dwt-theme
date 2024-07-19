<?php
/**
 * Call to Action one
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Call_To_Action_One extends Widget_Base
{
    public function get_name()
    {
        return 'call-to-action-one';
    }

    public function get_title()
    {
        return __('Call To Action', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-call-to-action';
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
            'call_to_action_one',
            [
                'label' => __('Content Area', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Larnge business directory theme ', 'dwt-elementor'),
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
                'label_block' => true,
                'rows' => 5,
            ]
        );
        $this->add_control(
			'call_action_one_btn_title',
			[
				'label' => __( 'Button Title', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Button title here', 'dwt-elementor' ),
                'default' =>    __( 'Button Link', 'dwt-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'call_action_one_btn_link',
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
        $this->end_controls_section();
    }
    protected function render()
    {
        //get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '' ;
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['call_action_one_btn_title'] = $settings['call_action_one_btn_title'] ? $settings['call_action_one_btn_title'] : '';
        $params['call_action_one_btn_link'] = $settings['call_action_one_btn_link']['url'] ? $settings['call_action_one_btn_link']['url'] : '';
        $params['target_one'] = $settings['call_action_one_btn_link']['is_external'] ? ' target="_blank"' : '';
		$params['nofollow_one'] = $settings['call_action_one_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        echo dwt_elementor_call_to_action_one($params);
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