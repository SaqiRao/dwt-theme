<?php
if (!defined('ABSPATH'))
    exit;

/* ------------------Blog Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Blog Settings', 'dwt-listing'),
    'id' => 'sb-blog-settings',
    'desc' => '',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'dwt_listing_blog-post-title',
            'type' => 'text',
            'title' => esc_html__('Blog Page Title', 'dwt-listing'),
            'desc' => '',
            'default' => 'Latest News & Trends',
        ),
        array(
            'id' => 'dwt_listing_blog-layout',
            'type' => 'sorter',
            'title' => 'Blog Post Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the blog page',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('content' => 'Content Area ', 'sidebar' => 'Sidebar'),
            ),
        ),
        array(
            'id' => 'dwt_listing_blog-singlelayout',
            'type' => 'sorter',
            'title' => 'Blog Detail Layout Manager',
            'desc' => 'Organize how you want the layout to appear on the blog page',
            'compiler' => 'true',
            'options' => array(
                'enabled' => array('singlepost' => 'Post Detail ', 'singlesidebar' => 'Sidebar'),
            ),
        ),
    )
));