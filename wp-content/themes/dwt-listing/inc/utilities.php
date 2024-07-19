<?php
/* ------------------------------------------------ */
/* Pagination */
/* ------------------------------------------------ */

if (!function_exists('dwt_listing_pagination')) {

    function dwt_listing_pagination()
    {
        if (is_singular())
            return;

        global $wp_query;
        /** Stop execution if there's only 1 page */
        if ($wp_query->max_num_pages <= 1)
            return;

        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $max = intval($wp_query->max_num_pages);

        /**    Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**    Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
            printf('<li>%s</li>' . "\n", get_previous_posts_link());

        /**    Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>';
        }

        /**    Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array)$links as $link) {
            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**    Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }

        if (get_next_posts_link())
            printf('<li>%s</li>' . "\n", get_next_posts_link());
        echo '</ul>' . "\n";
    }

}

if (!function_exists('dwt_listing_pagination_search')) {

    function dwt_listing_pagination_search($wp_query = '')
    {
        if (is_singular())
            //return;
            //global $wp_query;
            /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;

        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $max = intval($wp_query->max_num_pages);

        /**    Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**    Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
            printf('<li>%s</li>' . "\n", get_previous_posts_link());

        /**    Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>';
        }

        /**    Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array)$links as $link) {

            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**    Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }


        if (get_next_posts_link_custom($wp_query))
            printf('<li>%s</li>' . "\n", get_next_posts_link_custom($wp_query));

        echo '</ul>' . "\n";
    }

}


if (!function_exists('get_next_posts_link_custom')) {

    function get_next_posts_link_custom($wp_query = '', $label = null, $max_page = 0)
    {
        global $paged;
        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        if (!$paged)
            $paged = 1;

        $nextpage = intval($paged) + 1;

        if (null === $label)
            $label = esc_html__('Next Page &raquo;', 'dwt-listing');

        if ($nextpage <= $max_page) {
            /**
             * Filters the anchor tag attributes for the next posts page link.
             *
             * @param string $attributes Attributes for the anchor tag.
             * @since 2.7.0
             *
             */
            $attr = apply_filters('next_posts_link_attributes', '');

            return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
        }
    }

}


if (!function_exists('dwt_listing_cat_name')) {

    // Return Category ID
    function dwt_listing_cat_name()
    {
        return esc_html(get_cat_id(single_cat_title("", false)));
    }

}


// Breadcrumb
if (!function_exists('dwt_listing_page_breadcrumb')) {

    function dwt_listing_page_breadcrumb()
    {
        $string = '';

        if (is_category()) {
            $string .= esc_html(get_cat_name(dwt_listing_cat_name()));
        } else if (is_singular('events')) {
            $string = esc_html__('Events', 'dwt-listing');
        } else if (is_singular('listing')) {
            $string = esc_html__('Listings', 'dwt-listing');
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_singular('product')) {
            $string = esc_html__('Product Detail', 'dwt-listing');
        } else if (is_single()) {
            $string .= esc_html__('Blog Details', 'dwt-listing');
        } elseif (is_page()) {
            $string .= esc_html(get_the_title());
        } elseif (is_tag()) {
            $string .= esc_html(single_tag_title("", false));
        } elseif (is_search()) {
            $string .= esc_html(get_search_query());
        } elseif (is_404()) {
            $string .= esc_html__('Page not Found', 'dwt-listing');
        } elseif (is_author()) {
            $string .= esc_html__('Author', 'dwt-listing');
        } else if (is_tax()) {
            $string .= esc_html(single_cat_title("", false));
        } elseif (is_archive()) {
            $string .= esc_html__('Archive', 'dwt-listing');
        } else if (is_home()) {
            $string = esc_html__('Latest News & Trends', 'dwt-listing');
        }
        return $string;
    }

}

