<?php
if (!defined('ABSPATH'))
    exit;
/* ------------------Blog Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Packages Text', 'dwt-listing'),
    'id' => 'dwt_listing_pkg_txt',
    'desc' => '',
    'icon' => 'el el-text-height',
    'fields' => array(
        array(
            'id' => 'd_pakge_indent',
            'type' => 'section',
            'indent' => true,
        ),
        array(
            'id' => 'd_p_exp',
            'type' => 'text',
            'title' => esc_html__('Package Expiry Title', 'dwt-listing'),
            'default' => 'Package Expiry',
        ),
        /* ====== */
        array(
            'id' => 'd_l_exp',
            'type' => 'text',
            'title' => esc_html__('Listing Expiry Title', 'dwt-listing'),
            'default' => 'Listing Expiry',
        ),
        /* ====== */
        array(
            'id' => 'd_reg_listing',
            'type' => 'text',
            'title' => esc_html__('Regular Listing Title', 'dwt-listing'),
            'default' => 'Regular Listing',
        ),
        array(
            'id' => 'd_feat_listing',
            'type' => 'text',
            'title' => esc_html__('Featured Listing Title', 'dwt-listing'),
            'default' => 'Featured Listing',
        ),
        array(
            'id' => 'd_feat_for',
            'type' => 'text',
            'title' => esc_html__('Featured For Title', 'dwt-listing'),
            'default' => 'Featured For',
        ),
        array(
            'id' => 'd_vid_listing',
            'type' => 'text',
            'title' => esc_html__('Video Listing Title', 'dwt-listing'),
            'default' => 'Video Listing',
        ),
        array(
            'id' => 'd_web_link',
            'type' => 'text',
            'title' => esc_html__('Website Link Title', 'dwt-listing'),
            'default' => 'Website Link',
        ),
        array(
            'id' => 'd_no_images',
            'type' => 'text',
            'title' => esc_html__('No of Images Title', 'dwt-listing'),
            'default' => 'No of Images',
        ),
        array(
            'id' => 'd_p_range',
            'type' => 'text',
            'title' => esc_html__('Price Range Title', 'dwt-listing'),
            'default' => 'Price Range',
        ),
        array(
            'id' => 'd_b_hours',
            'type' => 'text',
            'title' => esc_html__('Business Hours Title', 'dwt-listing'),
            'default' => 'Business Hours',
        ),
        array(
            'id' => 'd_llow_tag',
            'type' => 'text',
            'title' => esc_html__('Allow Tags Title', 'dwt-listing'),
            'default' => 'Allow Tags',
        ),
        array(
            'id' => 'd_bump_listing',
            'type' => 'text',
            'title' => esc_html__('Bump Listing Title', 'dwt-listing'),
            'default' => 'Bump Listing',
        ),
        array(
            'id' => 'd_coupon_code',
            'type' => 'text',
            'title' => esc_html__('Coupon Code Title', 'dwt-listing'),
            'default' => 'Allow Coupon Code',
        ),
        array(
            'id' => 'd_create_event',
            'type' => 'text',
            'title' => esc_html__('Create Event Title', 'dwt-listing'),
            'default' => 'Create Event',
        ),
        array(
            'id' => 'd_pakge_other_text',
            'title' => esc_html__('Other Text', 'dwt-listing'),
            'type' => 'section',
            'indent' => true,
        ),
        array(
            'id' => 'd_pkg_daytxt',
            'type' => 'text',
            'title' => esc_html__('Days Option Text', 'dwt-listing'),
            'default' => 'Days',
        ),
        array(
            'id' => 'd_pkg_unlimited',
            'type' => 'text',
            'title' => esc_html__('Unlimited Option Text', 'dwt-listing'),
            'default' => 'Unlimited',
        ),
        array(
            'id' => 'd_never_exp',
            'type' => 'text',
            'title' => esc_html__('Never Expire Option Text', 'dwt-listing'),
            'default' => 'Never Expire',
        ),
        array(
            'id' => 'd_pkg_yes',
            'type' => 'text',
            'title' => esc_html__('Yes Option Text', 'dwt-listing'),
            'default' => 'Yes',
        ),
        array(
            'id' => 'd_pkg_no',
            'type' => 'text',
            'title' => esc_html__('No Option Text', 'dwt-listing'),
            'default' => 'No',
        ),
    )
));