<?php
class listing_meta_boxes {

    public function __construct() {

        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox() {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);
    }

    public function add_metabox() {

        add_meta_box(
            'listing_meta_fields', __('Listing Fields', 'dwt-listing-framework'), array($this, 'render_metabox'), 'listing', 'advanced', 'default'
        );
    }

    public function render_metabox($post) {
        // Add nonce for security and authentication.
        wp_nonce_field('listing_nonce_action', 'listing_nonce');

        $listing_id = $post->ID;
        $class_six = $class_five = $class_four = $class_three = $class_two = $class_custom_fields = $class = 'none';

        $state_html = $ad_countries = $country_level = $get_object_terms_country = $countries = $catz_feature = $catz = $category_id = $listing_currency = $price_type = $ip_type = $listing_longitide = $listing_lattitude = '';
        $states = '';
        $selected = '';
        $cities = '';
        $towns = '';
        $cities_html = '';
        $towns_html = '';
        $listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
        $listing_longitide = dwt_listing_text('dwt_listing_default_long');
        $ip_type = dwt_listing_text('dwt_geo_api_settings');

        // Retrieve an existing value from the database.
        $listing_contact = get_post_meta($listing_id, 'dwt_listing_listing_contact', true);
        $listing_web_url = get_post_meta($listing_id, 'dwt_listing_listing_weburl', true);
        $listing_price_type = get_post_meta($listing_id, 'dwt_listing_listing_priceType', true);
        $listing_currency_type = get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true);

        $listing_price_from = get_post_meta($listing_id, 'dwt_listing_listing_pricefrom', true);
        $listing_price_to = get_post_meta($listing_id, 'dwt_listing_listing_priceto', true);
        $listing_video = get_post_meta($listing_id, 'dwt_listing_listing_video', true);
        $listing_contact_email = get_post_meta($listing_id, 'dwt_listing_related_email', true);

