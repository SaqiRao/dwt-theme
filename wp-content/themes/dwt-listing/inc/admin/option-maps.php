<?php if ( ! defined( 'ABSPATH' ) ) exit;
	/* ------------------ Geo APi Settings ----------------------- */
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Map Settings', 'dwt-listing' ),
        'id'         => 'dwt-map-settings',
        'desc'       => '',
        'icon' => 'el el-globe',
        'fields'     => array(
			array(
                'id'       => 'dwt_listing_enable_map',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Map', 'dwt-listing' ),
                'default'  => true,
				'desc'     => esc_html__( 'Trun on or off Maps.', 'dwt-listing' ),
            ),	
          array(
                'id'       => 'dwt_map_selection',
                'type'     => 'select',
                'title'    => esc_html__( 'Select Map Type ', 'dwt-listing' ),
				'options'  => array(
					'open_street' => 'Open Street',
					'google_map' => 'Google Maps',
				),
				'required' => array( 'dwt_listing_enable_map', '=', true ),
				'default'  => 'open_street',			
            ),
		
            array(
                'id'    => 'dwt_listing_options_notification',
                'type'  => 'info',
                'style' => 'warning',
				'required' => array( 'dwt_map_selection', '=', 'google_map' ),
                'title' => __( 'Google Notification.', 'dwt-listing' ),
                'desc'  => __( 'Google <strong>maps & places</strong> will only works when you have an API key.<a href="https://developers.google.com/places/web-service/usage-and-billing" target="_blank">Google Notification</a>', 'dwt-listing' )
            ),

		 array(
					'id'       => 'gmap_api_key',
					'type'     => 'text',
					'title'    => esc_html__( 'Google Map API Key', 'dwt-listing' ),
					'desc' => dwt_listing_make_link ( 'https://developers.google.com/maps/documentation/javascript/get-api-key' , esc_html__( 'How to Find it' , 'dwt-listing' ) ),
					'required' => array( 'dwt_map_selection', '=', 'google_map' ),
					'subtitle' => esc_html__( 'Google Map & search only works when you entered Google API Key', 'dwt-listing' ),
					'default'  => 'AIzaSyB_La6qmewwbVnTZu5mn3tVrtu6oMaSXaI',
			),
			
			array(
                'id'       => 'dwt_listing_enable_long_lat',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Longitude and Longitude', 'dwt-listing' ),
                'default'  => true,
				'desc'     => esc_html__( 'Trun on or off Latitude and Longitude.', 'dwt-listing' ),
				'required' => array( 'dwt_listing_enable_map', '=', true ),

            ),	
			
			array(
                'id'       => 'dwt_listing_default_lat',
                'type'     => 'text',
                'title'    => esc_html__( 'Latitude', 'dwt-listing' ),
                'subtitle' => esc_html__( 'for default map.', 'dwt-listing' ),
                'default'  => '40.7127837' ,
				'required' => array( 'dwt_listing_enable_long_lat', '=', true ),

            ),
			array(
                'id'       => 'dwt_listing_default_long',
                'type'     => 'text',
                'title'    => esc_html__( 'Longitude', 'dwt-listing' ),
                'subtitle' => esc_html__( 'for default map.', 'dwt-listing' ),
				'required' => array( 'dwt_listing_enable_long_lat', '=', true ),
                'default'  => '-74.00594130000002' ,
            ),	
			
			
        )
    ) );	