// Get BreadCrumb Heading
if (!function_exists('dwt_listing_bread_crumb_heading')) {

    function dwt_listing_bread_crumb_heading()
    {
        $page_heading = '';
        global $dwt_listing_options;
        if (is_search()) {
            $string = esc_html__('entire web', 'dwt-listing');
            if (get_search_query() != "") {
                $string = get_search_query();
            }
            $page_heading = sprintf(esc_html__('Search Results for: %s', 'dwt-listing'), esc_html($string));
        } else if (is_category()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (is_tag()) {
            $page_heading = esc_html__('Tag: ', 'dwt-listing') . esc_html(single_tag_title("", false));
        } else if (is_404()) {
            $page_heading = esc_html__('Page not found', 'dwt-listing');
        } else if (is_author()) {
            $author_id = get_query_var('author');
            $author = get_user_by('ID', $author_id);
            $page_heading = $author->display_name;
        } else if (is_tax()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
            $page_heading = esc_html__('All Products', 'dwt-listing');
        } else if (is_archive()) {
            $page_heading = esc_html__('Blog Archive', 'dwt-listing');
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product_category()) {
            $page_heading = esc_html__('Shop ', 'dwt-listing');
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_singular('product')) {
            $page_heading = get_the_title();
        } else if (is_home()) {
            if (isset($dwt_listing_options['dwt_listing_blog-post-title']) && $dwt_listing_options['dwt_listing_blog-post-title'] != "") {
                $page_heading = $dwt_listing_options['dwt_listing_blog-post-title'];
            } else {
                $page_heading = esc_html__('Latest Stories', 'dwt-listing');
            }
        } else if (is_singular('post')) {
            $page_heading = get_the_title();
        } else if (is_singular('page')) {
            $page_heading = get_the_title();
        } else if (is_singular('listing')) {
            $page_heading = get_the_title();
        } else if (is_singular('reviews')) {
            $page_heading = get_the_title();
        } else if (is_singular('events')) {
            // $page_heading = esc_html__('Event Details', 'dwt-listing');
            $page_heading = get_the_title();
        }else if (is_singular('speakers')) {
            $page_heading = get_the_title();
        }
        return $page_heading;
    }

}


// get post description as per need. 
if (!function_exists('dwt_listing_words_count')) {

    function dwt_listing_words_count($contect = '', $limit = '')
    {
        $string = '';
        $limit = ($limit!='') ? $limit : 180;
        $contents = strip_tags(strip_shortcodes($contect));
        $contents = str_replace("|", " ", $contents);
        $contents = dwt_listing_removeURL($contents);
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $limit) {
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }

}


if (!function_exists('dwt_listing_required_attributes')) {

    function dwt_listing_required_attributes()
    {
        return $default_attribs = array(
            'id' => array(),
            'src' => array(),
            'href' => array(),
            'target' => array(),
            'class' => array(),
            'title' => array(),
            'type' => array(),
            'style' => array(),
            'data' => array(),
            'role' => array(),
            'aria-haspopup' => array(),
            'aria-expanded' => array(),
            'data-toggle' => array(),
            'data-hover' => array(),
            'data-animations' => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-href' => array(),
            'data-tabs' => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-height' => array(),
            'data-hide-cover' => array(),
            'data-show-facepile' => array(),
        );
    }

}

if (!function_exists('dwt_listing_required_tags')) {

    function dwt_listing_required_tags()
    {
        return $allowed_tags = array(
            'div' => dwt_listing_required_attributes(),
            'span' => dwt_listing_required_attributes(),
            'p' => dwt_listing_required_attributes(),
            'a' => array_merge(dwt_listing_required_attributes(), array(
                'href' => array(),
                'target' => array('_blank', '_top'),
            )),
            'u' => dwt_listing_required_attributes(),
            'br' => dwt_listing_required_attributes(),
            'i' => dwt_listing_required_attributes(),
            'q' => dwt_listing_required_attributes(),
            'b' => dwt_listing_required_attributes(),
            'ul' => dwt_listing_required_attributes(),
            'ol' => dwt_listing_required_attributes(),
            'li' => dwt_listing_required_attributes(),
            'br' => dwt_listing_required_attributes(),
            'hr' => dwt_listing_required_attributes(),
            'strong' => dwt_listing_required_attributes(),
            'blockquote' => dwt_listing_required_attributes(),
            'del' => dwt_listing_required_attributes(),
            'strike' => dwt_listing_required_attributes(),
            'em' => dwt_listing_required_attributes(),
            'code' => dwt_listing_required_attributes(),
            'style' => dwt_listing_required_attributes(),
            'script' => dwt_listing_required_attributes(),
            'img' => dwt_listing_required_attributes(),
        );
    }

}
// get feature image

if (!function_exists('dwt_listing_get_feature_image')) {

    function dwt_listing_get_feature_image($post_id = '', $image_size = '')
    {
        return wp_get_attachment_image_src(get_post_thumbnail_id(esc_html($post_id)), $image_size);
    }

}

if (!function_exists('dwt_listing_categories_fetch')) {

    function dwt_listing_categories_fetch($taxonomy = 'category', $parent_of = 0, $child_of = 0)
    {
        $defaults = array(
            'taxonomy' => $taxonomy,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 0,
            'exclude' => array(),
            'exclude_tree' => array(),
            'number' => '',
            'offset' => '',
            'fields' => 'all',
            'name' => '',
            'slug' => '',
            'hierarchical' => true,
            'search' => '',
            'name__like' => '',
            'description__like' => '',
            'pad_counts' => false,
            'get' => '',
            'child_of' => $child_of,
            'parent' => $parent_of,
            'childless' => false,
            'cache_domain' => 'core',
            'update_term_meta_cache' => true,
            'meta_query' => '',
        );
        $default = dwt_listing_wpml_show_all_posts_callback($defaults);
        return get_terms($default);
    }

}

// Modifying search form
add_filter('get_search_form', 'carspot_search_form');
if (!function_exists('carspot_search_form')) {

    function carspot_search_form($text = '')
    {

        $text = str_replace('<label>', '<div class="search-blog"><div class="input-group stylish-input-group">', $text);
        $text = str_replace('</label>', '<span class="input-group-addon">
							<button type="submit"> <span class="fa fa-search"></span> </button>
												</span></div></div>', $text);
        $text = str_replace('<span class="screen-reader-text">' . esc_html__('Search for:', 'dwt-listing') . '</span>', '', $text);
        $text = str_replace('class="search-field"', 'class="form-control"', $text);
        return $text;
    }

}
// remove url from excerpt
if (!function_exists('dwt_listing_removeURL')) {

    function dwt_listing_removeURL($string = '')
    {
        return preg_replace("/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i", '', $string);
    }

}


if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('init', 'dwt_listing_woocommerce_image_dimensions', 1);
}

if (!function_exists('dwt_listing_woocommerce_image_dimensions')) {

    function dwt_listing_woocommerce_image_dimensions()
    {
        $catalog = array(
            'width' => '262',
            'height' => '320',
            'crop' => 1,
        );

        $single = array(
            'width' => '396',
            'height' => '302',
            'crop' => 1,
        );

        $thumbnail = array(
            'width' => '100',
            'height' => '100',
            'crop' => 1,
        );

        // Image sizes
        update_option('shop_catalog_image_size', $catalog);
        update_option('shop_single_image_size', $single);
        update_option('shop_thumbnail_image_size', $thumbnail);
    }

}

if (!function_exists('dwt_listing_make_link')) {

    function dwt_listing_make_link($url = '', $text = '')
    {
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", dwt_listing_required_tags()) . $text . wp_kses('</a>', dwt_listing_required_tags());
    }

}

if (!function_exists('dwt_listing_get_comments')) {

    function dwt_listing_get_comments()
    {
        $comments = $num_comments = '';
        $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
        if ($num_comments == 0) {
            $comments = esc_html__('No Comments', 'dwt-listing');
        } elseif ($num_comments > 1) {
            $comments = $num_comments . __(' Comments', 'dwt-listing');
        } else {
            $comments = __('1 Comment', 'dwt-listing');
        }
        return $comments;
    }

}
if (!function_exists('dwt_listing_get_date')) {

    function dwt_listing_get_date($PID = '')
    {
        echo get_the_date(get_option('date_format'), $PID);
    }

}


if (!function_exists('dwt_listing_redirect')) {

    function dwt_listing_redirect($url = '')
    {

        return '<script>window.location = "' . dwt_listing_page_lang_url_callback($url) . '";</script>';
    }

}

if (!function_exists('dwt_listing_redirect_withmsg')) {

    function dwt_listing_redirect_withmsg($url = '')
    {
        $listing_update_url = '';
        //$listing_update_url = dwt_listing_set_url_param($url, 'redirect', 'true');
        $listing_update_url = dwt_listing_set_url_params_multi($url, array('redirect' => 'true'));
        return '<script>window.location = "' . $listing_update_url . '"</script>';
    }

}

// Bad word filter
if (!function_exists('dwt_listing_badwords_filter')) {

    function dwt_listing_badwords_filter($words = array(), $string = '', $replacement = '')
    {
        foreach ($words as $word) {
            $string = str_ireplace($word, $replacement, $string);
        }
        return $string;
    }

}

//  search params
if (!function_exists('dwt_listing_search_params')) {

    function dwt_listing_search_params($index = '', $second = '', $third = '')
    {
        $param = dwt_listing_query_string_func('QUERY_STRING');
        $res = '';
        if (isset($param)) {
            parse_str($param, $vars);
            foreach ($vars as $key => $val) {

                if ($key == $index)
                    continue;

                if ($second != "") {
                    if ($key == $second)
                        continue;
                }

                if ($third != "") {
                    if ($key == $third)
                        continue;
                }

                if (isset($vars['custom']) && count($vars['custom']) > 0 && 'custom' == $key) {
                    foreach ($vars['custom'] as $ckey => $cval) {
                        $name = "custom[$ckey]";
                        if ($name == $index) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else {
                    if (is_array($val)) {
                        foreach ($val as $v) {
                            $res .= '<input type="hidden" name="' . esc_attr($key) . '[]" value="' . esc_attr($v) . '" />';
                        }
                    } else {
                        $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                    }
                }
            }
        }
        return $res;
    }

}

if (!function_exists('dwt_listing_listing_custom_location')) {

    function dwt_listing_listing_custom_location($listing_id = '')
    {
        $ad_country = '';
        $ad_country = wp_get_object_terms($listing_id, array('l_location'), array('orderby' => 'term_group'));
        if (count((array)$ad_country) > 0) {
            $all_locations = array();
            foreach ($ad_country as $ad_count) {
                $country_ads = get_term($ad_count);
                $item = array(
                    'term_id' => $country_ads->term_id,
                    'location' => $country_ads->name
                );
                $all_locations[] = $item;
            }
            $location_html = '';
            if (count((array)$all_locations) > 0) {
                $limit = count((array)$all_locations) - 1;
                for ($i = 0; $i <= $limit; $i++) {
                    //for ($i = $limit; $i >= 0; $i--) {
                    $location_html .= '<a href="' . get_term_link($all_locations[$i]['term_id']) . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                }
            }
            return rtrim($location_html, ', ');
        } else {
            return '';
        }
    }

}


if (!function_exists('dwt_listing_get_all_countries')) {

    function dwt_listing_get_all_countries()
    {
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => 'downtown_map_address',
            'post_status' => 'publish',
        );
        $countries = get_posts($args);
        $res = array();
        foreach ($countries as $country) {
            $res[$country->post_excerpt] = $country->post_title;
        }
        return $res;
    }

}

if (!function_exists('dwt_listing_randomString')) {

    function dwt_listing_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}


if (!function_exists('dwt_listing_google_locations')) {

    function dwt_listing_google_locations($action_on_complete = '')
    {
        global $dwt_listing_options;
        $stricts = '';
        if (isset($dwt_listing_options['dwt_listing_allow_loc']) && !$dwt_listing_options['dwt_listing_allow_loc'] && isset($dwt_listing_options['dwt_listing_allowed_loc'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($dwt_listing_options['dwt_listing_allowed_loc']) . "}";
        }

        echo "<script>
	   function dwt_listing_location() {
        var input = document.getElementById('address_location');
	    var action_on_complete	=	'" . $action_on_complete . "';
	    var options = {" . $stricts . "};
      var autocomplete = new google.maps.places.Autocomplete(input, options);
	  if( action_on_complete )
	  {
	   new google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
	document.getElementById('d_latt').value = place.geometry.location.lat();
	document.getElementById('d_long').value = place.geometry.location.lng();
	var markers = [
        {
            'title': '',
            'lat': place.geometry.location.lat(),
            'lng': place.geometry.location.lng(),
        },
    ];
	
	my_g_map(markers);
});
	   }

   }
   </script>";
    }

}


if (!function_exists('dwt_listing_get_user_dp')) {

    function dwt_listing_get_user_dp($user_id = '', $size = '')
    {
        global $dwt_listing_options;
        $user_info = '';
        $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/users/defualt.jpg';
        if (isset($dwt_listing_options['dwt_listing_user-default-image']['url']) && $dwt_listing_options['dwt_listing_user-default-image']['url'] != "") {
            $user_pic = $dwt_listing_options['dwt_listing_user-default-image']['url'];
        }
        //check if there is a brand image
        if (get_user_meta($user_id, 'dwt_listing_user_logo_type', true) != "" && get_user_meta($user_id, 'dwt_listing_user_logo_type', true) == "2") {
            return dwt_listing_get_brand_img($user_id, 'dwt_listing_user-dp');
        } else {
            $user_info = get_userdata($user_id);
            if ($user_info == true) {
                $image_link = array();
                if (get_user_meta($user_id, 'dwt_listing_user_pic', true) != "") {
                    $attach_id = get_user_meta($user_id, 'dwt_listing_user_pic', true);
                    $image_link = wp_get_attachment_image_src($attach_id, $size);
                }

                if (isset($image_link[0]) && $image_link[0] != "") {
                    return $image_link[0];
                } else {
                    return $user_pic;
                }
            } else {
                return $user_pic;
            }
        }
    }

}


if (!function_exists('dwt_listing_check_pkg')) {

    function dwt_listing_check_pkg()
    {
        global $dwt_listing_options;
        if (is_user_logged_in()) {
            $profile = new dwt_listing_profile();
            $uid = $profile->user_info->ID;
            if (is_super_admin(get_current_user_id())) {

            } else {
                if (get_user_meta($uid, 'd_user_package_id', true) != "") {

                } else {
                    echo dwt_listing_redirect_withmsg(dwt_listing_pagelink('dwt_listing_packages'));
                }
            }
        } else {
            echo dwt_listing_redirect_withmsg(dwt_listing_pagelink('dwt_listing_packages'));
        }
    }

}

if (!function_exists('dwt_listing_check_user_package_history')) {

    function dwt_listing_check_user_package_history($listing_id = '')
    {
        if (isset($listing_id) && $listing_id != "") {

        } else {
            global $dwt_listing_options;
            $regular_listing = get_user_meta(get_current_user_id(), 'dwt_listing_regular_listing', true);
            $expiry_date = get_user_meta(get_current_user_id(), 'dwt_listing_package_expiry', true);
            $current_date = date('Y-m-d');
            if ($regular_listing == '-1' || $regular_listing > 0) {
                if ($expiry_date == '-1') {

                } // need to check  expiry
                else if ($current_date > $expiry_date) {
                    //package is expired
                    echo dwt_listing_redirect(dwt_listing_pagelink('dwt_listing_packages'));
                } else {

                }
            } else {
                // regular listing is expired
                echo dwt_listing_redirect(dwt_listing_pagelink('dwt_listing_packages'));
            }
        }
    }

}

if (!function_exists('dwt_listing_pkg_selection_time')) {

    function dwt_listing_pkg_selection_time($pack_id = '', $pack_type = '', $uid = '')
    {
        if ($pack_id != "" && $pack_type != "") {
            //check package type
            if ($pack_type == "free") {
                update_user_meta($uid, 'd_user_package_id', $pack_id);
                update_user_meta($uid, 'd_is_free_pgk', $pack_id);
                //need to check if plugin is activated
                dwt_listing_store_user_package($uid, $pack_id);
            } else {
                //It's a paid package
                dwt_listing_adding_into_cart($pack_id, 1);
            }
        }
    }

}


// Time difference n days
if (!function_exists('dwt_listing_days_difference')) {

    function dwt_listing_days_difference($now = '', $from = '')
    {
        $datediff = $now - $from;
        return floor($datediff / (60 * 60 * 24));
    }

}


if (!function_exists('dwt_listing_comments_pagination')) {

    function dwt_listing_comments_pagination($total_records = '', $current_page = '')
    {
        // Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $args = array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '?page=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            'type' => 'plain');
        return paginate_links($args);
    }

}


if (!function_exists('dwt_listing_week_days')) {

    function dwt_listing_week_days()
    {
        return array(0 => esc_html__('Monday', 'dwt-listing'), 1 => esc_html__('Tuesday', 'dwt-listing'), 2 => esc_html__('Wednesday', 'dwt-listing'), 3 => esc_html__('Thursday', 'dwt-listing'), 4 => esc_html__('Friday', 'dwt-listing'), 5 => esc_html__('Saturday', 'dwt-listing'), 6 => esc_html__('Sunday', 'dwt-listing'));
    }

}

if (!function_exists('dwt_listing_listing_pagination')) {

    function dwt_listing_listing_pagination($max_num_pages = '')
    {
        $total_pages = $max_num_pages->max_num_pages;
        $big = 999999999; // need an unlikely integer
        if ($total_pages > 1) {
            $total_pages;
            $current_page = max(1, get_query_var('paged'));
            $current_page;
            return paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_next' => true,
                'show_all' => false,
                'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                'type' => 'plain'
            ));
        }
    }

}


