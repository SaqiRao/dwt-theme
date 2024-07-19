<?php
/**
 * Newsletter
 */

namespace ElementorDwt\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class News_Letter extends Widget_Base
{
    public function get_name()
    {
        return 'news-letter';
    }

    public function get_title()
    {
        return __('Newsletter', 'dwt-elementor');
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
            'news_letter_basic',
            [
                'label' => __('Basic', 'dwt-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'news_letter_heading',
            [
                'label' => __('News Letter Heading', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Want to notified? Subscribe now', 'dwt-elementor'),
                'placeholder' => __('Put heading here', 'dwt-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'newsletter_btn_txt',
            [
                'label' => __('Button Text', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Notify Me', 'dwt-elementor'),
                'placeholder' => __('Put Button text here', 'dwt-elementor'),
                'rows' => 5,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        $params['news_letter_heading'] = $settings['news_letter_heading'] ? $settings['news_letter_heading'] : '';
        $params['newsletter_btn_txt'] = $settings['newsletter_btn_txt'] ? $settings['newsletter_btn_txt'] : '';

        echo dwt_elementor_news_letter($params);
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