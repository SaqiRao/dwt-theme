<?php
if (!class_exists('dwt_listing_listings')) {

    class dwt_listing_listings
    {
        /* user object */
        var $user_info;

        public function __construct()
        {
            $this->user_info = get_userdata(get_current_user_id());
        }

        /* Get User Listings Grid 1 */
        function dwt_listing_listing_styles_grid1($listing_id = '', $col_size = '', $is_slider = '', $animation = '')
        {
            if ($col_size == 3) {
                $col_size = 'col-md-4 col-sm-6 col-xs-12';
            } else if ($col_size == 2) {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            } else if ($col_size == 12) {
                $col_size = 'col-md-12 col-sm-12 col-xs-12';
            } else {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            }
            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }

            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            $business_hours = $status_type = $business_hours_status = $ratings = '';
            /* get media */
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            $get_user_dp = dwt_listing_brand_img_or_author($listing_id, 'dwt_listing_user-dp');
            /* user dp */
            if (get_post_meta($listing_id, 'dwt_listing_brand_name', true)) {
                $get_user_name = get_post_meta($listing_id, 'dwt_listing_brand_name', true);
                $get_user_url = get_the_permalink($listing_id);
            } else {
                /* user dp */
                $get_user_name = dwt_listing_listing_owner($listing_id, 'name');
                $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
            }
            /* listing category */
            $categories = dwt_listing_listing_assigned_cats($listing_id, 'grid1');
            //Business Hours
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status = '<div class="timing"> <span class="closed">' . esc_html__('Closed', 'dwt-listing') . '</span></div>';
                } else if ($status_type == 2) {
                    $business_hours_status = '<div class="timing"> <span class="always-opened">' . esc_html__('Always Open', 'dwt-listing') . '</span></div>';
                } else {
                    $business_hours_status = '<div class="timing"> <span class="opened">' . esc_html__('Open Now', 'dwt-listing') . '</span></div>';
                }
            }
            /* Ratings */
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . $get_percentage['average'] . '</i></div>';
                }
            }
            //claimed
            $claimed = '';
            if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
                $claimed = '<div class="claimed-badge"> <a href="javascript:void(0)" class="tool-tip" title="' . esc_html__('Claimed', 'dwt-listing') . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/claimed.png') . '" class="img-responsive" alt="' . $final_title . '"></a> </div>';
            }

            //coupon
            $coupon_tag = '';
            return '<div class="' . esc_attr($col_size) . ' masonery_item">
					  <div class="listing-item l_grid1 ' . esc_attr($reveal) . '">
							<div class="listing-img">
								<a href="' . get_the_permalink($listing_id) . '" class="post-img"><img src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '" class="img-responsive" alt="' . $final_title . '"></a>
								<div class="profile-avtar">
									<a class="if-no-img" href="' . esc_url($get_user_url) . '"><img src="' . esc_url($get_user_dp) . '" class="img-responsive" alt="' . get_the_title($listing_id) . '"></a>
								</div>
								' . $claimed . '
								' . $business_hours_status . '
								<div class="listing-details">
								 ' . $categories . '
								  <h4><a href="' . get_the_permalink($listing_id) . '">' . $final_title . '</a>' . dwt_listing_is_listing_featured($listing_id) . '</h4>
								 ' . $ratings . '
								 ' . $coupon_tag . '
								</div>
							</div>
						  </div>
              </div>';
        }

        // Get User Listings Grid 2
        function dwt_listing_listing_styles_grid2($listing_id = '', $col_size = '', $is_slider = '', $animation = '')
        {
            if ($col_size == 3) {
                $col_size = 'col-md-4 col-sm-6 col-xs-12';
            } else if ($col_size == 2) {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            } else if ($col_size == 12) {
                $col_size = 'col-md-12 col-sm-12 col-xs-12';
            } else {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            }
            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }

            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));

            $business_hours = $claimed = $location = $listing_currency = $price_type = $streent_location = $business_hours_status = $ratings = '';
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            //user dp
            $get_user_dp = dwt_listing_brand_img_or_author($listing_id, 'dwt_listing_user-dp');
            //user dp
            if (get_post_meta($listing_id, 'dwt_listing_brand_name', true)) {
                $get_user_url = get_the_permalink($listing_id);
            } else {
                //user dp
                $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
            }
            //listing category
            $categories = dwt_listing_listing_assigned_cats($listing_id, 'grid2');

            //Business Hours
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status = '<p class="closed">' . esc_html__('Closed', 'dwt-listing') . '</p>';
                } else if ($status_type == 2) {
                    $business_hours_status = '<p class="open24-7">' . esc_html__('Always Open', 'dwt-listing') . '</p>';
                } else {
                    $business_hours_status = '<p class="open">' . esc_html__('Open Now', 'dwt-listing') . '</p>';
                }
            } else {
                $business_hours_status = '<span><p class="light-gray">' . esc_html__('N/A', 'dwt-listing') . '</p></span>';
            }
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . $get_percentage['average'] . '</i></div>';
                }
            }
            //location
            if (get_post_meta($listing_id, 'dwt_listing_listing_street', true) != "") {
                $streent_location = get_post_meta($listing_id, 'dwt_listing_listing_street', true);
                $location = '<li class="tool-tip" title="' . $streent_location . '"><a href="javascript:void(0)" class="ti-location-pin"></a></li>';
            }
            //price type
            if (get_post_meta($listing_id, 'dwt_listing_listing_priceType', true) != "") {
                $listing_currency = '';
                $pricing = get_post_meta($listing_id, 'dwt_listing_listing_priceType', true);
                $listing_currency = get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true);
                $price_type = '<li class="tool-tip" title="' . esc_attr($pricing) . '"><a href="javascript:void(0)"><div>' . esc_attr($listing_currency) . '</div></a></li>';
            }
            //claimed
            if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
                $claimed = '<div class="claimed-badge"> <a href="javascript:void(0)" class="tool-tip" title="' . esc_html__('Claimed', 'dwt-listing') . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/claimed.png') . '" class="img-responsive" alt="' . $final_title . '"></a> </div>';
            }
            //coupon
            $coupon_tag = '';
            if (dwt_listing_check_coupon_expiry($listing_id) == '1') {
                if (get_post_meta($listing_id, 'dwt_listing_coupon_title', true) != "") {
                    $discount = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
                    $coupon_tag = '<span class="coupon-sale">' . $discount . '</span>';
                }
            }

            $flip = '';
            if (is_rtl()) {
                $flip = 'flip';
            }

            /* make favourite or not */
            $fav_class = "fa fa-heart-o";
            if (is_user_logged_in()) {
                if (get_user_meta(get_current_user_id(), 'dwt_listing_fav_listing_id' . $listing_id, true) == $listing_id) {
                    $fav_class = "fa fa-heart";
                }
            }

            return '<div class="' . esc_attr($col_size) . ' masonery_item">
                          <div class="listing-item ' . esc_attr($reveal) . '">
                            <div class="listing-img">
                                <div class="lazy-imagess" >
                                    <a href="' . get_the_permalink($listing_id) . '" class="post-img">
                                        <img src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '"  class="img-responsive" alt="' . $final_title . '">
                                    </a>
                                </div>
								' . $claimed . '
								' . dwt_listing_is_listing_featured($listing_id, true) . '
								' . dwt_listing_listing_video($listing_id) . '
                                ' . $ratings . '
							   <div class="profile-avtar">
								   <a class="if-no-img" href="' . esc_url($get_user_url) . '" ><img src="' . esc_url($get_user_dp) . '" class="img-responsive" alt="' . $final_title . '"></a>
							   </div>
							   ' . $coupon_tag . '
                            </div>
                            <div class="listing-details">
                              <h4><a href="' . get_the_permalink($listing_id) . '"> ' . $final_title . '</a></h4>
                              <div class="cat-icon-listing">' . $categories . '</div>
                              <p>' . dwt_listing_words_count(get_the_content($listing_id), 70) . '</p>
                            </div>
                            <div class="bottom-details"> 
                               ' . $business_hours_status . '
                                <ul class="pull-right ' . $flip . '">
                                    ' . $location . '
                                    <li class="tool-tip" title="' . esc_html__('Favourite', 'dwt-listing') . '"><a data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>" data-listing-id="' . esc_attr($listing_id) . '" href="javascript:void(0)" class="sonu-button-' . esc_attr($listing_id) . ' bookmark-listing ' . $fav_class . '"></a></li>
									' . $price_type . '
                                </ul>
                            </div>
                          </div>
                        </div>';
        }

        // Get User Listings Grid 3
        function dwt_listing_listing_styles_grid3($listing_id = '', $col_size = '', $is_slider = '', $animation = '')
        {
            if ($col_size == 3) {
                $col_size = 'col-md-4 col-sm-6 col-xs-12';
            } else if ($col_size == 2) {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            } else if ($col_size == 12) {
                $col_size = 'col-md-12 col-sm-12 col-xs-12';
            } else {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            }

            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }

            $business_hours = $claimed = $location = $listing_currency = $price_type = $streent_location = $business_hours_status = $ratings = '';
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            //user dp
            $get_user_dp = dwt_listing_brand_img_or_author($listing_id, 'dwt_listing_user-dp');
            if (get_post_meta($listing_id, 'dwt_listing_brand_name', true)) {
                $get_user_name = get_post_meta($listing_id, 'dwt_listing_brand_name', true);
                $get_user_url = get_the_permalink($listing_id);
            } else {
                //user dp
                $get_user_name = dwt_listing_listing_owner($listing_id, 'name');
                $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
            }
            //listing category
            $categories = dwt_listing_listing_assigned_cats($listing_id, 'grid2');

            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            //Business Hours
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status = '<p class="closed">' . esc_html__('Closed', 'dwt-listing') . '</p>';
                } else if ($status_type == 2) {
                    $business_hours_status = '<p class="open24-7">' . esc_html__('Always Open', 'dwt-listing') . '</p>';
                } else {
                    $business_hours_status = '<p class="open">' . esc_html__('Open Now', 'dwt-listing') . '</p>';
                }
            } else {
                $business_hours_status = '<span><p class="light-gray">' . esc_html__('N/A', 'dwt-listing') . '</p></span>';
            }
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . $get_percentage['average'] . '</i></div>';
                }
            }
            //location
            if (get_post_meta($listing_id, 'dwt_listing_listing_street', true) != "") {
                $streent_location = get_post_meta($listing_id, 'dwt_listing_listing_street', true);
                $location = '<li class="tool-tip" title="' . $streent_location . '"><a href="javascript:void(0)" class="ti-location-pin"></a></li>';
            }
            //price type
            if (get_post_meta($listing_id, 'dwt_listing_listing_priceType', true) != "") {

                $pricing = get_post_meta($listing_id, 'dwt_listing_listing_priceType', true);
                $listing_currency = get_post_meta($listing_id, 'dwt_listing_listing_currencyType', true);
                $price_type = '<li class="tool-tip" title="' . esc_attr($pricing) . '"><a href="javascript:void(0)" class="ti-money" ></a></li>';
            }
            //claimed
            if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
                $claimed = '<div class="claimed-badge"> <a href="javascript:void(0)" class="tool-tip" title="' . esc_html__('Claimed', 'dwt-listing') . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/claimed.png') . '" class="img-responsive" alt="' . $final_title . '"></a> </div>';
            }
            //coupon
            $coupon_tag = '';
            if (dwt_listing_check_coupon_expiry($listing_id) == '1') {
                if (get_post_meta($listing_id, 'dwt_listing_coupon_title', true) != "") {
                    $discount = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
                    $coupon_tag = '<span class="coupon-sale">' . $discount . '</span>';
                }
            }
            $flip = '';
            if (is_rtl()) {
                $flip = 'flip';
            }

            /* make favourite or not */
            $fav_class = "fa fa-heart-o";
            if (is_user_logged_in()) {
                if (get_user_meta(get_current_user_id(), 'dwt_listing_fav_listing_id' . $listing_id, true) == $listing_id) {
                    $fav_class = "fa fa-heart";
                }
            }

            return '<div class="' . esc_attr($col_size) . ' masonery_item">
                        <div class="grid-style-s1 ' . esc_attr($reveal) . '">
                            <div class="author-and-cat">
                                <div class="author-areaz">
                                     <a href="' . esc_url($get_user_url) . '" class="if-no-img" ><img src="' . esc_url($get_user_dp) . '" class=" img-responsive" alt="' . $final_title . '"></a>
                                    <div class="listing-auth-name">
                                        <h5>' . $get_user_name . '</h5>
                                        ' . $categories . '
                                    </div>
                                </div>
                             
								<span class="tool-tip listing-bookmark" title="' . esc_html__('Favourite', 'dwt-listing') . '"><a data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>" data-listing-id="' . esc_attr($listing_id) . '" href="javascript:void(0)" class="sonu-button-' . esc_attr($listing_id) . ' bookmark-listing "><i class="' . $fav_class . '"></i></a></span>
								
                            </div>
                            <div class="listing-image-box">
                                   <a href="' . get_the_permalink($listing_id) . '" class="post-img">
                                        <img src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '"  class="img-responsive" alt="' . $final_title . '">
                                    </a>
                                    ' . dwt_listing_listing_video($listing_id) . '
									' . dwt_listing_is_listing_featured($listing_id, true) . '
									' . $claimed . '
                            </div>
                            <div class="listing-grid-content-area">
                                <div class="listing-short-meta">
                                    ' . $ratings . '
                                </div>
                                <h4><a href="' . get_the_permalink($listing_id) . '"> ' . $final_title . '</a></h4>
                                <a href="' . get_the_permalink($listing_id) . '">' . esc_html__('View Detail', 'dwt-listing') . ' <i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>';
        }

        // Get User Listings Grid 4
        function dwt_listing_listing_styles_grid4($listing_id = '', $col_size = '', $is_slider = '', $animation = '')
        {
            if ($col_size == 3) {
                $col_size = 'col-md-4 col-sm-6 col-xs-12';
            } else if ($col_size == 2) {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            } else if ($col_size == 12) {
                $col_size = 'col-md-12 col-sm-12 col-xs-12';
            } else {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            }

            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }
            

            $business_hours = $claimed = $location = $listing_currency = $price_type = $streent_location = $business_hours_status = $ratings = '';
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            $get_user_dp = dwt_listing_brand_img_or_author($listing_id, 'dwt_listing_user-dp');


        
            //user dp
            if (get_post_meta($listing_id, 'dwt_listing_brand_name', true)) {
                $get_user_name = get_post_meta($listing_id, 'dwt_listing_brand_name', true);
                $get_user_url = get_the_permalink($listing_id);
            } else {
                //user dp
                $get_user_name = dwt_listing_listing_owner($listing_id, 'name');
                $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
            }

            //listing category
            $categories = '';
            $categories = dwt_listing_listing_assigned_cats($listing_id);

            //cleantitle
            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            //$final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            $final_title = $limited_title;

            //Business Hours
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Closed', 'dwt-listing') . '</li>';
                } else if ($status_type == 2) {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Always Open', 'dwt-listing') . '</li>';
                } else {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Open Now', 'dwt-listing') . '</li>';
                }
            } else {
                $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('N/A', 'dwt-listing') . '</li>';
            }
            //claimed
            if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
                $claimed = '<div class="claimed-badge"> <a href="javascript:void(0)" class="tool-tip" title="' . esc_html__('Claimed', 'dwt-listing') . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/claimed.png') . '" class="img-responsive" alt="' . $final_title . '"></a> </div>';
            }
            //coupon
            $coupon_tag = '';
            if (dwt_listing_check_coupon_expiry($listing_id) == '1') {
                if (get_post_meta($listing_id, 'dwt_listing_coupon_title', true) != "") {
                    $discount = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
                    $coupon_tag = '<span class="coupon-sale">' . $discount . '</span>';
                }
            }
            $flip = '';
            if (is_rtl()) {
                $flip = 'flip';
            }
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<li class="tool-tip" title="' . esc_html__('Reviews', 'dwt-listing') . '"><span class="rating-counter">' . esc_attr($get_percentage['rated_no_of_times']) . '&nbsp;' . esc_html__('Reviews', 'dwt-listing') . '</span></li>';
                }
            }

            /*check favourite or not and add css class*/
            $fav_class = "fa fa-heart-o";
            if (is_user_logged_in()) {
                if (get_user_meta(get_current_user_id(), 'dwt_listing_fav_listing_id' . $listing_id, true) == $listing_id) {
                    $fav_class = "fa fa-heart";
                }
            }

            $l_post_links = get_the_permalink($listing_id);
            return '<div class="switcher-item ' . esc_attr($col_size) . ' masonery_item">
            <div class="gird_with_list ' . esc_attr($reveal) . '">
           <div class="switcher-image-box">
		   ' . $claimed . '
                        <a href="' . get_the_permalink($listing_id) . '" class="imz-over">
                                <img class="group list-grid-switcher-image img-responsive" src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '" alt="' . $final_title . '" />
                        </a>
                        ' . dwt_listing_is_listing_featured($listing_id, true) . '
                        ' . $coupon_tag . '
                        ' . dwt_listing_listing_video($listing_id) . '
                        ' . $claimed . '
				<span class="tool-tip bookmarkz-listing" title="' . esc_html__('Favourite', 'dwt-listing') . '"><a data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>" data-listing-id="' . esc_attr($listing_id) . '" href="javascript:void(0)" class="sonu-button-' . esc_attr($listing_id) . ' bookmark-listing "><i class="' . $fav_class . '"></i></a></span>				
               </div>
                <div class="caption">
					 <h4 class="group inner list-grid-switcher-item-heading"><a href="' . ($l_post_links) . '"> ' . $final_title . '</a></h4>
					<ul class="list-inline">
						' . $ratings . '
						<li class="tool-tip" title="' . esc_html__('Listing Category', 'dwt-listing') . '">' . $categories . '</li>
						' . $business_hours_status . '
					</ul>
					<p class="group inner list-grid-switcher-item-text">' . dwt_listing_words_count(get_the_content($listing_id), 70) . '</p>
                    <div class="venue"><span><i class="fa fa-map-marker"></i></span>' . dwt_listing_listing_custom_location($listing_id) . '</div>
                </div>
                ' . apply_filters('custom_changes_by_theme_grid4', $listing_id, $get_user_url, $get_user_dp, $final_title, $get_user_name) . '
            </div>
        </div>';
        }

        function dwt_listing_listing_styles_mansory($listing_id = '', $col_size = '', $is_slider = '', $animation = '')
        {
            if ($col_size == 3) {
                $col_size = 'col-md-4 col-sm-6 col-xs-12';
            } else if ($col_size == 2) {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            } else if ($col_size == 12) {
                $col_size = 'col-md-12 col-sm-12 col-xs-12';
            } else {
                $col_size = 'col-md-6 col-sm-6 col-xs-12';
            }
            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }

            $business_hours = $claimed = $location = $listing_currency = $price_type = $streent_location = $business_hours_status = $ratings = '';
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            $get_user_dp = dwt_listing_brand_img_or_author($listing_id, 'dwt_listing_user-dp');
            //user dp
            if (get_post_meta($listing_id, 'dwt_listing_brand_name', true)) {
                $get_user_name = get_post_meta($listing_id, 'dwt_listing_brand_name', true);
                $get_user_url = get_the_permalink($listing_id);
            } else {
                //user dp
                $get_user_name = dwt_listing_listing_owner($listing_id, 'name');
                $get_user_url = dwt_listing_listing_owner($listing_id, 'url');
            }
            //listing category
            $categories = dwt_listing_listing_assigned_cats($listing_id);

            //cleantitle
            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            //Business Hours
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Closed', 'dwt-listing') . '</li>';
                } else if ($status_type == 2) {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Always Open', 'dwt-listing') . '</li>';
                } else {
                    $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('Open Now', 'dwt-listing') . '</li>';
                }
            } else {
                $business_hours_status = '<li class="tool-tip" title="' . esc_html__('Status', 'dwt-listing') . '">' . esc_html__('N/A', 'dwt-listing') . '</li>';
            }

            //claimed
            if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
                $claimed = '<div class="claimed-badge"> <a href="javascript:void(0)" class="tool-tip" title="' . esc_html__('Claimed', 'dwt-listing') . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/claimed.png') . '" class="img-responsive" alt="' . $final_title . '"></a> </div>';
            }
            //coupon
            $coupon_tag = '';
            if (dwt_listing_check_coupon_expiry($listing_id) == '1') {
                if (get_post_meta($listing_id, 'dwt_listing_coupon_title', true) != "") {
                    $discount = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
                    $coupon_tag = '<span class="coupon-sale">' . $discount . '</span>';
                }
            }

            $flip = '';
            if (is_rtl()) {
                $flip = 'flip';
            }
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<li class="tool-tip" title="' . esc_html__('Reviews', 'dwt-listing') . '"><span class="rating-counter">' . esc_attr($get_percentage['rated_no_of_times']) . '&nbsp;' . esc_html__('Reviews', 'dwt-listing') . '</span></li>';
                }
            }

            /* make favourite or not */
            $fav_class = "fa fa-heart-o";
            if (is_user_logged_in()) {
                if (get_user_meta(get_current_user_id(), 'dwt_listing_fav_listing_id' . $listing_id, true) == $listing_id) {
                    $fav_class = "fa fa-heart";
                }
            }

            return '<div class="switcher-item ' . esc_attr($col_size) . ' masonery_item">
            <div class="gird_with_list ' . esc_attr($reveal) . '">
           <div class="switcher-image-box">
		   ' . $claimed . '
				<a href="' . get_the_permalink($listing_id) . '" class="imz-over">
					<img class="group list-grid-switcher-image img-responsive" src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '" alt="' . $final_title . '" />
				</a>
				' . dwt_listing_is_listing_featured($listing_id, true) . '
				' . $coupon_tag . '
				' . dwt_listing_listing_video($listing_id) . '
				' . $claimed . '
				<span class="tool-tip bookmarkz-listing" title="' . esc_html__('Favourite', 'dwt-listing') . '"><a data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>" data-listing-id="' . esc_attr($listing_id) . '" href="javascript:void(0)" class="sonu-button-' . esc_attr($listing_id) . ' bookmark-listing "><i class="' . $fav_class . '"></i></a></span>				
               </div>
                <div class="caption">
					 <h4 class="group inner list-grid-switcher-item-heading"><a href="' . get_the_permalink($listing_id) . '"> ' . $final_title . '</a></h4>
					<ul class="list-inline">
						' . $ratings . '
						<li class="tool-tip" title="' . esc_html__('Listing Category', 'dwt-listing') . '">' . $categories . '</li>
						' . $business_hours_status . '
					</ul>
					<p class="group inner list-grid-switcher-item-text">' . dwt_listing_words_count(get_the_content($listing_id), 70) . '</p>
                    <div class="venue"><span><i class="fa fa-map-marker"></i></span>' . dwt_listing_listing_custom_location($listing_id) . '</div>
                </div>
                <div class="authorz">
                  <div class="author-thumb">
                    <a class="if-no-img" href="' . esc_url($get_user_url) . '"><img src="' . esc_url($get_user_dp) . '" class="img-responsive" alt="' . $final_title . '"></a>
                  </div>
                  <div class="author-info">
                    <h6><a href="' . esc_url($get_user_url) . '">' . dwt_listing_words_count($get_user_name) . '</a></h6>
                    <span class="listing-date"><i class="far fa-clock"></i> ' . get_the_date(get_option('date_format'), $listing_id) . ' </span>
                  
                  </div>
                </div>
            </div>
        </div>';
        }

        // Get User Listings Grid 1
        function dwt_listing_listing_styles_list1($listing_id = '', $animation = '')
        {
            $thumb_size = 'dwt_listing_list-view1';
            $business_hours = $status_type = $location = $business_hours_status = $ratings = '';
            $reveal = 'foo';
            if ($animation == 'no') {
                $reveal = '';
            }
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            //listing category
            $categories = dwt_listing_listing_assigned_cats($listing_id, 'list1');
            //cleantitle
            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<div class="ratings elegent">' . $get_percentage['total_stars'] . ' <i class="rating-counter">' . esc_attr($get_percentage['rated_no_of_times']) . '&nbsp;' . esc_html__('Reviews', 'dwt-listing') . '</i></div>';
                }
            }
            //for thumbs
            $small_thumb = $large_img = $related_img = '';
            if (count((array)$media) > 0) {
                $count = 1;
                foreach ($media as $thumb) {
                    if ($count > 4) {
                        break;
                    }
                    //if (wp_attachment_is_image($listing_id)) {
                    if (wp_get_attachment_image_src($thumb, 'full') != false) {
                        $class = '';
                        $full_img = wp_get_attachment_image_src($thumb, 'full');
                        $imgthumb = wp_get_attachment_image_src($thumb, 'dwt_listing_listing_thumb');
                        $large_img = $full_img[0];
                        $small_thumb = $imgthumb[0];
                    } else {
                        $large_img = trailingslashit(get_template_directory_uri()) . 'assets/images/small-thumb.png';
                        $small_thumb = trailingslashit(get_template_directory_uri()) . 'assets/images/small-thumb.png';
                    }
                    $related_img .= '<li><a href="' . esc_url($large_img) . '" data-fancybox="images-preview-' . esc_attr($listing_id) . '"><img src="' . esc_attr($small_thumb) . '" class="img-responsive" alt="' . $final_title . '"></a></li>';
                    $count++;
                }
            }
            //location
            if (get_post_meta($listing_id, 'dwt_listing_listing_street', true) != "") {
                $streent_location = get_post_meta($listing_id, 'dwt_listing_listing_street', true);
                $location = '<a href="javascript:void(0)"> <i class="ti-location-pin"></i> ' . $streent_location . ' </a>';
            }
            //Business Hours
            $business_hours_status = '';
            if (dwt_listing_business_hours_status($listing_id) != "") {
                $status_type = dwt_listing_business_hours_status($listing_id);
                if ($status_type == 0) {
                    $business_hours_status .= '<a class="closed">' . esc_html__('Closed', 'dwt-listing') . '</a>';
                } else if ($status_type == 2) {
                    $business_hours_status .= '<a class="open24">' . esc_html__('Always Open', 'dwt-listing') . '</a>';
                } else {
                    $business_hours_status .= '<a class="open-now">' . esc_html__('Open Now', 'dwt-listing') . '</a>';
                }
            }
            //coupon
            $coupon_tag = '';
            if (dwt_listing_check_coupon_expiry($listing_id) == '1') {
                if (get_post_meta($listing_id, 'dwt_listing_coupon_title', true) != "") {
                    $discount = get_post_meta($listing_id, 'dwt_listing_coupon_title', true);
                    $coupon_tag = '<span class="coupon-sale">' . $discount . '</span>';
                }
            }

            return '<div class="ads-list-archive masonery_item">
				<div class="' . esc_attr($reveal) . '">
						  <div class="col-md-4 col-sm-5 col-xs-12  nopadding">
							 <div class="ad-archive-img">
									<a href="' . get_the_permalink($listing_id) . '">
										<img class="img-responsive" src="' . dwt_listing_return_listing_idz($media, $thumb_size) . '" alt="' . $final_title . '"> 
									</a>
									 ' . $business_hours_status . '
									 ' . $coupon_tag . '
							 </div>
						  </div>
						  <div class="col-md-8 col-sm-7 col-xs-12">
							 <div class="ad-archive-desc">
								<h3><a href="' . get_the_permalink($listing_id) . '"> ' . $final_title . ' </a>' . dwt_listing_is_listing_featured($listing_id) . '</h3>
								<div class="category-title">
									<span>
										' . $location . '
										' . $categories . '
									</span>
								</div>
								<div class="clearfix  visible-xs-block"></div>
								<p class="hidden-sm">' . dwt_listing_words_count(get_the_content($listing_id), 90) . '</p>
								<ul class="add_info">
								  ' . $related_img . '
								</ul>
								<div class="clearfix archive-history">
								   <div class="last-updated">
										' . $ratings . '
								   </div>
								   <div class="ad-meta">
								   <a href="javascript:void(0)" class="save-ad bookmark-listing sonu-button-' . esc_attr($listing_id) . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>' . esc_html__("Processing...", 'dwt-listing') . '" data-listing-id="' . esc_attr($listing_id) . '"><i class="fa fa-bookmark-o"></i> ' . esc_html__('Save', 'dwt-listing') . ' </a>
									<a href="' . get_the_permalink($listing_id) . '" class="read-more"> ' . esc_html__('View Detail', 'dwt-listing') . '</a>
								   </div>
								</div>
							 </div>
						  </div>
						  </div>
					   </div>';
        }

        // Get Featured Listing Slider
        function dwt_listing_featured_listing_slider($args = '', $title = '', $col = 12, $grid_layout = '')
        {
            $slider_html = $start_div = $end_div = '';
            $featured_ads = new WP_Query($args);
            if ($featured_ads->have_posts()) {
                while ($featured_ads->have_posts()) {
                    $featured_ads->the_post();
                    $listing_id = get_the_ID();
                    //style 2 grid
                    if ($grid_layout == 'grid2') {
                        $slider_html .= $this->dwt_listing_listing_styles_grid2($listing_id, '12', true, 'no');
                    } else if ($grid_layout == 'grid1') {
                        $slider_html .= $this->dwt_listing_listing_styles_grid1($listing_id, '12', true, 'no');
                    } else if ($grid_layout == 'grid3') {
                        $slider_html .= $this->dwt_listing_listing_styles_grid3($listing_id, '12', true, 'no');
                    } else if ($grid_layout == 'grid4') {
                        $slider_html .= $this->dwt_listing_listing_styles_grid4($listing_id, '12', true, 'no');
                    } else {
                        $slider_html .= $this->dwt_listing_listing_styles_grid4($listing_id, '12', true, 'no');
                    }
                }
                if ($grid_layout == 'grid1') {
                    $start_div = '<div class="papular-listing-2">';
                    $end_div = '</div>';
                }
                wp_reset_postdata();
            }
            if ($slider_html == '') {
                return '';
            } else {
                $slider_id = 'papular-listing-2-slider';
                if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
                    $slider_id = 'slider_type_2';
                }

                return '<div class="premium-slider">
					<div class="heading-title">
						<h4>' . $title . '</h4>
					</div>
					<div class="row">
					' . $start_div . '<div id="' . $slider_id . '" class="owl-carousel owl-theme"> ' . $slider_html . ' </div></div>' . $end_div . '
				</div>';
            }
        }

        // Get Most Viewed Listings
        function dwt_listing_most_viewed($listing_id = '')
        {
            $listing_views = $ratings = $get_percentage = '';
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            //Ratings
            if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
                if (isset($get_percentage) && count((array)$get_percentage['ratings']) > 0 && count((array)$get_percentage['rated_no_of_times']) > 0) {
                    $ratings = '<li><div class="ratings elegent">' . $get_percentage['total_stars'] . '</div></li>';
                }
            }
            if (function_exists('pvc_get_post_views')) {
                $listing_views = '<li>' . esc_html__('Views ', 'dwt-listing') . pvc_get_post_views($listing_id) . '</li>';
            }
            return '<li class="listing-most-viewed">
				  <div class="listing-viewed-card">
					<a href="' . get_the_permalink($listing_id) . '"><img class="listing-viewed-img" src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_user-dp') . '" alt="' . get_the_title($listing_id) . '" /></a>
					<div class="listing-viewed-detailz">
					  <span class="date">' . dwt_listing_listing_assigned_cats($listing_id) . '</span>
					  <h3 class="listing-viewed-title"><a href="' . get_the_permalink($listing_id) . '">' . get_the_title($listing_id) . '</a></h3>
						<ul class="listing-viewed-stats">
							' . $ratings . '
							' . $listing_views . '
						</ul>
						<p class="date"><i class="lnr lnr-calendar-full"></i>' . esc_html__('Posted on', 'dwt-listing') . ' ' . get_the_date(get_option('date_format'), $listing_id) . '</p>
					</div>
				  </div>
				</li>';
        }

        // Get User Eventz
        function dwt_listing_public_events($event_id = '')
        {
            $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $term_list = wp_get_post_terms($event_id, 'l_event_cat', array("fields" => "names"));
            $event_cat = $term_list[0];
            if ($event_start_date != "") {
                $event_start = '<li>' . esc_html__('From', 'dwt-listing') . ' : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_start_date)) . '</li>';
            }
            if ($event_end_date != "") {
                $event_end = '<li>' . esc_html__('To', 'dwt-listing') . ' : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_end_date)) . '</li>';
            }
            if ($event_venue != "") {
                $event_venue_loc = '<li><a class="published" href="javascript:void(0)">' . esc_html__('Location', 'dwt-listing') . ' : ' . $event_venue . '</a></li>';
            }

            //cleantitle
            $limited_title = dwt_listing_words_count(get_the_title($event_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));

            return '<div class="profile-listing-box">
                   <img class="img-circle img-responsive" src="' . dwt_listing_return_event_idz($media, 'dwt_listing_user-dp') . '" alt="' . $final_title . '">
                    <div class="profile-listing-box-info">
                        <div class="profile-listing-box-title"><h5><a href="' . get_the_permalink($event_id) . '">' . $final_title . '</a></h5> </div>
                        <div class="profile-listing-box-text">
                            <ul>
                            	<li> <a href="javascript:void(0)"> ' . esc_attr($event_cat) . '</a></li>
                                ' . ($event_start) . '
                                ' . ($event_end) . '
                                ' . ($event_venue_loc) . '
                            </ul>
                        </div>
                    </div>
                </div>';
        }

        function dwt_listing_listing_styles_gallery($listing_id = '')
        {
            $limited_title = dwt_listing_words_count(get_the_title($listing_id), dwt_listing_text('grid_title_limit'));
            $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
            $business_hours = $status_type = $business_hours_status = $ratings = '';
            //listing category
            $categories = dwt_listing_listing_assigned_cats($listing_id, '');
            //get media
            $media = dwt_listing_fetch_listing_gallery($listing_id);
            return '<li class="s-gallery-box">
                <img src="' . dwt_listing_return_listing_idz($media, 'dwt_listing_listing-grids') . '" alt="' . $final_title . '">
                <div class="s-gallery-content">
					<span class="s-gallery-cat">' . $categories . '</span>
                    <h4><a href="' . get_the_permalink($listing_id) . '">' . $final_title . '</a></h4>
                    <h5><i class=" ti-time "></i> ' . get_the_date(get_option('date_format'), $listing_id) . '</h5>
                    <a href="' . get_the_permalink($listing_id) . '" class="btn-gallery btn btn-theme ">' . esc_html__('View Detials', 'dwt-listing') . '</a>
                </div>
            </li>';
        }
    }

}

