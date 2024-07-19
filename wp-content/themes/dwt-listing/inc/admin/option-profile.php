<?php
if (!defined('ABSPATH'))
    exit;
Redux::set_section($opt_name, array(
    'title' => __('Profile Settings', 'dwt-listing'),
    'id' => 'profile-settings',
    'desc' => __('Here you can setup the profile settings', 'dwt-listing'),
    'customizer_width' => '400px',
    'icon' => 'el el-user',
    'fields' => array(
        array(
            'id' => 'dwt_listing_enable_leads',
            'type' => 'switch',
            'title' => __('Track User Lead Activities', 'dwt-listing'),
            'desc' => __('Do you want to track user all activities?.', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_leads_per_page',
            'type' => 'spinner',
            'title' => __('Leads Per Page', 'dwt-listing'),
            'subtitle' => __('Leads pagination', 'dwt-listing'),
            'default' => '10',
            'min' => '1',
            'step' => '1',
            'max' => '100',
        ),
        array(
            'id' => 'dwt_listing_show_pkg',
            'type' => 'switch',
            'title' => __('Show Package Info', 'dwt-listing'),
            'desc' => __('Do you want to Show package info at profile sidebar?.', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_show_remaining_pkg',
            'type' => 'switch',
            'title' => __('Show Package Remaining Info', 'dwt-listing'),
            'desc' => __('Do you want to Show package info at profile sidebar?.', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_packages',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Package Page Link', 'dwt-listing'),
            'required' => array('dwt_listing_show_pkg', '=', '1'),
        ),
    )
));