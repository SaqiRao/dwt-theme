<?php
function dwt_listing_add_code($id, $func)
{
    add_shortcode($id, $func);
}

function dwt_listing_decode($html)
{
    return base64_decode($html);
}

if (!function_exists('dwt_listing_query_string_func')) {

    function dwt_listing_query_string_func($string = '')
    {
        if ($string == "")
            return '';
        return $_SERVER["$string"];
    }

}

if (!function_exists('dwt_listing_admin_bar')) {

    function dwt_listing_admin_bar()
    {
        global $wp_admin_bar;
        $wp_admin_bar->add_menu(
            array(
                'id' => 'dwt-listing-forum',
                'title' => 'Support Forum',
                'href' => 'https://scriptsbundle.ticksy.com/',
                'meta' => array(
                    'target' => '_blank'
                )
            )
        );

        $wp_admin_bar->add_menu(
            array(
                'id' => 'dwt-listing-documentation',
                'title' => 'Documentation',
                'href' => 'http://documentation.scriptsbundle.com/docs/dwt-listing-directory-listing-wordpress-theme/',
                'meta' => array(
                    'target' => '_blank'
                )
            )
        );
    }

    add_action('admin_bar_menu', 'dwt_listing_admin_bar', 100);
}

//Send Email On New User Registration
function dwt_listing_email_on_new_user($user_id, $social = '', $admin_email = true)
{
    global $dwt_listing_options;

    if (isset($dwt_listing_options['dwt_listing_new_user_email_to_admin']) && $dwt_listing_options['dwt_listing_new_user_email_to_admin'] && $admin_email) {
        if (isset($dwt_listing_options['dwt_listing_new_user_admin_message']) && $dwt_listing_options['dwt_listing_new_user_admin_message'] != "" && isset($dwt_listing_options['dwt_listing_new_user_admin_message_from']) && $dwt_listing_options['dwt_listing_new_user_admin_message_from'] != "") {
            $to = get_option('admin_email');
            $subject = $dwt_listing_options['dwt_listing_new_user_admin_message_subject'];
            $from = $dwt_listing_options['dwt_listing_new_user_admin_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            // User info
            $user_info = get_userdata($user_id);
            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);
            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_new_user_admin_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

    if (isset($dwt_listing_options['dwt_listing_new_user_email_to_user']) && $dwt_listing_options['dwt_listing_new_user_email_to_user']) {
        if (isset($dwt_listing_options['dwt_listing_new_user_message']) && $dwt_listing_options['dwt_listing_new_user_message'] != "" && isset($dwt_listing_options['dwt_listing_new_user_message_from']) && $dwt_listing_options['dwt_listing_new_user_message_from'] != "") {
            // User info
            $user_info = get_userdata($user_id);
            $to = $user_info->user_email;
            $subject = $dwt_listing_options['dwt_listing_new_user_message_subject'];
            $from = $dwt_listing_options['dwt_listing_new_user_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $user_name = $user_info->user_email;
            if ($social != '')
                $user_name .= "(Password: $social )";
            $verification_link = '';

            if (isset($dwt_listing_options['dwt_listing_new_user_email_verification']) && $dwt_listing_options['dwt_listing_new_user_email_verification'] == '1') {
                $token = get_user_meta($user_id, 'dwt_listing_email_verification_token', true);
                if ($token == "") {
                    $token = dwt_listing_randomString(50);
                }
                $verification_link = trailingslashit(get_home_url()) . '?verification_key=' . $token . '-dwt_listing_uid-' . $user_id;
                update_user_meta($user_id, 'dwt_listing_email_verification_token', $token);
            }
            $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);

            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_new_user_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
}

//Resend Activation Email
add_action('wp_ajax_dwt_listing_resend_email', 'dwt_listing_resend_activation_email');
add_action('wp_ajax_nopriv_dwt_listing_resend_email', 'dwt_listing_resend_activation_email');

function dwt_listing_resend_activation_email()
{

    $email = $_POST['usr_email'];
    $user = get_user_by('email', $email);
    if (get_user_meta($user->ID, 'dwt_listing_resent_email', true) != 'yes') {
        dwt_listing_email_on_new_user($user->ID, '', false);
        update_user_meta($user->ID, 'dwt_listing_resent_email', 'yes');
    }
    die();
}

// Ajax handler for Forgot Password
add_action('wp_ajax_dwt_listing_forgot_password', 'dwt_listing_forgot_password');
add_action('wp_ajax_nopriv_dwt_listing_forgot_password', 'dwt_listing_forgot_password');

// Forgot Password
function dwt_listing_forgot_password()
{
    global $dwt_listing_options;
    // Getting values
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $email = sanitize_text_field($params['dwt_listing_forgot_email']);
    if (email_exists($email) == true) {
        $from = get_bloginfo('name');
        if (isset($dwt_listing_options['dwt_listing_forgot_password_from']) && $dwt_listing_options['dwt_listing_forgot_password_from'] != "") {
            $from = $dwt_listing_options['dwt_listing_forgot_password_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($dwt_listing_options['dwt_listing_forgot_password_message']) && $dwt_listing_options['dwt_listing_forgot_password_message'] != "") {
            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));
            $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_forgot_password_subject']);
            $token = dwt_listing_randomString(50);
            $user = get_user_by('email', $email);
            $msg_keywords = array('%site_name%', '%user%', '%reset_link%');
            $reset_link = trailingslashit(get_home_url()) . '?token=' . $token . '-dwt_listing_uid-' . $user->ID;
            $msg_replaces = array(get_bloginfo('name'), $user->display_name, $reset_link);
            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_forgot_password_message']);
            $to = $email;
            $mail = wp_mail($to, $subject, $body, $headers);
            if ($mail) {
                update_user_meta($user->ID, 'dwt_listing_password_forget_token', $token);
                echo "1";
            } else {
                echo "2";
            }
        }
    } else {
        echo esc_html__('Email is not resgistered with us.', 'dwt-listing-framework');
    }
    die();
}

/* == Send email on Event expire. == */
if (!function_exists('dwt_listing_notify_on_event_expire')) {

    function dwt_listing_notify_on_event_expire($pid)
    {
        global $dwt_listing_options;
        $author_id = get_post_field('post_author', $pid);
        
        $user_info = get_userdata($author_id);
        if (isset($dwt_listing_options['dwt_listing_email_event_expire']) && $dwt_listing_options['dwt_listing_email_event_expire']) {
            $to = $user_info->user_email;
            $subject = __('Event Expire', 'dwt-listing-framework') . '-' . get_bloginfo('name');
            $body = '<html><body><p>' . __('Event has been expired', 'dwt-listing-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['dwt_listing_msg_from_on_event_expire']) && $dwt_listing_options['dwt_listing_msg_from_on_event_expire'] != "") {
                $from = $dwt_listing_options['dwt_listing_msg_from_on_event_expire'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($dwt_listing_options['dwt_listing_msg_on_event_expire']) && $dwt_listing_options['dwt_listing_msg_on_event_expire'] != "") {

                $subject_keywords = array('%site_name%', '%event_owner%', '%event_title%');

                $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));

                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_msg_subject_on_event_expire']);

                $msg_keywords = array('%site_name%', '%event_owner%', '%event_title%', '%event_link%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));

                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_msg_on_event_expire']);
            }

            wp_mail($to, $subject, $body, $headers);
        }
    }

}

/* == Send email when listing expire == */
if (!function_exists('dwt_listing_email_on_listing_expire')) {

    function dwt_listing_email_on_listing_expire($pid)
    {
        global $dwt_listing_options;
        $author_id = get_post_field('post_author', $pid);
        $user_info = get_userdata($author_id);
        if (isset($dwt_listing_options['dwt_listing_email_listngs_expire']) && $dwt_listing_options['dwt_listing_email_listngs_expire']) {
            $to = $user_info->user_email;
            $subject = __('Listing Expire', 'dwt-listing-framework') . '-' . get_bloginfo('name');
            $body = '<html><body><p>' . __('Listing has been expired', 'dwt-listing-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['dwt_listing_msg_from_on_listings_expire']) && $dwt_listing_options['dwt_listing_msg_from_on_listings_expire'] != "") {
                $from = $dwt_listing_options['dwt_listing_msg_from_on_listings_expire'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($dwt_listing_options['dwt_listing_msg_on_listings_expire']) && $dwt_listing_options['dwt_listing_msg_on_listings_expire'] != "") {

                $subject_keywords = array('%site_name%', '%listing_owner%', '%listing_title%');
                $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));

                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_msg_subject_on_listings_expire']);
                

                $msg_keywords = array('%site_name%', '%listing_owner%', '%listing_title%', '%listing_link%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));

                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_msg_on_listings_expire']);
            }
            wp_mail($to, $subject, $body, $headers);
        }
    }

}

//Send email on new listing
function dwt_listing_notify_on_new_listing($pid)
{
    global $dwt_listing_options;
    if (isset($dwt_listing_options['dwt_listing_email_on_listing']) && $dwt_listing_options['dwt_listing_email_on_listing']) {
        $to = $dwt_listing_options['dwt_listing_get_listing_email'];
        $subject = __('New Ad', 'dwt-listing-framework') . '-' . get_bloginfo('name');
        $body = '<html><body><p>' . __('Got new ad', 'dwt-listing-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
        $from = get_bloginfo('name');
        if (isset($dwt_listing_options['dwt_listing_msg_from_on_new_ad']) && $dwt_listing_options['dwt_listing_msg_from_on_new_ad'] != "") {
            $from = $dwt_listing_options['dwt_listing_msg_from_on_new_ad'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($dwt_listing_options['dwt_listing_msg_on_new_ad']) && $dwt_listing_options['dwt_listing_msg_on_new_ad'] != "") {
            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);
            $subject_keywords = array('%site_name%', '%ad_owner%', '%ad_title%');
            $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));
            $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_msg_subject_on_new_ad']);
            $msg_keywords = array('%site_name%', '%ad_owner%', '%ad_title%', '%ad_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));
            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_msg_on_new_ad']);
        }
        wp_mail($to, $subject, $body, $headers);
    }
}

//Send email on listing approval
function dwt_listing_notify_on_listing_approval($pid)
{
    global $dwt_listing_options;
    $from = get_bloginfo('name');
    if (isset($dwt_listing_options['dwt_listing_active_ad_email_from']) && $dwt_listing_options['dwt_listing_active_ad_email_from'] != "") {
        $from = $dwt_listing_options['dwt_listing_active_ad_email_from'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($dwt_listing_options['dwt_listing_active_ad_email_message']) && $dwt_listing_options['dwt_listing_active_ad_email_message'] != "") {

        $author_id = get_post_field('post_author', $pid);
        $user_info = get_userdata($author_id);
        $subject = $dwt_listing_options['dwt_listing_active_ad_email_subject'];
        $msg_keywords = array('%site_name%', '%user_name%', '%ad_title%', '%ad_link%');
        $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));
        $to = $user_info->user_email;
        $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_active_ad_email_message']);
        wp_mail($to, $subject, $body, $headers);
    }
}

// Report Listing
add_action('wp_ajax_dwt_listing_listing_report', 'dwt_listing_listing_report_claim');
add_action('wp_ajax_nopriv_dwt_listing_listing_report', 'dwt_listing_listing_report_claim');

function dwt_listing_listing_report_claim()
{
    global $dwt_listing_options;
    // Getting values
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $report_cat = sanitize_text_field($params['report_cat']);
    $report_reason = sanitize_text_field($params['report_reason']);
    $listing_id = sanitize_text_field($params['listing_id']);
    if (get_current_user_id() == 0) {
        echo '0|' . __("Please Login to Report this Listing.", 'dwt-listing-framework');
    } else if (get_post_meta($listing_id, 'dwt_listing_reported_user_id' . get_current_user_id(), true) == get_current_user_id()) {
        echo '0|' . __("You have reported this listing already.", 'dwt-listing-framework');
    }
    else {
        $count = get_post_meta($listing_id, 'dwt_listing_report_count_limit', true);
        if ((int)$count <= $dwt_listing_options['report_limit']) {
            update_post_meta($listing_id, 'dwt_listing_reported_user_id' . get_current_user_id(), get_current_user_id());
            update_post_meta($listing_id, 'dwt_listing_report_category' . get_current_user_id(), $report_cat);
            update_post_meta($listing_id, 'dwt_listing_report_reason' . get_current_user_id(), $report_reason);

            $count = (int)$count + 1;
            update_post_meta($listing_id, 'dwt_listing_report_count_limit', $count);

            if ($dwt_listing_options['report_action'] == '1') {
                $my_post = array(
                    'ID' => $listing_id,
                    'post_status' => 'pending',
                );
                wp_update_post($my_post);
            } else {
                // Sending email
                $to = $dwt_listing_options['report_email'];
                $subject = __('Ad Reported', 'dwt-listing-framework');
                $body = '<html><body><p>' . __('Users reported this listing, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($listing_id) . '">' . get_the_title($listing_id) . '</a></p></body></html>';

                $from = get_bloginfo('name');
                if (isset($dwt_listing_options['sb_report_ad_from']) && $dwt_listing_options['sb_report_ad_from'] != "") {
                    $from = $dwt_listing_options['sb_report_ad_from'];
                }
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                if (isset($dwt_listing_options['sb_report_ad_message']) && $dwt_listing_options['sb_report_ad_message'] != "") {
                    $subject_keywords = array('%site_name%', '%ad_title%');
                    $subject_replaces = array(get_bloginfo('name'), get_the_title($listing_id));
                    $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['sb_report_ad_subject']);
                    $author_id = get_post_field('post_author', $listing_id);
                    $user_info = get_userdata($author_id);
                    $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%', '%report_reason%');
                    $msg_replaces = array(get_bloginfo('name'), get_the_title($listing_id), get_the_permalink($listing_id), $user_info->display_name, $report_reason);
                    $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['sb_report_ad_message']);
                }
                wp_mail($to, $subject, $body, $headers);
            }
            echo '1|' . __("You have reported this listing successfully.", 'dwt-listing-framework');
        } else {
            echo '0|' . __("Your Reporting Limit is Completed.", 'dwt-listing-framework');
        }
    }
    die();
}

// Send Message To Listing Owner
add_action('wp_ajax_send_msg_to_listing_owner', 'dwt_listing_msg_to_listing_owner');
add_action('wp_ajax_nopriv_send_msg_to_listing_owner', 'dwt_listing_msg_to_listing_owner');

function dwt_listing_msg_to_listing_owner()
{
    global $dwt_listing_options;
    // Getting values
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $name = sanitize_text_field($params['name']);
    $email = sanitize_email($params['email']);
    $phone = sanitize_text_field($params['phone']);
    $message = sanitize_text_field($params['message']);
    $listing_id = sanitize_text_field($params['posted_listing_id']);
    $listing_owner_email = dwt_listing_listing_owner($listing_id, 'email');
    $to = $listing_owner_email;
    if (get_post_meta($listing_id, 'dwt_listing_related_email', true) != "") {
        $to = get_post_meta($listing_id, 'dwt_listing_related_email', true);
    }

    $subject = __('New Message', 'dwt-listing-framework');
    $body = '<html><body><p>' . __('Got new message on listing', 'dwt-listing-framework') . ' ' . get_the_title($listing_id) . '</p><p>' . $params['message'] . '</p></body></html>';
    $from = get_bloginfo('name');
    
    if (isset($dwt_listing_options['dwt_listing_message_from_on_new_ad']) && $dwt_listing_options['dwt_listing_message_from_on_new_ad'] != "") {
        $from = $dwt_listing_options['dwt_listing_message_from_on_new_ad'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    
    if (isset($dwt_listing_options['dwt_listing_message_on_new_listing']) && $dwt_listing_options['dwt_listing_message_on_new_listing'] != "") {
        $subject_keywords = array('%site_name%', '%ad_title%');
        $subject_replaces = array(get_bloginfo('name'), get_the_title($listing_id));
        $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_message_subject_on_new_ad']);
        $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%message%', '%sender_name%', '%sender_contact%', '%sender_email%');
        $msg_replaces = array(get_bloginfo('name'), get_the_title($listing_id), get_the_permalink($listing_id), $message, $name, $phone, $email);
        $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_message_on_new_listing']);
    }

    $sent_message = wp_mail($to, $subject, $body, $headers);

    //display message based on the result.
    if ($sent_message) {
        // The message was sent.
        echo '1|' . __("Message sent successfully.", 'dwt-listing-framework');
    } else {
        // The message was not sent.
        echo '0|' . __("Message not sent, please try again later.", 'dwt-listing-framework');
    }
    die();
}


// Send Chat Message To Listing Owner
add_action('wp_ajax_send_chat_msg_to_listing_owner', 'dwt_listing_send_chat_msg_to_listing_owner');
add_action('wp_ajax_nopriv_send_chat_msg_to_listing_owner', 'dwt_listing_send_chat_msg_to_listing_owner');

function dwt_listing_send_chat_msg_to_listing_owner()
{

    if(!class_exists('SB_Chat')){
        echo '0|' . __("Please install Sb chat plugin to enable chat feature.", 'dwt-listing-framework');
    }

    if(get_current_user_id() == 0)
    {
        echo '2|' . __("Message not sent, please login first.", 'dwt-listing-framework');
    }



    global $dwt_listing_options;
    // Getting values
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $message = sanitize_text_field($params['message']);
    $listing_id = sanitize_text_field($params['posted_listing_id']);

    $my_post = get_post( $listing_id );
    $receiver_id = $my_post->post_author;

    $sender_id = get_current_user_id();
    
    $conversation['recipient'] = $receiver_id;
    $conversation['message'] = $message;

    $conversation_exists = sb_conversation_exists($receiver_id);
        if ($conversation_exists > 0 && !empty($conversation_exists)):
            $conversation_id = $conversation_exists;
        else:
            $conversation_id = sb_start_conversation($conversation);
        endif;

        if (!empty($conversation_id) && $conversation_id > 0) {
            $new_message['conversation_id'] = $conversation_id;
            $new_message['sender_id'] = $sender_id;
            $new_message['receiver_id'] = $receiver_id;
            $new_message['message'] = $message;
        }

        $message_sent = sb_send_new_message($new_message);

        if ($message_sent) {
            echo '1|' . __("Message sent successfully.", 'dwt-listing-framework');
        }
        else
        {
            echo '0|' . __("Message not sent, please try again later.", 'dwt-listing-framework');
        }
    die();
    // print_r($message);

    // print_r($author_id);
    // $receiver_id = 1;
//     $sender_id = get_current_user_id();
//     // $sender_id = 1;


//     $query = $wpdb->prepare("
//     SELECT id
//     FROM {$wpdb->prefix}sb_chat_conversation 
//     WHERE (user_1 = %d AND user_2 = %d)
// ", $sender, $receiver_id);

// $conversation_id = $wpdb->get_var($query);

// if ($conversation_id) {
//     echo $conversation_id;
//     die();
// } else {
//         echo "else"; 
//     die();
// }

//     global $wpdb;
//      $wpdb->insert(
//         $wpdb->prefix . 'sb_chat_conversation',
//         array(
//             'user_1' => get_current_user_id(), 
//             'user_2' => $receiver_id, 
//             'read_user_1' => 0, 
//             'read_user_2' => 0,
//         ),
//         array(
//             '%d',
//             '%d',
//             '%s',
//             '%d',
//             '%d',
//             '%d',
//         )
//     );

//     if (isset($wpdb->insert_id)) {

//         $id = $wpdb->insert_id;

//       $wpdb->insert(
//         $wpdb->prefix . 'sb_chat_messages',
//         array(
//             'conversation_id' => $id,
//             'sender_id' => $sender_id,
//             'receiver_id' => $receiver_id,
//             'message' => $message,
//             'created_at' => date('yyyy-mm-dd'),
//             'attachment_ids' => 0,
//             'message_type' => 0,
//             'deleted_msgs' => 0,
//             'email_sent' => 0,
//         ),
//         array('%d','%d','%d','%s','%d','%s','%d','%d','%d')
//     );

//     if (isset($wpdb->insert_id)) {
//         // The message was sent.
//         echo '1|' . __("Message sent successfully.", 'dwt-listing-framework');
//     } else {
//         // The message was not sent.
//         echo '0|' . __("Message not sent, please try again later.", 'dwt-listing-framework');
//     }
//     } else {
//         $id = false;
//         echo '0|' . __("Message not sent, please try again later.", 'dwt-listing-framework');
//     }

   
    die();
}
// Get unread messages 
add_action('wp_ajax_get_unread_messages', 'dwt_listing_get_unread_messages');
add_action('wp_ajax_nopriv_get_unread_messages', 'dwt_listing_get_unread_messages');

function dwt_listing_get_unread_messages()
{

    if(!class_exists('SB_Chat')){
        echo '0|' . __("Please install Sb chat plugin to enable chat feature.", 'dwt-listing-framework');
    }

    $current_user_id = get_current_user_id();
    global $wpdb;
    $table_name = $wpdb->prefix . 'sb_chat_messages';
    
    // Modify the query to count rows where receiver_id is equal to $current_user_id
    $count_query = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE receiver_id = %d AND read_status = %d", $current_user_id,0);
    $num = $wpdb->get_var($count_query);
    
    wp_send_json_success(['unread_chatss'=> $num]);
    die();
}

// Claim Process
add_action('wp_ajax_for_claim_listing', 'dwt_listing_claim_listing_report');
add_action('wp_ajax_nopriv_for_claim_listing', 'dwt_listing_claim_listing_report');

function dwt_listing_claim_listing_report()
{
    $listing_post_title = '';
    $claimer_email = '';
    global $dwt_listing_options;
    /* Getting values */
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $claimer_contact = sanitize_text_field($params['claimer_contact']);
    $claimer_message = sanitize_text_field($params['claimer_message']);
    $claim_listing_id = sanitize_text_field($params['claim_listing_id']);
    $claimer_id = sanitize_text_field($params['claimer_id']);
    if (get_user_meta(get_current_user_id(), 'dwt_listing_claimed_listing_id' . $claim_listing_id, true) == $claim_listing_id) {
        if (get_post_meta($claim_listing_id, 'd_listing_claim_status', true) == 'decline') {
            echo '0|' . __("You claim has been declined.", 'dwt-listing-framework');
            die();
        } else {
            echo '0|' . __("You have claimed this listing already.", 'dwt-listing-framework');
            die();
        }
    } else {
        //get user that claim for listing
        $user = get_user_by('id', $claimer_id);
        if ($user) {
            $user_id = $user->ID;
            $claimer_name = $user->display_name;
            $claimer_email = $user->user_email;
        }
        $status = 'pending';
        //get post title
        $listing_post_title = get_the_title($claim_listing_id);
        // Create post object
        $my_post = array(
            'post_title' => wp_strip_all_tags($listing_post_title),
            'post_status' => 'publish',
            'post_author' => $claimer_id,
            'post_type' => 'l_claims',
        );
        // Insert the post into the database
        $new_inserted_id = wp_insert_post($my_post);
        //Update post meta values
        update_post_meta($new_inserted_id, 'd_listing_original_id', $claim_listing_id);
        update_post_meta($new_inserted_id, 'd_listing_claimer_id', $claimer_id);
        update_post_meta($new_inserted_id, 'd_listing_claimer_msg', $claimer_message);
        dwt_listing_l_claims_admin_tables_content('dwt_listing_claim_status', $status, $new_inserted_id);
        dwt_listing_l_claims_admin_tables_content('dwt_listing_claimner_no', $claimer_contact, $new_inserted_id);
        update_user_meta(get_current_user_id(), 'dwt_listing_claimed_listing_id' . $claim_listing_id, $claim_listing_id);
        // Sending email to admin
        if (isset($dwt_listing_options['dwt_listing_is_admin_email']) && $dwt_listing_options['dwt_listing_is_admin_email'] == '1') {
            // Sending email to admin
            $listing_owner_id = dwt_listing_listing_owner($claim_listing_id, 'id');
            $listing_owner_name = dwt_listing_listing_owner($claim_listing_id, 'name');
            $to = get_option('admin_email');
            $subject = __('Claim Listing', 'dwt-listing-framework');
            $body = '<html><body><p>' . __('Users claim this listing, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($claim_listing_id) . '">' . get_the_title($claim_listing_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['downtwon_listing_claim_from']) && $dwt_listing_options['downtwon_listing_claim_from'] != "") {
                $from = $dwt_listing_options['downtwon_listing_claim_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($dwt_listing_options['downtwon_listing_claim_message']) && $dwt_listing_options['downtwon_listing_claim_message'] != "") {
                $subject_keywords = array('%site_name%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($claim_listing_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_listing_subject']);
                $author_id = get_post_field('post_author', $claim_listing_id);
                $user_info = get_userdata($author_id);
                $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%', '%claimed_by%', '%claimer_email%', '%claimer_contact%', '%claim_details%');
                $msg_replaces = array(get_bloginfo('name'), get_the_title($claim_listing_id), get_the_permalink($claim_listing_id), $listing_owner_name, $claimer_name, $claimer_email, $claimer_contact, $claimer_message);
                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_listing_claim_message']);
            }
            wp_mail($to, $subject, $body, $headers);
        }
        echo '1|' . __("Your claim has been submited successfully & waiting for approval.", 'dwt-listing-framework');
        die();
    }
}

// Review Listing Form
add_action('wp_ajax_dwt_listing_listing_reviews', 'dwt_listing_listing_post_reviews');
add_action('wp_ajax_nopriv_dwt_listing_listing_reviews', 'dwt_listing_listing_post_reviews');
if (!function_exists('dwt_listing_listing_post_reviews')) {

    function dwt_listing_listing_post_reviews()
    {
        global $dwt_listing_options;
        $params = array();
        parse_str($_POST['collect_data'], $params);
        //fetch form fields
        $listing_id = sanitize_text_field($params['review_listing_id']);
        $review_title = sanitize_text_field($params['review_title']);
        $review_comments = sanitize_text_field($params['review_comments']);
        $review_stars = sanitize_text_field($params['review_stars']);
        //fetch user data
        $profile = new dwt_listing_profile();
        $reviever_id = $profile->user_info->ID;
        $reviever_email = $profile->user_info->user_email;
        $reviever_id_name = $profile->user_info->display_name;
        //owner cant post rating 
        if (get_post_field('post_author', $listing_id) == $reviever_id) {
            echo '0|' . esc_html__("Listing author can't post review.", 'dwt-listing-framework');
            die();
        }
        //from user dashboard
        if (isset($params['comment_is_dashboard']) && $params['comment_is_dashboard'] != "") {
            $my_comment_id = $params['comment_is_dashboard'];
            $commentarr['comment_ID'] = $my_comment_id;
            $commentarr['comment_approved'] = 1;
            $commentarr['comment_content'] = $review_comments;
            wp_update_comment($commentarr);
            update_comment_meta($my_comment_id, 'review_stars', $review_stars);
            update_comment_meta($my_comment_id, 'review_main_title', $review_title);
            echo '1|' . esc_html__("Review Updated Successfully.", 'dwt-listing-framework');
            die();
        } else {
            //if review limit is enabled
            if (isset($dwt_listing_options['dwt_listing_review_rating_limit']) && $dwt_listing_options['dwt_listing_review_rating_limit'] == 1) {
                $args = array('type__in' => array('listing'), 'post_id' => $listing_id, 'user_id' => $reviever_id, 'number' => 1, 'parent' => 0);
                $if_comment = get_comments($args);
                if (count((array)$if_comment) > 0) {
                    $comment_id = $if_comment[0]->comment_ID;
                    $commentarr = array();
                    $commentarr['comment_ID'] = $comment_id;
                    $commentarr['comment_approved'] = 1;
                    $commentarr['comment_content'] = $review_comments;
                    wp_update_comment($commentarr);
                    update_comment_meta($comment_id, 'review_stars', $review_stars);
                    update_comment_meta($comment_id, 'review_main_title', $review_title);
                    echo '1|' . esc_html__("Review Updated Successfully.", 'dwt-listing-framework');
                    die();
                } else {
                    //inserting new comment
                    $comments_approval = '0';
                    $comment_status = '';
                    $comments_approval = $dwt_listing_options['dwt_listing_review_permission'];
                    $time = current_time('mysql');
                    $data = array(
                        'comment_post_ID' => $listing_id,
                        'comment_author' => $reviever_id_name,
                        'comment_author_email' => $reviever_email,
                        'comment_author_url' => '',
                        'comment_content' => $review_comments,
                        'comment_type' => 'listing',
                        'user_id' => $reviever_id,
                        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                        'comment_date' => $time,
                        'comment_approved' => $comments_approval,
                    );
                    $comment_id = wp_insert_comment($data);
                    if ($comment_id) {
                        dwt_listing_track_activity($listing_id, 'comments', 'yes', $comment_id);
                        //if there is any image in user review field
                        if (get_user_meta($reviever_id, 'reviews_comments_images', true) != "") {
                            $get_diz = get_user_meta($reviever_id, 'reviews_comments_images', true);
                            update_comment_meta($comment_id, 'review_images_idz', $get_diz);
                            //remove image idz from user meta
                            update_user_meta($reviever_id, 'reviews_comments_images', '');
                        }
                        //not null
                        if ($review_stars != "") {
                            update_comment_meta($comment_id, 'review_stars', $review_stars);
                        }
                        update_comment_meta($comment_id, 'review_main_title', $review_title);
                        dwt_listing_track_activity($listing_id, 'rating', $review_stars, $comment_id);
                        if (isset($dwt_listing_options['dwt_listing_review_send_email']) && $dwt_listing_options['dwt_listing_review_send_email'] == "1" && $comments_approval == 1) {
                            // Sending email to listing owner
                            $listing_owner_email = dwt_listing_listing_owner($listing_id, 'email');
                            $listing_owner_name = dwt_listing_listing_owner($listing_id, 'name');
                            $to = $listing_owner_email;
                            $subject = __('Claim Listing', 'dwt-listing-framework');
                            $body = '<html><body><p>' . __('You have a new review, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($listing_id) . '">' . get_the_title($listing_id) . '</a></p></body></html>';
                            $from = get_bloginfo('name');
                            if (isset($dwt_listing_options['downtwon_review_comment_email_from']) && $dwt_listing_options['downtwon_review_comment_email_from'] != "") {
                                $from = $dwt_listing_options['downtwon_review_comment_email_from'];
                            }
                            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                            if (isset($dwt_listing_options['downtwon_review_comment_email_message']) && $dwt_listing_options['downtwon_review_comment_email_message'] != "") {
                                $subject_keywords = array('%site_name%', '%ad_title%');
                                $subject_replaces = array(get_bloginfo('name'), get_the_title($listing_id));
                                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_review_comment_email_change']);
                                $author_id = get_post_field('post_author', $listing_id);
                                $user_info = get_userdata($author_id);
                                $msg_keywords = array('%listing_owner_name%', '%ad_title%', '%ad_link%', '%listng_comment%');
                                $msg_replaces = array($listing_owner_name, get_the_title($listing_id), get_the_permalink($listing_id), $review_comments);
                                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_review_comment_email_message']);
                            }
                            wp_mail($to, $subject, $body, $headers);
                        }
                        $comment_status = wp_get_comment_status($comment_id);
                        if ($comment_status == "approved") {
                            echo '1|' . esc_html__("Review Posted Successfully.", 'dwt-listing-framework');
                        } else {
                            echo '1|' . esc_html__("Review posted successfully & waiting for admin approval.", 'dwt-listing-framework');
                        }
                    } else {
                        echo '0|' . esc_html__("Message not sent, please try again later.", 'dwt-listing-framework');
                    }
                }
            } else {
                //insert data
                $comments_approval = '0';
                $comment_status = '';
                $comments_approval = $dwt_listing_options['dwt_listing_review_permission'];
                $time = current_time('mysql');
                $data = array(
                    'comment_post_ID' => $listing_id,
                    'comment_author' => $reviever_id_name,
                    'comment_author_email' => $reviever_email,
                    'comment_author_url' => '',
                    'comment_content' => $review_comments,
                    'comment_type' => 'listing',
                    'user_id' => $reviever_id,
                    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                    'comment_date' => $time,
                    'comment_approved' => $comments_approval,
                );
                $comment_id = wp_insert_comment($data);
                if ($comment_id) {
                    dwt_listing_track_activity($listing_id, 'comments', 'yes', $comment_id);
                    //if there is any image in user review field
                    if (get_user_meta($reviever_id, 'reviews_comments_images', true) != "") {
                        $get_diz = get_user_meta($reviever_id, 'reviews_comments_images', true);
                        update_comment_meta($comment_id, 'review_images_idz', $get_diz);
                        //remove image idz from user meta
                        update_user_meta($reviever_id, 'reviews_comments_images', '');
                    }
                    //not null
                    if ($review_stars != "") {
                        update_comment_meta($comment_id, 'review_stars', $review_stars);
                    }
                    update_comment_meta($comment_id, 'review_main_title', $review_title);
                    dwt_listing_track_activity($listing_id, 'rating', $review_stars, $comment_id);
                    if (isset($dwt_listing_options['dwt_listing_review_send_email']) && $dwt_listing_options['dwt_listing_review_send_email'] == "1" && $comments_approval == 1) {
                        // Sending email to listing owner
                        $listing_owner_email = dwt_listing_listing_owner($listing_id, 'email');
                        $listing_owner_name = dwt_listing_listing_owner($listing_id, 'name');
                        $to = $listing_owner_email;
                        $subject = __('Claim Listing', 'dwt-listing-framework');
                        $body = '<html><body><p>' . __('You have a new review, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($listing_id) . '">' . get_the_title($listing_id) . '</a></p></body></html>';
                        $from = get_bloginfo('name');
                        if (isset($dwt_listing_options['downtwon_review_comment_email_from']) && $dwt_listing_options['downtwon_review_comment_email_from'] != "") {
                            $from = $dwt_listing_options['downtwon_review_comment_email_from'];
                        }
                        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                        if (isset($dwt_listing_options['downtwon_review_comment_email_message']) && $dwt_listing_options['downtwon_review_comment_email_message'] != "") {
                            $subject_keywords = array('%site_name%', '%ad_title%');
                            $subject_replaces = array(get_bloginfo('name'), get_the_title($listing_id));
                            $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_review_comment_email_change']);
                            $author_id = get_post_field('post_author', $listing_id);
                            $user_info = get_userdata($author_id);
                            $msg_keywords = array('%listing_owner_name%', '%ad_title%', '%ad_link%', '%listng_comment%');
                            $msg_replaces = array($listing_owner_name, get_the_title($listing_id), get_the_permalink($listing_id), $review_comments);
                            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_review_comment_email_message']);
                        }
                        wp_mail($to, $subject, $body, $headers);
                    }
                    $comment_status = wp_get_comment_status($comment_id);
                    if ($comment_status == "Approved") {
                        echo '1|' . esc_html__("Review Posted Successfully.", 'dwt-listing-framework');
                    } else {
                        echo '1|' . esc_html__("Review posted successfully & waiting for admin approval.", 'dwt-listing-framework');
                    }
                } else {
                    echo '0|' . esc_html__("Message not sent, please try again later.", 'dwt-listing-framework');
                }
            }
        }
        die();
    }

}

//Hook fire on claim post ownership
function dwt_listing_claim_hook($post_id, $post, $update)
{
    if ($post->post_type != 'l_claims') {
        return;
    }
    global $dwt_listing_options;
    $original_listing_id = '';
    $claimer_id = '';
    $claim_status = '';
    $user_info = '';
    $claim_winner_name = '';
    $claim_winner_email = '';
    if (isset($_POST['claim_status']) && $_POST['claim_status'] != "") {
        //get original listing id
        if (get_post_meta($post->ID, 'd_listing_original_id', true) != "")
            ;
        {
            $original_listing_id = get_post_meta($post->ID, 'd_listing_original_id', true);
        }
        // get claimer id
        if (get_post_meta($post->ID, 'd_listing_claimer_id', true) != "")
            ;
        {
            $claimer_id = get_post_meta($post->ID, 'd_listing_claimer_id', true);
        }
        // pending post status
        if ($_POST['claim_status'] == 'pending') {
            update_post_meta($original_listing_id, 'd_listing_claim_status', 'pending');
            return;
        }
        // approved post status
        if ($_POST['claim_status'] == 'approved') {
            // send email to first owner before claim
            $first_owner = dwt_listing_listing_owner($original_listing_id, 'name');
            $first_owner_email = dwt_listing_listing_owner($original_listing_id, 'email');
            $to = $first_owner_email;
            $subject = __('Listing Ownership Changed', 'dwt-listing-framework');
            $body = '<html><body><p>' . __('The ownership of your listing has been changed, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($original_listing_id) . '">' . get_the_title($original_listing_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['downtwon_claim_change_from']) && $dwt_listing_options['downtwon_claim_change_from'] != "") {
                $from = $dwt_listing_options['downtwon_claim_change_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($dwt_listing_options['downtwon_claim_change_message']) && $dwt_listing_options['downtwon_claim_change_message'] != "") {
                $subject_keywords = array('%site_name%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_claim_change']);
                $author_id = get_post_field('post_author', $original_listing_id);
                $user_info = get_userdata($author_id);
                $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%');
                $msg_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id), get_the_permalink($original_listing_id), $first_owner);
                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_claim_change_message']);
            }
            wp_mail($to, $subject, $body, $headers);
            remove_action('save_post', 'dwt_listing_claim_hook', 10, 3);
            // update the post, which calls save_post again
            $my_post = array(
                'ID' => $original_listing_id,
                'post_author' => $claimer_id,
            );
            wp_update_post($my_post);
            // Now get claim winner data
            $user_info = get_userdata($claimer_id);
            if ($user_info) {
                $claim_winner_name = $user_info->display_name;
                $claim_winner_email = $user_info->user_email;
            }
            // Now send email to claim winne
            $to = $claim_winner_email;
            $subject = __('Claim Listing Approval', 'dwt-listing-framework');
            $body = '<html><body><p>' . __('The ownership of your listing has been changed, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($original_listing_id) . '">' . get_the_title($original_listing_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['downtwon_claim_change_approved_from']) && $dwt_listing_options['downtwon_claim_change_approved_from'] != "") {
                $from = $dwt_listing_options['downtwon_claim_change_approved_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($dwt_listing_options['downtwon_claim_change_approved_message']) && $dwt_listing_options['downtwon_claim_change_approved_message'] != "") {
                $subject_keywords = array('%site_name%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_claim_approved_change']);
                $author_id = get_post_field('post_author', $original_listing_id);
                $user_info = get_userdata($author_id);
                $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%');
                $msg_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id), get_the_permalink($original_listing_id), $claim_winner_name);
                $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_claim_change_approved_message']);
            }
            wp_mail($to, $subject, $body, $headers);
            // remove user meta value
            if (get_user_meta($claimer_id, 'dwt_listing_claimed_listing_id' . $original_listing_id, true) == $original_listing_id) {
                //update values
                update_user_meta($claimer_id, 'dwt_listing_claimed_listing_id' . $original_listing_id, '');
                update_post_meta($original_listing_id, 'd_listing_claim_status', 'approved');
                update_post_meta($original_listing_id, 'dwt_listing_is_claimed', 1);
            }
        }

        // decline post status
        if ($_POST['claim_status'] == 'decline') {
            // Now get claim winner data
            $user_infoz = get_userdata($claimer_id);
            if ($user_infoz) {
                $claim_looser_name = $user_infoz->display_name;
                $claim_looser_email = $user_infoz->user_email;
                // Now send email to claim winne
                $to = $claim_looser_email;
                $subject = __('Listing Claim Declined', 'dwt-listing-framework');
                $body = '<html><body><p>' . __('Unfortunately! your claim has been declined, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($original_listing_id) . '">' . get_the_title($original_listing_id) . '</a></p></body></html>';
                $from = get_bloginfo('name');
                if (isset($dwt_listing_options['downtwon_claim_change_decline_from']) && $dwt_listing_options['downtwon_claim_change_decline_from'] != "") {
                    $from = $dwt_listing_options['downtwon_claim_change_decline_from'];
                }
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                if (isset($dwt_listing_options['downtwon_claim_change_decline_message']) && $dwt_listing_options['downtwon_claim_change_decline_message'] != "") {
                    $subject_keywords = array('%site_name%', '%ad_title%');
                    $subject_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id));
                    $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_claim_decline_change']);
                    $author_id = get_post_field('post_author', $original_listing_id);
                    $user_info = get_userdata($author_id);
                    $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%claimer_name%');
                    $msg_replaces = array(get_bloginfo('name'), get_the_title($original_listing_id), get_the_permalink($original_listing_id), $claim_looser_name);
                    $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_claim_change_decline_message']);
                }
                wp_mail($to, $subject, $body, $headers);

                // remove user meta value
                if (get_user_meta($claimer_id, 'dwt_listing_claimed_listing_id' . $original_listing_id, true) == $original_listing_id) {
                    //update values
                    update_post_meta($original_listing_id, 'd_listing_claim_status', 'decline');
                }
            }
        }
    }
}

