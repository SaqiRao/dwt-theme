<?php
if (!function_exists('dwt_listing_elegent_categories')) {

    function dwt_listing_elegent_categories() {
        vc_map(array(
            "name" => __("Elegant Categories (New)", 'dwt-listing'),
            "base" => "d_elegent_cats_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "vc_icon-vc-gitem-image",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('elegent_cat.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("View All Link", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
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
                            "value" => dwt_listing_get_parests_cats('l_category', 'no'),
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Category Description", 'dwt-listing'),
                            "param_name" => "cat_desc",
                            "description" => esc_html__('Title for your section ', 'dwt-listing') . '</strong>',
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Category Image", 'dwt-listing'),
                            "param_name" => "loc_img",
                            "description" => esc_html__('Recommended Image size 360x240', 'dwt-listing') . '</strong>',
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_elegent_categories');
if (!function_exists('d_elegent_cats_base_func')) {

    function d_elegent_cats_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        //grid categories
        $cat_icon = $grid_categories = $bgImageURL = $cat_icon = $link = '';
        if (isset($atts['grid_cats']) && $atts['grid_cats'] != "") {
            $all_cats = vc_param_group_parse_atts($atts['grid_cats']);
            if (!empty($all_cats) && count($all_cats) > 0) {
                foreach ($all_cats as $catz) {
                    if (isset($catz['grid_cat'])) {
                        $fetch_category = get_term($catz['grid_cat'], 'l_category');
                        if (!empty($fetch_category)) {
                            if (is_array($fetch_category) && count((array) $fetch_category) == 0)
                                continue;
                            $count = $fetch_category->count;
                            if (isset($catz['loc_img']) && $catz['loc_img'] != "") {
                                $bgImageURL = dwt_listing_return_img_src($catz['loc_img'], 'dwt_listing_blogpost-thumb');
                            }
                            if (isset($catz['cat_desc']) && $catz['cat_desc'] != "") {
                                $cat_desc = '<p>' . $catz['cat_desc'] . '</p>';
                            }
                            if (get_term_meta($fetch_category->term_id, 'category_icon', true) != "") {
                                $cat_icon = '<div class="glyphicon-ring "><span class="' . get_term_meta($fetch_category->term_id, 'category_icon', true) . ' glyphicon-bordered"></span></div>';
                            }

                            //$link = get_term_link($fetch_category->term_id);
                            $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                            
                            $grid_categories .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							  <a class="dwt-new-catz" href="' . $link . '">
									<div class="e-cat-box">
										' . $cat_icon . '
										<img class="img-responsive" src="' . esc_url($bgImageURL) . '"  alt="' . $fetch_category->name . '">
										<div class="e-cat-overly">
										<div class="e-cat-desc">
											<h2 class="e-cat-name">' . $fetch_category->name . '</h2>
											' . $cat_desc . '
											<span class="e-cat-count"> ' . $count . ' ' . esc_html__('Listings', 'dwt-listing') . ' </span>
										</div>
									</div>
								</div>
							  </a>
							</div>';
                        }
                    }
                }
            }
        }

        $view_all_btn = $button = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme', false, false, '');
        if ($button) {
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button . '</div>
				</div>';
        }

        return '<section class="new-popular-listing ' . $bg_color . '" id="elegent_catz" ' . $style . '>
  <div class="container">
    <div class="row">
      ' . $header . '
      <div class="col-md-12 col-sm-12 col-xs-12 elegent-cats nopadding">
        ' . $grid_categories . '
        ' . $view_all_btn . '
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_elegent_cats_base', 'd_elegent_cats_base_func');
}