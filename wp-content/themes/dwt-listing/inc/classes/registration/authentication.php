<?php
// sign up form
if (!class_exists('authentication')) {

    class authentication {
        
    }

}

// Goog re-capthca verification
if (!function_exists('dwt_listing_recaptcha_verify')) {

    function dwt_listing_recaptcha_verify($api_secret, $code, $ip, $enable_captcha) {
        if ($enable_captcha == 1)
            return true;
        global $dwt_listing_theme;
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $api_secret . '&response=' . $code . '&remoteip=' . $ip;
        $responseData = wp_remote_get($url);
        $res = json_decode($responseData['body'], true);
        if ($res["success"] === true) {
            return true;
        } else {
            return false;
        }
    }

}

// Ajax handler for Login User
add_action('wp_ajax_dwt_listing_login_user', 'dwt_listing_login_user');
add_action('wp_ajax_nopriv_dwt_listing_login_user', 'dwt_listing_login_user');
// Login User

if (!function_exists('dwt_listing_login_user')) {

    function dwt_listing_login_user() {
        global $dwt_listing_options;
        // Getting values
        $params = array();
        parse_str($_POST['collect_data'], $params);

        $email = sanitize_text_field($params['log_email']);
        $password = sanitize_text_field($params['log_password']);

        $remember = false;
        if ($params['is_remember']) {
            $remember = true;
        }
        $user = wp_authenticate($email, $password);
        if (!is_wp_error($user)) {
            if (count($user->roles) == 0) {
                echo __('Your account is not verified yet.', 'dwt-listing');
                die();
            } else {
                $res = dwt_listing_auto_login($email, $password, $remember);
                if ($res == 1) {
                    echo "1";
                }
            }
        } else {
            echo __('Invalid email or password.', 'dwt-listing');
        }
        die();
    }

}

// Ajax handler for Register User
add_action('wp_ajax_dwt_listing_register_user', 'dwt_listing_do_register_user');
add_action('wp_ajax_nopriv_dwt_listing_register_user', 'dwt_listing_do_register_user');
if (!function_exists('dwt_listing_do_register_user')) {

// Register User
    function dwt_listing_do_register_user() {
        global $dwt_listing_options;
        global $woocommerce;
        $link = '';
        $link = function_exists('wc_get_cart_url') ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
        $params = array();
        $pack_id = '';
        $pack_type = '';
        if (isset($_POST['package_id']) && $_POST['package_id'] != "") {
            $pack_id = $_POST['package_id'];
        }
        if (isset($_POST['package_type']) && $_POST['package_type'] != "") {
            $pack_type = $_POST['package_type'];
        }
        parse_str($_POST['sb_data'], $params);
        $display_name = sanitize_user($params['display_name']);
        $email = sanitize_email($params['email']);
        $password = sanitize_text_field($params['password']);
        if (email_exists($email) == false) {
            $remote_addr = dwt_listing_query_string_func('REMOTE_ADDR');
            $enable_captcha = 0;
            if (dwt_listing_text('dwt_listing_recaptcha') == 1) {
                $enable_captcha = 1;
            }
            if (dwt_listing_recaptcha_verify($dwt_listing_options['google_api_secret'], $params['g-recaptcha-response'], $remote_addr, $enable_captcha == 0)) {
                $user_name = explode('@', $email);
                $u_name = dwt_listing_check_user_name($user_name[0]);
                $uid = wp_create_user($u_name, $password, $email);
                wp_update_user(array('ID' => $uid, 'display_name' => $display_name));
                //selection of new package
                if ($pack_id != "" && $pack_type != "") {
                    dwt_listing_pkg_selection_time($pack_id, $pack_type, $uid);
                } else {
                    //if free package assign option is enabled
                    if (!empty($dwt_listing_options['dwt_listing_enable_packages']) && $dwt_listing_options['dwt_listing_enable_packages'] == true && class_exists('WooCommerce') && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        if (!empty($dwt_listing_options['dwt_listing_package_type'])) {
                            $pack_id = $dwt_listing_options['dwt_listing_package_type'];
                            dwt_listing_store_user_package_admin($uid, $pack_id);
                        }
                    }
                }
                // Email for new user
                if (function_exists('dwt_listing_email_on_new_user')) {
                    dwt_listing_email_on_new_user($uid, '');
                }
                if (isset($dwt_listing_options['dwt_listing_new_user_email_verification']) && $dwt_listing_options['dwt_listing_new_user_email_verification'] == '1') {
                    $user = new WP_User($uid);
                    // Remove all user roles after registration
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    echo '2|';
                    die();
                } else {
                    dwt_listing_auto_login($email, $password, true);
                    if ($pack_id != "" && $pack_type != "" && $pack_type == "free") {

                        echo '3|' . dwt_listing_pagelink('dwt_listing_header-page');
                        die();
                    } else if ($pack_type == "paid") {
                        echo '4|' . $link;
                        die();
                    } else {
                        echo '1|';
                        die();
                    }
                }
            } else {
                echo '5|';
            }
        } else {

            echo esc_html__('Email already exist, please try other one.', 'dwt-listing');
        }
        die();
    }

}


