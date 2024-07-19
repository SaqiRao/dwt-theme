<?php
/* DWT Listing logo */
if (!function_exists('dwt_listing_site_logo')) {

    function dwt_listing_site_logo($header_logo_type = 1, $logo_type = '')
    {
        $logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo-white.png';
        global $dwt_listing_options;
        if (isset($dwt_listing_options["dwt_listing_logo"]["url"]) && $dwt_listing_options["dwt_listing_logo"]["url"] != "") {
            $logo = $dwt_listing_options["dwt_listing_logo"]["url"];
        }
        if (isset($dwt_listing_options["dwt_listing_logo-transparent"]["url"]) && $dwt_listing_options["dwt_listing_logo-transparent"]["url"] != "" && $logo_type == 'transparent') {
            $logo = $dwt_listing_options["dwt_listing_logo-transparent"]["url"];
        }

        $class_name = ($header_logo_type == 2) ? 'header-top-logo' : 'menu-logo';
        return '<ul class="' . esc_attr($class_name) . '">
		  <li> <a href="' . esc_url(home_url("/")) . '"> 
			<img src="' . esc_url($logo) . '" alt="' . __("logo", "dwt-listing") . '" class="img-responsive"> </a> 
		   </li>
		</ul>';
    }

}

/* DWT Listing get header data */
if (!function_exists('dwt_listing_site_header')) {

    function dwt_listing_site_header()
    {
        global $dwt_listing_options;
        $my_url = '';
        $layout = 1;
        if (isset($dwt_listing_options["dwt_listing_header-layout"])) {
            $layout = $dwt_listing_options["dwt_listing_header-layout"];
        }

        if (isset($layout) && $layout == '1') {
            echo get_template_part('template-parts/header/header', 1);
        } else if (isset($layout) && $layout == '2') {
            echo get_template_part('template-parts/header/header', 2);
        } else if (isset($layout) && $layout == '3') {
            echo get_template_part('template-parts/header/header', 3);
        } else if ($layout == '5' && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            elementor_theme_do_location('header');
        } else {
            echo get_template_part('template-parts/header/header', 4);
        }

    }

}


/* DWT Listing site spinner */
if (!function_exists('dwt_listing_site_spinner')) {

    function dwt_listing_site_spinner()
    {
        global $dwt_listing_options;
        $spinner_html = '';
        if (isset($dwt_listing_options["dwt_listing_site-spinner"]) && $dwt_listing_options["dwt_listing_site-spinner"] == "1") {
            $logo = trailingslashit(get_template_directory_uri()) . 'assets/images/loader.gif';
            if (isset($dwt_listing_options["dwt_listing_spinner-logo"])) {
                $logo = $dwt_listing_options["dwt_listing_spinner-logo"]["url"];
            }
            $spinner_text = $dwt_listing_options["dwt_listing_spinner-text"];
            $text = ($spinner_text != "") ? $spinner_text : __("Please Wait", "dwt-listing");
            $spinner_html = '<div id="spinner"><div class="spinner-img"> <img alt="' . esc_attr($text) . '" src="' . esc_url($logo) . '" /><h2>' . esc_html($text) . '</h2></div></div>';
        }
        echo $spinner_html;
    }

}
/* DWT Listing Header Button */
if (!function_exists('dwt_listing_header_btn')) {

    function dwt_listing_header_btn($class = 'post-btn')
    {
        global $dwt_listing_options;
        $btn_html = '';
        if (dwt_listing_text('dwt_listing_disable_submission') == '1') {
            $btn_text = __("Add Listing", "dwt-listing");
            $btn_link = '#';
            $btn_html = '';
            if (isset($dwt_listing_options["dwt_listing_header-btn"]) && $dwt_listing_options["dwt_listing_header-btn"] == "1") {
                $btn_text = $dwt_listing_options["dwt_listing_header-text"];
                $btn_link = $dwt_listing_options["dwt_listing_header-page"];
                $btn_html = '<li class="' . esc_attr($class) . '"><a href="' . esc_url(get_the_permalink($btn_link)) . '"><i class="fa fa-plus"></i>' . esc_html($btn_text) . '</a></li>';
            }
        }
        if (dwt_listing_text('dwt_listing_disable_submission') == '0') {
            $btn_text = esc_html__("View All Listing", "dwt-listing");
            $btn_link = '#';
            $btn_html = '';
            $btn_text = $dwt_listing_options["dwt_listing_disable_header_text"];
            $btn_link = $dwt_listing_options["dwt_listing_disable_after_page"];
            $btn_html = '<li class="' . esc_attr($class) . '"><a href="' . esc_url(get_the_permalink($btn_link)) . '"><i class="fa fa-plus"></i>' . esc_html($btn_text) . '</a></li>';
        }
        return $btn_html;
    }

}

/* DWT Listing Header Button */
if (!function_exists('dwt_listing_header_profile_menu')) {

    function dwt_listing_header_profile_menu($type = 1)
    {
        global $dwt_listing_options;
        $default = '';
        $default = dwt_listing_get_user_dp(get_current_user_id(), 'dwt_listing_user-dp');
        //Dynamic name here
        $username = __("User name", "dwt-listing");
        /* Listing Button */
        $btn_class = ($type == 3) ? "ad-listing-btn" : "post-btn";
        $listing_button = dwt_listing_header_btn($btn_class);
        $profile_html = $login_btn = $register_btn = '';
        /* Profile Link */
        $profile_link = '';
        if (isset($dwt_listing_options['dwt_listing_profile-page']) && $dwt_listing_options['dwt_listing_profile-page'] != ""):
            $profile_text = esc_html__("My Profile", "dwt-listing");

            $listing_update_url = '';
            //$listing_update_url = dwt_listing_set_url_param(get_the_permalink($dwt_listing_options['dwt_listing_profile-page']), 'listing-type', 'dashboard');
            $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink($dwt_listing_options['dwt_listing_profile-page']), array('listing-type' => 'dashboard'));

            $profile_link = '<li><a href="' . esc_url(dwt_listing_page_lang_url_callback($listing_update_url)) . '"><i class="ti-user"></i>' . $profile_text . '</a></li>';
        endif;
        if (is_user_logged_in()) {
            //check if plugin is activated
            // $chat_option = isset($dwt_listing_options['enable_chat_option']) ? $dwt_listing_options['enable_chat_option'] : ""; 
            // $listing_update_url = 'localhost/dwt/profile/?listing-type=chat-dashboard';
            // $notification = '';
            // if($chat_option)
            // {
            //     $notification ='<li><a href="'.esc_url(dwt_listing_page_lang_url_callback($listing_update_url)).'"><i class="lnr lnr-user"></i> <span>'.esc_html__("Notifications", 'dwt-listing').' <span id="notify">(0)</span></span></a></li>';
            // }
            
            
            if (in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))) && $dwt_listing_options["dwt_listing_profile-dashboard"] == "1") :
                $logout_btn = '<li><a href="' . wp_logout_url(home_url('/')) . '"><i class="ti-power-off"></i>' . esc_html__('Logout', 'dwt-listing') . '</a></li>';
                $profile_html .= '<li class="dropdown profile-dropdown">
								<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
									<img class="resize" alt="' . esc_attr($username) . '" src="' . esc_url($default) . '"> 
								 </a>
							<ul class="dropdown-menu">
								' . $profile_link . '
                                <li role="separator" class="divider"></li>
							' . $logout_btn . '</ul></li>';
            endif;
        } else {
            if (dwt_listing_text('dwt_listing_header-layout') == '4') {
                $login_btn = '<li class="logged"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><i class="fa fa-unlock"></i></a> </li>';
            } else {
                $login_btn = '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"> ' . esc_html__('Login', 'dwt-listing') . '</a> </li>';
            }
        }
        //$profile_html = '';
        return $profile_html . $login_btn . $listing_button;
    }

}

/* DWT Listing logo */
if (!function_exists('dwt_listing_site_footer_logo')) {

    function dwt_listing_footer_logo()
    {
        global $dwt_listing_options;
        $logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo-white.png';
        if (isset($dwt_listing_options["dwt_listing_footer-logo"]["url"]) && $dwt_listing_options["dwt_listing_footer-logo"]["url"] != "") {
            $logo = $dwt_listing_options["dwt_listing_footer-logo"]["url"];
        }
        return '<img src="' . esc_url($logo) . '" alt="' . __("logo", "dwt-listing") . '" class="img-responsive" />';
    }

}

/* Footer Function Goes Here */
if (!function_exists('dwt_listing_site_footer')) {

    function dwt_listing_site_footer()
    {
        $layout = 4;
        global $dwt_listing_options;
        if (isset($dwt_listing_options["dwt_listing_footer-layout"])) {
            $layout = $dwt_listing_options["dwt_listing_footer-layout"];
        }
        if (in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

            if ($layout == '5' && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                elementor_theme_do_location('footer');
            } else if (is_page_template('page-search.php') && is_page()) {
                if (isset($dwt_listing_options['dwt_listing_seacrh_page']) && $dwt_listing_options['dwt_listing_seacrh_page'] != "") {
                    if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
                        if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                            echo get_template_part('template-parts/footer/footer', $layout);
                        } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
                            echo get_template_part('template-parts/footer/footer', $layout);
                        } else {
                            // no footer for map
                        }
                    } else {
                        echo get_template_part('template-parts/footer/footer', $layout);
                    }
                }
            } else if (is_page_template('page-events.php') && is_page()) {
                if (dwt_listing_text('dwt_listing_event_layout') == 'map') {
                    //no footer
                } else {
                    echo get_template_part('template-parts/footer/footer', $layout);
                }
            } else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
                //for listings search
                if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                    echo get_template_part('template-parts/footer/footer', $layout);
                } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
                    echo get_template_part('template-parts/footer/footer', $layout);
                } else {
                    //no breadcrum on map
                }
            } else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
                //for event search
                if (dwt_listing_text('dwt_listing_event_layout') == 'topbar') {
                    echo get_template_part('template-parts/footer/footer', $layout);
                } else {
                    //no breadcrum on map
                }
            } else {
                echo get_template_part('template-parts/footer/footer', $layout);
            }
        } else {
            echo get_template_part('template-parts/footer/footer', $layout);

        }
    }

}


if (!function_exists('dwt_listing_footer_link')) {

    function dwt_listing_footer_link()
    {
        global $dwt_listing_options;
        $link_html = '';
        if (isset($dwt_listing_options["dwt_listing_footer-pages"])) {
            $pages = $dwt_listing_options["dwt_listing_footer-pages"];
            if (is_array($pages) && count($pages) > 0) {
                foreach ($pages as $page) {
                    $page = dwt_listing_language_page_id_callback($page);
                    $link_html .= '<li><a href="' . esc_url(get_the_permalink($page)) . '">' . esc_attr(get_the_title($page)) . '</a></li>';
                }
            }
        }
        return $link_html;
    }

}


if (!function_exists('dwt_listing_footer_copyrights')) {

    function dwt_listing_footer_copyrights()
    {
        global $dwt_listing_options;
        $site_title = get_bloginfo('name');
        $home_link = home_url("/");
        $copyrights_text = '&copy; ' . esc_html__("Copyright", "dwt-listing") . ' ' . date("Y") . ' | ' . esc_html__("All Rights Reserved", "dwt-listing") . ' ' . '<a href="' . esc_url($home_link) . '"> | ' . esc_html($site_title) . '</a>';

        if (isset($dwt_listing_options["dwt_listing_footer-copyrights"])) {
            $copyrights_text = __($dwt_listing_options["dwt_listing_footer-copyrights"], "dwt-listing");
        }
        return $copyrights_text;
    }

}

if (!function_exists('dwt_listing_footer_posts')) {

    function dwt_listing_footer_posts()
    {
        $link_html = '';
        global $dwt_listing_options;
        if (isset($dwt_listing_options["dwt_listing_footer-posts"])) {
            $posts = $dwt_listing_options["dwt_listing_footer-posts"];
            if (count((array)$posts) > 0) {
                foreach ($posts as $post) {

                    $title = get_the_title($post);

                    $link = get_the_permalink($post);
                    $thumbnail = get_the_post_thumbnail($post, 'thumbnail', array('class' => ''));
                    $link_html .= '<li>
                   <span><a class="plus" href="' . esc_url($link) . '">' . $thumbnail . '<i>+</i></a></span>
                   <p><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></p>
                ' . get_the_date(get_option('date_format'), $post) . '
                </li>';
                }
            }
        }
        return $link_html;
    }

}

if (!function_exists('dwt_listing_social_icons')) {

    function dwt_listing_social_icons($option_key = '')
    {
        global $dwt_listing_options;
        $social_icons = array(
            'Facebook' => 'fa fa-facebook', 
            'Twitter' => 'fa fa-twitter ', 
            'Linkedin' => 'fa fa-linkedin ', 
            'Google' => 'fa fa-google-plus', 
            'YouTube' => 'fa fa-youtube-play', 
            'Vimeo' => 'fa fa-vimeo ',
            'TikTok' => 'fa fa-tiktok' , 
            'Pinterest' => 'fa fa-pinterest ', 
            'Tumblr' => 'fa fa-tumblr ', 
            'Instagram' => 'fa fa-instagram', 
            'Reddit' => 'fa fa-reddit ', 
            'Flickr' => 'fa fa-flickr ', 
            'StumbleUpon' => 'fa fa-stumbleupon', 
            'Delicious' => 'fa fa-delicious ', 
            'dribble' => 'fa fa-dribbble ', 
            'behance' => 'fa fa-behance', 
            'DeviantART' => 'fa fa-deviantart',


        );
        $li_html = '';
        if (isset($dwt_listing_options[$option_key])) {
            $icons = $dwt_listing_options[$option_key];

            if (isset($icons) && count((array)$icons) > 0) {
                foreach ($icons as $key => $val) {
                    $fa_value = $social_icons[$key];
                    if ($fa_value != "" && $val != "") {
                        $li_html .= '<li><a href="' . esc_url($val) . '"><i class="' . esc_attr($fa_value) . '"></i></a></li>';
                    }
                }
            }
        }
        return $li_html;
    }

}


if (!function_exists('dwt_listing_themeOptions')) {

    function dwt_listing_themeOptions($param1 = '', $param2 = '', $vaidate = false)
    {
        global $dwt_listing_options;
        $data = '';
        if ($param1 != "") {
            $data = $dwt_listing_options["$param1"];
        }
        if ($param1 != "" && $param2 != "") {
            $data = $dwt_listing_options["$param1"]["$param2"];
        }
        if ($vaidate == true)
            $data = (isset($data) && $data) ? 1 : 0;
        return $data;
    }

}


/* Enqueue scrips and styles */
if (!function_exists('dwt_listing_enqueue_sticky_script')) {

    function dwt_listing_enqueue_sticky_script()
    {
        global $dwt_listing_options;
        if (isset($dwt_listing_options["dwt_listing_sticky-header"]) && $dwt_listing_options["dwt_listing_sticky-header"] == true) {
            wp_add_inline_script('dwt-listing-custom', '$("#menu-1, #menu-2, #menu-3").megaMenu({ sticky_header : true, });');
        }
        if (isset($dwt_listing_options["dwt_listing_footer-bg1"])) {
            $layout = $dwt_listing_options["dwt_listing_footer-layout"];
            $layout = ($layout != "") ? $layout : '';
            $custom_css = '';
            if ($layout == 1) {
                $custom_css = 'footer';
                $style_data = dwt_listing_getBGImageStyle('dwt_listing_footer-bg1');
                $style_css = "
                $custom_css{
                       {$style_data};
                }";
                wp_add_inline_style('dwt-listing-custom', $style_css);
            }
            if ($layout == 2) {
                $custom_css = '.footer';
            }
            if ($layout == 3) {
                $custom_css = 'footer.footer-3';
            }

            if ($custom_css != "") {

            }
        }
    }

}


