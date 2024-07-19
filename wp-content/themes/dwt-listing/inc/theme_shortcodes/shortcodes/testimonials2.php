<?php
if (!function_exists('dwt_listing_testimonials2')) {

    function dwt_listing_testimonials2() {
        vc_map(array(
            "name" => __("Testimonials(New)", 'dwt-listing'),
            "base" => "d_testimonials_base2",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-images-carousel",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('feedback2.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    'group' => esc_html__('Testimonials', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Testimonials', 'dwt-listing'),
                    'param_name' => 'testimonials',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("User Name", 'dwt-listing'),
                            "param_name" => "testi_user_name",
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "heading" => esc_html__("Description", 'dwt-listing'),
                            "param_name" => "testi_desc",
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("User Desgination", 'dwt-listing'),
                            "param_name" => "testi_user_desg",
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("User Image", 'dwt-listing'),
                            "param_name" => "loc_img",
                            "description" => esc_html__('recommended size 70x70', 'dwt-listing') . '</strong>',
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_testimonials2');
if (!function_exists('d_testimonials_base_func2')) {

    function d_testimonials_base_func2($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        $user_img = $bgImageURL = $testimonials = '';
        $rows = vc_param_group_parse_atts($atts['testimonials']);
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                $user_img = '';
                if (isset($row['testi_desc']) && $row['testi_desc'] != "") {
                    if (isset($row['loc_img']) && $row['loc_img'] != "") {
                        $bgImageURL = dwt_listing_return_img_src($row['loc_img']);
                        $user_img .= '<div class="feedback-user-img">
                            	<img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . esc_html__('image not found', 'dwt-listing') . '">
                        	</div>';
                    }
                    $testi_user_desg = '';
                    if(isset($row['testi_user_desg']) && $row['testi_user_desg'] != ""){
                        $testi_user_desg = $row['testi_user_desg'];
                    }
                    $testimonials .= '<div class="feedback-type2 text-center draw-border">
                        ' . $user_img . '
                        <div class="feedback-desc">
                            <h5>' . $row['testi_user_name'] . '</h5>
                            <h6>' . $testi_user_desg . '</h6>							
							<div class="quote-arrow">
                            <p>' . $row['testi_desc'] . '</p>
							</div>
                        </div>
                   </div>';
                }
            }
        }
        return '<section class="testimonial-style-2 ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div  class="feedbacks1 owl-carousel owl-theme">' . $testimonials . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_testimonials_base2', 'd_testimonials_base_func2');
}