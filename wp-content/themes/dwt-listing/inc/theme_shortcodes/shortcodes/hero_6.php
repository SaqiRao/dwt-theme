<?php
if (!function_exists('dwt_listing_hero_6')) {

    function dwt_listing_hero_6() {
        vc_map(array(
            "name" => __("Hero Section 6", 'dwt-listing'),
            "base" => "d_hero_6_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero6.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "group" => esc_html__("Buttons Settings", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("First Button", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
                ),
                array(
                    "group" => esc_html__("Buttons Settings", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Second Button", 'dwt-listing'),
                    "param_name" => "main_link_2",
                    "description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
                ),
                array(
                    "group" => esc_html__("Buttons Settings", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Section Image", 'dwt-listing'),
                    "param_name" => "app_img",
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_6');
if (!function_exists('d_hero_6_base_func')) {

    function d_hero_6_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ') no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $loc_imgz = $static_image = '';
        if (isset($app_img) && $app_img != "") {
            if (wp_attachment_is_image($app_img)) {
                $static_image = dwt_listing_return_img_src($app_img);
            } else {
                $static_image = trailingslashit(get_template_directory_uri()) . 'assets/images/pets.png';
            }
            $loc_imgz = '<img class="img-responsive center-block" src="' . esc_url($static_image) . '" alt="' . esc_html__('image not found', 'dwt-listing') . '">';
        }


        $btn_1 = $button = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme btn-active', false, false, '');
        if ($button) {
            $btn_1 = '<li>' . $button . '</li>';
            ;
        }

        $btn_2 = $button2 = '';
        $button2 = dwt_listing_get_button($main_link_2, 'btn btn-theme', false, false, '');
        if ($button2) {
            $btn_2 = '<li>' . $button2 . '</li>';
            ;
        }

        return '<div class="classical-hero" ' . $style . '>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="hero-content-extra text-center">
                        <h1>' . $section_title . '</h1>
                        <p>' . $section_tag_line . '</p>
                        <ul class="buttons-case">
                            ' . $btn_1 . '
                            ' . $btn_2 . '
                        </ul>
                    </div>
                </div>
            </div>
           ' . $loc_imgz . '
        </div>
    </div>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_6_base', 'd_hero_6_base_func');
}