if (!function_exists('dwt_listing_auto_login')) {

    function dwt_listing_auto_login($username, $password, $remember) {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;
        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return false;
        } else {
            if (count($user->roles) > 0) {
                return true;
            } else {
                return 2;
            }
        }
    }

}
//associating a function to login hook
add_action('wp_login', 'carspot_set_last_login');

//function for setting the last login
if (!function_exists('carspot_set_last_login')) {

    function carspot_set_last_login($login) {
        $user = get_user_by('login', $login);
        //add or update the last login value for logged in user
        update_user_meta($user->ID, '_sb_last_login', time());
    }

}
// Last login time
if (!function_exists('dwt_listing_get_last_login')) {

    function dwt_listing_get_last_login($uid) {
        $from = get_user_meta($uid, '_sb_last_login', true);
        $time_diff = esc_html__('50 Years', 'dwt-listing');
        if ($from != '') {
            $time_diff = human_time_diff($from, time());
        }
        return $time_diff;
    }

}



// Ajax handler for Social login
add_action('wp_ajax_dwt_listing_social_login', 'dwt_listing_check_social_user');
add_action('wp_ajax_nopriv_dwt_listing_social_login', 'dwt_listing_check_social_user');
if (!function_exists('dwt_listing_check_social_user')) {

    function dwt_listing_check_social_user() {
        global $wp_session;
        global $dwt_listing_options;
        $pack_id = '';
        $pack_type = '';
        //===

        $network = (isset($_POST['sb_network'])) ? $_POST['sb_network'] : '';
        $response_response = false;
        $user_email = "";
        if ($network == 'facebook') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://graph.facebook.com/me?fields=name,email&access_token=$access_token");
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_email = $info->email;
                        $response_response = true;
                    }
                }
            }
        } else if ($network == 'google') {
            $access_token = (isset($_POST['access_token'])) ? $_POST['access_token'] : '';
            $token_verify = wp_remote_get("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=$access_token");
            if (isset($token_verify['response']['code']) && $token_verify['response']['code'] == '200') {
                $info = (json_decode($token_verify['body']));
                if (isset($_POST['email']) && isset($token_verify['body'])) {
                    if (isset($info->email) && $info->email == $_POST['email']) {
                        $user_email = $info->email;
                        $response_response = true;
                    }
                }
            }
        }
        if ($response_response == false) {
            echo '0|error|Invalid request|Diret Access not allowed';
            die();
        }
        //===


        if (!empty($_POST['package_id'])) {
            $pack_id = $_POST['package_id'];
        }
        if (!empty($_POST['package_type'])) {
            $pack_type = $_POST['package_type'];
        }
        $display_name = sanitize_text_field($_POST['name']);
        //$user_email = sanitize_text_field($_POST['email']);
        $exists = email_exists($user_email);
        if ($exists) {
            $user = get_user_by('email', $user_email);
            $user_id = $user->ID;
            if ($user) {
                wp_set_current_user($user_id, $user->user_login);
                wp_set_auth_cookie($user_id);
                //do_action( 'wp_login', $user->user_login );
                echo '1|';
            }
        } else {
            // Here we need to register user.
            $password = mt_rand(1000, 999999);
            $uid = dwt_listing_do_socialregister($display_name, $user_email, $password, $pack_id, $pack_type);
            if (function_exists('dwt_listing_email_on_new_user')) {
                dwt_listing_email_on_new_user($uid, $password);
            }
            echo '0|';
        }
        die();
    }

}

