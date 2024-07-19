<?php
if (!defined('ABSPATH'))
    exit;
/* ------------------Blog Settings ----------------------- */
Redux::set_section($opt_name, array(
    'title' => esc_html__('Admin Options', 'dwt-listing'),
    'id' => 'dwt_listing_slugs',
    'desc' => '',
    'icon' => 'el el-asl',
    'fields' => array(

        array(
            'id' => 'admin_commission_percentage',
            'type' => 'select',
            'title' => esc_html__('Admin Commision Percentage', 'dwt-listing'),
            'options' => array(1 => 10, 2 => 15, 3 => 20, 4 => 25, 5 => 30),
            'default' => 1,
        ),

        array(
            'id' => 'dwt_listing_admin_bar_switch',
            'type' => 'switch',
            'title' => esc_html__('Hide/Show Admin Bar', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_enable_packages',
            'type' => 'switch',
            'title' => esc_html__('Assign Free Package On Registration', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_bult_renew_date',
            'type' => 'switch',
            'title' => esc_html__('Renew listings in bulk', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_mov_trash_to_expire',
            'type' => 'switch',
            'title' => esc_html__('Move Trash to Expire', 'dwt-listing'),
            'default' => false,
        ),
        array(
            'id' => 'dwt_listing_notification_packages',
            'type' => 'info',
            'title' => esc_html__('Package Alert', 'dwt-listing'),
            'style' => 'critical',
            'desc' => esc_html__('This option will only work when ( WooCommerce Plugin ) is activeted & ( Downtown Packages ) are created.', 'dwt-listing'),
            'required' => array('dwt_listing_enable_packages', '=', true),
        ),
        array(
            'id' => 'dwt_listing_package_type',
            'type' => 'select',
            'data' => 'posts',
            'args' => array(
                'post_type' => array('product'),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
            ),
            'title' => __('Select Package Only', 'dwt-listing'),
            'required' => array('dwt_listing_enable_packages', '=', true),
            'desc' => __('Only select package not shop products.', 'dwt-listing'),
        ),
        array(
            'id' => 'dwt_listing_disable_menu',
            'type' => 'switch',
            'title' => esc_html__('Enable Menu', 'dwt-listing'),
            'default' => true,
        ),
        array(
            'id' => 'dwt_listing_brand_default_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Default Brand Image', 'dwt-listing'),
            'compiler' => 'true',
            'desc' => __('Select brand default image here', 'dwt-listing'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'assets/images/brand.png'),
        ),
    )
));
?>
<?php 
ob_start( ); // This tells PHP to start putting all output in a buffer.
?>
<input type="button" id="renew_expired_listings" class="button button-primary" value="Click Here"/>
<?php
    $renew_listing='';
    echo $renew_listing;
$output = ob_get_clean(); // Now everything is in our variable.

Redux::set_section($opt_name, array(
    'title' => esc_html__('Renew Expired Listings', 'dwt-listing'),
    'desc' => '',
    'icon' => 'el el-asl',
    'fields' => array(
        array(
            'id'           => 'opt-raw',
            'type'         => 'raw',
            'subtitle'     => esc_html__('Click Here', 'dwt-listing'),
            'desc'         => esc_html__('Click to reactive Expired Listing.', 'dwt-listing'),
            'content'  => $output // Now let's set that in the raw field.
        ),
    )
    ));