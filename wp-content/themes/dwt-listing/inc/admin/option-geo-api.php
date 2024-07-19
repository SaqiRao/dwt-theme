<?php if ( ! defined( 'ABSPATH' ) ) exit;
	/* ------------------ Geo APi Settings ----------------------- */
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Geo IP Settings', 'dwt-listing' ),
        'id'         => 'dwt-geo-settings',
        'desc'       => '',
        'icon' => 'el el-map-marker',
        'fields'     => array(
			array(
                'id'       => 'dwt_listing_enable_geo',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable GeoLocation', 'dwt-listing' ),
                'default'  => true,
				'desc'     => esc_html__( 'Trun on or off GeoLocation Api.', 'dwt-listing' ),
            ),	
          array(
                'id'       => 'dwt_geo_api_settings',
                'type'     => 'select',
                'title'    => esc_html__( 'Select API Type for Current location ', 'dwt-listing' ),
                'subtitle' => esc_html__( 'For location detection', 'dwt-listing' ),
                'desc'     => __('Above API options are used to identify visitors current location by their ip address.', 'dwt-listing'),
				'options'  => array(
					'geo_ip' => 'Geo IP DB',
					'ip_api' => 'IP API',
				),
				'required' => array( 'dwt_listing_enable_geo', '=', true ),
				'default'  => 'geo_ip',			
            ),
        )
    ) );	