add_action('wp_enqueue_scripts', 'dwt_listing_enqueue_sticky_script');


if (!function_exists('dwt_listing_getBGImageStyle')) {

    function dwt_listing_getBGImageStyle($optname = '')
    {
        global $dwt_listing_options;
        if ($optname == '')
            return '';
        $style = '';
        if (isset($dwt_listing_options[$optname])) {

            $bg_size = '';
            $bg_attachment = '';
            $bg_repeat = '';
            $bg_position = '';
            $bgarea = $dwt_listing_options[$optname];
            $style = '';
            if (isset($bgarea['background-color']) && $bgarea['background-color'] != "") {
                $style .= ' background: ' . $bgarea['background-color'] . ' !important;';
            }
            if (isset($bgarea['background-image']) && $bgarea['background-image'] != "") {
                $bg_size = $bgarea['background-size'];
                $bg_attachment = $bgarea['background-attachment'];
                $bg_repeat = $bgarea['background-repeat'];
                $bg_position = $bgarea['background-position'];
                $style .= ' background: url(' . $bgarea['background-image'] . ') !important; ';
                $style .= ' background-repeat: ' . $bg_repeat . ' !important;';
                $style .= ' background-size: ' . $bg_size . ' !important; ';
                $style .= ' background-position: ' . $bg_position . ' !important; ';
                $style .= ' background-attachment: ' . $bg_attachment . ' !important; ';
            }
            $style .= '';
        }
        return $style;
    }

}


if (!function_exists('dwt_listing_site_breadcrumb')) {

    function dwt_listing_site_breadcrumb()
    {
        global $dwt_listing_options;

        if (in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            //For transparent header only
            if (isset($dwt_listing_options['dwt_listing_header-layout']) && $dwt_listing_options['dwt_listing_header-layout'] == '1') {
                if (is_singular('listing')) {
                    if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
                        //no bread minimal
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', 'elegent');
                    } else if (dwt_listing_text('dwt_listing_lp_style') == 'minimal') {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', 'minimal');
                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing', 'bread');
                    }
                } else if (is_author()) {
                    get_template_part('template-parts/breadcrumb/bread', 'crumb-dashboard');
                } else if (is_page_template('page-search.php') && is_page()) {
                    //for search page with transparent header
                    if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
                        if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                            get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                        } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
                            get_template_part('template-parts/breadcrumb/bread', 'crumb-search');
                        } else {
                            //no breadcrum on map
                        }
                    } else {
                        get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                    }
                } else if (is_page_template('page-events.php') && is_page()) {
                    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {

                    } else {
                        get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                    }
                } else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
                    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                        get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                    } else if (dwt_listing_text('dwt_listing_seacrh_layout') == 'topbar') {
                        get_template_part('template-parts/breadcrumb/bread', 'crumb-search');
                    } else {
                        //no breadcrum on map
                    }
                } else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
                    //for event search
                    if (dwt_listing_text('dwt_listing_event_layout') == 'topbar') {
                        get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                    } else {
                        //no breadcrum on map
                    }
                } else {
                    get_template_part('template-parts/breadcrumb/bread', 'crumb-before');
                }
            } else if (isset($dwt_listing_options['dwt_listing_header-layout']) && $dwt_listing_options['dwt_listing_header-layout'] == '2') {
                if (is_singular('listing')) {
                    if (dwt_listing_text('dwt_listing_lp_style') == 'minimal') {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', 'minimal');
                    } else {
                        //no breadcrum on single listing
                    }
                } else if (is_page_template('page-search.php') && is_page()) {
                    if (isset($dwt_listing_options['dwt_listing_seacrh_page']) && $dwt_listing_options['dwt_listing_seacrh_page'] != "" && is_page()) {
                        //for search page with transparent header
                        if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
                            if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                                get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                            } else {
                                //no breadcrum on map
                            }
                        } else {
                            get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                        }
                    }
                } else if (is_page_template('page-events.php') && is_page()) {
                    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {

                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                    }
                } else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
                    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                    } else {
                        //no breadcrum on map
                    }
                } else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
                    //for event search
                    if (dwt_listing_text('dwt_listing_event_layout') == 'topbar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                    } else {
                        //no breadcrum on map
                    }
                } else {
                    get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'two');
                }
            } else if (isset($dwt_listing_options['dwt_listing_header-layout']) && $dwt_listing_options['dwt_listing_header-layout'] == '3') {
                if (is_singular('listing')) {
                    if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
                        //no bread
                    } else if (dwt_listing_text('dwt_listing_lp_style') == 'minimal') {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', 'minimal');
                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type-three', 'single');
                    }
                } else if (is_page_template('page-search.php') && is_page()) {
                    if (isset($dwt_listing_options['dwt_listing_seacrh_page']) && $dwt_listing_options['dwt_listing_seacrh_page'] != "" && is_page()) {
                        //for search page with transparent header
                        if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
                            if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                                get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                            } else {
                                //no breadcrum on map
                            }
                        } else {
                            get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                        }
                    }
                } else if (is_page_template('page-events.php') && is_page()) {
                    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {

                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                    }
                } else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
                    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                    } else {
                        //no breadcrum on map
                    }
                } else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
                    //for event search
                    if (dwt_listing_text('dwt_listing_event_layout') == 'topbar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                    } else {
                        //no breadcrum on map
                    }
                } else {
                    get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'three');
                }
            } else if (isset($dwt_listing_options['dwt_listing_header-layout']) && $dwt_listing_options['dwt_listing_header-layout'] == '4') {
                if (is_singular('listing')) {
                    if (dwt_listing_text('dwt_listing_lp_style') == 'elegent') {
                        //no bread minimal
                    } else if (dwt_listing_text('dwt_listing_lp_style') == 'minimal') {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', 'minimal');
                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/transparent/listing-bread', '4');
                    }
                } else if (is_page_template('page-search.php') && is_page()) {
                    if (isset($dwt_listing_options['dwt_listing_seacrh_page']) && $dwt_listing_options['dwt_listing_seacrh_page'] != "" && is_page()) {
                        //for search page with transparent header
                        if (get_page_template_slug($dwt_listing_options['dwt_listing_seacrh_page']) == get_page_template_slug(get_the_ID())) {
                            if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                                get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                            } else {
                                //no breadcrum on map
                            }
                        } else {
                            get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                        }
                    }
                } else if (is_page_template('page-events.php') && is_page()) {
                    if (dwt_listing_text('dwt_listing_event_layout') == 'map') {

                    } else {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                    }
                } else if (is_tax(array('l_category', 'l_tags', 'l_location'))) {
                    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'sidebar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                    } else {
                        //no breadcrum on map
                    }
                } else if (is_tax(array('l_event_cat', 'l_event_tags'))) {
                    //for event search
                    if (dwt_listing_text('dwt_listing_event_layout') == 'topbar') {
                        get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                    } else {
                        //no breadcrum on map
                    }
                } else {
                    get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
                }
            }
        } else {
            get_template_part('template-parts/listing-detial/breadcrumb/solid/bread-type', 'four');
        }
    }

}


/* DWT Listing Registration */
if (!function_exists('dwt_listing_authorization')) {

    function dwt_listing_authorization()
    {
        global $dwt_listing_options;
        if (!is_user_logged_in()):
            get_template_part('template-parts/registration/registration', 'login');
        endif;
    }

}

/* Auth Messages */
if (!function_exists('dwt_listing_get_auth_messages')) {

    function dwt_listing_get_auth_messages($type = '')
    {
        global $dwt_listing_options;
        $message = '';
        if ($type == 'warning') {
            $class = 'class="alert custom-alert custom-alert--warning none"';
        }

        $message = '<div id="info-messages" ' . $class . ' role="alert">
          			<div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
            <div class="custom-alert__body">
              <h6 class="custom-alert__heading">
               ' . esc_html__('Email already exists', 'dwt-listing') . '
              </h6>
              <div class="custom-alert__content">
                ' . esc_html__("Email already exist, please try other one.", 'dwt-listing') . '
              </div>
            </div>
          </div>
        		</div>';

        return $message;
    }

}

/* Auth Messages */
if (!function_exists('dwt_listing_essential_inputs')) {

    function dwt_listing_essential_inputs()
    {
        global $dwt_listing_options;
        get_template_part('template-parts/essential-inputs/footer', 'inputs');
    }

}

/* DWT Listing Registration */
if (!function_exists('dwt_listing_verification_logic')) {

    function dwt_listing_verification_logic()
    {
        global $dwt_listing_options;
        get_template_part('template-parts/verification/verification', 'logic');
    }

}

//Get Template Slug
if (!function_exists('dwt_listing_pagelink')) {

    function dwt_listing_pagelink($get_data, $text = "")
    {
        global $dwt_listing_options;
        if (isset($dwt_listing_options[$get_data]) && $dwt_listing_options[$get_data] != ""):
            return esc_url(get_the_permalink($dwt_listing_options[$get_data]));
        else:
            return home_url('/');
        endif;
    }

}
if (!function_exists('dwt_listing_transparent_bread')) {

    function dwt_listing_transparent_bread()
    {
        global $dwt_listing_options;
        $user_cover = trailingslashit(get_template_directory_uri()) . 'assets/images/collage.jpg';
        if (isset($dwt_listing_options['dwt_listing_header-bg']) && $dwt_listing_options['dwt_listing_header-bg'] != "") {
            $custom_css = '';
            $custom_css = '.transparent-breadcrumb-listing';
            $style_data = dwt_listing_getBGImageStyle('dwt_listing_header-bg');
            $style_css = "
				$custom_css{
					   {$style_data};
				}";
            wp_add_inline_style('dwt-listing-custom', $style_css);
        }
    }

    add_action('wp_enqueue_scripts', 'dwt_listing_transparent_bread');
}


//Get Template Slug
if (!function_exists('dwt_listing_text')) {

    function dwt_listing_text($get_text)
    {
        global $dwt_listing_options;
        if (isset($dwt_listing_options[$get_text]) && $dwt_listing_options[$get_text] != ""):
            return $dwt_listing_options[$get_text];
        else:
            return '';
        endif;
    }

}


if (!function_exists('dwt_listing_fetch_listing_gallery')) {

    function dwt_listing_fetch_listing_gallery($listing_id)
    {
        //$results= array();  
        global $dwt_listing_options;
        $re_order = get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true);
        if ($re_order != "") {
            return explode(',', $re_order);
        } 
        else {
            global $wpdb;
            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $listing_id . "'";
            $results = $wpdb->get_results($query, OBJECT);
            return $results;
        }
    }

}



// Return media
if (!function_exists('dwt_listing_return_listing_idz')) {

    function dwt_listing_return_listing_idz($media, $thumbnail_size)
    {
        global $dwt_listing_options;
        if (count((array)$media) > 0) {
            $i = 1;
            foreach ($media as $m) {
                if ($i > 1)
                    break;
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                if (wp_attachment_is_image($mid)) {
                    $image = wp_get_attachment_image_src($mid, $thumbnail_size);
                    return $image[0];
                } else {
                    return $dwt_listing_options['dwt_listing_defualt_listing_image']['url'];
                }
            }
        } else {
            return $dwt_listing_options['dwt_listing_defualt_listing_image']['url'];
        }
    }

}


//Return Listing is Featured
if (!function_exists('dwt_listing_is_listing_featured')) {

    function dwt_listing_is_listing_featured($listing_id, $style = '')
    {
        //getting listing status
        if (get_post_meta($listing_id, 'dwt_listing_is_feature', true) == '1' && get_post_meta($listing_id, 'dwt_listing_listing_status', true) == '1') {
            if ($style) {
                return '<div class="featured-ribbon"><span>' . esc_html__('Featured', 'dwt-listing') . '</span></div>';
            } else {
                return "<span class='business-status'> " . esc_html__('Featured', 'dwt-listing') . "</span>";
            }
        }
    }

}

//Mark as Featured Listing
if (!function_exists('dwt_listing_mark_listing_featured')) {

    function dwt_listing_mark_listing_featured($listing_id)
    {
        ?>
        <div class="sticky-button-feature">
            <?php
            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                echo '<a href="javascript:void(0)" class="btn-confirmz tool-tip" title=" ' . esc_html__('Disable for Demo', 'dwt-listing') . '">' . esc_html__('Mark As Featured', 'dwt-listing') . '</a>';
            } else {
                ?>
                <a class="btn-confirm sonu-button"
                   data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"
                   href="javascript::void(0)"
                   data-id="<?php echo esc_attr($listing_id); ?>"><?php echo esc_html__('Mark As Featured', 'dwt-listing'); ?></a>
            <?php } ?>
        </div>
        <?php
    }

}