add_action('save_post', 'dwt_listing_claim_hook', 10, 3);

//Post view counter
function downotown_listing_views()
{
    if (in_array('post-views-counter/post-views-counter.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        return do_shortcode('[post-views]');
    }
}

// Review Listing Form
add_action('wp_ajax_dwt_listing_listing_review_reply', 'dwt_listing_review_reply');
if (!function_exists('dwt_listing_review_reply')) {

    function dwt_listing_review_reply()
    {
        global $dwt_listing_options;
        if (isset($_POST['c_id']) && $_POST['c_id'] != "") {
            $comment_id = $_POST['c_id'];
            $params = array();
            parse_str($_POST['collect_data'], $params);
            //fetch form fields
            $listing_id = $params['listing_id'];
            $reply_review_id = $params['review_reply_id'];
            $review_msg_reply = ($params['comments-review-reply']);
            //fetch current user data
            $profile = new dwt_listing_profile();
            $replier_id = $profile->user_info->ID;
            $replier_email = $profile->user_info->user_email;
            $replier_name = $profile->user_info->display_name;
            if (isset($reply_review_id) && $reply_review_id != "") {
                $commentarr['comment_post_ID'] = $listing_id;
                $commentarr['comment_ID'] = $reply_review_id;
                $commentarr['comment_approved'] = 1;
                $commentarr['comment_content'] = $review_msg_reply;
                wp_update_comment($commentarr);
                echo '1|' . esc_html__("Reply Updated Successfully.", 'dwt-listing-framework');
                die();
            } else {
                $time = current_time('mysql');
                $data = array(
                    'comment_author' => $replier_name,
                    'comment_author_email' => $replier_email,
                    'comment_content' => $review_msg_reply,
                    'comment_type' => 'listing',
                    'user_id' => $replier_id,
                    'comment_date' => $time,
                    'comment_approved' => 1,
                    'comment_parent' => $comment_id,
                    'comment_post_ID' => $listing_id,
                );
                $comment_id = wp_insert_comment($data);
                if ($comment_id) {
                    // send email
                    if (isset($dwt_listing_options['dwt_listing_review_reply_email']) && $dwt_listing_options['dwt_listing_review_reply_email'] == "1") {
                        // Sending email to listing owner
                        $listing_owner_email = dwt_listing_listing_owner($listing_id, 'email');
                        $listing_owner_name = dwt_listing_listing_owner($listing_id, 'name');
                        $to = $listing_owner_email;
                        $subject = __('Listing Review Reply', 'dwt-listing-framework');
                        $body = '<html><body><p>' . __('You received a new reply, please check it. ', 'dwt-listing-framework') . '<a href="' . get_the_permalink($listing_id) . '">' . get_the_title($listing_id) . '</a></p></body></html>';
                        $from = get_bloginfo('name');
                        if (isset($dwt_listing_options['downtwon_review_reply_email_from']) && $dwt_listing_options['downtwon_review_reply_email_from'] != "") {
                            $from = $dwt_listing_options['downtwon_review_reply_email_from'];
                        }
                        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                        if (isset($dwt_listing_options['downtwon_review_reply_email_message']) && $dwt_listing_options['downtwon_review_reply_email_message'] != "") {
                            $subject_keywords = array('%site_name%', '%ad_title%');
                            $subject_replaces = array(get_bloginfo('name'), get_the_title($listing_id));
                            $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['downtwon_review_reply_email_change']);
                            $author_id = get_post_field('post_author', $listing_id);
                            $user_info = get_userdata($author_id);
                            $msg_keywords = array('%listing_owner_name%', '%ad_title%', '%ad_link%', '%replier_comment%', '%replier_name%');
                            $msg_replaces = array($listing_owner_name, get_the_title($listing_id), get_the_permalink($listing_id), $review_msg_reply, $replier_name);
                            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['downtwon_review_reply_email_message']);
                        }
                        wp_mail($to, $subject, $body, $headers);
                    }
                    echo '1|' . esc_html__("Reply Posted Successfully.", 'dwt-listing-framework');
                } else {
                    echo '0|' . esc_html__("Reply not sent, please try again later.", 'dwt-listing-framework');
                }
            }
            die();
        }
    }
}

