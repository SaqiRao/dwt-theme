<?php
if (!function_exists('dwt_listing_text_block')) {

    function dwt_listing_text_block() {
        vc_map(array(
            "name" => __("DWT Text Block", 'dwt-listing'),
            "base" => "d_txt_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "vc_element-icon icon-wpb-woocommerce",
            "params" => array(
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
                    "group" => esc_html__("Content Area", "dwt-listing"),
                    "type" => "textarea_html",
                    "holder" => "div",
                    "param_name" => "content",
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_text_block');
if (!function_exists('d_txt_base_func')) {

    function d_txt_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        return '<section class="blog-post-container ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
				   <div class="col-md-12 col-sm-12 col-xs-12">
					   <div class="single-blog blog-detial">
						   <div class="blog-post">
							   <div class="post-excerpt post-desc">
									' . $content . '
							   </div>
						   </div>
					   </div>
				   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_txt_base', 'd_txt_base_func');
}