// DWT Listing Ajax Based Search

add_action('wp_ajax_dwt_ajax_search', 'dwt_listing_ajax_search');
add_action('wp_ajax_nopriv_dwt_ajax_search', 'dwt_listing_ajax_search');
if (!function_exists('dwt_listing_ajax_search')) {

    function dwt_listing_ajax_search()
    {
        global $dwt_listing_options;
        $params = array();
        $lat_lng_meta_query = array();
        parse_str($_POST['collect_data'], $params);
        $latitude = '';
        $longitude = '';

        // print_r($params);
        /*
       * custom field search
       */
        $meta_query_arr = $meta_field_set = array();
        foreach ($params as $key => $values) {
            if (strpos($key, 'field_multi_') === 0) {
                if (isset($values) && is_array($values)) {
                    if (isset($values[0]) && $values[0] != '') {
                        $meta_field_set['relation'] = 'OR';
                        foreach ($values as $single_value) {
                            $meta_field_set[] = array(
                                'key' => $key,
                                'value' => $single_value,
                                'compare' => 'LIKE',
                            );
                        }
                    }
                } else {
                    if (isset($values[0]) && $values[0] != '') {
                        $meta_field_set[] = array(
                            'key' => $key,
                            'value' => $values,
                            'compare' => 'LIKE',
                        );
                    }
                }

            }
        }
        $meta_query_arr = $meta_field_set;

        /*
         * End custom field search
         */

        if (!empty($_POST['e_lat']) && !empty($_POST['e_long'])) {
           // $latitude = $_POST['e_lat'];
         //   $longitude = $_POST['e_long'];
        } else if (isset($params['r_map_lat']) && $params['r_map_long'] != "") {
//$latitude = $params['r_map_lat'];
         //   $longitude = $params['r_map_long'];
        }

        if (!empty($latitude) && !empty($longitude)) {
            $distance = '30';
            $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
            $type_lat = "'DECIMAL'";
            $type_lon = "'DECIMAL'";
            $lats_longs = dwt_listing_radius_search($data_array, false);
            if (!empty($lats_longs) && count((array)$lats_longs) > 0) {
                if ($latitude > 0) {
                    $lat_lng_meta_query[] = array(
                        'key' => 'dwt_listing_listing_lat',
                        'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                        'compare' => 'BETWEEN',
                    );
                } else {
                    $lat_lng_meta_query[] = array(
                        'key' => 'dwt_listing_listing_lat',
                        'value' => array($lats_longs['lat']['max'], $lats_longs['lat']['min']),
                        'compare' => 'BETWEEN',
                    );
                }
                if ($longitude > 0) {
                    $lat_lng_meta_query[] = array(
                        'key' => 'dwt_listing_listing_long',
                        'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                        'compare' => 'BETWEEN',
                    );
                } else {
                    $lat_lng_meta_query[] = array(
                        'key' => 'dwt_listing_listing_long',
                        'value' => array($lats_longs['long']['max'], $lats_longs['long']['min']),
                        'compare' => 'BETWEEN',
                    );
                }
            }
        }

        //Listing Title
        $listing_title = '';
        if (isset($params['by_title']) && $params['by_title'] != "") {
            $listing_title = $params['by_title'];
        }

        //Categories
        $category = '';
            if (isset($params['l_category']) && $params['l_category'] != "" && $params['l_category'] != 'all') {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => dwt_listing_show_taxonomy_all($params['l_category'], 'l_category'),
                ),
            );
        }

        $search_filter_type = '';
        if (isset($_POST['search_filter_type']) && $_POST['search_filter_type'] != "") {
            $search_filter_type = $_POST['search_filter_type'];
        }

        $all_dynamic_fields = '';
        if ($dwt_listing_options['donwtown_search_bydynamic_fields'] == true) {
            if ($params['l_category'] != "" && $params['l_category'] != 'all') {
            // if ($params['l_category'] != '' && $params['l_category'] != 'all') {
                $all_dynamic_fields = dwt_listing_fetch_cat_form_fields_($params['l_category'], $search_filter_type);
                
            }
        }
        

        //Listing Street Address
        $street_address = '';
        if (isset($params['street_address']) && $params['street_address'] != "") {
            $street_address = array(
                'key' => 'dwt_listing_listing_street',
                'value' => trim($params['street_address']),
                'compare' => 'LIKE',
            );
        }

        //Price Type
        $price_type = '';
        if (isset($params['l_price_type']) && $params['l_price_type'] != "" && $params['l_price_type'] != 'all') {
        // if (isset($params['l_price_type']) && $params['l_price_type'] != "") {
            $price_type = array(
                array(
                    'taxonomy' => 'l_price_type',
                    'field' => 'term_id',
                    'terms' => $params['l_price_type'],
                ),
            );
        // }
    }

        //Listing Status
        $listing_id = array();
        if (isset($params['l_listing_status']) && $params['l_listing_status'] != "") {
            if ($params['l_listing_status'] == 'all') {
                $listing_id = array();
            } else if ($params['l_listing_status'] == 'opened') {
                $listing_id = dwt_listing_search_listing_status();
                if (count((array)$listing_id) == 0) {
                    $listing_id = array(0);
                }
            }
        }

        /*Rated As
        Listing By Rated */
        $order = 'DESC';
        $order_by = 'date';
        $key = '';
        if (isset($params['l_rating']) && $params['l_rating'] != "") {
            $order = 'DESC';
            if ($params['l_rating'] == 'low_rated') {
                $order = 'ASC';
            }
            $key = 'listing_total_average';
            $order_by = 'meta_value_num';
        }
        //Tags
        $tags = '';
        if (isset($params['l_tag']) && $params['l_tag'] != "") {
            $tags = array(
                array(
                    'taxonomy' => 'l_tags',
                    'field' => 'term_id',
                    'terms' => dwt_listing_show_taxonomy_all($params['l_tag'], 'l_tags'),
                ),
            );
        }
        //Amenties
        $amenties = '';
        if (isset($params['amenties']) && is_array($params['amenties']) && $params['amenties'] != "") {
            $amenties = array(
                'taxonomy' => 'l_category',
                'field' => 'term_id',
                'terms' => $params['amenties'],
            );
        }
        //Custom Location region
        $custom_location = '';
        if (isset($params['l_location']) && $params['l_location'] != "") {
            $location_array = array();
            if (isset($params['l_location']) && $params['l_location'] != "")
                $location_array[] = $params['l_location'];
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => dwt_listing_show_taxonomy_all($params['l_location'], 'l_location'),
                ),
            );
        } elseif (isset($_COOKIE['dwt_cookie_location']) && $_COOKIE['dwt_cookie_location'] != "") {
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => dwt_listing_countires_cookies(),
                ),
            );
        }
        //post status active only
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $featured_or_simple = '';
        /* condition based featured ads */
        if (dwt_listing_text('feature_or_simple') == 0) {
            $featured_or_simple = array(
                'key' => 'dwt_listing_is_feature',
                'value' => '0',
                'compare' => '='
            );
        }
        if (isset($_POST['sort_by']) && $_POST['sort_by'] != "") {
            $orde_arr = explode('-', $_POST['sort_by']);
            $order = isset($orde_arr[1]) ? $orde_arr[1] : 'DESC';
            $order_by = isset($orde_arr[0]) ? $orde_arr[0] : 'ID';
        }
        $page_no = '';
        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        $featured_ads = '';
        if (dwt_listing_text('feature_on_search') == 1) {

            $grid_layout = 'grid2';
            $grid_layout = dwt_listing_text('dwt_listing_feature_on_search');
            $feature_args = array(
                'post_type' => 'listing',
                'posts_per_page' => dwt_listing_text('max_ads_feature'),
                'tax_query' => array(
                    $category,
                ),
                'meta_query' => array(
                    array(
                        'key' => 'dwt_listing_is_feature',
                        'value' => 1,
                        'compare' => '=',
                    ),
                    array(
                        'key' => 'dwt_listing_listing_status',
                        'value' => '1',
                        'compare' => '='
                    ),
                ),
                'orderby' => 'date',
            );
            $dwt_listing_listings = new dwt_listing_listings();
            $featured_ads .= ($dwt_listing_listings->dwt_listing_featured_listing_slider($feature_args, dwt_listing_text('feature_ads_title'), 4, $grid_layout));
        }
        //main query
        $args = array
        (
            's' => $listing_title,
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'post__in' => $listing_id,
            'tax_query' => array(
                $category,
                $price_type,
                $amenties,
                $tags,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $street_address,
                $featured_or_simple,
                $lat_lng_meta_query,
                $meta_query_arr
            ),
            'meta_key' => $key,
            'order' => $order,
            'orderby' => $order_by,
            'paged' => $page_no,
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            if (dwt_listing_text("dwt_listing_seacrh_layout") == "map") {
                require trailingslashit(get_template_directory()) . "template-parts/listing-search/grid-styles/grids-ajax.php";
                echo $results->found_posts . '|' . $fetch_output . '|' . '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>' . '|' . dwt_listing_ajax_pagination_search($results, $page_no) . '|' . $featured_ads . '|' . $all_dynamic_fields;
            } else {
                require trailingslashit(get_template_directory()) . "template-parts/listing-search/grid-styles/grids.php";
                echo $results->found_posts . '|' . $fetch_output . '|' . '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>' . '|' . dwt_listing_ajax_pagination_search($results, $page_no) . '|' . $featured_ads . '|' . $all_dynamic_fields;
            }
        } else {
            if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
                echo '0|' . dwt_listing_ajax_no_result() . '|' . '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>';
                echo '<script>var listing_markersz = [];</script>';
            } else {
                echo '0|' . dwt_listing_ajax_no_result() . '|' . '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>' . '|' . '' . '|' . $featured_ads;
            }
        }
        die();
    }
}