if (!function_exists('dwt_listing_listing_assigned_cats')) {

    function dwt_listing_listing_assigned_cats($listing_id = '', $html_type = '')
    {
        $link = '';
        $cats_html = $cat_icon = '';
        $listing_features = wp_get_object_terms($listing_id, array('l_category'), array('orderby' => 'name', 'order' => 'ASC'));
        if (isset($listing_features) && $listing_features != "") {
            if (!is_wp_error($listing_features)) {
                foreach ($listing_features as $term) {
                    if ($term->parent == 0) {
                        $link = get_term_link($term->term_id);
                        if ($html_type == 'grid1') {
                            $cats_html .= '<a href="' . $link . '"><span class="bisiness-cat">' . esc_html($term->name) . '</span></a>';
                        } else if ($html_type == 'grid2') {
                            $cat_icon .= '<i class="' . get_term_meta($term->term_id, 'category_icon', true) . '"></i>';
                            $cats_html .= '<a href="' . $link . '">' . $cat_icon . '<span> ' . esc_html($term->name) . ' </span></a>';
                        } else if ($html_type == 'list1') {
                            $cat_icon .= '<i class="' . get_term_meta($term->term_id, 'category_icon', true) . '"></i>';
                            $cats_html .= '<a href="' . $link . '">' . $cat_icon . '<span> ' . esc_html($term->name) . ' </span></a>';
                        } else {
                            $cats_html .= '<a href="' . $link . '">' . esc_html($term->name) . '</a>';
                        }
                        break;
                    }
                }
                return $cats_html;
            }
        }
    }

}


