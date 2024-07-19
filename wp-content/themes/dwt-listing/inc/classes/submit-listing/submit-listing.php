<?php
if (!class_exists('dwt_listing_submit_listing')) {

    class dwt_listing_submit_listing
    {

        /* user object */
        var $user_info;

        public function __construct()
        {
            $this->user_info = get_userdata(get_current_user_id());
        }

        /*
         * get package details
         */
        function get_package_detials($listing_id = '')
        {
            /* check role if admin package */
            if ($listing_id != '') {
                $get_owner_id = get_post_field('post_author', $listing_id);
                if (is_super_admin(get_current_user_id()) && $get_owner_id == $this->user_info->ID) {
                    /* return package id against user */
                    if (get_user_meta($this->user_info->ID, 'd_user_package_id', true) != "") {
                        return get_user_meta($this->user_info->ID, 'd_user_package_id', true);
                    }
                } else {
                    /* return package id against user */
                    if (get_user_meta($get_owner_id, 'd_user_package_id', true) != "") {
                        return get_user_meta($get_owner_id, 'd_user_package_id', true);
                    }
                }
            } else {
                /* return package id against user */
                if (get_user_meta($this->user_info->ID, 'd_user_package_id', true) != "") {
                    return get_user_meta($this->user_info->ID, 'd_user_package_id', true);
                }
            }
        }

    }

}

/* Class init */

add_action('wp_ajax_dwt_listing_get_features', 'dwt_listing_listing_cat_features');

function dwt_listing_listing_cat_features()
{
    if (isset($_POST['cat_id']) && $_POST['cat_id'] != "") {
        $cat_id = $_POST['cat_id'];
        $features = dwt_listing_categories_fetch('l_category', $cat_id);
        if (count($features) > 0) {
            $cats_html = '<ul>';
            foreach ($features as $feature) {
                $cats_html .= '<li><input type="checkbox" class="custom-checkbox" value="' . $feature->term_id . '" name="cat_features[]"></span> <label for="' . $feature->name . '"> ' . $feature->name . '</label></li>';
            }
            $cats_html .= '</ul>';
            echo '' . $cats_html;
            die();
        } else {
            die();
        }
    }
}

/*
 * get locations
 */
add_action('wp_ajax_dwt_listing_get_locations', 'dwt_listing_listing_custom_locations');
add_action('wp_ajax_nopriv_dwt_listing_get_locations', 'dwt_listing_listing_custom_locations');

function dwt_listing_listing_custom_locations()
{
    if (!empty($_POST['city_id'])) {
        $cities_html = '';
        $city_id = $_POST['city_id'];
        $cities = dwt_listing_categories_fetch('l_location', $city_id);
        if (count($cities) > 0) {
            $cities_html .= '<option value="">' . esc_html__('Select An Option', 'dwt-listing') . '</option>';
            foreach ($cities as $city) {
                $cities_html .= '<option value="' . $city->term_id . '">' . $city->name . '</option>';
            }
            echo($cities_html);
            die();
        } else {
            die();
        }
    }
}

/*
 * get listing terms
 */
if (!function_exists('dwt_listing_get_listing_terms')) {

    function dwt_listing_get_listing_terms($id, $taxonomy)
    {
        $post_categories = wp_get_object_terms($id, $taxonomy, array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }
        return $cats;
    }

}


/* Create Post By Title */
add_action('wp_ajax_create_new_post', 'dwt_listing_create_new_listing');
if (!function_exists('dwt_listing_create_new_listing')) {

    function dwt_listing_create_new_listing()
    {

        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            die();
        }
        if ($_POST['is_update'] != "") {
            die();
        }

        $title = sanitize_text_field($_POST['title']);
        if (get_current_user_id() == "")
            die();

        if (!isset($title))
            die();

        $ad_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        if (get_post_status($ad_id) && $ad_id != "") {
            $my_post = array(
                'ID' => $ad_id,
                'post_title' => $title
            );
            wp_update_post($my_post);
            die();

        }


        /* Gather post data. */
        $my_post = array(
            'post_title' => $title,
            'post_status' => 'pending',
            'post_author' => get_current_user_id(),
            'post_type' => 'listing'
        );

        /* Insert the post into the database. */
        $id = wp_insert_post($my_post);
        if ($id) {
            update_user_meta(get_current_user_id(), 'listing_in_progress', $id);
        }
        die();
    }

}

