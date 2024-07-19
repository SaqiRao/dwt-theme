<?php
if (!function_exists('dwt_listing_hero_7')) {

    function dwt_listing_hero_7() {
        vc_map(array(
            "name" => __("Hero Section 7 (YouTube)", 'dwt-listing'),
            "base" => "d_hero_7_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('youtube.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Heading One", 'dwt-listing'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Heading Two", 'dwt-listing'),
                    "param_name" => "form_text",
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
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                    "description" => esc_html__("1920x800", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("BG Video", 'dwt-listing'),
                    "description" => __("Youtube video url.", 'dwt-listing'),
                    "param_name" => "section_video",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "vc_link",
                    "heading" => esc_html__("Button ", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_7');
if (!function_exists('d_hero_7_base_func')) {

    function d_hero_7_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        extract(shortcode_atts(array(
            'section_video' => '',
            'section_tag_line' => '',
                        ), $atts));
        $btn_1 = $button = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme active', false, false, '');
        if (isset($button)) {
            $btn_1 = '<div class="intro-btn">' . $button . '</div>';
        }
        $style = $bgImageURL = '';
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background-image:url(' . $bgImageURL . ');background-position: center;background-repeat: no-repeat;background-size: cover; height: 100%; "' : "";
        }
        wp_enqueue_script('ytPlyer', trailingslashit(get_template_directory_uri()) . 'assets/js/jquery.mb.YTPlayer.min.js', false, false, true);
        $script = '<script>jQuery(document).ready(function () {
			jQuery(".youtube-bg").mb_YTPlayer();
		});</script>';
        return $script . '<section class="hero-youtube " ' . $style . '>
  <div class="video_overlay"></div>
  <a id="video" class="youtube-bg" data-property="{videoURL:\'' . $section_video . '\',containment:\'.hero-youtube\', quality:\'highres\', autoPlay:true, loop:true, showControls: false, startAt:1,  mute:true, opacity: 1, origin: \'' . home_url('/') . '\'}">' . __('Video', 'dwt-listing') . '</a>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12 text-center">
        <h1 class="hero-title">' . $section_title . '<br>
          ' . $form_text . '</h1>
        <p class="hero-tagline">' . $section_tag_line . ' </p>
        ' . $btn_1 . '
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_7_base', 'd_hero_7_base_func');
}