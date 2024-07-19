<?php
/**
 * About Us Two
 */
namespace ElementorDwt\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class About_Us_Two extends Widget_Base
{
    public function get_name()
	{
		return 'about-us-two';
	}

	public function get_title()
	{
		return __('About Us(New)', 'dwt-elementor');
	}

	public function get_icon()
	{
		return 'eicon-animation';
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
        /* for About Us tab */
		$this->start_controls_section(
			'aboutus_new_section',
			[
				'label' => __('About Us(New)', 'dwt-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $this->add_control(
			'section_title',
			[
				'label' => __('About Heading', 'dwt-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('About DWT Listing Directory', 'dwt-elementor'),
				'placeholder' => __('About DWT Listing Directory', 'dwt-elementor'),
                'label_block' => true,
			]
		);


		$this->add_control(
			'section_tag_line',
			[
				'label' => __('Your Tagline', 'dwt-elementor'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 5,
                'label_block' => true,
			]
		);

		$this->add_control(
			'section_description',
			[
				'label' => __('Section Description', 'dwt-elementor'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 5,
                'label_block' => true,
			]
        );
        $this->add_control(
			'img_postion',
			[
				'label' => __('Grid Image Position', 'dwt-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
					'right' => __('Right', 'dwt-elementor'),
					'left' => __('Left', 'dwt-elementor'),
				],
				'default' => 'right',
                'label_block' => true,
			]
        );
        $this->add_control(
			'main_btn_title',
			[
				'label' => __( 'Main Button Title', 'dwt-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Button title here', 'dwt-elementor' ),
                'default' =>    __( 'Explore Listings', 'dwt-elementor' ),
				'label_block' => true
			]
		);
		
		$this->add_control(
			'main_btn_link',
			[
				'label' => __( 'Main Button Link', 'dwt-elementor' ),
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

        /* for Feature tab */
		$this->start_controls_section(
			'about _new_feature_section',
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
                'description' => __('Recommended image size 64x64 .png', 'dwt-elementor'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					'id'=> ''
				],
                'label_block' => true,
			]
		);
		$this->add_control(
			'about_new_features',
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
				'features_title' => '{{{ features_title }}}',
			]
		);

        $this->end_controls_section();

        /* Grid Images */
        $this->start_controls_section(
			'about_new_grid_images',
			[
				'label' => __('Grid Images', 'dwt-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'about_new_grid_img',
			[
				'label' => __('Grid Image', 'dwt-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => __('Recommended image size 260x260 & should be 4 images to avoid design conflict', 'dwt-elementor'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
					'id' => '' 
				],
                'label_block' => true,
			]
        );
        $this->add_control(
			'grid_imgs',
			[
				'label' => __('Grid Images', 'dwt-elementor'),
				'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
					[
						'about_new_grid_img' => __('Your Title', 'dwt-elementor'),
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
		$params['section_tag_line'] = $settings['section_tag_line'] ? $settings['section_tag_line'] : '';
        $params['section_description'] = $settings['section_description'] ? $settings['section_description'] : ''; 
        $params['img_postion'] = $settings['img_postion'] ? $settings['img_postion'] : 'right';
        $params['main_btn_title'] = $settings['main_btn_title'] ? $settings['main_btn_title'] : ''; 
		$params['main_btn_link'] = $settings['main_btn_link']['url'] ? $settings['main_btn_link']['url'] : '';
		$params['target_one'] = $settings['main_btn_link']['is_external'] ? ' target="_blank"' : '';
		$params['nofollow_one'] = $settings['main_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
        $params['about_new_features'] = $settings['about_new_features']; 
        $params['grid_imgs'] = $settings['grid_imgs'];
		
		echo dwt_elementor_about_us_new($params);
		
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