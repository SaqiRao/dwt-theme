<?php
if (!function_exists('dwt_listing_hero_10')) {

    function dwt_listing_hero_10() {
        vc_map(array(
            "name" => __("Hero Section 10", 'dwt-listing'),
            "base" => "d_hero_10_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-application-icon-large",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero3.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Hero Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Hero Section Tagline", 'dwt-listing'),
                    "param_name" => "section_tag_line",
                ),
                array(
                    "group" => esc_html__("Settings", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Hero Section Title", 'dwt-listing'),
                    "param_name" => "rotating_words",
                    'description' => esc_html__('Use | sign to add more words eg ( Attratction|Explore City|Food ).', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Google location or custom location?", 'dwt-listing'),
                    "param_name" => "google_or_custom",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Google location', 'dwt-listing') => 'google',
                        esc_html__('Custom location', 'dwt-listing') => 'custom',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array(
                    "group" => esc_html__("Settings", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Locations', 'dwt-listing'),
                    'param_name' => 'select_locations',
                    'dependency' => array('element' => 'google_or_custom', 'value' => array('custom')),
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "autocomplete",
                            "holder" => "div",
                            "heading" => esc_html__("Location Name", 'dwt-listing'),
                            "param_name" => "name",
                            'settings' => array('values' => dwt_listing_location_data_shortcode()),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_10');
if (!function_exists('d_hero_10_base_func')) {

    function d_hero_10_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        $location = '';
        $cats_html = '';
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ');background-position-x: 0%;background-position-y: 0%;background-size: auto;background-size: cover;background-position: center center;"' : "";
        }
        $form_action = dwt_listing_pagelink('dwt_listing_seacrh_page');
        $options = explode('|', $rotating_words);
        $options = json_decode(json_encode($options), FALSE);
        wp_localize_script('dwt-listing-custom', 'get_typed', array('type_strings' => $options));
        //fetch locations
        if ($google_or_custom == 'google') {
            $check_class = $location_icon = '';
            if (dwt_listing_text('dwt_listing_enable_geo') == '1') {
                $check_class = 'specific-search';
                $location_icon = '<i class="detect-me fa fa-crosshairs"></i>';
            }
            dwt_listing_google_locations();
            wp_enqueue_script("google-map-callback");
            $location = '<div class="form-group ' . $check_class . '">
				<input id="address_location" name="street_address" placeholder="' . esc_html__('Location...', 'dwt-listing') . '"  type="text">
				' . $location_icon . '
			  </div>';
        } else {
            if (function_exists('vc_param_group_parse_atts')) {
            $location = dwt_listing_return_selective_location(vc_param_group_parse_atts($atts['select_locations']), 'yes');
        }}
        return '<div class="typed-hero-section" ' . $style . '>
            <form class="custom-style-search" action="' . esc_url($form_action) . '">
                <fieldset>
                    <legend><h1>' . esc_attr($section_title) . ' <span class="typed typed-words"></span></h1></legend>
                    <p>' . esc_attr($section_tag_line) . '</p>
                </fieldset>
                <div class="inner-form">
                    <div class="left">
                        <div class="input-wrap first">
                            <div class="input-field first">
                                <label>' . esc_html__('Explore', 'dwt-listing') . '</label>
                                <div class="typeahead__container">
                                    <div class="typeahead__field">
                                        <div class="typeahead__query">
                                            <input class="for_sp_home dwt-search" autocomplete="off" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" value="" type="search">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-wrap second">
                            <div class="input-field second">
                                <label>' . esc_html__('Where', 'dwt-listing') . '</label>
                                ' . $location . '
                            </div>
                        </div>
                    </div>
                    <button class="btn-search" type="submit">' . esc_html__('Search', 'dwt-listing') . '</button>
                </div>
                <input id="by_title_home" type="hidden" name="by_title" value="">
                <input id="l_category_home" type="hidden" name="l_category" value="">
                <input id="l_tag_home" type="hidden" name="l_tag" value="">
                '. dwt_listing_form_lang_field_callback(false) .'
            </form>
        </div>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_10_base', 'd_hero_10_base_func');
}