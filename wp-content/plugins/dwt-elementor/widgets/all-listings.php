<?php
/**
 * All listings
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class All_Listings extends Widget_Base
{
    public function get_name()
    {
        return 'all-listings';
    }

    public function get_title()
    {
        return __('All Listings', 'dwt-elementor');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
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
            'all_listings_basic',
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
                'default' => __('Exclusive', 'dwt-elementor'),
                'placeholder' => __('Put title here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Put description here', 'dwt-elementor'),
                'rows' => 5,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        /* for listing settings tab */
        $this->start_controls_section(
            'all_listings_settings',
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
            'layout_type',
            [
                'label' => __('Layout Type', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '' => __('Select Layout Type', 'dwt-elementor'),
                    'grid1' => __('Grid 1', 'dwt-elementor'),
                    'grid2' => __('Grid 2', 'dwt-elementor'),
                    'grid3' => __('Grid 3', 'dwt-elementor'),
                    'grid4' => __('Grid 4', 'dwt-elementor'),
                ],
                'default' => 'grid4',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'no_of_ads',
            [
                'label' => __('Number fo Listings', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 8,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'all_listing_btn_title',
            [
                'label' => __('View All', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button title here', 'dwt-elementor'),
                'default' =>    __('View All Listings', 'dwt-elementor'),
                'label_block' => true,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'all_listing_btn_link',
            [
                'label' => __('View All Button Link', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'dwt-elementor'),
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

        /* for listing Category */
        $this->start_controls_section(
            'all_listings_cats',
            [
                'label' => __('Listing Categories', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'listing_cat',
            [
                'label' => __('Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => dwt_elementor_get_parests_cats('l_category'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'listing_cat_repeater',
            [
                'label' => __('Select Category', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'listing_cat' => '',
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
        $params['ad_type'] = $settings['ad_type'] ? $settings['ad_type'] : 'both';
        $params['ad_order'] = $settings['ad_order'] ? $settings['ad_order'] : 'desc';
        $params['layout_type'] = $settings['layout_type'] ? $settings['layout_type'] : 'grid4';
        $params['no_of_ads'] = $settings['no_of_ads'] ? $settings['no_of_ads'] : 8;
        $params['all_listing_btn_title'] = $settings['all_listing_btn_title'] ? $settings['all_listing_btn_title'] : '';
        $params['all_listing_btn_link'] = $settings['all_listing_btn_link']['url'] ? $settings['all_listing_btn_link']['url'] : '';
        $params['target_one'] = $settings['all_listing_btn_link']['is_external'] ? ' target="_blank"' : '';
        $params['nofollow_one'] = $settings['all_listing_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $list_cats = $settings['listing_cat_repeater'] ? $settings['listing_cat_repeater'] : '';

        /* all listing category */
        $listing_category_ = array();
        if (!empty($list_cats)) {
            foreach ($list_cats as $item) {
                if ($item['listing_cat'] != '') {
                    $listing_category_[] = $item['listing_cat'];
                }
            }
        }

        $params['listing_categories'] = $listing_category_;

        echo dwt_elementor_all_listings($params);
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