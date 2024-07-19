<?php
if (!function_exists('dwt_listing_hero_3')) {

    function dwt_listing_hero_3() {
        vc_map(array(
            "name" => __("Hero Section 3", 'dwt-listing'),
            "base" => "d_hero_3_base",
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
                    "group" => esc_html__("Event Or Listing", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select Shortcode Search Type", 'dwt-listing'),
                    "param_name" => "event_or_listing",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('For Events Search', 'dwt-listing') => 'd_events',
                        esc_html__('For Listing Search', 'dwt-listing') => 'd_listing',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_3');
if (!function_exists('d_hero_3_base_func')) {

    function d_hero_3_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $form_action = dwt_listing_pagelink('dwt_listing_seacrh_page');
        if ($event_or_listing == 'd_events') {
            $form_action = dwt_listing_pagelink('dwt_listing_event_page');
        }
        return '<div class="event-hero-intro for-my-locz" ' . $style . '>
            <div class="container">
                <div class="text-center">
                    <h1>' . $section_title . ' <span class=""></span> </h1>
                    <p class="lead">' . $section_tag_line . '</p>
                </div>
                <form class="event-hero-intro-search" action="' . esc_attr($form_action) . '">
                   <div class="search_box">
                   <div class="col-md-9 col-sm-9 col-xs-12 nopadding">
                     <input name="by_title" placeholder="' . esc_html__('What are you looking for ?', 'dwt-listing') . '" type="text">
                   </div>
                   <div class="col-md-3 col-sm-3 col-xs-12 nopadding"> 
                     <button class="common-button" onclick="this.form.submit()" type="submit"> ' . esc_html__('Search', 'dwt-listing') . '  <i class="fa fa-search"></i></button>
                   '. dwt_listing_form_lang_field_callback(false) .'
                    </div> 
                    </div>
                </form>
				
            </div>
        </div>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_3_base', 'd_hero_3_base_func');
}