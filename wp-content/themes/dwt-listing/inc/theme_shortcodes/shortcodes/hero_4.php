<?php
if (!function_exists('dwt_listing_hero_4')) {

    function dwt_listing_hero_4() {
        vc_map(array(
            "name" => __("Hero Listing & Events", 'dwt-listing'),
            "base" => "d_hero_4_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-application-icon-large",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('hero4.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                array
                    (
                    "group" => esc_html__("Listing Form", "dwt-listing"),
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
                    "group" => esc_html__("Listing Location", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show categorties with their sub categories?", 'dwt-listing'),
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
                    "group" => esc_html__("Listing Location", "dwt-listing"),
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
                    "group" => esc_html__("Event Form", "dwt-listing"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'dwt-listing'),
                    'param_name' => 'grid_cats',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "grid_cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('l_event_cat', 'yes'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_hero_4');
if (!function_exists('d_hero_4_base_func')) {

    function d_hero_4_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (isset($bg_img) && $bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($bg_img);
            $style = ( $bgImageURL != "" ) ? ' style="background: url(' . $bgImageURL . ') center center /cover no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }
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
				<label>' . esc_html__('Location', 'dwt-listing') . '</label>
				<input class="form-control" id="address_location" name="street_address" placeholder="' . esc_html__('Location...', 'dwt-listing') . '"  type="text">
				 ' . $location_icon . '
			  </div>';
        } else {
            $location = dwt_listing_return_selective_location(vc_param_group_parse_atts($atts['select_locations']));
        }

        //event categories
        $grid_categories = $link = '';
        if (isset($atts['grid_cats']) && $atts['grid_cats'] != "") {
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
                        $fetch_category = get_term($catz['grid_cat'], 'l_event_cat');
                        if (count((array)$fetch_category) == 0)
                            continue;
                        $grid_categories .= '<option value="' . $fetch_category->slug . '">' . $fetch_category->name . '</option>';
                    }
                }
                if ($g_cats) {
                    $ad_catz = dwt_listing_categories_fetch('l_event_cat', 0);
                    if (is_array($ad_catz) && count($ad_catz) > 0) {
                        foreach ($ad_catz as $my_cat) {
                            $grid_categories .= '<option value="' . $my_cat->slug . '">' . $my_cat->name . '</option>';
                        }
                    }
                }
            }
        }


        return '<div class="hero-list-event" ' . $style . '>
            <div class="container">
            <div class="search-container">
               <!-- Form -->
               <h1>' . $section_title . '</h1>
               <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#hero-listingz" aria-controls="hero-listingz" role="tab" data-toggle="tab">' . esc_html__('Listings', 'dwt-listing') . '</a></li>
                    <li role="presentation"><a href="#hero-event" aria-controls="hero-event" role="tab" data-toggle="tab">' . esc_html__('Events', 'dwt-listing') . '</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="hero-listingz">
                       <form class="custom-style-search" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
                       			<div class="col-md-4 col-xs-12 col-sm-12 nopadding">
								   <div class="form-group ">
									 <label class="control-label">' . esc_html__('Keyword', 'dwt-listing') . ' </label>
									 <div class="typeahead__container"><div class="typeahead__field"><div class="typeahead__query">
											<input autocomplete="off" class="dget_listings form-control for_s_home" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" name="by_title" type="search"/>
									   </div></div></div>		
									 </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-sm-12 nopadding ">
                                       <div class="form-group">
                                            <label>' . esc_html__('Select Category', 'dwt-listing') . '</label>
											<select data-placeholder="' . esc_html__('Select Business Category', 'dwt-listing') . '"  class="custom-select" name="l_category">
											 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
											  ' . $cats_html . '
											</select>
          								</div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-sm-12 nopadding">
                                      ' . $location . '
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12 col-sm-12 nopadding">
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-block btn-theme">' . esc_html__('Search', 'dwt-listing') . '</button>
                                              '. dwt_listing_form_lang_field_callback(false) .'
                                       </div>
                                    </div>
                       </form>             
                       
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="hero-event">
                       <form action="' . dwt_listing_pagelink('dwt_listing_event_page') . '">
                       <div class="col-md-4 col-xs-12 col-sm-12 nopadding">
                       
                      	 <div class="form-group ">
							 <label class="control-label">' . esc_html__('Keyword', 'dwt-listing') . ' </label>
							 <input class="form-control" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" name="by_title" type="text"/>
 						 </div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-sm-12 nopadding ">
                                       <div class="form-group">
                                            <label>' . esc_html__('Select Category', 'dwt-listing') . '</label>
                                             <select data-placeholder="' . esc_html__('Select Event Category', 'dwt-listing') . '" name="event_cat" class="custom-select">
                                              <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
                                              ' . $grid_categories . '
                                            </select>
          								</div>
                                    </div>
                                    <div class="col-md-3 col-xs-12 col-sm-12 nopadding">
                                       <div class="form-group specific-search">
                                     <label class="control-label ">' . esc_html__('Location', 'dwt-listing') . ' </label>
                                            <input class="form-control" placeholder="' . esc_html__('e.g. Event venues..', 'dwt-listing') . '" id="address_location_event" autocomplete="on" type="text" name="by_location" />
											<i class="detect-me fa fa-crosshairs"></i>
                                     </div>
                                       
                                    </div>
                                    <div class="col-md-2 col-xs-12 col-sm-12 nopadding">
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-block btn-theme">' . esc_html__('Search', 'dwt-listing') . '</button>
                                              '. dwt_listing_form_lang_field_callback(false) .'
                                       </div>
                                    </div>
                       </form>
                    </div>
                </div>
            </div>
            </div>
         </div>
        </div>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_hero_4_base', 'd_hero_4_base_func');
}