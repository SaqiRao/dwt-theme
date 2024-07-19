<?php
if (!function_exists('dwt_listing_events_slider')) {

    function dwt_listing_events_slider() {
        vc_map(array(
            "name" => __("Events Slider", 'dwt-listing'),
            "base" => "d_e_slider_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-ui-pageable",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('event_slider.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Event Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Layout Type", 'dwt-listing'),
                    "param_name" => "layout_type",
                    "admin_label" => true,
                    'value' => array(
                        esc_html__('Slider', 'dwt-listing') => '_slider',
                    ),
                    'std' => 'Slider', // Your default value
                ),
                array(
                    "group" => esc_html__("Event Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Order By", 'dwt-listing'),
                    "param_name" => "ad_order",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Events order', 'dwt-listing') => '',
                        esc_html__('Oldest', 'dwt-listing') => 'asc',
                        esc_html__('Latest', 'dwt-listing') => 'desc',
                        esc_html__('Random', 'dwt-listing') => 'rand'
                    ),
                ),
                array(
                    "group" => esc_html__("Event Settings", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Events", 'dwt-listing'),
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
                            "value" => dwt_listing_get_parests_cats('l_event_cat', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_events_slider');
if (!function_exists('d_e_slider_base_func')) {

    function d_e_slider_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/get_events.php";

        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat fixed center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        return '<section class="main-event" ' . $style . '>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
        <div class="event-box"> <span class="event-title"> ' . $section_title . ' </span>
          <div id="event-slider" class="owl-carousel owl-theme">
		 	 ' . $fetch_listingz . '
		  </div>
        </div>
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_e_slider_base', 'd_e_slider_base_func');
}