// DWT Listing Js Static Strings
if (!function_exists('dwt_listing_static_strings')) {

    function dwt_listing_static_strings()
    {
        global $dwt_listing_options;
        $user_pic = trailingslashit(get_template_directory_uri()) . 'assets/images/users/defualt.jpg';
        if (isset($dwt_listing_options['dwt_listing_user-default-image']['url']) && $dwt_listing_options['dwt_listing_user-default-image']['url'] != "") {
            $user_pic = $dwt_listing_options['dwt_listing_user-default-image']['url'];
        }
        $show_msg = $my_val = 0;
        if (dwt_listing_text('gmap_api_key') != "") {
            $my_val = 1;
        }
        if (isset($_REQUEST['redirect']) && $_REQUEST['redirect'] == true) {
            $show_msg = 1;
        }
        wp_localize_script(
            'dwt-listing-custom', // name of js file
            'get_strings', array(
                'confirmation' => esc_html__('Confirmation!', 'dwt-listing'),
                'congratulations' => esc_html__('Congratulations!', 'dwt-listing'),
                'payout_sent' => esc_html__('Payout Request Sent!', 'dwt-listing'),
                'no_business_hrs' => esc_html__('No Business Hours Available!', 'dwt-listing'),
                'reservation_created' => esc_html__('Reservation created Succefully!', 'dwt-listing'),
                'amount_is_greater' => esc_html__('Requested Amount is greater than amount available in Wallet!', 'dwt-listing'),
                'Back' => esc_html__('Back!', 'dwt-listing'),
                'fil_checkbox' => __('Please check atleast one checkbox.', 'dwt-listing'),
                'miss' => esc_html__('We will miss you!', 'dwt-listing'),
                'content' => esc_html__('Are you sure you want to do this?', 'dwt-listing'),
                'del' => esc_html__('Are you sure you want to delete your account?', 'dwt-listing'),
                'acn_deleted' => esc_html__('Your account have been deleted.', 'dwt-listing'),
                'admin_cant' => esc_html__('You can not delete your account as Admin.', 'dwt-listing'),
                'expiry' => esc_html__('Really want to expire this listing?', 'dwt-listing'),
                'event_expiry' => esc_html__('Are you sure you want to expire this event?', 'dwt-listing'),
                'event_reactive' => esc_html__('Are you sure you want to reactive this event?', 'dwt-listing'),
                'ok' => esc_html__('Yes', 'dwt-listing'),
                'cancle' => esc_html__('Cancel', 'dwt-listing'),
                'canclelisting' => esc_html__('Cancel', 'dwt-listing'),
                'showlisting' => esc_html__('Show Listing', 'dwt-listing'),
                'whoops' => esc_html__('Whoops!', 'dwt-listing'),
                'thanks' => esc_html__('Thank You!', 'dwt-listing'),
                'one' => esc_html__('One Star', 'dwt-listing'),
                'two' => esc_html__('Two Stars', 'dwt-listing'),
                'three' => esc_html__('Three Stars', 'dwt-listing'),
                'four' => esc_html__('Four Stars', 'dwt-listing'),
                'five' => esc_html__('Five Stars', 'dwt-listing'),
                'views' => esc_html__('Total Views', 'dwt-listing'),
                'webclick' => esc_html__('Website Clicks', 'dwt-listing'),
                'contactclick' => esc_html__('Contact Clicks', 'dwt-listing'),
                'total' => esc_html__('Total Leads', 'dwt-listing'),
                'pricing' => esc_html__('Select Pricing Criteria', 'dwt-listing'),
                'rated' => esc_html__('Rated As', 'dwt-listing'),
                'location' => esc_html__('Select From Location', 'dwt-listing'),
                'status' => esc_html__('Open or Closed', 'dwt-listing'),
                'kilometer' => esc_html__('Km', 'dwt-listing'),
                'newsletter_success' => esc_html__('Thank you, we will get back to you.', 'dwt-listing'),
                'redirecting_success' => esc_html__('Proceeding to Checkout.', 'dwt-listing'),
                'redirecting_error' => esc_html__('You are Not Logged In.', 'dwt-listing'),
                'newsletter_error' => esc_html__('There is some error, please check your API-KEY and LIST-ID.', 'dwt-listing'),
                'lcreated' => esc_html__('Listing created successfully.', 'dwt-listing'),
                'lupdated' => esc_html__('Listing updated successfully.', 'dwt-listing'),
                'Sunday' => __('Sunday', 'dwt-listing'),
                'Monday' => __('Monday', 'dwt-listing'),
                'Tuesday' => __('Tuesday', 'dwt-listing'),
                'Wednesday' => __('Wednesday', 'dwt-listing'),
                'Thursday' => __('Thursday', 'dwt-listing'),
                'Friday' => __('Friday', 'dwt-listing'),
                'Saturday' => __('Saturday', 'dwt-listing'),
                'Sun' => __('Sun', 'dwt-listing'),
                'Mon' => __('Mon', 'dwt-listing'),
                'Tue' => __('Tue', 'dwt-listing'),
                'Wed' => __('Wed', 'dwt-listing'),
                'Thu' => __('Thu', 'dwt-listing'),
                'Fri' => __('Fri', 'dwt-listing'),
                'Sat' => __('Sat', 'dwt-listing'),
                'Su' => __('Su', 'dwt-listing'),
                'Mo' => __('Mo', 'dwt-listing'),
                'Tu' => __('Tu', 'dwt-listing'),
                'We' => __('We', 'dwt-listing'),
                'Th' => __('Th', 'dwt-listing'),
                'Fr' => __('Fr', 'dwt-listing'),
                'Sa' => __('Sa', 'dwt-listing'),
                'January' => __('January', 'dwt-listing'),
                'February' => __('February', 'dwt-listing'),
                'March' => __('March', 'dwt-listing'),
                'April' => __('April', 'dwt-listing'),
                'May' => __('May', 'dwt-listing'),
                'June' => __('June', 'dwt-listing'),
                'July' => __('July', 'dwt-listing'),
                'August' => __('August', 'dwt-listing'),
                'September' => __('September', 'dwt-listing'),
                'October' => __('October', 'dwt-listing'),
                'November' => __('November', 'dwt-listing'),
                'December' => __('December', 'dwt-listing'),
                'Jan' => __('Jan', 'dwt-listing'),
                'Feb' => __('Feb', 'dwt-listing'),
                'Mar' => __('Mar', 'dwt-listing'),
                'Apr' => __('Apr', 'dwt-listing'),
                'May' => __('May', 'dwt-listing'),
                'Jun' => __('Jun', 'dwt-listing'),
                'Jul' => __('July', 'dwt-listing'),
                'Aug' => __('Aug', 'dwt-listing'),
                'Sep' => __('Sep', 'dwt-listing'),
                'Oct' => __('Oct', 'dwt-listing'),
                'Nov' => __('Nov', 'dwt-listing'),
                'Dec' => __('Dec', 'dwt-listing'),
                'Today' => __('Today', 'dwt-listing'),
                'Clear' => __('Clear', 'dwt-listing'),
                'dateFormat' => __('dateFormat', 'dwt-listing'),
                'coupon_days' => __('days', 'dwt-listing'),
                'coupon_hours' => __('hours', 'dwt-listing'),
                'coupon_minutes' => __('minutes', 'dwt-listing'),
                'coupon_seconds' => __('seconds', 'dwt-listing'),
                'copied' => __('Copied!', 'dwt-listing'),
                'not_copy' => __('Whoops, not copied!', 'dwt-listing'),
                'copy_unable' => __('Oops, unable to copy', 'dwt-listing'),
                'copy_else' => __('Copy to clipboard: Ctrl+C or Command+C, Enter', 'dwt-listing'),
                'timepicker' => __('Timepicker', 'dwt-listing'),
                'regz' => __('Register with', 'dwt-listing'),
                'logz' => __('Login with', 'dwt-listing'),
                'tagz' => dwt_listing_text('dwt_listing_list_tags_place'),
                'map_type' => dwt_listing_text('dwt_map_selection'),
                'google_key' => $my_val,
                'is_map_enabled' => dwt_listing_text('dwt_listing_enable_map'),
                'show_redirect_msg' => $show_msg,
                'notify' => __('Notification!', 'dwt-listing'),
                'notify_msg' => __('Package is required to submit listings', 'dwt-listing'),
                'no_msg' => __('No results found', 'dwt-listing'),
                'no_r_for' => __('no result for ', 'dwt-listing'),
                'if_no_img' => esc_url($user_pic),
            )
        );
        wp_localize_script(
            'dwt-listing-profile', // name of js file
            'profile_strings', array(
                'events' => esc_html__('Event gallery will be enabled after providing event title.', 'dwt-listing'),
                'created' => esc_html__('Event created successfully. ', 'dwt-listing'),
                'updated' => esc_html__('Event updated successfully.', 'dwt-listing'),
                'reservation' => esc_html__('Your reservation is submitted succefully. You will get a confirmation email.', 'dwt-listing'),

                'stay_here' => esc_html__('<button>Stay Here?</button>', 'dwt-listing'),
                'event_page' => esc_html__('<button>Move to Event?</button>', 'dwt-listing'),
                'speaker_creation_success'=> __("Speaker Created Successfully!"),
                'speaker_update_success'=> __("Speaker Updated Successfully!"),
                'speaker_creation_error'=> __("Please try again..."),

            )
        );
    }

    add_action('wp_enqueue_scripts', 'dwt_listing_static_strings', 100);
}


if (!function_exists('dwt_listing_feature_listign_expiry_checker')) {

    function dwt_listing_feature_listign_expiry_checker($listing_id)
    {
        if (!$listing_id)
            return;
        global $dwt_listing_options;
        //dynmaic package expiry get_current_user_id()
        $user_id = get_post_field('post_author', $listing_id);
        $featured_expiry_for = get_user_meta($user_id, 'dwt_listing_featured_for', true);
        if (strpos($featured_expiry_for, '-') !== false && $featured_expiry_for != '-1') {
            //get user package id
            if (get_user_meta($user_id, 'd_user_package_id', true) != "") {
                if (get_post_meta($package_id, 'featured_listing_expiry', true) != "") {
                    $package_id = get_user_meta($user_id, 'd_user_package_id', true);
                    $get_featured_days = get_post_meta($package_id, 'featured_listing_expiry', true);
                    update_user_meta($user_id, 'dwt_listing_featured_for', $get_featured_days);
                }
            }
        }
        if (get_post_meta($listing_id, 'dwt_listing_is_feature', true) == '1' && $featured_expiry_for != '-1' && $featured_expiry_for != '') {

            if (get_post_meta($listing_id, 'dwt_listing_feature_ad_expiry_days', true) != "") {
                $featured_date = get_post_meta($listing_id, 'dwt_listing_feature_ad_expiry_days', true);
                $date = date_create($featured_date);
                date_add($date, date_interval_create_from_date_string("$featured_expiry_for days"));
                $expiry_date = date_format($date, "Y-m-d");
                $now = date('Y-m-d'); // current time
                if ($now > $expiry_date) {
                    update_post_meta($listing_id, 'dwt_listing_is_feature', 0);
                }
            }
        }
    }

}




if (!function_exists('dwt_listing_show_business_hours')) {

    function dwt_listing_show_business_hours($listing_id)
    {
        global $dwt_listing_options;
        $days_name = dwt_listing_week_days();
        $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $days = '';
        $listing_is_opened = 0;
        //check option is yes or not
        $listing_is_opened = get_post_meta($listing_id, 'dwt_listing_business_hours', true);
        
        


        if ($listing_is_opened == 0) {
            $days = array();
            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);
                $user_id = get_post_field('post_author', $listing_id);
                //current day
                $current_day = lcfirst(date("l"));
                if ($current_day == $week_days) {
                    $current_day = $current_day;
                } else {
                    $current_day = '';
                }
                if (get_post_meta($listing_id, '_timingz_' . $week_days . '_open', true) == 1 ) {
               
//days which are opened
if (get_user_meta($user_id, 'dwt_listing_user_hours_type', true) != "" && get_user_meta($user_id, 'dwt_listing_user_hours_type', true) == "24") {
$time_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
$time_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));


} else {
$time_from = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
$time_to = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
}

$break_click_on= "";
 $breeak_on= get_post_meta($listing_id, '_timingz_break_' . $week_days . '_open', true) ;
 $break_click_on= isset($breeak_on) && $breeak_on != "" ? $breeak_on: "";
if($break_click_on == 1)
{
    $breakk_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakfrom', true)));
    $breakk_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakto', true)));  
}
else{
    $breakk_from =  "";
    $breakk_to = ""; 
}
$days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "break_from" => $breakk_from, "break_too" => $breakk_to,  "closed" => '', "current_day" => $current_day, 'break'=> $break_click_on);
    
               
if (get_user_meta($user_id, 'dwt_listing_user_hours_type', true) != "" && get_user_meta($user_id, 'dwt_listing_user_hours_type', true) == "24") {
                }
            
            }
              else {
                //days which are closed
                $days[] = array("day_name" => $days_name[$a], "closed" => '1', "current_day" => $current_day);
            }
            }
            return $days;
        }
    }

}


// Check Status Of Business Hours
if (!function_exists('dwt_listing_business_hours_status')) {

    function dwt_listing_business_hours_status($listing_id)
    {
        /*if listing open 24/7 */
        if (get_post_meta($listing_id, 'dwt_listing_business_hours', true) == '1') {
            /*return esc_html__('Always Open','dwt-listing'); */
            return '2';
        } else if (get_post_meta($listing_id, 'dwt_listing_business_hours', true) == '') {
            return '';
        } else {
            /* timezone of selected business hours */
            $listing_timezone = get_post_meta($listing_id, 'dwt_listing_user_timezone', true);
            if (dwt_listing_checktimezone($listing_timezone) == true) {
                if ($listing_timezone != "") {
                    /*$status = esc_html__('Closed','dwt-listing'); */
                    /*current day */
                    $current_day = lcfirst(date("l"));
                    /*current time */
                    $date = new DateTime("now", new DateTimeZone($listing_timezone));
                    $currentTime = $date->format('Y-m-d H:i:s');

                    $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                    /*get all weak days */
                    $times = array();
                    for ($a = 0; $a <= 6; $a++) {
                        $week_days = lcfirst($custom_days[$a]);
                        /*check if businnes hours avaible for current day */
                        if(get_post_meta($listing_id, '_timingz_'.$week_days.'_open', true) == 1) 
                        { 
                        $startTime = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $endTime = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                        $times[substr($week_days, 0, 3)] = $startTime . ' - ' . $endTime;
                        } 
                    }

 
                    $currentTime = strtotime($currentTime);
                    
                        return isOpen($currentTime, $times);
                }
            }
        }
    }

}

function compileHours($times, $timestamp)
{

  
  $times =    isset($times[strtolower(date('D', $timestamp))])  ?   $times[strtolower(date('D', $timestamp))]    : ""  ;
    if (!strpos($times, '-'))
        return array();
    $hours = explode(",", $times);
    $hours = array_map('explode', array_pad(array(), count($hours), '-'), $hours);
    $hours = array_map('array_map', array_pad(array(), count($hours), 'strtotime'), $hours, array_pad(array(), count($hours), array_pad(array(), 2, $timestamp)));
    end($hours);
    if ($hours[key($hours)][0] > $hours[key($hours)][1])
        $hours[key($hours)][1] = strtotime('+1 day', $hours[key($hours)][1]);
    return $hours;
}

function isOpen($now, $times)
{
    $open = "0"; // time until closing in seconds or 0 if closed
    // merge opening hours of today and the day before
    $hours = array_merge(compileHours($times, strtotime('yesterday', $now)), compileHours($times, $now));
    foreach ($hours as $h) {
        if ($now >= $h[0] and $now < $h[1]) {
            $open = $h[1] - $now;
            return $open;
        }
    }
    return $open;
}

// Check User Activity
if (!function_exists('dwt_listing_track_activity')) {

    function dwt_listing_track_activity($listing_id, $activity_type, $value, $comment_id = '')
    {
        global $dwt_listing_options;

        //if leads tracking is enabled
        if (isset($dwt_listing_options['dwt_listing_enable_leads']) && $dwt_listing_options['dwt_listing_enable_leads'] == '1') {
            $user_id = get_current_user_id();
            if ($value != "") {
                $date = date('Y-m-d H:i:s');
                if ($user_id != "") {
                    if (isset($comment_id) && $comment_id != "") {
                        add_post_meta($listing_id, '_activity_' . $activity_type . '_userid_' . $user_id . $comment_id, $date . '_' . $value);
                    } else {
                        add_post_meta($listing_id, '_activity_' . $activity_type . '_userid_' . $user_id, $date . '_' . $value);
                    }
                } else {
                    add_post_meta($listing_id, '_activity_' . $activity_type . '_userid_unknown', $date . '_' . $value);
                }
            }
        }
    }

}


