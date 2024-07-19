<?php
/**
 * About us one html
 */
if (!function_exists('dwt_elementor_about_us')) {

    function dwt_elementor_about_us($params) {
        /* Declearing */
        $section_title = $section_tag_line = $section_description = $img_postion = $img_left = $img_right = $bg_img = '';
        $features = $feature_html = $feature_icon = '';

        /* initializing */
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $section_description = $params['section_description'];
        $bg_img = $params['bg_img'];
        $img_postion = $params['img_postion'];
        $features = $params['features'];



        $bg_img = dwt_listing_return_img_src($bg_img);
        if (!empty($params['bg_img'])) {
            $bg_img = '<img src="' . esc_url($bg_img) . '" class="wow center-block img-responsive" alt="' . __('No Image', 'dwt-elementor') . '">';
        }
        if ($params['img_postion'] == 'left') {
            $img_left = '<div class="col-md-5 col-sm-12 col-xs-12">' . $bg_img . '</div>';
        } else {
            $img_right = '<div class="col-md-5 col-sm-12 col-xs-12">' . $bg_img . '</div>';
        }


        /* feature repeater */
        if ($params['features']) {
            foreach ($params['features'] as $item) {
                if ($item['features_img']['id'] != '') {
                    $feature_icon = dwt_listing_return_img_src($item['features_img']['id'], 'dwt_listing_image_icon');
                } else {
                    $feature_icon = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                }
                $feature_html .= '<div class="col-md-6 col-xs-12 col-sm-6">';
                $feature_html .= '<div class="services-grid">';
                $feature_html .= '<div class="icons">';
                $feature_html .= '<img src="' . esc_url($feature_icon) . '" class="img-responsive" alt="' . __('Image Not Found', 'dwt-listing') . '">';
                $feature_html .= '</div>';
                $feature_html .= '<h4>' . $item['features_title'] . '</h4>';
                $feature_html .= '<p>' . $item['features_desc'] . '</p>';
                $feature_html .= '</div>';
                $feature_html .= '</div>';
            }
        }


        return '<section class="about-us">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
							' . $img_left . '
						<div class="col-md-7 col-sm-12 col-xs-12">
                            <h2>' . $section_title . '</h2>
							<p class="large-paragraph">' . $section_tag_line . '</p>
							<p>' . $section_description . '</p>
							<div class="row">
								<div class="services">
									' . $feature_html . '
								</div>
							</div>
						</div>
							' . $img_right . '
					</div>
				</div>
			</div>
		</section>';
    }

}

/**
 * About Us New
 */
if (!function_exists('dwt_elementor_about_us_new')) {

    function dwt_elementor_about_us_new($params) {
        /* Declearing */
        $section_title = $section_tag_line = $section_description = $img_left = $img_right = $feature_html = '';
        $grid_imgs_html = $view_all_btn = $feature_icon = $grid_img_icon = '';

        /* Initializing */
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $section_description = $params['section_description'];
        $img_postion = $params['img_postion'];
        $btn_title = $params['main_btn_title'];
        $btn_link = $params['main_btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $about_new_features = $params['about_new_features'];
        $grid_imgs = $params['grid_imgs'];



        /* features repeater */
        if ($params['about_new_features']) {
            foreach ($params['about_new_features'] as $item) {
                if ($item['features_img']['id'] != '') {
                    $feature_icon = dwt_listing_return_img_src($item['features_img']['id'], 'dwt_listing_image_icon');
                } else {
                    $feature_icon = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                }
                $feature_html .= '<li>';
                $feature_html .= '<div class="choose-box">';
                $feature_html .= '<span class="iconbox"><img src="' . esc_url($feature_icon) . '" class="img-responsive" alt="' . __('Image Not Found', 'dwt-listing') . '"></span>';
                $feature_html .= '<div class="choose-box-content">';
                $feature_html .= '<h4>' . $item['features_title'] . '</h4>';
                $feature_html .= '<p>' . $item['features_desc'] . '</p>';
                $feature_html .= '</div>';
                $feature_html .= '</div>';
                $feature_html .= '</li>';
            }
        }
        /* grid images repeater */
        if ($grid_imgs) {
            foreach ($grid_imgs as $item) {
                if ($item['about_new_grid_img']['id'] != '') {
                    $grid_img_icon = dwt_listing_return_img_src($item['about_new_grid_img']['id'], 'dwt_listing_about_image');
                } else {
                    $grid_img_icon = trailingslashit(get_template_directory_uri()) . 'assets/images/small.png';
                }
                $grid_imgs_html .= '<li>';
                $grid_imgs_html .= '<img src="' . esc_url($grid_img_icon) . '" class="img-responsive" alt="' . __('Image Not Found', 'dwt-listing') . '">';
                $grid_imgs_html .= '</li>';
            }
        }

        /* grid image button */
        if (!empty($btn_title)) {
            $target_one = $params['target_one'];
            $nofollow_one = $params['nofollow_one'];
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link);
            $view_all_btn .= $button_one;
        }

        if ($params['img_postion'] == 'left') {

            $img_left .= '<div class="col-md-6 col-lg-6 col-xs-12 hidden-sm hidden-xs">';
            $img_left .= '<div class="p-about-us">';
            $img_left .= '<ul class="p-call-action">';
            $img_left .= $grid_imgs_html;
            $img_left .= '</ul>';
            $img_left .= '<div class="p-absolute-menu">';
            $img_left .= $view_all_btn;
            $img_left .= '</div>';
            $img_left .= '</div>';
            $img_left .= '</div>';
        } else {
            $img_right .= '<div class="col-md-6 col-lg-6 col-xs-12 hidden-sm hidden-xs">';
            $img_right .= '<div class="p-about-us">';
            $img_right .= ' <ul class="p-call-action">';
            $img_right .= $grid_imgs_html;
            $img_right .= ' </ul>';
            $img_right .= '<div class="p-absolute-menu">';
            $img_right .= '' . $view_all_btn;
            $img_right .= '</div>';
            $img_right .= '</div>';
            $img_right .= '</div>';
        }

        return '<section class="">
            <div class="container">
                <div class="row">
                    ' . $img_left . '
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <div class="choose-title">
                        <h3>' . $section_title . '</h3>
                        <h2>' . $section_tag_line . '</h2>
                            <p>' . $section_description . '</p>
                        </div>
                        <div class="choose-services">
                            <ul class="choose-list">
                                ' . $feature_html . '
                            </ul>
                        </div>
                    </div>
                    ' . $img_right . '
                </div>
            </div>
        </section>';
    }

}

/**
 * View All listings
 */
if (!function_exists('dwt_elementor_all_listings')) {

    function dwt_elementor_all_listings($params) {
        /* initializing variables */
        $section_title = $section_description = $ad_type = $ad_order = $layout_type = '';
        $no_of_ads = $all_listing_btn_title = $all_listing_btn_link = $listing_cats = '';
        $view_all_btn = $section_id = $header = $category = '';

        /* assign values to variable */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $all_listing_btn_title = $params['all_listing_btn_title'];
        $all_listing_btn_link = $params['all_listing_btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $listing_cats = $params['listing_categories'];

        $custom_class = 'papular-listing-2';
        if ($layout_type == 'grid2') {
            $custom_class = '';
            $section_id = 'id="Papular-listing"';
        }


        if ($all_listing_btn_title) {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $all_listing_btn_title, $all_listing_btn_link, 'btn btn-theme');
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="load-btn">
                  ' . $button_one . '
                  </div>
				  </div>';
        }
        $header = dwt_listing_headings($section_title, $section_description);

        /* ===== get listings ===== */
        if (count($listing_cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $listing_cats,
                ),
            );
        }

        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $lang_switch_term_id = dwt_listing_translate_object_id(dwt_listing_countires_cookies(), 'l_location');
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => $lang_switch_term_id,
                ),
            );
        }
        /* post status active only */
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        /* query args */
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $fetch_listingz = '';
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if (isset($layout_type) && $layout_type != "") {
            $layout_type = $layout_type;
        } else {
            $layout_type = 'grid2';
        }
        if ($results->have_posts()) {
            $fetch_listingz_get = (isset($fetch_listingz_get) && $fetch_listingz_get != "") ? $fetch_listingz_get : 3;
            //Masonry layout
            $fetch_listingz .= '<div class="masonery_wrap">';
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $fetch_listingz .= $listingz->$function($listing_id, $fetch_listingz_get);
            }
            $fetch_listingz .= '</div>';
        }
        wp_reset_postdata();




        return '<section ' . $section_id . ' class="' . $custom_class . '">
          <div class="container">
            <div class="row masonry_container">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   ' . $fetch_listingz . '
				' . $view_all_btn . '
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * View all blogs/posts
 */
if (!function_exists('dwt_elementor_all_blogs')) {

    function dwt_elementor_all_blogs($params) {
        /* initializing variables */
        $section_title = $section_description = $max_limit = $all_posts_btn_title = $all_posts_btn_link = '';
        $pattern_chk = $blog_cats = $show_pattern = $class = $view_all_btn = '';
        $cats = array();

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $max_limit = $params['max_limit'];
        $all_posts_btn_title = $params['all_posts_btn_title'];
        $all_posts_btn_link = $params['all_posts_btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $pattern_chk = $params['pattern_chk'];
        $blog_cats = $params['blog_cats_repeater'];


        if (!empty($pattern_chk) && $pattern_chk == 'yes') {
            $show_pattern = 'new-blog-section-3';
        }
        $header = dwt_listing_headings($section_title, $section_description);

        if ($all_posts_btn_title) {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $all_posts_btn_title, $all_posts_btn_link, 'btn btn-theme');
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button_one . '</div>
				</div>';
        }


        if (is_array($blog_cats) && !empty($blog_cats)) {
            foreach ($blog_cats as $blog_cat) {
                if (isset($blog_cat) && $blog_cat['blog_cats'] != '') {
                    $cats[] = $blog_cat['blog_cats'];
                }
            }
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $max_limit,
            'post_status' => 'publish',
            'category__in' => $cats,
            'orderby' => 'DATE',
            'order' => 'DESC',
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $posts = new WP_Query($args);
        $blog_html = $img_show = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $blogz_id = get_the_ID();
                if (has_post_thumbnail()) {
                    $get_img_src = '';
                    $get_img_src = dwt_listing_get_feature_image($blogz_id, 'dwt_listing_blogpost-thumb');
                    $img_show = '<div class="image">
						<div class="lazy-imagess">
							<a href="' . get_the_permalink($blogz_id) . '">
								<img src="' . esc_url($get_img_src[0]) . '" alt="' . get_the_title($blogz_id) . '" class="img-responsive">
							</a>
						</div>
					</div>';
                } else {
                    $img_show = '<div class="image">
						<div class="lazy-imagess">
							<a href="' . get_the_permalink($blogz_id) . '">
								<img src="' . esc_url(dwt_listing_defualt_img_url()) . '" alt="' . get_the_title($blogz_id) . '" class="img-responsive">
							</a>
						</div>
					</div>';
                }

                /*  */
                $blog_html .= '<div class="col-xs-12 col-md-4 col-sm-6">
				  <div class="blog-inner-box">
				   ' . $img_show . '
					<div class="blog-lower-box">
					  <p class="blog-date">' . get_the_date(get_option('date_format'), $blogz_id) . '</p>
					  <h3><a href="' . get_the_permalink($blogz_id) . '">' . dwt_listing_words_count(get_the_title($blogz_id), dwt_listing_text('grid_title_limit')) . '</a></h3>
					  <div class="text">' . dwt_listing_words_count(get_the_excerpt(), 90) . '</div>
					  <a href="' . get_the_permalink($blogz_id) . '" class="btn btn-theme">' . esc_html__('read more', 'dwt-listing') . '</a> </div>
				  </div>
				</div>';
            }
            wp_reset_postdata();
        }


        /* render the view */
        return '<section class="blog-section-2 ' . $show_pattern . ' ' . $class . '">
        <div class="container">
          <div class="row">
              ' . $header . '
             <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                    ' . $blog_html . '
                  ' . $view_all_btn . '
             </div>
          </div>
        </div>
      </section>';
    }

}

/**
 * Call to action One
 */
if (!function_exists('dwt_elementor_call_to_action_one')) {

    function dwt_elementor_call_to_action_one($params) {
        /* initializing variables */
        $section_title = $section_description = $call_action_one_btn_title = $call_action_one_btn_link = '';

        /* Gettings values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $call_action_one_btn_title = $params['call_action_one_btn_title'];
        $call_action_one_btn_link = $params['call_action_one_btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        /* Button with link */
        if ($call_action_one_btn_title) {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $call_action_one_btn_title, $call_action_one_btn_link, 'btn btn-theme');
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button_one . '</div>
				</div>';
        }

        /* render the view */
        return '<section class="call-to-action">
        	<div class="container">
                <div class="row">
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<h2> ' . $section_title . ' </h2>
                        <p> ' . $section_description . '</p>
                        ' . $view_all_btn . '
                    </div>
                </div>
             </div>                	
        </section>';
    }

}

