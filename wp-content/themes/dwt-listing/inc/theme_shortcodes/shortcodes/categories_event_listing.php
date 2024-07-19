<?php
if (!function_exists('dwt_listing_evevtz_categories')) {

    function dwt_listing_evevtz_categories() {
        vc_map(array(
            "name" => __("Event Categories", 'dwt-listing'),
            "base" => "d_custom_eventz_cats_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "vc_icon-vc-gitem-image",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('event_cats.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                array
                    (
                    "group" => esc_html__("Categories", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'dwt-listing'),
                    'param_name' => 'grid_cats',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "grid_cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('l_event_cat', 'no'),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Category Icon", 'dwt-listing'),
                            "param_name" => "loc_img",
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_evevtz_categories');
if (!function_exists('d_custom_eventz_cats_base_func')) {

    function d_custom_eventz_cats_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        //grid categories
        $grid_categories = $bgImageURL = $cat_icon = $link = '';
        if (isset($atts['grid_cats'])) {
            $all_cats = vc_param_group_parse_atts($atts['grid_cats']);
            if (!empty($all_cats) && count($all_cats) > 0) {
                foreach ($all_cats as $catz) {
                    if (isset($catz['grid_cat'])) {
                        $fetch_category = get_term($catz['grid_cat'], 'l_event_cat');
                        if (!empty($fetch_category)) {
                            if (is_array($fetch_category) && count($fetch_category) == 0)
                                continue;
                            $count = $fetch_category->count;
                            if (isset($catz['loc_img']) && $catz['loc_img'] != "") {
                                $bgImageURL = dwt_listing_return_img_src($catz['loc_img'], 'dwt_listing_woo-thumb');
                            }
                            //$link = get_term_link($fetch_category->term_id);
                            $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                            $grid_categories .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
									<a href="' . $link . '">
										<div class="event-list-cat red">
											<img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . $fetch_category->name . '">
											<div class="event-cat-hover">
												<h2>' . $fetch_category->name . '</h2>
												<span>' . $count . ' ' . esc_html__('Events', 'dwt-listing') . '</span>
											</div>
										</div>
									</a>
								</div>';
                        }
                    }
                }
            }
        }
        return '<section class="' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   		' . $grid_categories . '
			   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_custom_eventz_cats_base', 'd_custom_eventz_cats_base_func');
}