// Store User Package Details
if (!function_exists('dwt_listing_store_user_package')) {

    function dwt_listing_store_user_package($uid, $product_id)
    {
        $listing_featured_expiry = $pkg_exp = $bump_listing = $featured_listing = $regular_listing = $listing_expiry = '';
        $regular_listing = get_post_meta($product_id, 'regular_listing', true);
        $featured_listing = get_post_meta($product_id, 'featured_listing', true);
        $bump_listing = get_post_meta($product_id, 'bump_listing', true);
        $pkg_exp = get_post_meta($product_id, 'package_expiry', true);
        $listing_featured_expiry = get_post_meta($product_id, 'featured_listing_expiry', true);

        //assign simple listings
        if (!empty($regular_listing) && $regular_listing == '-1') {
            update_user_meta($uid, 'dwt_listing_regular_listing', '-1');
        } else if (!empty($regular_listing) && is_numeric($regular_listing) && $regular_listing != 0) {
            update_user_meta($uid, 'dwt_listing_regular_listing', $regular_listing);
        }

        //assign featured listings
        if (!empty($featured_listing) && $featured_listing == '-1') {
            update_user_meta($uid, 'dwt_listing_featured_listing', '-1');
        } else if (!empty($featured_listing) && is_numeric($featured_listing) && $featured_listing != 0) {
            update_user_meta($uid, 'dwt_listing_featured_listing', $featured_listing);
        }

        //assign bump listings
        if (empty($bump_listing)) {
            update_user_meta($uid, 'dwt_listing_bump_listing', '0');
        } else if (!empty($bump_listing) && $bump_listing == '-1') {
            update_user_meta($uid, 'dwt_listing_bump_listing', '-1');
        } else if (!empty($bump_listing) && is_numeric($bump_listing) && $bump_listing != 0) {
            update_user_meta($uid, 'dwt_listing_bump_listing', $bump_listing);
        }

        //assign package days to user
        if (!empty($pkg_exp) && $pkg_exp == '-1') {
            update_user_meta($uid, 'dwt_listing_package_expiry', '-1');
        } else {
            $expiry_date = get_user_meta($uid, 'dwt_listing_package_expiry', true);
            $e_date = strtotime($pkg_exp);
            $today = strtotime(date('Y-m-d'));
            if ($today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$pkg_exp days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$pkg_exp days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, 'dwt_listing_package_expiry', $new_expiry);
        }
        //store featured listing expiry days to user

        if (!empty($listing_featured_expiry) && $listing_featured_expiry == '-1') {
            update_user_meta($uid, 'dwt_listing_featured_for', '-1');
        } else {
            update_user_meta($uid, 'dwt_listing_featured_for', $listing_featured_expiry);
        }
    }

}

// Store User Package From Admin Panel
if (!function_exists('dwt_listing_store_user_package_admin')) {

    function dwt_listing_store_user_package_admin($uid, $product_id)
    {
        $gey_packtype = $product_type = '';
        $product_type = wc_get_product($product_id);
        $now = date('Y-m-d');
        if ($product_type->get_type() == 'dwt_listing_pkgs' || $product_type->get_type() == 'subscription') {
            if (get_post_meta($product_id, 'package_type', true) != "") {
                $gey_packtype = get_post_meta($product_id, 'package_type', true);
                //check package type
                if ($gey_packtype == "free") {
                    update_user_meta($uid, 'd_user_package_id', $product_id);
                    update_user_meta($uid, 'd_is_free_pgk', $product_id);
                    if (get_user_meta($uid, 'package_expiry_logic_date', true) != "") {

                    } else {
                        update_user_meta($uid, 'package_expiry_logic_date', $now);
                    }
                } else {
                    //It's a paid package
                    update_user_meta($uid, 'd_user_package_id', $product_id);
                    if (get_user_meta($uid, 'package_expiry_logic_date', true) != "") {

                    } else {
                        update_user_meta($uid, 'package_expiry_logic_date', $now);
                    }
                }
            }
            $listing_featured_expiry = $pkg_exp = $bump_listing = $featured_listing = $regular_listing = '';
            $regular_listing = get_post_meta($product_id, 'regular_listing', true);
            $featured_listing = get_post_meta($product_id, 'featured_listing', true);
            $bump_listing = get_post_meta($product_id, 'bump_listing', true);
            $pkg_exp = get_post_meta($product_id, 'package_expiry', true);
            $listing_featured_expiry = get_post_meta($product_id, 'featured_listing_expiry', true);
            //assign simple listings
            if (!empty($regular_listing) && $regular_listing == '-1') {
                update_user_meta($uid, 'dwt_listing_regular_listing', '-1');
            } else if (!empty($regular_listing) && is_numeric($regular_listing) && $regular_listing != 0) {
                update_user_meta($uid, 'dwt_listing_regular_listing', $regular_listing);
            }

            //assign featured listings
            if (!empty($featured_listing) && $featured_listing == '-1') {
                update_user_meta($uid, 'dwt_listing_featured_listing', '-1');
            } else if (!empty($featured_listing) && is_numeric($featured_listing) && $featured_listing != 0) {
                update_user_meta($uid, 'dwt_listing_featured_listing', $featured_listing);
            }

            //assign bump listings
            if (empty($bump_listing)) {
                update_user_meta($uid, 'dwt_listing_bump_listing', '0');
            } else if (!empty($bump_listing) && $bump_listing == '-1') {
                update_user_meta($uid, 'dwt_listing_bump_listing', '-1');
            } else if (!empty($bump_listing) && is_numeric($bump_listing) && $bump_listing != 0) {
                update_user_meta($uid, 'dwt_listing_bump_listing', $bump_listing);
            }

            //assign package days to user
            if (!empty($pkg_exp) && $pkg_exp == '-1') {
                update_user_meta($uid, 'dwt_listing_package_expiry', '-1');
            } else {
                $expiry_date = get_user_meta($uid, 'dwt_listing_package_expiry', true);
                $e_date = strtotime($pkg_exp);
                $today = strtotime(date('Y-m-d'));
                if ($today > $e_date) {
                    $new_expiry = date('Y-m-d', strtotime("+$pkg_exp days"));
                } else {
                    $date = date_create($expiry_date);
                    date_add($date, date_interval_create_from_date_string("$pkg_exp days"));
                    $new_expiry = date_format($date, "Y-m-d");
                }
                update_user_meta($uid, 'dwt_listing_package_expiry', $new_expiry);
            }
            //store featured listing expiry days to user

            if (!empty($listing_featured_expiry) && $listing_featured_expiry == '-1') {
                update_user_meta($uid, 'dwt_listing_featured_for', '-1');
            } else {
                update_user_meta($uid, 'dwt_listing_featured_for', $listing_featured_expiry);
            }
        }
    }

}


// Store User Package Details
if (!function_exists('dwt_listing_closest_number')) {

    function dwt_listing_closest_number($array, $number)
    {
        if (is_array($array) && count((array)$array) > 0) {
            sort($array);
            foreach ($array as $a) {
                if ($a >= $number)
                    return $a;
            }
            return end($array); // or return NULL;
        } else {
            return '';
        }
    }

}
// Store User Package Details
if (!function_exists('dwt_listing_review_user_tagline')) {

    function dwt_listing_review_user_tagline($review_count = 0)
    {
        global $dwt_listing_options;
        if (dwt_listing_text('dwt_listing_review_taglines_limit') != "") {
            $numbers_array = explode("|", dwt_listing_text('dwt_listing_review_taglines_limit'));
            $name_array = explode("|", dwt_listing_text('dwt_listing_review_taglines_titles'));
            if (is_array($numbers_array) && count((array)$numbers_array) > 0 && is_array($name_array) && count((array)$name_array) > 0) {
                $getValue = dwt_listing_closest_number($numbers_array, $review_count);
                $index = 0;
                foreach ($numbers_array as $num) {
                    if ($num == $getValue) {
                        return $name_array[$index];
                        break;
                    }
                    $index++;
                }
            }
        }
    }

}
// Listing Coupon Time Difference
if (!function_exists('dwt_listing_check_coupon_expiry')) {

    function dwt_listing_check_coupon_expiry($listing_id)
    {
        if ($listing_id == '')
            return '';
        global $dwt_listing_options;

        //must have end time
        if (get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true) != '') {
            $coupon_end_date = get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true);
            $end_expiry_date = strtotime($coupon_end_date);
            //listing owner timezone

            $author_id = get_post_field('post_author', $listing_id);
            if (get_user_meta($author_id, 'd_user_timezone', true) != "") {
                $user_time = get_user_meta($author_id, 'd_user_timezone', true);

                if (dwt_listing_checktimezone($user_time) == true) {
                    $user_timezone = new DateTime("now", new DateTimeZone($user_time));
                    $currentTime = $user_timezone->format('m/d/Y g:i a');
                } else {//no timezone :(
                    $currentTime = date('m/d/Y g:i a');
                }
            } else {
                //no timezone :(
                $currentTime = date('m/d/Y g:i a');
            }
            $time_need_to_check = strtotime($currentTime);
            if ($time_need_to_check < $end_expiry_date) {
                //not expired
                return '1';
            } else {
                //coupon expired
                return '0';
            }
        }
    }

}


// Event Time Expiry Started
if (!function_exists('dwt_listing_check_event_starting')) {

    function dwt_listing_check_event_starting($event_id)
    {
        if ($event_id == '')
            return '';
        global $dwt_listing_options;

        //must have end time
        if (get_post_meta($event_id, 'dwt_listing_event_start_date', true) != '') {
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $start_timing = strtotime($event_start_date);
            //listing owner timezone

            $author_id = get_post_field('post_author', $event_id);
            if (get_user_meta($author_id, 'd_user_timezone', true) != "") {
                $user_time = get_user_meta($author_id, 'd_user_timezone', true);
                if (dwt_listing_checktimezone($user_time) == true) {
                    $user_timezone = new DateTime("now", new DateTimeZone($user_time));
                    $currentTime = $user_timezone->format('m/d/Y g:i a');
                } else {//no timezone :(
                    $currentTime = date('m/d/Y g:i a');
                }
            } else {
                //no timezone :(
                $currentTime = date('m/d/Y g:i a');
            }
            $time_need_to_check = strtotime($currentTime);
            if ($time_need_to_check < $start_timing) {
                //not expired
                return '1';
            } else {
                //coupon expired
                return '0';
            }
        }
    }

}


// Event Time Expiry Started
if (!function_exists('dwt_listing_check_event_against_listing')) {

    function dwt_listing_check_event_against_listing($listing_id)
    {
        if (!$listing_id)
            return;
        $args = array(
            'post_type' => 'events',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_event_listing_id',
                    'value' => $listing_id,
                    'compare' => '='
                ),
                array(
                    'key' => 'dwt_listing_event_status',
                    'value' => '1',
                    'compare' => '='
                )
            ),
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $event_id = get_the_ID();
                ?>
                <div class="single-event-widget">
                    <div class="notify-event">
                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                        <h3><?php echo get_the_title(); ?> </h3>
                        <ul>
                            <li><i class="fa fa-map-marker"
                                   aria-hidden="true"></i> <?php echo get_post_meta($event_id, 'dwt_listing_event_venue', true); ?>
                            </li>
                            <li><i class="fa fa-calendar-times-o"
                                   aria-hidden="true"></i> <?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime(get_post_meta($event_id, 'dwt_listing_event_start_date', true))); ?>
                            </li>
                        </ul>
                        <a target="_blank" href="<?php echo get_permalink($event_id); ?>"
                           class="btn btn-theme"><?php echo esc_html__('View Event', 'dwt-listing'); ?></a>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {

        }
    }

}

