<?php
/**
 * All Events
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class All_Events extends Widget_Base
{
    public function get_name()
    {
        return 'all-events';
    }

    public function get_title()
    {
        return __('All Events', 'dwt-elementor');
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
            'all_events_basic',
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
                'default' => __('Latest Events','dwt-elementor'),
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

        /* Event settings tab */
        $this->start_controls_section(
            'event_settings',
            [
                'label' => __('Event Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
			'order_by',
			[
				'label' => __( 'Order By', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'asc'  => __( 'Oldest', 'dwt-elementor' ),
					'desc' => __( 'Latest', 'dwt-elementor' ),
					'rand' => __( 'Random', 'dwt-elementor' ),
				],
				'default' => 'desc',
                'label_block' => true,
			]
        );
        $this->add_control(
			'layout_type',
			[
				'label' => __( 'Layout Type', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'_grid'  => __( 'Grid', 'dwt-elementor' ),
					'_list' => __( 'List', 'dwt-elementor' ),
				],
				'default' => '_grid',
                'label_block' => true,
			]
        );
        $this->add_control(
			'no_of_events',
			[
				'label' => __( 'Number fo Events', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 600,
				'step' => 1,
				'default' => 8,
                'label_block' => true,
			]
        );
        $this->add_control(
			'btn_title',
			[
				'label' => __( 'Button Title', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Button title here', 'dwt-elementor' ),
                'default' =>    __( 'Button Link', 'dwt-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => __( 'Button Link', 'dwt-elementor' ),
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
        /* Event settings tab */
        $this->start_controls_section(
            'event_categories',
            [
                'label' => __('Event Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'event_cats',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_get_parests_cats('l_event_cat'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'event_cat_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'event_cats' => '',
                    ],
                ],
            ]
        );
        $this->end_controls_section();

    }
    protected function render()
    {
        /* get our input from the widget settings. */
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['order_by'] = $settings['order_by'] ? $settings['order_by'] : 'desc';
        $params['layout_type'] = $settings['layout_type'] ? $settings['layout_type'] : '_grid';
        $params['no_of_events'] = $settings['no_of_events'] ? $settings['no_of_events'] : 8;
        $params['btn_title'] = $settings['btn_title'] ? $settings['btn_title'] : '';
        $params['btn_link'] = $settings['btn_link']['url'] ? $settings['btn_link']['url'] : '';
        $params['target_one'] = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
         /*============ Event  Category ============*/
         $event_category_ = array();
         if (!empty($settings['event_cat_repeater'])) {
             foreach ($settings['event_cat_repeater'] as $item) {
                 if ($item['event_cats'] != '') {
                     $event_category_[] = $item['event_cats'];
                 }
             }
         }
         $params['event_categories'] = $event_category_;

        echo dwt_elementor_all_events($params);
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