/**
 * Call to Action Two
 */
if (!function_exists('dwt_elementor_call_to_action_two')) {

    function dwt_elementor_call_to_action_two($params) {
        /* initializing variables */
        $section_title = $section_description = $section_tagline = $call_action_btn_title_one = $call_action_btn_link_one = '';
        $call_action_btn_title_two = $call_action_btn_link_two = '';

        /* Getting Values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $section_tagline = $params['section_tagline'];
        $call_action_btn_title_one = $params['call_action_btn_title_one'];
        $call_action_btn_link_one = $params['call_action_btn_link_one'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $call_action_btn_title_two = $params['call_action_btn_title_two'];
        $call_action_btn_link_two = $params['call_action_btn_link_two'];
        $target_two = $params['target_two'];
        $nofollow_two = $params['nofollow_two'];

        /* Buttons with link */

        $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $call_action_btn_title_one, $call_action_btn_link_one, 'btn btn-theme');
        $button_two = dwt_elementor_button_link($target_two, $nofollow_two, $call_action_btn_title_two, $call_action_btn_link_two, 'btn btn-white btn-theme');

        /* render the view */
        return '<div class="s-call-action">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-7 col-md-7">
                    <div class="s-call-action-content">
                        <h2>' . $section_tagline . '</h2>
                        <h3>' . $section_title . ' </h3>
                        <p> ' . $section_description . '</p>
                        ' . $button_one . '
                        ' . $button_two . '
                    </div>
                </div>
            </div>
        </div>
    </div>';
    }

}
/**
 * Call to action Modern
 */
if (!function_exists('dwt_elementor_call_to_action_three')) {

    function dwt_elementor_call_to_action_three($params) {
        /* initializing variables */
        $section_title = $section_description = $btn_title = $btn_link = $style = $button_one = '';
        $target_one = $nofollow_one = $add_img_html = $show_extra_img = $extra_image = '';
        /* Getting Values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $show_extra_img = $params['show_extra_img'];
        if ($show_extra_img == 'yes') {
            $extra_image = $params['extra_image'];
        }

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }

        /* Display extra image */
        if (!empty($show_extra_img) && $show_extra_img == 'yes') {
            if (isset($extra_image) && $extra_image != "") {
                if ($extra_image != '') {
                    $add_img_html = '<div class="c-custom-img">
										<img class="img-responsive custom-img" src="' . dwt_listing_return_img_src($extra_image) . '" alt="' . esc_attr__('image not found', 'dwt-listing') . '" >
									</div>';
                }
            } else {
                $extra_image = trailingslashit(get_template_directory_uri()) . 'assets/images/sell-1.png';
                $add_img_html = '<div class="c-custom-img">
                                    <img class="img-responsive custom-img" src="' . $extra_image . '" alt="' . esc_attr__('image not found', 'dwt-listing') . '" >
                                </div>';
            }
        }


        /* render the view */
        return '<section class="c-call-to-action" ' . $style . '>
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
						<div class="call-to-main">
							<h2>' . $section_title . '</h2>
							<p> ' . $section_description . '</p>
							' . $button_one . '
						</div>
					</div>
				</div>
			</div>
		</section>' . $add_img_html . '';
    }

}

/**
 * Call to action Elegent
 */
if (!function_exists('dwt_elementor_call_to_action_elegent')) {

    function dwt_elementor_call_to_action_elegent($params) {
        /* initializing variables */
        $section_tag = $section_title = $section_description = $btn_title = $btn_link = $style = $button_one = '';
        $target_one = $nofollow_one = $inspection_lists = $inspection_lists_html = $add_img_html = $show_extra_img = $extra_image = '';
        /* Getting Values */
        $section_tag = $params['section_tag'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $show_extra_img = $params['show_extra_img'];
        if ($show_extra_img == 'yes') {
            $extra_image = $params['extra_image'];
        }
        $inspection_lists = $params['inspection_lists'];

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme', 'fa fa-angle-right');
        }

        /* inspection repeater */
        if ($inspection_lists) {
            foreach ($inspection_lists as $inspection_list) {
                $inspection_lists_html .= '<li class="col-md-4 col-sm-6 col-xs-12"> <i class="fa fa-check"></i> ' . $inspection_list['elegent_inspection_list'] . '</li>';
            }
        }

        /* Display extra image */
        if (!empty($show_extra_img) && $show_extra_img == 'yes') {
            if (isset($extra_image) && $extra_image != "") {
                if ($extra_image != '') {
                    $add_img_html .= '<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                        <span class="c-auto-mechanic hidden-sm hidden-xs"><img src="' . dwt_listing_return_img_src($extra_image) . '" alt="' . esc_attr__('image not found', 'dwt-listing') . '" ></span>
                                    </div>';
                }
            }
        }

        return '<section class="contact-section section-padding car-inspection">
                <div class="c-img-raper" ' . $style . '>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="c-insp-cont">
                                    <div class="row">
                                        <h3>' . $section_tag . '</h3>
                                        <h2>' . $section_title . '</h2>
                                        <p> ' . $section_description . '</p>
                                        <ul>
                                           ' . $inspection_lists_html . '
                                        </ul>
										' . $button_one . '
                                    </div>
                                </div>
                            </div>
                            ' . $add_img_html . '
                        </div> 
                    </div>
                </div>
            </section>';
    }

}

/**
 * Categories html render
 */
if (!function_exists('dwt_elementor_categories_one')) {

    function dwt_elementor_categories_one($params) {
        /* initializing variables */
        $categories_repeater = $section_title = $section_description = $header = $grid_categories = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $categories_repeater = $params['categories_repeater'];

        $header .= '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';


        if (is_array($categories_repeater) && count($categories_repeater) > 0) {
            foreach ($categories_repeater as $category) {
                $cat_id = $category['category_select'];
                $cat_img = $category['category_img']['id'];
                if (isset($cat_id) && $cat_id != '') {
                    $fetch_category = get_term($cat_id, 'l_category');
                    if (!empty($fetch_category)) {
                        if (is_array($fetch_category) && count((array) $fetch_category) == 0)
                            continue;
                        $count = $fetch_category->count;
                        if (isset($cat_img) && $cat_img != '') {
                            $bgImageURL = dwt_listing_return_img_src($cat_img);
                        } else {
                            $bgImageURL = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                        }
                        //$link = get_term_link($fetch_category->term_id);
                        $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                        $grid_categories .= '<li>
                                <a href="' . $link . '">
                                    <div class="category-list-modern-single">
                                        <img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . $fetch_category->name . '">
                                        <h4>' . $fetch_category->name . '</h4>
                                        <span>' . $count . ' ' . esc_html__('Listings', 'dwt-listing') . '</span>
                                    </div>
                                </a>
                            </li>';
                    }
                }
            }
        }



        return '<section class="category-list-modern">
                    <div class="container">
                        <div class="row">
            	                ' . $header . '
                            <div class="col-md-12 col-sm-12 col-xs-12">
			   		            <ul>' . $grid_categories . '</ul>
			                </div>
                        </div>
                    </div>
                </section>';
    }

}

/**
 * Category Elegent
 */
if (!function_exists('dwt_elementor_category_elegent')) {

    function dwt_elementor_category_elegent($params) {
        /* initializing variables */
        $categories_repeater = $section_title = $section_description = $head_section = $grid_categories = $bgImageURL = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $categories_repeater = $params['categories_repeater'];

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }

        /* title section */
        $head_section = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        if (is_array($categories_repeater) && count($categories_repeater) > 0) {
            foreach ($categories_repeater as $category) {
                $cat_icon = '';
                $cat_id = $category['category_select'];
                $cat_desc = $category['category_description'];
                $cat_img = $category['category_img']['id'];
                if (isset($cat_id) && $cat_id != '') {
                    $fetch_category = get_term($cat_id, 'l_category');
                    if (!empty($fetch_category)) {
                        if (is_array($fetch_category) && count((array) $fetch_category) == 0)
                            continue;
                        $count = $fetch_category->count;
                        if (isset($cat_img) && $cat_img != '') {
                            $bgImageURL = dwt_listing_return_img_src($cat_img, 'dwt_listing_blogpost-thumb');
                        }
                        if (get_term_meta($fetch_category->term_id, 'category_icon', true) != "") {
                            $cat_icon = '<div class="glyphicon-ring "><span class="' . get_term_meta($fetch_category->term_id, 'category_icon', true) . ' glyphicon-bordered"></span></div>';
                        }
                        //$link = get_term_link($fetch_category->term_id);
                        $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                        $grid_categories .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dwt-new-catz" href="' . $link . '">
                              <div class="e-cat-box">
                                  ' . $cat_icon . '
                                  <img class="img-responsive" src="' . esc_url($bgImageURL) . '"  alt="' . $fetch_category->name . '">
                                  <div class="e-cat-overly">
                                  <div class="e-cat-desc">
                                      <h2 class="e-cat-name">' . $fetch_category->name . '</h2>
                                      <p>' . $cat_desc . '</p>
                                      <span class="e-cat-count"> ' . $count . ' ' . esc_html__('Listings', 'dwt-listing') . ' </span>
                                  </div>
                              </div>
                          </div>
                        </a>
                      </div>';
                    }
                }
            }
        }

        return '<section class="new-popular-listing" id="elegent_catz">
                    <div class="container">
                        <div class="row">
                            ' . $head_section . '
                            <div class="col-md-12 col-sm-12 col-xs-12 elegent-cats nopadding">
                                ' . $grid_categories . '
                                <div class="col-md-12 col-sm-12 col-xs-12">
				                <div class="load-btn">' . $button_one . '</div>
				                </div>
                                
                            </div>
                        </div>
                        </div>
                </section>';
    }

}

/**
 * Event Categories
 */
if (!function_exists('dwt_elementor_category_events')) {

    function dwt_elementor_category_events($params) {
        /* initializing variables */
        $event_categories = $section_title = $section_description = $head_html = $bgImageURL = $event_categories_html = '';
        $class = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $event_categories = $params['event_categories_repeater'];

        /* Header */
        $head_html .= '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        /* Grid section html */
        if (is_array($event_categories) && count($event_categories) > 0) {
            foreach ($event_categories as $event_category) {
                $event_id = $event_category['event_select'];
                $cat_img = $event_category['category_img']['id'];
                if (isset($event_id) && $event_id != '') {
                    $fetch_category = get_term($event_id, 'l_event_cat');
                    if (!empty($fetch_category)) {
                        if (is_array($fetch_category) && count((array) $fetch_category) == 0)
                            continue;
                        $count = $fetch_category->count;
                        if (isset($cat_img) && $cat_img != '') {
                            $bgImageURL = dwt_listing_return_img_src($cat_img, 'dwt_listing_woo-thumb');
                        }
                        $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));
                        $event_categories_html .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                        <a href="' . $link . '">
                                                        <div class="event-list-cat red">
                                                            <img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . $fetch_category->name . '">
                                                            <div class="event-cat-hover">
                                                                <h2>' . $fetch_category->name . '</h2>
                                                                <span>' . $count . ' ' . esc_html__('Events', 'dwt-listing') . '</span>
                                                            </div>
                                                        </div>
                                                        </a>
                                                    </div>';
                    }
                }
            }
        }



        return '<section class="' . $class . '">
          <div class="container">
            <div class="row">
            	' . $head_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   		' . $event_categories_html . '
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * Categories Minimal
 */
if (!function_exists('dwt_elementor_category_minimal')) {

    function dwt_elementor_category_minimal($params) {
        /* initializing variables */
        $categories_repeater = $section_title = $section_description = $header_html = $bgImageURL = $grid_categories_html = '';
        $class = $btn_title = $btn_link = $target_one = $nofollow_one = $button_one = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $categories_repeater = $params['categories_repeater'];

        /* caategory grid render */
        if (is_array($categories_repeater) && count($categories_repeater) > 0) {
            foreach ($categories_repeater as $catz) {
                if (isset($catz) && is_array($catz) && $catz['category_select'] !='') {
                    $fetch_category = get_term($catz['category_select'], 'l_category');
                    if (!empty($fetch_category)) {
                        if (is_array($fetch_category) && count((array) $fetch_category) == 0)
                            continue;
                        $count = $fetch_category->count;
                        if (isset($catz['category_img']['id']) && $catz['category_img']['id'] != "") {
                            if ($catz['category_img']['id']) {
                                $bgImageURL = dwt_listing_return_img_src($catz['category_img']['id'], 'full');
                            } else {
                                $bgImageURL = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                            }
                        }
                        $link = dwt_cat_link_page(get_term_link($fetch_category->term_id));

                        $grid_categories_html .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								 <div class="catz-boxes">
									 <img alt="' . $fetch_category->name . '" src="' . esc_url($bgImageURL) . '">
										<h4><a href="' . ($link) . '">' . $fetch_category->name . '</a></h4>
										<strong>' . $count . ' ' . esc_html__('Listings', 'dwt-listing') . ' </strong> 
								 </div>
							  </div>';
                    }
                }
            }
        }

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }

        /* header render */
        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        /* render the html */
        return '<section class="minimal-categories">
                    <div class="container">
		                <div class="row">
			                ' . $header_html . '
		                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			                    ' . $grid_categories_html . '
			                    <div class="col-md-12 col-sm-12 col-xs-12">
				                    <div class="load-btn">' . $button_one . '</div>
				                </div>
		                    </div>
                        </div>
                    </div>
                </section>';
    }

}