/* Ad listing Posting... */
add_action('wp_ajax_submit_new_listing', 'dwt_listing_submit_new_listing');
if (!function_exists('dwt_listing_submit_new_listing')) {
    function dwt_listing_submit_new_listing()
    {
    
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            return '';
            die();
        }

        global $dwt_listing_options;
        global $wpdb;
        if (get_current_user_id() == "") {
            echo "0";
            die();
        }

        if (!is_super_admin(get_current_user_id())) {
            $regular_listing = get_user_meta(get_current_user_id(), 'dwt_listing_regular_listing', true);
            if ($regular_listing == -1) {

            } else if ($_POST['is_update'] != "") {

            } else if ($regular_listing <= 0) {
                echo "1";
                die();
            }
        }


        /* Getting values */
        
        $listing_contact_email = '';
        $params = array();
        parse_str($_POST['collect_data'], $params);

        $ad_desc = isset($params['listing_desc']) ? sanitize_text_field($params['listing_desc']) : "";
        $listing_title = isset($params['title']) ? sanitize_text_field($params['title']) : "";
        $listing_contact = isset($params['listing_contact']) ? sanitize_text_field($params['listing_contact']) : "";
        $listing_web_url = isset($params['website-url']) ? sanitize_text_field($params['website-url']) : "";
        $listing_price_type = isset($params['listing_price_type']) ? sanitize_text_field($params['listing_price_type']) : "";
        $listing_currency_type = isset($params['listing_currency_type']) ? sanitize_text_field($params['listing_currency_type']) : "";
        $listing_price_from = isset($params['listing_pricefrom']) ? sanitize_text_field($params['listing_pricefrom']) : "";
        $listing_price_to = isset($params['listing_priceto']) ? sanitize_text_field($params['listing_priceto']) : "";
        $listing_video = isset($params['listing_videolink']) ? sanitize_text_field($params['listing_videolink']) : "";
        $listing_contact_email = isset($params['listing_contact_email']) ? sanitize_text_field($params['listing_contact_email']) : "";
        $listing_tags = isset($params['listing_tags']) ? sanitize_text_field($params['listing_tags']) : "";
        $listing_street = isset($params['listing_streetAddress']) ? sanitize_text_field($params['listing_streetAddress']) : "";
        $listing_lattitude = isset($params['listing_lat']) ? sanitize_text_field($params['listing_lat']) : "";
        $listing_longitide = isset($params['listing_long']) ? sanitize_text_field($params['listing_long']) : "";
        $listing_fb = isset($params['listing_fb']) ? sanitize_text_field($params['listing_fb']) : "";
        $listing_tw = isset($params['listing_tw']) ? sanitize_text_field($params['listing_tw']) : "";
        $listing_google = isset($params['listing_google']) ? sanitize_text_field($params['listing_google']) : "";
        $listing_in = isset($params['listing_in']) ? sanitize_text_field($params['listing_in']) : "";
        $listing_youtube = isset($params['listing_youtube']) ? sanitize_text_field($params['listing_youtube']) : "";
        $listing_insta = isset($params['listing_insta']) ? sanitize_text_field($params['listing_insta']) : "";
        $listing_whatsapp = isset($params['listing_whatsapp']) ? sanitize_text_field($params['listing_whatsapp']) : "";
        
        // Coupon code here
        $listing_coupon = isset($params['listing_coupon_title']) ? sanitize_text_field($params['listing_coupon_title']) : "";
        $listing_coupon_code = isset($params['listing_coupon_code']) ? sanitize_text_field($params['listing_coupon_code']) : "";
        $listing_coupon_referral = isset($params['listing_coupon_referral']) ? sanitize_text_field($params['listing_coupon_referral']) : "";
        $listing_coupon_exp = isset($params['listing_coupon_exp']) ? sanitize_text_field($params['listing_coupon_exp']) : "";
        $listing_coupon_desc = isset($params['dwt_listing_coupon_desc']) ? sanitize_textarea_field($params['dwt_listing_coupon_desc']) : "";
        $listing_brandname = isset($params['listing_brandname']) ? sanitize_textarea_field($params['listing_brandname']) : "";
        
    
        $ad_status = 'publish';
        if ($_POST['is_update'] != "") {
            $listing_id = $_POST['is_update'];
            if ($dwt_listing_options['dwt_listing_up_approval'] == 'manual') {
                $ad_status = 'pending';
            } else if (get_post_status($listing_id) == 'pending') {
                $ad_status = 'pending';
            }
            /* set first image to feature for display during social sharing */
            $media = get_attached_media('image', $listing_id);
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($listing_id, $single_media->ID);
                }
            }
        } else {
            if ($dwt_listing_options['dwt_listing_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            } else {
                $ad_status = 'publish';
            }
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
            /* set first image to feature for display during social sharing */
            $media = get_attached_media('image', $listing_id);
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($listing_id, $single_media->ID);
                }
            }
            /* Now user can post new ad */
            delete_user_meta(get_current_user_id(), 'listing_in_progress');
            $regular_listing = get_user_meta(get_current_user_id(), 'dwt_listing_regular_listing', true);
            if ($regular_listing > 0 && !is_super_admin(get_current_user_id())) {
                $regular_listing = $regular_listing - 1;
                update_user_meta(get_current_user_id(), 'dwt_listing_regular_listing', $regular_listing);
            }

            update_post_meta($listing_id, 'dwt_listing_ad_status', 'active');
            update_post_meta($listing_id, 'dwt_listing_is_feature', '0');
            /* == send email on new listing == */
            dwt_listing_notify_on_new_listing($listing_id);
        }
        /* Bad words filteration */
        $words = explode(',', $dwt_listing_options['dwt_listing_bad_words_filter']);
        $replace = $dwt_listing_options['dwt_listing_bad_words_replace'];
        $desc = dwt_listing_badwords_filter($words, $ad_desc, $replace);
        $title = dwt_listing_badwords_filter($words, $listing_title, $replace);
        //$desc	=	preg_replace('/style[^>]*/', '', $desc);
        $desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);
        $my_post = array(
            'ID' => $listing_id,
            'post_title' => $title,
            'post_status' => $ad_status,
            'post_content' => $desc,
            'post_name' => $title
        );
        wp_update_post($my_post);


        update_post_meta($listing_id, 'dwt_listing_listing_contact', $listing_contact);
        update_post_meta($listing_id, 'dwt_listing_listing_weburl', $listing_web_url);
        $price_type = '';
        if ($listing_price_type != "") {
            $pricetype_arr = explode('|', $listing_price_type);
            wp_set_post_terms($listing_id, $pricetype_arr[0], 'l_price_type');
            $price_type = $pricetype_arr[1];
        }
        update_post_meta($listing_id, 'dwt_listing_listing_priceType', $price_type);

        $currency_type = '';
        if ($listing_currency_type != "") {
            $currency_arr = explode('|', $listing_currency_type);
            wp_set_post_terms($listing_id, $currency_arr[0], 'l_currency');
            $currency_type = $currency_arr[1];
        }
        update_post_meta($listing_id, 'dwt_listing_listing_currencyType', $currency_type);

        update_post_meta($listing_id, 'dwt_listing_listing_pricefrom', $listing_price_from);
        update_post_meta($listing_id, 'dwt_listing_listing_priceto', $listing_price_to);
        if (!empty($listing_video)) {
            update_post_meta($listing_id, 'dwt_listing_listing_video', $listing_video);
        } else {
            update_post_meta($listing_id, 'dwt_listing_listing_video', '');
        }
        update_post_meta($listing_id, 'dwt_listing_related_email', $listing_contact_email);

        $tags = explode(',', $listing_tags);
        wp_set_object_terms($listing_id, $tags, 'l_tags');

        update_post_meta($listing_id, 'dwt_listing_listing_street', $listing_street);
        update_post_meta($listing_id, 'dwt_listing_listing_lat', $listing_lattitude);
        update_post_meta($listing_id, 'dwt_listing_listing_long', $listing_longitide);

        update_post_meta($listing_id, 'dwt_listing_listing_fb', $listing_fb);
        update_post_meta($listing_id, 'dwt_listing_listing_tw', $listing_tw);
        update_post_meta($listing_id, 'dwt_listing_listing_google', $listing_google);
        update_post_meta($listing_id, 'dwt_listing_listing_in', $listing_in);
        update_post_meta($listing_id, 'dwt_listing_youtube', $listing_youtube);
        update_post_meta($listing_id, 'dwt_listing_insta', $listing_insta);
        update_post_meta($listing_id, 'dwt_listing_whatsapp', $listing_whatsapp);
        update_post_meta($listing_id, 'dwt_listing_coupon_title', $listing_coupon);
        update_post_meta($listing_id, 'dwt_listing_coupon_code', $listing_coupon_code);
        update_post_meta($listing_id, 'dwt_listing_coupon_refer', $listing_coupon_referral);
        update_post_meta($listing_id, 'dwt_listing_coupon_desc', $listing_coupon_desc);
        update_post_meta($listing_id, 'dwt_listing_brand_name', $listing_brandname);
        update_post_meta($listing_id, 'dwt_listing_listing_status', '1');

        if ($listing_coupon_exp != '' && $listing_coupon_exp != '') {
            update_post_meta($listing_id, 'dwt_listing_coupon_expiry', $listing_coupon_exp);
        }

        /**
         * 0 = N/A
         * 1 = open 24/7
         * 2 = selective hours
         */
        $listing_is_open = isset($params['hours_type']) ? sanitize_text_field($params['hours_type']) : "";

        $listing_timezone = isset($params['listing_timezome']) ? sanitize_text_field($params['listing_timezome']) : "";
        
       
        /* checkbox for closed/not */
        $is_closed = isset($params['is_closed']) ? $params['is_closed'] : array();
        $start_from = isset($params['to']) ? $params['to'] : array();
        $end_from = isset($params['from']) ? $params['from'] : array();
        //get break hours data again input name
        $break_from =isset($params['breakfrom']) ? $params['breakfrom'] : array();
        $break_to=  isset($params['breakto']) ? $params['breakto'] : array();
        $break_click= isset($params['is_break']) ? $params['is_break'] : array();

        if ($listing_is_open == '1') {
            update_post_meta($listing_id, 'dwt_listing_is_hours_allow', '1');
            update_post_meta($listing_id, 'dwt_listing_business_hours', $listing_is_open);
        } /* listing business hours */

        else if ($listing_is_open == '2') {
            /* business hours */
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            for ($a = 0; $a <= 6; $a++) {
                $to = '';
                $from = '';
                $days = '';
                $break_time_from= '';
                $break_time_to= '';
                //get days
                $days = lcfirst($custom_days[$a]);

                if (!in_array($a, $is_closed)) {
                    $from = date("H:i:s", strtotime(str_replace(" : ", ":", $end_from[$a])));
                    $to = date("H:i:s", strtotime(str_replace(" : ", ":", $start_from[$a])));
                    //day status open or not
                    update_post_meta($listing_id, '_timingz_' . $days . '_open', '1');
                    //day hours from
                    update_post_meta($listing_id, '_timingz_' . $days . '_from', $from);
                    update_post_meta($listing_id, '_timingz_' . $days . '_to', $to);
                    //break hours
                    if (in_array($a, $break_click)) {

                        $break_time_from = isset($break_from[$a])  &&  $break_from[$a] != ""?       date("H:i:s", strtotime(str_replace(" : ", ":", $break_from[$a]))) : "";
                        $break_time_to   =   isset($break_to[$a]) && $break_to[$a] != "" ?   date("H:i:s", strtotime(str_replace(" : ", ":", $break_to[$a]))) : "";

                        update_post_meta($listing_id, '_timingz_break_' . $days . '_open', '1');
                        update_post_meta($listing_id, '_timingz_break_' . $days . '_breakfrom', $break_time_from);
                        update_post_meta($listing_id, '_timingz_break_' . $days . '_breakto', $break_time_to);
                    }
                    else
                    {
                        update_post_meta($listing_id, '_timingz_break_' . $days . '_open', '0');
                        update_post_meta($listing_id, '_timingz_break_' . $days . '_breakfrom', '');
                        update_post_meta($listing_id, '_timingz_break_' . $days . '_breakto', '');
                    }
                }
                else {
                    update_post_meta($listing_id, '_timingz_' . $days . '_open', '0');
                }
            }
            update_post_meta($listing_id, 'dwt_listing_business_hours', 0);
            update_post_meta($listing_id, 'dwt_listing_user_timezone', $listing_timezone);
            update_post_meta($listing_id, 'dwt_listing_is_hours_allow', '1');

        } else {
            update_post_meta($listing_id, 'dwt_listing_is_hours_allow', '0');
            /* add this code on 26-aug-2020(because n/a not show if user choose N/A) */
            update_post_meta($listing_id, 'dwt_listing_business_hours', '');
        }

        /* categories */
        $category = array();
        $category_main = array();
        $category_sub = array();
        if ($params['d_cats'] != "") {
            $category_main[] = $params['d_cats'];
        }
        if ($params['cat_features'] != "") {
           $category_sub = isset($params['cat_features']) ? $params['cat_features'] : "";

        }

        /* check if parent has any child */
        $if_cats = dwt_listing_categories_fetch('l_category', $params['d_cats']);
        if (count($if_cats) > 0) {
            $category = array_merge($category_main, $category_sub);
        } else {
            $category[] = $params['d_cats'];
        }
        wp_set_post_terms($listing_id, $category, 'l_category');
        /* countries */
        $countries = array();
        if ($params['d_country'] != "") {
            $countries[] = $params['d_country'];
        }
        if ($params['d_state'] != "") {
            $countries[] = $params['d_state'];
        }
        if ($params['d_city'] != "") {
            $countries[] = $params['d_city'];
        }
        if ($params['d_town'] != "") {
            $countries[] = $params['d_town'];
        }
        /* Featured Listing */
        if (isset($params['make_listing_featured']) && $params['make_listing_featured'] == "1") {
            // Getting User Featured Ads.
            $featured_ad = get_user_meta(get_current_user_id(), 'dwt_listing_featured_listing', true);
            if ($featured_ad > 0) {
                update_post_meta($listing_id, 'dwt_listing_is_feature', '1');
                update_post_meta($listing_id, 'dwt_listing_feature_ad_expiry_days', date('Y-m-d'));
                $featured_ad = $featured_ad - 1;
                update_user_meta(get_current_user_id(), 'dwt_listing_featured_listing', $featured_ad);
            }
        }
        /* Bump Listing */
        if (isset($params['make_listing_bump']) && $params['make_listing_bump'] == "1") {
            /* Getting User Featured Ads. */
            $bump_linting = get_user_meta(get_current_user_id(), 'dwt_listing_bump_listing', true);
            if ($bump_linting > 0) {
                $current_time = current_time('mysql');
                wp_update_post
                (
                    array
                    (
                        'ID' => $listing_id,
                        'post_date' => $current_time,
                        'post_date_gmt' => get_gmt_from_date($current_time)
                    )
                );
                update_post_meta($listing_id, 'dwt_listing_is_bump', '1');
                $bump_linting = $bump_linting - 1;
                update_user_meta(get_current_user_id(), 'dwt_listing_bump_listing', $bump_linting);
            }
        }
        /* set location */
        wp_set_post_terms($listing_id, $countries, 'l_location');
        $get_custom_fields = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '" . $listing_id . "' AND meta_key LIKE 'field_multi_%'");

        /* listing custom form fields */
        foreach ($params as $key => $value) {
            if (strpos($key, 'field_multi_') === 0) {
                if (is_array($value)) {
                    $array_values = '';
                    if (count($value) > 0) {
                        foreach ($value as $val) {
                            $array_values .= $val . '|';
                        }
                        $trim_values = rtrim($array_values, '|');
                        add_post_meta($listing_id, $key, $trim_values);
                    }
                } else {
                    if ($value != "0" && $value != '') {
                        add_post_meta($listing_id, $key, $value);
                    }
                }
            }
        }
        /* == WPML duplicate post in all languages when new post created == */
        do_action('dwt_listing_duplicate_posts_lang_wpml', $listing_id, 'listing');
        $listing_update_url = '';
        $listing_update_url = dwt_listing_page_lang_url_callback(get_the_permalink($listing_id));
        echo $listing_update_url;
        die();
    }

}


