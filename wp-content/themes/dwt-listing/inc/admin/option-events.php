<?php
if (!defined('ABSPATH'))
    exit;

/* ------------------ Events  ----------------------- */
Redux::set_section($opt_name, array(
    
    'title' => esc_html__('Events', 'dwt-listing'),
    'id' => 'dwt_listing_events-settingss',
    'desc' => '',
    'icon' => 'el el-plane',
    'fields' => array(
        array(
            'id' => 'dwt_listing_event_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Events Search Page', 'dwt-listing'),
            'default' => '',
        ),
        array(
            'id' => 'dwt_listing_event_layout',
            'type' => 'image_select',
            'title' => esc_html__('Events Page Layout', 'dwt-listing'),
            'desc' => esc_html__('Select events page layout type.', 'dwt-listing'),
            'options' => array(
                'topbar' => array(
                    'alt' => esc_html__('Full Width', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/e_topbar.png'
                ),
                'map' => array(
                    'alt' => esc_html__('With Map', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/e_map.png'
                ),
            ),
            'default' => 'topbar'
        ),
        array(
            'id' => 'dwt_listing_event_view',
            'type' => 'image_select',
            'title' => esc_html__('Events Detail Page Layout', 'dwt-listing'),
            'desc' => esc_html__('Select events page layout type.', 'dwt-listing'),
            'options' => array(
                'classic' => array(
                    'alt' => esc_html__('CLassic', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/classic_event.png'
                ),
                'modern' => array(
                    'alt' => esc_html__('Modern', 'dwt-listing'),
                    'img' => esc_url(trailingslashit(get_template_directory_uri())) . 'vc-images/admin/modern_event.png'
                ),
            ),
            'default' => 'modern'
        ),
        array(
            'id' => 'dwt_listing_event_send_email',
            'type' => 'switch',
            'title' => esc_html__('Send Email On Event To user', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_event_send_email_admin',
            'type' => 'switch',
            'title' => esc_html__('Send Event Email To Admin', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_email_event_expire',
            'type' => 'switch',
            'title' => __('Event Expiry Email', 'dwt-listing'),
            'default' => false,
            'desc' => __('Turn On if you send email on Event Expire', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_event_admin_email',
            'type' => 'text',
            'title' => __('Email for notification.', 'dwt-listing'),
            'required' => array('dwt_listing_event_send_email_admin', '=', '1'),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'dwt_listing_event_approval',
            'type' => 'button_set',
            'title' => esc_html__('Event Approval', 'dwt-listing'),
            'options' => array(
                '1' => esc_html__('Auto Approval', 'dwt-listing'),
                '0' => esc_html__('Admin Approval', 'dwt-listing'),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'dwt_listing_event_up_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approval', 'manual' => 'Admin Approval'),
            'title' => esc_html__('Event Update Approval', 'dwt-listing'),
            'default' => 'auto',
        ),
        array(
            'id' => 'dwt_listing_event_upload_limit',
            'type' => 'select',
            'title' => esc_html__('Events Gallery Limit', 'dwt-listing'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'id' => 'dwt_listing_event_images_size',
            'type' => 'select',
            'title' => __('Events Image Upload Size', 'dwt-listing'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB', '6291456-6MB' => '6MB', '7340032-7MB' => '7MB', '8388608-8MB' => '8MB', '9437184-9MB' => '9MB', '10485760-10MB' => '10MB', '11534336-11MB' => '11MB', '12582912-12MB' => '12MB', '13631488-13MB' => '13MB', '14680064-14MB' => '14MB', '15728640-15MB' => '15MB', '20971520-20MB' => '20MB', '26214400-25MB' => '25MB'),
            'default' => '2097152-2MB',
        ),
        array(
            'id' => 'dwt_listing_defualt_event_image',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Event Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of listing then this will be show.', 'dwt-listing'),
            'subtitle' => esc_html__('Dimensions: 100 x 100', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/event.jpg'),
        ),
        array(
            'id' => 'event_add_to_calendar',
            'type' => 'switch',
            'title' => esc_html__('Add event to your calendar ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'event_question',
            'type' => 'switch',
            'title' => __('Enable Events Questions Section', 'dwt-listing'),
            'default' => false,
        ),   
        array(
            'id' => 'days_schedule',
            'type' => 'switch',
            'title' => esc_html__('Enable Events Day Schedule ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'event_attendees',
            'type' => 'switch',
            'title' => esc_html__('Enable Event Attendies ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_event_speakers',
            'type' => 'switch',
            'title' => esc_html__('Enable Event Speakers', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'event_ticket_system',
            'type' => 'switch',
            'title' => esc_html__('Enable Event Tickets', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_event_type_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable Event Type', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_event_admin_disable_commission',
            'type' => 'switch',
            'title' => esc_html__('Admin Commision on Tickets', 'dwt-listing'),
            'default' => false,
            'required' => array( array('event_ticket_system', '=', 1))
        ),
        array(
            'id' => 'event_commission_from',
            'type' => 'button_set',
            'title' => esc_html__('Events Commission', 'dwt-listing'),
            'options' => array(
                '1' => esc_html__('Commission from Author', 'dwt-listing'),
                '2' => esc_html__('Commission from Users', 'dwt-listing'),
            ),
            'default' => '1',
            'required' => array( array('event_ticket_system', '=', true),
            array( 'dwt_listing_event_admin_disable_commission', '=',true ),

        ),
            
        ),
        array(
            'id'            => 'service_charges',
            'type'          => 'slider',
            'title'         => __( 'select percentage to deduct', 'dwt-listing' ),
            'subtitle'      => __( 'select here to deduct from authors or users.', 'dwt-listing' ),
            'desc'          => __( 'Min: 0, max: 100 %,', 'dwt-listing' ),
            'default'       => 0,
            'min'           => 0,
            'step'          => 1,
            'max'           => 100,
            'display_value' => 'label',
            'required' =>  array(
                array('event_ticket_system', '=', true),
                array( 'dwt_listing_event_admin_disable_commission', '=', true ),
            ),

        ),
        array(
            'id' => 'service_custom_deposit_package',
            'type' => 'select',
            'data' => 'callback',
            'title' => esc_html__('Select Custom Product for Services', 'dwt-listing'),
            'args' => 'service_packages_callback_function',
            
        ),
        array(
            'id' => 'wallet_custom_deposit_package',
            'type' => 'select',
            'data' => 'callback',
            'title' => esc_html__('Select Package for custom product', 'dwt-listing'),
            'args' => 'wallet_packages_callback_function',
        ),
            
    )
));

Redux::set_section($opt_name, array(
    'title' => esc_html__('Related Events', 'dwt-listing'),
    'id' => 'dwt_listing_r_events',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_on_related',
            'type' => 'switch',
            'title' => esc_html__('Allow Related Events', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_related_section',
            'type' => 'text',
            'title' => esc_html__('Section Title', 'dwt-listing'),
            'required' => array('dwt_listing_on_related', '=', true),
            'default' => esc_html__('Related Events', 'dwt-listing'),
        ),
        array(
            'id' => 'app_event_related_nums',
            'type' => 'spinner',
            'title' => __('Related Events', 'dwt-listing'),
            'desc' => __('Number of events shown', 'dwt-listing'),
            'required' => array('dwt_listing_on_related', '=', true),
            'default' => '6',
            'min' => '1',
            'step' => '1',
            'max' => '9',
        ),
    ),
));

Redux::set_section($opt_name, array(
    'title' => esc_html__('Event Filters', 'dwt-listing'),
    'id' => 'dwt_listing_event_filters',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_events-filter-manager',
            'type' => 'sorter',
            'title' => 'Event Search Filters',
            'compiler' => 'true',
            'options' => array('enabled' => array('by_title' => 'By Title', 'by_category' => 'By Categories', 'by_location' => 'By Location', 'by_date' => 'By Date'),
                'disabled' => array(),
            ),
        ),
    ),
));

Redux::set_section($opt_name, array(
    'title' => esc_html__('Event Cron jobs', 'dwt-listing'),
    'id' => 'dwt_listing_event_cron',
    'desc' => '',
    'icon' => 'el el-time',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_event_cron_switch',
            'type' => 'switch',
            'title' => esc_html__('Switch of Cron Jobs', 'dwt-listing'),
            'desc' => esc_html__('Note : This functionality works hiddenly notify the users before package expiry.This option takes a lot of load so any one who wishes to choose this option must have a good server that can support heavy load. ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_events_cron_interval',
            'type' => 'select',
            'required' => array('dwt_listing_event_cron_switch', '=', true),
            'title' => 'Cron Interval',
            'desc' => __('Cron job run after this Interval', 'dwt-listing'),
            'options' => array('hourly' => 'Hourly', 'twicedaily' => 'Twice Daily', 'daily' => 'Daily'),
            'default' => 'daily',
        ),
    ),
));

//========================
//email on event expire
Redux::set_section($opt_name, array(
    'title' => esc_html__('Email on Event Expire', 'dwt-listing'),
    'id' => 'dwt_event_email_on_expiration',
    'desc' => '',
    'icon' => 'el el-pencil',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_listing_msg_subject_on_event_expire',
            'type' => 'text',
            'title' => esc_html__('Event Expire Email subject', 'dwt-listing'),
            'desc' => esc_html__('%site_name% , %event_owner% , %event_title% , %event_link% will be translated accordingly.', 'dwt-listing'),
            'default' => 'Your Event Expired - DWT Listing',
        ),
        array(
            'id' => 'dwt_listing_msg_from_on_event_expire',
            'type' => 'text',
            'title' => esc_html__('Event Expire Email FROM', 'dwt-listing'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'dwt-listing'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'dwt_listing_msg_on_event_expire',
            'type' => 'editor',
            'title' => esc_html__('Event Expire Posted Message', 'dwt-listing'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %event_owner% , %event_title% , %event_link% will be translated accordingly.', 'dwt-listing'),
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
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>%event_owner%,</b></span></p>
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">This Even has been Expired.</p>
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %event_title%</p>
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%event_link%">%event_title%</a></p>
                                                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Owner : %event_owner%</p>
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

</div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        )
));

// =============================Speakers===========================================
Redux::set_section($opt_name, array(
    'title' => esc_html__('Speakers', 'dwt-listing'),
    'id' => 'dwt_listing_speakers_settings',
    'desc' => '',
    'icon' => 'el el-mic',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dwt_add_speaker_type_switch',
            'type' => 'switch',
            'title' => esc_html__('Speaker Types ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_add_speaker_education_switch',
            'type' => 'switch',
            'title' => esc_html__('Add Education for Speakers ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_add_speaker_faqs_switch',
            'type' => 'switch',
            'title' => esc_html__('Add FAQs for Speakers ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_add_speaker_skills_switch',
            'type' => 'switch',
            'title' => esc_html__('Add Skills for Speakers ', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_add_speaker_profession_switch',
            'type' => 'switch',
            'title' => esc_html__('Add Profession for Speakers ', 'dwt-listing'),
            'default' => false,
        ),
    )
)
);
//======================== FAQs and Days Schedule Ends Here ===========================/

//for services
    if (! function_exists ( 'service_packages_callback_function' )) {
    function service_packages_callback_function(){
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            $service_packages_products = [];
            $packages = array();
            if (function_exists ( 'ziauddin_service_products' ))
            {
                $packages = ziauddin_service_products();
            }
            if(!empty($packages))
            {
                while ( $packages->have_posts() )
                {
                    $packages->the_post();
                    $products_id	=	get_the_ID();
                    $product	=	wc_get_product( $products_id );
                    $product_title = $product->get_title();
                    $product_price = $product->get_price();
                    $service_packages_products[$products_id] = $product_title.'('.($product_price).')';
                }
            }

            return $service_packages_products;
        }
        else
        {
            return array();
        }
    }
    

}
if (! function_exists ( 'wallet_packages_callback_function' )) {
    function wallet_packages_callback_function(){
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            $wallet_packages_products = [];
            $packages = array();
            if (function_exists ( 'dwt_wallet_products' ))
            {
                $packages = dwt_wallet_products();
            }
            if(!empty($packages))
            {
                while ( $packages->have_posts() )
                {
                    $packages->the_post();
                    $products_id	=	get_the_ID();
                    $product	=	wc_get_product( $products_id );
                    $product_title = $product->get_title();
                    $product_price = $product->get_price();
                    $wallet_packages_products[$products_id] = $product_title.'('.fl_price_separator($product_price).')';
                }
            }

            return $wallet_packages_products;
        }
        else
        {
            return array();
        }
    }
}