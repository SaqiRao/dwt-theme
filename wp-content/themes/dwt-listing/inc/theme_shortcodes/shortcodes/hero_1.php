<?php
if (!function_exists('dwt_listing_hero_1')) {

    function dwt_listing_hero_1() {
        vc_map(array(
            "name" => __("Hero Section 1", 'dwt-listing'),
            "base" => "d_hero_1_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero1.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                    "description" => esc_html__("%count% for total ads.", 'dwt-listing'),
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
                    "group" => __("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Search Form Text", 'dwt-listing'),
                    "param_name" => "form_text",
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => esc_html__("Show Clody Image", 'dwt-listing'),
                    "param_name" => "pattern_chk",
                    "value" => 1,
                    'std' => '1',
                    "description" => esc_html__('Show cludy image at top of section', 'dwt-listing') . '</strong>',
                ),
                array
                    (
                    "group" => esc_html__("Search Form", "dwt-listing"),
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
                array(
                    "group" => esc_html__("Location", "dwt-listing"),
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
                    "group" => esc_html__("Location", "dwt-listing"),
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
                array
                    (
                    "group" => esc_html__("Grid Categories", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'dwt-listing'),
                    'param_name' => 'grid_cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "grid_cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('l_category', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_1');
if (!function_exists('d_hero_1_base_func')) {

    function d_hero_1_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $count_listings = wp_count_posts('listing');
        $cats_html = $location = '';
        //fetch catefories
        $cats_html = dwt_listing_return_cats_features(vc_param_group_parse_atts($atts['cats']), $want_to_show);
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
				<label>' . esc_html__('By Street Address', 'dwt-listing') . '</label>
				<input class="form-control" id="address_location" name="street_address" placeholder="' . esc_html__('Location...', 'dwt-listing') . '"  type="text">
				' . $location_icon . '
			  </div>';
        } else {
            $location = dwt_listing_return_selective_location(vc_param_group_parse_atts($atts['select_locations']));
        }

        //grid categories
        $grid_categories = $cat_icon = $link = '';
        if (isset($atts['grid_cats'])) {
            $all_cats = vc_param_group_parse_atts($atts['grid_cats']);
            $g_cats = false;
            if (!empty($all_cats) && count($all_cats) > 0) {
                foreach ($all_cats as $catz) {
                    if (isset($catz['grid_cat'])) {
                        if ($catz['grid_cat'] == 'all') {
                            $g_cats = true;
                            $grid_categories = '';
                            break;
                        }
                        $fetch_category = get_term($catz['grid_cat'], 'l_category');
                        if (count((array) $fetch_category) == 0)
                            continue;
                        $cat_icon = get_term_meta($fetch_category->term_id, 'category_icon', true);

                        //$link = get_term_link($fetch_category->term_id);
                        $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                        $grid_categories .= '<div class="catz_iconz"><a href="' . $link . '" class="' . $cat_icon . ' new_v1"></a><span><a href="' . $link . '"> ' . $fetch_category->name . ' </a></span></div>';
                    }
                }
                if ($g_cats) {
                    $ad_catz = dwt_listing_categories_fetch('l_category', 0);
                    if (is_array($ad_catz) && count($ad_catz) > 0) {
                        foreach ($ad_catz as $my_cat) {
                            $cat_icon = get_term_meta($my_cat->term_id, 'category_icon', true);
                            //$link = get_term_link($my_cat->term_id);
                            $link = dwt_cat_link_page(get_term_link($my_cat->term_id));
                            $grid_categories .= '<div class="catz_iconz"><a href="' . $link . '" class="' . $cat_icon . ' new_v1"></a><span><a href="' . $link . '"> ' . $my_cat->name . ' </a></span></div>';
                        }
                    }
                }
            }
        }

        if (is_rtl()) {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow-rtl.png');
        } else {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow.png');
        }
        $show_pattern = '';
        if (!empty($pattern_chk) && $pattern_chk == 'true') {
            $show_pattern = 'd-cloudy';
        }
        return '<section id="intro-hero" ' . $style . ' class="' . $show_pattern . '">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
        <div class="hero-text-box">
          <h1 class="hero-title">' . str_replace('%count%', '<strong>' . $count_listings->publish . '</strong>', $section_title) . '</h1>
          <h2> ' . esc_attr($section_tag_line) . ' </h2>
          <div class="category-section">
            <div class="highlighted-text"> <img class="main-arrow" src="' . $arrow . '" alt="' . esc_html__('dwt-listing', 'dwt-listing') . '"> </div>
            <div class="category-list1 owl-carousel owl-theme"  id="main-section-slider">
            	' . $grid_categories . '
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-lg-4 col-sm-6 col-xs-12 col-lg-offset-1">
        <form class="custom-style-search form-join" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
          <h4>' . esc_attr($form_text) . '</h4>
          <div class="form-group">
            <label>' . esc_html__('Title', 'dwt-listing') . '</label>
			<div class="typeahead__container">
            <div class="typeahead__field">
                <div class="typeahead__query">
            <input class="dget_listings form-control for_s_home" autocomplete="off" name="by_title" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" value="" type="search">
			</div>
			</div>
			</div>
          </div>
          <div class="form-group">
            <label>' . esc_html__('Select Category', 'dwt-listing') . '</label>
            <select data-placeholder="' . esc_html__('Select Business Category', 'dwt-listing') . '" class="custom-select" name="l_category">
			 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
              ' . $cats_html . '
            </select>
          </div>
          ' . $location . '
          <button class="btn btn-theme btn-block" type="submit">' . esc_html__('Search', 'dwt-listing') . '</button>
          ' . dwt_listing_form_lang_field_callback(false) . '
        </form>
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_1_base', 'd_hero_1_base_func');
}