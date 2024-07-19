<?php
/* ------------------------------------------------ */
/* My Drop Downs */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_input_fields')) {

    function dwt_listing_input_fields() {
        vc_map(array(
            "name" => esc_html__("My Drop Down", 'dwt-listing'),
            "base" => "colorpicker",
            "category" => esc_html__("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-ui-custom_heading",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'text',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                ),
                array(
                    "group" => esc_html__("My Drop Down", 'dwt-listing'),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'dwt-listing'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'dwt-listing') => '',
                        esc_html__('White', 'dwt-listing') => '',
                        esc_html__('Gray', 'dwt-listing') => 'bg-gray',
                        esc_html__('Red', 'dwt-listing') => 'bg-red',
                    ),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("My Drop Down", 'dwt-listing'),
                    "type" => "dropdown",
                    "heading"=> esc_html__("select Your Country", 'dwt-listing'),
                    "param_name" =>"country_section",
                    "admin_label" => true,
                    "value" =>  array(
                        esc_html__('Select Your Country', 'dwt-listing')=> '',
                        esc_html__('Pakistan', 'dwt-listng') => 'Pakistan',
                        esc_html__('India', 'dwt-listing')=>'Pakistan',
                        esc_html__('Iran', 'dwt-listing')=>'Iran',
                        esc_html__('Afghanistan', 'dwt-listing')=>'Afghanistan',
                    ),
                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                    "std"=> '',
                    "description" => esc_html__( "Selec Your Country", 'dwt-listing' ),
                ),

                array(
                    "group" => esc_html__("My Drop Down", 'dwt-listing'),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("My Heading", 'dwt-listing'),
                    "param_name" => "section_title",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("My Drop Down", 'dwt-listing'),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Tagline", 'dwt-listing'),
                    "param_name" => "section_tag_line",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("My Drop Down", 'dwt-listing'),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'dwt-listing'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                
                
                array(
                    'group' => esc_html__('Features', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('List Features', 'dwt-listing'),
                    'param_name' => 'about_features',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Title", 'dwt-listing'),
                            "param_name" => "features_title",
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "heading" => esc_html__("Description", 'dwt-listing'),
                            "param_name" => "features_desc",
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Icons", 'dwt-listing'),
                            "param_name" => "features_img",
                            "description" => esc_html__("Recommended image size 64x64 .png ", 'dwt-listing'),
                        ),
                    )
                ),
                
                array(
                    'group' => esc_html__('Grid Images', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Recommended image size 260x260 & should be 4 images.', 'dwt-listing'),
                    'param_name' => 'grid_images',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Image", 'dwt-listing'),
                            "param_name" => "grid_img",
                            "description" => esc_html__("Recommended image size 260x260 & should be 4 images to avoid design conflict", 'dwt-listing'),
                        ),
                    )
                ),
                array(
                    'group' => esc_html__('Grid Images', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Recommended image size 260x260 & should be 4 images.', 'dwt-listing'),
                    'param_name' => 'grid_images',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Image", 'dwt-listing'),
                            "param_name" => "grid_img",
                            "description" => esc_html__("Recommended image size 260x260 & should be 4 images to avoid design conflict", 'dwt-listing'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'dwt_listing_input_fields');

if (!function_exists('d_input_field_base_func')) {

    function d_input_field_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        $img_left = $featureimg = $features = $img_right = '';
        $title = '';
        if ($section_title != '') {
            $title = '<h3>' . $section_title . '</h3>';
        }
        $tagline = '';
        if ($section_tag_line != '') {
            $tagline = '<h2>' . $section_tag_line . '</h2>';
        }
        $rows = vc_param_group_parse_atts($atts['about_features']);
        if (!empty($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['features_title']) && isset($row['features_desc'])) {
                    $feature_img = '';
                    if (isset($row['features_img']) && $row['features_img'] != "") {
                        if (wp_attachment_is_image($row['features_img'])) {
                            $feature_img = dwt_listing_return_img_src($row['features_img']);
                            if (isset($feature_img) && $feature_img != '') {
                                $featureimg = '<span class="iconbox"><img src="' . $feature_img . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></span>';
                            }
                        } else {
                            $featureimg = '<span class="iconbox"><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/category.png' . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></span>';
                        }
                    }
                    $features .= '<li>
                  <div class="choose-box">
				    ' . $featureimg . '
                    <div class="choose-box-content">
                      <h4>' . $row['features_title'] . '</h4>
                      <p>' . $row['features_desc'] . '</p>
                    </div>
                  </div>
                </li>';
                }
            }
        }

        $img_html = '';
        $rows_imgz = vc_param_group_parse_atts($atts['grid_images']);
        if (!empty($rows_imgz) && count($rows_imgz) > 0) {
            foreach ($rows_imgz as $rows_img) {
                if (isset($rows_img['grid_img']) && $rows_img['grid_img'] != "") {
                    if (wp_attachment_is_image($rows_img['grid_img'])) {
                        $gridz_img = dwt_listing_return_img_src($rows_img['grid_img']);
                        if (isset($gridz_img) && $gridz_img != '') {
                            $img_html .= '<li> <img src="' . $gridz_img . '" class="img-responsive" alt="' . esc_attr__('Image Not Found', 'dwt-listing') . '"> </li>';
                        }
                    } else {
                        $img_html .= '<li> <img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/small.png' . '" class="img-responsive" alt="' . esc_attr__('Image Not Found', 'dwt-listing') . '"> </li>';
                    }
                }
            }
        }
        $view_all_btn = '';
        $button = '';
        $button = dwt_listing_get_button($main_link, '', false, false, '');
        if ($button) {
            $view_all_btn = $button;
        }
        if ($img_postion == '') {
            $img_left = '<div class="col-md-6 col-lg-6 col-xs-12 hidden-sm hidden-xs">
					<div class="p-about-us">
						<ul class="p-call-action">
							' . $img_html . '
						</ul>
						<div class="p-absolute-menu">
							' . $view_all_btn . '
				   		</div>     
					</div>
				</div>';
        } else {
            $img_right = '<div class="col-md-6 col-lg-6 col-xs-12 hidden-xs">
					<div class="p-about-us">
						<ul class="p-call-action">
							' . $img_html . '
						</ul>
						<div class="p-absolute-menu">
						' . $view_all_btn . '
				   </div>     
					</div>
				</div>';
        }

        return '<section class="' . $class . ' ' . $bg_color . '">
			<div class="container">
				<div class="row">
				' . $img_left . '
					<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
						<div class="choose-title">
							' . $title . '
							' . $tagline . '
							<p>' . $section_description . '</p>
             			</div>
						  <div class="choose-services">
							  <ul class="choose-list">
								' . $features . '
							  </ul>
						  </div>
					</div>
				' . $img_right . '	
				</div>
			</div>
		</section>';
    }

}

if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_input_field_base', 'd_input_field_base_func');
}