if (!function_exists('dwt_listing_events_assigned_cats')) {

    function dwt_listing_events_assigned_cats($event_id = '', $type = '')
    {
        $link = '';
        $cats_html = '';
        $listing_features = wp_get_object_terms($event_id, array('l_event_cat'), array('orderby' => 'name', 'order' => 'ASC'));
        if (isset($listing_features) && $listing_features != "") {
            if (!is_wp_error($listing_features)) {
                foreach ($listing_features as $term) {
                    $link = get_term_link($term->term_id);
                    if ($type != "") {
                        $cats_html .= '<div class="category-title"><span><a href="' . $link . '">' . esc_html($term->name) . '</a></span></div>';
                    } else {
                        $cats_html .= '<a href="' . $link . '" class="btn btn-success">' . esc_html($term->name) . ' </a>';
                    }
                    break;
                }
                return $cats_html;
            }
        }
    }

}


if (!function_exists('dwt_listing_activities_pagination')) {

    function dwt_listing_activities_pagination($listing_id = '', $per_page = '', $page = '')
    {
        global $wpdb;
        // Check if a records is set.
        if (!isset($listing_id))
            return;
        if (!isset($per_page))
            return;
        if (!isset($page))
            return;
        $total = $wpdb->get_var("SELECT count(meta_id) from $wpdb->postmeta WHERE meta_key LIKE '_activity_%' AND post_id IN ($listing_id) ORDER BY meta_id DESC");

        $prev = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
        $nxt = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
        if (is_rtl()) {
            $prev = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
            $nxt = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
        }

        $args = array(
            'base' => add_query_arg('page', '%#%'),
            'format' => '?page=%#%',
            'total' => ceil($total / $per_page),
            'current' => $page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev,
            'next_text' => $nxt,
            'type' => 'plain');
        return paginate_links($args);
    }

}


