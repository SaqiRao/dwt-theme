<?php

global $dwt_listing_options;
if (dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "" && dwt_listing_text('dwt_listing_enable_map') == "1") {
    dwt_listing_google_locations(true);
    wp_enqueue_script("google-map-callback");
}
dwt_listing_submission_disbaled();
$listing_contact_email = $listing_brandname = $listing_insta =$listing_whatsapp = $listing_youtube = '';
$listing_coupon = $listing_coupon_code = $listing_coupon_referral = $listing_coupon_desc = '';
$listing_coupon_from = $listing_coupon_exp = $video_listing = '';
$web_link = '';
$no_of_images = '';
$price_range = "";
$business_hours = '';
$allow_tags = '';
$latitude = '';
$longitude = '';
$cats = '';
$countries = '';
$price_type = '';
$listing_id = '';
$listing_desc = '';
$listing_title = '';
$listing_tagline = '';
$listing_contact = '';
$listing_web_url = '';
$listing_price_from = '';
$listing_price_to = '';
$listing_video = '';
$listing_tags = '';
$tags_array = '';
$listing_street = '';
$listing_lattitude = '';
$listing_longitide = '';
$listing_price_type = '';
$get_object_terms = '';
$category_level = '';
$cats_features = '';
$get_object_terms_country = '';
$country_level = '';
$state_html = '';
$states = '';
$selected = '';
$cities = '';
$towns = '';
$cities_html = '';
$towns_html = '';
$is_update = '';
$listing_fb = '';
$listing_tw = '';
$listing_google = '';
$listing_in = '';
$listing_categories = '';
$number_of_images = '';
$expiry_date = '';
$listing_is_feature = 0;
$listing_is_bump = 0;
$featured_listing = '';
$listing_bump_amount = '';
$listing_currency = '';
$listing_currency_type = '';
$time_from = $listing_timezone = $time_to = '';
$category_id = '';
$dynamic_custom_fields = '';
$coupon_code = '';
$class = 'none';
$class_two = 'none';
$class_three = 'none';
$class_four = 'none';
$my_class = $class_custom_fields = 'none';
$listing_is_opened = $is_closed = 0;
$selected_zone = '';
//check user package history
if (isset($_GET['listing_id']) && $_GET['listing_id'] != "") {
    $listing_id = $_GET['listing_id'];
}
dwt_listing_check_user_package_history($listing_id);

$listng = new dwt_listing_submit_listing();
$package_id = $listng->get_package_detials($listing_id);
//get form fields

$regular_listing = get_user_meta(get_current_user_id(), 'dwt_listing_regular_listing', true);
$featured_listing = get_user_meta(get_current_user_id(), 'dwt_listing_featured_listing', true);
$listing_bump_amount = get_user_meta(get_current_user_id(), 'dwt_listing_bump_listing', true);

if (get_post_meta($package_id, 'video_listing', true) != "") {
    $video_listing = get_post_meta($package_id, 'video_listing', true);
}
if (get_post_meta($package_id, 'website_link', true) != "") {
    $web_link = get_post_meta($package_id, 'website_link', true);
}
if (get_post_meta($package_id, 'no_of_images', true) != "") {
    $number_of_images = get_post_meta($package_id, 'no_of_images', true);
}
if (get_post_meta($package_id, 'price_range', true) != "") {
    $price_range = get_post_meta($package_id, 'price_range', true);
}
if (get_post_meta($package_id, 'business_hours', true) != "") {
    $business_hours = get_post_meta($package_id, 'business_hours', true);
}
if (get_post_meta($package_id, 'allow_tags', true) != "") {
    $allow_tags = get_post_meta($package_id, 'allow_tags', true);
}
if (get_post_meta($package_id, 'allow_coupon_code', true) != "") {
    $coupon_code = get_post_meta($package_id, 'allow_coupon_code', true);
}