/* Ad Listing Images ... */
add_action('wp_ajax_upload_dwt_listing_listing_images', 'dwt_listing_listing_gallery');
if (!function_exists('dwt_listing_listing_gallery')) {

    function dwt_listing_listing_gallery()
    {
        global $dwt_listing_options;
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }
        if (isset($dwt_listing_options['dwt_listing_standard_images_size']) && $dwt_listing_options['dwt_listing_standard_images_size']) {
            list($width, $height) = getimagesize($_FILES["my_file_upload"]["tmp_name"]);
            if ($width < 760) {
                echo '0|' . __("Minimum image dimension should be", 'dwt-listing') . ' 750x450';
                die();
            }
            if ($height < 410) {
                echo '0|' . __("Minimum image dimension should be", 'dwt-listing') . ' 750x450';
                die();
            }
        }

        $gallery_limit = $_GET['gallery_limit'];
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $size_arr = explode('-', $dwt_listing_options['dwt_listing_image_up_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];
        

        /* Allow certain file formats */
        $imageFileType = strtolower(end(explode('.', $_FILES['my_file_upload']['name'])));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
            echo '0|' . __("Sorry, only JPG, JPEG, PNG, WEBP & GIF files are allowed.", 'dwt-listing');
            die();
        }
        /* Check file size */
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . __("Max allowed image size is", 'dwt-listing') . " " . $display_size;
            die();
        }
        /* Let WordPress handle the upload. */
        /* Remember, 'my_image_upload' is the name of our file input in our form above. */
        if ($_GET['is_update'] != "") {
            $listing_id = $_GET['is_update'];
        } else {
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        }

        if ($listing_id == "") {
            echo '0|' . __("Please enter title first in order to create listing.", 'dwt-listing');
            die();
        }

            if( get_post_meta($listing_id, 'dwt_listing_brand_img', true) != ""){
                $gallery_limit = $gallery_limit + 1;
            }
        /* Check max image limit */
        $media = get_attached_media('image', $listing_id);
       
        if (count($media) >= $gallery_limit) {
            $msg = esc_html__("Sorry you cant upload more than ", 'dwt-listing');
            $images_l = esc_html__(" images ", 'dwt-listing');
            echo '0|' . $msg . $gallery_limit . $images_l;
            die();
        }

        $attachment_id = media_handle_upload('my_file_upload', $listing_id);
        if (!is_wp_error($attachment_id)) {
            $imgaes = get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true);
            if ($imgaes != "") {
                $imgaes = $imgaes . ',' . $attachment_id;
                update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $imgaes);
            } else {
                update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $attachment_id);
            }
            echo '' . $attachment_id;
            die();
        } else {
            echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
            die();
        }
    }

}

