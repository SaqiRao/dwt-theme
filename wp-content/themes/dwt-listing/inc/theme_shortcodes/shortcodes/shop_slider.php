<?php
if (!function_exists('dwt_listing_shop_slider')) {

    function dwt_listing_shop_slider() {
        vc_map(array(
            "name" => __("Shop With Grids & Slider", 'dwt-listing'),
            "base" => "d_shop_slider_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "vc_element-icon icon-wpb-woocommerce",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('shop_grid.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "group" => esc_html__("Products Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Products", 'dwt-listing'),
                    "param_name" => "max_limit",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Products Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Product Layout Type", 'dwt-listing'),
                    "param_name" => "shop_layout_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Grids', 'dwt-listing') => 'grid',
                        esc_html__('Slider', 'dwt-listing') => 'slider',
                    ),
                ),
                array(
                    "group" => esc_html__("Products Settings", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("View All Products Link", 'dwt-listing'),
                    "param_name" => "main_link",
                    'dependency' => array('element' => 'shop_layout_type', 'value' => array('grid')),
                    "description" => esc_html__("Link You Want To Redirect.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Products Settings", "dwt-listing"),
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
                array
                    (
                    'group' => esc_html__('Categories', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'dwt-listing'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('product_cat', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_shop_slider');
if (!function_exists('d_shop_slider_base_func')) {

    function d_shop_slider_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/get_products.php";
        $caresol_start = $caresol_end = '';
        if ($shop_layout_type == 'slider') {
            $caresol_start = '<div class="related-produt-slider owl-carousel owl-theme">';
            $caresol_end = '</div>';
        }
        $view_all_btn = $button = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme', false, false, '');
        if ($button) {
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button . '</div>
				</div>';
        }

        return '<section class="rel-products woocommerce ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 products nopadding">
				   
						' . $caresol_start . '
							' . $fetch_products . '
						' . $caresol_end . '	
						
						
					</div>
					' . $view_all_btn . '
				  </div>
            </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_shop_slider_base', 'd_shop_slider_base_func');
}