        $listing_coupon = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
        $listing_coupon_code = get_post_meta($listing_id, 'dwt_listing_coupon_code', true);
        $listing_coupon_referral = get_post_meta($listing_id, 'dwt_listing_coupon_refer', true);
        $listing_coupon_exp = get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true);
        $listing_coupon_desc = get_post_meta($listing_id, 'dwt_listing_coupon_desc', true);

        $timekit_booking_widget_code = get_post_meta($listing_id, 'dwt-listing-timekit-booking', true);


        $listing_street = get_post_meta($listing_id, 'dwt_listing_listing_street', true);
        $listing_timezone = get_post_meta($listing_id, 'dwt_listing_user_timezone', true);

        if (get_post_meta($listing_id, 'dwt_listing_listing_lat', true) != "") {
            $listing_lattitude = get_post_meta($listing_id, 'dwt_listing_listing_lat', true);
        }
        if (get_post_meta($listing_id, 'dwt_listing_listing_long', true) != "") {
            $listing_longitide = get_post_meta($listing_id, 'dwt_listing_listing_long', true);
        }
        $listing_fb = get_post_meta($listing_id, 'dwt_listing_listing_fb', true);
        $listing_tw = get_post_meta($listing_id, 'dwt_listing_listing_tw', true);
        $listing_google = get_post_meta($listing_id, 'dwt_listing_listing_google', true);
        $listing_in = get_post_meta($listing_id, 'dwt_listing_listing_in', true);
        $listing_youtube = get_post_meta($listing_id, 'dwt_listing_youtube', true);
        $listing_insta = get_post_meta($listing_id, 'dwt_listing_insta', true);
        $listing_whatsapp = get_post_meta($listing_id, 'dwt_listing_whatsapp', true);
        //Get categories levels
        $get_object_terms = dwt_listing_selected_catz($listing_id);
        $category_level = count($get_object_terms);
        if ($category_level >= 2) {
            $listing_categories = wp_get_object_terms($listing_id, 'l_category', array("fields" => "ids"));
            $class = 'nones';
            $features = dwt_listing_categories_fetch('l_category', $get_object_terms[0]['id']);
            $cats_features = '<ul>';
            foreach ($features as $feature) {
                $selected = (in_array($feature->term_id, $listing_categories)) ? 'checked="checked"' : '';

                $cats_features .= '<li><input type="checkbox" class="custom-checkbox" value="' . $feature->term_id . '" name="cat_features[]" ' . $selected . '></span> <label for="' . $feature->name . '"> ' . $feature->name . '</label></li>';
            }
            $cats_features .= '</ul>';
        }

        //get dynmaic custom form fields
        if (isset($get_object_terms[0]['id']) && $get_object_terms[0]['id'] != "") {
            $category_id = $get_object_terms[0]['id'];
            $class_custom_fields = '';
        }
        $selected_val = 0;
        if (get_post_meta($listing_id, 'dwt_listing_is_hours_allow', true) == 1) {
            if (get_post_meta($listing_id, 'dwt_listing_business_hours', true) == '1') {
                $selected_val = 1;
            } else {
                $selected_val = 2;
            }
        }
        $listing_brandname = get_post_meta($listing_id, 'dwt_listing_brand_name', true);

        // Set default values.
        if (empty($listing_contact))
            $listing_contact = '';
        if (empty($listing_web_url))
            $listing_web_url = '';
        if (empty($listing_price_type))
            $listing_price_type = '';
        if (empty($listing_currency_type))
            $listing_currency_type = '';
        if (empty($listing_price_from))
            $listing_price_from = '';
        if (empty($listing_price_to))
            $listing_price_to = '';
        if (empty($listing_video))
            $listing_video = '';
        if (empty($listing_contact_email))
            $listing_contact_email = '';
        if (empty($listing_coupon))
            $listing_coupon = '';
        if (empty($listing_coupon_code))
            $listing_coupon_code = '';
        if (empty($listing_coupon_referral))
            $listing_coupon_referral = '';
        if (empty($listing_coupon_exp))
            $listing_coupon_exp = '';
        if (empty($listing_coupon_desc))
            $listing_coupon_desc = '';
        if (empty($timekit_booking_widget_code))
            $timekit_booking_widget_code = '';
        if (empty($listing_street))
            $listing_street = '';
        if (empty($listing_fb))
            $listing_fb = '';
        if (empty($listing_tw))
            $listing_tw = '';
        if (empty($listing_youtube))
            $listing_youtube = '';
        if (empty($listing_insta))
            $listing_insta = '';
        if (empty($listing_whatsapp))
            $listing_whatsapp = '';
        if (empty($listing_google))
            $listing_google = '';
        if (empty($listing_in))
            $listing_in = '';
        if (empty($get_object_terms))
            $get_object_terms = '';
        if (empty($category_level))
            $category_level = '';
        if (empty($cats_features))
            $cats_features = '';
        if (empty($category_id))
            $category_id = '';
        if (empty($listing_timezone))
            $listing_timezone = '';
        if (empty($listing_brandname))
            $listing_brandname = '';
        $gallery_thumbs = '';

        //Get price type
        $price_type = dwt_listing_categories_fetch('l_price_type', 0);
        $price_type_html = '';
        foreach ($price_type as $price_types) {
            $selected = '';
            if ($listing_price_type == $price_types->name) {
                $selected = ' selected="selected"';
            }
            $price_type_html .= '<option value="' . $price_types->term_id . '|' . $price_types->name . '"' . $selected . '>' . $price_types->name . '</option>';
        }
        //Listing Currency Type
        $listing_currency = dwt_listing_categories_fetch('l_currency', 0);
        $listing_currency_html = '';
        foreach ($listing_currency as $currency) {
            $selected = '';
            if ($listing_currency_type == $currency->name) {
                $selected = ' selected="selected"';
            }

            $listing_currency_html .= '<option value="' . $currency->term_id . '|' . $currency->name . '"' . $selected . '>' . $currency->name . '</option>';
        }
        //Listing Categories
        $cats = dwt_listing_categories_fetch('l_category', 0);
        $cats_html = '';
        foreach ($cats as $cat) {
            $selected = '';
            if ($category_level > 0 && $cat->term_id == $get_object_terms[0]['id']) {
                $selected = 'selected="selected"';
            }
            $cats_html .= '<option value="' . $cat->term_id . '" ' . $selected . '>' . $cat->name . '</option>';
        }

        $loc_lvl_1 = esc_html__('Select Your Country', 'dwt-listing-framework');
        $loc_lvl_2 = esc_html__('Select Your State', 'dwt-listing-framework');
        $loc_lvl_3 = esc_html__('Select Your City', 'dwt-listing-framework');
        $loc_lvl_4 = esc_html__('Select Your Town', 'dwt-listing-framework');
        if (dwt_listing_text('sb_location_titles') != "") {
            $titles_array = explode("|", dwt_listing_text('sb_location_titles'));
            if (count((array) $titles_array) > 0) {
                if (isset($titles_array[0]))
                    $loc_lvl_1 = $titles_array[0];
                if (isset($titles_array[1]))
                    $loc_lvl_2 = $titles_array[1];
                if (isset($titles_array[2]))
                    $loc_lvl_3 = $titles_array[2];
                if (isset($titles_array[3]))
                    $loc_lvl_4 = $titles_array[3];
            }
        }

        $get_object_terms_country = dwt_listing_selected_locationz($listing_id);
        $country_level = count($get_object_terms_country);


        //Get countries
        $ad_countries = dwt_listing_categories_fetch('l_location', 0);
        $country_html = '';
        foreach ($ad_countries as $ad_country) {
            $selected = '';
            if ($country_level > 0 && $ad_country->term_id == $get_object_terms_country[0]['id']) {
                $selected = 'selected="selected"';
            }
            $country_html .= '<option value="' . $ad_country->term_id . '" ' . $selected . '>' . $ad_country->name . '</option>';
        }

        if ($country_level >= 2) {
            $states = dwt_listing_categories_fetch('l_location', $get_object_terms_country[0]['id']);
            $state_html = '';
            foreach ($states as $state) {
                $selected = '';
                if ($country_level > 0 && $state->term_id == $get_object_terms_country[1]['id']) {
                    $class_two = 'nones';
                    $selected = 'selected="selected"';
                }
                $state_html .= '<option value="' . $state->term_id . '" ' . $selected . '>' . $state->name . '</option>';
            }
        }

        if ($country_level >= 3) {
            $ad_country_cities = dwt_listing_categories_fetch('l_location', $get_object_terms_country[1]['id']);
            $cities_html = '';
            foreach ($ad_country_cities as $ad_city) {
                $selected = '';
                if ($country_level > 0 && $ad_city->term_id == $get_object_terms_country[2]['id']) {
                    $class_three = 'nones';
                    $selected = 'selected="selected"';
                }
                $cities_html .= '<option value="' . $ad_city->term_id . '" ' . $selected . '>' . $ad_city->name . '</option>';
            }
        }
        if ($country_level >= 4) {
            $towns = dwt_listing_categories_fetch('l_location', $get_object_terms_country[2]['id']);
            $towns_html = '';

            foreach ($towns as $town) {
                $selected = '';
                if ($country_level > 0 && ($town->term_id) == ($get_object_terms_country[3]['id'])) {
                    $class_four = 'nones';
                    $selected = 'selected="selected"';
                }
                $towns_html .= '<option value="' . $town->term_id . '" ' . $selected . '>' . $town->name . '</option>';
            }
        }

        $days = array();
        if (!empty(dwt_listing_fetch_business_hours($listing_id))) {
            $days = dwt_listing_fetch_business_hours($listing_id);
        } else {
            $dayss = dwt_listing_week_days();
            foreach ($dayss as $key => $val) {
                $days[] = array("day_name" => $val, "start_time" => '', "end_time" => '', "closed" => '', "break_from" => '', "break_to" => '', "break" => '');
            }
        }

        $tabz = '';
        $tabz_value = '';
        foreach ($days as $key => $day) {
            if ($key == 0) {
                $mark = 'active';
                $in = 'in active';
            } else {
                $mark = '';
                $in = '';
            }
            $selected = '';
            if ($day['closed'] == 1) {
                $selected = 'checked="checked"';
            }

            $tabz .= '<li class="' . $mark . '"><a href="#tab1' . $key . '" data-toggle="tab">' . $day['day_name'] . '</a></li>';
            $tabz_value .= '<div class="tab-pane fade ' . $in . '" id="tab1' . $key . '">
		
		<div class="row">
			<div class="col-md-5 col-xs-12 col-sm-6">
					<div class="form-group">
						<label class="control-label"> ' . esc_html__('From', 'dwt-listing-framework') . ' </label>
						<div class="input-group">
							<span class="input-group-addon"><i class="ti-time"></i></span>
							<input type="text" class="for_specific_page form-control timepicker" name="from[]" id="from-' . $key . '" placeholder="' . esc_html__('Select your business hours', 'dwt-listing-framework') . '" value="' . trim(date("g:i A", strtotime($day['start_time']))) . '">
						</div>
					</div>
				</div>
				<div class="col-md-5 col-xs-12 col-sm-6">
					<div class="form-group">
						<label class="control-label">' . esc_html__('To', 'dwt-listing-framework') . '</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="ti-time"></i></span>
							<input type="text" class="form-control timepicker" id="to-' . $key . '" name="to[]" placeholder="' . esc_html__('Select your business hours', 'dwt-listing-framework') . '" value="' . trim(date("g:i A", strtotime($day['end_time']))) . '">
						</div>
					</div>
				</div>
				
				<div class="col-md-2 col-xs-12 col-sm-2">
					<div class="form-group">
						<label class="control-label">' . esc_html__('Closed', 'dwt-listing-framework') . '</label>
						<input name="is_closed[]" id="is_closed-' . $key . '" value="' . $key . '"  type="checkbox" ' . $selected . ' class="custom-checkbox is_closed"></span>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
			<div class="col-md-5 col-xs-12 col-sm-6">
					<div class="form-group">
						<label class="control-label"> ' . esc_html__('Break From', 'dwt-listing-framework') . ' </label>
						<div class="input-group">
                        <span class="input-group-addon"><i class="ti-time"></i></span>
                        <input type="text" class="for_specific_page form-control timepicker" id="to-' . $key . '" name="breakto[]" placeholder="' . esc_html__('Select your business hours', 'dwt-listing-framework') . '" value="' . trim(date("g:i A", strtotime(isset($day['break_too'])))) . '">
                        </div>
					</div>
				</div>
				<div class="col-md-5 col-xs-12 col-sm-6">
					<div class="form-group">
						<label class="control-label">' . esc_html__('Break To', 'dwt-listing-framework') . '</label>
						<div class="input-group">
                            <span class="input-group-addon"><i class="ti-time"></i></span>
                        <input type="text" class="for_specific_page form-control timepicker" name="breakfrom[]" id="from-' . $key . '" placeholder="' . esc_html__('Select your business hours', 'dwt-listing-framework') . '" value="' . trim(date("g:i A", strtotime(isset($day['break_from'])))) . '">
                        </div>
					</div>
				</div>
				<div class="col-md-2 col-xs-12 col-sm-2">
					<div class="form-group">
						<label class="control-label">' . esc_html__('Break', 'dwt-listing-framework') . '</label>
						<input name="is_break[]" id="is_break-' . $key . '" value="' . $key . '"  type="checkbox" ' . $selected . ' class="custom-checkbox is_break"></span>
					</div>
				</div>
			</div>
	</div>';
        }

