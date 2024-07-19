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
;
$offset = ($page * $limit) - $limit;
$param = array('status' => 'approve', 'offset' => $offset, 'user_id' => $user_id, 'number' => $limit, 'post_type' => 'listing', 'orderby' => 'post_date', 'order' => 'DESC', 'parent' => 0);
$total_comments = dwt_listing_submitted_reviews($user_id);
if (isset($limit) && $limit != "") {
    $pages = ceil($total_comments / $limit);
}
$comments = get_comments($param);
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/dashboard'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Submitted Reviews', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="profile-detail-area">
                        <?php
                        if (count((array) $comments) > 0) {
                            ?>	
                            <?php
                            $comment_title = '';
                            $form_path = $main_title = $main_desc = $listing_id = $rated = '';
                            foreach ($comments as $comment) {
                                $comment_id = $comment->comment_ID;
                                $listing_id = $comment->comment_post_ID;
                                //get media
                                $media = dwt_listing_fetch_listing_gallery($listing_id);
                                $rated = get_comment_meta($comment_id, 'review_stars', true);
                                $main_title = get_comment_meta($comment_id, 'review_main_title', true);
                                $main_desc = esc_attr($comment->comment_content);
                                //get images idz
                                if (get_comment_meta($comment_id, 'review_images_idz', true) != "") {
                                    $images_idz = get_comment_meta($comment->comment_ID, 'review_images_idz', true);
                                } else {
                                    $images_idz = '';
                                }
                                ?>
                                <div class="profile-review-box unique-key-<?php echo esc_attr($comment_id); ?>">
                                    <img class="img-circle" src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_user-dp'); ?>" alt="<?php echo get_the_title($listing_id); ?>">
                                    <div class="profile-review-box-info">
                                <?php
                                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                    echo '<span class="tool-tip delete-my-sub-rev-dis" title="' . esc_attr__('Disable for Demo', 'dwt-listing') . '" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></span>';
                                } else {
                                    ?>	
                                            <span class="tool-tip sonu-button-<?php echo esc_attr($comment_id); ?> delete-my-sub-rev" title="<?php echo esc_attr__('Delete', 'dwt-listing'); ?>" href="javascript:void(0)" data-comment-id="<?php echo esc_attr($comment_id); ?>" data-listing-id="<?php echo esc_attr($listing_id); ?>" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-times" aria-hidden="true"></i></span>
                                            <?php
                                        }
                                        ?>
                                        <div class="profile-review-title">
                                            <p><?php echo esc_html__('You have posted a review on', 'dwt-listing'); ?> <a href="<?php echo get_the_permalink($listing_id); ?>" title="<?php echo get_the_title($listing_id); ?>"><?php echo get_the_title($listing_id); ?></a>
                                            </p>
                                            <span class="review-toggle-angle  collapsed"  data-toggle="collapse" data-target="#review-<?php echo esc_attr($comment_id); ?>">
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
                                        <div class="profile-review-box-text collapse" data-comment-id="<?php echo esc_attr($comment_id); ?>" id="review-<?php echo esc_attr($comment_id); ?>">
                                            <p><?php echo esc_attr($comment->comment_content); ?></p>
                                            <div class="profile-review-edit-box">
                                                <p class="comment-submitted collapsed" data-comment-id="<?php echo esc_attr($comment_id); ?>" data-toggle="collapse" data-target="#review-edit-<?php echo esc_attr($comment_id); ?>"> <i class="ti-pencil-alt"></i> <?php echo esc_html__('Edit Review', 'dwt-listing'); ?> </p>
                                                <div class="review-form collapse"  id="review-edit-<?php echo esc_attr($comment_id); ?>">
                                                    <?php
                                                    //fetch comment form
                                                    require trailingslashit(get_template_directory()) . 'template-parts/listing-detial/reviews/comment-form/form.php';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        <?php
    }
    echo '<div class="clearfix"></div><div class="review-pagination">' . dwt_listing_comments_pagination($pages, $page) . ' </div>';
    ?>

                                                <?php
                                            } else {
                                                ?>
                            <div class="alert custom-alert custom-alert--warning" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading"><?php echo esc_html__('No Review Submitted !', 'dwt-listing'); ?></h6>
                                        <div class="custom-alert__content"><?php echo esc_html__('Sorry! You have not submitted any review yet!', 'dwt-listing'); ?></div>
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