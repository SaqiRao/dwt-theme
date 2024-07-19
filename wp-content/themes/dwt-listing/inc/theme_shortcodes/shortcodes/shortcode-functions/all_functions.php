<?php
if (!function_exists('dwt_listing_headings')) {

    function dwt_listing_headings($sb_section_title, $sb_section_description)
    {
        $title = '';
        $desc = '';

        if ($sb_section_title != ''):
            $title = '<h3>' . $sb_section_title . '</h3>';
        endif;
        if ($sb_section_description != ''):
            $desc = '<h2>' . $sb_section_description . '</h2>';
        endif;
        $main_title = $sb_section_title;

        if ($sb_section_title != '' || $sb_section_description != '') {
            return '<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="heading-2">
							' . $title . '
							' . $desc . '
						 </div>
					   </div>';
        }
    }

}

/*
 *5-4-2021
 * work for customization
 */

add_filter('custom_changes_by_theme_grid4', 'listing_custom_order_btn_filter_grid4', 10, 5);
if (!function_exists('listing_custom_order_btn_filter_grid4')) {
    function listing_custom_order_btn_filter_grid4($listing_id = '', $get_user_url = '', $get_user_dp = '', 
    $final_title = '', $get_user_name = '')
    {
        return '<div class="authorz">
        <div class="author-thumb">
            <a class="if-no-img" href="' . esc_url($get_user_url) . '"><img src="' . esc_url($get_user_dp) . '"
                                                                            class="img-responsive"
                                                                            alt="' . $final_title . '"></a>
        </div>
        <div class="author-info">
            <h6><a href="' . esc_url($get_user_url) . '">' . dwt_listing_words_count($get_user_name) . '</a></h6>
            <span class="listing-date"><i class="far fa-clock"></i> ' . get_the_date(get_option('date_format'), $listing_id) . ' </span>
        </div>
    </div>';
    }
}


add_filter('profile_user_info_card', 'listing_profile_user_info_card', 10, 3);
if (!function_exists('listing_profile_user_info_card')) {
    function listing_profile_user_info_card($listing_id = '', $profile_url = '', $get_user_dp = '')
    {
        return '<div class="l-author-box user-info-card">
    <div class="row">
        <div class="user-photo col-lg-4 col-md-4 col-sm-3  col-xs-12">
            <a target="_blank" href="' . esc_url($profile_url) . '">
                <img src="' . esc_url($get_user_dp) . '" class="img-circle center-block img-responsive" alt="' . esc_html__('not found', 'dwt-listing') . '">
            </a>
        </div>
        <div class="user-information col-lg-8 col-md-8 col-sm-9 col-xs-12 no-left-pad">
            <span class="user-name"><a class="hover-color" href="' . esc_url($profile_url) . '">' . dwt_listing_listing_owner($listing_id, 'name') . '</a></span>
            <div class="item-date">
                <p class="street-adr"><i class="ti-location-pin"></i>' . dwt_listing_listing_owner($listing_id, 'location') . '</p>
            </div>
        </div>
    </div>
    <div class="auth-button">
        <a class="btn btn-theme btn-block" href="' . esc_url($profile_url) . '">' . esc_html__('View Profile', 'dwt-listing') . '</a>
    </div>
</div>';
    }
}

add_filter('profile_info_filter', 'listing_profile_filter', 10, 3);
if (!function_exists('listing_profile_filter')) {
    function listing_profile_filter($listing_id = '', $profile_url = '', $get_user_dp = '')
    {
    
        return '<div class="contact-box">
        <div class="contact-img">
            <a target="_blank" href="' . esc_url($profile_url) . '"><img
                        src="' . esc_url($get_user_dp) . '" class="img-circle img-responsive"
                        alt="' . esc_html__('not found', 'dwt-listing') . '"></a>
        </div>
        <div class="contact-caption">
            <h4>
                <a href="' . esc_url($profile_url) . '">' . dwt_listing_listing_owner($listing_id, 'name') . '</a>
            </h4>
            <span>' . dwt_listing_listing_owner($listing_id, 'location') . '</span>
        </div>
    </div>';
    }
}

/*
 * END
 *5-4-2021
 * work for customization
 */