/* ***************************************
 * get dynamic form fields for search filter
 ***************************************** */
if (!function_exists('dwt_listing_fetch_cat_form_fields_')) {

    function dwt_listing_fetch_cat_form_fields_($category_id = '', $search_filter_type = '')
    {
        $fetch_form_fields = get_posts(array('post_type' => 'l_form_fields', 'post_status' => 'publish', 'order' => 'ASC',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'l_category',
                        'field' => 'term_id',
                        'terms' => $category_id)
                )
            )
        );
        $check_html = $selected = '';
        $form_multicheck = '';
        $fetch_options = '';
        $form_multiradio = '';
        $form_multiselect = '';
        if (count($fetch_form_fields) > 0) {
            $start_div = $end_div = $wrap_start_div = $wrap_end_div = '';
            if ($search_filter_type == 'topbar_filter') {
                $start_div = '<div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">';
                $end_div = '</div>';
            }
            if ($search_filter_type == 'map_sidebar_filter') {
                $start_div = '<div class="col-md-6 col-xs-12 col-sm-6">';
                $end_div = '</div>';
            }
            if ($search_filter_type == 'sidebar_filter') {
                $wrap_start_div = '<div class="listing-widget">';
                $wrap_end_div = '</div>';
            }
            foreach ($fetch_form_fields as $form_fields) {
                $text_field_val = $post_id = '';
                $post_id = $form_fields->ID;
                $selected = '';
                /* fetch generated field type */
                $field_type = get_post_meta($post_id, 'd_field_type', true);
                if ($field_type == 'multiplecheck') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_check');
                    if (count($options) > 0) {
                        $check_html .= '<div class="form-group multicheckbox-form-group"><label class="fields-custom-text">' . $form_fields->post_title . '</label>';
                        $check_html .= '<ul class="my_fields multicheckbox_custom">';
                        foreach ($options as $opt) {
                            if ($fetch_options != "") {
                                $selected = (in_array($opt, $fetch_options)) ? 'checked="checked"' : '';
                            }
                            $check_html .= '<li><input type="checkbox" class="custom-checkbox" ' . $selected . ' value="' . $opt . '" name="field_multi_check_' . $post_id . '[]"></span> <label for="' . $opt . '"> ' . $opt . '</label></li>';
                        }
                        $check_html .= '</ul></div>';
                        $check_html = $check_html;
                    }
                }
                /*currently we not useing this(by sir..) */
                if ($field_type == 'radio-radio') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_radio');
                    if (count($options) > 0) {
                        $check_html .= '<div class="form-group radio-form-group"><lable class="fields-custom-text">' . $form_fields->post_title . '</lable>';
                        $check_html .= '<ul class="my_fields dynamic_radio_fields">';
                        foreach ($options as $opt) {
                            $selected = ($opt == $form_multiradio) ? 'checked="checked"' : '';
                            $check_html .= '<li><input type="radio" class="custom-checkbox checkbox_radio" ' . $selected . ' value="' . $opt . '" name="field_multi_radio_' . $post_id . '"></span> <label for="' . $opt . '"> ' . $opt . '</label></li>';
                        }
                        $check_html .= '</ul></div>';
                        $check_html = $check_html;
                    }
                }
                if ($field_type == 'dropdownselect') {
                    $options = dwt_listing_render_custom_fields($post_id, 'd_multi_drop_val');
                    if (count($options) > 0) {
                        $check_html .= $start_div . ' <div class="form-group select-form-group"><div class="selective-dropdowns">';
                        $check_html_options = '';
                        $check_html .= '<label class="control-label">' . $form_fields->post_title . '</label>';
                        foreach ($options as $opt) {
                            $selected = ($opt == $form_multiselect) ? 'selected="selected"' : '';
                            $check_html_options .= '<option value="' . $opt . '" ' . $selected . '>' . $opt . '</option>';
                        }
                        $check_html .= '<select data-placeholder="' . esc_html__('Select an option', 'dwt-listing') . '" class="form-control custom-fields dynamic_field_select" name="field_multi_select_' . $post_id . '">';
                        $check_html .= '<option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>';
                        $check_html .= $check_html_options;
                        $check_html .= '</select>';
                        $check_html .= '</div></div>' . $end_div;
                        $check_html = $check_html;
                    }
                }
            }
            return $wrap_start_div . $check_html . $wrap_end_div;
        }
        return $check_html;
    }
}