if (!function_exists('dwt_listing_comments_list')) {

    function dwt_listing_comments_list($comment = '', $args = '', $depth = '')
    {
        //checks if were using a div or ol|ul for our output
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        if (get_avatar($comment, $args['avatar_size']) != "") {
            $my_class = 'comment-body';
        } else {
            $my_class = 'comment-body no-marg';
        }
        ?>

        <<?php echo '' . $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($args['has_children'] ? 'parent' : '', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="<?php echo esc_attr($my_class); ?>">
            <div class="comment-wrapper">
                <div class="comment-meta-wrapper align-items-center">
                    <div class="gravatar">
                        <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                    </div>
                    <div class="comment-meta">
                        <div class="comment-author">
                            <?php printf(sprintf('<div class="comment-author-linkz">%s</div>', get_comment_author_link($comment))); ?>
                            <time class="comment-meta-item"><?php printf(__('%1$s at %2$s', 'dwt-listing'), get_comment_date('', $comment), sprintf('<a class="comment-author-link">%s</a>', get_comment_time())); ?></time>
                        </div>
                    </div>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html__('Your comment is awaiting moderation.', 'dwt-listing'); ?></p>
                    <?php endif; ?>
                    <?php
                    $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ', get_comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'dwt-listing'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                    ?>
                    <?php
                    if ($reply_link != "") {
                        ?>
                        <?php echo wp_kses($reply_link, dwt_listing_required_tags()); ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </article>
        <?php
    }
}

/*
 * Check Listing opened
 */
if (!function_exists('dwt_listing_search_listing_status')) {

    function dwt_listing_search_listing_status()
    {
        $listing_status = array(
            array(
                'key' => 'dwt_listing_user_timezone',
                'value' => "",
                'compare' => '!='
            ),
            array(
                'key' => 'dwt_listing_business_hours',
                'value' => '1',
                'compare' => '='
            ),
        );
        $args = array
        (
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'dwt_listing_listing_status',
                    'value' => '1',
                    'compare' => '='
                ),
                $listing_status,
            )
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $results = new WP_Query($args);
        $listing_idz = array();
        while ($results->have_posts()) {
            $results->the_post();
            $listing_id = get_the_ID();
            $status = dwt_listing_business_hours_status($listing_id);
            if ($status == 0) {
                continue;
            }
            $listing_idz[] = $listing_id;
        }
        return $listing_idz;
    }

}

if (!function_exists('dwt_listing_count_active_widgets')) {

    function dwt_listing_count_active_widgets($sidebar_id = '')
    {
        global $_wp_sidebars_widgets;
        if (empty($_wp_sidebars_widgets)) :
            $_wp_sidebars_widgets = get_option('sidebars_widgets');
        endif;
        $sidebars_widgets_count = $_wp_sidebars_widgets;
        if (isset($sidebars_widgets_count[$sidebar_id])) :
            $widget_count = count($sidebars_widgets_count[$sidebar_id]);
            return $widget_count;
        endif;
    }

}

if (!function_exists('dwt_listing_number_format_short')) {

    function dwt_listing_number_format_short($n = '', $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format_i18n($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format_i18n($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format_i18n($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format_i18n($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format_i18n($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $commazero = ',' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
            $n_format = str_replace($commazero, '', $n_format);
        }
        return $n_format . $suffix;
    }

}

if (!function_exists('adforest_get_ad_cats')) {

    function adforest_get_ad_cats($id = '', $by = 'name', $for_country = false)
    {
        $taxonomy = 'ad_cats'; //Put your custom taxonomy term here

        if ($for_country) {
            $taxonomy = 'ad_country';
        } else {
            $taxonomy = 'ad_cats'; //Put your custom taxonomy term here
        }

        $terms = wp_get_post_terms($id, $taxonomy);
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy 
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy   
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }
        return $cats;
        $post_categories = wp_get_object_terms($id, array('ad_cats'), array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }
        return $cats;
    }

}


//Woocommerce Over Riding
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
    add_filter('woocommerce_default_catalog_orderby', 'dwt_listing_default_catalog_orderby');
    if (!function_exists('dwt_listing_default_catalog_orderby')) {

        function dwt_listing_default_catalog_orderby()
        {
            return 'date'; // Can also use title and price
        }

    }

    //Woocommerce Style Widget
    add_filter('get_product_search_form', 'dwt_listing_custom_product_searchform');
    if (!function_exists('dwt_listing_custom_product_searchform')) {

        function dwt_listing_custom_product_searchform($form = '')
        {
            $form = '<form role="search" method="get" class="search-form" id="searchform" action="' . esc_url(home_url('/')) . '">
			<div class="search-blog">
				<div class="input-group stylish-input-group">
					<input class="form-control" placeholder="' . esc_html__('Search products...', 'dwt-listing') . '" value="' . get_search_query() . '" name="s" type="search">
					<span class="input-group-addon">
							<button type="submit"> <span class="fa fa-search"></span> </button>
					</span>
				</div>
			</div>
			<input type="hidden" name="post_type" value="product" />
			<input class="search-submit" value="' . esc_html__('Search', 'dwt-listing') . '" type="submit">
		</form>';
            return $form;
        }

    }


    add_action('woocommerce_after_shop_loop_item', 'mycode_remove_add_to_cart_buttons', 1);

    function mycode_remove_add_to_cart_buttons()
    {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
    }

    if (!function_exists('dwt_listing_fetch_product_images')) {

        function dwt_listing_fetch_product_images($productId = '')
        {
            $product = wc_get_product($productId);
            $attachmentIds = $product->get_gallery_image_ids();
            $attachmentIds[] = $product->get_image_id();
            return $attachmentIds;
        }

    }
}


//Allow Pending products to be viewed by listing/product owner
if (!function_exists('dwt_listing_show_pending_post_to_author')) {

    function dwt_listing_show_pending_post_to_author($query = '')
    {

        if (isset($_GET['post_type']) && $_GET['post_type'] == "listing" && isset($_GET['p'])) {
            $listing_id = $_GET['p'];
            $post_author = get_post_field('post_author', $listing_id);
            if (is_user_logged_in() && get_current_user_id() == $post_author) {
                $query->set('post_status', array('publish', 'pending'));
                return $query;
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

}
add_filter('pre_get_posts', 'dwt_listing_show_pending_post_to_author');


//Allow Pending products to be viewed by listing/product owner
if (!function_exists('dwt_listing_show_pending_event_to_author')) {

    function dwt_listing_show_pending_event_to_author($query = '')
    {

        if (isset($_GET['post_type']) && $_GET['post_type'] == "events" && isset($_GET['p'])) {
            $event_id = $_GET['p'];
            $post_author = get_post_field('post_author', $event_id);
            if (is_user_logged_in() && get_current_user_id() == $post_author) {
                $query->set('post_status', array('publish', 'pending'));
                return $query;
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

}

add_filter('pre_get_posts', 'dwt_listing_show_pending_event_to_author');

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
    /* Shop Settings */
    add_action('pre_get_posts', 'dwt_listing_shop_filter_cat');

    function dwt_listing_shop_filter_cat($query = '')
    {
        if (!is_admin() && is_post_type_archive('product') && $query->is_main_query()) {
            $query->set('tax_query', array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'dwt_listing_pkgs', 'operator' => 'NOT IN'),));
        }
    }

}
add_action('wp_ajax_nopriv_fetch_suggestions', 'dwt_listing_live_search');
add_action('wp_ajax_fetch_suggestions', 'dwt_listing_live_search'); // wp_ajax_{action}

function dwt_listing_live_search()
{
    if (!empty($_GET['q'])) {
        $tags = $all_listings = $cat_array = array();
        $keyword = strtolower($_GET['q']);
        $status = true;
        $search_results = new WP_Query(array(
            's' => $keyword,
            'post_type' => 'listing',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 15
        ));
        if ($search_results->have_posts()) {
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $media = dwt_listing_fetch_listing_gallery($search_results->post->ID);
                $all_listings[] = array("id" => $search_results->post->ID, "with_title" => dwt_listing_clean_strings($search_results->post->post_title), "img" => dwt_listing_return_listing_idz($media, 'dwt_listing_slider-thumb'), 'link' => get_the_permalink($search_results->post->ID));
            }
            wp_reset_postdata();
        }
        $get_cats = dwt_listing_categories_fetch('l_category', 0);
        if (!empty($get_cats) && count($get_cats) > 0) {
            foreach ($get_cats as $cats) {
                $cat_array[] = array("id" => $cats->term_id, "cat_name" => dwt_listing_clean_strings($cats->name), "cat_icon" => get_term_meta($cats->term_id, 'category_icon', true));
            }
        }

        $get_tags = get_terms(array('taxonomy' => 'l_tags', 'name__like' => $keyword, 'fields' => 'all'));
        if (!empty($get_tags) && count($get_tags) > 0) {
            foreach ($get_tags as $tag) {
                $tags[] = array("id" => $tag->term_id, "tag_name" => dwt_listing_clean_strings($tag->name), "tag_icon" => 'icon-autos-wholesale');
            }
        }
        echo json_encode(array(
            "status" => $status,
            "error" => null,
            "data" => array(
                "listings" => $all_listings,
                "categories" => $cat_array,
                "tags" => $tags
            )
        ));
    } else {
        $status = false;
        echo json_encode(array(
            "status" => $status,
            "error" => null,
            "data" => array()
        ));
    }
    die();
}

add_action('wp_ajax_nopriv_fetch_listing_suggestions', 'dwt_listing_live_search_listings');
add_action('wp_ajax_fetch_listing_suggestions', 'dwt_listing_live_search_listings'); // wp_ajax_{action}

function dwt_listing_live_search_listings()
{
    if (!empty($_GET['q'])) {
        //Custom Location
        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => dwt_listing_countires_cookies(),
                ),
            );
        }
        $tags = $all_listings = $cat_array = array();
        $keyword = strtolower($_GET['q']);
        $status = true;
        $search_results = new WP_Query(array(
            's' => $keyword,
            'post_type' => 'listing',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 15,
            'tax_query' => array(
                $custom_location
            ),
        ));
        if ($search_results->have_posts()) {
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $media = dwt_listing_fetch_listing_gallery($search_results->post->ID);
                $all_listings[] = array("id" => $search_results->post->ID, "with_title" => dwt_listing_clean_strings($search_results->post->post_title), "img" => dwt_listing_return_listing_idz($media, 'dwt_listing_slider-thumb'), 'link' => get_the_permalink($search_results->post->ID));
            }
            wp_reset_postdata();
        }
        echo json_encode(array(
            "status" => $status,
            "error" => null,
            "data" => array(
                "listings" => $all_listings,
            )
        ));
    } else {
        $status = false;
        echo json_encode(array(
            "status" => $status,
            "error" => null,
            "data" => array()
        ));
    }
    die();
}

add_action('wp_ajax_nopriv_event_questions_action', 'dwt_listing_event_questions_action');
add_action('wp_ajax_event_questions_action', 'dwt_listing_event_questions_action'); // wp_ajax_{action}

function dwt_listing_event_questions_action()
{

    parse_str($_POST['data'], $params);
    $product_id= isset( $params[ 'question' ] ) ? sanitize_text_field( $params[ 'question' ] ) : '';
    echo $product_id."this sis ioaufosadiufsa";
    die();
}

//adding for days_Schedule


add_action('wp_ajax_nopriv_event_days_textarea_action', 'dwt_listing_event_days_textarea_action');
add_action('wp_ajax_event_days_textarea_action', 'dwt_listing_event_days_textarea_action'); // wp_ajax_{action}

function dwt_listing_event_days_textarea_action()
{

    parse_str($_POST['data'], $params);
    $productss_id= isset( $params[ 'newDay' ] ) ? sanitize_text_field( $params[ 'newDay' ] ) : '';
    echo $productss_id."this sis ioaufosadiufsa";

    die();
}


//adding for extra_services

add_action('wp_ajax_nopriv_event_extra_services_action', 'dwt_listing_event_extra_services_action');
add_action('wp_ajax_event_extra_services_action', 'dwt_listing_event_extra_services_action'); // wp_ajax_{action}

function dwt_listing_event_extra_services_action()
{
    parse_str($_POST['data'], $params);
    $product_id= isset( $params[ 'ticket_price' ] ) ? sanitize_text_field( $params[ 'ticket_price' ] ) : '';
    echo $product_id."this sis ioaufosadiufsa";
    die();
}

//adding for extra_services



//adding for extra_services_pitch_&_catering

add_action('wp_ajax_nopriv_event_extra_services_catering_pitch_action', 'dwt_listing_event_extra_services_catering_pitch_action');
add_action('wp_ajax_event_extra_services_catering_pitch_action', 'dwt_listing_event_extra_services_catering_pitch_action'); // wp_ajax_{action}

function dwt_listing_event_extra_services_catering_pitch_action()
{
    parse_str($_POST['data'], $params);
    $product_id= isset( $params[ 'e_services' ] ) ? sanitize_text_field( $params[ 'e_services' ] ) : '';
    echo $product_id."this sis ioaufosadiufsa";
    die();
}

//adding for extra_services







add_action('wp_ajax_nopriv_fetch_listing_suggestions_search', 'dwt_listing_live_search_listings_sp_pages');
add_action('wp_ajax_fetch_listing_suggestions_search', 'dwt_listing_live_search_listings_sp_pages'); // wp_ajax_{action}

function dwt_listing_live_search_listings_sp_pages()
{
    if (!empty($_GET['q'])) {
        //Custom Location
        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => dwt_listing_countires_cookies(),
                ),
            );
        }
        $tags = $all_listings = $cat_array = array();
        $keyword = strtolower($_GET['q']);
        $status = true;
        $search_results = new WP_Query(array(
            's' => $keyword,
            'post_type' => 'listing',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 20,
            'tax_query' => array(
                $custom_location
            ),
        ));
        if ($search_results->have_posts()) {
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $title = $search_results->post->post_title;
                $return[] = dwt_listing_clean_strings($title);
            }
            wp_reset_postdata();
        }
        echo json_encode($return);
    }
    die();
}