/* Fetch Listing Images ... */
add_action('wp_ajax_get_uploaded_ad_images', 'dwt_listing_get_uploaded_listing_images');
if (!function_exists('dwt_listing_get_uploaded_listing_images')) {

    function dwt_listing_get_uploaded_listing_images()
    {
        if ($_POST['is_update'] != "") {
            $listing_id = $_POST['is_update'];
        } else {
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        }
        if ($listing_id == "") {
            return '';
        }
        $media = dwt_listing_fetch_listing_gallery($listing_id);
        $result = array();
        foreach ($media as $m) {
            $mid = '';
            $guid = '';
            if (isset($m->ID)) {
                $mid = $m->ID;
                $source = wp_get_attachment_image_src($mid, 'thumbnail');
                $path = $source[0];
            } else {
                $mid = $m;
                $source = wp_get_attachment_image_src($mid, 'thumbnail');
                $path = $source[0];
            }
            $obj = array();
            $obj['dispaly_name'] = basename(get_attached_file($mid));
            $obj['name'] = $path;
            $obj['size'] = filesize(get_attached_file($mid));
            $obj['id'] = $mid;
            $result[] = $obj;

        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($result);
        die();
    }

}


// Hook the dwt_listing_delete_listing_image() function to the wp_ajax_delete_listing_image action
add_action('wp_ajax_delete_listing_image', 'dwt_listing_delete_listing_image');

// Define the dwt_listing_delete_listing_image() function
if (!function_exists('dwt_listing_delete_listing_image')) {
    function dwt_listing_delete_listing_image()
    {
        // Check if editing is disabled for demo and the current user is not a super admin
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }

         
        // Check if the current user is logged in
        if (get_current_user_id() == 0) {
            die();
        }
 


        // Get the listing ID from the POST data
        if ($_POST['is_update'] != "") {
            $listing_id = $_POST['is_update'];
        } else {
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        }


        // Check if the current user is not a super admin and is not the author of the post
        if ( get_post_field('post_author', $listing_id) == get_current_user_id()) 
        {
            // Get the attachment ID from the POST data
            $attachment_id = isset($_POST["img"]) ? $_POST["img"] : null;

            // Delete the attachment
            wp_delete_attachment($attachment_id, true);

            // Update the photo arrangement meta data for the post
            if (get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true) != "")
            {
                $ids = get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true);
                $res = str_replace($attachment_id, "", $ids);
                $res = str_replace(',,', ",", $res);
                $img_ids = trim($res, ',');

                update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $img_ids);
            }

                // Output a success message
                echo "1";
                // Stop further execution of the script
               wp_die();
        }
   }
}