if (!function_exists('dwt_listing_typography')) {

    function dwt_listing_typography()
    {
        global $dwt_listing_options;
        $nav_color = $nav_line_height = $nav_font_weight = $nav_font_size = $nav_font_family = $color = $line_height = $font_weight = $font_size = $font_family = '';
        $h3_color = $h3_line_height = $h3_font_weight = $h3_font_size = $h3_font_family = $h2_color = $h2_line_height = $h2_font_weight = $h2_font_size = $h2_font_family = '';

        $h5_color = $h5_line_height = $h5_font_weight = $h5_font_size = $h5_font_family = $h4_color = $h4_line_height = $h4_font_weight = $h4_font_size = $h4_font_family = '';

        $p_color = $p_line_height = $p_font_weight = $p_font_size = $p_font_family = $h6_color = $h6_line_height = $h6_font_weight = $h6_font_size = $h6_font_family = '';

        $primary_clr = $active_clr = $hover_clr = $regular_clr = '';


        // for body typo
        $font_family = $dwt_listing_options['typography-body']['font-family'];
        $font_size = $dwt_listing_options['typography-body']['font-size'];
        $font_weight = $dwt_listing_options['typography-body']['font-weight'];
        $line_height = $dwt_listing_options['typography-body']['line-height'];
        $color = $dwt_listing_options['typography-body']['color'];

        //for navigation typo
        $nav_font_family = $dwt_listing_options['dwt_nav-typo']['font-family'];
        $nav_font_size = $dwt_listing_options['dwt_nav-typo']['font-size'];
        $nav_font_weight = $dwt_listing_options['dwt_nav-typo']['font-weight'];
        $nav_line_height = $dwt_listing_options['dwt_nav-typo']['line-height'];
        $nav_color = $dwt_listing_options['dwt_nav-typo']['color'];

        //for h2 typo
        $h2_font_family = $dwt_listing_options['dwt_h2_typo']['font-family'];
        $h2_font_size = $dwt_listing_options['dwt_h2_typo']['font-size'];
        $h2_font_weight = $dwt_listing_options['dwt_h2_typo']['font-weight'];
        $h2_line_height = $dwt_listing_options['dwt_h2_typo']['line-height'];
        $h2_color = $dwt_listing_options['dwt_h2_typo']['color'];


        //for h3 typo
        $h3_font_family = $dwt_listing_options['dwt_h3_typo']['font-family'];
        $h3_font_size = $dwt_listing_options['dwt_h3_typo']['font-size'];
        $h3_font_weight = $dwt_listing_options['dwt_h3_typo']['font-weight'];
        $h3_line_height = $dwt_listing_options['dwt_h3_typo']['line-height'];
        $h3_color = $dwt_listing_options['dwt_h3_typo']['color'];


        //for h4 typo
        $h4_font_family = $dwt_listing_options['dwt_h4_typo']['font-family'];
        $h4_font_size = $dwt_listing_options['dwt_h4_typo']['font-size'];
        $h4_font_weight = $dwt_listing_options['dwt_h4_typo']['font-weight'];
        $h4_line_height = $dwt_listing_options['dwt_h4_typo']['line-height'];
        $h4_color = $dwt_listing_options['dwt_h3_typo']['color'];


        //for h5 typo
        $h5_font_family = $dwt_listing_options['dwt_h5_typo']['font-family'];
        $h5_font_size = $dwt_listing_options['dwt_h5_typo']['font-size'];
        $h5_font_weight = $dwt_listing_options['dwt_h5_typo']['font-weight'];
        $h5_line_height = $dwt_listing_options['dwt_h5_typo']['line-height'];
        $h5_color = $dwt_listing_options['dwt_h5_typo']['color'];


        //for h6 typo
        $h6_font_family = $dwt_listing_options['dwt_h6_typo']['font-family'];
        $h6_font_size = $dwt_listing_options['dwt_h6_typo']['font-size'];
        $h6_font_weight = $dwt_listing_options['dwt_h6_typo']['font-weight'];
        $h6_line_height = $dwt_listing_options['dwt_h6_typo']['line-height'];
        $h6_color = $dwt_listing_options['dwt_h6_typo']['color'];


        //for p typo
        $p_font_family = $dwt_listing_options['dwt_p_typo']['font-family'];
        $p_font_size = $dwt_listing_options['dwt_p_typo']['font-size'];
        $p_font_weight = $dwt_listing_options['dwt_p_typo']['font-weight'];
        $p_line_height = $dwt_listing_options['dwt_p_typo']['line-height'];
        $p_color = $dwt_listing_options['dwt_p_typo']['color'];

        //theme btn color
        $regular_clr = $dwt_listing_options['dwt_btnz_plate']['regular'];
        $hover_clr = $dwt_listing_options['dwt_btnz_plate']['hover'];
        $active_clr = $dwt_listing_options['dwt_btnz_plate']['active'];


        //theme primary color
        $primary_clr = $dwt_listing_options['dwt_primary_clr'];

        $custom_css = "
					body{
							font-family: {$font_family} !important;
							font-weight: {$font_weight};
							font-size: {$font_size};
							line-height: {$line_height};
							color: {$color};
					}
					.mega-menu , .mega-menu .menu-links > li > a{
						font-family: {$nav_font_family} !important;
					}
					
					.mega-menu .menu-links > li > a , .mega-menu.transparent .menu-links > li > a , .mega-menu.header2 .menu-button li a {
						font-size: {$nav_font_size};
						font-weight: {$nav_font_weight};
						line-height: {$nav_line_height};
						color: {$nav_color};
					}
                                        .hoverTrigger.sb-wpml .wpml-ls-legacy-dropdown a {
                                                color: {$nav_color};}
					
					.mega-menu .drop-down-multilevel a, .menu-button li.profile-dropdown ul.dropdown-menu li a {
						font-size: {$nav_font_size};
						font-weight: {$nav_font_weight};
					
					}
					.h2, h2 , .heading-2 h2 {
						font-family: {$h2_font_family} !important;
						font-size: {$h2_font_size};
						font-weight: {$h2_font_weight};
						line-height: {$h2_line_height};
						color: {$h2_color};
					}
					.home-main-2 .main-section-area h2 {
						font-family: {$h2_font_family} !important;
					}
					.how-it-work-section .hiw-main-box .hiw-single-box .hiw-heading h2{
						color: {$h2_color} !important;
					} 
					
					.h3, h3 , .heading-2 h3
					{
						font-family: {$h3_font_family} !important;
						font-size: {$h3_font_size};
						font-weight: {$h3_font_weight};
						color: {$h3_color};
					}
					
					.heading-2 h3 {
							line-height: {$h3_line_height};
					}
					
					.h4, h4 
					{
						font-family: {$h4_font_family} !important;
						font-size: {$h4_font_size};
						font-weight: {$h4_font_weight};
						line-height: {$h4_line_height};
						color: {$h4_color};
					}
					
					p , .short-detail .list-detail p , .blog-section-2 .blog-inner-box .blog-lower-box .text , .dwt_listing_single-detial .entry-content p , .list-detail ul li, .list-detail ol li{
					    font-family: {$p_font_family} !important;
						font-size: {$p_font_size};
						font-weight: {$p_font_weight};
						line-height: {$p_line_height};
						color: {$p_color};
					}
					.single-detail-page .list-detail #d-desc ul li, .single-detail-page .list-detail #d-desc ol li
					{
						color: {$p_color};
					}
					
					.card-agent-6 .author-loc {
						 font-family: {$p_font_family} !important;
						font-size: {$p_font_size};
						font-weight: {$p_font_weight};
						color: {$p_color};
					}
					
					.single-post .review-box .review-author-right .review-author-detail p {
						line-height: {$p_line_height};
					}
					
					.h5, h5 
					{
						font-family: {$h5_font_family} !important;
						font-size: {$h5_font_size};
						font-weight: {$h5_font_weight};
						line-height: {$h5_line_height};
						color: {$h5_color};
					}
					
					.h6, h6 
					{
						font-family: {$h6_font_family} !important;
						font-size: {$h6_font_size};
						font-weight: {$h6_font_weight};
						line-height: {$h6_line_height};
						color: {$h6_color};
					}
					
					.list-detail  .event_type2.owl-carousel .owl-next,.list-detail  .event_type2.owl-carousel .owl-prev 
					{
						border: 1px solid {$primary_clr} !important;
						background: {$primary_clr} !important;
					}
					
					.sidebar .nav > li > a:focus, .sidebar .nav > li > a.active {
						border-left-color: {$primary_clr};
					}
					.sidebar .nav > li > a:hover i, .sidebar .nav > li > a:focus i, .sidebar .nav > li > a.active i {
						color: {$primary_clr};
					}
					.catz-boxes:hover 
					{
						border: 1px solid {$primary_clr};
					}
					.btn-theme , .mega-menu.header2 .menu-button li.post-btn , .event-hero-intro-search button , .header-top .header-top-profile ul li.ad-listing-btn a  ,.with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn , .typeahead__container.hero9 button , .n-header-4 .mega-menu .menu-button li.post-btn , .btn-admin{
						background-color: {$regular_clr};
						border-color: {$regular_clr};
					}
					
					.new-hero-search-bar .submit {
						background: {$hover_clr};
					}
					.s-call-action-content .btn-theme , .s-listing-gallery li.s-gallery-box .s-gallery-content .btn-theme {
						background: {$hover_clr};
						border-color: {$hover_clr};
					}
					.new-hero-search-bar .submit:hover {
						background: {$regular_clr};
					}
					.new-hero-search-bar .submit:focus, .new-hero-search-bar .submit:active {
						background: {$active_clr};
					}
					
					.header-top .header-top-profile ul li.ad-listing-btn {
						border: 1px solid {$regular_clr};
					}
					
					.recent-tab ul.nav.nav-tabs li.active a {
						background-color: {$regular_clr};
					}
					
					.landing-carousel .owl-theme .owl-nav [class*='owl-']:hover {
						background: {$hover_clr};
					}
					
					.btn-theme:hover,  .mega-menu.header2 .menu-button li.post-btn:hover, .event-hero-intro-search button:hover, .header-top .header-top-profile ul li.ad-listing-btn a:hover ,  .listing-widget-sidebar .input-group .input-group-btn .btn-default:hover , .location-filters .input-group  .input-group-btn .btn-default:hover , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn:hover , .custom-form-field .input-group .input-group-btn .btn-default:hover  , .typeahead__container.hero9 button:focus, .typeahead__container.hero9 button:hover , .n-header-4 .mega-menu .menu-button li.post-btn:hover , .btn-admin:hover , .btn-main:hover  {
						background-color: {$hover_clr};
						border-color: {$hover_clr};
					}
					
					.typeahead__container.hero9 button.active, .typeahead__container.hero9 button:active
					{
						background-color: {$hover_clr};
						border-color: {$hover_clr};
					}
					
					.header-top .header-top-profile ul li.ad-listing-btn:hover {
						border: 1px solid {$hover_clr};
					}
					
					.listing-widget-sidebar .input-group  .btn-default:focus , .location-filters .input-group  .input-group-btn .btn-default:focus , .custom-form-field .input-group .input-group-btn .btn-default:hover {
						 background-color: {$active_clr};
						border-color: {$active_clr};
						color:#fff;
					}
					
					.btn-theme:active, .btn-theme.active , .btn-theme:focus ,  .mega-menu.header2 .menu-button li.post-btn:focus ,  .mega-menu.header2 .menu-button li.post-btn.active , .event-hero-intro-search button.active  , .event-hero-intro-search button:active, .event-hero-intro-search button:focus , .listing-widget-sidebar .input-group .input-group-btn .btn-default.active, .location-filters .input-group  .input-group-btn .btn-default.active , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn.active , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn:focus , .custom-form-field .input-group .input-group-btn .btn-default:hover{
						background-color: {$active_clr};
						border-color: {$active_clr};
					}
								
					.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover , .btn-main {
						background-color: {$primary_clr};
						border-color: {$primary_clr};
					}
					.pagination li > a:hover {
							background-color: {$primary_clr};
							border: 1px solid {$primary_clr};
					}
					
					.p-about-us .p-absolute-menu a {
						 border: 3px solid {$primary_clr};
					}
					.navbar-nav .dropdown-menu {
						border-top: 2px solid {$primary_clr};
					}
					
					.listing-details h4 a:hover , .ad-archive-desc h3:hover, .ad-archive-desc h3 a:hover , .ad-archive-desc .ad-meta .read-more:hover, .dwt_listing_shop-grid-description h2:hover , .mega-menu .drop-down-multilevel li:hover > a , .single-post .short-detail .list-category ul li a , .single-post .list-meta .list-meta-with-icons a , .sidebar .profile-widget .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover , .modern-version-block-info .post-author a:hover , .blog-sidebar .widget ul li a:hover ,  .dark-footer .list li a:hover , .dark-footer  .list li i , .search-catz i , .tags i  , .feedback-type2 .feedback-desc h6  , #dwt-admin-wrap .collaspe-btn-admin,  .listing-viewed-stats > li.my-active-clr {
						color: {$primary_clr};
					}
					
					.draw-border:hover::before, .draw-border:hover::after {
  							border-color: {$primary_clr};
					}
					
					.sidebar .profile-widget .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
						border-bottom: 2px solid {$primary_clr};
					}
					
					.hero-list-event .search-container .tab .nav-tabs li.active a::after {
						border-top: 7px solid {$primary_clr};
					}
					
					.hero-list-event .search-container .tab .tab-content {
						border-bottom: 3px solid {$primary_clr};
					}
					
					.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover , .select2-container .select2-dropdown .select2-results__option--highlighted , .hero-list-event .search-container .tab .nav-tabs li.active a , #papular-listing .papular-listing-2-slider.owl-carousel .owl-nav button.owl-next, #papular-listing .papular-listing-2-slider.owl-carousel .owl-nav button.owl-prev, #papular-listing .papular-listing-2-slider.owl-carousel button.owl-dot , .cities-grid-area-2 hr , .single-event-detials .owl-theme .owl-dots .owl-dot.active span, .single-event-detials .owl-theme .owl-dots .owl-dot:hover span , .input-group-addon button , .search-form .input-group-addon , .blog-sidebar .widget .widget-heading h4::before , .filters-option-bar .heading-icon , .dark-footer ul.social li a:hover {
						background-color: {$primary_clr};
					}
					
					a:hover, a:focus , .ad-archive-desc .category-title a , .testimonial-style-2 .testimonial .post , .blog-section-2 .blog-inner-box .blog-lower-box h3 a:hover , .ft-right ul li a:hover , .event-list-cat.red span  , .card-agent-6 .card-title a:hover , .card-agent-6 .author-loc span {
						color: {$primary_clr};
					}
					
					.scrollup, .related-produt-slider.owl-carousel .owl-nav button.owl-next, .related-produt-slider.owl-carousel .owl-nav button.owl-prev, .related-produt-slider.owl-carousel button.owl-dot , .event-list-cat.red::after , .dropdown-menu > .active > a, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a:hover , .dwt_listing_modal-copun button.close {
						background-color: {$primary_clr};
					}
					.highlights h4::before {
						background-color: {$primary_clr};
					}
					";
        wp_add_inline_style('dwt-listing-custom', $custom_css);
    }

}