// Get param array
if (!function_exists('carspot_generate_type')) {

    function carspot_generate_type($heading = '', $type = '', $para_name = '', $description = '', $group = '', $values = array(), $default = '', $class = 'vc_col-sm-12 vc_column', $dependency = '', $holder = 'div')
    {
        $val = '';
        if (count($values) > 0) {
            $val = $values;
        }

        return array(
            "group" => $group,
            "type" => $type,
            "holder" => $holder,
            "class" => "",
            "heading" => $heading,
            "param_name" => $para_name,
            "value" => $val,
            "description" => $description,
            "edit_field_class" => $class,
            "std" => $default,
            'dependency' => $dependency,
        );
    }

}

if (!function_exists('dwt_listing_get_button')) {

    function dwt_listing_get_button($section_btn = '', $class = '', $onlyAttr = false, $iconBefore = '', $iconAfter = '')
    {
        $buttonHTML = "";
        if (isset($section_btn) && $section_btn != "") {
            $button = dwt_listing_extarct_link($section_btn);
            $class = ($class != "") ? 'class="' . esc_attr($class) . '"' : '';
            $rel = (isset($button["rel"]) && $button["rel"] != "") ? ' rel="' . esc_attr($button["rel"]) . ' "' : "";
            $href = (isset($button["url"]) && $button["url"] != "") ? ' href="' . esc_url($button["url"]) . ' "' : "javascript:void(0);";
            $title = (isset($button["title"]) && $button["title"] != "") ? ' title="' . esc_attr($button["title"]) . '"' : "";
            $target = (isset($button["target"]) && $button["target"] != "") ? ' target="' . esc_attr($button["target"]) . '"' : "";
            $titleText = (isset($button["title"]) && $button["title"] != "") ? esc_html($button["title"]) : "";

            if (isset($button["url"]) && $button["url"] != "") {
                $btn = ($onlyAttr == true) ? $href . $target . $class . $rel : '<a ' . $href . ' ' . $target . ' ' . $class . ' ' . $rel . '>' . $iconBefore . ' ' . esc_html($titleText) . ' ' . $iconAfter . '</a>';
                $buttonHTML = (isset($title)) ? $btn : "";
            }
        }
        return $buttonHTML;
    }

}

if (!function_exists('dwt_listing_extarct_link')) {

    function dwt_listing_extarct_link($string )
    {

        if($string && $string != "") {
            $arr = explode('|', $string);
            list($url, $title, $target, $rel) = $arr;
            $rel = urldecode(dwt_listing_themeGetExplode($rel, ':', '1'));
            $url = urldecode(dwt_listing_themeGetExplode($url, ':', '1'));
            $title = urldecode(dwt_listing_themeGetExplode($title, ':', '1'));
            $target = urldecode(dwt_listing_themeGetExplode($target, ':', '1'));
            return array("url" => $url, "title" => $title, "target" => $target, "rel" => $rel);
        }
    }

}

if (!function_exists('dwt_listing_themeGetExplode')) {

    function dwt_listing_themeGetExplode($string = "", $explod = "", $index = "")
    {
        $ar = '';
        if ($string != "") {
            $exp = explode($explod, $string);
            $ar = ($index != "") ? $exp[$index] : $exp;
        }
        return ($ar != "") ? $ar : "";
    }

}

if (!function_exists('dwt_listing_return_img_src')) {

    function dwt_listing_return_img_src($id, $size = 'full', $showHtml = false, $class = '', $alt = '')
    {

        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                if (wp_attachment_is_image($id)) {
                    $img1 = wp_get_attachment_image_src($id, $size);
                    $img = $img1[0];
                } else {
                    $img = dwt_listing_defualt_img_url();
                }
            } else {
                $class = ($class != "") ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ($alt != "") ? 'alt="' . esc_attr($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }

}

if (!function_exists('dwt_listing_VCImage')) {

    function dwt_listing_VCImage($imgName = '')
    {
        $val = '';
        if ($imgName != "") {
            $path = esc_url(trailingslashit(get_template_directory_uri()) . 'vc-images/' . $imgName);
            $val = '<img src="' . esc_url($path) . '" style="width:100%" class="img-responsive">';
        }
        return $val;
    }

}


if (!function_exists('dwt_listing_get_parests_cats')) {

    function dwt_listing_get_parests_cats($taxonomy, $all = 'yes')
    {
        if (taxonomy_exists($taxonomy)) {
            $listing_cats = dwt_listing_categories_fetch($taxonomy, 0);
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count($listing_cats) > 0 && $listing_cats != "") {
                foreach ($listing_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->term_id;
                }
            }
            return $cats;
        }
    }

}

