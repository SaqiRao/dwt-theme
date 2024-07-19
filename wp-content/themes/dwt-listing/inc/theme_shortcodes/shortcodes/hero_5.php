<?php
if (!function_exists('dwt_listing_hero_5')) {

    function dwt_listing_hero_5() {
        vc_map(array(
            "name" => __("Hero Section 5", 'dwt-listing'),
            "base" => "d_hero_5_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_icon",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero5.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "type" => "dropdown",
                    "heading" => __("Display tags?", 'dwt-listing'),
                    "param_name" => "is_display_tags",
                    "admin_label" => true,
                    "value" => array(
                        __('Select Option', 'dwt-listing') => '',
                        __('Yes', 'dwt-listing') => '1',
                        __('No', 'dwt-listing') => '0'
                    ),
                ),
                array(
                    "group" => __("Basic", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => __("Max number of tags", 'dwt-listing'),
                    "param_name" => "max_tags_limit",
                    "admin_label" => true,
                    "value" => range(1, 500),
                    'dependency' => array(
                        'element' => 'is_display_tags',
                        'value' => array('1'),
                    ),
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
add_action('vc_before_init', 'dwt_listing_hero_5');
if (!function_exists('d_hero_5_base_func')) {

    function d_hero_5_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
        $count_listings = wp_count_posts('listing');
        $cats_html = $location = '';
        //fetch catefories
        $cats_html = dwt_listing_return_cats_features(vc_param_group_parse_atts($atts['cats']), $want_to_show);

        $link = $tags = '';
        if ($is_display_tags == 1) {
            $tags = '<div class="hero-form-sub">
			<strong class="hidden-sm-down">' . __('Popular Tags', 'dwt-listing') . '</strong>';
            $listing_tags = get_terms('l_tags', array('orderby' => 'count', 'hide_empty' => 0, 'number' => $max_tags_limit, 'orderby' => 'count', 'order' => 'DESC',));
            if (!empty($listing_tags) && count((array) $listing_tags) > 0) {
                $tags .= '<ul>';
                foreach ($listing_tags as $tagz) {
                    $link = get_term_link($tagz->term_id);
                    $tags .= '<li><a href="' . esc_url($link) . '">' . esc_attr($tagz->name) . '</a></li>';
                }
                $tags .= '</ul>';
            }
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
                        $link = dwt_listing_pagelink('dwt_listing_seacrh_page') . '?l_category=' . $fetch_category->term_id;
                        $grid_categories .= '<a href="' . $link . '" class="' . $cat_icon . '"><span> ' . $fetch_category->name . ' </span></a>';
                    }
                }
                if ($g_cats) {
                    $ad_catz = dwt_listing_categories_fetch('l_category', 0);
                    if (is_array($ad_catz) && count($ad_catz) > 0) {
                        foreach ($ad_catz as $my_cat) {
                            $cat_icon = get_term_meta($my_cat->term_id, 'category_icon', true);
                            $link = dwt_listing_pagelink('dwt_listing_seacrh_page') . '?l_category=' . $my_cat->term_id;
                            $grid_categories .= '<a href="' . $link . '" class="' . $cat_icon . '"><span> ' . $my_cat->name . ' </span></a>';
                        }
                    }
                }
            }
        }

        $extra_spacing = '=';
        if (dwt_listing_text("dwt_listing_header-layout") == "1") {
            $extra_spacing = 'need-extra-space';
        }

        return '<div class="hero-with-live-search parallex" ' . $style . '>
      <div class="container">
      <div class="row">
      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
         <div class="main-search-title ' . $extra_spacing . '">
            <h1>' . esc_attr($section_tag_line) . '</h1>
            <p>' . str_replace('%count%', '<strong>' . $count_listings->publish . '</strong>', $section_title) . '</p>
         </div>
         
         <div class="search-section">
	 <form class="custom-style-search" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
            <div id="form-panel">
               <ul class="list-unstyled search-options clearfix">
				  <li>
				  <div class="typeahead__container"><div class="typeahead__field"><div class="typeahead__query">
				  <input name="by_title" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" autocomplete="off" class="  dget_listings form-control for_s_home" type="search">
				  </div></div></div>	
				  </li>
                  <li>
                     <select data-placeholder="' . esc_html__('Select Business Category', 'dwt-listing') . '" class="custom-select" name="l_category">
					 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
					  ' . $cats_html . '
					</select>
                  </li>
                  <li>
				    <button class="btn btn-theme btn-block" type="submit">' . esc_html__('Search', 'dwt-listing') . '</button>
                                        '. dwt_listing_form_lang_field_callback(false) .'
                  </li>
               </ul>
               ' . $tags . '
            </div>
		   </form>
         </div>
         </div>
         </div>
       </div>
      
 

</div>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_5_base', 'd_hero_5_base_func');
}