/* Sort Listing Images */
add_action('wp_ajax_dwt_listing_sort_listing_images', 'dwt_listing_listing_images_sort');
if (!function_exists('dwt_listing_listing_images_sort')) {

    function dwt_listing_listing_images_sort()
    {
        update_post_meta($_POST['listing_id'], 'dwt_listing_photo_arrangement_', $_POST['ids']);
        die();
    }

}



/* Mark as featured listing */
add_action('wp_ajax_make_listing_featured', 'dwt_listing_make_listing_featured');
if (!function_exists('dwt_listing_make_listing_featured')) {

    function dwt_listing_make_listing_featured()
    {
        $listing_id = $_POST['listing_id'];
        $user_id = get_current_user_id();
        if (get_post_field('post_author', $listing_id) == $user_id) {
            if (get_user_meta($user_id, 'dwt_listing_featured_listing', true) != 0) {
                if (get_user_meta($user_id, 'dwt_listing_package_expiry', true) != '-1') {
                    if (get_user_meta($user_id, 'dwt_listing_package_expiry', true) < date('Y-m-d')) {
                        echo '0|' . esc_html__("Your package has bee expired.", 'dwt-listing');
                        die();
                    }
                }
                $feature_ads = get_user_meta($user_id, 'dwt_listing_featured_listing', true);
                $feature_ads = $feature_ads - 1;
                update_user_meta($user_id, 'dwt_listing_featured_listing', $feature_ads);

                update_post_meta($listing_id, 'dwt_listing_is_feature', '1');
                update_post_meta($listing_id, 'dwt_listing_feature_ad_expiry_days', date('Y-m-d'));
                echo '1|' . esc_html__("This listing has been featured successfullly.", 'dwt-listing');
            } else {
                echo '0|' . esc_html__("Get package in order to make it feature.", 'dwt-listing');
            }
        } else {
            echo '0|' . esc_html__("You must be listing owner to make it feature.", 'dwt-listing');
        }
        die();
    }

}