if (!function_exists('dwt_listing_clean_strings')) {

    function dwt_listing_clean_strings($string = '')
    {
        $string = preg_replace('/%u([0-9A-F]+)/', '&#x$1;', $string);
        return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
    }

}


add_action('add_meta_boxes', 'dwt_listing_remove_metabox', 100);
if (!function_exists('dwt_listing_remove_metabox')) {

    function dwt_listing_remove_metabox()
    {
        remove_meta_box('l_categorydiv', 'listing', 'side');
        remove_meta_box('l_price_typediv', 'listing', 'side');
        remove_meta_box('l_currencydiv', 'listing', 'side');
        remove_meta_box('l_locationdiv', 'listing', 'side');
        remove_meta_box('l_event_catdiv', 'events', 'side');
        remove_meta_box('l_event_tagsdiv', 'events', 'side');
        //remove_meta_box( 'trackbacksdiv', 'post', 'normal' ); // Trackbacks meta box
    }

}

//Generate Timezones
if (!function_exists('dwt_listing_get_all_timezones')) {

    function dwt_listing_get_all_timezones()
    {
        $zones_array = array();
        foreach (timezone_identifiers_list() as $key => $zone) {
            $zones_array[] = $zone;
            //break;
        }
        return $zones_array;
    }

}

//Author Page Pagination
if (!function_exists('dwt_listing_author_pagination_filter')) {

    function dwt_listing_author_pagination_filter($query = '')
    {
        if ($query->is_author() && $query->is_main_query()) {
            if (isset($_GET['type']) && $_GET['type'] != '1') {
                if ($_GET['type'] == 'listings') {
                    $query->set('post_type', array('listing'));
                }
                if ($_GET['type'] == 'events') {
                    $query->set('post_type', array('events'));
                }
            }
        }
    }

}
add_action('pre_get_posts', 'dwt_listing_author_pagination_filter');


//Author Page Pagination
if (!function_exists('dwt_listing_submission_disbaled')) {

    function dwt_listing_submission_disbaled()
    {
        global $dwt_listing_options;
        if (dwt_listing_text('dwt_listing_disable_submission') == 0) {
            if ($dwt_listing_options["dwt_listing_packages"] == get_the_ID() || $dwt_listing_options["dwt_listing_header-page"] == get_the_ID()) {
                echo dwt_listing_redirect(home_url('/'));
            }
        }
    }

}

if (!function_exists('dwt_listing_selected_catz')) {

    function dwt_listing_selected_catz($id = '', $by = 'name', $for_country = false)
    {
        $taxonomy = 'l_category'; //Put your custom taxonomy term here
        $terms = wp_get_post_terms($id, $taxonomy);
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy	
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy	  
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }
        return $cats;
        $post_categories = wp_get_object_terms($id, array('l_category'), array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }
        return $cats;
    }

}


if (!function_exists('dwt_listing_selected_locationz')) {

    function dwt_listing_selected_locationz($id = '', $by = 'name', $for_country = false)
    {
        $taxonomy = 'l_location'; //Put your custom taxonomy term here
        $terms = wp_get_post_terms($id, $taxonomy);
        $cats = array();
        $myparentID = '';
        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $myparent = $term;
                $myparentID = $myparent->term_id;
                $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                break;
            }
        }

        if ($myparentID != "") {
            $mychildID = '';
            // Right, the parent is set, now let's get the children
            foreach ($terms as $term) {
                if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                    $child_term = $term; // this gets the children of the current post taxonomy	
                    $mychildID = $child_term->term_id;
                    $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                    break;
                }
            }
            if ($mychildID != "") {
                $mychildchildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy
                        $mychildchildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildchildID != "") {
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy	  
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                }
            }
        }
        return $cats;
        $loc_categories = wp_get_object_terms($id, array('l_location'), array('orderby' => 'term_group'));
        $cats = array();
        foreach ($loc_categories as $c) {
            $cat = get_term($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }
        return $cats;
    }

}


if (!function_exists('dwt_listing_ajax_pagination_search')) {

    function dwt_listing_ajax_pagination_search($wp_query = '', $page = 0)
    {
        if ($wp_query->found_posts > 1) {
            $limit = $total_pages = '';
            $limit = get_option('posts_per_page');
            $total_pages = $wp_query->found_posts;
            //$total_pages =1638;
            $stages = 3;
            $page = $page;
            if ($page) {
                $start = ($page - 1) * $limit;
            } else {
                $start = 0;
            }
            // Initial page num setup
            if ($page == 0) {
                $page = 1;
            }
            $prev = $page - 1;
            $next = $page + 1;

            $lastpage = ceil($total_pages / $limit);
            $LastPagem1 = $lastpage - 1;

            $paginate = '';
            if ($lastpage > 1) {
                $paginate .= '<ul class="pagination pagination-lg">';
                // Previous
                if ($page > 1) {
                    $paginate .= '<li class="fetch_result" data-page-no="' . $prev . '"><a href="javascript:void(0)">« ' . esc_html__('Previous', 'dwt-listing') . '</a></li>';
                } else {

                    $paginate .= '<li class="disabled"><a href="javascript:void(0)" aria-label="' . esc_html__('Previous', 'dwt-listing') . '"><span aria-hidden="true">« ' . esc_html__('Previous', 'dwt-listing') . '</span></a></li>';
                }

                // Pages
                if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
                    for ($counter = 1; $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate .= '<li class="fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                        } else {
                            $paginate .= '<li class="fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                        }
                    }
                } elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
                    // Beginning only hide later pages
                    if ($page < 1 + ($stages * 2)) {
                        for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                            } else {
                                $paginate .= '<li class="fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                            }
                        }
                        $paginate .= '<li class="disabled"><a href="javascript:void(0)">...</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)">' . $LastPagem1 . '</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no=' . $lastpage . '><a href="javascript:void(0)">' . $lastpage . '</a></li>';
                    } // Middle hide some front and some back
                    elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {

                        $paginate .= '<li class="fetch_result" data-page-no="1"><a href="javascript:void(0)">1</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no="2"><a href="javascript:void(0)">2</a></li>';
                        $paginate .= '<li class="disabled"><a href="javascript:void(0)">...</a></li>';
                        //$paginate.= "...";
                        for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="fetch_result active" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                            } else {
                                $paginate .= '<li class="fetch_result" data-page-no=' . $counter . '><a href="javascript:void(0)">' . $counter . '</a></li>';
                            }
                        }
                        //$paginate.= "...";
                        $paginate .= '<li class="disabled"><a href="javascript:void(0)">...</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no=' . $LastPagem1 . '><a href="javascript:void(0)">' . $LastPagem1 . '</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no=' . $lastpage . '><a href="javascript:void(0)">' . $lastpage . '</a></li>';
                    } // End only hide early pages
                    else {
                        $paginate .= '<li class="fetch_result" data-page-no="1"><a href="javascript:void(0)">1</a></li>';
                        $paginate .= '<li class="fetch_result" data-page-no="2"><a href="javascript:void(0)">2</a></li>';
                        $paginate .= '<li class="disabled"><a href="javascript:void(0)">...</a></li>';
                        for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="fetch_result active" data-page-no=' . $counter . '><a>' . $counter . '</a></li>';
                            } else {
                                $paginate .= '<li class="fetch_result" data-page-no=' . $counter . '><a>' . $counter . '</a></li>';
                            }
                        }
                    }
                }
                // Next
                if ($page < $counter - 1) {
                    $paginate .= '<li class="fetch_result" data-page-no="' . $next . '"><a href="javascript:void(0)" aria-label="' . esc_html__('Next', 'dwt-listing') . '"><span aria-hidden="true">' . esc_html__('Next', 'dwt-listing') . ' »</span></a></li>';
                } else {
                    $paginate .= '<li class="disabled"><a href="javascript:void(0)" aria-label="' . esc_html__('Next', 'dwt-listing') . '"><span aria-hidden="true">' . esc_html__('Next', 'dwt-listing') . ' »</span></a></li>';
                }
                $paginate .= "</ul>";
            }
            return $paginate;
        }
    }

}


