<?php
if (!function_exists('dwt_listing_hero_8')) {

    function dwt_listing_hero_8() {
        vc_map(array(
            "name" => __("Hero Section 8 (New)", 'dwt-listing'),
            "base" => "d_hero_8_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero8.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_8');
if (!function_exists('d_hero_8_base_func')) {

    function d_hero_8_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        ///fetch catefories
        $style = $bgImageURL = $cats_html = '';
        $cats_html = dwt_listing_return_cats_features(vc_param_group_parse_atts($atts['cats']), $want_to_show);
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background-image:url(' . $bgImageURL . ');"' : "";
        }
        $tags = '';
        $l_tags = get_terms(array('l_tags'), array('hierarchical' => 1));
        if (!is_wp_error($l_tags) && !empty($l_tags)) {
            foreach ($l_tags as $term) {
                $tags .= '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
            }
        }

        $addition_class = '';
        if (dwt_listing_text('dwt_listing_header-layout') == 1) {
            $addition_class = 'with-t-section';
        }

        return '<section class="new-hero-explore-section ' . $addition_class . '" ' . $style . '>
  <div class="new-layer-image"> <img class="img-responsive" alt="'. esc_html__('No Image found','dwt-listing') .'" src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/overlay.png') . '"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        <div class="dwt-new-hero">
            <h1>' . esc_attr($section_title) . ' </h1>
            <span class="sub-head">' . esc_attr($section_tag_line) . '</span>
          <div class="new-hero-search-bar">
          <form class="custom-style-search" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
            <div class="row">
              <div class="form-group input-iconz col-lg-4">
			  <div class="typeahead__container"><div class="typeahead__field"><div class="typeahead__query">
                <i class="ti-search"></i>
                <input class="dget_listings for_s_home" autocomplete="off" name="by_title" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" type="search">
				</div></div></div>
              </div>
              <div class="form-group input-iconz col-lg-3">
               <i class="ti-reload"></i>
				<select data-placeholder="' . esc_html__('Select Category', 'dwt-listing') . '" class="allow_clear" name="l_category">
				 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
				  ' . $cats_html . '
				</select>
              </div>
              <div class="form-group input-iconz  col-lg-3">
              <i class="ti-filter"></i>
               		<select class="allow_clear" name="l_tag" data-placeholder="' . esc_html__('Filter by Tags', 'dwt-listing') . '">
					  <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
                  		' . $tags . '
               		</select>
              </div>
              <div class="form-group col-lg-2">
                <input value="' . esc_html__('Search', 'dwt-listing') . '" class="submit" type="submit">
                    '. dwt_listing_form_lang_field_callback(false) .'
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="scroll-to ">
								<a class="arrow bounce scroller" href="#elegent_catz" title=""><i class=" ti-angle-down  "></i></a>
							</div>
  
</section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_8_base', 'd_hero_8_base_func');
}