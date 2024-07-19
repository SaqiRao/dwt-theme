<?php
if (!function_exists('dwt_listing_pakges')) {

    function dwt_listing_pakges() {
        vc_map(array(
            "name" => __("Packages", 'dwt-listing'),
            "base" => "d_packages_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-vc_pie",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('packages.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", 'dwt-listing'),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'dwt-listing'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'dwt-listing') => '',
                        esc_html__('White', 'dwt-listing') => '',
                        esc_html__('Gray', 'dwt-listing') => 'bg-gray',
                        esc_html__('Image', 'dwt-listing') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", 'dwt-listing'),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", 'dwt-listing'),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                    "description" => esc_html__('Title for your section ', 'dwt-listing') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("Basic", 'dwt-listing'),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'dwt-listing'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array
                (
                    'group' => __('Select Package', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'dwt-listing'),
                    'param_name' => 'woo_products',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Select Package", 'dwt-listing'),
                            "param_name" => "product",
                            "admin_label" => true,
                            "value" => dwt_listing_get_packages(),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_pakges');
if (!function_exists('d_packages_base_func')) {

    function d_packages_base_func($atts, $content = '') {
        dwt_listing_submission_disbaled();
        $packages = '';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        if (class_exists('WooCommerce')) {
            $days = dwt_listing_text('d_pkg_daytxt');
            $yes = dwt_listing_text('d_pkg_yes');
            $no = dwt_listing_text('d_pkg_no');
            $tick = '<i class="yes ti-check-box"></i>';
            $cross = '<i class="no ti-close"></i>';
            $never_expire = dwt_listing_text('d_never_exp');
            $unlimited = dwt_listing_text('d_pkg_unlimited');
            if (function_exists('vc_param_group_parse_atts')) {
                $rows = vc_param_group_parse_atts($woo_products);
                $icon = $options_html = $create_event = $allow_coupon_code = $bump_listing = $allow_tags = $business_hours = $price_range = $no_of_images = $website_link = $video_listing = $featured_listing_expiry = $featured_listing = $regular_listing = $package_expiry = $bg_img = '';
                $gey_packtype = '';
                $btn_link = '';
                $make_it_featured = '';
                global $post;
                if (count((array) $rows) > 0) {
                    foreach ($rows as $row) {
                        $make_it_featured = '';
                        $options_html = '';
                        if (isset($row['product']) && $row['product'] != '') {
                            $product = wc_get_product($row['product']);
                            if (isset($product) && $product != '') {
                                $pack_img = $product->get_image_id();
                                $get_woobg = dwt_listing_return_img_src($pack_img);

                                $extra_txt = '';
                                if ($product->get_short_description() != "") {
                                    $extra_txt = '<div class="p-extra-txt">' . $product->get_short_description() . '</div>';
                                }
                                if (get_post_meta($row['product'], 'make_package_featured', true) != "" && get_post_meta($row['product'], 'make_package_featured', true) == 'yes') {

                                    $make_it_featured = "pricing__item--featured";
                                }
                                if (get_post_meta($row['product'], 'package_type', true) != "") {
                                    $gey_packtype = get_post_meta($row['product'], 'package_type', true);
                                }
                                if (get_post_meta($row['product'], 'package_expiry', true) != "") {

                                    $package_expiry = get_post_meta($row['product'], 'package_expiry', true);
                                    if ($package_expiry == '-1') {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_p_exp') . ' : ' . $never_expire . '</li>';
                                    } else {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_p_exp') . ' : ' . esc_attr($package_expiry) . ' ' . $days . '</li>';
                                    }
                                }

                                if (get_post_meta($row['product'], 'regular_listing', true) != "") {
                                    $regular_listing = get_post_meta($row['product'], 'regular_listing', true);
                                    if ($regular_listing == '-1') {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_reg_listing') . ' : ' . $unlimited . '</li>';
                                    } else {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_reg_listing') . ' : ' . esc_attr($regular_listing) . '</li>';
                                    }
                                }
                                if (get_post_meta($row['product'], 'listing_expiry', true) != "") {
                                    $listing_expiry = get_post_meta($row['product'], 'listing_expiry', true);
                                    if ($listing_expiry == '-1') {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_l_exp') . ' : ' . $never_expire . '</li>';
                                    } else {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_l_exp') . ' : ' . esc_attr($listing_expiry) . ' ' . $days . '</li>';
                                    }
                                }
                                if (get_post_meta($row['product'], 'featured_listing', true) != "") {
                                    $featured_listing = get_post_meta($row['product'], 'featured_listing', true);
                                    if ($featured_listing == '-1') {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_listing') . ' : ' . $unlimited . '</li>';
                                    } else {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_listing') . ' : ' . esc_attr($featured_listing) . '</li>';
                                    }
                                }
                                if (get_post_meta($row['product'], 'featured_listing_expiry', true) != "") {
                                    $featured_listing_expiry = get_post_meta($row['product'], 'featured_listing_expiry', true);
                                    if ($featured_listing_expiry == '-1') {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_for') . ' : ' . $never_expire . '</li>';
                                    } else {
                                        $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_feat_for') . ' : ' . esc_attr($featured_listing_expiry) . ' ' . $days . '</li>';
                                    }
                                }
                                if (get_post_meta($row['product'], 'video_listing', true) != "") {
                                    $video_listing = get_post_meta($row['product'], 'video_listing', true);
                                    if ($video_listing == 'yes') {
                                        $yes_or_no = $yes;
                                        $icon = $tick;
                                    } else {
                                        $yes_or_no = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_vid_listing') . ' : ' . esc_attr($yes_or_no) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'website_link', true) != "") {
                                    $website_link = get_post_meta($row['product'], 'website_link', true);
                                    if ($website_link == 'yes') {
                                        $w_link = $yes;
                                        $icon = $tick;
                                    } else {
                                        $w_link = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_web_link') . ' : ' . esc_attr($w_link) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'no_of_images', true) != "") {
                                    $no_of_images = get_post_meta($row['product'], 'no_of_images', true);
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_no_images') . ' : ' . esc_attr($no_of_images) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'price_range', true) != "") {
                                    $price_range = get_post_meta($row['product'], 'price_range', true);
                                    if ($price_range == 'yes') {
                                        $yes_or_no = $yes;
                                        $icon = $tick;
                                    } else {
                                        $yes_or_no = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_p_range') . ' : ' . esc_attr($yes_or_no) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'business_hours', true) != "") {
                                    $business_hours = get_post_meta($row['product'], 'business_hours', true);
                                    if ($business_hours == 'yes') {
                                        $yes_or_no = $yes;
                                        $icon = $tick;
                                    } else {
                                        $yes_or_no = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_b_hours') . ' : ' . esc_attr($yes_or_no) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'allow_tags', true) != "") {
                                    $allow_tags = get_post_meta($row['product'], 'allow_tags', true);
                                    if ($allow_tags == 'yes') {
                                        $yes_or_no = $yes;
                                        $icon = $tick;
                                    } else {
                                        $yes_or_no = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_llow_tag') . ' : ' . esc_attr($yes_or_no) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'bump_listing', true) != "") {
                                    $bump_listing = get_post_meta($row['product'], 'bump_listing', true);
                                    $options_html .= '<li class="pricing-feature"><i class="yes ti-check-box"></i>' . dwt_listing_text('d_bump_listing') . ' : ' . esc_attr($bump_listing) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'allow_coupon_code', true) != "") {
                                    $allow_coupon_code = get_post_meta($row['product'], 'allow_coupon_code', true);
                                    if ($allow_coupon_code == 'yes') {
                                        $yes_or_no = $yes;
                                        $icon = $tick;
                                    } else {
                                        $yes_or_no = $no;
                                        $icon = $cross;
                                    }
                                    $options_html .= '<li class="pricing-feature">' . $icon . '' . dwt_listing_text('d_coupon_code') . ' : ' . esc_attr($yes_or_no) . '</li>';
                                }
                                if (get_post_meta($row['product'], 'create_event', true) != "") {
                                    $create_event = get_post_meta($row['product'], 'create_event', true);
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
                                    if (get_user_meta($uid, 'd_user_package_id', true) != "" && get_user_meta($uid, 'd_user_package_id', true) == $row['product']) {
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
                                                $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['product'] . ' sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                            } else {
                                                //package have regular listings
                                                $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Purchased", 'dwt-listing') . '</button>';
                                            }
                                        } else {
                                            if (get_user_meta($uid, 'd_is_free_pgk', true) == $row['product']) {
                                                $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Used", 'dwt-listing') . '</button>';
                                            } else {
                                                //no regular listings
                                                $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['product'] . ' sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                            }
                                        }
                                    } else {
                                        if (get_user_meta($uid, 'd_is_free_pgk', true) == $row['product']) {
                                            $btn_link = '<button type="button" class="pricing-action my-btn-disabled btn btn-defualt disabled">' . esc_html__("Already Used", 'dwt-listing') . '</button>';
                                        } else {
                                            $btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['product'] . ' sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                        }
                                    }
                                } else {
                                    $btn_link = '<a href="javascript:void(0)"'.' class="pricing-action sonu-button-"'. 'data-toggle="modal" data-target="#myModal"' .  $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') .' </a>';

                                    //$btn_link = '<a href="javascript:void(0)" class="pricing-action sonu-button-' . $row['product'] . ' sb_add_cart" data-product-id="' . $row['product'] . '" data-product-qty="1"  data-package-type="' . $gey_packtype . '" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> ' . esc_html__("Processing...", 'dwt-listing') . '">' . esc_html__("Choose plan", 'dwt-listing') . ' </a>';
                                }

                                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                    $btn_link = '<a href="javascript:void(0)" class="pricing-action">' . esc_html__("Disable for Demo", 'dwt-listing') . ' </a>';
                                } else {
                                    $btn_link = $btn_link;
                                }

                                $price_label  =  $product->get_price();
                                $woo_commerece_label = get_woocommerce_currency_symbol();
                                $tag_line= get_the_title($row['product']);

                            if($price_label == 0 || $price_label == ""){

                                $price_label   =   esc_html__( 'Free', 'dwt-listing');
                                $woo_commerece_label = esc_html__('');
                                $tag_line = esc_html__('a ');
                                print_r($tag_line);
                            }

                                


                                $bg_img = ( $get_woobg != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $get_woobg . ') center bottom no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
                                $packages .= '<div class="pricing-item ' . $make_it_featured . '">
                                <div class="pricing-deco" ' . $bg_img . '>
                                    <svg class="pricing-deco-img" enable-background="new 0 0 300 100" height="100px"  preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" y="0px">
                                    <path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729&#x000A;	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
                                    <path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729&#x000A;	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
                                    <path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716&#x000A;	H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
                                    <path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428&#x000A;	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
                                    </svg>
                                    <div class="pricing-price"><span class="pricing-currency">' . $woo_commerece_label . '</span>' . $price_label. '
                                    </div>
                                    <h3 class="pricing-title">' . get_the_title($row['product']) . '</h3>
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
            }

            return '<section class="pricing-table ' . $class . ' ' . $bg_color . '" ' . $style . '>
				<div class="container">
					<div class="row">
						' . $header . '
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="pricing pricing-palden">
									' . $packages . '
								</div>	
							</div>
						</div>
					</div>
			</section>';
        }
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_packages_base', 'd_packages_base_func');
}