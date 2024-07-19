<?php
if (!defined('ABSPATH'))
    exit;
/* ------------------API Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('API Settings', 'dwt-listing'),
    'id' => 'sb-api-settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'dwt_listing_recaptcha',
            'type' => 'switch',
            'title' => esc_html__('Enable Google Captcha', 'dwt-listing'),
            'desc' => esc_html__('Enable google captcha on registration', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'google_api_key',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Key', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'dwt-listing')),
            'default' => '',
            'required' => array('dwt_listing_recaptcha', '=', true),
        ),
        array(
            'id' => 'google_api_secret',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Secret', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'dwt-listing')),
            'default' => '',
            'required' => array('dwt_listing_recaptcha', '=', true),
        ),
        array(
            'id' => 'mailchimp_api_key',
            'type' => 'text',
            'title' => esc_html__('MailChimp API Key', 'dwt-listing'),
            'desc' => dwt_listing_make_link('http://kb.mailchimp.com/integrations/api-integrations/about-api-keys', esc_html__('How to Find it', 'dwt-listing')),
        ),
        array(
            'id' => 'mailchimp_list_id',
            'type' => 'text',
            'title' => esc_html__('MailChimp List ID', 'dwt-listing'),
            'desc' => dwt_listing_make_link('http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id', esc_html__('How to Find it', 'dwt-listing')),
        ),
        array(
            'id' => 'fb_api_key',
            'type' => 'text',
            'title' => esc_html__('Facebook Client ID', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://developers.facebook.com/?advanced_app_create=true', esc_html__('How to Make', 'dwt-listing')),
        ),
        array(
            'id' => 'gmail_api_key',
            'type' => 'text',
            'title' => esc_html__('Gmail Client ID', 'dwt-listing'),
            'desc' => dwt_listing_make_link('https://console.developers.google.com/apis/api/gmail/', esc_html__('How to Find it', 'dwt-listing')),
        ),
        array(
            'id' => 'redirect_uri',
            'type' => 'text',
            'title' => esc_html__('Redirect URI', 'dwt-listing'),
            'desc' => esc_html__('Must be URI where you want to redirect after thentication, it will be your web url.', 'dwt-listing'),
        ),
    )
));