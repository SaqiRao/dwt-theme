<?php 
if (!defined('ABSPATH'))
exit;
// Options for Listing comparison 
Redux::set_section( $opt_name, array(
    'title'  => esc_html__( 'Compare Listings', 'dwt-listing' ),
    'id'     => 'mw_compare',
    'desc'   => '',
    'subsection' => false,
    'fields' => array(
        array(
            'id'       => 'mw_compare_tagline',
            'type'     => 'text',
            'title'    => esc_html__( 'Tagline', 'dwt-listing' ),
            'default' => esc_html__('Spot the difference', 'dwt-listing'),
        ),
		array(
            'id'       => 'mw_compare_heading',
            'type'     => 'text',
            'title'    => esc_html__( 'Heading', 'dwt-listing' ),
            'default' => esc_html__('Compare Listing', 'dwt-listing'),
        ),
        array(
            'id'       => 'mw_empty_list',
            'type'     => 'text',
            'title'    => esc_html__( 'Empty List Message', 'dwt-listing' ),
            'default' => esc_html__('Add listings to compare.', 'dwt-listing'),
        ),
        array(
            'id'       => 'mw_empty_msg',
            'type'     => 'text',
            'title'    => esc_html__( 'Empty Page Message', 'dwt-listing' ),
            'default' => esc_html__('Please select more than one listing to compare.', 'dwt-listing'),
        ),
    )
));