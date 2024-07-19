<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;

//pagination 
$pages = $page = '';
$limit = 10;
$limit = dwt_listing_text('dwt_listing_review_all_pagination_limit');
if ($limit == -1) {
    $limit = "";
}
$page = (get_query_var('page')) ? get_query_var('page') : 1;
$offset = ($page * $limit) - $limit;
//get listings that having comments 
$param = array('status' => 'approve', 'post_type' => 'listing', 'post_author__in' => array($user_id), 'orderby' => 'post_date', 'order' => 'DESC', 'number' => $limit, 'offset' => $offset, 'parent' => 0);
$total_comments = dwt_listing_received_reviews($user_id);
if (isset($limit) && $limit != "") {
    $pages = ceil($total_comments) / $limit;
}
$comments = get_comments($param);
?>

<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/dashboard'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Received Reviews', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="profile-detail-area">
                        <?php
                        if (count((array) $comments) > 0) {
                            ?>          	
                            <?php
                            foreach ($comments as $comment) {
                                $reply_comment_id = '';
                                $replier_msg = '';
                                $comment_id = $comment->comment_ID;
                                $listing_id = $comment->comment_post_ID;
                                $commenter_dp = dwt_listing_fetch_comment_poster($comment->user_id, 'dp');
                                $commenter_profile_url = dwt_listing_fetch_comment_poster($comment->user_id, 'url');
                                $rated = get_comment_meta($comment_id, 'review_stars', true);
                                $main_title = get_comment_meta($comment_id, 'review_main_title', true);
                                //fetch replies of that post
                                $replies = get_comments(array('parent' => $comment->comment_ID, 'status' => 'approve', 'orderby' => 'comment_date', 'order' => 'DESC'));
                                if (count((array) $replies) > 0) {
                                    foreach ($replies as $reply) {
                                        $reply_comment_id = $reply->comment_ID;
                                        $replier_msg = esc_attr($reply->comment_content);
                                    }
                                }
                                ?>
                                <div class="profile-review-box">
                                    <a href="<?php echo esc_url($commenter_profile_url); ?>"><img class="img-circle" src="<?php echo esc_url($commenter_dp); ?>" alt="<?php echo esc_html__('no image', 'dwt-listing'); ?>"></a>
                                    <div class="profile-review-box-info">
                                        <div class="profile-review-title">
                                            <p><a href="<?php echo esc_url($commenter_profile_url); ?>"><?php echo esc_attr($comment->comment_author); ?></a> <?php echo esc_html__('posted a review on', 'dwt-listing'); ?> <a href="<?php echo get_the_permalink($listing_id); ?>" title="<?php echo get_the_title($listing_id); ?>"><?php echo get_the_title($listing_id); ?></a>
                                            </p>
                                            <span class="review-toggle-angle collapsed" data-toggle="collapse" data-target="#review-<?php echo esc_attr($comment_id); ?>">
                                                <i class="ti-angle-up"></i>
                                            </span>
                                        </div>
                                        <?php
                                        //check if stars are enabled or not
                                        if (dwt_listing_text('dwt_listing_review_enable_stars') == 1) {
                                            ?>	
                                            <div class="profile-review-meta">
                                                <ul>
                                                    <li>
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
                                                    </li>
                                                    <li><?php echo '<i class="lnr lnr-calendar-full"></i>' . date_i18n('j F, Y', strtotime(get_the_time($comment->comment_date))); ?></li>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="profile-review-box-text collapse" id="review-<?php echo esc_attr($comment_id); ?>" >
                                            <p><?php echo esc_attr($comment->comment_content); ?></p>
                                            <div class="profile-review-reply-box">
                                                <p><?php echo esc_html__('Reply to this review', 'dwt-listing'); ?> </p>
                                                <form class="review-reply" method="post" data-disable="false" data-cid="<?php echo esc_attr($comment_id); ?>">
                                                    <div class="form-group">
                                                        <textarea name="comments-review-reply" placeholder="<?php echo esc_html__('Write a reply to this review', 'dwt-listing'); ?>"  cols="10" rows="5" required><?php echo '' . $replier_msg; ?></textarea>
                                                        <div class="help-block"></div>
                                                    </div>

                                                    <input type="hidden" name="listing_id" value="<?php echo esc_attr($listing_id); ?>">
                                                    <input type="hidden" name="review_reply_id" value="<?php echo esc_attr($reply_comment_id); ?>">
                                                    <?php
                                                    if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                        echo '<button type="button" class="btn btn-theme tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Submit Reply', 'dwt-listing') . ' </button>';
                                                    } else {
                                                        ?>
                                                        <button type="submit" class="btn btn-admin sonu-button-reply-<?php echo esc_attr($comment_id); ?>"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Submit Reply", 'dwt-listing'); ?></button>
                                                    <?php } ?>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            echo '<div class="clearfix"></div><div class="review-pagination">' . dwt_listing_comments_pagination($pages, $page) . ' </div>';
                        } else {
                            ?>
                            <div class="alert custom-alert custom-alert--warning" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading"><?php echo esc_html__('No Review Received!', 'dwt-listing'); ?></h6>
                                        <div class="custom-alert__content"><?php echo esc_html__("You dont received any review yet!", 'dwt-listing'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>