/* fetch business hours */
if (!function_exists('dwt_listing_fetch_business_hours')) {

    function dwt_listing_fetch_business_hours($listing_id)
    {
        global $dwt_listing_options;
        $days_name = dwt_listing_week_days();
        $days = '';
        /* check option is yes or not */
        if (get_post_meta($listing_id, 'dwt_listing_business_hours', true) != "") {
            $listing_is_opened = get_post_meta($listing_id, 'dwt_listing_business_hours', true);
            $days = array();
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);


                if (get_post_meta($listing_id, '_timingz_' . $week_days . '_open', true) == 1) {
                    //days which are opened
                    $is_break_on     =    get_post_meta($listing_id, '_timingz_break_' . $week_days . '_open', true) ;
                    $breeak_from1     =   get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakfrom', true);
                    $breeak_tooo1     =   get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakto', true);

                    $time_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    $breeak_from =  isset($breeak_from1) && $breeak_from1 !=""  ?   date('H:i:s', strtotime($breeak_from1))  :   "";
                    $breeak_tooo = isset($breeak_tooo1) && $breeak_tooo1 != ""  ?   date('H:i:s', strtotime($breeak_tooo1))  : "";

                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "break_from" => $breeak_from, "break_too"=>$breeak_tooo, "closed" => '', "break"=> $is_break_on);
                }
                else {
                    //days which are closed
                    $time_from = date('g:i A', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('g:i A', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => 1, "break"=>'');
                }
            }
            return $days;
        }
    }

}

/* get form fields against category */
if (!function_exists('dwt_listing_fetch_cat_form_fields')) {

    function dwt_listing_fetch_cat_form_fields($category_id, $is_update = '', $listing_id = '')
    {
        $fetch_form_fields = get_posts(array('post_type' => 'l_form_fields', 'post_status' => 'publish', 'order' => 'ASC',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'l_category',
                        'field' => 'term_id',
                        'terms' => $category_id)
                ))
        );
        $check_html = $selected = '';
        $form_multicheck = '';
        $fetch_options = '';
        $form_multiradio = '';
        $form_multiselect = '';
        if (count($fetch_form_fields) > 0) {
            foreach ($fetch_form_fields as $form_fields) {
                $text_field_val = '';
                $post_id = $form_fields->ID;
                $check_html = $selected = '';
                //for update
                if ($is_update == 1 && $listing_id != "") {
                    //text fields data fetch
                    if (get_post_meta($listing_id, 'field_multi_text_' . $post_id . '', true) != "") {
                        $text_field_val = get_post_meta($listing_id, 'field_multi_text_' . $post_id . '', true);
                    }
                    /* mulitcheckboxes data fetch */
                    if (get_post_meta($listing_id, 'field_multi_check_' . $post_id . '', true) != "") {
                        if (get_post_meta($listing_id, 'field_multi_check_' . $post_id . '', true) != "") {
                            $form_multicheck = get_post_meta($listing_id, 'field_multi_check_' . $post_id . '', true);
                            $fetch_options = explode('|', $form_multicheck);
                        }
                    }
                    /* radio buttons data fetch */
                    if (get_post_meta($listing_id, 'field_multi_radio_' . $post_id . '', true) != "") {
                        $form_multiradio = get_post_meta($listing_id, 'field_multi_radio_' . $post_id . '', true);
                    }
                    /* select dropdown data fetch */
                    if (get_post_meta($listing_id, 'field_multi_select_' . $post_id . '', true) != "") {
                        $form_multiselect = get_post_meta($listing_id, 'field_multi_select_' . $post_id . '', true);
                    }
                }

                /* fetch generated field type */
                $field_type = get_post_meta($post_id, 'd_field_type', true);
                if ($field_type == 'text') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_textfields');
                    if (count($options) > 0) {
                        $check_html .= '<div class="form-group has-feedback">';
                        $check_html .= '<label class="control-label">' . $form_fields->post_title . '</label>';
                        foreach ($options as $opt) {
                            $check_html .= '<input type="text" class="form-control" value="' . $text_field_val . '"  name="field_multi_text_' . $post_id . '">';
                        }
                        $check_html .= '</div>';
                        $check_html = '<div class="col-md-4 col-xs-12 col-sm-12"><div class="div-seprator">' . $check_html . '</div></div>';
                    }
                }
                if ($field_type == 'multiplecheck') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_check');
                    if (count($options) > 0) {
                        $check_html .= '<h4 class="fields-custom-text">' . $form_fields->post_title . '</h4>';
                        $check_html .= '<ul class="my_fields">';
                        foreach ($options as $opt) {
                            if ($fetch_options != "") {
                                $selected = (in_array($opt, $fetch_options)) ? 'checked="checked"' : '';
                            }
                            $check_html .= '<li><input type="checkbox" class="custom-checkbox" ' . $selected . ' value="' . $opt . '" name="field_multi_check_' . $post_id . '[]"></span> <label for="' . $opt . '"> ' . $opt . '</label></li>';
                        }
                        $check_html .= '</ul>';

                        $check_html = '<div class="category-based-fields">' . $check_html . '</div>';
                    }
                }
                if ($field_type == 'radio') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_radio');
                    if (count($options) > 0) {
                        $check_html .= '<h4 class="fields-custom-text">' . $form_fields->post_title . '</h4>';
                        $check_html .= '<ul class="my_fields">';
                        foreach ($options as $opt) {
                            $selected = ($opt == $form_multiradio) ? 'checked="checked"' : '';
                            $check_html .= '<li><input type="radio" class="custom-checkbox" ' . $selected . ' value="' . $opt . '" name="field_multi_radio_' . $post_id . '"></span> <label for="' . $opt . '"> ' . $opt . '</label></li>';
                        }
                        $check_html .= '</ul>';
                        $check_html = '<div class="category-based-fields">' . $check_html . '</div>';
                    }
                }
                if ($field_type == 'dropdownselect') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_drop_val');
                    if (count($options) > 0) {
                        $check_html .= '<div class="selective-dropdowns"> <div class="form-group">';
                        $check_html_options = '';
                        $check_html .= '<label class="control-label">' . $form_fields->post_title . '</label>';

                        foreach ($options as $opt) {
                            $selected = ($opt == $form_multiselect) ? 'selected="selected"' : '';
                            $check_html_options .= '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
                        }
                        $check_html .= '<select data-placeholder="' . esc_html__('Select an option', 'dwt-listing') . '" class="custom-fields" name="field_multi_select_' . $post_id . '">';
                        $check_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
                        $check_html .= $check_html_options;
                        $check_html .= '</select>';
                        $check_html .= '</div></div>';
                        $check_html = '<div class="col-md-4 col-xs-12 col-sm-6">' . $check_html . '</div>';
                    }
                }
                echo '' . $check_html;
            }
        }
    }

}


