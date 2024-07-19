<?php
/* ------------------------------------------------ */
/* Fun Facts */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_funfacts')) {

    function dwt_listing_funfacts() {
        vc_map(array(
            "name" => esc_html__("Fun Facts", 'dwt-listing'),
            "base" => "fun_facts_base",
            "category" => esc_html__("Theme Shortcodes", 'dwt-listing'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('funfacts.png') . esc_html__('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                    "description" => esc_html__("1280x800", 'dwt-listing'),
                ),
                array
                    (
                    'group' => esc_html__('Fun Facts', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Fun Fact', 'dwt-listing'),
                    'param_name' => 'fun_facts',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            'group' => esc_html__('Fun Facts', 'dwt-listing'),
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Numbers", 'dwt-listing'),
                            "param_name" => "numbers",
                        ),
                        array(
                            'group' => esc_html__('Fun Facts', 'dwt-listing'),
                            "type" => "textfield",
                            "holder" => "div",
                            "heading" => esc_html__("Title", 'dwt-listing'),
                            "param_name" => "title",
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "heading" => esc_html__("Location Image", 'dwt-listing'),
                            "param_name" => "features_img",
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'dwt_listing_funfacts');

if (!function_exists('fun_facts_base_func')) {

    function fun_facts_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'p_cols' => '3',
            'fun_facts' => '',
            'feature_img' => '',
                        ), $atts));

        $fun_html = $featureimg = $feature_img = '';
        if (function_exists('vc_param_group_parse_atts')) {
        $rows = vc_param_group_parse_atts($atts['fun_facts']);
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if ($row['numbers'] != "" && $row['title'] != "") {
                        if (isset($row['features_img']) && $row['features_img'] != '' && wp_attachment_is_image($row['features_img'])) {
                            $feature_img = dwt_listing_return_img_src($row['features_img']);
                            if (isset($feature_img) && $feature_img != '') {
                                $featureimg = '<div class="icon-container"><img src="' . $feature_img . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                            }
                        } else {
                            $featureimg = '<div class="icon-container"><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/category.png' . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                        }
                        $fun_html .= '<div class="counter-seprator">
                        ' . $featureimg . '
                            <div class="counter-box">
                            <h5 class="counter-stats">' . $row['numbers'] . '</h5>
                            <h3 class="count-title">' . $row['title'] . '</h3>
                            </div>
                        </div>';
                    }
                }
            }
        }
        $style = '';
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }

        return '<div class="funfacts arch-funfacts" ' . $style . '>
            <div class="container">
               <div class="row">
				   <div class="col-md-12 col-sm-12 nopadding">
				   		<div class="conter-grid">' . $fun_html . '</div>
				   </div>
			   </div>
            </div>
         </div> ';
    }

}

if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('fun_facts_base', 'fun_facts_base_func');
}