if (!function_exists('dwt_listing_typography_rtl')) {

    function dwt_listing_typography_rtl()
    {
        global $dwt_listing_options;
        $nav_color = $nav_line_height = $nav_font_weight = $nav_font_size = $nav_font_family = $color = $line_height = $font_weight = $font_size = $font_family = '';
        $h3_color = $h3_line_height = $h3_font_weight = $h3_font_size = $h3_font_family = $h2_color = $h2_line_height = $h2_font_weight = $h2_font_size = $h2_font_family = '';
        $h5_color = $h5_line_height = $h5_font_weight = $h5_font_size = $h5_font_family = $h4_color = $h4_line_height = $h4_font_weight = $h4_font_size = $h4_font_family = '';
        $p_color = $p_line_height = $p_font_weight = $p_font_size = $p_font_family = $h6_color = $h6_line_height = $h6_font_weight = $h6_font_size = $h6_font_family = '';
        $primary_clr = $active_clr = $hover_clr = $regular_clr = '';

        // for body typo
        $font_family = $dwt_listing_options['typography-body']['font-family'];
        $font_size = $dwt_listing_options['typography-body']['font-size'];
        $font_weight = $dwt_listing_options['typography-body']['font-weight'];
        $line_height = $dwt_listing_options['typography-body']['line-height'];
        $color = $dwt_listing_options['typography-body']['color'];

        //for navigation typo
        $nav_font_family = $dwt_listing_options['dwt_nav-typo']['font-family'];
        $nav_font_size = $dwt_listing_options['dwt_nav-typo']['font-size'];
        $nav_font_weight = $dwt_listing_options['dwt_nav-typo']['font-weight'];
        $nav_line_height = $dwt_listing_options['dwt_nav-typo']['line-height'];
        $nav_color = $dwt_listing_options['dwt_nav-typo']['color'];

        //for h2 typo
        $h2_font_family = $dwt_listing_options['dwt_h2_typo']['font-family'];
        $h2_font_size = $dwt_listing_options['dwt_h2_typo']['font-size'];
        $h2_font_weight = $dwt_listing_options['dwt_h2_typo']['font-weight'];
        $h2_line_height = $dwt_listing_options['dwt_h2_typo']['line-height'];
        $h2_color = $dwt_listing_options['dwt_h2_typo']['color'];


        //for h3 typo
        $h3_font_family = $dwt_listing_options['dwt_h3_typo']['font-family'];
        $h3_font_size = $dwt_listing_options['dwt_h3_typo']['font-size'];
        $h3_font_weight = $dwt_listing_options['dwt_h3_typo']['font-weight'];
        $h3_line_height = $dwt_listing_options['dwt_h3_typo']['line-height'];
        $h3_color = $dwt_listing_options['dwt_h3_typo']['color'];


        //for h4 typo
        $h4_font_family = $dwt_listing_options['dwt_h4_typo']['font-family'];
        $h4_font_size = $dwt_listing_options['dwt_h4_typo']['font-size'];
        $h4_font_weight = $dwt_listing_options['dwt_h4_typo']['font-weight'];
        $h4_line_height = $dwt_listing_options['dwt_h4_typo']['line-height'];
        $h4_color = $dwt_listing_options['dwt_h3_typo']['color'];


        //for h5 typo
        $h5_font_family = $dwt_listing_options['dwt_h5_typo']['font-family'];
        $h5_font_size = $dwt_listing_options['dwt_h5_typo']['font-size'];
        $h5_font_weight = $dwt_listing_options['dwt_h5_typo']['font-weight'];
        $h5_line_height = $dwt_listing_options['dwt_h5_typo']['line-height'];
        $h5_color = $dwt_listing_options['dwt_h5_typo']['color'];


        //for h6 typo
        $h6_font_family = $dwt_listing_options['dwt_h6_typo']['font-family'];
        $h6_font_size = $dwt_listing_options['dwt_h6_typo']['font-size'];
        $h6_font_weight = $dwt_listing_options['dwt_h6_typo']['font-weight'];
        $h6_line_height = $dwt_listing_options['dwt_h6_typo']['line-height'];
        $h6_color = $dwt_listing_options['dwt_h6_typo']['color'];


        //for p typo
        $p_font_family = $dwt_listing_options['dwt_p_typo']['font-family'];
        $p_font_size = $dwt_listing_options['dwt_p_typo']['font-size'];
        $p_font_weight = $dwt_listing_options['dwt_p_typo']['font-weight'];
        $p_line_height = $dwt_listing_options['dwt_p_typo']['line-height'];
        $p_color = $dwt_listing_options['dwt_p_typo']['color'];

        //theme btn color
        $regular_clr = $dwt_listing_options['dwt_btnz_plate']['regular'];
        $hover_clr = $dwt_listing_options['dwt_btnz_plate']['hover'];
        $active_clr = $dwt_listing_options['dwt_btnz_plate']['active'];

        //theme primary color
        $primary_clr = $dwt_listing_options['dwt_primary_clr'];
        $custom_css = "
					body{
                                                        font-family: {$font_family} !important;
							font-weight: {$font_weight};
							font-size: {$font_size};
							line-height: {$line_height};
							color: {$color};
					}
                                        .mega-menu , .mega-menu .menu-links > li > a{
						font-family: {$nav_font_family} !important;
					}
					.mega-menu .menu-links > li > a , .mega-menu.transparent .menu-links > li > a {
						
						font-weight: {$nav_font_weight};
						line-height: {$nav_line_height};
						color: {$nav_color};
					}
					.mega-menu .drop-down-multilevel a, .menu-button li.profile-dropdown ul.dropdown-menu li a {
						font-size: {$nav_font_size};
						font-weight: {$nav_font_weight};
					
					}
                                        
                                        .rtl .hoverTrigger.sb-wpml .wpml-ls-legacy-dropdown a {
                                                    color: {$nav_color};}
                                                        
					.h2, h2 , .heading-2 h2 {
                                                font-family: {$h2_font_family} !important;
						font-size: {$h2_font_size};
						font-weight: {$h2_font_weight};
						line-height: {$h2_line_height};
						color: {$h2_color};
					}
                                        
					.how-it-work-section .hiw-main-box .hiw-single-box .hiw-heading h2{
						color: {$h2_color};
					} 
                                        
					.h3, h3 , .heading-2 h3
					{
                                                font-family: {$h3_font_family} !important;
						font-size: {$h3_font_size};
						font-weight: {$h3_font_weight};
						color: {$h3_color};
					}
					.heading-2 h3 {
							line-height: {$h3_line_height};
					}
					.h4, h4 
					{
                                                font-family : {$h4_font_family} !important;
						font-size: {$h4_font_size};
						font-weight: {$h4_font_weight};
						line-height: {$h4_line_height};
						color: {$h4_color};
					}
					p , .short-detail .list-detail p , .blog-section-2 .blog-inner-box .blog-lower-box .text , .dwt_listing_single-detial .entry-content p , .list-detail ul li, .list-detail ol li{
                                                font-family: {$p_font_family} !important;
						font-size: {$p_font_size};
						font-weight: {$p_font_weight};
						line-height: {$p_line_height};
						color: {$p_color};
					}
					.single-detail-page .list-detail #d-desc ul li, .single-detail-page .list-detail #d-desc ol li
					{
						color: {$p_color};
					}
					.card-agent-6 .author-loc {
						 font-family: {$p_font_family} !important;
						font-size: {$p_font_size};
						font-weight: {$p_font_weight};
						color: {$p_color};
					}
					.single-post .review-box .review-author-right .review-author-detail p {
						line-height: {$p_line_height};
					}
					.h5, h5 
					{
                                                font-family : {$h5_font_family} !important;
						font-size: {$h5_font_size};
						font-weight: {$h5_font_weight};
						line-height: {$h5_line_height};
						color: {$h5_color};
					}
					.h6, h6 
					{
                                                font-family : {$h6_font_family} !important;
						font-size: {$h6_font_size};
						font-weight: {$h6_font_weight};
						line-height: {$h6_line_height};
						color: {$h6_color};
					}
					.sidebar .nav > li > a:focus, .sidebar .nav > li > a.active {
						border-left-color: {$primary_clr};
					}
					.sidebar .nav > li > a:hover i, .sidebar .nav > li > a:focus i, .sidebar .nav > li > a.active i {
						color: {$primary_clr};
					}
					.catz-boxes:hover 
					{
						border: 1px solid {$primary_clr};
					}
					
					.btn-theme , .mega-menu.header2 .menu-button li.post-btn , .event-hero-intro-search button , .header-top .header-top-profile ul li.ad-listing-btn a  ,.with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn , .typeahead__container.hero9 button , .n-header-4 .mega-menu .menu-button li.post-btn , .btn-admin   {
						background-color: {$regular_clr};
						border-color: {$regular_clr};
					}
					.s-call-action-content .btn-theme , .s-listing-gallery li.s-gallery-box .s-gallery-content .btn-theme {
						background: {$hover_clr};
						border-color: {$hover_clr};
					}
					.new-hero-search-bar .submit {
						background: {$hover_clr};
					}
					.new-hero-search-bar .submit:hover {
						background: {$regular_clr};
					}
					.new-hero-search-bar .submit:focus, .new-hero-search-bar .submit:active {
						background: {$active_clr};
					}
					
					.header-top .header-top-profile ul li.ad-listing-btn  {
						border: 1px solid {$regular_clr};
					}
					
					.recent-tab ul.nav.nav-tabs li.active a {
						background-color: {$regular_clr};
					}
					
					.landing-carousel .owl-theme .owl-nav [class*='owl-']:hover {
						background: {$hover_clr};
					}
					.btn-theme:hover,  .mega-menu.header2 .menu-button li.post-btn:hover, .event-hero-intro-search button:hover, .header-top .header-top-profile ul li.ad-listing-btn a:hover ,  .listing-widget-sidebar .input-group .input-group-btn .btn-default:hover , .location-filters .input-group  .input-group-btn .btn-default:hover , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn:hover , .custom-form-field .input-group .input-group-btn .btn-default:hover , .typeahead__container.hero9 button:focus, .typeahead__container.hero9 button:hover , .typeahead__container.hero9 button:focus, .typeahead__container.hero9 button:hover , .n-header-4 .mega-menu .menu-button li.post-btn:hover , .btn-admin:hover , .btn-main:hover    {
						background-color: {$hover_clr};
						border-color: {$hover_clr};
					}
					.list-detail  .event_type2.owl-carousel .owl-next,.list-detail  .event_type2.owl-carousel .owl-prev 
					{
						border: 1px solid {$primary_clr} !important;
						background: {$primary_clr} !important;
					}
					.typeahead__container.hero9 button.active, .typeahead__container.hero9 button:active
					{
						background-color: {$hover_clr};
						border-color: {$hover_clr};
					}
					
					
					.header-top .header-top-profile ul li.ad-listing-btn:hover {
						border: 1px solid {$hover_clr};
					}
					
					.listing-widget-sidebar .input-group  .btn-default:focus , .location-filters .input-group  .input-group-btn .btn-default:focus , .custom-form-field .input-group .input-group-btn .btn-default:hover {
						 background-color: {$active_clr};
						border-color: {$active_clr};
						color:#fff;
					}
					
					.btn-theme:active, .btn-theme.active , .btn-theme:focus ,  .mega-menu.header2 .menu-button li.post-btn:focus ,  .mega-menu.header2 .menu-button li.post-btn.active , .event-hero-intro-search button.active  , .event-hero-intro-search button:active, .event-hero-intro-search button:focus , .listing-widget-sidebar .input-group .input-group-btn .btn-default.active, .location-filters .input-group  .input-group-btn .btn-default.active , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn.active , .with-solid-menu.menu-transparent .mega-menu.transparent .menu-button li.post-btn:focus , .custom-form-field .input-group .input-group-btn .btn-default:hover{
						background-color: {$active_clr};
						border-color: {$active_clr};
					}
								
					.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover , .btn-main{
						background-color: {$primary_clr};
						border-color: {$primary_clr};
					}
					.pagination li > a:hover {
							background-color: {$primary_clr};
							border: 1px solid {$primary_clr};
					}
					.p-about-us .p-absolute-menu a {
						 border: 3px solid {$primary_clr};
					}
					
					.navbar-nav .dropdown-menu {
						border-top: 2px solid {$primary_clr};
					}
					
					.listing-details h4 a:hover , .ad-archive-desc h3:hover, .ad-archive-desc h3 a:hover , .ad-archive-desc .ad-meta .read-more:hover, .dwt_listing_shop-grid-description h2:hover , .mega-menu .drop-down-multilevel li:hover > a , .single-post .short-detail .list-category ul li a , .single-post .list-meta .list-meta-with-icons a , .sidebar .profile-widget .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover , .modern-version-block-info .post-author a:hover , .blog-sidebar .widget ul li a:hover ,  .dark-footer .list li a:hover , .dark-footer  .list li i  , .search-catz i , .tags i , .feedback-type2 .feedback-desc h6,  #dwt-admin-wrap .collaspe-btn-admin,  .listing-viewed-stats > li.my-active-clr {
						color: {$primary_clr};
					}
					
					.draw-border:hover::before, .draw-border:hover::after {
  							border-color: {$primary_clr};
					}

					
					.sidebar .profile-widget .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
						border-bottom: 2px solid {$primary_clr};
					}
					
					.hero-list-event .search-container .tab .nav-tabs li.active a::after {
						border-top: 7px solid {$primary_clr};
					}
					
					.hero-list-event .search-container .tab .tab-content {
						border-bottom: 3px solid {$primary_clr};
					}
					
					.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover , .select2-container .select2-dropdown .select2-results__option--highlighted , .hero-list-event .search-container .tab .nav-tabs li.active a , #papular-listing .papular-listing-2-slider.owl-carousel .owl-nav button.owl-next, #papular-listing .papular-listing-2-slider.owl-carousel .owl-nav button.owl-prev, #papular-listing .papular-listing-2-slider.owl-carousel button.owl-dot , .cities-grid-area-2 hr , .single-event-detials .owl-theme .owl-dots .owl-dot.active span, .single-event-detials .owl-theme .owl-dots .owl-dot:hover span , .input-group-addon button , .search-form .input-group-addon , .blog-sidebar .widget .widget-heading h4::before , .dark-footer ul.social li a:hover {
						background-color: {$primary_clr};
					}
					
					a:hover, a:focus , .ad-archive-desc .category-title a , .testimonial-style-2 .testimonial .post , .blog-section-2 .blog-inner-box .blog-lower-box h3 a:hover , .ft-right ul li a:hover , .event-list-cat.red span , .card-agent-6 .card-title a:hover , .card-agent-6 .author-loc span  {
						color: {$primary_clr};
					}
					.scrollup, .related-produt-slider.owl-carousel .owl-nav button.owl-next, .related-produt-slider.owl-carousel .owl-nav button.owl-prev, .related-produt-slider.owl-carousel button.owl-dot , .event-list-cat.red::after , .dropdown-menu > .active > a, .dropdown-menu > .active > a:focus, .dropdown-menu > .active > a:hover , .filters-option-bar .heading-icon {
						background-color: {$primary_clr};
					}
					.highlights h4::before {
						background-color: {$primary_clr};
					}
					
					";
        wp_add_inline_style('dwt-listing-custom', $custom_css);
    }

}

if (is_rtl()) {
    add_action('wp_enqueue_scripts', 'dwt_listing_typography_rtl', 999);
} else {
    add_action('wp_enqueue_scripts', 'dwt_listing_typography', 999);
}

if (!function_exists('dwt_listing_valuesz')) {

    function dwt_listing_valuesz($listing_id = '', $type = '')
    {
        if (isset($type) && $type == 'dwt-events') {
            if ($listing_id != "") {
                $listing_lattitude = get_post_meta($listing_id, 'dwt_listing_event_lat', true);
                $listing_longitide = get_post_meta($listing_id, 'dwt_listing_event_long', true);
            } else {
                $listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
                $listing_longitide = dwt_listing_text('dwt_listing_default_long');
            }
        } else {
            if ($listing_id != "") {
                $listing_lattitude = get_post_meta($listing_id, 'dwt_listing_listing_lat', true);
                $listing_longitide = get_post_meta($listing_id, 'dwt_listing_listing_long', true);
            } else {
                $listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
                $listing_longitide = dwt_listing_text('dwt_listing_default_long');
            }
        }
        wp_localize_script(
            'dwt-listing-custom', // name of js file
            'get_valzz', array(
                'd_map_lat' => $listing_lattitude,
                'd_map_long' => $listing_longitide,
            )
        );
    }

    add_action('wp_enqueue_scripts', 'dwt_listing_valuesz');
}

// DWT Listing Js Static Strings
if (!function_exists('dwt_listing_search_dynamic_valz')) {

    function dwt_listing_search_dynamic_valz($google_lat = '', $google_lon = '')
    {
        $lon = $lat = '';
        if ($google_lat != "" && $google_lon != "") {
            $lat = $google_lat;
            $lon = $google_lon;
        }
        $is_rtl = 0;
        if (is_rtl()) {
            $is_rtl = 1;
        }

        if (isset($_GET['latitude']) && $_GET['latitude'] != "") {
            $lat = $_GET['latitude'];
        }
        if (isset($_GET['longitude']) && $_GET['longitude'] != "") {
            $lon = $_GET['longitude'];
        }
        wp_localize_script(
            'dwt-listing-search', // name of js file
            'search_strings', array(
                's_lat' => $lat,
                's_lon' => $lon,
                'errorLoading' => esc_html__('Please wait...', 'dwt-listing'),
                'inputTooShort' => esc_html__('Please enter 3 or more characters...', 'dwt-listing'),
                'searching' => esc_html__('Searching...', 'dwt-listing'),
                'noResults' => esc_html__('No Results Found.', 'dwt-listing'),
                'rtlz' => $is_rtl,
            )
        );
    }

    add_action('wp_enqueue_scripts', 'dwt_listing_search_dynamic_valz', 100);
}

//Formatted address
if (!function_exists('dwt_listing_get_lat_lon_google')) {

    function dwt_listing_get_lat_lon_google($address)
    {
        global $dwt_listing_options;
        if (!empty($address)) {
            $formattedAddr = str_replace(' ', '+', $address);
            $arrContextOptions = array("ssl" => array("verify_peer" => false, "verify_peer_name" => false));
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=' . $dwt_listing_options['gmap_api_key'] . '&address=' . $formattedAddr . '&sensor=false', false, stream_context_create($arrContextOptions));
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            if (isset($output->results[0]->geometry->location->lat) && isset($output->results[0]->geometry->location->lng)) {
                dwt_listing_search_dynamic_valz($output->results[0]->geometry->location->lat, $output->results[0]->geometry->location->lng);
            }
        }
    }
}

//Check Timezone Iz Valid or not
if (!function_exists('dwt_listing_checktimezone')) {

    function dwt_listing_checktimezone($timezone)
    {
        $zoneList = timezone_identifiers_list(); # list of (all) valid timezones
        if (in_array($timezone, $zoneList)) {
            return true;
        } else {
            return false;
        }
    }
}


//Check Timezone Iz Valid or not
if (!function_exists('dwt_listing_checktimezone_css_options')) {

    function dwt_listing_checktimezone_css_options()
    {
        global $dwt_listing_options;
        $css_editor = '';
        $css_editor = $dwt_listing_options['dwt_listing_css_editor'];
        ?>
        <style>
            <?php echo $css_editor; ?>
        </style>
        <?php
    }

}
add_action('wp_head', 'dwt_listing_checktimezone_css_options', 100);

if (!function_exists('dwt_listing_checktimezone_js_options')) {

    function dwt_listing_checktimezone_js_options()
    {
        global $dwt_listing_options;
        $js_editor = '';
        $js_editor = $dwt_listing_options['dwt_listing_js_editor'];
        ?>
        <script type="text/javascript">
            <?php echo $js_editor; ?>
        </script>
        <?php
    }

}
add_action('wp_head', 'dwt_listing_checktimezone_js_options', 100);

