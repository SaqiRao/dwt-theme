<?php
/**
 * Packages
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Packages extends Widget_Base {

    public function get_name() {
        return 'packages';
    }

    public function get_title() {
        return __('Packages', 'dwt-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-group';
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
        /* for Basic tab */
        $this->start_controls_section(
                'packages_basic',
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

        /* for Basic tab */
        $this->start_controls_section(
                'packages_select',
                [
                    'label' => __('Select Package', 'dwt-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'products',
                [
                    'label' => __('Package', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => false,
                    'options' => dwt_elementor_get_packages(),
                    'label_block' => true,
                ]
        );
        $this->add_control(
                'package_repeater',
                [
                    'label' => __('Package', 'dwt-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'products' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['section_title'] = $settings['section_title'] ? $settings['section_title'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : '';
        $package_repeate = $settings['package_repeater'] ? $settings['package_repeater'] : '';
        /* create array for products */
        $prod_arr = array();
        if ($package_repeate != '' && is_array($package_repeate)) {
            foreach ($package_repeate as $single_prod) {
                $prod_arr[]['products_'] = $single_prod['products'];
            }
        }
        $params['product'] = $prod_arr;
        echo dwt_elementor_package_select($params);
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
  

}