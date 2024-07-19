<?php
if (!defined('ABSPATH'))
    exit;

/* -> START Basic Fields */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Footer Settings', 'dwt-listing'),
    'id' => 'footer-settings',
    'subsection' => false,
    'customizer_width' => '450px',
    'fields' => array(
        array(
            'id' => 'dwt_listing_footer-layout',
            'type' => 'image_select',
            'title' => esc_html__('Footer Layout', 'dwt-listing'),
            'desc' => esc_html__('Select footer Layout you want to show. Footer 5 only use with Elementor Pro.', 'dwt-listing'),
            'options' => array(
                '1' => array(
                    'alt' => esc_html__('Layout Type 1', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/f1.png'
                ),
                '2' => array(
                    'alt' => esc_html__('Layout Type 2', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/f2.png'
                ),
                '3' => array(
                    'alt' => esc_html__('Layout Type 3', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/f3.png'
                ),
                '4' => array(
                    'alt' => esc_html__('Layout Type 4', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/f4.png'
                ),
                '5' => array(
                    'alt' => esc_html__('Layout Type only for Elementor', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/f5.png'
                )
            ),
            'default' => '4'
        ),
        array(
            'id' => 'dwt_listing_footer-logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Footer Logo', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('Upload main logo of the website.', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/logo-white.png'),
        ),
        array(
            'id' => 'dwt_listing_pop_loc',
            'type' => 'text',
            'title' => esc_html__('Popular Locations', 'dwt-listing'),
            'desc' => esc_html__('Enter section title here', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '=', '4'),
            'default' => esc_html__('Popular Locations', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_getpop_loc',
            'type' => 'select',
            'title' => __('Select Locations', 'dwt-listing'),
            'multi' => true,
            'data' => 'terms',
            'args' => array(
                'taxonomy' => 'l_location', 'hide_empty' => false,
            ),
            'required' => array('dwt_listing_footer-layout', '=', '4'),
        ),
        array(
            'id' => 'dwt_listing_pop_catz',
            'type' => 'text',
            'title' => esc_html__('Top Categories', 'dwt-listing'),
            'desc' => esc_html__('Enter section title here', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '=', '4'),
            'default' => esc_html__('Featured Categories', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_getpop_catz',
            'type' => 'select',
            'title' => __('Select Category', 'dwt-listing'),
            'multi' => true,
            'sortable' => true,
            'data' => 'terms',
            'args' => array('taxonomy' => 'l_category', 'hide_empty' => false,),
            'required' => array('dwt_listing_footer-layout', '=', '4'),
        ),
        array(
            'id' => 'dwt_listing_footer-text',
            'type' => 'textarea',
            'title' => esc_html__('Footer Text', 'dwt-listing'),
            'subtitle' => esc_html__('All HTML will be stripped', 'dwt-listing'),
            'desc' => esc_html__('This is the description field, again good for additional info.', 'dwt-listing'),
            'validate' => 'no_html',
            'required' => array('dwt_listing_footer-layout', '!=', '1'),
            'default' => esc_html__('Cu qui probo malorum saperet. Ne admodum apeirian iracundia usu, eam cu agam ludus, eum munere accusam molestie ut. Alienum percipitur ne est, pri quando iriure ad. Alienum percipitur ne est, pri quando iriure ad. Alienum percipitur ne est, pri quando iriure ad.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_footer-links-text',
            'type' => 'text',
            'title' => esc_html__('Links Title', 'dwt-listing'),
            'desc' => esc_html__('Enter section title here', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '!=', '1'),
            'default' => esc_html__('Quick Links', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_footer-pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'title' => esc_html__('Select Option', 'dwt-listing'),
            'desc' => esc_html__('Select the links for the footer.', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '!=', '1'),
        ),
        array(
            'id' => 'dwt_listing_footer-posts-text',
            'type' => 'text',
            'title' => esc_html__('Recent Posts', 'dwt-listing'),
            'desc' => esc_html__('Enter section title here', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '=', '3'),
            'default' => esc_html__('Recent Posts', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_footer-posts',
            'type' => 'select',
            'data' => 'posts',
            'multi' => true,
            'title' => esc_html__('Select Posts', 'dwt-listing'),
            'desc' => esc_html__('Select posts for the footer.', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '=', '3'),
        ),
        array(
            'id' => 'dwt_listing_footer-address-tile',
            'type' => 'text',
            'title' => esc_html__('Contact Information', 'dwt-listing'),
            'desc' => esc_html__('Enter section title here', 'dwt-listing'),
            'required' => array('dwt_listing_footer-layout', '=', '3'),
            'default' => esc_html__('Contact Information', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_footer-address',
            'type' => 'sortable',
            'title' => esc_html__('Address Info', 'dwt-listing'),
            'desc' => esc_html__('Leave empty if you don\' want to show.', 'dwt-listing'),
            'label' => true,
            'options' => array(
                'address' => '#',
                'email' => '#',
                'phone' => '#',
                'clock' => '#',
            ),
            'default' => array('address' => esc_html__('B-Floor,Arcade Model Town, USA', 'dwt-listing'), 'email' => 'contact@scriptsbundle.com', 'phone' => '(0092)+ 124 45 78 678 ', 'clock' => esc_html__('Mon - Sun: 8:00 - 16:00', 'dwt-listing')),
            'required' => array('dwt_listing_footer-layout', '=', '3'),
        ),
        array(
            'id' => 'dwt_listing_footer-copyrights',
            'type' => 'editor',
            'title' => esc_html__('Copy Rights Text', 'dwt-listing'),
            'default' => esc_html__('Copyright 2018 &copy; Theme Created By ScriptsBundle, All Rights Reserved.', 'dwt-listing'),
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 4,
                'teeny' => false,
                'quicktags' => false,
            )
        ),
        array(
            'id' => 'dwt_listing_footer-bg1',
            'type' => 'background',
            'title' => esc_html__('Footer Background', 'dwt-listing'),
            'subtitle' => esc_html__('Footer background with image, color, etc.', 'dwt-listing'),
            'desc' => esc_html__('You can set the footer BG image here', 'dwt-listing'),
            'default' => array(
                'background-image' => trailingslashit(get_template_directory_uri()) . 'assets/images/footer.jpg',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position' => 'left top',
                'background-attachment' => 'fixed'
            ),
            'required' => array('dwt_listing_footer-layout', '=', '1'),
        ),
        array(
            'id' => 'dwt_listing_footer-social-media',
            'type' => 'sortable',
            'title' => esc_html__('Social Media', 'dwt-listing'),
            'desc' => esc_html__('Social Icons For Foter. You can sort it out as you want.', 'dwt-listing'),
            'label' => true,
            'options' => array(
                'Facebook' => '',
                'Twitter' => '',
                'Linkedin' => '',
                'Google' => '',
                'YouTube' => '',
                'Vimeo' => '',
                'TikTok' => '',
                'Pinterest' => '',
                'Tumblr' => '',
                'Instagram' => '',
                'Reddit' => '',
                'Flickr' => '',
                'StumbleUpon' => '',
                'Delicious' => '',
                'dribble' => '',
                'behance' => '',
                'DeviantART' => '',
            ),
            'default' => array('Facebook' => '#', 'Twitter' => '#', 'Linkedin' => '#', 'Google' => '#', 'YouTube' => '#', 'TikTok' => '#'),
        ),
        array(
            'id' => 'dwt_listing_layout-sorter',
            'type' => 'sorter',
            'title' => 'Footer Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the homepage',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('logo' => 'Logo & Desc ', 'quciklinks' => 'Quick Links'),
            ),
            'required' => array('dwt_listing_footer-layout', '=', '2'),
        ),
        array(
            'id' => 'dwt_listing_layout-sorter-3',
            'type' => 'sorter',
            'title' => 'Footer Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the homepage',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('logo' => 'Your Details ', 'quciklinks' => 'Quick Links', 'post' => 'Blog Post', 'info' => 'Contact Info'),
            ),
            'required' => array('dwt_listing_footer-layout', '=', '3'),
        ),
        array(
            'id' => 'dwt_listing_layout-sorter-4',
            'type' => 'sorter',
            'title' => 'Footer Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the homepage',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('logo' => 'Your Details ', 'countries' => 'Popular Countries', 'cats' => 'Categories', 'links' => 'Quick Links'),
            ),
            'required' => array('dwt_listing_footer-layout', '=', '4'),
        ),
    )
));