//Search Function Updated
if (!function_exists('dwt_listing_search_query')) {

    function dwt_listing_search_query($paged)
    {
        //for archieve page only
        $tax_query = '';
        $custom_location = '';
        $queried_object = get_queried_object();
        if (!empty($queried_object) && count((array)$queried_object) > 0) {
            $term_id = $queried_object->term_id;
            $tax_name = $queried_object->taxonomy;
            if (!empty($term_id)) {
                $term_idz = get_term_by('id', $term_id, $tax_name);
                $termName = $term_idz->name;
                $term_ID = $term_idz->term_id;
            }
            //Custom Location
            if (dwt_listing_countires_cookies() != "" && !is_tax('l_location')) {
                $custom_location = array(
                    array(
                        'taxonomy' => 'l_location',
                        'field' => 'term_id',
                        'terms' => dwt_listing_countires_cookies(),
                    ),
                );
            }
            $tax_query = array(
                array(
                    'taxonomy' => $tax_name,
                    'field' => 'term_id',
                    'terms' => dwt_listing_show_taxonomy_all($term_ID, $tax_name),
                ),
            );
        }
        //Listing By Rated
        $order = 'DESC';
        $order_by = 'date';
        $key = '';
        //post status active only
        $active_listings = array(
            'key' => 'dwt_listing_listing_status',
            'value' => '1',
            'compare' => '='
        );
        //query 
        $args = array
        (
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'tax_query' => array(
                $tax_query,
                $custom_location
            ),
            'meta_query' => array(
                $active_listings,
            ),
            'order' => $order,
            'orderby' => $order_by,
            'paged' => $paged,
        );
        return $args;
    }

}

//Search Ajax No Result
function dwt_listing_ajax_no_result()
{
    $ad_col = $end_col = '';
    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
        $ad_col = '<div class="col-md-12 col-sm-12 col-xs-12">';
        $end_col = '</div>';
    }
    return '' . $ad_col . '
	<div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('No Result Found.', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("Sorry, we couldn't find any results for this search.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div>
	' . $end_col . '';
}

if (!function_exists('dwt_menu_modalz')) {

    function dwt_menu_modalz($some_id = '')
    {
        echo '<div class="modal fade menu_modalz" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="ModalLabel">New message</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Recipient:</label>
                              <input type="text" class="form-control" id="recipient-name">
                            </div>
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Message:</label>
                              <textarea class="form-control" id="message-text"></textarea>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success">Send message</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>';
    }

}


/* Event Search Function Updated */
if (!function_exists('dwt_listing_events_query')) {

    function dwt_listing_events_query($paged)
    {
        //for archieve page only
        $tax_query = '';
        $queried_object = get_queried_object();
        if (!empty($queried_object) && count((array)$queried_object) > 0) {
            $term_id = $queried_object->term_id;
            $tax_name = $queried_object->taxonomy;
            if (!empty($term_id)) {
                $term_idz = get_term_by('id', $term_id, $tax_name);
                $termName = $term_idz->name;
                $term_ID = $term_idz->term_id;
            }
            $tax_query = array(
                array(
                    'taxonomy' => $tax_name,
                    'field' => 'id',
                    'terms' => dwt_listing_show_taxonomy_all($term_ID, $tax_name),
                ),
            );
        }
        //Listing By Rated
        $order = 'DESC';
        $order_by = 'date';
        $key = '';

        //post status active only
        $active_events = array(
            'key' => 'dwt_listing_event_status',
            'value' => '1',
            'compare' => '='
        );
        //query 
        $args = array
        (
            'post_type' => 'events',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'tax_query' => array(
                $tax_query,
            ),
            'meta_query' => array(
                $active_events,
            ),
            'order' => $order,
            'orderby' => $order_by,
            'paged' => $paged,
        );
        return $args;
    }

}

if (!function_exists('dwt_listing_countires_cookies')) {

    function dwt_listing_countires_cookies()
    {
        $select_val = '';
        if (isset($_COOKIE['dwt_cookie_location']) && $_COOKIE['dwt_cookie_location'] != "") {
            $select_val = $_COOKIE['dwt_cookie_location'];
        }
        return $select_val;
    }

}

// User Featured Listings
if (!function_exists('dwt_listing_get_featured_count')) {

    function dwt_listing_get_featured_count($user_id)
    {
        $count = 0;
        $args = array('post_type' => 'listing', 'author' => $user_id, 'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_listing_status',
                    'value' => 1,
                    'compare' => '=',
                ),
                array(
                    'key' => 'dwt_listing_is_feature',
                    'value' => 1,
                    'compare' => '=',
                ),
            ),
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            return dwt_listing_number_format_short($query->post_count);
        } else {
            return dwt_listing_number_format_short($count);
        }
        wp_reset_postdata();
    }
}