if (!function_exists('dwt_listing_do_socialregister')) {

    function dwt_listing_do_socialregister($display_name = '', $email = '', $password = '', $pack_id = '', $pack_type = '') {
        global $dwt_listing_options;
        global $woocommerce;

        $u_name = dwt_listing_check_user_name($display_name);
        $uid = wp_create_user($u_name, $password, $email);
        wp_update_user(array('ID' => $uid, 'display_name' => $u_name));
        dwt_listing_auto_login($email, $password, true);
        //selection of new package
        if ($pack_id != "" && $pack_type != "") {
            dwt_listing_pkg_selection_time($pack_id, $pack_type, $uid);
        } else {
            //if free package assign option is enabled
            if (!empty($dwt_listing_options['dwt_listing_enable_packages']) && $dwt_listing_options['dwt_listing_enable_packages'] == true && class_exists('WooCommerce') && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                if (!empty($dwt_listing_options['dwt_listing_package_type'])) {
                    $pack_id = $dwt_listing_options['dwt_listing_package_type'];
                    dwt_listing_store_user_package_admin($uid, $pack_id);
                }
            }
        }
        return $uid;
    }

}


if (!function_exists('dwt_listing_authenticate_check')) {

    function dwt_listing_authenticate_check() {
        if (get_current_user_id() == 0) {
            echo '0|' . __("You are not logged in.", 'dwt-listing');
            die();
        }
    }

}


if (!function_exists('check_if_not_logged')) {

    function check_if_not_logged() {
        global $dwt_listing_options;
        if (get_current_user_id() == "") {
            echo dwt_listing_redirect(home_url('/'));
        }
    }

}
if (!function_exists('carspot_user_logged_in')) {

    function carspot_user_logged_in() {
        if (get_current_user_id() != "") {
            echo carspot_redirect(home_url('/'));
        }
    }

}
if (!function_exists('dwt_listing_check_user_name')) {

    function dwt_listing_check_user_name($username = '') {
        if (username_exists($username)) {
            $random = rand(10, 100);
            $username = $username . '-' . $random;
            dwt_listing_check_user_name($username);
        }
        return $username;
    }

}

add_action('wp_ajax_dwt_listing_reset_password', 'dwt_listing_reset_password');
add_action('wp_ajax_nopriv_dwt_listing_reset_password', 'dwt_listing_reset_password');
// Reset Password
if (!function_exists('dwt_listing_reset_password')) {

    function dwt_listing_reset_password() {
        global $dwt_listing_options;
        // Getting values
        $params = array();
        parse_str($_POST['collect_data'], $params);
        $token = $params['token'];
        $token_arr = explode('-dwt_listing_uid-', $token);
        $key = $token_arr[0];
        $uid = $token_arr[1];
        $token_db = get_user_meta($uid, 'dwt_listing_password_forget_token', true);
        if ($token_db != $key) {
            echo esc_html__("Invalid security token.", 'dwt-listing');
        } else {
            $new_password = sanitize_text_field($params['dwt_listing_new_password']);
            wp_set_password($new_password, $uid);
            update_user_meta($uid, 'dwt_listing_password_forget_token', '');
            echo '1|' . home_url('/');
        }
        die();
    }

}