//for defualt timezone
$listing_timezone = '';
$current_user_id = get_current_user_id();
if (get_user_meta($current_user_id, 'd_user_timezone', true) != "") {
    $listing_timezone = get_user_meta($current_user_id, 'd_user_timezone', true);
}
if (isset($_GET['listing_id']) && $_GET['listing_id'] != "") {
    $listing_id = $_GET['listing_id'];
    $post = get_post($listing_id);
    $listing_title = $post->post_title;
    $listing_desc = $post->post_content;
    $listing_contact = get_post_meta($listing_id, 'dwt_listing_listing_contact', true);
    $listing_web_url = get_post_meta($listing_id, 'dwt_listing_listing_weburl', true);
    $listing_price_type = get_post_meta($listing_id, 'dwt_listing_listing_priceType', true);
    $listing_currency_type = get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true);
    $listing_price_from = get_post_meta($listing_id, 'dwt_listing_listing_pricefrom', true);
    $listing_price_to = get_post_meta($listing_id, 'dwt_listing_listing_priceto', true);
    $listing_video = get_post_meta($listing_id, 'dwt_listing_listing_video', true);
    $tags_array = wp_get_object_terms($listing_id, 'l_tags', array('fields' => 'names'));
    $listing_tags = implode(',', $tags_array);
    $listing_contact_email = get_post_meta($listing_id, 'dwt_listing_related_email', true);
    //coupon code
    $listing_coupon = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
    $listing_coupon_code = get_post_meta($listing_id, 'dwt_listing_coupon_code', true);
    $listing_coupon_referral = get_post_meta($listing_id, 'dwt_listing_coupon_refer', true);
    $listing_coupon_exp = get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true);
    $listing_coupon_desc = get_post_meta($listing_id, 'dwt_listing_coupon_desc', true);
    $listing_street = get_post_meta($listing_id, 'dwt_listing_listing_street', true);
    $listing_lattitude = get_post_meta($listing_id, 'dwt_listing_listing_lat', true);
    $listing_longitide = get_post_meta($listing_id, 'dwt_listing_listing_long', true);
    $listing_fb = get_post_meta($listing_id, 'dwt_listing_listing_fb', true);
    $listing_tw = get_post_meta($listing_id, 'dwt_listing_listing_tw', true);
    $listing_google = get_post_meta($listing_id, 'dwt_listing_listing_google', true);
    $listing_in = get_post_meta($listing_id, 'dwt_listing_listing_in', true);
    $listing_youtube = get_post_meta($listing_id, 'dwt_listing_youtube', true);
    $listing_insta = get_post_meta($listing_id, 'dwt_listing_insta', true);
    $listing_whatsapp = get_post_meta($listing_id, 'dwt_listing_whatsapp', true);
    $listing_is_feature = get_post_meta($listing_id, 'dwt_listing_is_feature', true);
    $listing_is_opened = get_post_meta($listing_id, 'dwt_listing_business_hours', true);
    if ($listing_is_opened == 0) {
        $my_class = 'nones';
    }
    $listing_brandname = get_post_meta($listing_id, 'dwt_listing_brand_name', true);
    $listing_timezone = get_post_meta($listing_id, 'dwt_listing_user_timezone', true);
    $is_update = $listing_id;
    //Get categories levels
    $get_object_terms = dwt_listing_selected_catz($listing_id);
    $category_level = count($get_object_terms);

    $cats = dwt_listing_categories_fetch('l_category', 0);
    $cats_html = '';
    foreach ($cats as $cat) {
        $selected = '';
        if ($category_level > 0 && $cat->term_id == $get_object_terms[0]['id']) {
            $selected = 'selected="selected"';
        }
        $cats_html .= '<option value="' . $cat->term_id . '" ' . $selected . '>' . $cat->name . '</option>';
    }

    //get dynmaic custom form fields
    if (isset($get_object_terms[0]['id']) && $get_object_terms[0]['id'] != "") {
        $category_id = $get_object_terms[0]['id'];
        $class_custom_fields = '';
    }

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


    $price_type = dwt_listing_categories_fetch('l_price_type', 0);
    $price_type_html = '';
    foreach ($price_type as $price_types) {
        $selected = '';
        if ($listing_price_type == $price_types->name) {
            $selected = ' selected="selected"';
        }

        $price_type_html .= '<option value="' . $price_types->term_id . '|' . $price_types->name . '"' . $selected . '>' . $price_types->name . '</option>';
    }
    $listing_currency = dwt_listing_categories_fetch('l_currency', 0);
    $listing_currency_html = '';
    foreach ($listing_currency as $currency) {
        $selected = '';
        if ($listing_currency_type == $currency->name) {
            $selected = ' selected="selected"';
        }

        $listing_currency_html .= '<option value="' . $currency->term_id . '|' . $currency->name . '"' . $selected . '>' . $currency->name . '</option>';
    }

    if (!empty(dwt_listing_fetch_business_hours($listing_id))) {
        $days = dwt_listing_fetch_business_hours($listing_id);
    } else {
        $dayss = dwt_listing_week_days();
        foreach ($dayss as $key => $val) {
            $days[] = array("day_name" => $val, "start_time" => '', "end_time" => '', "closed" => '');
        }
    }
    
    //Get countries levels
    $get_object_terms_country = dwt_listing_selected_locationz($listing_id);
    $country_level = count($get_object_terms_country);

    //Get countries
    $ad_countries = dwt_listing_categories_fetch('l_location', 0);
    $country_html = '';
    $country_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
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
        $state_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
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
        $cities_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
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
        $towns_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
        foreach ($towns as $town) {
            $selected = '';
            if ($country_level > 0 && $town->term_id == $get_object_terms_country[3]['id']) {
                $class_four = 'nones';
                $selected = 'selected="selected"';
            }
            $towns_html .= '<option value="' . $town->term_id . '" ' . $selected . '>' . $town->name . '</option>';
        }
    }
} else {

    $listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
    $listing_longitide = dwt_listing_text('dwt_listing_default_long');
    //Get cats
    $cats = dwt_listing_categories_fetch('l_category', 0);
    $cats_html = '';
    foreach ($cats as $cat) {
        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
    }

    //Get price type
    $price_type = dwt_listing_categories_fetch('l_price_type', 0);
    $price_type_html = '';
    foreach ($price_type as $price_types) {
        $price_type_html .= '<option value="' . $price_types->term_id . '|' . $price_types->name . '">' . $price_types->name . '</option>';
    }

    //Get listing currency
    $listing_currency = dwt_listing_categories_fetch('l_currency', 0);
    $listing_currency_html = '';
    foreach ($listing_currency as $currency) {
        $listing_currency_html .= '<option value="' . $currency->term_id . '|' . $currency->name . '">' . $currency->name . '</option>';
    }

    //Get countries
    $countries = dwt_listing_categories_fetch('l_location', 0);
    $country_html = '';
    $country_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
    foreach ($countries as $country) {
        $country_html .= '<option value="' . $country->term_id . '">' . $country->name . '</option>';
    }

    $dayss = dwt_listing_week_days();
    $days = array();

    foreach ($dayss as $key => $val) {
        $days[] = array("day_name" => $val, "start_time" => '', "end_time" => '', "closed" => '');
    }
}
$loc_lvl_1 = esc_html__('Select Your Country', 'dwt-listing');
$loc_lvl_2 = esc_html__('Select Your State', 'dwt-listing');
$loc_lvl_3 = esc_html__('Select Your City', 'dwt-listing');
$loc_lvl_4 = esc_html__('Select Your Town', 'dwt-listing');
if (dwt_listing_text('sb_location_titles') != "") {
    $titles_array = explode("|", dwt_listing_text('sb_location_titles'));
    if (count($titles_array) > 0) {
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

require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/simple.php';
if (dwt_listing_text('dwt_listing_enable_map') == "1" && dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "") {
    echo '<script type="text/javascript">

    var markers = [
        {
            "title": "",
            "lat": "' . $listing_lattitude . '",
            "lng": "' . $listing_longitide . '",
        },
    ];
    window.onload = function () {
        	my_g_map(markers);
        }
		function my_g_map(markers1)
		{
			var mapOptions = {
            center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var geocoder = geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById("submit-listing-map"), mapOptions);
            var data = markers1[0]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
                google.maps.event.addListener(marker, "dragend", function (e) {
					document.getElementById("dwt_listing_loading").style.display	= "block";
                    var lat, lng, address;
                    geocoder.geocode({ "latLng": marker.getPosition() }, function (results, status) {
						
                        if (status == google.maps.GeocoderStatus.OK) {
                            lat = marker.getPosition().lat();
                            lng = marker.getPosition().lng();
                            address = results[0].formatted_address;
							document.getElementById("d_latt").value = lat;
							document.getElementById("d_long").value = lng;
							document.getElementById("address_location").value = address;
							document.getElementById("dwt_listing_loading").style.display	= "none";
                            //alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
                        }
                    });
                });
            })(marker, data);
            latlngbounds.extend(marker.position);
		
		jQuery(document).ready(function($) {
		$(document.getElementsByClassName("my-current-location")[0]).click(function() {
		$.ajax({
		url: "https://geoip-db.com/jsonp",
		jsonpCallback: "callback",
		dataType: "jsonp",
		success: function( location ) {
			var pos = new google.maps.LatLng(location.latitude, location.longitude);
			console.log(location)
			map.setCenter(pos);
			map.setZoom(12);
			$("#address_location").val(location.city + ", " + location.country_name );
			document.getElementById("d_latt").value = location.latitude;
			document.getElementById("d_long").value = location.longitude;
			
		var markers2 = [
        {
            title: "",
            lat: location.latitude,
            lng: location.longitude,
        },
    ];
	my_g_map(markers2);
		}
	});		
	});
	
		});
		
		}
</script>';
} else {
    dwt_listing_valuesz($listing_id);
}
?>