// User Pendings Events
if (!function_exists('dwt_listing_get_pending_events_count')) {

    function dwt_listing_get_pending_events_count($user_id)
    {
        $args = array(
            'post_type' => 'events',
            'post_status' => 'pending',
            'fields' => 'ids',
            'no_found_rows' => false,
            'author' => $user_id,
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_event_status',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $result_query = new WP_Query($args);
        wp_reset_postdata();
        return dwt_listing_number_format_short($result_query->found_posts);
    }

}

// User Pendings Listings
if (!function_exists('dwt_listing_get_pending_listing_count_update')) {

    function dwt_listing_get_pending_listing_count_update($user_id)
    {
        $args = array(
            'post_type' => 'listing',
            'post_status' => 'pending',
            'fields' => 'ids',
            'no_found_rows' => false,
            'author' => $user_id,
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_listing_status',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $result_query = new WP_Query($args);
        wp_reset_postdata();
        return dwt_listing_number_format_short($result_query->found_posts);
    }

}


// User Package History
if (!function_exists('dwt_listing_user_pack_history')) {

    function dwt_listing_user_pack_history($package_id)
    {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && $package_id != "") {
            $options_html = '';
            $yes = dwt_listing_text('d_pkg_yes');
            $no = dwt_listing_text('d_pkg_no');
            /* ==================================== */
            //package expirty days =fk
            if (get_post_meta($package_id, 'package_expiry', true) != "") {
                $package_expiry = get_post_meta($package_id, 'package_expiry', true);
                if ($package_expiry == '-1') {
                    $options_html .= '<li><i class="lnr lnr-sun"></i>' . dwt_listing_text('d_p_exp') . ' : <span>' . dwt_listing_text('d_never_exp') . '</span></li>';
                } else {
                    $options_html .= '<li><i class="lnr lnr-sun"></i>' . dwt_listing_text('d_p_exp') . ' : <span>' . esc_attr($package_expiry) . ' ' . dwt_listing_text('d_pkg_daytxt') . '</span></li>';
                }
            }
            //maximum listings =fk
            if (get_post_meta($package_id, 'regular_listing', true) != "") {

                $regular_listing = get_post_meta($package_id, 'regular_listing', true);
                if ($regular_listing == '-1') {
                    $options_html .= '<li><i class="lnr lnr-text-align-justify"></i>' . dwt_listing_text('d_reg_listing') . ' : <span>' . dwt_listing_text('d_pkg_unlimited') . '</span></li>';
                } else {
                    $options_html .= '<li><i class="lnr lnr-text-align-justify"></i>' . dwt_listing_text('d_reg_listing') . ' : <span>' . esc_attr($regular_listing) . '</span></li>';
                }
            }
            //listing expiry =fk
            if (get_post_meta($package_id, 'listing_expiry', true) != "") {

                $listing_expiry = get_post_meta($package_id, 'listing_expiry', true);
                if ($listing_expiry == '-1') {
                    $options_html .= '<li><i class="lnr lnr-sun"></i>' . dwt_listing_text('d_l_exp') . ' : <span>' . dwt_listing_text('d_never_exp') . '</span></li>';
                } else {
                    $options_html .= '<li><i class="lnr lnr-sun"></i>' . dwt_listing_text('d_l_exp') . ' : <span>' . esc_attr($listing_expiry) . ' ' . dwt_listing_text('d_pkg_daytxt') . '</span></li>';
                }
            }
            //featured listings =fk
            if (get_post_meta($package_id, 'featured_listing', true) != "") {

                $featured_listing = get_post_meta($package_id, 'featured_listing', true);
                if ($featured_listing == '-1') {
                    $options_html .= '<li><i class="lnr lnr-layers"></i>' . dwt_listing_text('d_feat_listing') . ' : <span>' . dwt_listing_text('d_never_exp') . '</span></li>';
                } else {
                    $options_html .= '<li><i class="lnr lnr-layers"></i>' . dwt_listing_text('d_feat_listing') . ' : <span>' . esc_attr($featured_listing) . '</span></li>';
                }
            }
            //featured listing expiry =fk
            if (get_post_meta($package_id, 'featured_listing_expiry', true) != "") {

                $featured_listing_expiry = get_post_meta($package_id, 'featured_listing_expiry', true);
                if ($featured_listing_expiry == '-1') {
                    $options_html .= '<li><i class="lnr lnr-thumbs-up"></i>' . dwt_listing_text('d_feat_for') . ' : <span>' . dwt_listing_text('d_never_exp') . '</span></li>';
                } else {
                    $options_html .= '<li><i class="lnr lnr-thumbs-up"></i>' . dwt_listing_text('d_feat_for') . ' : <span>' . esc_attr($featured_listing_expiry) . ' ' . dwt_listing_text('d_pkg_daytxt') . '</span></li>';
                }
            }
            /* ==================================== */
            if (get_post_meta($package_id, 'video_listing', true) != "") {

                $video_listing = get_post_meta($package_id, 'video_listing', true);
                if ($video_listing == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-camera-video"></i> ' . dwt_listing_text('d_vid_listing') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }
            if (get_post_meta($package_id, 'website_link', true) != "") {
                $website_link = get_post_meta($package_id, 'website_link', true);
                if ($website_link == 'yes') {
                    $w_link = $yes;
                } else {
                    $w_link = $no;
                }
                $options_html .= '<li><i class="lnr lnr-move"></i> ' . dwt_listing_text('d_web_link') . ' : <span>' . esc_attr($w_link) . '</span></li>';
            }
            if (get_post_meta($package_id, 'no_of_images', true) != "") {
                $no_of_images = get_post_meta($package_id, 'no_of_images', true);
                $options_html .= '<li><i class="lnr lnr-camera"></i> ' . dwt_listing_text('d_no_images') . ' : <span>' . esc_attr($no_of_images) . '</span></li>';
            }
            if (get_post_meta($package_id, 'price_range', true) != "") {
                $price_range = get_post_meta($package_id, 'price_range', true);
                if ($price_range == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-cog"></i> ' . dwt_listing_text('d_p_range') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }
            if (get_post_meta($package_id, 'business_hours', true) != "") {
                $business_hours = get_post_meta($package_id, 'business_hours', true);
                if ($business_hours == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-clock"></i> ' . dwt_listing_text('d_b_hours') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }
            if (get_post_meta($package_id, 'allow_tags', true) != "") {
                $allow_tags = get_post_meta($package_id, 'allow_tags', true);
                if ($allow_tags == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-tag"></i> ' . dwt_listing_text('d_llow_tag') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }
            /* ================================= */
            //bump listing =fk
            if (get_post_meta($package_id, 'bump_listing', true) != "") {
                $bump_listing = get_post_meta($package_id, 'bump_listing', true);
                $options_html .= '<li><i class="lnr lnr-thumbs-up"></i>' . dwt_listing_text('d_bump_listing') . ' : <span>' . esc_attr($bump_listing) . '</span></li>';
            }
            //deal offer discount =fk
            if (get_post_meta($package_id, 'allow_coupon_code', true) != "") {
                $allow_coupon_code = get_post_meta($package_id, 'allow_coupon_code', true);
                if ($allow_coupon_code == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-briefcase"></i>' . dwt_listing_text('d_coupon_code') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }
            //events =fk
            if (get_post_meta($package_id, 'create_event', true) != "") {
                $create_event = get_post_meta($package_id, 'create_event', true);
                if ($create_event == 'yes') {
                    $yes_or_no = $yes;
                } else {
                    $yes_or_no = $no;
                }
                $options_html .= '<li><i class="lnr lnr-dice"></i>' . dwt_listing_text('d_create_event') . ' : <span>' . esc_attr($yes_or_no) . '</span></li>';
            }

            /* ================================ */
            return $options_html;
        }
    }

}


if (!function_exists('dwt_listing_defualt_img_url')) {

    function dwt_listing_defualt_img_url()
    {
        global $dwt_listing_options;
        if (isset($dwt_listing_options['dwt_listing_defualt_listing_image']['url']) && $dwt_listing_options['dwt_listing_defualt_listing_image']['url'] != "") {
            return $dwt_listing_options['dwt_listing_defualt_listing_image']['url'];
        } else {
            return trailingslashit(get_template_directory_uri()) . 'assets/images/no-image.png';
        }
    }

}

/* ==========
  Fazal karim
  =========== */

/* == check event is ending on event-detail/event listing == */
if (!function_exists('dwt_listing_check_event_ending')) {

    function dwt_listing_check_event_ending($event_id)
    {
        if ($event_id == '')
            return '';
        global $dwt_listing_options;

        $event_end_dateTime = strtotime(get_post_meta($event_id, 'dwt_listing_event_end_date', true));
        $author_id = get_post_field('post_author', $event_id);
        if (get_user_meta($author_id, 'd_user_timezone', true) != "") {
            $user_time = get_user_meta($author_id, 'd_user_timezone', true);
            if (dwt_listing_checktimezone($user_time) == true) {
                $user_timezone = new DateTime("now", new DateTimeZone($user_time));
                $currentTime = strtotime($user_timezone->format('m/d/Y g:i a'));
            } else {
                //no timezone
                $currentTime = strtotime(date('m/d/Y g:i a'));
            }
        } else {
            //no timezone 
            $currentTime = strtotime(date('m/d/Y g:i a'));
        }
        if ($currentTime > $event_end_dateTime) {
            $status = '0';
            update_post_meta($event_id, 'dwt_listing_event_status', $status);
            //send email when status set to 0
            if (function_exists('dwt_listing_notify_on_event_expire')) {
                dwt_listing_notify_on_event_expire($event_id);
            }
        }
    }

}


/* == get current time.. == */
if (!function_exists('dwt_listing_get_current_datTime')) {

    function dwt_listing_get_current_datTime($event_id)
    {
        $author_id = get_post_field('post_author', $event_id);
        if (get_user_meta($author_id, 'd_user_timezone', true) != "") {
            $user_time = get_user_meta($author_id, 'd_user_timezone', true);
            if (dwt_listing_checktimezone($user_time) == true) {
                $user_timezone = new DateTime("now", new DateTimeZone($user_time));
                $currentTime = strtotime($user_timezone->format('m/d/Y g:i a'));
            } else {//no timezone :(
                $currentTime = strtotime(date('m/d/Y g:i a'));
            }
        } else {
            //no timezone :(
            $currentTime = strtotime(date('m/d/Y g:i a'));
        }
        return $currentTime;
    }

}

/* warning when Event is expired */
if (!function_exists('dwt_listing_event_expired_notification')) {

    function dwt_listing_event_expired_notification()
    {
        return '<div class="s_ajax"><div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('Event Expired.', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("Sorry, Event has been expired.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div></div>';
    }

}

/* warning when Event is expired no more event Tickets*/
if (!function_exists('dwt_listing_event_expired_no_more_tickets_notification')) {

    function dwt_listing_event_expired_no_more_tickets_notification()
    {
        return '<div class="s_ajax"><div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('Event Expired.', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("Sorry, No Tickets Available.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div></div>';
    }

}

/* warning when listing already booked with this listing. */
if (!function_exists('dwt_listing_already_booked_notification')) {

    function dwt_listing_already_booked_notification()
    {
        return '<div class="s_ajax"><div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('List already booked.', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("Sorry, This list already booked with timekit.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div></div>';
    }

}

/* == warning if timekit.io switch is off from options == */
if (!function_exists('dwt_listing_booking_switch_off_notification')) {

    function dwt_listing_booking_switch_off_notification()
    {
        return '<div class="s_ajax"><div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('Booking off by admin.', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("You are not able to use timekit.io, Please contact to admin.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div></div>';
    }

}


/* == warning if you don't have any booking == */
if (!function_exists('dwt_listing_have_no_boking_notification')) {

    function dwt_listing_have_no_boking_notification()
    {
        return '<div class="s_ajax"><div class="alert custom-alert custom-alert--warning" role="alert">
			  <div class="custom-alert__top-side">
				<span class="alert-icon custom-alert__icon  ti-info-alt "></span>
				<div class="custom-alert__body">
				  <h6 class="custom-alert__heading">
				   ' . esc_html__('No Result Found..', 'dwt-listing') . '
				  </h6>
				  <div class="custom-alert__content">
					' . esc_html__("Currently you don't have any booking yet.", 'dwt-listing') . '
				  </div>
				</div>
			  </div>
			</div></div>';
    }

}

/* =========================== */
if (!function_exists('dwt_listing_listing_expiry_checker')) {

    function dwt_listing_listing_expiry_checker($listing_id)
    {
        $packg_id = $list_expir = $author_id = $listing_exp_days = '';
        $author_id = get_post_field('post_author', $listing_id);
        $now = date('Y-m-d');
        $actual_listing_date = get_the_date('Y-m-d');
        if (get_user_meta($author_id, 'package_expiry_logic_date', true) != "") {
            $package_purchase_date = get_user_meta($author_id, 'package_expiry_logic_date', true);
            if (strtotime($actual_listing_date) < strtotime($package_purchase_date)) {
                //dont expire
            } else {
                $packg_id = get_user_meta($author_id, 'd_user_package_id', true);
                $listing_exp_days = get_post_meta($packg_id, 'listing_expiry', true);
                if ($listing_exp_days != '' && $listing_exp_days != '-1' && $listing_exp_days != 0) {
                    if ($packg_id != '') {
                        $total_listing_expir_days = date('Y-m-d', strtotime($actual_listing_date . ' + ' . $listing_exp_days . ' days'));
                        print_r($total_listing_expir_days);
                        if (strtotime($now) > strtotime($total_listing_expir_days)) {
                            update_post_meta($listing_id, 'dwt_listing_listing_status', 0);
                            wp_trash_post($listing_id);
                            //Send email to listing post admin on expire.
                            if (function_exists('dwt_listing_email_on_listing_expire')) {
                                dwt_listing_email_on_listing_expire($listing_id);
                            }
                        }
                    }
                }
            }
        } else {

        }
    }

}


if (!function_exists('dwt_nearby_distance')) {

    function dwt_nearby_distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $rounded_value = $final_distance = '';
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "KM") {
            $final_distance = ($miles * 1.609344);
            $dist = round($final_distance, 1);
            return array('calculated_distance' => $dist);
        } else {
            $dist = round($miles, 1);
            return array('calculated_distance' => $dist);
        }
    }

}


if (!function_exists('dwt_get_listing_expiry_date_only')) {

    function dwt_get_listing_expiry_date_only($listing_id = '')
    {
        $packg_id = $list_expir = $author_id = $listing_exp_days = '';
        if ($listing_id == '') {
            return;
        }
        $author_id = get_post_field('post_author', $listing_id);
        $now = date('Y-m-d'); //current date.
        $actual_listing_date = get_the_date('Y-m-d');
        if (get_user_meta($author_id, 'package_expiry_logic_date', true) != "") {
            $package_purchase_date = get_user_meta($author_id, 'package_expiry_logic_date', true);
            if (strtotime($actual_listing_date) < strtotime($package_purchase_date)) {
                return esc_html__('N/A', 'dwt-listing');
            } else {
                $packg_id = get_user_meta($author_id, 'd_user_package_id', true);
                $listing_exp_days = get_post_meta($packg_id, 'listing_expiry', true);
                if ($listing_exp_days != '' && $listing_exp_days != '-1' && $listing_exp_days != 0) {
                    if ($packg_id != '') {
                        $total_listing_expir_days = date('Y-m-d', strtotime($actual_listing_date . ' + ' . $listing_exp_days . ' days'));
                        return $total_listing_expir_days;
                    }
                } else {
                    return esc_html__('Never Expiry', 'dwt-listing');
                }
            }
        } else {
            return esc_html__('N/A', 'dwt-listing');
        }
    }

}

/*
 * custom language switcher 
 *  */
if (!function_exists('dwt_listing_language_switcher')) {

    function dwt_listing_language_switcher()
    {
        if (function_exists('icl_object_id')) {
            $lang_link = '';
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/translation.png');
            $lang_name = esc_html__('All Languages', 'dwt-listing');
            if (!empty($languages)) {
                ?>
                <ul class="list-inline">
                    <li class="dropdown location-selector">
                        <span class="loc"><?php echo $lang_name; ?></span>
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"
                           data-close-others="true" aria-expanded="false">
                            <img src="<?php echo esc_url($final_img); ?>" alt="<?php echo esc_attr($lang_name); ?>"/>
                        </a>
                        <ul class="dropdown-menu pull-right " style="display: none;">
                            <?php
                            foreach ($languages as $lang) {
                                if ($lang['active']) {
                                    $lang_link = "javascript:void(0)";
                                } else {
                                    $lang_link = esc_url($lang['url']);
                                }
                                ?>
                                <li>
                                    <a href="<?php echo $lang_link; ?>" class="top-lang-selection">
                                        <img src="<?php echo $lang['country_flag_url']; ?>" alt="">
                                        <span><?php echo icl_disp_language($lang['native_name']); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
                <?php
            }
        }
    }

}

function dwt_listing_returnEcho($html = '')
{
    return $html;
}


/* ===================== */
/*    START WPML         */
/* ==================== */
/*
 * set category link in shortcodes
 * according to current language.
 */
if (!function_exists('dwt_cat_link_page')) {

    function dwt_cat_link_page($url)
    {
        $url = $url;
        if (function_exists('icl_object_id')) {
            $url = esc_url(remove_query_arg('lang', $url));
            $url = $url . '?lang=' . ICL_LANGUAGE_CODE;
        }
        return $url;
    }

}

/*
 * @param $object_id integer|string|array The ID/s of the objects to check and return
 * @param $type the object type: post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag etc.
 * @return string or array of object ids
 */
if (!function_exists('dwt_listing_translate_object_id')) {

    function dwt_listing_translate_object_id($object_id, $type)
    {
        $current_language = apply_filters('wpml_current_language', NULL);
        // if array
        if (is_array($object_id)) {
            $translated_object_ids = array();
            foreach ($object_id as $id) {
                $translated_object_ids[] = apply_filters('wpml_object_id', $id, $type, true, $current_language);
            }
            return $translated_object_ids;
        } // if string
        elseif (is_string($object_id)) {
            // check if we have a comma separated ID string
            $is_comma_separated = strpos($object_id, ",");
            if ($is_comma_separated !== FALSE) {
                // explode the comma to create an array of IDs
                $object_id = explode(',', $object_id);
                $translated_object_ids = array();
                foreach ($object_id as $id) {
                    $translated_object_ids[] = apply_filters('wpml_object_id', $id, $type, true, $current_language);
                }
                // make sure the output is a comma separated string (the same way it came in!)
                return implode(',', $translated_object_ids);
            } // if we don't find a comma in the string then this is a single ID
            else {
                return apply_filters('wpml_object_id', intval($object_id), $type, true, $current_language);
            }
        } // if int
        else {
            return apply_filters('wpml_object_id', $object_id, $type, true, $current_language);
        }
    }

}

/* == check page language url for wpml  == */
if (!function_exists('dwt_listing_page_lang_url_callback')) {

    function dwt_listing_page_lang_url_callback($page_url = '')
    {
        global $sitepress;
        if (function_exists('icl_object_id') && $page_url != '') {
            $page_url = apply_filters('wpml_permalink', $page_url, ICL_LANGUAGE_CODE, true);
        }
        return $page_url;
    }

}

/* == get current page id for redirect in  wpml == */
if (!function_exists('dwt_listing_language_page_id_callback')) {

    function dwt_listing_language_page_id_callback($page_id = '')
    {
        global $sitepress;
        if (function_exists('icl_object_id') && function_exists('wpml_init_language_switcher') && $page_id != '' && is_numeric($page_id)) {
            $language_code = $sitepress->get_current_language();
            $lang_page_id = icl_object_id($page_id, 'page', false, $language_code);
            if ($lang_page_id <= 0) {
                $lang_page_id = $page_id;
            }
            return $lang_page_id;
        } else {
            return $page_id;
        }
    }

}

/* == set url params for wpml == */
if (!function_exists('dwt_listing_set_url_param')) {

    function dwt_listing_set_url_param($dwt_listing = '', $key = '', $value = '')
    {
        if ($dwt_listing != '') {
            $dwt_listing = add_query_arg(array($key => $value), $dwt_listing);
            $dwt_listing = dwt_listing_page_lang_url_callback($dwt_listing);
        }
        return $dwt_listing;
    }

}

/* if parameter are multiple like 4 */
if (!function_exists('dwt_listing_set_url_params_multi')) {

    function dwt_listing_set_url_params_multi($dwt_listing = '', $wpml_url_params = '')
    {
        if ($dwt_listing != '') {
            $dwt_listing = add_query_arg(($wpml_url_params), $dwt_listing);
            $dwt_listing = dwt_listing_page_lang_url_callback($dwt_listing);
        }
        return $dwt_listing;
    }

}


/* ===========================================
 *  wpml ( display result within all language or only current language.)
 *=========================================== */
if (!function_exists('dwt_listing_wpml_show_all_posts_callback')) {

    function dwt_listing_wpml_show_all_posts_callback($query_args = array(), $option_name = 'dwt_listing_options', $option_key_name = 'dwt_listing_display_post')
    {
        global $sitepress;
        $dwt_listing_show_posts = false;
        //if (function_exists('icl_object_id') && $query_args != '' && $dwt_listing_show_posts) { comment on 13-aug-2020
        if (!is_admin()) {
            if (function_exists('icl_object_id') && $query_args != '') {
                if (class_exists('Redux')) {
                    $dwt_listing_show_posts = Redux::get_option($option_name, $option_key_name);
                }
                if ($dwt_listing_show_posts == true) {
                    do_action('dwt_listing_wpml_terms_filters');
                    dwt_reset_wpml_taxonomy_data();
                    $query_args['suppress_filters'] = $dwt_listing_show_posts;
                }
            }
        }
        return $query_args;
    }

}

/* ===========================================
 * reset taxonomy data.
 =========================================== */
if (!function_exists('dwt_reset_wpml_taxonomy_data')) {

    function dwt_reset_wpml_taxonomy_data()
    {
        global $sitepress;
        remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
        remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
        remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
    }

}

/* ===============================================================
 wpml function for duplicate post in all language or in current language.
=============================================================== */
add_action('dwt_listing_duplicate_posts_lang_wpml', 'dwt_listing_duplicate_posts_lang', 10, 4);

function dwt_listing_duplicate_posts_lang($org_post_id = 0, $pst_nme = '', $theme_option_ky = 'dwt_listing_options', $wpml_duplicate_post = 'dwt_listing_duplicate_post')
{
    global $sitepress;
    $dwt_duplicate_post = false;
    if (class_exists('Redux')) {
        $dwt_duplicate_post = Redux::get_option($theme_option_ky, $wpml_duplicate_post);
    }
    if (function_exists('icl_object_id') && $org_post_id != 0 && $dwt_duplicate_post) {
        $language_details_original = $sitepress->get_element_language_details($org_post_id, "post_'.$pst_nme.'");
        if (!class_exists('TranslationManagement')) {
            include(ABSPATH . 'wp-content/plugins/sitepress-multilingual-cms/inc/translation-management/translation-management.class.php');
        }
        foreach ($sitepress->get_active_languages() as $lang => $details) {
            if ($lang != $language_details_original->language_code) {
                $iclTranslationManagement = new TranslationManagement();
                $iclTranslationManagement->make_duplicate($org_post_id, $lang);
            }
        }
    }
}

/* wpml functions for framwork */
/*
 * Duplicate post from backend
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
    $dwt_listing_duplicate_posts = false;
    if (class_exists('Redux')) {
        $dwt_listing_duplicate_posts = Redux::get_option('dwt_listing_options', 'dwt_listing_duplicate_post');
    }
    if ($dwt_listing_duplicate_posts) {
        add_action('wp_insert_post', 'post_duplicate_on_publish');

        function post_duplicate_on_publish($post_id)
        {
            $post = get_post($post_id);
            if ($post->post_type == 'listing' || $post->post_type == 'events') {
                /* don't save for autosave */
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return $post_id;
                }
                /* dont save for revisions */
                if (isset($post->post_type) && $post->post_type == 'revision') {
                    return $post_id;
                }
                /* we need this to avoid recursion see add_action at the end */
                remove_action('wp_insert_post', 'post_duplicate_on_publish');
                /* make duplicates if the post being saved */
                /* #1. itself is not a duplicate of another or */
                /* #2. does not already have translations */
                $is_translated = apply_filters('wpml_element_has_translations', '', $post_id, $post->post_type);
                if (!$is_translated) {
                    do_action('wpml_admin_make_post_duplicates', $post_id);
                }
                /* must hook again - see remove_action further up */   
                add_action('wp_insert_post', 'post_duplicate_on_publish');
            }
        }

    }
}

/* include hidden value for language parameter */
if (!function_exists('dwt_listing_form_lang_field_callback')) {

    function dwt_listing_form_lang_field_callback($echo = false)
    {
        global $sitepress;
        $hidden_lang_html = '';
        if (class_exists('SitePress')) {
            if (function_exists('icl_object_id')) {
                if ($sitepress->get_setting('language_negotiation_type') == 3) {
                    $hidden_lang_html = '<input name="lang" id="lang" type="hidden" value="' . ICL_LANGUAGE_CODE . '">';
                }
            }
        }
        if ($echo) {
            echo dwt_listing_returnEcho($hidden_lang_html);
        } else {
            return $hidden_lang_html;
        }
    }

}


/*
 * show record in all language.
 * related to specific taxonomy.
 * related to specific custom tags.
 * related to specific custom region.
 * 1 => if display all post switch ON.
 * 2 => if WPML is active.
 */
if (!function_exists('dwt_listing_show_taxonomy_all')) {

    function dwt_listing_show_taxonomy_all($taxo_id, $taxo_nme)
    {
        global $sitepress;
        $dwt_listing_show_posts = false;
        if (class_exists('Redux')) {
            $dwt_listing_show_posts = Redux::get_option('dwt_listing_options', 'dwt_listing_display_post');
        }
        if (function_exists('icl_object_id') && $dwt_listing_show_posts) {
            $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
            $taxo = array();
            foreach ($languages as $val) {
                $taxo[] = apply_filters('wpml_object_id', $taxo_id, $taxo_nme, FALSE, $val['code']);
            }
            //return original id if only one language.
            return $taxo;
        } else {
            return $taxo_id;
        }
    }

}

if (!function_exists('has_field_required')) {
    function has_field_required($field_required = '')
    {
        if ($field_required != '') {
            global $dwt_listing_options;
            $field_req = array();
            if ($dwt_listing_options[$field_required]) {
                $field_req['spann'] = "*";
                $field_req['reqq'] = 'required';
            }
            return $field_req;
        }
    }
}   /* == end wpml == */