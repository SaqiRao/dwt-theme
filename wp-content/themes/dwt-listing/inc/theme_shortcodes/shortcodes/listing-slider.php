<?php
if (!function_exists('dwt_listing_listing_slider')) {

    function dwt_listing_listing_slider() {
        vc_map(array(
            "name" => __("Listing Slider", 'dwt-listing'),
            "base" => "d_slider_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('listing_slider.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
add_action('vc_before_init', 'dwt_listing_listing_slider');
if (!function_exists('d_slider_base_func')) {

    function d_slider_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if ($layout_type == '') {
            $layout_type = 'grid4';
        }
        $cats = array();
        $rows = vc_param_group_parse_atts($atts['cats']);
        if (!empty($rows) && count((array) $rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == 'all') {
                        break;
                    } else {
                        $cats[] = $row['cat'];
                    }
                }
            }
        }
        $category = '';
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => dwt_listing_countires_cookies(),
                ),
            );
        }
        //post status active only
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        //query 
        $args = array
            (
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $slider_html = $start_div = $end_div = '';
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            if ($layout_type == "grid1") {
                $start_div = '<div class="papular-listing-2">';
                $end_div = '</div>';
            }
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $slider_html .= $listingz->$function($listing_id, '12', true, 'no');
            }
        }
        wp_reset_postdata();

        return '<section id="papular-listing" class="' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
              <div class="col-md-12 col-sm-12 col-xs-12">
			  ' . $start_div . '
              	<div class="papular-listing-2-slider owl-carousel owl-theme">
                 ' . $slider_html . '
                </div>
				' . $end_div . '
              </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_slider_base', 'd_slider_base_func');
}