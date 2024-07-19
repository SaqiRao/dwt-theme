<?php
if (!class_exists('dwt_listing_submit_reviews')) {

    class dwt_listing_submit_reviews {

        // user object
        var $user_info;

        public function __construct() {
            $this->user_info = get_userdata(get_current_user_id());
        }

    }

}


add_action('wp_ajax_upload_review_gallery', 'dwt_listing_reviews_comments_gallery');
add_action('wp_ajax_nopriv_upload_review_gallery', 'dwt_listing_reviews_comments_gallery');
if (!function_exists('dwt_listing_reviews_comments_gallery')) {

    function dwt_listing_reviews_comments_gallery() {
        global $dwt_listing_options;

        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }

        $gallery_limit = $dwt_listing_options['dwt_listing_review_upload_limit'];
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        // check size of uploaded images
        $size_arr = explode('-', $dwt_listing_options['dwt_listing_review_images_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        // Allow certain file formats
        $imageFileType = strtolower(end(explode('.', $_FILES['my_file_upload']['name'])));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'dwt-listing');
            die();
        }

        // Check file size
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . __("Max allowed image size is", 'dwt-listing') . " " . $display_size;
            die();
        }

        //for comment edit
        if (dwt_listing_text('dwt_listing_review_enable_gallery') == 1 && dwt_listing_text('dwt_listing_review_rating_limit') == 1) {
            if ($_GET['is_update'] != "") {
                $user_id = get_current_user_id();
                $listing_id = $_GET['is_update'];
                $args = array('type__in' => array('listing'), 'post_id' => $listing_id, 'user_id' => $user_id, 'number' => 1, 'parent' => 0);
                $if_comment = get_comments($args);
                if (count((array) $if_comment) > 0) {
                    $comment_id = $if_comment[0]->comment_ID;
                    $attachment_id = media_handle_upload('my_file_upload', $comment_id);
                    if (!is_wp_error($attachment_id)) {
                        //check if images already exit
                        $comment_images = get_comment_meta($comment_id, 'review_images_idz', true);
                        if ($comment_images != "") {
                            $media = explode(',', $comment_images);
                            if (count($media) >= $gallery_limit) {
                                $msg = esc_html__("Sorry you cant upload more than ", 'dwt-listing');
                                $images_l = esc_html__(" images ", 'dwt-listing');
                                echo '0|' . $msg . $gallery_limit . $images_l;
                                die();
                            }
                            $comment_images = $comment_images . ',' . $attachment_id;
                            update_comment_meta($comment_id, 'review_images_idz', $comment_images);
                            die();
                        } else {
                            update_comment_meta($comment_id, 'review_images_idz', $attachment_id);
                            die();
                        }
                    } else {
                        echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                        die();
                    }
                } else {
                    // Check max image limit
                    $review_images_count = get_user_meta(get_current_user_id(), 'reviews_comments_images', true);
                    if ($review_images_count != "") {
                        $media = explode(',', $review_images_count);
                        if (count($media) >= $gallery_limit) {
                            $msg = esc_html__("Sorry you cant upload more than ", 'dwt-listing');
                            $images_l = esc_html__(" images ", 'dwt-listing');
                            echo '0|' . $msg . $gallery_limit . $images_l;
                            die();
                        }
                    }
                    // Check max image limit
                    $attachment_id = media_handle_upload('my_file_upload', get_current_user_id());
                    if (!is_wp_error($attachment_id)) {
                        $review_images = get_user_meta(get_current_user_id(), 'reviews_comments_images', true);
                        if ($review_images != "") {
                            $review_images = $review_images . ',' . $attachment_id;
                            update_user_meta(get_current_user_id(), 'reviews_comments_images', $review_images);
                        } else {
                            update_user_meta(get_current_user_id(), 'reviews_comments_images', $attachment_id);
                        }
                        echo '' . $attachment_id;
                        die();
                    } else {
                        echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                        die();
                    }
                }
            }
        } else {
            // Check max image limit
            $review_images_count = get_user_meta(get_current_user_id(), 'reviews_comments_images', true);
            if ($review_images_count != "") {
                $media = explode(',', $review_images_count);
                if (count($media) >= $gallery_limit) {
                    $msg = esc_html__("Sorry you cant upload more than ", 'dwt-listing');
                    $images_l = esc_html__(" images ", 'dwt-listing');
                    echo '0|' . $msg . $gallery_limit . $images_l;
                    die();
                }
            }
            // Check max image limit
            $attachment_id = media_handle_upload('my_file_upload', get_current_user_id());
            if (!is_wp_error($attachment_id)) {
                $review_images = get_user_meta(get_current_user_id(), 'reviews_comments_images', true);
                if ($review_images != "") {
                    $review_images = $review_images . ',' . $attachment_id;
                    update_user_meta(get_current_user_id(), 'reviews_comments_images', $review_images);
                } else {
                    update_user_meta(get_current_user_id(), 'reviews_comments_images', $attachment_id);
                }
                echo '' . $attachment_id;
                die();
            } else {
                echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                die();
            }
        }
    }

}