/**
 * Clients html
 */
if (!function_exists('dwt_elementor_clients')) {

    function dwt_elementor_clients($params) {
        /* initializing variables */
        $clients_repeater = $section_title = $section_description = $header_html = $clients_repeater = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $clients_repeater = $params['clients_repeater'];


        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        if (isset($clients_repeater) && is_array($clients_repeater)) {
            $href = $client_loop = $client_img = '';
            foreach ($clients_repeater as $row) {
                if (isset($row['client_logo']) && $row['client_logo'] != '') {
                    $client_img = $row['client_logo']['id'];
                    echo  $client_img;
                    if (isset($client_img) && $client_img != '') {
                        $client_img = dwt_listing_return_img_src($client_img);
                        $href = '';
                        if (isset($row['client_link']) && $row['client_link'] != '') {
                            echo  $row['client_link'];
                            $href = esc_url($row['client_link']);
                        } else {
                            $href = 'javascript:void(0)';
                        }
                        $client_loop .= '<div class="col-lg-2 col-md-3 col-xs-12 col-sm-3">
                                    <div class="single-partner">
                                        <a href="' . $href . '"><img class="img-responsive" src="' . $client_img . '" alt="' . esc_html__("image not found", "dwt-listing") . '"></a>
                                    </div>
                                </div>';
                    }
                }
            }
        }




        return '<section  class="partners">
			<div class="container">
				<div class="row">
				' . $header_html . '
					 <div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="row no-gutters">
								' . $client_loop . '
						</div>
					</div>
				</div>
			</div>
		</section>';
    }

}


/**
 * Contact Us
 */
if (!function_exists('dwt_elementor_contact_us')) {

    function dwt_elementor_contact_us($params) {
        $contact_short_code = $con_title = $con_address = $address = $hours = $number = $email = '';
        $con_work_title = $con_work_time = $con_num_title = $con_number = $con_email_title = $con_email = '';

        /* Initializing values */
        $contact_short_code = $params['contact_short_code'];
        $con_title = $params['con_title'];
        $con_address = $params['con_address'];
        $con_work_title = $params['con_work_title'];
        $con_work_time = $params['con_work_time'];
        $con_num_title = $params['con_num_title'];
        $con_number = $params['con_number'];
        $con_email_title = $params['con_email_title'];
        $con_email = $params['con_email'];



        //address
        if ($con_title != '' && $con_address != '') {
            $address = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-book"></i>
							</div>
							<div class="content-area">
							   <h4>' . $con_title . '</h4>
							   <p>' . $con_address . '</p>
							</div>
						 </div>';
        }
        //Hours
        if ($con_work_title != '' && $con_work_time != '') {
            $hours = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-alarm-clock"></i>
							</div>
							<div class="content-area">
							   <h4>' . $con_work_title . '</h4>
							   <p>' . $con_work_time . ' </p>
							</div>
						 </div>';
        }
        //Contact No
        if ($con_num_title != '' && $con_number != '') {
            $number = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-mobile"></i>
							</div>
							<div class="content-area">
							   <h4>' . $con_num_title . '</h4>
							   <p>' . $con_number . '</p>
							</div>
						 </div>';
        }
        //Email
        if ($con_email_title != '' && $con_email != '') {
            $email = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-email"></i>
							</div>
							<div class="content-area">
							   <h4>' . $con_email_title . '</h4>
							   <p>' . $con_email . '</p>
							</div>
						 </div>';
        }


        return '<section class="contact-us">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                  <div class="col-md-8 col-sm-6 col-xs-12">
                     ' . do_shortcode(dwt_listing_clean_shortcode($contact_short_code)) . '
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contact-detail">
						 ' . $address . '
						 ' . $hours . '
						 ' . $number . '
						 ' . $email . '
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>';
    }

}

/**
 * Custom location
 */
