<?php
/**
 * Our Clients
 */
namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Clients extends Widget_Base
{
    public function get_name()
    {
        return 'clients';
    }

    public function get_title()
    {
        return __('Clients or Brands', 'dwt-elementor');
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
            'clients_basic',
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
        $this->end_controls_section();

        /* for cleints tab */
        $this->start_controls_section(
            'clients',
            [
                'label' => __('Clients', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'client_link',
            [
                'label' => __('Client Link', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('www.abc.com', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
			'client_logo',
			[
				'label' => __( 'Choose logo Image', 'dwt-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('image Size Should Be 140x95','dwt-elementor'),
				'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                    'id'=>'',
				],
                'label_block' => true,
			]
		);
        $this->add_control(
            'clients_repeater',
            [
                'label' => __('Select Clients', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'client_link' => '',
                        'client_logo' => '',
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
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['clients_repeater'] = $settings['clients_repeater'] ? $settings['clients_repeater'] : array();

        echo dwt_elementor_clients($params);
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