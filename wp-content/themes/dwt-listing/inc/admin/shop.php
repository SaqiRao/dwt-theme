<?php
/* ------------------Shop Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Shop', 'dwt-listing'),
    'id' => 'dwt_listing_shop_settings',
    'desc' => '',
    'icon' => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id' => 'related_products',
            'type' => 'switch',
            'title' => esc_html__('Related Products', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'max_related_products',
            'type' => 'select',
            'title' => esc_html__('Max Related Products To Show', 'dwt-listing'),
            'required' => array('related_products', '=', array(true)),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'id' => 'related_products_title',
            'type' => 'text',
            'title' => esc_html__('Related Products Title', 'dwt-listing'),
            'required' => array('related_products', '=', array(true)),
            'default' => 'Related Products',
        ),
        array(
            'id' => 'show_banners_on_product',
            'type' => 'switch',
            'title' => esc_html__('Show Advertising Banner On Product Page', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'opt-slides-do',
            'type' => 'slides',
            'title' => esc_html__('Ad Banner Slides', 'dwt-listing'),
            'show' => array(
                'title' => false,
                'description' => false,
                'url' => true
            ),
            'desc' => esc_html__('Recommended size 750x215', 'dwt-listing'),
            'placeholder' => array(
                'url' => esc_html__('Link you want to redirect', 'dwt-listing'),
            ),
        ),
    )
));