// Get Products

if (!function_exists('dwt_listing_get_packages')) {

    function dwt_listing_get_packages()
    {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
            $args = array(
                'post_type' => 'product',
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'dwt_listing_pkgs'
                    ),
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'subscription'
                    ),
                ),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date'
            );
            $products = array('Select Product' => '');
            $packages = new WP_Query($args);
            if ($packages->have_posts()) {
                while ($packages->have_posts()) {
                    $packages->the_post();
                    $products[get_the_title()] = get_the_ID();
                }
            }
            return $products;
        }
    }

}


// Making shortcode function
if (!function_exists('dwt_listing_clean_shortcode')) {

    function dwt_listing_clean_shortcode($string)
    {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }

}

if (!function_exists('dwt_listing_listing_video')) {

    function dwt_listing_listing_video($listing_id)
    {
        global $dwt_listing_options;
        $video_img = '';
        if (isset($dwt_listing_options['dwt_listing_video_icon']['url']) && $dwt_listing_options['dwt_listing_video_icon']['url'] != "") {
            $video_img = '<img class="img-responsive" src="' . esc_url($dwt_listing_options['dwt_listing_video_icon']['url']) . '" alt="' . esc_html__('Icon', 'dwt-listing') . '">';
        } else {
            $video_img = '<img class="img-responsive" src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'assets/images/play-button.png' . '" alt="' . esc_html__('Icon', 'dwt-listing') . '">';
        }

        if (isset($dwt_listing_options['dwt_listing_enable_video_option']) && $dwt_listing_options['dwt_listing_enable_video_option'] && get_post_meta($listing_id, 'dwt_listing_listing_video', true)) {
            return '<div class="video-button"><a class="play-video" href="' . get_post_meta($listing_id, 'dwt_listing_listing_video', true) . '" >' . $video_img . '</a></div>';
        }
    }

}


if (!function_exists('dwt_listing_return_cats_features')) {

    function dwt_listing_return_cats_features($return_categories, $want_to_show)
    {
        $cats = false;
        $cats_html = '';
        if (count((array)$return_categories) > 0) {
            $cats_html .= '';
            foreach ($return_categories as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == 'all') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term($row['cat'], 'l_category');
                    if (count((array)$category) == 0)
                        continue;
                    $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                }
            }

            if ($cats) {
                $ad_cats = dwt_listing_categories_fetch('l_category', 0);
                foreach ($ad_cats as $cat) {
                    $cats_html .= '<option value="' . $cat->term_id . '"> ' . $cat->name . '  (' . $cat->count . ')</option>';
                }
            }
        }
        return $cats_html;
    }

}


if (!function_exists('dwt_listing_location_data_shortcode')) {

    function dwt_listing_location_data_shortcode($term_type = 'l_location')
    {
        $terms = get_terms($term_type, array('hide_empty' => false));
        $result = array();
        if (count((array)$terms) > 0 && !empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $result[] = array
                (
                    'value' => $term->term_id,
                    'label' => $term->name,
                );
            }
        }
        return $result;
    }

}


if (!function_exists('dwt_listing_return_selective_location')) {

    function dwt_listing_return_selective_location($return_locs, $no_label = '')
    {
        $locationz = '';
        $lable_text = '';
        if (!empty($return_locs) && count($return_locs) > 0) {
            $locationz .= '';

            foreach ($return_locs as $row) {
                $return_locs;
                $get_locationz_idz = (isset($row['name'])) ? $row['name'] : '';
                $term = get_term_by('id', $get_locationz_idz, 'l_location');
                if (count((array) $term) > 0 && !empty($term) && !is_wp_error($term)) {
                    $locationz .= '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                }
            }
        }
        $lable_text = '<label>' . esc_html__('Select Location', 'dwt-listing') . '</label>';
        if ($no_label == 'yes') {
            $lable_text = '';
        }
        return '<div class="form-group" id="dwt_select_location_dropdown">
			' . $lable_text . '
			<select data-placeholder="' . esc_html__('Select From Location', 'dwt-listing') . '" name="l_location" class="custom-select">
			 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
				' . $locationz . '
			</select>
		</div>';
    }

}