/* get form fields against category */
if (!function_exists('dwt_listing_render_custom_fields')) {

    function dwt_listing_render_custom_fields($post_id, $field_name)
    {
        $field_values = array();
        $fields = get_post_meta($post_id, $field_name, true);
        $options = explode('|', $fields);
        return $options;
    }

}


add_action('wp_ajax_dwt_listing_get_custom_fields', 'dwt_listing_get_custom_fields');

function dwt_listing_get_custom_fields()
{
    if (isset($_POST['cat_id']) && $_POST['cat_id'] != "") {
        $cat_id = $_POST['cat_id'];
        /* check if there is any custom field */
        echo dwt_listing_fetch_cat_form_fields($cat_id);
        die();
    }
}

/*
 * track leadz
 */
add_action('wp_ajax_track_my_leadz', 'dwt_listing_track_my_leadz');
add_action('wp_ajax_nopriv_track_my_leadz', 'dwt_listing_track_my_leadz');

function dwt_listing_track_my_leadz()
{
    if (isset($_POST['listing_id']) && $_POST['listing_id'] != "" && $_POST['lead_type'] != "") {
        $listing_id = $_POST['listing_id'];
        $listing_lead_type = $_POST['lead_type'];

        if ($listing_lead_type == 'contact') {
            /* if count is already there */
            if (get_post_meta($listing_id, '_dowtown_contact_leads', true) != "") {
                $current_count = get_post_meta($listing_id, '_dowtown_contact_leads', true);
                $update_count = $current_count + 1;
                update_post_meta($listing_id, '_dowtown_contact_leads', $update_count);
                dwt_listing_track_activity($listing_id, 'leads', $listing_lead_type);
            } else {
                update_post_meta($listing_id, '_dowtown_contact_leads', 1);
                dwt_listing_track_activity($listing_id, 'leads', $listing_lead_type);
            }
        } else {
            /* if count is already there */
            if (get_post_meta($listing_id, '_dowtown_web_leads', true) != "") {
                $current_count = get_post_meta($listing_id, '_dowtown_web_leads', true);
                $update_count = $current_count + 1;
                update_post_meta($listing_id, '_dowtown_web_leads', $update_count);
                dwt_listing_track_activity($listing_id, 'leads', $listing_lead_type);
            } else {
                update_post_meta($listing_id, '_dowtown_web_leads', 1);
                dwt_listing_track_activity($listing_id, 'leads', $listing_lead_type);
            }
        }
        die();
    }
}

/* Categories Features For Map */
add_action('wp_ajax_nopriv_dwt_listing_get_cat_featurez', 'dwt_listing_get_cat_featurez_ajax');
add_action('wp_ajax_dwt_listing_get_cat_featurez', 'dwt_listing_get_cat_featurez_ajax');

function dwt_listing_get_cat_featurez_ajax()
{
    if (isset($_POST['category_id']) && $_POST['category_id'] != "") {
        $cat_id = $_POST['category_id'];
        $name = get_term_by('id', $cat_id, 'l_category');
        $tax_name = $name->name;
        $features = dwt_listing_categories_fetch('l_category', $cat_id);
        if (count((array)$features) > 0) {
            $cats_html = ' <div class="panel-group" id="accordionz" role="tablist" aria-multiselectable="true"><div class="panel panel-default"><div class="panel-heading" role="tab" id="feat_anam">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordionz" href="#featurez" aria-expanded="true" aria-controls="featurez">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        ' . esc_html__('Features', 'dwt-listing') . '
                    </a>
                </h4>
            </div><div id="featurez" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="feat_anam">  <div class="panel-body"><ul class="list-inline">';
            foreach ($features as $feature) {
                $cats_html .= '<li>
							  <input type="checkbox" id=" ' . esc_url($feature->slug) . '" name="amenties[]"  value="' . esc_attr($feature->term_id) . '" class="custom-checkbox">
							  <label for="' . esc_url($feature->slug) . '">' . esc_attr($feature->name) . '</label>
							</li>';
            }
            $cats_html .= ' <input id="d_getfilters" class="btn btn-theme" type="button" value="' . esc_html__('Filter', 'dwt-listing') . '" ></ul></div></div></div></div><div class="clearfix"></div>';
            echo '' . $cats_html;
            die();
        } else {
            die();
        }
    } else {
        die();
    }
}

/* Categories Features For Sidebar */
add_action('wp_ajax_nopriv_dwt_listing_get_cat_featurez_sidebar', 'dwt_listing_get_cat_featurez_ajax_sidebar');
add_action('wp_ajax_dwt_listing_get_cat_featurez_sidebar', 'dwt_listing_get_cat_featurez_ajax_sidebar');