// Fetch Reviews Images ...
add_action('wp_ajax_get_uploaded_review_images', 'dwt_listing_get_uploaded_listing_reviews_images');
add_action('wp_ajax_nopriv_get_uploaded_review_images', 'dwt_listing_get_uploaded_listing_reviews_images');
if (!function_exists('dwt_listing_get_uploaded_listing_reviews_images')) {

    function dwt_listing_get_uploaded_listing_reviews_images() {
        $user_id = get_current_user_id();
        if ($user_id == "") {
            return;
        }

        $review_images = get_user_meta($user_id, 'reviews_comments_images', true);
        if ($review_images != "") {
            $media = explode(',', $review_images);
            $result = array();
            $path = '';
            foreach ($media as $m) {
                $mid = '';
                $guid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                    $source = wp_get_attachment_image_src($mid, 'dwt_listing_user-dp');
                    $path = $source[0];
                } else {
                    $mid = $m;
                    $source = wp_get_attachment_image_src($mid, 'dwt_listing_user-dp');
                    $path = $source[0];
                }

                $obj = array();
                $obj['dispaly_name'] = basename(get_attached_file($mid));
                ;
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

}


// Delete Reviews Images ...
add_action('wp_ajax_delete_listing_reviews_image', 'dwt_listing_delete_listing_reviews_image');
add_action('wp_ajax_nopriv_delete_listing_reviews_image', 'dwt_listing_delete_listing_reviews_image');
if (!function_exists('dwt_listing_delete_listing_reviews_reviews_image')) {

    function dwt_listing_delete_listing_reviews_image() {
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }

        $user_id = get_current_user_id();
        if ($user_id == "") {
            return '';
        }
        $attachmentid = $_POST['img'];
        wp_delete_attachment($attachmentid, $force_delete= false);

        if (get_user_meta($user_id, 'reviews_comments_images', true) != "") {
            $ids = get_user_meta($user_id, 'reviews_comments_images', true);
            
            $res = str_replace($attachmentid, "", $ids);
            $res = str_replace(',,', ",", $res);
            $img_ids = trim($res, ',');
           echo "a". update_user_meta($user_id, 'reviews_comments_images', $img_ids) ."b";
        }
        echo "1";
        die();
    }

}


// Get Listing Owner Details
if (!function_exists('dwt_listing_fetch_comment_poster')) {

    function dwt_listing_fetch_comment_poster($user_idz, $field = '') {
        //get user data
        $user_info = get_userdata($user_idz);
        if ($user_info == true) {

            $user_id = $user_info->ID;
            if ($user_info != "") {
                if ($field == 'id') {
                    return $user_id = $user_info->ID;
                }
                if ($field == 'dp') {
                    return dwt_listing_get_user_dp($user_id, 'dwt_listing_user-dp');
                }
                if ($field == 'name') {
                    return  $user_info->display_name;
                }
                if ($field == 'email') {
                    return $user_info->user_email;
                }
                if ($field == 'location') {
                    return $user_info->d_user_location;
                }
                if ($field == 'url') {
                    //$all_author_update_url = dwt_listing_set_url_param(get_author_posts_url($user_id), 'type', 'listings');
                    $all_author_update_url = dwt_listing_set_url_params_multi(get_author_posts_url($user_id), array('type' => 'listings'));
                    return (dwt_listing_page_lang_url_callback($all_author_update_url));
                }
                if ($field == 'contact') {
                    return $user_info->d_user_contact;
                }
            }
        } else {
            return dwt_listing_get_user_dp($user_idz);
        }
    }

}


add_action('wp_ajax_dwt_listing_listing_reaction', 'dwt_listing_listing_reaction_emoji');
add_action('wp_ajax_nopriv_dwt_listing_listing_reaction', 'dwt_listing_listing_reaction_emoji');
if (!function_exists('dwt_listing_listing_reaction_emoji')) {

    function dwt_listing_listing_reaction_emoji() {
        if (!is_user_logged_in()) {
            echo '0|' . __("You need to login.", 'dwt-listing');
            die();
        }

        global $dwt_listing_options;
        $reaction_id = '';
        $comment_id = '';
        if (isset($_POST['r_id']) && $_POST['r_id'] != "") {
            $reaction_id = $_POST['r_id'];
        }
        if (isset($_POST['c_id']) && $_POST['c_id'] != "") {
            $comment_id = $_POST['c_id'];
        }

        if ($reaction_id && $comment_id) {
            if (get_user_meta(get_current_user_id(), 'dwt_listing_review_submit_id' . $comment_id, true) == $comment_id) {
                echo '0|' . esc_html__("You have already reacted on this review.", 'dwt-listing');
                die();
            } else {
                //get comment listing id and current user id
                $get_comment = get_comment($comment_id);
                $listing_id = $get_comment->comment_post_ID;

                /* $author_id = get_post_field ('post_author', $listing_id);
                  if($author_id == get_current_user_id())
                  {
                  echo '0|' . esc_html__( "Listing author cant reacted on reviews", 'dwt-listing' );
                  die();
                  }
                 */
                update_user_meta(get_current_user_id(), 'dwt_listing_review_submit_id' . $comment_id, $comment_id);

                if ($reaction_id == 1) {
                    if (get_comment_meta($comment_id, 'review_like', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_like', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_like', $update_count);
                        echo '' . $update_count;
                        dwt_listing_track_activity($listing_id, 'like', '1');
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_like', $total_count);
                        echo '' . $total_count;
                        dwt_listing_track_activity($listing_id, 'like', '1');
                    }
                }
                if ($reaction_id == 2) {
                    if (get_comment_meta($comment_id, 'review_love', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_love', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_love', $update_count);
                        echo '' . $update_count;
                        dwt_listing_track_activity($listing_id, 'like', '2');
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_love', $total_count);
                        echo '' . $total_count;
                        dwt_listing_track_activity($listing_id, 'like', '2');
                    }
                }
                if ($reaction_id == 3) {
                    if (get_comment_meta($comment_id, 'review_wow', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_wow', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_wow', $update_count);
                        echo '' . $update_count;
                        dwt_listing_track_activity($listing_id, 'like', '3');
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_wow', $total_count);
                        echo '' . $total_count;
                        dwt_listing_track_activity($listing_id, 'like', '3');
                    }
                }
                if ($reaction_id == 4) {
                    if (get_comment_meta($comment_id, 'review_angry', true) != "") {
                        $current_count = get_comment_meta($comment_id, 'review_angry', true);
                        $update_count = $current_count + 1;
                        update_comment_meta($comment_id, 'review_angry', $update_count);
                        echo '' . $update_count;
                        dwt_listing_track_activity($listing_id, 'like', '4');
                    } else {
                        $total_count = '1';
                        update_comment_meta($comment_id, 'review_angry', $total_count);
                        echo '' . $total_count;
                        dwt_listing_track_activity($listing_id, 'like', '4');
                    }
                }
                //update_user_meta( get_current_user_id(), 'dwt_listing_review_submit_id' . $comment_id, $comment_id );
            }
        }
        die();
    }

}


// Get Listing Owner Details
if (!function_exists('dwt_listing_fetch_reviews_average')) {

    function dwt_listing_fetch_reviews_average($listing_id) {
        $comments = '';
        $rated = $get_rating_avrage = '';
        $one_star = '';
        $two_star = '';
        $three_star = '';
        $four_star = '';
        $five_star = '';
        $star1 = $star2 = $star3 = $star4 = $star5 = 0;
        $comments = get_comments(array('post_id' => $listing_id, 'post_type' => 'listing', 'status' => 'approve', 'parent' => 0));
        if (count($comments) > 0) {
            $sum_of_rated = 0;
            $no_of_times_rated = 0;
            foreach ($comments as $comment) {
                if (get_comment_meta($comment->comment_ID, 'review_stars', true) != "") {
                    $rated = get_comment_meta($comment->comment_ID, 'review_stars', true);
                    if ($rated != "" && $rated > 0) {
                        $sum_of_rated += $rated;
                        $no_of_times_rated++;
                        //now rated percentage
                        if ($rated == 1) {
                            $star1++;
                        }
                        if ($rated == 2) {
                            $star2++;
                        }
                        if ($rated == 3) {
                            $star3++;
                        }
                        if ($rated == 4) {
                            $star4++;
                        }
                        if ($rated == 5) {
                            $star5++;
                        }
                    }
                }
            }
            //loop end get avrage value
            if ($rated != "" && $rated > 0) {
                $get_rating_avrage = round($sum_of_rated / $no_of_times_rated, 2);
                $get_rating_avrage1 = round($sum_of_rated / $no_of_times_rated, 1);
                $one_star = round(($star1 / $no_of_times_rated) * 100);
                $two_star = round(($star2 / $no_of_times_rated) * 100);
                $three_star = round(($star3 / $no_of_times_rated) * 100);
                $four_star = round(($star4 / $no_of_times_rated) * 100);
                $five_star = round(($star5 / $no_of_times_rated) * 100);
                $total_stars = explode(".", $get_rating_avrage1);

                $stars_html = '';
                $first_part = (isset($total_stars[0]) && $total_stars[0] > 0 && $total_stars[0] != "") ? $total_stars[0] : 0;
                $second_part = (isset($total_stars[1]) && $total_stars[1] > 0 && $total_stars[1] != "") ? $total_stars[1] : 0;
                for ($stars = 1; $stars <= 5; $stars++) {
                    if ($stars <= $first_part && $first_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part <= 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star-half-o color" aria-hidden="true"></i>';
                    } else if ($stars == $first_part + 1 && $second_part > 5 && $second_part > 0) {
                        $stars_html .= '<i class="fa fa-star color" aria-hidden="true"></i>';
                    } else {
                        $stars_html .= '<i class="fa fa-star" aria-hidden="true"></i>';
                    }
                }
                if (strpos($get_rating_avrage, ".") !== false) {
                    $get_rating_avrage = $get_rating_avrage;
                } else {
                    $get_rating_avrage = $get_rating_avrage . '.0';
                }

                $array = array();
                $array['total_stars'] = $stars_html;
                $array['average'] = $get_rating_avrage;
                $array['rated_no_of_times'] = $no_of_times_rated;
                $array['ratings'] = array('1_star' => $one_star, '2_star' => $two_star, '3_star' => $three_star, '4_star' => $four_star, '5_star' => $five_star);
                //update avrage in post mera
                update_post_meta($listing_id, 'listing_total_average', $get_rating_avrage);
                return $array;
            }
        }
    }

}


// Upload Images Against Comments...
add_action('wp_ajax_upload_comments_gallery', 'dwt_listing_comments_gallery');
add_action('wp_ajax_nopriv_comments_review_gallery', 'dwt_listing_comments_gallery');
if (!function_exists('dwt_listing_comments_gallery')) {

    function dwt_listing_comments_gallery() {
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '0|' . __("Disable for Demo.", 'dwt-listing');
            die();
        }

        global $dwt_listing_options;
        $gallery_limit = $dwt_listing_options['dwt_listing_review_upload_limit'];
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        // check size of uploaded images
        $size_arr = explode('-', $dwt_listing_options['dwt_listing_review_images_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        // Allow certain file formats
        $imageFileType = strtolower(end(explode('.', $_FILES['my_file_upload']['name'])));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '0|' . __("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'dwt-listing');
            die();
        }

        // Check file size
        if ($_FILES['my_file_upload']['size'] > $actual_size) {
            echo '0|' . __("Max allowed image size is", 'dwt-listing') . " " . $display_size;
            die();
        }

        if ($_GET['is_comments'] != "") {
            $comment_id = $_GET['is_comments'];
            //for comment edit
            if (dwt_listing_text('dwt_listing_review_enable_gallery') == 1) {
                //check if images already exit
                $comment_images = get_comment_meta($comment_id, 'review_images_idz', true);
                if ($comment_images != "") {
                    $media = explode(',', $comment_images);
                    if (count($media) >= $gallery_limit) {
                        $msg = esc_html__("Sorry you cant upload more than ", 'dwt-listing');
                        $images_l = esc_html__(" images ", 'dwt-listing');
                        echo '0|' . $msg . $gallery_limit . $images_l;
                        die();
                    }
                }
                $attachment_id = media_handle_upload('my_file_upload', $comment_id);
                if (!is_wp_error($attachment_id)) {
                    $comment_images_up = get_comment_meta($comment_id, 'review_images_idz', true);
                    if ($comment_images_up != "") {
                        $comment_images_up = $comment_images_up . ',' . $attachment_id;
                        update_comment_meta($comment_id, 'review_images_idz', $comment_images_up);
                    } else {
                        update_comment_meta($comment_id, 'review_images_idz', $attachment_id);
                    }
                    echo '' . $attachment_id;
                    die();
                } else {
                    echo '0|' . esc_html__("Something went wrong please try later", 'dwt-listing');
                    die();
                }
            }
        }
    }

}


// Fetch Comments Images...
add_action('wp_ajax_get_uploaded_comments_images', 'dwt_listing_get_uploaded_listing_comments_images');
add_action('wp_ajax_nopriv_get_uploaded_comments_images', 'dwt_listing_get_uploaded_listing_comments_images');
if (!function_exists('dwt_listing_get_uploaded_listing_comments_images')) {

    function dwt_listing_get_uploaded_listing_comments_images() {
        $user_id = get_current_user_id();
        if ($user_id == "") {
            return;
        }
        // if comment is going to update
        if (isset($_POST['is_comment_id']) && $_POST['is_comment_id'] != "") {
            $path = '';
            $comment_id = $_POST['is_comment_id'];
            if (get_comment_meta($comment_id, 'review_images_idz', true) != "") {
                $comment_images = get_comment_meta($comment_id, 'review_images_idz', true);
                if ($comment_images != "") {
                    $media = explode(',', $comment_images);
                    $result = array();
                    foreach ($media as $m) {
                        $mid = '';
                        $guid = '';
                        if (isset($m->ID)) {
                            $mid = $m->ID;
                            $source = wp_get_attachment_image_src($mid, 'dwt_listing_user-dp');
                            $path = $source[0];
                        } else {
                            $mid = $m;
                            $source = wp_get_attachment_image_src($mid, 'dwt_listing_user-dp');
                            $path = $source[0];
                        }

                        $obj = array();
                        $obj['dispaly_name'] = basename(get_attached_file($mid));
                        ;
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
        }
    }

}


// Delete Reviews Images ...
add_action('wp_ajax_delete_listing_comments_image', 'dwt_listing_delete_listing_comments_image');
add_action('wp_ajax_nopriv_delete_listing_comments_image', 'dwt_listing_delete_listing_comments_image');
if (!function_exists('dwt_listing_delete_listing_comments_image')) {

    function dwt_listing_delete_listing_comments_image() {
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            return '';
            die();
        }
        $user_id = get_current_user_id();
        if ($user_id == "") {
            return '';
        }

        if (isset($_POST['is_comment_id']) && $_POST['is_comment_id'] != "") {
            $comment_id = $_POST['is_comment_id'];
            $attachmentid = $_POST['img'];
            wp_delete_attachment($attachmentid, true);
            if (get_comment_meta($comment_id, 'review_images_idz', true) != "") {
                $comment_images_up = get_comment_meta($comment_id, 'review_images_idz', true);
                $res = str_replace($attachmentid, "", $comment_images_up);
                $res = str_replace(',,', ",", $res);
                $img_ids = trim($res, ',');
                update_comment_meta($comment_id, 'review_images_idz', $img_ids);
            }
            echo "1";
        }
        die();
    }

} 