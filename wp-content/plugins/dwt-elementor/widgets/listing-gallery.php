<?php
/**
 * Listing Gallery
 */
namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Listing_Gallery extends Widget_Base
{
    public function get_name()
    {
        return 'listing-gallery';
    }

    public function get_title()
    {
        return __('Listing Gallery', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-gallery-masonry';
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
            'listing_gallery_basic',
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

        /* for Listing Settings tab */
        $this->start_controls_section(
            'listing_gallery_settings',
            [
                'label' => __('Listing Settings', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'ad_type',
            [
                'label' => __('Listing Type', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '' => __('Select Listing Type', 'dwt-elementor'),
                    'feature' => __('Featured Listing', 'dwt-elementor'),
                    'regular' => __('Simple Listing', 'dwt-elementor'),
                    'both' => __('Both', 'dwt-listing'),
                ],
                'default' => 'both',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'ad_order',
            [
                'label' => __('Order By', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '' => __('Select Listing order', 'dwt-elementor'),
                    'asc' => __('Oldest', 'dwt-elementor'),
                    'desc' => __('Latest', 'dwt-elementor'),
                    'rand' => __('Random', 'dwt-elementor'),
                ],
                'default' => 'desc',
                'label_block' => true,
            ]
        );
        $this->add_control(
			'no_of_ads',
			[
				'label' => __( 'Number fo Listings', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => 8,
                'label_block' => true,
			]
        );
        $this->end_controls_section();

        /* for categories tab */
        $this->start_controls_section(
            'listing_gallery_category',
            [
                'label' => __('Listing Category', 'dwt-elementor'),
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
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $params['ad_type'] = $settings['ad_type'] ? $settings['ad_type'] : 'both';
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : 'desc';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : 8;
        $params['categories_repeater'] = $settings['categories_repeater'] ? $settings['categories_repeater'] : array();

        echo dwt_elementor_listing_gallery($params);
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