<?php
if (!function_exists('dwt_listing_custom_locations')) {

    function dwt_listing_custom_locations() {
        vc_map(array(
            "name" => __("Custom Locations", 'dwt-listing'),
            "base" => "d_custom_locations_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "vc_icon-vc-masonry-media-grid",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('loc.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => esc_html__("Show Pattern Image", 'dwt-listing'),
                    "param_name" => "pattern_chk",
                    "value" => 1,
                    'std' => '1',
                    "description" => esc_html__('Show pattern image at right side of section', 'dwt-listing') . '</strong>',
                ),
                array(
                    "group" => esc_html__("Location", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Locations', 'dwt-listing'),
                    'param_name' => 'select_locations',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Select Custom Location", 'dwt-listing'),
                            "param_name" => "name",
                            'settings' => array('values' => dwt_listing_location_data_shortcode()),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Location Image", 'dwt-listing'),
                            "param_name" => "loc_img",
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_custom_locations');
if (!function_exists('d_custom_locations_base_func')) {

    function d_custom_locations_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        $locations_html = '';
        $show_pattern = '';
        if (!empty($pattern_chk) && $pattern_chk == 'true') {
            $show_pattern = 'new-blog-section-3';
        }
        $get_locationz = vc_param_group_parse_atts($atts['select_locations']);
        if (!empty($get_locationz) && count($get_locationz) > 0) {
            foreach ($get_locationz as $locationz) {
                $img_thumb = '';
                $get_locationz_idz = (isset($locationz['name'])) ? $locationz['name'] : '';
                $location_img = (isset($locationz['loc_img'])) ? $locationz['loc_img'] : '';
                if (wp_attachment_is_image($location_img)) {
                    $img_url = wp_get_attachment_image_src($location_img, 'dwt_listing_blogpost-thumb');
                    $img_thumb = $img_url[0];
                } else {
                    $img_thumb = dwt_listing_defualt_img_url();
                }
                $term = get_term_by('id', $get_locationz_idz, 'l_location');
                if (count((array) $term) > 0 && !empty($term) && !is_wp_error($term)) {
                    //$link = get_term_link($term->term_id);
                    $link = dwt_cat_link_page(get_term_link($term->term_id));
                    $locations_html .= '<div class="col-sm-6 col-xs-12 col-md-4">
                          <a href="' . esc_url($link) . '">
                             <div class="country-box">
                                <div class="country-images">
                                	<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_html__('not found', 'dwt-listing') . '">
                                </div>
                                <div class="country-description-overlay">
                                   <div class="country-description">
                                   		<h2 class="country-name">' . $term->name . ' </h2>
                                   		<p class="country-ads"> ' . $term->count . ' ' . esc_html__('Listings', 'dwt-listing') . ' </p>
                                   </div>
                                </div>
                                <span class="featured-badge"><i class="fa fa-star-o"></i></span>
                             </div>
                          </a>
                       </div>';
                }
            }
        }
        return '<section class="cities-section ' . $show_pattern . ' ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div class="cities-grid-area posts-masonry">' . $locations_html . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_custom_locations_base', 'd_custom_locations_base_func');
}