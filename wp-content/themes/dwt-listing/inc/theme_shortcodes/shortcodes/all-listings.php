<?php
if (!function_exists('dwt_listing_all_listings')) {

    function dwt_listing_all_listings() {
        vc_map(array(
            "name" => __("All Listing", 'dwt-listing'),
            "base" => "d_listings_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('listings.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'dwt-listing'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'dwt-listing') => '',
                        esc_html__('White', 'dwt-listing') => '',
                        esc_html__('Gray', 'dwt-listing') => 'bg-gray',
                        esc_html__('Image', 'dwt-listing') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                    "description" => esc_html__('Title for your section ', 'dwt-listing') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'dwt-listing'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("Listing Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Listing Type", 'dwt-listing'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Listing Type', 'dwt-listing') => '',
                        esc_html__('Featured Listing', 'dwt-listing') => 'feature',
                        esc_html__('Simple Listing', 'dwt-listing') => 'regular',
                        esc_html__('Both', 'dwt-listing') => 'both'
                    ),
                ),
                array(
                    "group" => esc_html__("Listing Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Order By", 'dwt-listing'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Listing order', 'dwt-listing') => '',
                        esc_html__('Oldest', 'dwt-listing') => 'asc',
                        esc_html__('Latest', 'dwt-listing') => 'desc',
                        esc_html__('Random', 'dwt-listing') => 'rand'
                    ),
                ),
                array(
                    "group" => esc_html__("Listing Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Layout Type", 'dwt-listing'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Layout Type', 'dwt-listing') => '',
                        esc_html__('Grid 1', 'dwt-listing') => 'grid1',
                        esc_html__('Grid 2', 'dwt-listing') => 'grid2',
                        esc_html__('Grid 3', 'dwt-listing') => 'grid3',
                        esc_html__('Grid 4', 'dwt-listing') => 'grid4',
                    ),
                ),
                array(
                    "group" => esc_html__("Listing Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Listings", 'dwt-listing'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Listing Settings", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("View All Link", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
                ),
                array
                    (
                    "group" => esc_html__("Categories", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category ( All or Selective )', 'dwt-listing'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('l_category', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_all_listings');
if (!function_exists('d_listings_base_func')) {

    function d_listings_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/get_listings.php";
        $section_id = $view_all_btn = '';
        $custom_class = 'papular-listing-2';
        if ($layout_type == 'grid2') {
            $custom_class = '';
            $section_id = 'id="Papular-listing"';
        }
        $button = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme', false, false, '');
        if ($button) {
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button . '</div>
				</div>';
        }
        return '<section ' . $section_id . ' class="' . $custom_class . ' ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row masonry_container">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   ' . $fetch_listingz . '
               
				' . $view_all_btn . '
			   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_listings_base', 'd_listings_base_func');
}