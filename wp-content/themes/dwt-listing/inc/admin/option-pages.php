<?php if ( ! defined( 'ABSPATH' ) ) exit;
// -> START Basic Fields
    Redux::set_section( $opt_name, array(
        'title'            => __( 'Theme Essential Pages', 'dwt-listing' ),
        'id'               => 'theme_essential',
        'desc'             => __( 'Here you can setup theme pages settings', 'dwt-listing' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-user',
        'fields'           => array(
		
		 array(
                'id'       => 'dwt_listing_new_user_email_verification',
				'type'     => 'switch',
                'title'    => __( 'New user email verification', 'dwt-listing' ),
                'default'  => false,
				'desc'		=> __( 'If verfication on then please update your new user email template by verification link.', 'dwt-listing' ),
            ),
			array(
                'id'       => 'admin_contact_page',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => false,
                'title'    => __( 'Contact to Admin', 'dwt-listing' ),
				'required' => array( 'dwt_listing_new_user_email_verification', '=', array( '1' ) ),
                'desc'     => __( 'Select the page if verification email is not sent to new user.', 'dwt-listing' ),
            ),
			
			array(
                'id'       => 'dwt_listing_new_user_email_to_admin',
				'type'     => 'switch',
                'title'    => __( 'New User Email to Admin', 'dwt-listing' ),
                'default'  => true
            ),
		 array(
                'id'       => 'dwt_listing_new_user_email_to_user',
				'type'     => 'switch',
                'title'    => __( 'Welcome Email to User', 'dwt-listing' ),
                'default'  => true
            ),
		
		array(
                'id'       => 'dwt_listing_profile-dashboard',
                'type'     => 'button_set',
                'title'    => __( 'Menu Dashboard', 'dwt-listing' ),
                'desc'     => __( 'Do you want to show profile dashboard in menu?.', 'dwt-listing' ),
                'options'  => array(
                    '1' => __( 'Yes', 'dwt-listing' ),
                    '2' => __( 'No', 'dwt-listing' ),
                ),
                'default'  => '2'
            ),	
			
		array(
                'id'       => 'dwt_listing_profile-page',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => false,
                'title'    => __( 'Profile Page', 'dwt-listing' ),
				'required' => array( 'dwt_listing_profile-dashboard', '=', array( '1' ) ),
				'default'  =>  array('1917'),
            ),	
			
			array(
                'id'       => 'dwt_listing_profile_edit',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Profile Edit Page', 'dwt-listing' ),
				'required' => array( 'dwt_listing_profile-dashboard', '=', array( '1' ) ),
				'default'  =>  array('1920'),
            ),
			
            array(
                'id'       => 'dwt_listing_user-default-image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Default Image', 'dwt-listing' ),
                'compiler' => 'true',
                'desc'     => __( 'Select user default image here', 'dwt-listing' ),
				'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'assets/images/users/1.jpg' ),
            ),	
			
			
        )

    ) );