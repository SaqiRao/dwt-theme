<?php
if (!defined('ABSPATH'))
    exit;

// -> START Basic Fields
Redux::set_section($opt_name, array(
    'title' => esc_html__('Theme Settings', 'dwt-listing'),
    'id' => 'theme-settings',
    'desc' => esc_html__('These are really basic fields to setup theme!', 'dwt-listing'),
    'customizer_width' => '400px',
    'icon' => 'el el-wrench'
));

Redux::set_section($opt_name, array(
    'title' => esc_html__('General Settings', 'dwt-listing'),
    'id' => 'general-settings',
    'subsection' => true,
    'customizer_width' => '450px',
    'desc' => '',
    'fields' => array(
        array(
            'id' => 'dwt_listing_header-layout',
            'type' => 'image_select',
            'title' => esc_html__('Header Layout', 'dwt-listing'),
            'desc' => esc_html__('Select Header Layout you want to show. Header 5 only used with Elementor Pro.', 'dwt-listing'),
            'options' => array(
                '1' => array(
                    'alt' => esc_html__('Header Layout Type 1', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/h1.png'
                ),
                '2' => array(
                    'alt' => esc_html__('Header Layout Type 2', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/h2.png'
                ),
                '3' => array(
                    'alt' => esc_html__('Header Layout Type 3', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/h3.png'
                ),
                '4' => array(
                    'alt' => esc_html__('Header Layout Type 4', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/h4.png'
                ),
                '5' => array(
                    'alt' => esc_html__('Elementor Header', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/h5.png'
                ),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'dwt_listing_topbar',
            'type' => 'switch',
            'title' => esc_html__('Enable Topbar', 'dwt-listing'),
            'default' => true,
            'desc' => esc_html__('Want to show topbar with header.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_slogan',
            'type' => 'text',
            'title' => esc_html__('Your text/slogan', 'dwt-listing'),
            'desc' => esc_html__('Enter your text', 'dwt-listing'),
            'default' => 'Welcome To DWT Listing Theme',
            'required' => array('dwt_listing_topbar', '=', true),
        ),
        array(
            'id' => 'dwt_listing_locationz',
            'type' => 'switch',
            'title' => esc_html__('Enable Topbar Locations', 'dwt-listing'),
            'default' => true,
            'required' => array('dwt_listing_topbar', '=', true),
            'desc' => esc_html__('Want to show topbar with header.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_selected_locz',
            'type' => 'select',
            'data' => 'terms',
            'required' => array('dwt_listing_locationz', '=', true),
            'multi' => true,
            'sortable' => true,
            'required' => array('dwt_listing_topbar', '=', true),
            'title' => __('Select Locations', 'dwt-listing'),
            //'args' => array('taxonomies' => array('l_location'), 'hide_empty' => false),
            'args' => array('taxonomy' => 'l_location', 'hide_empty' => false,),
        ),
        array(
            'id' => 'dwt_block_widget',
            'type' => 'switch',
            'title' => __('Add new block widget style', 'adforest'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_share',
            'type' => 'sortable',
            'title' => __('Social Media Links', 'dwt-listing'),
            'subtitle' => __('Update your social media links.', 'dwt-listing'),
            'desc' => __('This is the description field, again good for additional info.', 'dwt-listing'),
            'label' => true,
            'required' => array('dwt_listing_topbar', '=', true),
            'options' => array(
                'Facebook' => 'Facebook',
                'Twitter' => 'Twitter',
                'Skype' => 'Skype',
                'LinkedIn' => 'LinkedIn',
                'Youtube' => 'Youtube',
                'GooglePlus' => 'GooglePlus',
                'Instagram' => 'Instagram',
            )
        ),
        array(
            'id' => 'dwt_listing_site-spinner',
            'type' => 'switch',
            'title' => esc_html__('Show Spinner', 'dwt-listing'),
            'default' => true,
            'desc' => esc_html__('Trun on or off site loader.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_spinner-logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Spinner Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('Select spinner image', 'dwt-listing'),
            'required' => array('dwt_listing_site-spinner', '=', true),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/loader.gif'),
        ),
        array(
            'id' => 'dwt_listing_spinner-text',
            'type' => 'text',
            'title' => esc_html__('Spinner Text', 'dwt-listing'),
            'desc' => esc_html__('Leave empty if you want to show default', 'dwt-listing'),
            'required' => array('dwt_listing_site-spinner', '=', true),
            'default' => esc_html__('Please Wait', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Logo', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('Upload main logo of the website.', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/logo-white.png'),
        ),
        array(
            'id' => 'dwt_listing_logo-transparent',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Transparent Logo', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('Upload transparent logo of the website.', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/logo-white.png'),
        ),
        array(
            'id' => 'dwt_listing_sticky-header',
            'type' => 'switch',
            'title' => esc_html__('Sticky Menu', 'dwt-listing'),
            'default' => false,
            'required' => array('dwt_listing_header-layout', '!=', '3'),
            'desc' => esc_html__('Trun on or off sticky menu', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_header-btn',
            'type' => 'switch',
            'title' => esc_html__('Listing Button', 'dwt-listing'),
            'default' => false,
            'desc' => esc_html__('Trun on or off lisitng button in header', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_header-text',
            'type' => 'text',
            'title' => esc_html__('Listing Button', 'dwt-listing'),
            'desc' => esc_html__('Enter button text for header', 'dwt-listing'),
            'default' => 'Add Listing',
            'required' => array('dwt_listing_header-btn', '=', true),
        ),
        array(
            'id' => 'dwt_listing_header-bg',
            'type' => 'background',
            'title' => esc_html__('Breadcrumb Background', 'dwt-listing'),
            'desc' => esc_html__('You can set the Breadcrumb BG image here', 'dwt-listing'),
            'default' => array(
                'background-image' => trailingslashit(get_template_directory_uri()) . 'assets/images/collage.jpg',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position' => 'center center',
                'background-attachment' => 'fixed'
            ),
            'required' => array('dwt_listing_header-layout', '!=', '3'),
        ),
        array(
            'id' => 'dwt_listing_header-page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Listing Post Page', 'dwt-listing'),
            'desc' => esc_html__('Select add listing page.', 'dwt-listing'),
            'default' => '#',
            'required' => array('dwt_listing_header-btn', '=', true),
        ),
        array(
            'id' => 'dwt_listing_faqs-page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Termsss & Conditons Page', 'dwt-listing'),
            'desc' => esc_html__('Term & Conditons or FAQS page.', 'dwt-listing'),
            'default' => '#',
        ),
        array(
            'id' => 'dwt_listing_sell_it_for_me',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => __('Sell It For Me', 'dwt-listing'),
            'required' => array('dwt_listing_profile-dashboard', '=', array('1')),
            'default' => array('3819'),
        ),
        array(
            'id' => 'dwt_listing_disable_edit',
            'type' => 'switch',
            'title' => esc_html__('For Theme Demo Purpose Only', 'dwt-listing'),
            'desc' => esc_html__("Don't enable this option on live site (It's only for demo purpose.)", 'dwt-listing'),
            'subtitle' => '',
            'default' => '0',
            'on' => esc_html__('Demo Purpose', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_disable_submission',
            'type' => 'switch',
            'title' => esc_html__('Frontend Submission', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_disable_header_text',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'dwt-listing'),
            'desc' => esc_html__('Enter button text for header', 'dwt-listing'),
            'default' => 'View All Listings',
            'required' => array('dwt_listing_disable_submission', '=', array('0')),
        ),
        array(
            'id' => 'dwt_listing_disable_after_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('View All Listing', 'dwt-listing'),
            'desc' => esc_html__('All listing page', 'dwt-listing'),
            'required' => array('dwt_listing_disable_submission', '=', array('0')),
            'default' => '#',
        ),
    )
));