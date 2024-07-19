<?php
if (!defined('ABSPATH'))
    exit;

/* ------------------WPML Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('WPML Settings', 'dwt-listing'),
    'id' => 'dwt-listing-wpml',
    'desc' => '',
    'icon' => 'el el-network',
    'fields' => array(
        array(
            'id' => 'dwt_listing_duplicate_post',
            'type' => 'switch',
            'title' => esc_html__('Duplicate Posts', 'dwt-listing'),
            'subtitle' => __('Enable this option to duplicate posts in all others languages after successfully publish.', 'dwt-listing'),
            'desc' => esc_html__('Note : Disable means the posts publish only in the current language.', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_display_post',
            'type' => 'switch',
            'title' => esc_html__('Display Posts', 'dwt-listing'),
            'subtitle' => __('Enable this option to display all others languages posts in current language.', 'dwt-listing'),
            'desc' => esc_html__('Note : Disable means to display only current language posts.', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_lang_switcher',
            'type' => 'switch',
            'title' => esc_html__('Language Switcher on Topbar', 'dwt-listing'),
            'subtitle' => __('Enable this option to display language switcher on topbar.', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_menu_lang_switch',
            'type' => 'switch',
            'title' => esc_html__('Language Switcher in Menu', 'dwt-listing'),
            'subtitle' => __('Enable this option to Show language switcher in menu.', 'dwt-listing'),
            'default' => false,
        ),
    )
));