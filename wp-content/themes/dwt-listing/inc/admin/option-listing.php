<?php
if (!defined('ABSPATH'))
    exit;

/* ------------------ Listing Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Listing Settings', 'dwt-listing'),
    'id' => 'dwt_listing_ad_listing',
    'desc' => '',
    'icon' => 'el el-adjust-alt',
));

/* *******************
   Listing General
   ******************* */
Redux::set_section($opt_name, array(
    'title' => esc_html__('General Settings', 'dwt-listing'),
    'id' => 'dwt_listing_ad_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_title_limit',
            'type' => 'text',
            'title' => __('Title Limit During Listing', 'dwt-listing'),
            'subtitle' => __('This must be numeric.', 'dwt-listing'),
            'desc' => __('Total number of characters', 'dwt-listing'),
            'validate' => 'numeric',
            'default' => '45',
        ),
        array(
            'id' => 'wo_pack_approve',
            'type' => 'button_set',
            'title' => esc_html__('Packages Order Approved By', 'dwt-listing'),
            'options' => array(
                '1' => esc_html__('Auto Approve', 'dwt-listing'),
                '2' => esc_html__('Admin Approve', 'dwt-listing'),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'dwt_listing_allow_loc',
            'type' => 'switch',
            'title' => esc_html__('Allowed all countries', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'sell-for-me',
            'type' => 'switch',
            'title' => esc_html__('Sell For Me', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_allowed_loc',
            'type' => 'select',
            'options' => dwt_listing_get_all_countries(),
            'multi' => true,
            'title' => esc_html__('Select Countries', 'dwt-listing'),
            'required' => array('dwt_listing_allow_loc', '=', array('0')),
            'desc' => esc_html__('You can select max 5 countries as per GOOGLE limit.', 'dwt-listing') . ' ' . dwt_listing_make_link('https://developers.google.com/maps/documentation/javascript/3.exp/reference#ComponentRestrictions', esc_html__('Read More', 'dwt-listing')),
        ),
        array(
            'id' => 'dwt_listing_gmap_lang',
            'type' => 'text',
            'title' => esc_html__('Google map language', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://developers.google.com/maps/faq#languagesupport', esc_html__('List of available languages', 'dwt-listing')),
            'default' => 'en',
        ),
        array(
            'id' => 'dwt_listing_show_street_view',
            'type' => 'switch',
            'title' => esc_html__('Show street view on map listing', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://en.wikipedia.org/wiki/Coverage_of_Google_Street_View', esc_html__('List of countries available street views', 'dwt-listing')),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_ad_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval'),
            'title' => esc_html__('Listing Approval', 'dwt-listing'),
            'default' => 'auto',
        ),
        array(
            'id' => 'dwt_listing_up_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval'),
            'title' => esc_html__('Listing Update Approval', 'dwt-listing'),
            'default' => 'auto',
        ),
        array(
            'id' => 'dwt_listing_email_on_listing',
            'type' => 'switch',
            'title' => esc_html__('Send email on Listing Post', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_email_listngs_expire',
            'type' => 'switch',
            'title' => __('Listing Expiry Email', 'dwt-listing'),
            'default' => false,
            'desc' => __('Turn On if you send email on Listing Expire', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_get_listing_email',
            'type' => 'text',
            'title' => esc_html__('Email for notification.', 'dwt-listing'),
            'required' => array('dwt_listing_email_on_listing', '=', '1'),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'email_on_ad_approval',
            'type' => 'switch',
            'title' => esc_html__('Email to Listing owner on approval', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'enable_report_option',
            'type' => 'switch',
            'title' => esc_html__('Enable report listing', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'report_options',
            'type' => 'text',
            'title' => esc_html__('Report Listing Options', 'dwt-listing'),
            'default' => 'Spam|Offensive|Duplicated|Fake',
            'required' => array('enable_report_option', '=', '1'),
        ),
        array(
            'id' => 'report_limit',
            'type' => 'text',
            'title' => esc_html__('Listing Report Limit', 'dwt-listing'),
            'desc' => esc_html__('Only integer value without spaces.', 'dwt-listing'),
            'default' => 50,
        ),
        array(
            'id' => 'report_action',
            'type' => 'select',
            'title' => esc_html__('Action on Listing Report Limit', 'dwt-listing'),
            'options' => array(1 => 'Auto Inactive', 2 => 'Email to Admin'),
            'default' => 2,
        ),
        array(
            'id' => 'report_email',
            'type' => 'text',
            'title' => esc_html__('Email', 'dwt-listing'),
            'desc' => esc_html__('Email where you want to get notify.', 'dwt-listing'),
            'required' => array('report_action', '=', array(2)),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'dwt_listing_is_claim',
            'type' => 'switch',
            'title' => esc_html__('Want To Enable Claim Option', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_is_admin_email',
            'type' => 'switch',
            'title' => esc_html__('Email To Admin', 'dwt-listing'),
            'required' => array(array('dwt_listing_is_claim', '=', '1')),
            'default' => true,
        ),
        array(
            
            'id' => 'dwt_listing_booking_time_kit',
            'type' => 'switch',
            'title' => __('Booking With Time Kit', 'dwt-listing'),
            'default' => false,
            'desc' => __('Turn off Timekit to enable Custom appointment system.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_booking_reservation',
            'type' => 'switch',
            'title' => __('Make a Custom Booking / Appointment', 'dwt-listing'),
            'default' => false,
            'desc' => __('Please turn time kit booking off to make custom booking on', 'dwt-listing'),
            'required' => array('dwt_listing_booking_time_kit', '!=', array('1')),
        ),
        array(
            'id' => 'dwt_listing_defualt_listing_image',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Listing Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of listing then this will be show.', 'dwt-listing'),
            'subtitle' => esc_html__('Dimensions: 300 x 225', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/no-image.png'),
        ),

        array(
            'id' => 'Appointment_paid_booking',
            'type' => 'switch',
            'title' => __('Listing Booking Paid / Appointment Paid', 'dwt-listing'),
            'default' => false,
            'desc' => __('Please turn time kit booking off to make custom booking on', 'dwt-listing'),
            'required' => array('dwt_listing_booking_time_kit', '!=', array('1')),
        ),

        array(
            'id' => 'booking_commission_from',
            'type' => 'switch',
            'title' => esc_html__('Admin Commission', 'dwt-listing'),
            'default' => false,
            'required' => array('Appointment_paid_booking', '=', true),    
        ),

        array(
            'id'            => 'service_charges_listing',
            'type'          => 'slider',
            'title'         => __( 'Select Percentage to deduct', 'dwt-listing' ),
            'subtitle'      => __( 'select here to deduct from authors or users.', 'dwt-listing' ),
            'desc'          => __( 'Min: 0, max: 100 %,', 'dwt-listing' ),
            'default'       => 0,
            'min'           => 0,
            'step'          => 1,
            'max'           => 100,
            'display_value' => 'label',
           'required' => array('Appointment_paid_booking', '=', true),

        ),
        array(
            'id' => 'listing_custom_deposit_package',
            'type' => 'select',
            'data' => 'callback',
            'title' => esc_html__('Select Custom Product for Services', 'dwt-listing'),
            'args' => 'service_packages_callback_function',
            'required' => array('Appointment_paid_booking', '=', '1'),
        ),

        array(
            'id' => 'enable_chat_option',
            'type' => 'switch',
            'title' => esc_html__('Enable Chat option for listing', 'dwt-listing'),
            'default' => false,
        ),

        // array(
        //     'id' => 'wallet_custom_deposit_package',
        //     'type' => 'select',
        //     'data' => 'callback',
        //     'title' => esc_html__('Select Package for custom product', 'dwt-listing'),
        //     'args' => 'wallet_packages_callback_function',
        // ),
    )
));

/* * ********************
 * Listing Post
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Post Listing Settings', 'dwt-listing'),
    'id' => 'dwt_listing_submit_listing',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_standard_images_size',
            'type' => 'switch',
            'title' => esc_html__('Strict Image Mode', 'dwt-listing'),
            'subtitle' => esc_html__('Not allowed image less than 750x450 dimenstions', 'dwt-listing'),
            'desc' => esc_html__('750x450 image dimenstions required to fit everywhere on web', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_image_up_size',
            'type' => 'select',
            'title' => esc_html__('Listing image max size', 'dwt-listing'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB', '6291456-6MB' => '6MB', '7340032-7MB' => '7MB', '8388608-8MB' => '8MB', '9437184-9MB' => '9MB', '10485760-10MB' => '10MB', '11534336-11MB' => '11MB', '12582912-12MB' => '12MB', '13631488-13MB' => '13MB', '14680064-14MB' => '14MB', '15728640-15MB' => '15MB', '20971520-20MB' => '20MB', '26214400-25MB' => '25MB'),
            'default' => '2097152-2MB',
        ),
        array(
            'id' => 'dwt_listing_allow_country_location',
            'type' => 'switch',
            'title' => esc_html__('Allow Custom Country Locations', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_bad_words_filter',
            'type' => 'textarea',
            'title' => esc_html__('Bad Words Filter', 'dwt-listing'),
            'subtitle' => esc_html__('comma separated', 'dwt-listing'),
            'placeholder' => esc_html__('word1,word2', 'dwt-listing'),
            'desc' => esc_html__('This words will be removed from AD Title and Description', 'dwt-listing'),
            'default' => '',
        ),
        array(
            'id' => 'dwt_listing_bad_words_replace',
            'type' => 'text',
            'title' => esc_html__('Bad Words Replace Word', 'dwt-listing'),
            'desc' => esc_html__('This words will be replace with above bad words list from AD Title and Description', 'dwt-listing'),
            'default' => '',
        ),
        array(
            'id' => 'dwt_listing_coupon_admin_note',
            'type' => 'switch',
            'title' => esc_html__('Coupon Note', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_coupon_admin_note_desc',
            'type' => 'textarea',
            'title' => esc_html__('Coupon Admin Note Description', 'dwt-listing'),
            'placeholder' => esc_html__('Your text here', 'dwt-listing'),
            'required' => array('dwt_listing_coupon_admin_note', '=', true),
            'default' => '',
        ),
        array(
            'id' => 'dwt_listing_coupon_desc_limit',
            'type' => 'text',
            'title' => __('Coupon Descrtion Characters Limit', 'dwt-listing'),
            'subtitle' => __('This must be numeric.', 'dwt-listing'),
            'desc' => __('Total number of characters', 'dwt-listing'),
            'validate' => 'numeric',
            'required' => array('dwt_listing_coupon_admin_note', '=', true),
            'default' => '170',
        ),
        array(
            'id' => 'info_form_fields',
            'type' => 'info',
            'desc' => __('Making these form fields required or not.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_form_title_req',
            'type' => 'switch',
            'title' => esc_html__('Title Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_form_categ_req',
            'type' => 'switch',
            'title' => esc_html__('Category Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_form_phone_req',
            'type' => 'switch',
            'title' => esc_html__('Phone Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_form_siteurl_req',
            'type' => 'switch',
            'title' => esc_html__('Site Url Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_price_type_req',
            'type' => 'switch',
            'title' => esc_html__('Price Type Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_curency_req',
            'type' => 'switch',
            'title' => esc_html__('Currency Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_price_from_req',
            'type' => 'switch',
            'title' => esc_html__('Price From Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_price_to_req',
            'type' => 'switch',
            'title' => esc_html__('Price To Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_desc_req',
            'type' => 'switch',
            'title' => esc_html__('Description Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_form_email_req',
            'type' => 'switch',
            'title' => esc_html__('Email Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_form_brand_req',
            'type' => 'switch',
            'title' => esc_html__('Brand Name Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_form_location_req',
            'type' => 'switch',
            'title' => esc_html__('Location Field Required', 'dwt-listing'),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_make_feature_icon',
            'type' => 'text',
            'title' => esc_html__('Make Feature Icon', 'dwt-listing'),
            'subtitle' => __('Get Icon here : https://themify.me/themify-icons','dwt-listing'),
            'placeholder' => esc_attr('ti-help-alt'),
            'default' => 'ti-help-alt'
        ),
        array(
            'id' => 'dwt_listing_already_feature_icon',
            'type' => 'text',
            'title' => esc_html__('Already Feature Icon', 'dwt-listing'),
            'subtitle' => __('Get Icon here : https://themify.me/themify-icons','dwt-listing'),
            'placeholder' => esc_attr('ti-bell'),
            'default' => 'ti-bell'
        ),
        array(
            'id' => 'dwt_listing_bump_up_icon',
            'type' => 'text',
            'title' => esc_html__('Bump Listing Icon', 'dwt-listing'),
            'subtitle' => __('Get Icon here : https://themify.me/themify-icons','dwt-listing'),
            'placeholder' => esc_attr('ti-reload'),
            'default' => 'ti-reload'
        ),
        array(
            'id' => 'dwt_listing_login_scren_icon',
            'type' => 'text',
            'title' => esc_html__('Login Screen Icon', 'dwt-listing'),
            'subtitle' => __('Get Icon here : https://themify.me/themify-icons','dwt-listing'),
            'placeholder' => esc_attr('ti-face-sad'),
            'default' => 'ti-face-sad'
        ),
    )
));

/* * ********************
 * Listing Form Text
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Listing Form Text', 'dwt-listing'),
    'id' => 'dwt_listing_form_fields',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'd_listing_title',
            'type' => 'section',
            'title' => __('Listing Title Field', 'dwt-listing'),
            'indent' => true,
        ),
        array(
            'id' => 'dwt_listing_list_title',
            'type' => 'text',
            'title' => esc_html__('Listing Title', 'dwt-listing'),
            'default' => esc_html__('Listing Title', 'dwt-listing')
        ),
        array(
            'id' => 'dwt_listing_list_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip Title', 'dwt-listing'),
            'default' => 'Place your business name and let the world know',
        ),
        array(
            'id' => 'dwt_listing_list_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder Text', 'dwt-listing'),
            'default' => 'e.g. Hungs Continental Food',
        ),
        array(
            'id' => 'd_section-end',
            'type' => 'section',
            'indent' => false, 
        ),
        array(
            'id' => 'd_listing_tagline',
            'type' => 'section',
            'title' => __('Listing Tagline Field', 'dwt-listing'),
            'indent' => true,
        ),
        array(
            'id' => 'dwt_listing_list_tagline',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Title',
        ),
        array(
            'id' => 'dwt_listing_list_tagline_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip', 'dwt-listing'),
            'default' => 'Let people know what you are specialized in',
        ),
        array(
            'id' => 'dwt_listing_list_tagline_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'e.g. Continental food boss ',
        ),
        array(
            'id' => 'd_t-end',
            'type' => 'section',
            'indent' => false, 
        ),
        array(
            'id' => 'd_cat_title',
            'type' => 'section',
            'title' => __('Listing Category Field', 'dwt-listing'),
            'indent' => true,
        ),
        array(
            'id' => 'dwt_listing_list_category',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Select Category',
        ),
        array(
            'id' => 'dwt_listing_list_amen',
            'type' => 'text',
            'title' => esc_html__('Amenities / Subcategories', 'dwt-listing'),
            'default' => 'Amenities',
        ),
        array(
            'id' => 'dwt_listing_list_custom',
            'type' => 'text',
            'title' => esc_html__('Custom Fields', 'dwt-listing'),
            'default' => 'Additional Fields',
        ),
        array(
            'id' => 'd_cat-end',
            'type' => 'section',
            'indent' => false, 
        ),
        array(
            'id' => 'd_contact_title',
            'type' => 'section',
            'title' => __('Listing Contact No Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_contact',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Phone Number',
        ),
        array(
            'id' => 'dwt_listing_list_contact_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip', 'dwt-listing'),
            'default' => 'Listing Contact Number',
        ),
        array(
            'id' => 'dwt_listing_list_contact_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => '+99 3331 234567',
        ),
        array(
            'id' => 'd_contact-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_web_title',
            'type' => 'section',
            'title' => __('Listing Web/Url Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_web',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Website URL',
        ),
        array(
            'id' => 'dwt_listing_list_web_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip', 'dwt-listing'),
            'default' => 'Write your website address',
        ),
        array(
            'id' => 'dwt_listing_list_web_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'https://www.yourdomain.com/',
        ),
        array(
            'id' => 'd_web-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_pricing_range',
            'type' => 'section',
            'title' => __('Listing Pricing Range Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_pricetype',
            'type' => 'text',
            'title' => esc_html__('Price Type Field', 'dwt-listing'),
            'default' => 'Select Price Type',
        ),
        array(
            'id' => 'dwt_listing_list_currenct',
            'type' => 'text',
            'title' => esc_html__('Select Currency', 'dwt-listing'),
            'default' => 'Listing Currency',
        ),
        array(
            'id' => 'dwt_listing_list_price_from',
            'type' => 'text',
            'title' => esc_html__('Price Start From', 'dwt-listing'),
            'default' => 'Price From',
        ),
        array(
            'id' => 'dwt_listing_list_price_to',
            'type' => 'text',
            'title' => esc_html__('Price End To', 'dwt-listing'),
            'default' => 'Price To',
        ),
        array(
            'id' => 'd_pricing_range-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_b_hour',
            'type' => 'section',
            'title' => __('Listing Business Hours', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_b_h_section',
            'type' => 'text',
            'title' => esc_html__('Section Title', 'dwt-listing'),
            'default' => 'Select Your Business Hours',
        ),
        array(
            'id' => 'dwt_listing_b_h_time',
            'type' => 'text',
            'title' => esc_html__('Timezone Field', 'dwt-listing'),
            'default' => 'Select Your Timezone',
        ),
        array(
            'id' => 'd_b_hour-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_video_title',
            'type' => 'section',
            'title' => __('Listing Video Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_video',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Video Link',
        ),
        array(
            'id' => 'dwt_listing_list_video_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip', 'dwt-listing'),
            'default' => 'Provide introductory Youtube video link',
        ),
        array(
            'id' => 'dwt_listing_list_video_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'Video Link',
        ),
        array(
            'id' => 'd_video-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_tags_title',
            'type' => 'section',
            'title' => __('Listing Tags / Keywords Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_tags',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Listing Tags / Keywords',
        ),
        array(
            'id' => 'dwt_listing_list_tags_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'Provide your tags( Comma Separated ) ',
        ),
        array(
            'id' => 'd_tags-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_coupn_title',
            'type' => 'section',
            'title' => __('Listing Coupon Section Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_coupon_title',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Promotional Coupon',
        ),
        array(
            'id' => 'dwt_listing_coupon_code',
            'type' => 'text',
            'title' => esc_html__('Coupon Code Field', 'dwt-listing'),
            'default' => 'Coupon Code',
        ),
        array(
            'id' => 'dwt_listing_coupon_referral',
            'type' => 'text',
            'title' => esc_html__('Referral Link', 'dwt-listing'),
            'default' => 'Your Referral Link ',
        ),
        array(
            'id' => 'dwt_listing_coupon_expiry_date',
            'type' => 'text',
            'title' => esc_html__('Expiry Date', 'dwt-listing'),
            'default' => 'Coupon Expiry Date',
        ),
        array(
            'id' => 'dwt_listing_coupon_desc',
            'type' => 'text',
            'title' => esc_html__('Description Field', 'dwt-listing'),
            'default' => 'Coupon Short Description',
        ),
        array(
            'id' => 'd_coupn-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_geo_fields',
            'type' => 'section',
            'title' => __('Listing GeoLocation Fields', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_google_loc',
            'type' => 'text',
            'title' => esc_html__('Title', 'dwt-listing'),
            'default' => 'Listing Location',
        ),
        array(
            'id' => 'dwt_listing_list_google_loc_tool',
            'type' => 'text',
            'title' => esc_html__('Tooltip', 'dwt-listing'),
            'default' => 'your business phisical location it will be shown in search result',
        ),
        array(
            'id' => 'dwt_listing_list_google_loc_place',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'Deluxe Diner Division No. 18, Canada',
        ),
        array(
            'id' => 'd_geo-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_lat_long_fields',
            'type' => 'section',
            'title' => __('Listing Latitude & Longitude Fields', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_lati',
            'type' => 'text',
            'title' => esc_html__('Latitude Field', 'dwt-listing'),
            'default' => 'Latitude',
        ),
        array(
            'id' => 'dwt_listing_list_lati_tool',
            'type' => 'text',
            'title' => esc_html__('Latitude Tooltip', 'dwt-listing'),
            'default' => 'Coordinates will be auto fill if you provide business location',
        ),
        array(
            'id' => 'dwt_listing_list_lati_place',
            'type' => 'text',
            'title' => esc_html__('Latitude Placeholder', 'dwt-listing'),
            'default' => '56.1304',
        ),
        array(
            'id' => 'dwt_listing_list_longi',
            'type' => 'text',
            'title' => esc_html__('Longitude Title', 'dwt-listing'),
            'default' => 'Longitude',
        ),
        array(
            'id' => 'dwt_listing_list_longi_tool',
            'type' => 'text',
            'title' => esc_html__('Longitude Tooltip', 'dwt-listing'),
            'default' => 'Coordinates will be auto fill if you provide business location',
        ),
        array(
            'id' => 'dwt_listing_list_longi_place',
            'type' => 'text',
            'title' => esc_html__('Longitude Placeholder', 'dwt-listing'),
            'default' => '106.3468',
        ),
        array(
            'id' => 'd_lat_long-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'd_brand_title',
            'type' => 'section',
            'title' => __('Listing Brand Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_b_title',
            'type' => 'text',
            'title' => esc_html__('Brand Title', 'dwt-listing'),
            'default' => 'Brand Name',
        ),
        array(
            'id' => 'dwt_listing_b_placetitle',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'KnK Restaurant & Fast food',
        ),
        array(
            'id' => 'dwt_listing_brand_name_logo',
            'type' => 'text',
            'title' => esc_html__('Brand Logo', 'dwt-listing'),
            'default' => 'Brand Logo',
        ),
        array(
            'id' => 'd_contact_field',
            'type' => 'section',
            'title' => __('Listing Contact Email Field', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_contact_email',
            'type' => 'text',
            'title' => esc_html__('Contact Email Title', 'dwt-listing'),
            'default' => 'Contact Email',
        ),
        array(
            'id' => 'dwt_listing_contact_email_placeholder',
            'type' => 'text',
            'title' => esc_html__('Placeholder', 'dwt-listing'),
            'default' => 'xyx@abc.com',
        ),
        array(
            'id' => 'dwt_listing_contact_email_tooltip',
            'type' => 'text',
            'title' => esc_html__('Contact Email Tooltip', 'dwt-listing'),
            'default' => 'Provide your email on which you want to receive notification',
        ),
        array(
            'id' => 'd_other_fields',
            'type' => 'section',
            'title' => __('Listing Common Fields', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dwt_listing_list_desc',
            'type' => 'text',
            'title' => esc_html__('Title For Description Field', 'dwt-listing'),
            'default' => 'Description',
        ),
        array(
            'id' => 'dwt_listing_list_gallery',
            'type' => 'text',
            'title' => esc_html__('Title For Listing Gallery', 'dwt-listing'),
            'default' => 'Listing Gallery',
        ),
        array(
            'id' => 'dwt_listing_list_gallery_desc',
            'type' => 'text',
            'title' => esc_html__('Gallery Box Description Text', 'dwt-listing'),
            'default' => 'Drop files here or click to upload',
        ),
        array(
            'id' => 'dwt_listing_list_socail_media',
            'type' => 'text',
            'title' => esc_html__('Social Media Section', 'dwt-listing'),
            'default' => 'Social Media Addresses',
        ),
        array(
            'id' => 'dwt_listing_list_form_btn',
            'type' => 'text',
            'title' => esc_html__('Title For Submit Button', 'dwt-listing'),
            'default' => 'Preview & Submit',
        ),
        array(
            'id' => 'sb_location_titles',
            'type' => 'text',
            'title' => __('Location titles', 'dwt-listing'),
            'desc' => __('4-level location title separate by | like Country|State|City|Town', 'dwt-listing'),
            'default' => 'Country|State|City|Town',
        ),
        array(
            'id' => 'dwt_listing_list_cover',
            'type' => 'text',
            'title' => esc_html__('Title For Cover Image Field', 'dwt-listing'),
            'default' => 'Cover Image',
        ),
        array(
            'id' => 'dwt_listing_list_cover_reco',
            'type' => 'text',
            'title' => esc_html__('Recommendation For Cover Image Field', 'dwt-listing'),
            'default' => 'Recommended cover size is 1920x550 px',
        ),
        array(
            'id' => 'd_other_fields-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),
    )
));


/* * ********************
 * Listing Search
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Search Settings', 'dwt-listing'),
    'id' => 'dwt_listing_search_settings',
    'desc' => '',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_seacrh_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Listing Search Page', 'dwt-listing'),
            'default' => '',
        ),
        array(
            'id' => 'dwt_listing_seacrh_layout',
            'type' => 'image_select',
            'title' => esc_html__('Search Page Layout', 'dwt-listing'),
            'desc' => esc_html__('Select search page layout type.', 'dwt-listing'),
            'options' => array(
                'sidebar' => array(
                    'alt' => esc_html__('With Sidebar', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/sidebar.png'
                ),
                'map' => array(
                    'alt' => esc_html__('With Map', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/map.png'
                ),
                'topbar' => array(
                    'alt' => esc_html__('With TopBar', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/topbar.png'
                ),
            ),
            'default' => 'map'
        ),
        array(
            'id' => 'dwt_listing_enable_mapfilters',
            'type' => 'switch',
            'title' => esc_html__('Enable / Disable Search Filter', 'dwt-listing'),
            'required' => array('dwt_listing_seacrh_layout', '!=', array('sidebar')),
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'donwtown_search_bytitle',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Search By Title', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byloc',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Search By Location', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_bcats',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Categories', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byprice',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Price Filters', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byopen',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Open Time', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byrated',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Highly Rated', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byregion',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Search By Region', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_bytags',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Search By Tags', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_bydynamic_fields',
            'type' => 'switch',

            'title' => esc_html__('Search By Dynamic Fields', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => false,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_byfeatures',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Features/Amenties', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => esc_html__('Enabled', 'dwt-listing'),
            'off' => esc_html__('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'donwtown_search_bysort',
            'type' => 'switch',
            'required' => array(array('dwt_listing_seacrh_layout', '!=', 'sidebar'), array('dwt_listing_enable_mapfilters', '=', '1')),
            'title' => esc_html__('Sort By', 'dwt-listing'),
            'desc' => '',
            'subtitle' => '',
            'default' => 1,
            'on' => __('Enabled', 'dwt-listing'),
            'off' => __('Disabled', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_search_layout_style',
            'type' => 'image_select',
            'title' => esc_html__('Listing Styles', 'dwt-listing'),
            'options' => array(
                'grid1' => array(
                    'alt' => esc_html__('Elegent Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid1.png'
                ),
                'grid2' => array(
                    'alt' => esc_html__('Classic Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid2.png'
                ),
                'grid3' => array(
                    'alt' => esc_html__('Classic Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid3.png'
                ),
                'grid4' => array(
                    'alt' => esc_html__('Gird & List Switcher', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid4.png'
                ),
                'list1' => array(
                    'alt' => esc_html__('Listing Type', 'dwt-listing'),
                    'title' => esc_html__("List style won't work with search with topbar style.", 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/list1.png'
                ),
            ),
            'default' => 'grid1'
        ),
        array(
            'id' => 'listing_title_limt',
            'type' => 'switch',
            'title' => esc_html__('Listing Title Limit', 'dwt-listing'),
            'required' => array('dwt_listing_search_layout_style', '=', array('grid1', 'grid2')),
            'default' => true,
        ),
        array(
            'id' => 'grid_title_limit',
            'type' => 'select',
            'title' => esc_html__('Title Limit For Grid Listing', 'dwt-listing'),
            'required' => array(
                array('dwt_listing_search_layout_style', '=', 'grid1', 'grid2'),
                array('listing_title_limt', '=', '1')
            ),
            'options' => array(10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50, 55 => 55, 60 => 60),
            'default' => 20,
        ),
        array(
            'id' => 'dwt_listing_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Search Sidebar Postion', 'dwt-listing'),
            'required' => array('dwt_listing_seacrh_layout', '=', array('sidebar')),
            'options' => array(
                'right' => 'Right',
                'left' => 'Left',
            ),
            'default' => 'right'
        ),
        array(
            'id' => 'dwt_listing_enable_video_option',
            'type' => 'switch',
            'title' => esc_html__('Show video icon on ads', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_video_icon',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Video Icon Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('Video Icon Image on ads.', 'dwt-listing'),
            'subtitle' => esc_html__('Dimensions: 32 x 32', 'dwt-listing'),
            'required' => array('dwt_listing_enable_video_option', '=', '1'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/play-button.png'),
        ),
        array(
            'id' => 'feature_or_simple',
            'type' => 'switch',
            'title' => esc_html__('Featured Listings In Simple Listings', 'dwt-listing'),
            'default' => false,
            'desc' => esc_html__('Want to show featured listing in simple listing as well', 'dwt-listing'),
        ),
        array(
            'id' => 'feature_on_search',
            'type' => 'switch',
            'title' => esc_html__('Featured Ads', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_feature_on_search',
            'type' => 'image_select',
            'title' => esc_html__('Featured Slider Style', 'dwt-listing'),
            'required' => array('feature_on_search', '=', array(true)),
            'options' => array(
                'grid1' => array(
                    'alt' => esc_html__('Elegent Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid1.png'
                ),
                'grid2' => array(
                    'alt' => esc_html__('Classic Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid2.png'
                ),
                'grid3' => array(
                    'alt' => esc_html__('Classic Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid3.png'
                ),
                'grid4' => array(
                    'alt' => esc_html__('Classic Listing', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/grid4.png'
                ),
            ),
            'default' => 'grid2'
        ),
        array(
            'id' => 'max_ads_feature',
            'type' => 'select',
            'title' => esc_html__('Max Featured ads to show', 'dwt-listing'),
            'required' => array('feature_on_search', '=', array(true)),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'id' => 'feature_ads_title',
            'type' => 'text',
            'title' => esc_html__('Featured Ads Title', 'dwt-listing'),
            'required' => array('feature_on_search', '=', array(true)),
            'default' => 'Featured Ads',
        ),
        array(
            'id' => 'search_ad_720_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'dwt-listing'),
            'subtitle' => esc_html__('720 x 90', 'dwt-listing'),
            'desc' => esc_html__('Above the Listing description', 'dwt-listing'),
            'default' => '<img alt="' . esc_html__('not found', 'dwt-listing') . '" target="_blank" src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/eds/720x120-1.jpg"> ',
        ),
        array(
            'id' => 'search_ad_720_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'dwt-listing'),
            'subtitle' => esc_html__('720 x 90', 'dwt-listing'),
            'desc' => esc_html__('Below the Listing description', 'dwt-listing'),
            'default' => '<img alt="' . esc_html__('not found', 'dwt-listing') . '" target="_blank" src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/eds/720x90-2.png"> ',
        ),
    )
));

/* * ********************
 * Listing View Settings
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Listing View Settings', 'dwt-listing'),
    'id' => 'sb_view_post',
    'desc' => '',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_lp_style',
            'type' => 'image_select',
            'title' => esc_html__('Listing Detial Page Style', 'dwt-listing'),
            'options' => array(
                'classic' => array(
                    'alt' => esc_html__('Classic', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/detial_1.png'
                ),
                'elegent' => array(
                    'alt' => esc_html__('Elegent', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/detial_2.png'
                ),
                'minimal' => array(
                    'alt' => esc_html__('Minimal', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/detial_3.png'
                ),
            ),
            'default' => 'style_1'
        ),
        array(
            'id' => 'dwt_listing_cover_default_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Default Cover Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => __('Select listing default cover image. Recommended size 1920x550 px', 'dwt-listing'),
            'required' => array('dwt_listing_lp_style', '=', 'minimal'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/listing-cover.png'),
        ),
        array(
            'id' => 'dwt_listing_view-layout-manager-minimal',
            'type' => 'sorter',
            'title' => 'Page Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the listing page',
            'compiler' => 'true',
            'required' => array('dwt_listing_lp_style', '=', 'minimal'),
            'options' => array(
                'enabled' => array(
                    'ad_slot_1' => 'Ad Slot 1',
                    'desc' => 'Description',
                    'menu' => 'Menu',
                    'listing_features' => 'Features',
                    'location' => 'Location',
                    'form_fields' => 'Custom Fields',
                    'video' => 'Video',
                    'ad_slot_2' => 'Ad Slot 2',
                    'reviews' => 'Reviews'
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'dwt_listing_view-layout-manager',
            'type' => 'sorter',
            'title' => 'Page Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the listing page',
            'compiler' => 'true',
            'required' => array(
                'dwt_listing_lp_style', '=', 'classic'
            ),
            'options' => array(
                'enabled' => array(
                    'slider' => 'Slider',
                    'ad_slot_1' => 'Ad Slot 1',
                    'desc' => 'Description',
                    'menu' => 'Menu',
                    'listing_features' => 'Features',
                    'location' => 'Location',
                    'form_fields' => 'Custom Fields',
                    'video' => 'Video',
                    'ad_slot_2' => 'Ad Slot 2',
                    'reviews' => 'Reviews'
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'dwt_listing_elegent_manager',
            'type' => 'sorter',
            'title' => 'Page Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the listing page',
            'compiler' => 'true',
            'required' => array('dwt_listing_lp_style', '=', 'elegent'),
            'options' => array(
                'enabled' => array(
                    'ad_slot_1' => 'Ad Slot 1',
                    'desc' => 'Description',
                    'menu' => 'Menu',
                    'listing_features' => 'Features',
                    'location' => 'Location',
                    'form_fields' => 'Custom Fields',
                    'video' => 'Video',
                    'ad_slot_2' => 'Ad Slot 2',
                    'reviews' => 'Reviews'
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'dwt_listing_menu_type_col',
            'type' => 'image_select',
            'title' => esc_html__('Menu Style Type', 'dwt-listing'),
            'options' => array(
                'column_1' => array(
                    'alt' => esc_html__('1 Column', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/1_col.png'
                ),
                'column_2' => array(
                    'alt' => esc_html__('2 Column', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/2_col.png'
                ),
            ),
            'default' => 'column_1'
        ),
        array(
            'id' => 'dwt_listing_slot_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'dwt-listing'),
            'subtitle' => esc_html__('720 x 90', 'dwt-listing'),
            'desc' => esc_html__('Advertisement slot 1', 'dwt-listing'),
            'default' => '<img class="img-responsive center-block" target="_blank" alt="' . esc_html__('not found', 'dwt-listing') . '" src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/eds/720x120-1.jpg"> ',
        ),
        array(
            'id' => 'dwt_listing_slot_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'dwt-listing'),
            'subtitle' => esc_html__('720 x 90', 'dwt-listing'),
            'desc' => esc_html__('Advertisement slot 2', 'dwt-listing'),
            'default' => '<img class="img-responsive center-block alt="' . esc_html__('not found', 'dwt-listing') . '" src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/eds/720x90-2.png"> ',
        ),
        array(
            'id' => 'dwt_listing_sidebar-layout-manager',
            'type' => 'sorter',
            'title' => 'Listing Page Sidebar',
            'desc' => 'Organize how you want the layout to appear on sidebar',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'card' => 'Profile Card',
                    'coupon' => 'Coupon',
                    'events' => 'Related Event',
                    'hours' => 'Business Hours',
                    'claim' => 'Claim',
                    'pricing' => 'Pricing',
                    'tags' => 'Tags',
                    'booking_timekit' => 'Booking Timekit',
                    'nearby_listing' => 'Listing Nearby'
                ),
                'disabled' => array(),
            ),
        ),
        array(
            'id' => 'dwt_listing_timezone_txt',
            'type' => 'text',
            'title' => esc_html__('Timezone Heading', 'dwt-listing'),
            'default' => 'Listing Timezone',
        ),
        array(
            'id' => 'dlisting_view_txt',
            'type' => 'section',
            'title' => __('Listing Sections Text', 'dwt-listing'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id' => 'dl_desc',
            'type' => 'text',
            'title' => esc_html__('Description Section', 'dwt-listing'),
            'default' => 'Description',
        ),
        array(
            'id' => 'dl_menu',
            'type' => 'text',
            'title' => esc_html__('Menu Section', 'dwt-listing'),
            'default' => 'Menu',
        ),
        array(
            'id' => 'dl_advert',
            'type' => 'text',
            'title' => esc_html__('Advertisement Section', 'dwt-listing'),
            'default' => 'Advertisement ',
        ),
        array(
            'id' => 'dl_amenties',
            'type' => 'text',
            'title' => esc_html__('Amenties Section', 'dwt-listing'),
            'default' => esc_html__('Amenties', 'dwt-listing'),
        ),
        array(
            'id' => 'dl_custom',
            'type' => 'text',
            'title' => esc_html__('Custom Fields Section', 'dwt-listing'),
            'default' => 'Additional Details',
        ),
        array(
            'id' => 'dl_location',
            'type' => 'text',
            'title' => esc_html__('Location Section', 'dwt-listing'),
            'default' => 'Location ',
        ),
        array(
            'id' => 'dl_video',
            'type' => 'text',
            'title' => esc_html__('Video Section', 'dwt-listing'),
            'default' => 'Video',
        ),
        array(
            'id' => 'dl_reviews',
            'type' => 'text',
            'title' => esc_html__('Reviews Section', 'dwt-listing'),
            'default' => 'Reviews',
        ),
    )
));
/* * ********************
 * Listing Form Manger
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Listing Form manager', 'dwt-listing'),
    'id' => 'dwt_listing_form_manager',
    'desc' => '',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_form-layout-manager',
            'type' => 'sorter',
            'title' => esc_html__('Listing Form Drag Drop', 'dwt-listing'),
            'desc' => esc_html__('Organize your listing form', 'dwt-listing'),
            'options' => array(
                'enabled' => array(
                    'title_cat' => 'Title & Category Section',
                    'price_type' => 'Price Type Section',
                    'buiness_hours' => 'Business Hours Section',
                    'social_links' => 'Social Media Section',
                    'desc_sec' => 'Description & Gallery',
                    'location' => 'Location Section',
                    'book_listing' => 'Book Listing Section'
                ),
                'disabled' => array(
                    'coupon' => 'Coupon Section',
                ),
            ),
        ),
    )
));
/* * ********************
 * Listing nearby
 * ******************** */
Redux::set_section($opt_name, array(
    'title' => __('Listing Nearby', 'dwt-listing'),
    'id' => 'dwt_listing_nearby_location',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_nearby_dest',
            'type' => 'text',
            'title' => esc_html__('Add Distance for Nearby Location', 'dwt-listing'),
            'subtitle' => esc_html__('Enter only numberic values. Do not add distance units here', 'dwt-listing'),
            'description' => esc_html__('Add Distance for Nearby Location', 'dwt-listing') . '</a>',
            'default' => '100',
        ),
        array(
            'id' => 'dwt_listing_nearby_dest_in',
            'type' => 'select',
            'title' => __('Destination in ', 'dwt-listing'),
            'subtitle' => __('Nearby Destination Calculate in', 'dwt-listing'),
            'desc' => __('Nearby Destination', 'dwt-listing'),
            'options' => array(
                'km' => 'Kilometers',
                'mile' => 'Miles',
            ),
            'default' => 'km',
        ),
        array(
            'id' => 'dwt_listing_nearby_no_listings',
            'type' => 'text',
            'title' => esc_html__('No. of Nearby Listings', 'dwt-listing'),
            'subtitle' => esc_html__('Enter only numberic values', 'dwt-listing'),
            'description' => esc_html__('No. of Nearby Listings', 'dwt-listing') . '</a>',
            'default' => '5',
        ),
    )
));

/* ***************************************
 *  Email Template when listing is expired.
 *************************************** */
Redux::set_section($opt_name, array(
    'id' => 'dwt_listing_email_on_expiration',
    'title' => esc_html__('Email on Listing Expire', 'dwt-listing'),
    'desc' => '',
    'icon' => 'el el-pencil',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_msg_subject_on_listings_expire',
            'type' => 'text',
            'title' => esc_html__('Listing Expire Email subject', 'dwt-listing'),
            'desc' => esc_html__('%site_name% , %listing_owner% , %listing_title% will be translated accordingly.', 'dwt-listing'),
            'default' => 'Your Listing Expired - DWT Listing',
        ),
        array(
            'id' => 'dwt_listing_msg_from_on_listings_expire',
            'type' => 'text',
            'title' => esc_html__('Listing Expire Email FROM', 'dwt-listing'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'dwt-listing'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'dwt_listing_msg_on_listings_expire',
            'type' => 'editor',
            'title' => esc_html__('Listing Expire Posted Message', 'dwt-listing'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %listing_owner% , %listing_title% , %listing_link% will be translated accordingly.', 'dwt-listing'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="https://listing.dwt_listing_directory.com/wp-content/uploads/2018/02/logo.png" alt="' . esc_html__('not found', 'dwt-listing') . '" width="200" height="40" /><br/>
A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>%listing_owner%,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">This Listing has been Expired.</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %listing_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%listing_link%">%listing_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Owner : %listing_owner%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));