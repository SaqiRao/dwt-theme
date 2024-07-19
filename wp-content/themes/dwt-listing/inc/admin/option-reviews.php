<?php
if (!defined('ABSPATH'))
    exit;

/* ------------------ Listing Comments Reviews ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Listing Reviews', 'dwt-listing'),
    'id' => 'sb-blog-settingss',
    'desc' => '',
    'icon' => 'el el-star-empty',
    'fields' => array(
        array(
            'id' => 'dwt_listing_review_send_email',
            'type' => 'switch',
            'title' => esc_html__('Send Email On Review', 'dwt-listing'),
            'subtitle' => esc_html__('Send email when there is a new comment', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_review_reply_email',
            'type' => 'switch',
            'title' => esc_html__('Send Email On Review Reply', 'dwt-listing'),
            'subtitle' => esc_html__('Send email on reply', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_review_rating_limit',
            'type' => 'switch',
            'title' => esc_html__('Review Rating Limit', 'dwt-listing'),
            'desc' => esc_html__('On means user cant rate more than one times on same listing', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_review_permission',
            'type' => 'button_set',
            'title' => esc_html__('Reviews Approved By', 'dwt-listing'),
            'options' => array(
                '1' => esc_html__('Auto Approve', 'dwt-listing'),
                '0' => esc_html__('Admin Approve', 'dwt-listing'),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'dwt_listing_review_enable_stars',
            'type' => 'switch',
            'title' => esc_html__('Enable Review Stars', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_review_enable_gallery',
            'type' => 'switch',
            'title' => esc_html__('Enable Review Gallery', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_review_enable_emoji',
            'type' => 'switch',
            'title' => esc_html__('Enable Review Reactions', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_review_upload_limit',
            'type' => 'select',
            'title' => esc_html__('Comment Gallery Limit', 'dwt-listing'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'required' => array('dwt_listing_review_enable_gallery', '=', true),
            'default' => 5,
        ),
        array(
            'id' => 'dwt_listing_review_images_size',
            'type' => 'select',
            'title' => __('Image Upload Size', 'dwt-listing'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB', '6291456-6MB' => '6MB', '7340032-7MB' => '7MB', '8388608-8MB' => '8MB', '9437184-9MB' => '9MB', '10485760-10MB' => '10MB', '11534336-11MB' => '11MB', '12582912-12MB' => '12MB', '13631488-13MB' => '13MB', '14680064-14MB' => '14MB', '15728640-15MB' => '15MB', '20971520-20MB' => '20MB', '26214400-25MB' => '25MB'),
            'required' => array('dwt_listing_review_enable_gallery', '=', true),
            'default' => '2097152-2MB',
        ),
        array(
            'id' => 'review_limit_listing_page',
            'type' => 'text',
            'title' => __('Reviews Limit On Listing Page', 'dwt-listing'),
            'subtitle' => __('This must be numeric.', 'dwt-listing'),
            'validate' => 'numeric',
            'default' => '5',
            'desc' => __('-1 means all reviews/comments without pagination.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_allreview_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('All Reviews Page', 'dwt-listing'),
            'desc' => __('Select review page.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_review_limit_btn_text',
            'type' => 'text',
            'title' => __('All Reviews Button Text', 'dwt-listing'),
            'default' => __('View All Reviews', 'dwt-listing'),
            'desc' => __('button title for reviews/comments', 'dwt-listing'),
            'validate' => 'not_empty',
        ),
        array(
            'id' => 'dwt_listing_review_all_pagination_limit',
            'type' => 'text',
            'title' => __('Reviews Pagination Limit', 'dwt-listing'),
            'subtitle' => __('This must be numeric.', 'dwt-listing'),
            'validate' => 'numeric',
            'default' => '8',
            'desc' => __('-1 means all reviews/comments without pagination.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_enable_names',
            'type' => 'switch',
            'title' => esc_html__('Enable Review User Titles', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_review_taglines_limit',
            'type' => 'text',
            'title' => __('Tagline for Limit', 'dwt-listing'),
            'subtitle' => __('for review', 'dwt-listing'),
            'desc' => __('Element shoud be number separate by | eg 20|40', 'dwt-listing'),
            'default' => '20|40|60|80',
            'required' => array('dwt_listing_enable_names', '=', true),
        ),
        array(
            'id' => 'dwt_listing_review_taglines_titles',
            'type' => 'text',
            'title' => __('Tagline for User', 'dwt-listing'),
            'subtitle' => __('for review', 'dwt-listing'),
            'desc' => __('Element shoud be number separate by | eg Rookie|Amateur', 'dwt-listing'),
            'default' => 'Rookie|Amateur|Elite|Professional',
            'required' => array('dwt_listing_enable_names', '=', true),
        ),
        array(
            'id' => 'dwt_listing_show_total_ratings',
            'type' => 'switch',
            'title' => esc_html__('Show user total ratings', 'dwt-listing'),
            'default' => true,
        ),
    )
));