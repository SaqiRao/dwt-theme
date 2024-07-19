<?php
/* ------------------Theme Customization Options ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Customization', 'dwt-listing'),
    'id' => 'dwt_listing_customization_settings',
    'desc' => '',
    'icon' => 'el el-css',
    'fields' => array(
        array(
            'id' => 'dwt_listing_css_editor',
            'type' => 'ace_editor',
            'title' => esc_html__('Custom CSS', 'dwt-listing'),
            'subtitle' => esc_html__('Paste your CSS code here.', 'dwt-listing'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "#youclass{\nmargin: 0 auto;\n}"
        ),
        array(
            'id' => 'dwt_listing_js_editor',
            'type' => 'ace_editor',
            'title' => esc_html__('Custom JS', 'dwt-listing'),
            'subtitle' => esc_html__('Paste your JS code here.', 'dwt-listing'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "jQuery(document).ready(function(){\n\n});"
        ),
    )
));