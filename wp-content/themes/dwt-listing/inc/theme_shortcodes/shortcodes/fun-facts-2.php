<?php
/* ------------------------------------------------ */
/* Fun Facts */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_funfacts_2')) {

    function dwt_listing_funfacts_2() {
        vc_map(array(
            "name" => esc_html__("Fun Facts (New)", 'dwt-listing'),
            "base" => "fun_facts_base_2",
            "category" => esc_html__("Theme Shortcodes", 'dwt-listing'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('funfacts_2.png') . esc_html__('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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

add_action('vc_before_init', 'dwt_listing_funfacts_2');

if (!function_exists('fun_facts_base_func_2')) {

    function fun_facts_base_func_2($atts, $content = '') {
        extract(shortcode_atts(array(
            'bg_img' => '',
            'p_cols' => '3',
            'fun_facts' => '',
            'feature_img' => '',
            'features_img' => '',
                        ), $atts));

        $fun_html = $featureimg = $feature_img = '';
        $rows = vc_param_group_parse_atts($atts['fun_facts']);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                if ($row['numbers'] != "" && $row['title'] != "") {
                    if (isset($row['features_img']) && $row['features_img'] != '' && wp_attachment_is_image($row['features_img'])) {
                        $feature_img = dwt_listing_return_img_src($row['features_img']);
                        if (isset($feature_img) && $feature_img != '') {
                            $featureimg = '<div class="icon-container"> <img src="' . $feature_img . '" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '" class="img-responsive"> </div>';
                        }
                    } else {
                        $featureimg = '<div class="icon-container"><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/category.png' . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                    }
                    $fun_html .= '<div class="counter-seprator">
									<div class="counter-box">
									   <h5 class="counter-stats">' . $row['numbers'] . '</h5>
									   <p class="count-title">' . $row['title'] . '</p>
									</div>
									' . $featureimg . '
                     			  </div>';
                }
            }
        }
        $style = '';
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        return '<section class="buisness-listing-section" ' . $style . '>
		<div class="buisness-inner-section"> <img  src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/lines.png') . '" alt="" class="img-responsive"> </div>
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
                  <div class="conter-grid">
                     ' . $fun_html . '
                  </div>
               </div>
            </div>
         </div>
      </section>';
    }

}

if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('fun_facts_base_2', 'fun_facts_base_func_2');
}