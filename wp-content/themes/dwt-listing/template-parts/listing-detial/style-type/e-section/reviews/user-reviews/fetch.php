<?php
global $dwt_listing_options;
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $pages = $page = '';
    $listing_id = $_GET['review_id'];
    $limit = 2;
    $limit = dwt_listing_text('dwt_listing_review_all_pagination_limit');
    if ($limit == -1) {
        $limit = "";
    }
    $page = (get_query_var('page')) ? get_query_var('page') : 1;
    ;
    $offset = ($page * $limit) - $limit;
    $param = array('orderby' => 'post_date', 'order' => 'DESC', 'status' => 'approve', 'offset' => $offset, 'post_id' => $listing_id, 'number' => $limit);
    $total_comments = get_comments(array('post_type' => 'listing', 'post_id' => $listing_id, 'status' => 'approve', 'parent' => 0));
    if (isset($limit) && $limit != "") {
        $pages = ceil(count($total_comments) / $limit);
    }
    $comments = get_comments($param);
} else {
    $listing_id = get_the_ID();
    $limit = dwt_listing_text('review_limit_listing_page');
    if ($limit == '-1') {
        $limit = "";
    }
    $comments = get_comments(array('post_id' => $listing_id, 'orderby' => 'post_date', 'order' => 'DESC', 'post_type' => 'listing', 'status' => 'approve', 'number' => $limit, 'parent' => 0));
}
$listing_slug = '';
if (count((array) $comments) > 0) {
    ?>

    <div class="reviews">
        <div class="review-filters">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="review-title">
                        <h3><?php echo esc_html__('User Reviews', 'dwt-listing'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $got_likes = '';
        foreach ($comments as $comment) {
            $replier_comment_id = '';
            $replier_user_id = '';
            $replier_remarks = '';
            $got_likes = '';
            $got_love = '';
            $got_wow = '';
            $got_angry = '';
            $commenter_id = dwt_listing_fetch_comment_poster($comment->user_id, 'id');
            $commenter_dp = dwt_listing_fetch_comment_poster($comment->user_id, 'dp');
            $commenter_name = dwt_listing_fetch_comment_poster($comment->user_id, 'name');
            $commenter_profile_url = dwt_listing_fetch_comment_poster($comment->user_id, 'url');
            $rated = get_comment_meta($comment->comment_ID, 'review_stars', true);
            $main_title = get_comment_meta($comment->comment_ID, 'review_main_title', true);
            if (get_comment_meta($comment->comment_ID, 'review_like', true) != "") {
                $focus_class = 'focus';
                $got_likes = get_comment_meta($comment->comment_ID, 'review_like', true);
            }
            if (get_comment_meta($comment->comment_ID, 'review_love', true) != "") {
                $focus_class = 'focus';
                $got_love = get_comment_meta($comment->comment_ID, 'review_love', true);
            }
            if (get_comment_meta($comment->comment_ID, 'review_wow', true) != "") {
                $focus_class = 'focus';
                $got_wow = get_comment_meta($comment->comment_ID, 'review_wow', true);
            }
            if (get_comment_meta($comment->comment_ID, 'review_angry', true) != "") {
                $focus_class = 'focus';
                $got_angry = get_comment_meta($comment->comment_ID, 'review_angry', true);
            }
            //fetch replies of that post
            $replies = get_comments(array('parent' => $comment->comment_ID, 'status' => 'approve', 'orderby' => 'comment_date', 'order' => 'DESC'));
            $total_count = dwt_listing_submitted_reviews($comment->user_id);
            ?>	
            <div class="review-box">
                <div class="review-author-left">
                    <div class="review-author-img"> <a target="_blank" href="<?php echo esc_url($commenter_profile_url); ?>"><img src="<?php echo esc_url($commenter_dp); ?>" class="img-responsive" alt="<?php echo esc_html__('no image', 'dwt-listing'); ?>"></a>
                        <div class="reviewer-category">
                            <?php if (dwt_listing_text('dwt_listing_enable_names') == "1") { ?>
                                <?php if (dwt_listing_review_user_tagline($total_count) != '') { ?>
                                    <span class="reviewer-category-badge"><?php echo dwt_listing_review_user_tagline($total_count); ?></span>
                                    <?php
                                }
                            }
                            ?>
                            <?php if (dwt_listing_text('dwt_listing_show_total_ratings') == "1") { ?>
                                <span> <?php echo dwt_listing_submitted_reviews($comment->user_id) . ' ' . esc_html__('ratings', 'dwt-listing'); ?></span>
                            <?php } ?>  
                        </div>
                    </div>
                </div>
                <div class="review-author-right">
                    <div class="review-author-detail">
                        <h4><?php echo esc_attr($main_title); ?></h4>
                        <div class="review-detail-meta">
                            <?php
                            if ($rated != "") {
                                ?>
                                <span class="ratings">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rated) {
                                            echo '<i class="fa fa-star color"></i>';
                                        } else {
                                            echo '<i class="fa fa-star"></i>';
                                        }
                                    }
                                    ?>
                                    <i class="rating-counter"> (<?php echo esc_attr($rated); ?>/<?php echo esc_html__('5', 'dwt-listing'); ?>)</i>
                                </span>
                                <?php
                            }
                            ?>
                            <?php echo esc_html__('By', 'dwt-listing'); ?> <a target="_blank" href="<?php echo esc_url($commenter_profile_url); ?>"> <strong><?php echo esc_attr($comment->comment_author); ?></strong></a> <?php echo esc_html__('on', 'dwt-listing'); ?> <strong><?php echo date_i18n('j F, Y', strtotime(get_the_time($comment->comment_date))); ?></strong> </div>
                        <p><?php echo esc_attr($comment->comment_content); ?></p>
                        <?php
                        if (get_comment_meta($comment->comment_ID, 'review_images_idz', true) != "") {
                            //get images idz
                            $images_idz = get_comment_meta($comment->comment_ID, 'review_images_idz', true);
                            if ($images_idz != "") {
                                $media = explode(',', $images_idz);
                                if (count($media) > 0) {
                                    ?>
                                    <p class="image-gallery">
                                        <?php
                                        $counter = 0;
                                        $my_class = '';
                                        foreach ($media as $m) {
                                            $mid = '';
                                            if (isset($m->ID)) {
                                                $mid = $m->ID;
                                            } else {
                                                $mid = $m;
                                            }
                                            $full_img = wp_get_attachment_image_src($mid, 'full');
                                            $thumb_imgs = wp_get_attachment_image_src($mid, 'dwt_listing_slider-thumb');
                                            /* check for empty */
                                            if ($full_img != '') {
                                                $full_img = esc_url($full_img[0]);
                                            } else {
                                                $full_img = '';
                                            }
                                            /* check for empty */
                                            if ($thumb_imgs != '') {
                                                $thumb_imgs = esc_url($full_img[0]);
                                            } else {
                                                $thumb_imgs = '';
                                            }
                                            if ($counter < 5) {

                                                if ($counter == 4) {
                                                    $my_class = '<span class="more-images">+</span>';
                                                }
                                                ?>	
                                                <span class="review-img-container">
                                                    <a href="<?php echo $full_img; ?>" data-fancybox="images-preview-<?php echo '' . $comment->comment_ID; ?>"> <img src="<?php echo $thumb_imgs; ?>" class="img-responsive" alt="image" /><?php echo '' . $my_class; ?></a> 
                                                </span>
                                                <?php
                                            } else {
                                                ?>
                                            <div class="hidden">
                                                <a href="<?php echo $full_img; ?>" data-fancybox="images-preview-<?php echo '' . $comment->comment_ID; ?>"> <img src="<?php echo $thumb_imgs; ?>" class="img-responsive" alt="image" /> </a> 
                                            </div>
                                            <?php
                                        }
                                        $counter++;
                                    }
                                }
                                ?>
                                </p>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if (dwt_listing_text('dwt_listing_review_enable_emoji') == '1') {
                            ?>
                            <div class="review-helpful"> <span><?php echo esc_html__('Your reaction about this review', 'dwt-listing'); ?></span>
                                <div class="Like">
                                    <div class="Emojis">
                                        <div class="Emoji  Emoji-like"  data-reaction="1" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                            <div class="emoji-name"> <?php echo esc_html__('Like', 'dwt-listing'); ?></div>
                                            <div class="icon icon-like"></div>
                                            <div class="emoji-count likes-<?php echo esc_attr($comment->comment_ID); ?>"><?php echo esc_attr($got_likes); ?></div>
                                        </div>
                                        <div class="Emoji Emoji-love" data-reaction="2" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                            <div class="emoji-name"> <?php echo esc_html__('Love', 'dwt-listing'); ?></div>
                                            <div class="icon icon-heart" ></div>
                                            <div class="emoji-count loves-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_love); ?> </div>
                                        </div>

                                        <div class="Emoji Emoji-wow" data-reaction="3" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                            <div class="emoji-name"> <?php echo esc_html__('Wow', 'dwt-listing'); ?></div>
                                            <div class="icon icon-wow" ></div>
                                            <div class="emoji-count wows-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_wow); ?> </div>
                                        </div>

                                        <div class="Emoji Emoji-angry" data-reaction="4" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                            <div class="emoji-name"> <?php echo esc_html__('Angry', 'dwt-listing'); ?></div>
                                            <div class="icon icon-angry"></div>
                                            <div class="emoji-count angrys-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_angry); ?> </div>
                                        </div>
                                        <img id="reaction-loader-<?php echo esc_attr($comment->comment_ID); ?>" class="none" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/dwt_listing.gif'); ?>" alt="<?php echo esc_html__('not found', 'dwt-listing'); ?>">
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        //replies
                        if (count((array) $replies) > 0) {
                            foreach ($replies as $reply) {
                                $replier_comment_id = $reply->comment_ID;
                                //get user that claim for listing
                                ?>
                                <div class="profile-review-reply-box">
                                    <h5> <strong><?php echo esc_html__('Author responded on', 'dwt-listing'); ?></strong>  <span class="responded"><?php echo date_i18n('j F, Y', strtotime(get_the_time($reply->comment_date))); ?></span></h5>
                                    <p class="profile-review-reply"><?php echo '' . $reply->comment_content; ?></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    if (is_singular('listing')) {
        if (isset($limit) && $limit != "" && get_comments_number($listing_id) > $limit) {
            ?>	
            <div class="all-reviews">

                <a target="_blank" class="btn btn-block btn-theme" href="<?php echo dwt_listing_pagelink('dwt_listing_allreview_page'); ?>?review_id=<?php echo esc_attr($listing_id); ?>"><?php echo dwt_listing_text('dwt_listing_review_limit_btn_text'); ?></a>
            </div>
            <?php
        }
    }
    ?>
    <?php
    if (isset($_GET['review_id']) && $_GET['review_id'] != "" && $limit != "") {
        echo '<div class="review-pagination">' . dwt_listing_comments_pagination($pages, $page) . ' </div>';
    }
    ?>	
    <?php
}
?>
