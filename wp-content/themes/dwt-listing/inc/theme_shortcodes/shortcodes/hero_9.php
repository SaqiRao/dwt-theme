<?php
if (!function_exists('dwt_listing_hero_9')) {

    function dwt_listing_hero_9() {
        vc_map(array(
            "name" => __("Hero Section 9 (New)", 'dwt-listing'),
            "base" => "d_hero_9_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-film-youtube",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero9.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "group" => __("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("First Heading", 'dwt-listing'),
                    "param_name" => "form_text",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Tagline", 'dwt-listing'),
                    "param_name" => "section_tag_line",
                ),
                array(
                    "group" => esc_html__("Video Option", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Want to show background video", 'dwt-listing'),
                    "param_name" => "pattern_chk",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('No', 'dwt-listing') => '0',
                        esc_html__('Yes', 'dwt-listing') => '1'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array(
                    "group" => esc_html__("Video Option", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("BG Video", 'dwt-listing'),
                    "description" => __("Youtube video url.", 'dwt-listing'),
                    "param_name" => "section_video",
                    'dependency' => array('element' => 'pattern_chk', 'value' => array('1')),
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_9');
if (!function_exists('d_hero_9_base_func')) {

    function d_hero_9_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        extract(shortcode_atts(array(
            'section_video' => '',
            'section_tag_line' => '',
                        ), $atts));
        $p = $video = $script = $show_pattern = '';
        if (!empty($pattern_chk) && $pattern_chk == '1') {
            wp_enqueue_script('ytPlyer', trailingslashit(get_template_directory_uri()) . 'assets/js/jquery.mb.YTPlayer.min.js', false, false, true);
            $script = '<script>jQuery(document).ready(function () {
			jQuery(".youtube-bg").mb_YTPlayer();
		});</script>';
            $p = '';
            $video = '<div class="video_overlay_2"></div>
  <a id="video" class="youtube-bg" data-property="{videoURL:\'' . $section_video . '\',containment:\'.dwt-new-short9\', quality:\'highres\', autoPlay:true, loop:true, showControls: false, startAt:1,  mute:true, opacity: 1, origin: \'' . home_url('/') . '\'}">' . __('Video', 'dwt-listing') . '</a>';
        } else {
            $p = 'parallex';
        }
        $style = $bgImageURL = $cats_html = '';
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background-image:url(' . $bgImageURL . ');"' : "";
        }
        $addition_class = '';
        if (dwt_listing_text('dwt_listing_header-layout') == 1) {
            $addition_class = 'with-t-section';
        }
        return $script . '<section class="dwt-new-short9 ' . $p . ' ' . $addition_class . '" ' . $style . '>
		' . $video . '
		<div class="container">
    <div class="row">
       <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 text-white text-center">
      <div class="new-hero1">
        <h4>' . esc_attr($form_text) . '</h4>
        <h1>' . esc_attr($section_title) . '</h1>
        <p>' . esc_attr($section_tag_line) . '</p>
        <div class="search-form">
        <form class="custom-style-search" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
        <div class="typeahead__container hero9">
            <div class="typeahead__field">
                <div class="typeahead__query">
                    <input  class="for_sp_home dwt-search" placeholder="' . esc_html__('What Are You Looking For?', 'dwt-listing') . '" type="search" autofocus autocomplete="off">
                </div>
                <div class="typeahead__button">
                    <button type="submit">
                        <span class="typeahead__search-icon fa fa-search"></span><span>' . esc_html__('Search', 'dwt-listing') . ' </span>
                    </button>
                </div>
            </div>
        </div>
		<input id="by_title_home" type="hidden" name="by_title" value="">
		<input id="l_category_home" type="hidden" name="l_category" value="">
		<input id="l_tag_home" type="hidden" name="l_tag" value="">
                                            ' . dwt_listing_form_lang_field_callback(false) . '
      </form>
      </div>
      </div>
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_9_base', 'd_hero_9_base_func');
}