function dwt_listing_get_cat_featurez_ajax_sidebar()
{
    if (isset($_POST['category_id']) && $_POST['category_id'] != "") {
        $ul_class = '<div class="amenties" ><h4 class="for_amenties">' . esc_html__('Search By Features', 'dwt-listing') . '</h4><div id="amenties-dropdown" class="collapse in"><ul>';
        if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
            $btn_block = '';
            $ul_class = '<div class="amentiesz" ><h4 class="for_amenties">' . esc_html__('Search By Features', 'dwt-listing') . '</h4><div id="amenties-dropdown" class="collapse in"><ul class="list-inline">';
        } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
            $btn_block = '';
        } else {
            $btn_block = 'btn-block';
        }

        $cat_id = $_POST['category_id'];
        $name = get_term_by('id', $cat_id, 'l_category');
        $tax_name = $name->name;
        $features = dwt_listing_categories_fetch('l_category', $cat_id);
        if (count((array)$features) > 0) {
            $cats_html = $ul_class;
            foreach ($features as $feature) {
                $cats_html .= '<li>
							  <input type="checkbox" id=" ' . esc_attr($feature->term_id) . '" name="amenties[]"  value="' . esc_attr($feature->term_id) . '" class="custom-checkbox amenties_filterz">
							  <label for="' . esc_url($feature->term_id) . '">' . esc_attr($feature->name) . '</label>
							</li>';
            }
            $cats_html .= '</ul> </div> <input id="d_getfilters" class="btn btn-theme btn-sm ' . $btn_block . '" type="button" value="' . esc_html__('Search', 'dwt-listing') . '">
 </div>';
            echo '' . $cats_html;
        }
        die();
    } else {
        die();
    }
}

add_action('wp_ajax_dwt_upload_cover', 'dwt_listing_user_listing_cover');
if (!function_exists('dwt_listing_user_listing_cover')) {

    function dwt_listing_user_listing_cover()
    {
        global $dwt_listing_options;
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }
        $listing_id = '';
        if ($_GET['is_update'] != "") {
            $listing_id = $_GET['is_update'];
        } else {
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        }

        if ($listing_id == "") {
            echo '0|' . __("Please enter title first in order to create listing.", 'dwt-listing');
            die();
        }

        if (!empty($_FILES["c-cover-listing"])) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $files = $_FILES["c-cover-listing"];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $_FILES = array("c-cover-listing" => $file);
                    foreach ($_FILES as $file => $array) {
                        $attach_id = media_handle_upload($file, $post_id);
                        if (!is_wp_error($attach_id)) {
                            update_post_meta($listing_id, 'dwt_listing_cover_photo', $attach_id);
                            echo '1|' . $attach_id;
                            die();
                        } else {
                            echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                            die();
                        }
                    }
                }
            }
        }
    }

}

/* Delete Fetch Cover Image ... */
add_action('wp_ajax_delete_listing_cover_image', 'dwt_listing_delete_listing_cover_image');
if (!function_exists('dwt_listing_delete_listing_cover_image')) {

    function dwt_listing_delete_listing_cover_image()
    {
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }

        if (get_current_user_id() == "")
            die();

        if ($_POST['is_update'] != "") {
            $listing_id = $_POST['is_update'];
        }
        if (!is_super_admin(get_current_user_id()) && get_post_field('post_author', $listing_id) != get_current_user_id())
            die();

        $attachmentid = $_POST['cover_id'];
        wp_delete_attachment($attachmentid, true);
        if (get_post_meta($listing_id, 'dwt_listing_cover_photo', true) != "") {
            update_post_meta($listing_id, 'dwt_listing_cover_photo', '');
        }
        $get_cover_img = '';
        $get_cover_img = dwt_listing_get_cover_img($listing_id, 'full');
        echo '1|' . $get_cover_img;
        die();
    }

}

/* Upload brand image ... */
add_action('wp_ajax_dwt_upload_brand_img', 'dwt_upload_brand_img_on_listing');
if (!function_exists('dwt_upload_brand_img_on_listing')) {

    function dwt_upload_brand_img_on_listing()
    {
        global $dwt_listing_options;
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }
        if ($_GET['is_update'] != "") {
            $listing_id = $_GET['is_update'];
        } else {
            $listing_id = get_user_meta(get_current_user_id(), 'listing_in_progress', true);
        }

        if ($listing_id == "") {
            echo '0|' . __("Please enter title first in order to create listing.", 'dwt-listing');
            die();
        }

        if (!empty($_FILES["c-cover-brand"])) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $files = $_FILES["c-cover-brand"];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $_FILES = array("c-cover-brand" => $file);

                    /* Allow certain file formats */
                    $imageFileType = strtolower(end(explode('.', $file['name'])));
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'dwt-listing');
                        die();
                    }

                    /* Check file size */
                    if ($file['size'] > 2097152) {
                        echo '0|' . __("Max allowd image size is 2MB", 'dwt-listing');
                        die();
                    }
                    foreach ($_FILES as $file => $array) {
                        $attach_id = media_handle_upload($file, $listing_id);
                        if (!is_wp_error($attach_id)) {
                            update_post_meta($listing_id, 'dwt_listing_brand_img', $attach_id);
                            echo '1|' . $attach_id;
                            die();
                        } else {
                            echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                            die();
                        }
                    }
                }
            }
        }
    }

}

/* Delete Brand Image ... */
add_action('wp_ajax_delete_brand_listing_image', 'dwt_listing_delete_brand_img');
if (!function_exists('dwt_listing_delete_brand_img')) {

    function dwt_listing_delete_brand_img()
    {
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }
        if (get_current_user_id() == "")
            die();
        $listing_id = $_POST['listing_id'];
        $attachmentid = $_POST['brand_img_id'];
        if (!empty($listing_id) && !empty($attachmentid)) {
            wp_delete_attachment($attachmentid, true);
            if (get_post_meta($listing_id, 'dwt_listing_brand_img', true) != "") {
                update_post_meta($listing_id, 'dwt_listing_brand_img', '');
            }
            $get_cover_img = '';
            $get_cover_img = dwt_listing_get_brand_img($listing_id, 'dwt_listing_user-dp');
            echo '1|' . $get_cover_img;
            die();
        } else {
            echo '0|' . __("Oops! Something went wrong, please try again.", 'dwt-listing');
            die();
        }
    }

}