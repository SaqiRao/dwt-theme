<?php
/* ------------------------------------------------ */
/* About Us Classic */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_about_us2')) {

    function dwt_listing_about_us2() {
        vc_map(array(
            "name" => esc_html__("About Us (New)", 'dwt-listing'),
            "base" => "d_about_us_base2",
            "category" => esc_html__("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-ui-custom_heading",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('about-new.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'dwt-listing'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'dwt-listing') => '',
                        esc_html__('White', 'dwt-listing') => '',
                        esc_html__('Gray', 'dwt-listing') => 'bg-gray',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("About Heading", 'dwt-listing'),
                    "param_name" => "section_title",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Your Tagline", 'dwt-listing'),
                    "param_name" => "section_tag_line",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'dwt-listing'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select Image Position", 'dwt-listing'),
                    "param_name" => "img_postion",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Left', 'dwt-listing') => 'left',
                        esc_html__('Right', 'dwt-listing') => 'right',
                    ),
                    "description" => esc_html__("Chose image position.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("About Us", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Button Link", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Ridirect.", 'dwt-listing'),
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
            ),
        ));
    }

}

add_action('vc_before_init', 'dwt_listing_about_us2');

if (!function_exists('d_about_us_base_func2')) {

    function d_about_us_base_func2($atts, $content = '') {
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
    dwt_listing_add_code('d_about_us_base2', 'd_about_us_base_func2');
}