/* DWT Listing Ajax Based Search */
add_action('wp_ajax_dwt_ajax_renew_listings', 'dwt_ajax_renew_lists');
add_action('wp_ajax_nopriv_dwt_ajax_renew_listings', 'dwt_ajax_renew_lists');
if (!function_exists('dwt_ajax_renew_lists')) {

    function dwt_ajax_renew_lists()
    {
        $list_arr = array();
        $list_arr = $_POST['listng_ids'];
        $listing_IDs = array_map('intval', explode(',', $list_arr));
        if (isset($listing_IDs) && is_array($listing_IDs)) {
            $status = '1';
            foreach ($listing_IDs as $list_id) {
                wp_update_post(
                    array(
                        'ID' => $list_id, // ID of the post to update
                        'post_date' => get_gmt_from_date(date(get_option('date_format'))),
                    )
                );
                //one means its active
                update_post_meta($list_id, 'dwt_listing_listing_status', $status);
            }
            echo '1|' . esc_html__("Your listing has been renewed.", 'dwt-listing');
        } else {
            echo '0|' . esc_html__("Nothing renew", 'dwt-listing');
        }
        die();
    }

}

/*==============================
Trashes Listing move to Expired
===============================*/
add_action('wp_ajax_dwt_ajax_trash_to_expired_listings', 'dwt_trash_to_expired_listings');
add_action('wp_ajax_nopriv_dwt_ajax_trash_to_expired_listings', 'dwt_trash_to_expired_listings');
if (!function_exists('dwt_trash_to_expired_listings')) {
    function dwt_trash_to_expired_listings()
    {
        $list_arr = $_POST['listng_ids'];
        $listing_IDs = array_map('intval', explode(',', $list_arr));
        if (isset($listing_IDs) && is_array($listing_IDs)) {
            foreach ($listing_IDs as $list_id) {
                $status = '0';
                $post = array('ID' => $list_id, 'post_status' => 'publish');
                update_post_meta($list_id, 'dwt_listing_listing_status', $status);
                wp_update_post($post);
            }
            echo '1|' . esc_html__("Your listing has been moved to expired", 'dwt-listing');
        } else {
            echo '0|' . esc_html__("Nothing move to Expired", 'dwt-listing');
        }
        die();
    }
}