add_action('wp_ajax_nopriv_dwt_listingzones', 'dwt_listing_getzones');
add_action('wp_ajax_dwt_listingzones', 'dwt_listing_getzones');

function dwt_listing_getzones()
{
    $return = array();
    $search_param = $_GET['q'];
    $get_locations = get_terms(array('taxonomy' => 'l_location', 'hide_empty' => false, 'name__like' => $search_param, 'fields' => 'all'));
    if (!empty($get_locations)) {
        foreach ($get_locations as $loc) {
            $return[] = array($loc->term_id, $loc->name);
        }
    }
    echo json_encode($return);
    die;
}

if (!function_exists('dwt_listing_iconfor_map')) {

    function dwt_listing_iconfor_map($listing_id = '')
    {
        $link = '';
        $cats_html = $cat_icon = '';
        $listing_features = wp_get_object_terms($listing_id, array('l_category'), array('orderby' => 'name', 'order' => 'ASC'));
        if (isset($listing_features) && $listing_features != "") {
            if (!is_wp_error($listing_features)) {
                foreach ($listing_features as $term) {
                    if ($term->parent == 0) {
                        return '<i class="' . get_term_meta($term->term_id, 'category_icon', true) . '"></i>';
                        break;
                    }
                }
            }
        }
    }

}


if (!function_exists('dwt_listing_radius_search')) {

    function dwt_listing_radius_search($data_arr = array(), $check_db = true)
    {
        $data = array();
        $user_id = get_current_user_id();
        $success = false;
        if (isset($data_arr) && !empty($data_arr)) {
            $nearby_data = $data_arr;
        }

        if (isset($nearby_data) && $nearby_data != "") {
            //array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance );
            $original_lat = $nearby_data['latitude'];
            $original_long = $nearby_data['longitude'];
            $distance = $nearby_data['distance'];

            $lat = $original_lat; //latitude
            $lon = $original_long; //longitude
            $distance = $distance; //your distance in KM
            $R = 6371.009; //constant earth radius. You can add precision here if you wish
            $maxLat = $lat + rad2deg($distance / $R);
            $minLat = $lat - rad2deg($distance / $R);
            $maxLon = $lon + rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));
            $minLon = $lon - rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));
            $data['radius'] = $R;
            $data['distance'] = $distance;
            $data['lat']['original'] = $original_lat;
            $data['long']['original'] = $original_long;
            $data['lat']['min'] = $minLat;
            $data['lat']['max'] = $maxLat;
            $data['long']['min'] = $minLon;
            $data['long']['max'] = $maxLon;
        }
        return $data;
    }
}