if (!function_exists('dwt_elementor_custom_location')) {

    function dwt_elementor_custom_location($params) {
        $section_title = $section_description = $pattern_chk = $location_repeater = '';
        $header_html = $locations_html = $show_pattern = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $pattern_chk = $params['pattern_chk'];
        $location_repeater = $params['location_repeater'];

        /* header */
        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        /* apply pattern */
        if (!empty($pattern_chk) && $pattern_chk == 'true') {
            $show_pattern = 'new-blog-section-3';
        }
        /* Location */
        if (is_array($location_repeater) && !empty($location_repeater)) {
            foreach ($location_repeater as $locationz) {
                $img_thumb = '';
                $get_locationz_idz = (isset($locationz['location_select'])) ? $locationz['location_select'] : '';
                $location_img = $locationz['loc_img']['id'] ? $locationz['loc_img']['id'] : '';
                if ($location_img) {
                    $img_thumb = dwt_listing_return_img_src($location_img, 'dwt_listing_blogpost-thumb');
                } else {
                    $img_thumb = dwt_listing_defualt_img_url();
                }
                $term = get_term_by('id', $get_locationz_idz, 'l_location');
                if (count((array) $term) > 0 && !empty($term) && !is_wp_error($term)) {
                    //$link = get_term_link($term->term_id);
                    $link = dwt_cat_link_page(get_term_link($term->term_id));
                    $locations_html .= '<div class="col-sm-6 col-xs-12 col-md-4">
                          <a href="' . esc_url($link) . '">
                             <div class="country-box">
                                <div class="country-images">
                                	<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_html__('not found', 'dwt-listing') . '">
                                </div>
                                <div class="country-description-overlay">
                                   <div class="country-description">
                                   		<h2 class="country-name">' . $term->name . ' </h2>
                                   		<p class="country-ads"> ' . $term->count . ' ' . esc_html__('Listings', 'dwt-listing') . ' </p>
                                   </div>
                                </div>
                                <span class="featured-badge"><i class="fa fa-star-o"></i></span>
                             </div>
                          </a>
                       </div>';
                }
            }
        }





        return '<section class="cities-section ' . $show_pattern . '">
          <div class="container">
            <div class="row">
            	' . $header_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div class="cities-grid-area posts-masonry">' . $locations_html . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * Custom location
 * fancy
 */
if (!function_exists('dwt_elementor_custom_location_fancy')) {

    function dwt_elementor_custom_location_fancy($params) {
        $section_title = $section_description = $location_repeater = '';
        $header_html = $locations_html = $arrow = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $location_repeater = $params['location_repeater'];

        /* header */
        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';
        $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/cities/location.svg');
        if (!empty($location_repeater) && is_array($location_repeater)) {
            foreach ($location_repeater as $locationz) {
                $img_thumb = '';
                $get_locationz_idz = (isset($locationz['location_select'])) ? $locationz['location_select'] : '';
                $location_img = (isset($locationz['loc_img']['id'])) ? $locationz['loc_img']['id'] : '';
                $location_desc = (isset($locationz['location_description'])) ? $locationz['location_description'] : '';
                $img_url = dwt_listing_return_img_src($location_img, 'dwt_listing_locations-thumb');
                $img_thumb = $img_url;
                /* backgroud image for locationz */
                $bg_img = ($img_thumb != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $img_thumb . ')no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";

                $term = get_term_by('id', $get_locationz_idz, 'l_location');
                if (count((array) $term) > 0 && !empty($term) && !is_wp_error($term)) {
                    //$link = get_term_link($term->term_id);
                    $link = dwt_cat_link_page(get_term_link($term->term_id));
                    $locations_html .= '<div class="col-sm-6 col-xs-12 col-md-4">
						<div class="city-card spring-fever" ' . $bg_img . '>
							<a href="' . esc_url($link) . '">
							  <div class="title-content">
								<h3>' . $term->name . '</h3>
								<hr />
							  </div>
							  <div class="card-info">' . $location_desc . '</div>
							  <div class="utility-info">
								<ul class="utility-list">
								  <li class="comments"> <img src="' . $arrow . '" class="img-responsive" alt="' . $term->name . '">' . $term->count . ' ' . esc_html__('Listings', 'dwt-listing') . '</li>
								</ul>
							  </div>
							  <div class="gradient-overlay"></div>
							  <div class="color-overlay"></div>
						  </a>
						</div>
					  </div>';
                }
            }
        }





        return '<section class="cities-section">
          <div class="container">
            <div class="row">
            	' . $header_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div class="cities-grid-area-2 posts-masonry">' . $locations_html . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * All Events
 */
if (!function_exists('dwt_elementor_all_events')) {

    function dwt_elementor_all_events($params) {

        $section_title = $section_description = $head_html = $ad_order = $category = $button_one = '';
        $cats = array();
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $ad_order = $params['order_by'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_events'];
        $cats = $params['event_categories'];



        /* header html */
        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }
        /* ===== getting events ===== */
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_event_cat',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
        //post status active only
        $active_events = array(
            'key' => 'dwt_listing_event_status',
            'value' => '1',
            'compare' => '='
        );
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        //query 
        $args = array(
            'post_type' => 'events',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
            ),
            'meta_query' => array(
                $active_events,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );

        $masnory = $masnory_end = '';
        $masnory = '<div class="masonery_wrap">';
        $masnory_end = '</div>';

        if ($layout_type == '') {
            $layout_type = '_grid';
        }

        if ($layout_type == '_slider') {
            $masnory = $masnory_end = '';
        }

        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $fetch_listingz = '';
        $eventz = new dwt_listing_events();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            //Masonry layout
            $fetch_listingz .= $masnory;
            while ($results->have_posts()) {
                $results->the_post();
                $event_id = get_the_ID();
                $function = "dwt_listing_event_type$layout_type";
                $fetch_listingz .= $eventz->$function($event_id);
            }
            $fetch_listingz .= $masnory_end;
        }
        wp_reset_postdata();


        return '<section class="for-shortcodes list-boxes">
          <div class="container">
            <div class="row">
            	' . $head_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			   ' . $fetch_listingz . '
               <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="load-btn">' . $button_one . '</div>
             </div>
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * Event slider
 */
if (!function_exists('dwt_elementor_event_slider')) {

    function dwt_elementor_event_slider($params) {
        $bg_img = $section_title = $layout_type = $ad_order = $no_of_ads = '';
        $cats = array();
        /* Initializing values */
        $section_title = $params['section_title'];
        $layout_type = $params['layout_type'];
        $ad_order = $params['ad_order'];
        $no_of_ads = $params['no_of_ads'];
        $cats = $params['event_categories'];



        /* ===== getting events ===== */
        $category = '';
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_event_cat',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
        //post status active only
        $active_events = array(
            'key' => 'dwt_listing_event_status',
            'value' => '1',
            'compare' => '='
        );
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        //query 
        $args = array(
            'post_type' => 'events',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
            ),
            'meta_query' => array(
                $active_events,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );

        $masnory = $masnory_end = '';
        $masnory = '<div class="masonery_wrap">';
        $masnory_end = '</div>';

        if ($layout_type == '') {
            $layout_type = '_grid';
        }

        if ($layout_type == '_slider') {
            $masnory = $masnory_end = '';
        }

        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $fetch_listingz = '';
        $eventz = new dwt_listing_events();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            //Masonry layout
            $fetch_listingz .= $masnory;
            while ($results->have_posts()) {
                $results->the_post();
                $event_id = get_the_ID();
                $function = "dwt_listing_event_type$layout_type";
                $fetch_listingz .= $eventz->$function($event_id);
            }
            $fetch_listingz .= $masnory_end;
        }
        wp_reset_postdata();



        return '<section class="main-event">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                                <div class="event-box"> <span class="event-title"> ' . $section_title . ' </span>
                                    <div id="event-slider" class="owl-carousel owl-theme">
		 	                            ' . $fetch_listingz . '
		                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
    }

}

/**
 * Shop Category
 */
if (!function_exists('dwt_elementor_shop_category')) {

    function dwt_elementor_shop_category($params) {
        $section_title = $section_description = $btn_title = $btn_link = $target_one = $nofollow_one = '';
        $shop_cat_repeater = $grid_categories = '';



        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $shop_cat_repeater = $params['shop_cat_repeater'];

        /* header */
        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        /* grid for shop */
        if (is_array($shop_cat_repeater) && !empty($shop_cat_repeater)) {
            $all_cats = $shop_cat_repeater;
            if (!empty($all_cats) && count($all_cats) > 0) {
                foreach ($all_cats as $catz) {
                    if (isset($catz['shop_cat_select']) && $catz['shop_cat_select'] != '') {
                        $fetch_category = get_term($catz['shop_cat_select'], 'product_cat');
                        if (!empty($fetch_category)) {
                            if (is_array($fetch_category) && count($fetch_category) == 0)
                                continue;
                            if (isset($catz['shop_cat_img']['id']) && $catz['shop_cat_img']['id'] != '') {
                                $loc_img_id = $catz['shop_cat_img']['id'];
                            }
                            $bgImageURL = dwt_listing_return_img_src($catz['shop_cat_img']['id']);
                            $link = get_term_link($fetch_category->slug, 'product_cat');
                            $grid_categories .= '<div class="col-xs-12 col-md-4 col-sm-4">
			                                        <div class="fancy-catz">
				                                        <a href="' . $link . '">
											<img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . $fetch_category->name . '">
											<div class="fancy-catz-desc">
												<div class="fancy-catz-desc_text">
													<h5>' . $fetch_category->name . '</h5>
													<p>' . esc_html__('Shop Now', 'dwt-listing') . ' <i class="fa fa-angle-right"></i></p>
												</div>
											</div>
										</a>
									</div>
								</div>';
                        }
                    }
                }
            }
        }


        return '<section class="dwt_listing_fancy-cats">
          <div class="container">
            <div class="row">
            	' . $header_html . '
				   <div class="row">
						' . $grid_categories . '
						</div>
				   </div>
          </div>
        </section>';
    }

}

/**
 * FAQS
 */
if (!function_exists('dwt_elementor_faqs')) {

    function dwt_elementor_faqs($params) {
        $section_title = $section_description = $head_html = $faq_html = $tips = '';


        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $safety_title = $params['safety_title'];
        $safety_description = $params['safety_description'];
        $faq_question_repeater = $params['faq_question_repeater'];
        $safety_tips_repeater = $params['safety_tips_repeater'];




        /* header */
        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        /* questions and answers */
        if (is_array($faq_question_repeater) && !empty($faq_question_repeater)) {
            $faq_html .= '<ul class="faqs-accordion">';
            foreach ($faq_question_repeater as $faq_question) {
                $question = $faq_question['faq_question'];
                $answer = $faq_question['faq_answer'];
                if (isset($question) && isset($answer)) {
                    $faq_html .= '<li>
                           <h3 class="faqs-accordion-title"><a href="javascript:void(0)">' . esc_html($question) . '</a></h3>
                           <div class="faqs-accordion-content">
                              <p>' . esc_html($answer) . '</p>
                           </div>
                        </li>';
                }
            }
            $faq_html .= '</ul>';
        }

        /* safety tips */
        if (is_array($safety_tips_repeater) && !empty($safety_tips_repeater)) {
            foreach ($safety_tips_repeater as $row_tip) {
                if (isset($row_tip['safety_tips'])) {
                    $tips .= '<li>' . $row_tip['safety_tips'] . '</li>';
                }
            }
        }

        return '<section class="faqs-section">
          <div class="container">
            <div class="row">
            	' . $head_html . '
				    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						' . $faq_html . '
				    </div>
					<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">	
						<div class="blog-sidebar">
                       	 <div class="widget">
                           <div class="widget-heading">
                              <h4 class="panel-title"><a>' . $safety_title . ' </a></h4>
                           </div>
                           <div class="faqs-desc">
                               <p class="lead">' . $safety_description . '</p>
                              <ol>' . $tips . ' </ol>
                           </div>
                        </div>
                     	</div>
					</div>	
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * Fun Facts
 */
if (!function_exists('dwt_elementor_fun_facts')) {

    function dwt_elementor_fun_facts($params) {
        $fun_fact_repeater = $fun_html = $featureimg = '';
        $fun_fact_repeater = $params['fun_fact_repeater'];

        /* func_html */
        if (count($fun_fact_repeater) > 0) {
            foreach ($fun_fact_repeater as $row) {
                if ($row['fun_fact_number'] != "" && $row['fun_fact_title'] != "") {
                    if (isset($row['fun_fact_img']) && $row['fun_fact_img'] != '') {
                        $feature_img = ($row['fun_fact_img']['id']);
                        if (isset($feature_img) && $feature_img != '') {
                            $feature_img_url = dwt_listing_return_img_src($feature_img);
                            $featureimg = '<div class="icon-container"><img src="' . $feature_img_url . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                        }
                    } else {
                        $featureimg = '<div class="icon-container"><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/category.png' . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                    }
                    $fun_html .= '<div class="counter-seprator">
                       ' . $featureimg . '
                        <div class="counter-box">
                           <h5 class="counter-stats">' . $row['fun_fact_number'] . '</h5>
                           <h3 class="count-title">' . $row['fun_fact_title'] . '</h3>
                        </div>
                     </div>';
                }
            }
        }

        return '<div class="funfacts arch-funfacts">
            <div class="container">
               <div class="row">
				   <div class="col-md-12 col-sm-12 nopadding">
				   		<div class="conter-grid">' . $fun_html . '</div>
				   </div>
			   </div>
            </div>
         </div> ';
    }

}

/**
 * Fun facts new
 */
if (!function_exists('dwt_elementor_fun_facts_new')) {

    function dwt_elementor_fun_facts_new($params) {
        $fun_fact_repeater = $fun_html = $fun_fact_bgimg = '';

        $fun_fact_repeater = $params['fun_fact_repeater'];


        if (is_array($fun_fact_repeater) && !empty($fun_fact_repeater)) {
            foreach ($fun_fact_repeater as $row) {
                if ($row['fun_fact_number'] != "" && $row['fun_fact_title'] != "") {
                    if (isset($row['fun_fact_img']) && $row['fun_fact_img'] != '') {
                        $feature_img = $row['fun_fact_img']['id'];
                        if (isset($feature_img) && $feature_img != '') {
                            $feature_img_url = dwt_listing_return_img_src($feature_img, 'dwt_listing_image_icon');
                            $featureimg = '<div class="icon-container"> <img src="' . $feature_img_url . '" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '" class="img-responsive"> </div>';
                        }
                    } else {
                        $featureimg = '<div class="icon-container"><img src="' . trailingslashit(get_template_directory_uri()) . 'assets/images/category.png' . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></div>';
                    }
                    $fun_html .= '<div class="counter-seprator">
									<div class="counter-box">
									   <h5 class="counter-stats">' . $row['fun_fact_number'] . '</h5>
									   <p class="count-title">' . $row['fun_fact_title'] . '</p>
									</div>
									' . $featureimg . '
                     			  </div>';
                }
            }
        }



        return '<section class="buisness-listing-section ">
		<div class="buisness-inner-section"> <img  src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/lines.png') . '" alt="" class="img-responsive"> </div>
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
                  <div class="conter-grid">
                     ' . $fun_html . '
                  </div>
               </div>
            </div>
         </div>
      </section>';
    }

}

/**
 * Listing Gallery
 */
if (!function_exists('dwt_elementor_listing_gallery')) {

    function dwt_elementor_listing_gallery($params) {
        $section_title = $section_description = $head_html = $faq_html = $tips = '';
        $cats = array();

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $no_of_ads = $params['no_of_ads'];
        $categories_repeater = $params['categories_repeater'];


        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="heading-2">
							<h3>' . $section_title . '</h3>
							<h2>' . $section_description . '</h2>
						 </div>
					   </div>';




        if (!empty($categories_repeater) && is_array($categories_repeater)) {
            foreach ($categories_repeater as $row) {
                if (isset($row['category_select']) && !empty($row['category_select'])) {
                    $cats[] = $row['category_select'];
                } else {
                    $cats[] = 'all';
                }
            }
        }
        $category = '';
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
        //post status active only
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
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
        //query 
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $gallery_html = '';
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            $layout_type = 'gallery';
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $gallery_html .= $listingz->$function($listing_id);
            }
        }
        wp_reset_postdata();


        return '<div class=">
          <div class="container">
            <div class="row">
            	' . $head_html . '
            </div>
          </div>
		  <ul class="s-listing-gallery">
            ' . $gallery_html . '
        </ul>
        </div>';
    }

}

/**
 * listing slider
 */
if (!function_exists('dwt_elementor_listing_slider')) {

    function dwt_elementor_listing_slider($params) {
        $section_title = $section_description = $head_html = $faq_html = $tips = '';
        $cats = array();

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $categories_repeater = $params['categories_repeater'];

        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';


        if (!empty($categories_repeater) && is_array($categories_repeater)) {
            foreach ($categories_repeater as $row) {
                if (isset($row['category_select']) && !empty($row['category_select'])) {
                    $cats[] = $row['category_select'];
                } else {
                    $cats[] = 'all';
                }
            }
        }
        $category = '';
        if (count($cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
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
        //post status active only
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        //query 
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $slider_html = $start_div = $end_div = '';
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            if ($layout_type == "grid1") {
                $start_div = '<div class="papular-listing-2">';
                $end_div = '</div>';
            }
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $slider_html .= $listingz->$function($listing_id, '12', true, 'no');
            }
        }
        wp_reset_postdata();


        return '<section id="papular-listing" class="">
          <div class="container">
            <div class="row">
            	' . $head_html . '
              <div class="col-md-12 col-sm-12 col-xs-12">
			  ' . $start_div . '
              	<div class="papular-listing-2-slider owl-carousel owl-theme">
                 ' . $slider_html . '
                </div>
				' . $end_div . '
              </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * listing with advertisement
 */
if (!function_exists('dwt_elementor_listing_advertisement')) {

    function dwt_elementor_listing_advertisement($params) {
        $section_title = $section_description = $headingz = $button_one = $view_all_btn = $category = $section_id = '';
        $cats = array();

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $ad_720_90 = $params['ad_720_90'];
        $sticky_left = $params['sticky_left'];
        $sticky_right = $params['sticky_right'];
        $listing_cats = $params['listing_categories'];

        $custom_class = 'papular-listing-2';
        if ($layout_type == 'grid2') {
            $custom_class = '';
            $section_id = 'id="Papular-listing"';
        }

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }
        if ($button_one) {
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button_one . '</div>
				</div>';
        }

        if ($section_title != '' || $section_description != '') {
            $headingz = '<div class="heading-2 left">
						<h3>' . $section_title . ' </h3>
						<h2>' . $section_description . '</h2>
					   </div>';
        }

        /* ===== get listings ===== */
        if (count($listing_cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $listing_cats,
                ),
            );
        }

        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $lang_switch_term_id = dwt_listing_translate_object_id(dwt_listing_countires_cookies(), 'l_location');
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => $lang_switch_term_id,
                ),
            );
        }
        /* post status active only */
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        /* query args */
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $fetch_listingz = '';
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if (isset($layout_type) && $layout_type != "") {
            $layout_type = $layout_type;
        } else {
            $layout_type = 'grid2';
        }
        if ($results->have_posts()) {
            $fetch_listingz_get = (isset($fetch_listingz_get) && $fetch_listingz_get != "") ? $fetch_listingz_get : 3;
            //Masonry layout
            $fetch_listingz .= '<div class="masonery_wrap">';
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $fetch_listingz .= $listingz->$function($listing_id, $fetch_listingz_get);
            }
            $fetch_listingz .= '</div>';
        }
        wp_reset_postdata();

        return '<section ' . $section_id . ' class="dwt-with-adverts ' . $custom_class . '>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 col-xs-12 col-md-2 leftSidebar">
                                <div class="theiaStickySidebar">
                                    <div class="list-image-section">
                                    ' . $sticky_left . '
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xs-12">
                                <div class="new-banner-image_dwt">
                                ' . $ad_720_90 . '
                                </div>
                                    ' . $headingz . '
	                            <div class="row">
	                                ' . $fetch_listingz . '
	                            </div>
	                            <div class="clearfix"></div>
	                                ' . $view_all_btn . '                
                            </div>
                            <div class="col-lg-2 col-xs-12 col-md-2 rightSidebar">
                                <div class="theiaStickySidebar">
                                    <div class="list-image-section">
                                    ' . $sticky_right . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
    }

}


/**
 * listing with 
 * sidebar
 */
if (!function_exists('dwt_elementor_listing_with_sidebar')) {

    function dwt_elementor_listing_with_sidebar($params) {
        $section_title = $section_description = $headingz = $button_one = $view_all_btn = $section_id = $sidebar = $category = '';
        $cats = array();

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $ad_type = $params['ad_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['layout_type'];
        $no_of_ads = $params['no_of_ads'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $listing_cats = $params['listing_categories'];


        $custom_class = 'papular-listing-2';
        if ($layout_type == 'grid2') {
            $custom_class = '';
            $section_id = 'id="Papular-listing"';
        }

        /* Button with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button_one . '</div>
				</div>';
        }

        /* sidebar */
        if (is_active_sidebar('dwt_listing_home_sidebar')) {
            ob_start();
            dynamic_sidebar('dwt_listing_home_sidebar');
            $sidebar = ob_get_contents();
            ob_end_clean();
        }

        /* header section */
        if ($section_title != '' || $section_description != '') {
            $headingz = '<div class="heading-2 left">
						<h3>' . $section_title . ' </h3>
						<h2>' . $section_description . '</h2>
					   </div>';
        }

        /* ===== get listings ===== */
        if (count($listing_cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'l_category',
                    'field' => 'term_id',
                    'terms' => $listing_cats,
                ),
            );
        }

        $custom_location = '';
        if (dwt_listing_countires_cookies() != "") {
            $lang_switch_term_id = dwt_listing_translate_object_id(dwt_listing_countires_cookies(), 'l_location');
            $custom_location = array(
                array(
                    'taxonomy' => 'l_location',
                    'field' => 'term_id',
                    'terms' => $lang_switch_term_id,
                ),
            );
        }
        /* post status active only */
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        $is_feature = '';
        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => 'dwt_listing_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        /* query args */
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'tax_query' => array(
                $category,
                $custom_location,
            ),
            'meta_query' => array(
                $active_listings,
                $is_feature,
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $fetch_listingz = '';
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $listingz = new dwt_listing_listings();
        $results = new WP_Query($args);
        if (isset($layout_type) && $layout_type != "") {
            $layout_type = $layout_type;
        } else {
            $layout_type = 'grid2';
        }
        $fetch_listingz_get = 2;
        if ($results->have_posts()) {
            $fetch_listingz_get = (isset($fetch_listingz_get) && $fetch_listingz_get != "") ? $fetch_listingz_get : 3;
            //Masonry layout
            $fetch_listingz .= '<div class="masonery_wrap">';
            while ($results->have_posts()) {
                $results->the_post();
                $listing_id = get_the_ID();
                $function = "dwt_listing_listing_styles_$layout_type";
                $fetch_listingz .= $listingz->$function($listing_id, $fetch_listingz_get);
            }
            $fetch_listingz .= '</div>';
        }
        wp_reset_postdata();


        return '<section ' . $section_id . ' class="listing-section ' . $custom_class . '>
          <div class="container">
            <div class="row">
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 nopadding">
			   	<div class="col-md-9 col-lg-9 col-xs-12 col-sm-12">
					<div class="masonry_container" id="all_rows">
					 ' . $headingz . '
					 ' . $fetch_listingz . '
						 <div class="clearfix"></div>
						 ' . $view_all_btn . '
						 </div>
				</div>
			  	 <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">' . $sidebar . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * app sections
 */
if (!function_exists('dwt_elementor_app_section')) {

    function dwt_elementor_app_section($params) {
        $section_title = $section_description = $app_bg_img = $mobile_img = $apps = $style = '';

        /* Initializing values */
        $section_title = $params['section_title'];
        $section_tagline = $params['section_tagline'];
        $section_description = $params['section_description'];
        $app_bg_img = $params['app_bg_img'];
        $app_img = $params['app_img'];
        $app_section_android = $params['app_section_android'];
        $app_section_ios = $params['app_section_ios'];


        if (isset($app_bg_img) && $app_bg_img != "") {
            $bgImageURL = dwt_listing_return_img_src($app_bg_img);
            $style = ($bgImageURL != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        }

        if (isset($app_img) && $app_img != "") {
            $mobile_img = '<div class="col-md-6 col-sm-12 col-xs-12">
			<img class="img-responsive" src="' . dwt_listing_return_img_src($app_img) . '" alt="' . esc_html__('DWT Listing app', 'dwt-listing') . '">
			</div>';
        }

        if ($app_section_android != "") {
            $apps .= '<a href="' . esc_url($app_section_android) . '" target="_blank" class=" btn btn-custom">
                     	<img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/android.png') . '" class="img-responsive" alt="' . esc_html__('android icon', 'dwt-listing') . '"> 
                        <span class="text">' . esc_html__('Download from', 'dwt-listing') . '</span>
                        <span class="app-name">' . esc_html__('Play Store', 'dwt-listing') . '</span>
                     </a>';
        }
        if ($app_section_ios != "") {
            $apps .= '<a href="' . esc_url($app_section_ios) . '" target="_blank" class="btn btn-custom">
					<img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/apple-store.png') . '" class="img-responsive" alt="' . esc_html__('ios icon', 'dwt-listing') . '"> 
                         <span class="text">' . esc_html__('Download from', 'dwt-listing') . '</span>
                        <span class="app-name">' . esc_html__('App Store', 'dwt-listing') . '</span>
                     </a>';
        }

        return '<section class="app-section bg-gray" ' . $style . '>
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="heading-2">
                     <h3>' . $section_tagline . '</h3>
                     <h2>' . $section_title . '</h2>
                  </div>
                  <p>' . $section_description . '</p>
                  <div class="apps-buttons">' . $apps . '</div>
               </div>
               ' . $mobile_img . '
            </div>
         </div>
      </section>';
    }

}

/**
 * News letter
 */
if (!function_exists('dwt_elementor_news_letter')) {

    function dwt_elementor_news_letter($params) {
        $news_letter_heading = $newsletter_btn_txt = '';

        /* Initializing values */
        $news_letter_heading = $params['news_letter_heading'];
        $newsletter_btn_txt = $params['newsletter_btn_txt'];
        $icon = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/bullhorn.png');
        return '<section class="subscribe-section">
			<div class="container">
			<div class="row">
			  <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
				<div class="col-md-1 col-sm-1 col-xs-12">
				  <div class="announcement-img"> <img src="' . $icon . '" class="img-responsive" alt="' . esc_html__('not found', 'dwt-listing') . '"> </div>
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12">
				  <div class="heading-2">
					<h3>' . $news_letter_heading . '</h3>
				  </div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <div class="subscription-form">
					<form id="dwt_listing_news_latter" data-disable="false" method="post">
					  <div class="form-group">
						<input name="news_email" id="news_email" class="form-control" type="email" required>
					  </div>
					  <div class="with-errors"></div>
					  <div class="form-group submit-btn">
						<button class="form-control sonu-button btn-theme" type="submit" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . $newsletter_btn_txt . '</button>
					  </div>
					</form>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>';
    }

}


/**
 * package select
 */
if (!function_exists('dwt_elementor_package_select')) {

    function dwt_elementor_package_select($params) {
        $section_title = $section_description = $packages_ = $head_html = '';
        $days = $yes = $no = $tick = $cross = $never_expire = $unlimited = '';
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $package_repeater = $params['product'];
        if (class_exists('WooCommerce')) {
            $days = dwt_listing_text('d_pkg_daytxt');
            $yes = dwt_listing_text('d_pkg_yes');
            $no = dwt_listing_text('d_pkg_no');
            $tick = '<i class="yes ti-check-box"></i>';
            $cross = '<i class="no ti-close"></i>';
            $never_expire = dwt_listing_text('d_never_exp');
            $unlimited = dwt_listing_text('d_pkg_unlimited');

            /* header section */
            $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

            /* Packages */
            global $post;
            if (is_array($package_repeater) && !empty($package_repeater)) {

                foreach ($package_repeater as $row) {
                    $make_it_featured = '';
                    $options_html = '';
                    if (isset($row['products_']) && $row['products_'] != '') {
                        $product = wc_get_product($row['products_']);
                        if (isset($product) && $product != '') {
                            $pack_img = $product->get_image_id();
                            $get_woobg = dwt_listing_return_img_src($pack_img);

                            $extra_txt = '';
                            if ($product->get_short_description() != "") {
                                $extra_txt = '<div class="p-extra-txt">' . $product->get_short_description() . '</div>';
                            }
                            if (get_post_meta($row['products_'], 'make_package_featured', true) != "" && get_post_meta($row['products_'], 'make_package_featured', true) == 'yes') {

                                $make_it_featured = "pricing__item--featured";
                            }
                            if (get_post_meta($row['products_'], 'package_type', true) != "") {
                                $gey_packtype = get_post_meta($row['products_'], 'package_type', true);
                            }
                            if (get_post_meta($row['products_'], 'package_expiry', true) != "") {

                                $package_expiry = get_post_meta($row['products_'], 'package_expiry', true);
                                if ($package_expiry == '-1') {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_p_exp') . ' : ' . $never_expire . '</li>';
                                } else {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_p_exp') . ' : ' . esc_attr($package_expiry) . ' ' . $days . '</li>';
                                }
                            }

                            if (get_post_meta($row['products_'], 'regular_listing', true) != "") {
                                $regular_listing = get_post_meta($row['products_'], 'regular_listing', true);
                                if ($regular_listing == '-1') {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_reg_listing') . ' : ' . $unlimited . '</li>';
                                } else {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_reg_listing') . ' : ' . esc_attr($regular_listing) . '</li>';
                                }
                            }
                            if (get_post_meta($row['products_'], 'listing_expiry', true) != "") {
                                $listing_expiry = get_post_meta($row['products_'], 'listing_expiry', true);
                                if ($listing_expiry == '-1') {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_l_exp') . ' : ' . $never_expire . '</li>';
                                } else {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_l_exp') . ' : ' . esc_attr($listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            if (get_post_meta($row['products_'], 'featured_listing', true) != "") {
                                $featured_listing = get_post_meta($row['products_'], 'featured_listing', true);
                                if ($featured_listing == '-1') {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_listing') . ' : ' . $unlimited . '</li>';
                                } else {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_listing') . ' : ' . esc_attr($featured_listing) . '</li>';
                                }
                            }
                            if (get_post_meta($row['products_'], 'featured_listing_expiry', true) != "") {
                                $featured_listing_expiry = get_post_meta($row['products_'], 'featured_listing_expiry', true);
                                if ($featured_listing_expiry == '-1') {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_for') . ' : ' . $never_expire . '</li>';
                                } else {
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_for') . ' : ' . esc_attr($featured_listing_expiry) . ' ' . $days . '</li>';
                                }
                            }
                            if (get_post_meta($row['products_'], 'video_listing', true) != "") {
                                $video_listing = get_post_meta($row['products_'], 'video_listing', true);
                                if ($video_listing == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_vid_listing') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'website_link', true) != "") {
                                $website_link = get_post_meta($row['products_'], 'website_link', true);
                                if ($website_link == 'yes') {
                                    $w_link = $yes;
                                    $icon = $tick;
                                } else {
                                    $w_link = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_web_link') . ' : ' . esc_attr($w_link) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'no_of_images', true) != "") {
                                $no_of_images = get_post_meta($row['products_'], 'no_of_images', true);
                                $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_no_images') . ' : ' . esc_attr($no_of_images) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'price_range', true) != "") {
                                $price_range = get_post_meta($row['products_'], 'price_range', true);
                                if ($price_range == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_p_range') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'business_hours', true) != "") {
                                $business_hours = get_post_meta($row['products_'], 'business_hours', true);
                                if ($business_hours == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_b_hours') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'allow_tags', true) != "") {
                                $allow_tags = get_post_meta($row['products_'], 'allow_tags', true);
                                if ($allow_tags == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_llow_tag') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'bump_listing', true) != "") {
                                $bump_listing = get_post_meta($row['products_'], 'bump_listing', true);
                                $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_bump_listing') . ' : ' . esc_attr($bump_listing) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'allow_coupon_code', true) != "") {
                                $allow_coupon_code = get_post_meta($row['products_'], 'allow_coupon_code', true);
                                if ($allow_coupon_code == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_coupon_code') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }
                            if (get_post_meta($row['products_'], 'create_event', true) != "") {
                                $create_event = get_post_meta($row['products_'], 'create_event', true);
                                if ($create_event == 'yes') {
                                    $yes_or_no = $yes;
                                    $icon = $tick;
                                } else {
                                    $yes_or_no = $no;
                                    $icon = $cross;
                                }
                                $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_create_event') . ' : ' . esc_attr($yes_or_no) . '</li>';
                            }


                            //if user is looged in
                            if (is_user_logged_in()) {
                                $profile = new dwt_listing_profile();
                                $uid = $profile->user_info->ID;
                                //getting ads + expiry
                                if (get_user_meta($uid, 'd_user_package_id', true) != "" && get_user_meta($uid, 'd_user_package_id', true) == $row['products_']) {
                                    $regular_listing = '';
                                    $expiry_date = '';
                                    $current_date = '';
                                    $regular_listing = get_user_meta($uid, 'dwt_listing_regular_listing', true);
                                    $expiry_date = get_user_meta($uid, 'dwt_listing_package_expiry', true);
                                    $current_date = date('Y-m-d');
                                    if ($regular_listing == '-1' || $regular_listing > 0) {
                                        if ($expiry_date == '-1') {
                                            //package will never expire
                                            $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Purchased", 'dwt-listing') . '</button>';
                                        } else if ($current_date > $expiry_date) {
                                            //regular listing is there but package is expire
                                            $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['products_'] . ' sb_add_cart" data-product-id="' . $row['products_'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                        } else {
                                            //package have regular listings
                                            $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Purchased", 'dwt-listing') . '</button>';
                                        }
                                    } else {
                                        if (get_user_meta($uid, 'd_is_free_pgk', true) == $row['products_']) {
                                            $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Used", 'dwt-listing') . '</button>';
                                        } else {
                                            //no regular listings 
                                            $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['products_'] . ' sb_add_cart" data-product-id="' . $row['products_'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                        }
                                    }
                                } else {
                                    if (get_user_meta($uid, 'd_is_free_pgk', true) == $row['products_']) {
                                        $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Used", 'dwt-listing') . '</button>';
                                    } else {
                                        $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['products_'] . ' sb_add_cart" data-product-id="' . $row['products_'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                    }
                                }
                            } else {
                                $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['products_'] . ' sb_add_cart" data-product-id="' . $row['products_'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                            }

                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                $btn_link = '<a href="javascript:void(0)" class="pricing-action">' . esc_html__("Disable for Demo", 'dwt-listing') . ' </a>';
                            } else {
                                $btn_link = $btn_link;
                            }
                            $bg_img = ($get_woobg != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $get_woobg . ') center bottom no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
                            $packages_ .= '<div class="pricing-item ' . $make_it_featured . '">
							  <div class="pricing-deco" ' . $bg_img . '>
								<svg class="pricing-deco-img" enable-background="new 0 0 300 100" height="100px"  preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
								  <path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A;	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
								  <path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
								  <path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;	H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
								  <path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A;	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
								</svg>
								<div class="pricing-price"><span class="pricing-currency">' . get_woocommerce_currency_symbol() . '</span>' . $product->get_price() . '
								</div>
								<h3 class="pricing-title">' . get_the_title($row['products_']) . '</h3>
							  </div>
							  <ul class="pricing-feature-list">
								' . $options_html . '
							  </ul>
							  ' . $extra_txt . '
							 ' . $btn_link . '
							</div>';
                        }
                    }
                }
            }


            return '<section class="pricing-table">
				<div class="container">
					<div class="row">
						' . $head_html . '
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="pricing pricing-palden">
									' . $packages_ . '
								</div>	
							</div>
						</div>
					</div>
			</section>';
        }
    }

}

/**
 * How It Works
 */
if (!function_exists('dwt_elementor_how_it_work')) {

    function dwt_elementor_how_it_work($params) {
        $section_title = $section_description = $head_html = $process_html = $process_title = $process_desc = '';
        $img_html = '';
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $steps_repeat = $params['steps_repeat'];



        /* header html */
        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        /* steps html */
        if (is_array($steps_repeat) && !empty($steps_repeat)) {
            foreach ($steps_repeat as $row) {
                if (isset($row['steps_title']) && $row['steps_title'] != '') {
                    $process_title = '<h4>' . $row['steps_title'] . ' </h4>';
                }
                if (isset($row['steps_desc']) && $row['steps_desc'] != '') {
                    $process_desc = '<p>' . $row['steps_desc'] . '</p>';
                }
                if (isset($row['steps_img']['id']) && $row['steps_img']['id'] != '') {
                    if ($row['steps_img']['id']) {
                        $img_url = dwt_listing_return_img_src($row['steps_img']['id']);
                    } else {
                        $img_url = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                    }
                    $img_html = '<figure><img src="' . $img_url . '" class="img-responsive" alt="' . esc_html__('not found', 'dwt-listing') . '"></figure>';
                }
                $process_html .= '<div class="col-md-4 col-sm-6 col-xs-12"> 
						<div class="process-cycle">
							' . $img_html . '
							' . $process_title . '
							' . $process_desc . '
						</div>
                  </div>';
            }
        }


        return '<section class="highlights bg-gray">
		  <div class="container">
			<div class="row">
			  ' . $head_html . '
			   <div class="col-md-12 col-sm-12 col-xs-12 nopadding ">	
				  ' . $process_html . '
			   </div>
			</div>
		  </div>
		</section>';
    }

}

/**
 * How it work new
 */
if (!function_exists('dwt_elementor_how_it_work_new')) {

    function dwt_elementor_how_it_work_new($params) {
        $section_title = $section_description = $header_html = $process_html = $process_title = $process_desc = '';
        $img_html = $steps_bg_img = '';
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $steps_bg_img = $params['steps_bg_img'];
        $steps_repeat = $params['steps_repeat'];


        /* Background image */
        if (isset($steps_bg_img)) {
            $class = 'parallex';
            $bgImageURL = dwt_listing_return_img_src($steps_bg_img);
            $style = ($bgImageURL != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
        } else {
            $style = '';
            $bg_color = $steps_bg_img;
        }

        /* header html */
        $header_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-2">
                                <h3>' . $section_title . '</h3>
                                <h2>' . $section_description . '</h2>
                            </div>
                        </div>';

        if (is_array($steps_repeat) && !empty($steps_repeat)) {
            foreach ($steps_repeat as $row) {
                if (isset($row['steps_title']) && $row['steps_title'] != '') {
                    $process_title = '<div class="hiw-heading"><h2>' . $row['steps_title'] . ' </h2></div>';
                }
                if (isset($row['steps_desc']) && $row['steps_desc'] != '') {
                    $process_desc = '<div class="hiw-details-text"><p>' . $row['steps_desc'] . '</p></div>';
                }
                if (isset($row['steps_process_num']) && $row['steps_process_num'] != '') {
                    $count_txt = '<div class="hiw-count"> ' . esc_attr($row['steps_process_num']) . ' </div>';
                }
                if (isset($row['steps_img']['id']) && $row['steps_img']['id'] != '') {
                    if ($row['steps_img']['id']) {
                        $img_url = dwt_listing_return_img_src($row['steps_img']['id']);
                    } else {
                        $img_url = trailingslashit(get_template_directory_uri()) . 'assets/images/category.png';
                    }
                    $img_html = '<div class="hiw-img-box">
                                                          ' . $count_txt . '
                                                              <img src="' . esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/layer.png') . '" class="img-responsive" alt="' . esc_html__('not found', 'dwt-listing') . '">
                                                      <div class="hiw-img-2"> <img src="' . esc_url($img_url) . '" class="img-responsive" alt="' . esc_html__('not found', 'dwt-listing') . '"> </div>
                                                  </div>';
                }
                $process_html .= '<div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
                                      <div class="hiw-single-box">
                                            ' . $img_html . '
                                            <div class="hiw-text-box">
                                              ' . $process_title . '
                                               ' . $process_desc . '
                                            </div>
                                        </div>
                                </div>';
            }
        }




        return '<section class="how-it-work-section" ' . $style . '>
		  <div class="container">
			<div class="row">
			   ' . $header_html . '
			   <div class="clearfix"></div>
			</div>
		  </div>
		</section>
		<div class="extra-points"><div class="container"><div class="hiw-main-box"><div class="row">
					' . $process_html . '
		</div></div></div></div><div class="clearfix"></div>';
    }

}

/**
 * Shop with grid slider
 */
if (!function_exists('dwt_elementor_shop_grid_slider')) {

    function dwt_elementor_shop_grid_slider($params) {
        $section_title = $section_description = $head_html = $view_all_btn = $caresol_start = $caresol_end = $button_one = '';
        $cats = array();
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $max_limit = $params['max_limit'];
        $shop_layout_type = $params['shop_layout_type'];
        $ad_order = $params['ad_order'];
        $layout_type = $params['shop_layout_type'];
        $no_of_ads = $params['max_limit'];
        if ($shop_layout_type != 'slider') {
            $btn_title = $params['btn_title'];
            $btn_link = $params['btn_link'];
            $target_one = $params['target_one'];
            $nofollow_one = $params['nofollow_one'];
        }
        $cats = $params['shop_cat_repeater'];


        /* Button with link */
        if ($shop_layout_type != 'slider') {
            if ($btn_title != '' && $btn_link != '') {
                $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
            }
            if ($button_one) {
                $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button_one . '</div>
				</div>';
            }
        }


        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        if ($shop_layout_type == 'slider') {
            $caresol_start = '<div class="related-produt-slider owl-carousel owl-theme">';
            $caresol_end = '</div>';
        }

        $category = '';
        if (count((array) $cats) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $cats,
                ),
            );
        }
        $order = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $order = 'ASC';
        } else if ($ad_order == 'desc') {
            $order = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }

        //query 
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $max_limit,
            'tax_query' => array(
                $category,
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'dwt_listing_pkgs',
                    'operator' => 'NOT IN',
                ),
            ),
            'order' => $order,
            'orderby' => $order_by,
        );
        $layout_type = 'shop_grid';
        $wrap_stater = '<div class="masonery_wrap">';
        $wrap_ender = '</div>';
        if ($shop_layout_type == 'slider') {
            $layout_type = 'shop_slider';
            $wrap_ender = $wrap_stater = '';
        }
        $fetch_products = '';
        $productz = new dwt_listing_products_shop();
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            //Masonry layout
            $fetch_products .= $wrap_stater;
            while ($results->have_posts()) {
                $results->the_post();
                $product_id = get_the_ID();
                $function = "dwt_listing_shop_listings_$layout_type";
                $fetch_products .= $productz->$function($product_id);
            }
            $fetch_products .= $wrap_ender;
        }
        wp_reset_postdata();



        return '<section class="rel-products woocommerce">
          <div class="container">
            <div class="row">
            	' . $head_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 products nopadding">
				   
						' . $caresol_start . '
							' . $fetch_products . '
						' . $caresol_end . '	
						
						
					</div>
					' . $view_all_btn . '
				  </div>
            </div>
        </section>';
    }

}


/**
 * Shop with tabs
 */
if (!function_exists('dwt_elementor_shop_with_tabs')) {

    function dwt_elementor_shop_with_tabs($params) {
        $section_title = $section_description = $head_html = $view_all_btn = '';
        $shop_cat_repeater = $categories_html = $categories_contents = '';
        $counnt = 1;
        /* Initializing values */
        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $max_limit = $params['max_limit'];
        $ad_order = $params['ad_order'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];
        $shop_cat_repeater = $params['shop_cat_repeater'];



        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';



        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="load-btn">' . $button_one . '</div>
                        </div>';
        }


        if (is_array($shop_cat_repeater) && !empty($shop_cat_repeater)) {
            foreach ($shop_cat_repeater as $row) {
                if (isset($row['shop_cat_select'])) {
                    $is_active = '';
                    if ($counnt == 1) {
                        $is_active = 'active';
                        $counnt++;
                    }
                    $category = get_term_by('id', $row['shop_cat_select'], 'product_cat');
                    if (!empty($category)) {
                        if (count((array) $category) == 0)
                            continue;
                        $categories_html .= ' <li role="presentation" class="' . esc_attr($is_active) . '">
                                              <a data-toggle="tab" title="' . $category->name . '" role="tab" href="#tab-' . $category->term_id . '" aria-expanded="true">' . $category->name . '</a>
                                           </li>';
                        $categories_contents .= '<div id="tab-' . $category->term_id . '" role="tabpanel" class="tab-pane in fade ' . esc_attr($is_active) . '">';
                    }
                }

                $category = '';
                if (count((array) $row['shop_cat_select']) > 0) {
                    $category = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $row['shop_cat_select'],
                        ),
                    );
                }
                $ordering = 'DESC';
                $order_by = 'ID';
                if ($ad_order == 'asc') {
                    $ordering = 'ASC';
                } else if ($ad_order == 'desc') {
                    $ordering = 'DESC';
                } else if ($ad_order == 'rand') {
                    $order_by = 'rand';
                }
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => $max_limit,
                    'tax_query' => array(
                        $category,
                        array(
                            'taxonomy' => 'product_type',
                            'field' => 'slug',
                            'terms' => 'dwt_listing_pkgs',
                            'operator' => 'NOT IN',
                        ),
                    ),
                    'orderby' => $order_by,
                    'order' => $ordering,
                );
                $layout_type = 'shop_grid';
                $productz = new dwt_listing_products_shop();
                $results = new WP_Query($args);
                if (count((array) $results) > 0) {
                    $i = 0;
                    while ($results->have_posts()) {
                        $results->the_post();
                        $product_id = get_the_ID();
                        $function = "dwt_listing_shop_listings_$layout_type";
                        $categories_contents .= $productz->$function($product_id, '', $i);
                        $i++;
                    }
                    wp_reset_postdata();
                }
                $categories_contents .= '</div>';
            }
        }


        return '<section class="woocommerce">
          <div class="container">
            <div class="row">
            	' . $head_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 products">
				   <div class="row">
						<div class="recent-tab">	
						<ul class="nav nav-tabs" role="tablist">' . $categories_html . '</ul>
					</div>
					<div class="tab-content">
							' . $categories_contents . '
					</div>
                        <div class="clearfix"></div>
						' . $view_all_btn . '
						</div>
				   </div>
            </div>
          </div>
        </section>';
    }

}

/**
 * Slider
 */
if (!function_exists('dwt_elementor_slider')) {

    function dwt_elementor_slider($params) {
        $overlay_effect = $slider_slides_repeater = $slides = $additional_class = $view_all_btn = '';

        $overlay_effect = $params['overlay_effect'];
        $slider_slides_repeater = $params['slider_slides_repeater'];


        if (isset($slider_slides_repeater) && !empty($slider_slides_repeater)) {
            $overlay_class = '';
            if ($overlay_effect == 'yes') {
                $additional_class = 'owl-parallex';
            }

            foreach ($slider_slides_repeater as $row) {
                if (isset($row['slide_tagline']) && $row['slide_tagline'] != '') {
                    $tag_line = '<h4 class="fresh-arrival">' . $row['slide_tagline'] . '</h4>';
                }
                if (isset($row['slide_title']) && $row['slide_title'] != '') {
                    $title_div = '<h1>' . $row['slide_title'] . '</h1>';
                }
                if (isset($row['slide_desc']) && $row['slide_desc'] != '') {
                    $desc_div = '<p>' . $row['slide_desc'] . '</p>';
                }
                if (($row['btn_title'] != '') && $row['btn_link']['url'] != '') {
                    $button_one = dwt_elementor_button_link($row['btn_link']['is_external'], $row['btn_link']['nofollow'], $row['btn_title'], $row['btn_link']['url'], 'btn btn-theme');
                    if ($button_one) {
                        $view_all_btn = $button_one;
                    }
                }
                if (isset($row['slide_img']) && $row['slide_img'] != '') {
                    $img_url = dwt_listing_return_img_src($row['slide_img']['id']);
                    $style = ($img_url != "") ? ' style="background: url(' . $img_url . '); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
                }
                $slides .= '<div class="item ' . $overlay_class . '" ' . $style . '>
				  <div class="container">
					<div class="row">
					   <div class="col-sm-8 col-md-6 col-xs-12 text-white">
					    ' . $tag_line . '
						' . $title_div . '
						' . $desc_div . '
						' . $view_all_btn . '
					  </div>
					</div>
				  </div>
				</div>';
            }
        }


        return '<div class="landing-carousel ' . $additional_class . '">
				  <div class="landing-carousel-slider owl-carousel owl-theme">
				  		' . $slides . '
				  </div>
    		  </div>';
    }

}

/**
 * Testimonials
 */
if (!function_exists('dwt_elementor_testimonials')) {

    function dwt_elementor_testimonials($params) {
        $section_title = $section_description = $head_html = $testimonials = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $testi_repeater = $params['testi_repeater'];

        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        if (is_array($testi_repeater) && !empty($testi_repeater)) {
            foreach ($testi_repeater as $row) {
                if (isset($row['testi_desc'])) {
                    $testimonials .= '<div class="testimonial">
                                    <div class="testimonial-content">
                                        <div class="testimonial-icon">
                                            <i class="fa fa-quote-left"></i>
                                        </div>
                                        <p class="description">
                                           ' . $row['testi_desc'] . '
                                        </p>
                                    </div>
                                    <h3 class="title">' . $row['testi_user_name'] . '</h3>
                                    <span class="post">' . $row['testi_user_desg'] . '</span>
                                    </div>';
                }
            }
        }


        return '<section class="testimonial-style-2">
          <div class="container">
            <div class="row">
            	' . $head_html . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div id="testimonial-slider" class="owl-carousel owl-theme">' . $testimonials . '</div>
			   </div>
            </div>
          </div>
        </section>';
    }

}


/**
 * Testimonials New
 */
if (!function_exists('dwt_elementor_testimonials_new')) {

    function dwt_elementor_testimonials_new($params) {
        $section_title = $section_description = $head_html = $testimonials = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $testi_repeater = $params['testi_repeater'];

        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';

        if (is_array($testi_repeater) && !empty($testi_repeater)) {
            foreach ($testi_repeater as $row) {
                $user_img = '';
                if (isset($row['testi_desc']) && $row['testi_desc'] != "") {
                    if (isset($row['loc_img']) && $row['loc_img'] != "") {
                        $bgImageURL = dwt_listing_return_img_src($row['loc_img']['id']);
                        $user_img .= '<div class="feedback-user-img">
                                            <img src="' . esc_url($bgImageURL) . '" class="img-responsive" alt="' . esc_html__('image not found', 'dwt-listing') . '">
                                        </div>';
                    }
                    $testi_user_desg = '';
                    if (isset($row['testi_user_desg']) && $row['testi_user_desg'] != "") {
                        $testi_user_desg = $row['testi_user_desg'];
                    }
                    $testimonials .= '<div class="feedback-type2 text-center draw-border">
                                    ' . $user_img . '
                                    <div class="feedback-desc">
                                        <h5>' . $row['testi_user_name'] . '</h5>
                                        <h6>' . $testi_user_desg . '</h6>							
                                        <div class="quote-arrow">
                                        <p>' . $row['testi_desc'] . '</p>
                                        </div>
                                    </div>
                               </div>';
                }
            }
        }


        return '<section class="testimonial-style-2">
                    <div class="container">
                      <div class="row">
                          ' . $head_html . '
                         <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                <div  class="feedbacks1 owl-carousel owl-theme">' . $testimonials . '</div>
                         </div>
                      </div>
                    </div>
                  </section>';
    }

}

/**
 * Text Block
 */
if (!function_exists('dwt_elementor_text_block')) {

    function dwt_elementor_text_block($params) {
        $section_title = $section_description = $head_html = $testimonials = '';

        $section_title = $params['section_title'];
        $section_description = $params['section_description'];
        $content = $params['content'];



        $head_html = '<div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-2">
                            <h3>' . $section_title . '</h3>
                            <h2>' . $section_description . '</h2>
                        </div>
                    </div>';



        return '<section class="blog-post-container">
          <div class="container">
            <div class="row">
            	' . $head_html . '
				   <div class="col-md-12 col-sm-12 col-xs-12">
					   <div class="single-blog blog-detial">
						   <div class="blog-post">
							   <div class="post-excerpt post-desc">
									' . $content . '
							   </div>
						   </div>
					   </div>
				   </div>
            </div>
          </div>
        </section>';
    }

}


/**
 * Hero SEction one
 */
if (!function_exists('dwt_elementor_hero_one')) {

    function dwt_elementor_hero_one($params) {
        $section_title = $location_repeater = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $form_text = $params['form_text'];
        $pattern_chk = $params['pattern_chk'];
        /* ==== search form ===== */
        $categories_repeater = $params['form_categories'];
        /* ===== location ===== */
        $google_or_custom = $params['google_or_custom'];
        if ($params['google_or_custom'] == 'custom') {
            $location_repeater = $params['location_repeater'];
        }
        /* ===== grid categories ===== */
        $grid_category_repeater = $params['grid_categories'];


        /* ================ */
        /* Now starat      */
        /* =============== */
        $count_listings = wp_count_posts('listing');

        /* ===== show pattern ===== */
        $show_pattern = '';
        if ($pattern_chk == 'yes') {
            $show_pattern = 'd-cloudy';
        }

        /* ===== arrow sign ===== */
        if (is_rtl()) {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow-rtl.png');
        } else {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow.png');
        }

        /* ===== fetch catefories for form ===== */
        $want_to_show = '';
        $cats_html = dwt_listing_return_cats_features($categories_repeater, $want_to_show);

        /* ===== Grid categories ===== */
        $grid_categories = $cat_icon = $link = '';
        if (isset($grid_category_repeater)) {
            $all_cats = $grid_category_repeater;
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

        /* ===== fetch locations ===== */
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
            $location = dwt_listing_return_selective_location($location_repeater);
        }



        return '<section id="intro-hero" class="' . $show_pattern . '">
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


/**
 * Hero two
 */
if (!function_exists('dwt_elementor_hero_two')) {

    function dwt_elementor_hero_two($params) {
        $section_title = $location_repeater = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        /* ==== search form ===== */
        $categories_repeater = $params['form_categories'];
        /* ===== location ===== */
        $google_or_custom = $params['google_or_custom'];
        if ($params['google_or_custom'] == 'custom') {
            $location_repeater = $params['location_repeater'];
        }
        /* ===== grid categories ===== */
        $grid_category_repeater = $params['grid_categories'];


        /* ================ */
        /* Now starat      */
        /* =============== */
        $count_listings = wp_count_posts('listing');

        /* ===== arrow sign ===== */
        if (is_rtl()) {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow-rtl.png');
        } else {
            $arrow = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/main-arrow.png');
        }

        /* ===== fetch catefories for form ===== */
        $want_to_show = '';
        $cats_html = dwt_listing_return_cats_features($categories_repeater, $want_to_show);

        /* ===== Grid categories ===== */
        $grid_categories = $cat_icon = $link = '';
        if (isset($grid_category_repeater)) {
            $all_cats = $grid_category_repeater;
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

        /* ===== fetch locations ===== */
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
            $location = dwt_listing_return_selective_location($location_repeater);
        }



        return '<div class="home-main-2 for-my-locz">
	<div class="container">
    	<div class="row">
        	<div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
            	<div class="main-section-area">
                    <div class="main-text-area">
                        <h1>' . esc_attr($section_tag_line) . ' <span class="my-current-location"></span> </h1>
                        <p>
						' . str_replace('%count%', '<strong>' . $count_listings->publish . '</strong>', $section_title) . '
						</p>
                    </div>
                    <div class="main-search-bar">
                    	<form  action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
                            <div class="col-md-5 col-sm-5 col-xs-12 nopadding">
                               ' . $location . '
                           </div>
                           
						   
                           <div class="col-md-5 col-sm-5 col-xs-12 nopadding">
						   <div class="form-group">
                              	<select data-placeholder="' . esc_html__('Select Business Category', 'dwt-listing') . '" class="custom-select" name="l_category">
								 <option value="">' . esc_html__('Select an option', 'dwt-listing') . '</option>
								  ' . $cats_html . '
								</select>
								</div>
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-12 nopadding">
							   <button class="btn btn-theme btn-block" type="submit">' . esc_html__('Search', 'dwt-listing') . '</button>
                           </div>
                           ' . dwt_listing_form_lang_field_callback(false) . '
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
            	<img class="main-arrow" src="' . $arrow . '" alt="' . esc_html__('dwt-listing', 'dwt-listing') . '">
            	<div class="category-section">
					<div class="category-list1 owl-carousel owl-theme"  id="main-section-slider-2">
						' . $grid_categories . '
					 </div>
				</div>
            </div>
        </div>
    </div>
</div>';
    }

}

/**
 * Hero Three
 */
if (!function_exists('dwt_elementor_hero_three')) {

    function dwt_elementor_hero_three($params) {
        $section_title = $location_repeater = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $event_or_listing = $params['event_or_listing'];

        /* ================ */
        /* Now starat      */
        /* =============== */
        /* form secttion */
        $form_action = dwt_listing_pagelink('dwt_listing_seacrh_page');
        if ($event_or_listing == 'd_events') {
            $form_action = dwt_listing_pagelink('dwt_listing_event_page');
        }



        return '<div class="event-hero-intro for-my-locz">
            <div class="container">
                <div class="text-center">
                    <h1>' . $section_title . ' <span class=""></span> </h1>
                    <p class="lead">' . $section_tag_line . '</p>
                </div>
                <form class="event-hero-intro-search" action="' . esc_attr($form_action) . '">
                   <div class="search_box">
                   <div class="col-md-9 col-sm-9 col-xs-12 nopadding">
                     <input name="by_title" placeholder="' . esc_html__('What are you looking for ?', 'dwt-listing') . '" type="text">
                   </div>
                   <div class="col-md-3 col-sm-3 col-xs-12 nopadding"> 
                     <button class="common-button" onclick="this.form.submit()" type="submit"> ' . esc_html__('Search', 'dwt-listing') . '  <i class="fa fa-search"></i></button>
                   ' . dwt_listing_form_lang_field_callback(false) . '
                    </div> 
                    </div>
                </form>
            </div>
        </div>';
    }

}

/**
 * Hero Four
 */
if (!function_exists('dwt_elementor_hero_four')) {

    function dwt_elementor_hero_four($params) {
        $section_title = $location_repeater = '';

        $section_title = $params['section_title'];
        /* ==== listing form ===== */
        $categories_repeater = $params['form_categories'];
        /* ===== location ===== */
        $google_or_custom = $params['google_or_custom'];
        if ($params['google_or_custom'] == 'custom') {
            $location_repeater = $params['location_repeater'];
        }
        /* ===== grid categories ===== */
        $event_category_repeater = $params['event_categories'];


        /* ================ */
        /* Now starat      */
        /* =============== */

        /* ===== fetch catefories for form ===== */
        $want_to_show = '';
        $cats_html = dwt_listing_return_cats_features($categories_repeater, $want_to_show);

        /* ===== fetch locations ===== */
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
            $location = dwt_listing_return_selective_location($location_repeater);
        }

        /* ==== event categories ===== */
        $grid_categories = $link = '';
        if (isset($event_category_repeater)) {
            $all_cats = $event_category_repeater;
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
                        if (count((array) $fetch_category) == 0)
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



        return '<div class="hero-list-event">
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
                                              ' . dwt_listing_form_lang_field_callback(false) . '
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
                                              ' . dwt_listing_form_lang_field_callback(false) . '
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


/**
 * Hero Five
 */
if (!function_exists('dwt_elementor_hero_five')) {

    function dwt_elementor_hero_five($params) {
        $section_title = $max_tags_limit = '';

        //$bg_img = $params['bg_img'];
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $is_display_tags = $params['is_display_tags'];
        if ($is_display_tags == '1') {
            $max_tags_limit = $params['max_tags_limit'];
        }
        $categories_repeater = $params['form_categories'];

        /* ================ */
        /* Now starat      */
        /* =============== */
        $count_listings = wp_count_posts('listing');

        /* ===== extra spacing ===== */
        $extra_spacing = '=';
        if (dwt_listing_text("dwt_listing_header-layout") == "1") {
            $extra_spacing = 'need-extra-space';
        }

        /* ===== fetch catefories for form ===== */
        $want_to_show = '';
        $cats_html = dwt_listing_return_cats_features($categories_repeater, $want_to_show);

        /* ===== tags ===== */
        $link = $tags = '';
        if ($is_display_tags == '1') {
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


        return '<div class="hero-with-live-search parallex">
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
                                        ' . dwt_listing_form_lang_field_callback(false) . '
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


/**
 * Hero Six
 */
if (!function_exists('dwt_elementor_hero_six')) {

    function dwt_elementor_hero_six($params) {

        $section_title = $location_repeater = $button_one = $button_two = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];

        $btn1_title = $params['btn1_title'];
        $btn1_link = $params['btn1_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        $btn2_title = $params['btn2_title'];
        $btn2_link = $params['btn2_link'];
        $target_two = $params['target_two'];
        $nofollow_two = $params['nofollow_two'];
        $app_img = $params['app_img'];

        /* Buttons with link */
        if ($btn1_title != '' && $btn1_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn1_title, $btn1_link, 'btn btn-theme btn-active');
        }
        if ($btn2_title != '' && $btn2_link != '') {
            $button_two = dwt_elementor_button_link($target_two, $nofollow_two, $btn2_title, $btn2_link, 'btn btn-white btn-theme');
        }

        /* app image */
        $loc_imgz = $static_image = '';
        if (isset($app_img)) {
            if ($app_img) {
                $static_image = dwt_listing_return_img_src($app_img);
            } else {
                $static_image = trailingslashit(get_template_directory_uri()) . 'assets/images/pets.png';
            }
            $loc_imgz = '<img class="img-responsive center-block" src="' . esc_url($static_image) . '" alt="' . esc_html__('image not found', 'dwt-listing') . '">';
        }


        return '<div class="classical-hero">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="hero-content-extra text-center">
                        <h1>' . $section_title . '</h1>
                        <p>' . $section_tag_line . '</p>
                        <ul class="buttons-case">
                           <li>' . $button_one . '</li>
                            <li>' . $button_two . '</li>
                        </ul>
                    </div>
                </div>
            </div>
           ' . $loc_imgz . '
        </div>
    </div>';
    }

}

/**
 * Hero Seven
 */
if (!function_exists('dwt_elementor_hero_seven')) {

    function dwt_elementor_hero_seven($params) {
        $section_title = $button_one = $script = '';


        $section_title = $params['section_title'];
        $form_text = $params['form_text'];
        $section_tag_line = $params['section_tag_line'];
        $section_video = $params['section_video'];
        $btn_title = $params['btn_title'];
        $btn_link = $params['btn_link'];
        $target_one = $params['target_one'];
        $nofollow_one = $params['nofollow_one'];

        if ($section_video != '') {
            wp_enqueue_script('ytPlyer', trailingslashit(get_template_directory_uri()) . 'assets/js/jquery.mb.YTPlayer.min.js', false, false, true);
            $script = '<script>jQuery(document).ready(function () {
			jQuery(".youtube-bg").mb_YTPlayer();
		});</script>';
        }
        /* Buttons with link */
        if ($btn_title != '' && $btn_link != '') {
            $button_one = dwt_elementor_button_link($target_one, $nofollow_one, $btn_title, $btn_link, 'btn btn-theme');
        }


        return $script . '<section class="hero-youtube">
  <div class="video_overlay"></div>
  <a id="video" class="youtube-bg" data-property="{videoURL:\'' . $section_video . '\',containment:\'.hero-youtube\', quality:\'highres\', autoPlay:true, loop:true, showControls: false, startAt:1,  mute:true, opacity: 1, origin: \'' . home_url('/') . '\'}">' . __('Video', 'dwt-listing') . '</a>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12 text-center">
        <h1 class="hero-title">' . $section_title . '<br>
          ' . $form_text . '</h1>
        <p class="hero-tagline">' . $section_tag_line . ' </p>
        ' . $button_one . '
      </div>
    </div>
  </div>
</section>';
    }

}

/**
 * Hero eight
 */
if (!function_exists('dwt_elementor_hero_eight')) {

    function dwt_elementor_hero_eight($params) {
        $section_title = $bg_img = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $categories_repeater = $params['form_categories'];



        $addition_class = '';
        if (dwt_listing_text('dwt_listing_header-layout') == 1) {
            $addition_class = 'with-t-section';
        }

        $style = $bgImageURL = $cats_html = '';
        /* ===== fetch catefories for form ===== */
        $want_to_show = '';
        $cats_html = dwt_listing_return_cats_features($categories_repeater, $want_to_show);



        $tags = '';
        $l_tags = get_terms(array('l_tags'), array('hierarchical' => 1));
        if (!is_wp_error($l_tags) && !empty($l_tags)) {
            foreach ($l_tags as $term) {
                $tags .= '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
            }
        }





        return '<section class="new-hero-explore-section ' . $addition_class . '">
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
                    ' . dwt_listing_form_lang_field_callback(false) . '
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

/**
 * Hero Nine
 */
if (!function_exists('dwt_elementor_hero_nine')) {

    function dwt_elementor_hero_nine($params) {
        $section_title = $bg_img = $form_text = $section_tag_line = $pattern_chk = $section_video = '';

        $form_text = $params['form_text'];
        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $pattern_chk = $params['pattern_chk'];
        if ($pattern_chk == 'yes') {
            $section_video = $params['section_video'];
        }


        $p = $video = $script = $show_pattern = '';
        if (!empty($pattern_chk) && $pattern_chk == 'yes') {
            wp_enqueue_script('ytPlyer', trailingslashit(get_template_directory_uri()) . 'assets/js/jquery.mb.YTPlayer.min.js', false, false, true);
            $script = '<script>jQuery(document).ready(function () {
			jQuery(".youtube-bg").mb_YTPlayer();
		});</script>';
            $p = '';
            $video = '<div class="video_overlay_2"></div>
  <a id="video" class="youtube-bg" data-property="{videoURL:\'' . $section_video . '\',containment:\'.dwt-new-short9\', quality:\'highres\', autoPlay:true, loop:true, showControls: false, startAt:1,  mute:true, opacity: 1, origin: \'' . home_url('/') . '\'}">' . __('Video', 'dwt-listing') . '</a>';
        } else {
            $p = 'parallex';
        }

        $addition_class = '';
        if (dwt_listing_text('dwt_listing_header-layout') == 1) {
            $addition_class = 'with-t-section';
        }

        $cats_html = '';

        return $script . '<section class="dwt-new-short9 ' . $p . ' ' . $addition_class . '">
		' . $video . '
		<div class="container">
    <div class="row">
       <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 text-white text-center">
      <div class="new-hero1">
        <h4>' . esc_attr($form_text) . '</h4>
        <h1>' . esc_attr($section_title) . '</h1>
        <p>' . esc_attr($section_tag_line) . '</p>
        <div class="search-form">
        <form class="custom-style-search" action="' . dwt_listing_pagelink('dwt_listing_seacrh_page') . '">
        <div class="typeahead__container hero9">
            <div class="typeahead__field">
                <div class="typeahead__query">
                    <input  class="for_sp_home dwt-search" placeholder="' . esc_html__('What Are You Looking For?', 'dwt-listing') . '" type="search" autofocus autocomplete="off">
                </div>
                <div class="typeahead__button">
                    <button type="submit">
                        <span class="typeahead__search-icon fa fa-search"></span><span>' . esc_html__('Search', 'dwt-listing') . ' </span>
                    </button>
                </div>
            </div>
        </div>
		<input id="by_title_home" type="hidden" name="by_title" value="">
		<input id="l_category_home" type="hidden" name="l_category" value="">
		<input id="l_tag_home" type="hidden" name="l_tag" value="">
                                            ' . dwt_listing_form_lang_field_callback(false) . '
      </form>
      </div>
      </div>
      </div>
    </div>
  </div>
</section>';
    }

}

/**
 * Hero Ten
 */
if (!function_exists('dwt_elementor_hero_ten')) {

    function dwt_elementor_hero_ten($params) {
        $section_title = $bg_img = $form_text = $section_tag_line = $pattern_chk = $section_video = $location = '';

        $section_title = $params['section_title'];
        $section_tag_line = $params['section_tag_line'];
        $rotating_words = $params['rotating_words'];

        /* ===== location ===== */
        $google_or_custom = $params['google_or_custom'];
        if ($params['google_or_custom'] == 'custom') {
            $location_repeater = $params['location_repeater'];
        }

        $form_action = dwt_listing_pagelink('dwt_listing_seacrh_page');
        $options = explode('|', $rotating_words);
        $options = json_decode(json_encode($options), FALSE);
        wp_localize_script('dwt-listing-custom', 'get_typed', array('type_strings' => $options));

        /* ===== fetch locations ===== */
        if ($google_or_custom == 'google') {
            $check_class = $location_icon = '';
            if (dwt_listing_text('dwt_listing_enable_geo') == '1') {
                $check_class = 'specific-search';
                $location_icon = '<i class="detect-me fa fa-crosshairs loc-icon"></i>';
            }
            dwt_listing_google_locations();
            wp_enqueue_script("google-map-callback");
            $location = '<div class="form-group ' . $check_class . '">
            <label>' . esc_html__('By Street Address', 'dwt-listing') . '</label>
				<input class="form-control street-address" id="address_location" name="street_address" placeholder="' . esc_html__('Location...', 'dwt-listing') . '"  type="text">
				' . $location_icon . '
			  </div>';
        } else {
            $location = dwt_listing_return_selective_location($location_repeater);
        }

        $form_action = dwt_listing_pagelink('dwt_listing_seacrh_page');

        return '<div class="typed-hero-section">
            <form class="custom-style-search" action="' . esc_url($form_action) . '">
                <fieldset>
                    <legend><h1>' . esc_attr($section_title) . '<span class="typed typed-words"></span></h1></legend>
                    <p>' . esc_attr($section_tag_line) . '</p>
                </fieldset>
                <div class="inner-form">
                    <div class="left">
                        <div class="input-wrap first">
                            <div class="input-field first">
                                <label>' . esc_html__('Explore', 'dwt-listing') . '</label>
                                <div class="typeahead__container">
                                    <div class="typeahead__field">
                                        <div class="typeahead__query">
                                            <input class="for_sp_home dwt-search" autocomplete="off" placeholder="' . esc_html__('What are you looking for', 'dwt-listing') . '" value="" type="search">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-wrap second">
                            <div class="input-field second">
                                ' . $location . '
                            </div>
                        </div>
                    </div>
                    <button class="btn-search" type="submit">' . esc_html__('Search', 'dwt-listing') . '</button>
                </div>
                <input id="by_title_home" type="hidden" name="by_title" value="">
                <input id="l_category_home" type="hidden" name="l_category" value="">
                <input id="l_tag_home" type="hidden" name="l_tag" value="">
                ' . dwt_listing_form_lang_field_callback(false) . '
            </form>
        </div>';
    }

}