//for listing images
        $custom_meta_fields = array(
            array(
                'label' => 'Gallery Images',
                'desc' => 'This is the gallery images on the single item page.',
                'id' => 'gallery',
                'type' => 'gallery'
            ),
        );
        $meta = $meta_html = '';
        if (get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true) != "") {
            $meta = get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true);
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            if (count((array) $media) > 0) {
                $meta_html .= '<ul class="dwt_listing_gallery">';
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $thumb_imgs = wp_get_attachment_image_src($mid, 'dwt_listing_recent-posts');
                    $thumb_imgs_ = isset($thumb_imgs[0]) ? $thumb_imgs[0] : '';
                    $meta_html .= '<li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon">
				 <img id="' . esc_attr($mid) . '" src="' . esc_url($thumb_imgs_) . '" alt="' . esc_html__('image not found', 'dwt-listing') . '" /></span></div></li>';
                }
                $meta_html .= '</ul>';
            }
        }

        $brand_meta_html = $brand_logo_id = '';
        $image_link = array();
        if (get_post_meta($listing_id, 'dwt_listing_brand_img', true) != "") {
            $brand_logo_id = get_post_meta($listing_id, 'dwt_listing_brand_img', true);
            $image_link = wp_get_attachment_image_src($brand_logo_id, 'dwt_listing_recent-posts');
            $image_link = is_array($image_link) ? $image_link[0] : '';
            $brand_meta_html .= '<ul class="dwt_listing_gallery"><li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon_brand"><img id="' . esc_attr($brand_logo_id) . '" src="' . esc_url($image_link) . '" alt="' . esc_html__('image not found', 'dwt-listing') . '" /></span> </li<</div></ul>';
        }
        ?>
        <div id="dwt_listing_loading" class="loading"></div>
        <table class="form-table ">
            <tr>
                <th><label class="claimed_by_label"><?php echo dwt_listing_text('dwt_listing_list_gallery'); ?></label></th>
                <td>
                    <input id="dwt_listing_gall_idz" type="hidden" name="dwt_listing_gall_idz" value="<?php echo esc_attr($meta); ?>" />
                    <span id="dwt_listing_gall_render"><?php echo $meta_html; ?></span>
                    <input id="dwt_listing_gallery_button" class="button button-primary button-large" type="button" value="<?php echo esc_attr__('Listing Gallery Images', 'dwt-listing-framework'); ?>" />
                </td>
            </tr>
            <tr>
                <th><label class="claimed_by_label"><?php echo dwt_listing_text('dwt_listing_list_category'); ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Business Category', 'dwt-listing-framework'); ?>" id="d_cats"  name="d_cats" class="claim_status_field admin-select">
                        <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $cats_html; ?>
                    </select>
                </td>
            </tr>
            <tr id="cat_features" class="<?php echo $class; ?>">
                <th><label class="claimed_by_label"><?php echo esc_html__('Amenties', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <div class="category-based-features"> <?php echo $cats_features; ?></div>
                </td>
            </tr>

            <tr id="additional_fields" class="<?php echo $class_custom_fields; ?>">
                <th><label><?php echo esc_html__('Additional Fields', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <div class="additional_custom_fields"><div class="category-based-features"> <?php dwt_listing_fetch_cat_form_fields($category_id, '1', $listing_id); ?></div></div>
                </td>
            </tr>

            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_b_title'); ?></label></th>
                <td>
                    <input type="text" id="listing_brandname" name="listing_brandname" placeholder="<?php echo dwt_listing_text('dwt_listing_b_placetitle'); ?>" value="<?php echo $listing_brandname; ?>">
                </td>
            </tr>

            <tr>
                <th><label class="claimed_by_label"><?php echo dwt_listing_text('dwt_listing_brand_name_logo'); ?></label></th>
                <td>
                    <input id="dwt_listing_b_logo_id" type="hidden" name="dwt_listing_b_logo_id" value="<?php echo esc_attr($brand_logo_id); ?>" />
                    <span id="dwt_listing_gall_render_html"><?php echo $brand_meta_html; ?></span>
                    <input id="dwt_listing_brand_btn" class="button button-primary button-large" type="button" value="<?php echo esc_attr__('Select Brand Logo', 'dwt-listing-framework'); ?>" />
                </td>
            </tr>

            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_contact'); ?></label></th>
                <td>
                    <input type="text" id="listing_contact" name="listing_contact" placeholder="<?php echo dwt_listing_text('dwt_listing_list_contact_place'); ?>" value="<?php echo $listing_contact; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_web'); ?></label></th>
                <td>
                    <input type="text" id="website-url" name="website-url" placeholder="<?php echo dwt_listing_text('dwt_listing_list_web_place'); ?>" value="<?php echo $listing_web_url; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_video'); ?></label></th>
                <td>
                    <input type="text" id="listing_videolink" name="listing_videolink" placeholder="<?php echo dwt_listing_text('dwt_listing_list_video_place'); ?>" value="<?php echo $listing_video; ?>">
                    <p class="description"><?php echo dwt_listing_text('dwt_listing_list_video_place'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_contact_email'); ?></label></th>
                <td>
                    <input type="text" id="listing_contact_email" name="listing_contact_email" placeholder="<?php echo dwt_listing_text('dwt_listing_contact_email_placeholder'); ?>" value="<?php echo sanitize_email($listing_contact_email); ?>">
                    <p class="description"><?php echo dwt_listing_text('dwt_listing_contact_email_tooltip'); ?></p>
                </td>
            </tr>
            <tr class="get-loc">
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_google_loc'); ?></label></th>
                <td>
                    <input type="text" id="address_location" name="listing_streetAddress" placeholder="<?php echo dwt_listing_text('dwt_listing_list_google_loc_place'); ?>" value="<?php echo $listing_street; ?>">
                    <i class="detect-me fa fa-crosshairs"></i>
                    <p class="description"><?php echo dwt_listing_text('dwt_listing_list_google_loc_tool'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Map', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <div id="submit-map-open"></div>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_lati'); ?></label></th>
                <td>
                    <input type="text" id="d_latt" name="listing_lat" placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>" value="<?php echo $listing_lattitude; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_longi'); ?></label></th>
                <td>
                    <input type="text" id="d_long" name="listing_long" placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>" value="<?php echo $listing_longitide; ?>">
                </td>
            </tr>
            <tr>
                <th><label class="claimed_by_label"><?php echo dwt_listing_text('dwt_listing_list_pricetype'); ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Price Type', 'dwt-listing-framework'); ?>"  name="listing_price_type" class="claim_status_field admin-select">
                        <option value=""> <?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $price_type_html; ?>
                    </select>
                    <p class="description"><?php echo __('It will show your business price range', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimed_by_label"><?php echo dwt_listing_text('dwt_listing_list_currenct'); ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Currency Type', 'dwt-listing-framework'); ?>"  name="listing_currency_type" class="claim_status_field admin-select">
                        <option value=""> <?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $listing_currency_html; ?>
                    </select>
                    <p class="description"><?php echo __('Select your business currency type', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_price_from'); ?></label></th>
                <td>
                    <input type="text" id="listing_pricefrom" name="listing_pricefrom" placeholder="" value="<?php echo $listing_price_from; ?>">
                    <p class="description"><?php echo __('Ignore this if your buisness does not have any specific price to show', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_list_price_to'); ?></label></th>
                <td>
                    <input type="text" id="listing_priceto" name="listing_priceto" placeholder="" value="<?php echo $listing_price_to; ?>">
                    <p class="description"><?php echo __('Ignore this if your buisness does not have any specific price to show', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Facebook', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_fb" name="listing_fb" placeholder="" value="<?php echo $listing_fb; ?>">
                    <p class="description"><?php echo __('Your facebook URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Twitter', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_tw" name="listing_tw" placeholder="" value="<?php echo $listing_tw; ?>">
                    <p class="description"><?php echo __('Your Twitter URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Tiktok', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_google" name="listing_google" placeholder="" value="<?php echo $listing_google; ?>">
                    <p class="description"><?php echo __('Your Tiktok URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Linked IN', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_in" name="listing_in" placeholder="" value="<?php echo $listing_in; ?>">
                    <p class="description"><?php echo __('Your Linked IN URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Youtube URL', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_youtube" name="listing_youtube" placeholder="" value="<?php echo $listing_youtube; ?>">
                    <p class="description"><?php echo __('Your Youtube URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Instagram URL', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_insta" name="listing_insta" placeholder="" value="<?php echo $listing_insta; ?>">
                    <p class="description"><?php echo __('Your Instagram URL', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('WhatsApp Number', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <input type="text" id="listing_whatsapp" name="listing_whatsapp" placeholder="" value="<?php echo $listing_whatsapp; ?>">
                    <p class="description"><?php echo __('Your WhatsApp Number', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo __('Business Hours', 'dwt-listing-framework'); ?></label></th>
                <td>

                    <ul class="admin-ul for_one">
                        <li>
                            <input id="na" class="custom-checkbox"  name="type_hours"  value="0" <?php echo checked(0, $selected_val, true); ?> type="radio">
                            <label for="na"> <?php echo __('N/A', 'dwt-listing-framework'); ?></label>
                        </li>
                        <li>
                            <input id="open" class="custom-checkbox"  name="type_hours" value="1" <?php echo checked(1, $selected_val, true); ?> type="radio">
                            <label for="open"><?php echo __('Open 24/7', 'dwt-listing-framework'); ?></label>
                        </li>
                        <li>
                            <input id="selective" class="custom-checkbox"  name="type_hours" value="2" <?php echo checked(2, $selected_val, true); ?> type="radio">
                            <label for="selective"> <?php echo __('Selective Hours', 'dwt-listing-framework'); ?></label>
                        </li>

                        <input type="hidden" id="hours_type" name="hours_type" value="<?php echo $selected_val; ?>">
                    </ul>
                    <p class="description"><?php echo __('Want to show business hours? ignore this if you dont want to show', 'dwt-listing-framework'); ?>'</p>
                </td>
            </tr>

            <tr id="for_timezones" class="<?php echo $class_five; ?> my-zones">
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_b_h_time'); ?></label></th>
                <td>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input id="timezones" autocomplete="off" value="<?php echo $listing_timezone; ?>" type="search" class="form-control timezone_typeahead"  name="listing_timezome">
                            </div></div></div>
                    <p class="description"><?php echo __('Select your timezone', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr id="for_timezones_selective" class="<?php echo $class_six; ?>">
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_b_h_time'); ?></label></th>
                <td>
                    <div class="panel with-nav-tabs panel-info">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <?php echo $tabz; ?>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <?php echo $tabz_value; ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_coupon_title'); ?></label></th>
                <td>
                    <input type="text" id="listing_coupon_title" name="listing_coupon_title" placeholder="<?php echo esc_html__('Save 20%', 'dwt-listing-framework'); ?>" value="<?php echo $listing_coupon; ?>">
                    <p class="description"><?php echo esc_html__('Ignore this if your buisness does have any coupon', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_coupon_code'); ?></label></th>
                <td>
                    <input type="text" id="listing_coupon_code" name="listing_coupon_code" placeholder="<?php echo esc_html__('#12356-12', 'dwt-listing-framework'); ?>" value="<?php echo $listing_coupon_code; ?>">
                    <p class="description"><?php echo esc_html__('Ignore this if your buisness does have any coupon', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_coupon_referral'); ?></label></th>
                <td>
                    <input type="text" id="listing_coupon_referral" name="listing_coupon_referral"  value="<?php echo $listing_coupon_referral; ?>">
                    <p class="description"><?php echo esc_html__('Website Referal link related to coupon', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label class="claimer_contact_label"><?php echo dwt_listing_text('dwt_listing_coupon_expiry_date'); ?></label></th>
                <td>
                    <input type="text" id="event_end" name="listing_coupon_exp"  value="<?php echo $listing_coupon_exp; ?>">
                </td>
            </tr>

            <tr>
                <th><label for="claim_detials" class="claim_detials_label"><?php echo dwt_listing_text('dwt_listing_coupon_desc'); ?></label></th>
                <td>
                    <textarea name="dwt_listing_coupon_desc" id="dwt_listing_coupon_desc" rows="10"><?php echo $listing_coupon_desc; ?></textarea>
                </td>
            </tr>

            <tr>
                <th><label class="claimed_by_label"><?php echo $loc_lvl_1; ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Your Country', 'dwt-listing-framework'); ?>" id="d_country"  name="d_country" class="claim_status_field admin-select">
                        <option value=""> <?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $country_html; ?>
                    </select>
                    <p class="description"><?php echo __('Ignore this if dont want to show.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>

            <tr id="states" class="<?php echo $class_two; ?>">
                <th><label class="claimed_by_label"><?php echo $loc_lvl_2; ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Your State', 'dwt-listing-framework'); ?>" id="d_state"  name="d_state" class="claim_status_field admin-select">
                        <option value=""><?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $state_html; ?>
                    </select>
                    <p class="description"><?php echo __('Ignore this if dont want to show.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>

            <tr id="city" class="<?php echo $class_three; ?>">
                <th><label class="claimed_by_label"><?php echo $loc_lvl_3; ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Your City', 'dwt-listing-framework'); ?>" id="d_city"  name="d_city" class="claim_status_field admin-select">
                        <option value=""> <?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $cities_html; ?>
                    </select>
                    <p class="description"><?php echo __('Ignore this if dont want to show.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>

            <tr id="town" class="<?php echo $class_four; ?>">
                <th><label class="claimed_by_label"><?php echo $loc_lvl_4; ?></label></th>
                <td>
                    <select data-placeholder="<?php echo esc_html__('Select Your Town', 'dwt-listing-framework'); ?>" id="d_town"  name="d_town" class="claim_status_field admin-select">
                        <option value=""> <?php echo esc_html__('Select an option', 'dwt-listing-framework'); ?></option>
                        <?php echo $towns_html; ?>
                    </select>
                    <p class="description"><?php echo __('Ignore this if dont want to show.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="timekit_boking_label" class="claim_detials_label"><?php echo __('Booking With Timekit', 'dwt-listing-framework'); ?></label></th>
                <td>
                    <textarea  name="dwt-listing-timekit-booking" id="dwt-listing-timekit-booking"  rows="10" placeholder="<?php esc_html_e('Timekit Widget Goes Here only code with <script></script>', 'dwt-listing'); ?>"><?php echo $timekit_booking_widget_code; ?></textarea>
                    <p class="description"><?php echo __('Booking widget will only shows when enable from admin panel.', 'dwt-listing-framework'); ?></p>
                </td>
            </tr>
            <input type="hidden" id="admin_ip_type" value="<?php echo $ip_type; ?>">
        </table>
        <?php
    }

    public function save_metabox($post_id, $post) {

        global $wpdb;
        // Add nonce for security and authentication.
        $nonce_name = ( isset($_POST['listing_nonce']) ) ? $_POST['listing_nonce'] : ' ';
        $nonce_action = 'listing_nonce_action';
        $listing_id = $post_id;

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_posts', $listing_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($listing_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($listing_id))
            return;
        // Sanitize user input.
        $listing_contact = isset($_POST['listing_contact']) ? sanitize_text_field($_POST['listing_contact']) : '';
        $listing_web_url = isset($_POST['website-url']) ? sanitize_text_field($_POST['website-url']) : '';
        $listing_price_type = isset($_POST['listing_price_type']) ? sanitize_text_field($_POST['listing_price_type']) : '';
        $listing_currency_type = isset($_POST['listing_currency_type']) ? sanitize_text_field($_POST['listing_currency_type']) : '';
        $listing_price_from = isset($_POST['listing_pricefrom']) ? sanitize_text_field($_POST['listing_pricefrom']) : '';
        $listing_price_to = isset($_POST['listing_priceto']) ? sanitize_text_field($_POST['listing_priceto']) : '';
        $listing_video = isset($_POST['listing_videolink']) ? sanitize_text_field($_POST['listing_videolink']) : '';
        $listing_contact_email = isset($_POST['listing_contact_email']) ? sanitize_email($_POST['listing_contact_email']) : '';
        $listing_street = isset($_POST['listing_streetAddress']) ? sanitize_text_field($_POST['listing_streetAddress']) : '';
        $listing_lattitude = isset($_POST['listing_lat']) ? sanitize_text_field($_POST['listing_lat']) : '';
        $listing_longitide = isset($_POST['listing_long']) ? sanitize_text_field($_POST['listing_long']) : '';
        $listing_fb = isset($_POST['listing_fb']) ? sanitize_text_field($_POST['listing_fb']) : '';
        $listing_tw = isset($_POST['listing_tw']) ? sanitize_text_field($_POST['listing_tw']) : '';
        $listing_google = isset($_POST['listing_google']) ? sanitize_text_field($_POST['listing_google']) : '';
        $listing_in = isset($_POST['listing_in']) ? sanitize_text_field($_POST['listing_in']) : '';
        $listing_youtube = isset($_POST['listing_youtube']) ? sanitize_text_field($_POST['listing_youtube']) : '';
        $listing_insta = isset($_POST['listing_insta']) ? sanitize_text_field($_POST['listing_insta']) : '';
        $listing_whatsapp = isset($_POST['listing_whatsapp']) ? sanitize_text_field($_POST['listing_whatsapp']) : '';
        $listing_coupon = isset($_POST['listing_coupon_title']) ? sanitize_text_field($_POST['listing_coupon_title']) : '';
        $listing_coupon_code = isset($_POST['listing_coupon_code']) ? sanitize_text_field($_POST['listing_coupon_code']) : '';
        $listing_coupon_referral = isset($_POST['listing_coupon_referral']) ? sanitize_text_field($_POST['listing_coupon_referral']) : '';
        $listing_coupon_exp = isset($_POST['listing_coupon_exp']) ? sanitize_text_field($_POST['listing_coupon_exp']) : '';
        $listing_coupon_desc = isset($_POST['dwt_listing_coupon_desc']) ? sanitize_text_field($_POST['dwt_listing_coupon_desc']) : '';

        $timekit_booking_widget_code = isset($_POST['dwt-listing-timekit-booking']) ? ($_POST['dwt-listing-timekit-booking']) : '';
        $listing_is_open = isset($_POST['hours_type']) ? sanitize_text_field($_POST['hours_type']) : '';
        $listing_timezone = isset($_POST['listing_timezome']) ? sanitize_text_field($_POST['listing_timezome']) : '';
        $is_closed = isset($_POST['is_closed']) ? ( $_POST['is_closed'] ) : [];
        $start_from = isset($_POST['to']) ? ( $_POST['to'] ) : '';
        $end_from = isset($_POST['from']) ? ( $_POST['from'] ) : '';
        $break_click = isset($_POST['is_break']) ? ( $_POST['is_break'] ) : [];
        $break_from = isset($_POST['breakto']) ? ( $_POST['breakto'] ) : '';
        $break_to = isset($_POST['breakfrom']) ? ( $_POST['breakfrom'] ) : '';
        $listing_brandname = isset($_POST['listing_brandname']) ? sanitize_text_field($_POST['listing_brandname']) : '';

        // Update the meta field in the database.
        update_post_meta($listing_id, 'dwt_listing_listing_status', '1');
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
        update_post_meta($listing_id, 'dwt_listing_listing_video', $listing_video);
        update_post_meta($listing_id, 'dwt_listing_related_email', $listing_contact_email);
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

        if (!empty($timekit_booking_widget_code)) {
            update_post_meta($listing_id, 'dwt-listing-timekit-booking', htmlspecialchars($timekit_booking_widget_code));
            $booking_status = '1';
            update_post_meta($listing_id, 'dwt-listing-timekit-booking-status', $booking_status);
        } else {
            update_post_meta($listing_id, 'dwt-listing-timekit-booking-status', '0');
        }

        update_post_meta($listing_id, 'dwt_listing_brand_name', $listing_brandname);

        if ($listing_coupon_exp != '' && $listing_coupon_exp != '') {
            update_post_meta($listing_id, 'dwt_listing_coupon_expiry', $listing_coupon_exp);
        }

        if ($listing_is_open == 1) {
            update_post_meta($listing_id, 'dwt_listing_is_hours_allow', '1');
            update_post_meta($listing_id, 'dwt_listing_business_hours', $listing_is_open);
        } else if ($listing_is_open == 2) {
            /* business hours */
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            for ($a = 0; $a <= 6; $a++) {
                $to = '';
                $from = '';
                $days = '';
                /* get days */
                $days = lcfirst($custom_days[$a]);
                if (!in_array($a, $is_closed)) {
                    $from = date("H:i:s", strtotime(str_replace(" : ", ":", $end_from[$a])));
                    $to = date("H:i:s", strtotime(str_replace(" : ", ":", $start_from[$a])));
                    /* day status open or not */
                    update_post_meta($listing_id, '_timingz_' . $days . '_open', '1');
                    /* day hours from */
                    update_post_meta($listing_id, '_timingz_' . $days . '_from', $from);
                    update_post_meta($listing_id, '_timingz_' . $days . '_to', $to);

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
            // add this code on 26-aug-2020(because n/a not show if user choose N/A)
            update_post_meta($listing_id, 'dwt_listing_business_hours', '');
        }

        /* categories */
        $category = array();
        $category_main = array();
        $category_sub = array();
        if ($_POST['d_cats'] != "") {
            $category_main[] = $_POST['d_cats'];
        }
        if (isset($_POST['cat_features']) && $_POST['cat_features'] != "") {
            $category_sub = $_POST['cat_features'];
        }
        //check if parent has any child
        $if_cats = dwt_listing_categories_fetch('l_category', $_POST['d_cats']);
        if (count((array) $if_cats) > 0) {
            $category = array_merge($category_main, $category_sub);
        } else {
            $category[] = $_POST['d_cats'];
        }
        wp_set_post_terms($listing_id, $category, 'l_category');
        /* countries */
        $countries = array();
        if ($_POST['d_country'] != "") {
            $countries[] = $_POST['d_country'];
        }
        if ($_POST['d_state'] != "") {
            $countries[] = $_POST['d_state'];
        }
        if ($_POST['d_city'] != "") {
            $countries[] = $_POST['d_city'];
        }
        if ($_POST['d_town'] != "") {
            $countries[] = $_POST['d_town'];
        }
        //set location
        wp_set_post_terms($listing_id, $countries, 'l_location');

        //images
        $images_idz = $_POST['dwt_listing_gall_idz'];
        if (!empty($images_idz) && count((array) $images_idz) > 0) {
            update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $images_idz);
        } else {
            update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $images_idz);
        }
        //brand image
        $b_logo_id = $_POST['dwt_listing_b_logo_id'];
        if (!empty($b_logo_id)) {
            update_post_meta($listing_id, 'dwt_listing_brand_img', $b_logo_id);
        } else {
            update_post_meta($listing_id, 'dwt_listing_brand_img', '');
        }

        //Custom Fields
        $get_custom_fields = $wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '" . $listing_id . "' AND meta_key LIKE 'field_multi_%'");
        foreach ($_POST as $key => $value) {
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
    }

}

new listing_meta_boxes;

class listing_meta_boxes_for_featured {

    public function __construct() {

        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox1'));
            add_action('load-post-new.php', array($this, 'init_metabox1'));
        }
    }

    public function init_metabox1() {

        add_action('add_meta_boxes', array($this, 'add_metabox_featured'));
        add_action('save_post', array($this, 'save_metabox_featured'), 10, 2);
    }

    public function add_metabox_featured() {

        add_meta_box(
            'listing_mark_featured', __('Mark Listing As Featured', 'dwt-listing-framework'), array($this, 'render_metabox_featured'), 'listing', 'side', 'high'
        );
    }

    public function render_metabox_featured($post) {
        // Add nonce for security and authentication.
        wp_nonce_field('listing_nonce_action1', 'listing_nonce1');
        $listing_id = $post->ID;
        $class_featured = 'none';
        $expiry_date = $author_id = '';
        $checkedz = 0;
        if (get_post_meta($listing_id, 'dwt_listing_is_feature', true) != "" && get_post_meta($listing_id, 'dwt_listing_is_feature', true) == 1) {
            $checkedz = 1;
            $class_featured = '';
        } else {
            $checkedz = 0;
        }
        $author_id = dwt_listing_listing_owner($listing_id, 'id');
        $expiry_date = get_user_meta($author_id, 'dwt_listing_featured_for', true);
        // Form fields.
        echo '<table class="form-table"><tr>
				<td>
				<p class="description">' . __('Do you want to make this listing as featured!', 'dwt-listing-framework') . '</p>
				<ul class="admin-ul for-featured">
					<li>
						<input id="not" class="custom-checkbox"  name="make_listing_featured"  value="0"  ' . checked(0, $checkedz, false) . '  type="radio">
						<label for="not"> ' . __('No', 'dwt-listing-framework') . '</label>
					</li>
					<li>
						<input id="open" class="custom-checkbox"  name="make_listing_featured" value="1" ' . checked(1, $checkedz, false) . '  type="radio">
						<label for="open"> ' . __('Yes', 'dwt-listing-framework') . '</label>
					</li>
				</ul>
					<div id="featured-for" class="' . $class_featured . '">
						<label class="claimer_contact_label">' . __('Featured For', 'dwt-listing-framework') . '</label><br><br>
						<input type="text" id="featured_for_days" value="' . $expiry_date . '" name="featured_for_days">
						<p class="description">' . __('Expiry in days, -1 means never expired.', 'dwt-listing-framework') . '</p>
						<strong><p class="description">' . __('Changes in days will impact on user package featured expiry days.', 'dwt-listing-framework') . '</p></strong>
					</div>
				</td>
			</tr>
		</table>';
    }

    public function save_metabox_featured($post_id, $post) {
        // Add nonce for security and authentication.
        $nonce_name = ( isset($_POST['listing_nonce1']) ) ? $_POST['listing_nonce1'] : ' ';
        $nonce_action = 'listing_nonce_action1';
        $listing_id = $post_id;

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_posts', $listing_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($listing_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($listing_id))
            return;
        // Sanitize user input.
        $author_id = dwt_listing_listing_owner($listing_id, 'id');
        $is_featurez = isset($_POST['make_listing_featured']) ? sanitize_text_field($_POST['make_listing_featured']) : '';
        $is_featurez_days = isset($_POST['featured_for_days']) ? sanitize_text_field($_POST['featured_for_days']) : '';
        if (!empty($is_featurez) && $is_featurez == 1 && $is_featurez_days != "") {
            update_post_meta($listing_id, 'dwt_listing_is_feature', '1');
            update_post_meta($listing_id, 'dwt_listing_feature_ad_expiry_days', date('Y-m-d'));
        } else {
            update_post_meta($listing_id, 'dwt_listing_is_feature', '0');
        }
        //update user meta
        if ($is_featurez_days == '-1') {
            update_user_meta($author_id, 'dwt_listing_featured_for', '-1');
        } else {
            update_user_meta($author_id, 'dwt_listing_featured_for', $is_featurez_days);
        }
    }

}

new listing_meta_boxes_for_featured;
// Add the Meta Box
//Assign listing

add_action('add_meta_boxes', 'dwt_listing_assign_listing');

function dwt_listing_assign_listing() {
    add_meta_box('dwt_listing_assign_listing_to', __('Assign Listing to Authors', 'dwt-listing-framework'), 'dwt_listing_render_html', 'listing', 'side', 'high');
}

function dwt_listing_render_html($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    $users = get_users(array('fields' => array('display_name', 'ID')));
    ?>
    <table class="form-table">
        <td>
            <select id="listing_author"  name="listing_author_name" class="admin-select-full">
                <option value=""> <?php echo esc_html__('Select author', 'dwt-listing-framework'); ?></option>
                <?php
                if (!empty($users) && count((array) $users) > 0) {
                    foreach ($users as $user) {
                        ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php if ($post->post_author == $user->ID) echo 'selected'; ?>>
                            <?php echo esc_html($user->display_name); ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
            <p class="description"><?php echo __('Assign listing to any other author', 'dwt-listing-framework'); ?></p>
        </td>
    </table>
    <?php
}

// Saving Metabox data
add_action('save_post', 'dwt_listing_save_for_listing');

function dwt_listing_save_for_listing($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

// if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_ad'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;

    // Make sure your data is set before trying to save it
    if (isset($_POST['listing_author_name'])) {
        $my_post = array(
            'ID' => $post_id,
            'post_author' => $_POST['listing_author_name'],
        );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'dwt_listing_save_for_listing');

        // update the post, which calls save_post again
        wp_update_post($my_post);

        // re-hook this function
        add_action('save_post', 'dwt_listing_save_for_listing');
    }
}