// get current page url
if (!function_exists('dwt_listing_current_url')) {

    function dwt_listing_current_url()
    {
        return $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}


// listing cover
if (!function_exists('dwt_listing_get_cover_img')) {

    function dwt_listing_get_cover_img($listing_id = '', $size = '')
    {
        global $dwt_listing_options;
        $user_info = '';
        $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/listing-cover.png';
        if (isset($dwt_listing_options['dwt_listing_cover_default_image']['url']) && $dwt_listing_options['dwt_listing_cover_default_image']['url'] != "") {
            $user_pic = $dwt_listing_options['dwt_listing_cover_default_image']['url'];
        }

        if (get_post_meta($listing_id, 'dwt_listing_cover_photo', true) != "") {
            $cover_id = get_post_meta($listing_id, 'dwt_listing_cover_photo', true);
            $image_link = wp_get_attachment_image_src($cover_id, $size);
            return $image_link[0];
        } else {
            return $user_pic;
        }
    }

}


if (!function_exists('dwt_listing_get_brand_img')) {

    function dwt_listing_get_brand_img($listing_id = '', $size = '')
    {
        global $dwt_listing_options;
        $user_brand_pic = $brand_image = '';
        $user_brand_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/brand.png';
        if (isset($dwt_listing_options['dwt_listing_brand_default_image']['url']) && $dwt_listing_options['dwt_listing_brand_default_image']['url'] != "") {
            $user_brand_pic = $dwt_listing_options['dwt_listing_brand_default_image']['url'];
        }
        if (get_post_meta($listing_id, 'dwt_listing_brand_img', true) != "") {
            $cover_id = get_post_meta($listing_id, 'dwt_listing_brand_img', true);
            $image_link = wp_get_attachment_image_src($cover_id, $size);
            $image_link = (isset($image_link) && $image_link != '') ? $image_link[0] : $user_brand_pic;
            return $image_link;
        } else {
            return $user_brand_pic;
        }
    }
}

if (!function_exists('dwt_listing_fetch_dashboard')) {

    //Fetch all ads
    function dwt_listing_fetch_dashboard($user_id = '', $most_viewed = false, $todays_trending = false)
    {
        $order_by = 'date';
        $limit = 5;
        if ($most_viewed == true) {
            if (function_exists('pvc_get_post_views')) {
                $order_by = 'post_views';
                $limit = 5;
            }
        }
        $today_vewzs = array();
        if ($todays_trending == true && $most_viewed == true && function_exists('pvc_get_post_views')) {
            $limit = 3;
            $today_vewzs = array(
                'year' => date('Y'), // this year
                'month' => date('m'), // this month
                'day' => date('d'), // this day
            );
        }

        $meta_query_args = array();
        $meta_query_args = array(array('key' => 'dwt_listing_listing_status', 'value' => 1, 'compare' => '='));
        $args = array
        (
            'post_type' => 'listing',
            'author' => $user_id,
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'order' => 'DESC',
            'orderby' => $order_by,
            'suppress_filters' => false,
            'meta_query' => $meta_query_args,
            'views_query' => $today_vewzs
        );
        return $args;
    }

}

if (!function_exists('dwt_listing_brand_img_or_author')) {

    function dwt_listing_brand_img_or_author($listing_id = '', $size = '')
    {

        global $dwt_listing_options;
        if (get_post_meta($listing_id, 'dwt_listing_brand_img', true) != "") {
            $cover_id = get_post_meta($listing_id, 'dwt_listing_brand_img', true);
            
            if (wp_attachment_is_image($cover_id)) {
                $image_link = wp_get_attachment_image_src($cover_id, $size);
                return $image_link[0];
                
            } else {
                $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/brand.png';
                
                if (isset($dwt_listing_options['dwt_listing_brand_default_image']['url']) && $dwt_listing_options['dwt_listing_brand_default_image']['url'] != "") {
                    $user_pic = $dwt_listing_options['dwt_listing_brand_default_image']['url'];
                }
                return $user_pic;
            }
        } else {
            $user_id = get_post_field('post_author', $listing_id);
            $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/users/defualt.jpg';
            if (isset($dwt_listing_options['dwt_listing_user-default-image']['url']) && $dwt_listing_options['dwt_listing_user-default-image']['url'] != "") {
                $user_pic = $dwt_listing_options['dwt_listing_user-default-image']['url'];
            }
            $user_info = get_userdata($user_id);
            if ($user_info == true) {
                $image_link = array();
                if (get_user_meta($user_id, 'dwt_listing_user_pic', true) != "") {
                    $attach_id = get_user_meta($user_id, 'dwt_listing_user_pic', true);
                    $image_link = wp_get_attachment_image_src($attach_id, $size);
                    if (isset($image_link[0]) && $image_link[0] != "") {
                        return $image_link[0];
                    } else {
                        return $user_pic;
                    }
                } else {
                    return $user_pic;
                }
            } else {
                return $user_pic;
            }
        }
    }




}

    /*ONLY FOR THE CUSTOM SERVICE AMOUNT*/
    add_action( 'woocommerce_before_calculate_totals', 'woo_add_custom_amount_hook_service');
    function woo_add_custom_amount_hook_service()
    {
        global $woocommerce;
        global $dwt_listing_options;
        
            $saved_product_id = $dwt_listing_options['service_custom_deposit_package'];
           
           
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
            {
                $product_detail = wc_get_product( $cart_item['product_id'] );
               
                //$product_detail = wc_get_product( $cart_item['total_tickets'] );
                $prduct_type = $product_detail->get_type();
                    if($cart_item['product_id'] == $saved_product_id && ! empty($_COOKIE['service_amount']) )
                    {
                        $cart_item['data']->set_price($_COOKIE['service_amount']);
                    }
    
            }
        
    }

    /*ONLY FOR THE LISTING BOOKING AMOUNT*/
    add_action( 'woocommerce_before_calculate_totals', 'woo_add_custom_amount_hook_listing');
    function woo_add_custom_amount_hook_listing()
    {
        global $woocommerce;
        global $dwt_listing_options;
        
            $saved_product_id = $dwt_listing_options['listing_custom_deposit_package'];
        
        
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
            {
                $product_detail = wc_get_product( $cart_item['product_id'] );
                $appointment_id =  isset($_SESSION['appointment_id']) ? $_SESSION['appointment_id'] : "";
                $prduct_type = $product_detail->get_type();
                    if($cart_item['product_id'] == $saved_product_id && ! empty($_COOKIE['service_amount_booking']) )
                    {
                        $cart_item['data']->set_price($_COOKIE['service_amount_booking']);
                        $cart_item['appointment_id'] =  $appointment_id;
                    }
    
            }
        
    }
        
    //for services
    if ( ! function_exists( 'ziauddin_service_products' ) )
    {
        function ziauddin_service_products()
        {
            $args	=	array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order'=> 'ASC',
                'orderby' => 'title'
            );
            $packages = new WP_Query( $args );
            return $packages;
        }
    }

    if(!function_exists('sb_get_conversations'))
    {

        /* Get user conversations */
        function sb_get_conversations($user_id, $limit = '')
        {
    
            global $wpdb;
            if ($limit != '') {
                $limit = " LIMIT " . esc_sql($limit);
            }
    
            $result = $wpdb->get_results("
            SELECT * FROM `" . $wpdb->prefix . "sb_chat_conversation`
            WHERE  user_1 = '$user_id' OR user_2 = '$user_id'
            ORDER BY last_update DESC $limit
            ");
    
            return $result;
        }
    }

    if(!function_exists('sb_conversation_exists'))
    {

        function sb_conversation_exists($recipient)
        {
            $user_id = get_current_user_id();
            $conversations = sb_get_conversations($user_id);
            foreach ($conversations as $key => $conv) {
                if ($user_id == (string) $conv->user_1 && $recipient == (string) $conv->user_2) {
                    return $conv->id;
                } elseif ($user_id == $conv->user_2 && $recipient == $conv->user_1) {
                    return $conv->id;
                }
            }
            return false;
        }
    }

    if(!function_exists('sb_mark_as_unread'))
    {

        function sb_mark_as_unread($user, $conversation)
        {
            global $wpdb;
    
            $result = $wpdb->update(
                $wpdb->prefix . 'sb_chat_conversation',
                array('read_' . $user => 0, 'notification' => ''),
                array('id' => $conversation)
            );
    
            return $result;
        }
    }

if(!function_exists('sb_mark_as_undeleted'))
{
    function sb_mark_as_undeleted($user, $conversation)
    {
        global $wpdb;

        $result = $wpdb->update(
            $wpdb->prefix . 'sb_chat_conversation',
            array('deleted_by_user_1' => 0, 'deleted_by_user_2' => 0),
            array('id' => $conversation)
        );

        return $result;
    }
}
if(!function_exists('sb_converstation_update_date'))
{
    function sb_converstation_update_date($conversation)
    {
        global $wpdb;
        $result = $wpdb->update(
            $wpdb->prefix . 'sb_chat_conversation',
            array('updated' => current_time('mysql')),
            array('id' => $conversation)
        );
        return $result;
    }
}
if(!function_exists('sb_get_conversation'))
{

    function sb_get_conversation($conversation_id)
    {
        global $wpdb;
        $result = $wpdb->get_results("
        SELECT * FROM `" . $wpdb->prefix . "sb_chat_conversation`
        WHERE  id = '$conversation_id'
    
        ");
        return $result;
    }
}
    

    if(!function_exists('sb_send_new_message'))
    {
        function sb_send_new_message($args = 0)
        {
            global $wpdb;
            $result = $wpdb->insert($wpdb->prefix . 'sb_chat_messages', array(
                'conversation_id' => $args['conversation_id'],
                'sender_id' => $args['sender_id'],
                'receiver_id' => $args['receiver_id'],
                'message' => stripslashes_deep($args['message']),
                'created' => date("Y-m-d H:i:s"),
                // 'created' => current_time('mysql'),
            ));
            // echo '</br> wpdb->last_query: '. $wpdb->last_query;
            if (isset($wpdb->insert_id)) {
                $id = $wpdb->insert_id;
                $conversation = sb_get_conversation($args['conversation_id']);
                if ($conversation[0]->user_1 == $args['sender_id']) {
                    $user = 'user_2';
                } else {
                    $user = 'user_1';
                }
                sb_mark_as_unread($user, $args['conversation_id']);
                sb_mark_as_undeleted($user, $args['conversation_id']);
    
                sb_converstation_update_date($args['conversation_id']);
            } else {
                $id = false;
            }
    
            return $id;
        }
    }


    if(!function_exists('sb_start_conversation'))
    {

        function sb_start_conversation($args = 0)
        {
    
            global $wpdb;
    
            $read_user_1 = '1';
            $read_user_2 = '0';
    
            $result = $wpdb->insert(
                $wpdb->prefix . 'sb_chat_conversation',
                array(
                    'user_1' => get_current_user_id(), //sender
                    'user_2' => $args['recipient'], // recipeint
                    'read_user_1' => $read_user_1, //sender already read
                    'read_user_2' => $read_user_2,
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                )
            );
    
            if (isset($wpdb->insert_id)) {
                $id = $wpdb->insert_id;
            } else {
                $id = false;
            }
    
            return $id;
        }
    }

  

   