// Ajax handler for add to cart
add_action('wp_ajax_dwt_listing_mailchimp_subcribe', 'dwt_listing_mailchimp_subcribed');
add_action('wp_ajax_nopriv_dwt_listing_mailchimp_subcribe', 'dwt_listing_mailchimp_subcribed');

// Addind Subcriber into Mailchimp
function dwt_listing_mailchimp_subcribed()
{
    global $dwt_listing_options;
    $apiKey = $dwt_listing_options['mailchimp_api_key'];
    $listid = $dwt_listing_options['mailchimp_list_id'];
    if ($apiKey != "" && $listid != "") {
        // Getting value from form
        $email = $_POST['user_email'];
        $fname = '';
        $lname = '';
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;
        // member information
        $json = json_encode(array(
            'email_address' => $email,
            'status' => 'subscribed',
            'merge_fields' => array(
                'FNAME' => $fname,
                'LNAME' => $lname
            )
        ));
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // store the status message based on response code
        $mcdata = json_decode($result);
        if (!empty($mcdata->error)) {
            echo 0;
        } else {
            echo 1;
        }
    }
    die();
}

//Send email on new Event
if (!function_exists('dwt_listing_notify_on_new_event')) {
    function dwt_listing_notify_on_new_event($event_id)
    {
        global $dwt_listing_options;
        //send email to admin
        $author_id = get_post_field('post_author', $event_id);
        $user_info = get_userdata($author_id);
        $event_owner_name = $user_info->user_email;
        /* fetch event meta */
        $event_venue = $event_date = '';
        $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
        $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
        $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
        if ($event_start_date != "" && $event_end_date != "") {
            $to = esc_html__('To : ', 'dwt-listing-framework');
            $from = esc_html__('From : ', 'dwt-listing-framework');
            $event_date = $to . ' ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_start_date)) . ' ' . $from . ' ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_end_date));
        }
        if (isset($dwt_listing_options['dwt_listing_event_send_email_admin']) && $dwt_listing_options['dwt_listing_event_send_email_admin'] == '1') {
            $to = $dwt_listing_options['dwt_listing_event_admin_email'];
            $subject = __('New Event', 'dwt-listing-framework') . '-' . get_bloginfo('name');
            $body = '<html><body><p>' . __('Got new event', 'dwt-listing-framework') . ' <a href="' . get_edit_post_link($event_id) . '">' . get_the_title($event_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['dwt_listing_event_from']) && $dwt_listing_options['dwt_listing_event_from'] != "") {
                $from = $dwt_listing_options['dwt_listing_event_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $author_id = get_post_field('post_author', $event_id);
            $user_info = get_userdata($author_id);
            if (isset($dwt_listing_options['dwt_listing_event_detial_message']) && $dwt_listing_options['dwt_listing_event_detial_message'] != "") {
                $subject_keywords = array('%site_name%', '%event_owner%', '%event_title%');
                $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($event_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_new_event_subject']);
                $msg_keywords = array('%site_name%', '%event_owner%', '%event_title%', '%event_link%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($event_id), get_the_permalink($event_id));
            }
            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_event_detial_message']);
            wp_mail($to, $subject, $body, $headers);
        }
        if (isset($dwt_listing_options['dwt_listing_event_send_email']) && $dwt_listing_options['dwt_listing_event_send_email'] == '1') {
            $to = $event_owner_name;
            $subject = __('New Event', 'dwt-listing-framework') . '-' . get_bloginfo('name');
            $body = '<html><body><p>' . __('You event created', 'dwt-listing-framework') . ' <a href="' . get_edit_post_link($event_id) . '">' . get_the_title($event_id) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($dwt_listing_options['dwt_listing_event_for_user_from']) && $dwt_listing_options['dwt_listing_event_for_user_from'] != "") {
                $from = $dwt_listing_options['dwt_listing_event_for_user_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            if (isset($dwt_listing_options['dwt_listing_event_detial_for_user_message']) && $dwt_listing_options['dwt_listing_event_detial_for_user_message'] != "") {
                $subject_keywords = array('%site_name%', '%event_owner%', '%event_title%');
                $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($event_id));
                $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_new_event_subject_for_user']);
                $msg_keywords = array('%site_name%', '%event_owner%', '%event_title%', '%event_link%', '%event_timing%', '%event_location%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($event_id), get_the_permalink($event_id), $event_date, $event_venue);
            }
            $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_event_detial_for_user_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

}

//Downtown Custom Package
function dwt_listing_register_custom_packages()
{
    if (class_exists('WooCommerce')) {

        class WC_Product_dwt_listing_custom_packages extends WC_Product
        {
            public $product_type = 'dwt_listing_pkgs';
            public function __construct($product)
            {
                parent::__construct($product);
            }
        }
    }
}

add_action('init', 'dwt_listing_register_custom_packages', 0);

function dwt_listing_add_packages_type($types)
{
    // Key should be exactly the same as in the class product_type parameter
    $types['dwt_listing_pkgs'] = __('Downtown Packages');
    return $types;
}

add_filter('product_type_selector', 'dwt_listing_add_packages_type', 0);

//class for custom product type
function dwt_listing_woocommerce_product_class($classname, $product_type)
{
    if ($product_type == 'dwt_listing_pkgs') { // notice the checking here.
        $classname = 'WC_Product_dwt_listing_custom_packages';
    }
    return $classname;
}

add_filter('woocommerce_product_class', 'dwt_listing_woocommerce_product_class', 10, 2);

/**
 * Show pricing fields for simple_rental product.
 */
function dwt_listing_render_package_custom_js()
{

    if ('product' != get_post_type()) :
        return;
    endif;
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function ($) {
            jQuery('#dwt_l_packages').hide();
            jQuery('.options_group.pricing').addClass('show_if_dwt_listing_pkgs').show();
            jQuery('#product-type').on('change', function () {
                if (jQuery(this).val() == 'dwt_listing_pkgs' || jQuery(this).val() == 'subscription') {
                    jQuery('#dwt_l_packages').show();
                    $("._subscription_sign_up_fee_field").hide();
                    $("._subscription_trial_length_field").hide();
                } else {
                    jQuery('#dwt_l_packages').hide();
                    $("._subscription_sign_up_fee_field").show();
                    $("._subscription_trial_length_field").show();
                }
            });
            jQuery('#product-type').trigger('change');
        });

    </script>
    <?php
}

add_action('admin_footer', 'dwt_listing_render_package_custom_js');

function dwt_listing_hide_attributes_data_panel($tabs)
{
    // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
    $tabs['attribute']['class'][] = 'hide_if_dwt_listing_pkgs';
    $tabs['shipping']['class'][] = 'hide_if_dwt_listing_pkgs';
    $tabs['linked_product']['class'][] = 'hide_if_dwt_listing_pkgs';
    $tabs['advanced']['class'][] = 'hide_if_dwt_listing_pkgs';
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'dwt_listing_hide_attributes_data_panel');

// Send Message To Listing Owner
add_action('wp_ajax_send_email_to_author', 'dwt_listing_send_email_to_author');
add_action('wp_ajax_nopriv_send_email_to_author', 'dwt_listing_send_email_to_author');

function dwt_listing_send_email_to_author()
{
    global $dwt_listing_options;
    // Getting values
    $params = array();
    parse_str($_POST['collect_data'], $params);
    $name = sanitize_text_field($params['name']);
    $email = sanitize_email($params['email']);
    $phone = sanitize_text_field($params['phone']);
    $message = sanitize_text_field($params['message']);
    $public_author_id = sanitize_text_field($params['author_id']);
    $user_info = get_userdata($public_author_id);
    $author_email = $user_info->user_email;
    $author_name = $user_info->display_name;
    $to = $author_email;
    $subject = __('New Notification', 'dwt-listing-framework');
    $body = '<html><body><p>' . __('You have a new email from', 'dwt-listing-framework') . ' ' . $name . '</p><p>' . $params['message'] . '</p></body></html>';
    $from = get_bloginfo('name');
    if (isset($dwt_listing_options['dwt_listing_message_from_public_profile']) && $dwt_listing_options['dwt_listing_message_from_public_profile'] != "") {
        $from = $dwt_listing_options['dwt_listing_message_from_public_profile'];
    }
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
    if (isset($dwt_listing_options['dwt_listing_message_on_public_profile']) && $dwt_listing_options['dwt_listing_message_on_public_profile'] != "") {
        $subject_keywords = array('%site_name%');
        $subject_replaces = '';
        $subject = str_replace($subject_keywords, $subject_replaces, $dwt_listing_options['dwt_listing_message_subject_public_profile']);
        $msg_keywords = array('%site_name%', '%author_name%', '%sender_name%', '%sender_contact%', '%sender_email%', '%message%');
        $msg_replaces = array(get_bloginfo('name'), $author_name, $name, $phone, $email, $message);
        $body = str_replace($msg_keywords, $msg_replaces, $dwt_listing_options['dwt_listing_message_on_public_profile']);
    }
    $sent_message = wp_mail($to, $subject, $body, $headers);
    //display message based on the result.
    if ($sent_message) {
        // The message was sent.
        echo '1|' . __("Message sent successfully.", 'dwt-listing-framework');
    } else {
        // The message was not sent.
        echo '0|' . __("Message not sent, please try again later.", 'dwt-listing-framework');
    }
    die();
}

// Importing data
// Ajax handler for add to cart
add_action('wp_ajax_demo_data_start', 'dwt_listing_before_install_demo_data');

// Addind Subcriber into Mailchimp
function dwt_listing_before_install_demo_data()
{
    if (get_option('dwt_listing_fresh_installation') != 'no') {
        update_option('dwt_listing_fresh_installation', $_POST['is_fresh']);
    }
    die();
}

if (!function_exists('dwt_listing_importing_data')) {

    function dwt_listing_importing_data($demo_type)
    {
        global $wpdb;
        $sql_file_OR_content = '';
        if ($demo_type == 'Directory & Listing') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/dwt-listing-themeforest.sql';
        }
        if ($demo_type == 'Autos') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/autos.sql';
        }
        if ($demo_type == 'EduPro') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/edu.sql';
        }
        if ($demo_type == 'Events') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/events.sql';
        }
        if ($demo_type == 'Gadgets') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/gadgets.sql';
        }
        if ($demo_type == 'Lahore') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/lhr.sql';
        }
        if ($demo_type == 'Los Angeles') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/los.sql';
        }
        if ($demo_type == 'Pets') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/pets.sql';
        }
        if ($demo_type == 'Royal') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/royal.sql';
        }
        if ($demo_type == 'Salon') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/salon.sql';
        }
        if ($demo_type == 'Shanghai') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/shang.sql';
        }
        if ($demo_type == 'Shop') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/shop.sql';
        }
        if ($demo_type == 'RTL') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/rtl-dwt-demo-data.sql';
        }
        /* in elementor case */
        if ($demo_type == 'Elementor Directory & Listing') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/elementor_sql/sbdowntown-elmntr.sql';
        }

        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content));
        $allLines = explode("\n", $SQL_CONTENT);
        $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
        foreach ($target_tables[2] as $table) {
            $wpdb->query('DROP TABLE IF EXISTS ' . $table);
        }
        $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
        $templine = ''; // Temporary variable, used to store current query
        foreach ($allLines as $line) {           // Loop through each line
            if (substr($line, 0, 2) != '--' && $line != '') {
                $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
                if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
                    if ($wpdb->prefix != 'wp_') {
                        $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
                    }
                    if (!$wpdb->query($templine)) {

                    }
                    $templine = ''; // set variable to empty, to start picking up the lines after ";"
                }
            }
        }
        //return 'Importing finished. Now, Delete the import file.';
    }

}

add_action('wp_ajax_my_action', 'dwt_listing_my_ajax_action_function');

function dwt_listing_my_ajax_action_function()
{
    $reponse = array();
    if (!empty($_POST['param'])) {
        $response['response'] = plugins_url();
    } else {
        $response['response'] = "";
    }
    header("Content-Type: application/json");
    echo json_encode($response);
    //Don't forget to always exit in the ajax function.
    exit();
}

// Get image ID from URL
function shift8_portfolio_get_image_id($image_url)
{
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
    if (!empty($attachment)) {
        return $attachment[0];
    }
}

// clear woo commerece cart items
add_filter( 'woocommerce_add_cart_item_data', 'ziauddinn_allow_one_product_cart' );

function ziauddinn_allow_one_product_cart( $cart_item_data ) {

    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return

    return $cart_item_data;
}