<?php
global $dwt_listing_options;
$user_dp = dwt_listing_fetch_comment_poster($user_id, 'dp');
$user_name = dwt_listing_fetch_comment_poster($user_id, 'name');
$user_profile_url = dwt_listing_fetch_comment_poster($user_id, 'url');
?>
<aside class="sidebar transparen-listing-sidebar">
    <div class="contact-box">
        <div class="contact-img">
            <img src="<?php echo esc_url($user_dp); ?>" class="img-circle img-responsive" alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>">
        </div>
        <div class="contact-caption">
            <h4><a href="javascript:void(0)"><?php echo esc_attr($user_name); ?></a></h4>
            <span><?php echo dwt_listing_fetch_comment_poster($user_id, 'location'); ?></span>
        </div>
    </div>
    <div class="profile-widget">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab"><?php echo esc_html__('Detail', 'dwt-listing'); ?></a></li>
                    <li><a href="#tab2default" data-toggle="tab"><?php echo esc_html__('Contact', 'dwt-listing'); ?></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1default">
                        <ul class="widget-listing-details">
                            <li>
                                <span> 
                                    <img alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/login.png'); ?>">
                                </span>
                                <span>
                                    <a href="javascript:void(0)"><?php echo esc_html__('Last Active', 'dwt-listing'); ?> : <strong><?php echo dwt_listing_get_last_login($user_id) . ' ' . esc_html__('ago', 'dwt-listing'); ?></strong></a>
                                </span>
                            </li>
                            <?php if (get_user_meta($user_id, 'd_user_contact', true) != '') { ?>
                                <li> <span><img alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/phone.png'); ?>"></span> <span> <a href="tel:<?php echo get_user_meta($user_id, 'd_user_contact', true); ?>"><?php echo get_user_meta($user_id, 'd_user_contact', true); ?></a></span> </li>
                            <?php } ?>
                            <?php if (get_user_meta($user_id, 'd_about_user', true) != '') { ?>
                                <li> <p><span><?php echo dwt_listing_clean_strings(get_user_meta($user_id, 'd_about_user', true)); ?></span></p></li>
                            <?php } ?>
                            
                        </ul>
                        <ul class="social-media">
                            <?php if (get_user_meta($user_id, 'd_fb_link', true) != '') { ?>
                                <li><a href="<?php echo esc_url(get_user_meta($user_id, 'd_fb_link', true)); ?>"><i class="ti-facebook"></i></a></li>
                            <?php } ?>
                            <?php if (get_user_meta($user_id, 'd_twitter_link', true) != '') { ?>
                                <li><a href="<?php echo esc_url(get_user_meta($user_id, 'd_twitter_link', true)); ?>"><i class="ti-twitter"></i></a></li>
                            <?php } ?>
                            <?php if (get_user_meta($user_id, 'd_google_link', true) != '') { ?>
                                <li><a href="<?php echo esc_url(get_user_meta($user_id, 'd_google_link', true)); ?>"><i class="ti-google"></i></a></li>
                            <?php } ?>
                            <?php if (get_user_meta($user_id, 'd_linked_link', true) != '') { ?>
                                <li><a href="<?php echo esc_url(get_user_meta($user_id, 'd_linked_link', true)); ?>"><i class="ti-linkedin"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="tab2default">
                        <form method="post" data-disable="false" id="email-to-author">
                            <div class="form-group">
                                <input placeholder="<?php echo esc_html__('Your Name', 'dwt-listing'); ?>" name="name" class="form-control" type="text" required>
                            </div>
                            <div class="form-group">
                                <input placeholder="<?php echo esc_html__('Email address', 'dwt-listing'); ?>" name="email" class="form-control" type="email" required>
                            </div>
                            <div class="form-group">
                                <input placeholder="<?php echo esc_html__('Phone number or mobile number', 'dwt-listing'); ?>" name="phone" class="form-control" type="number" required>
                            </div>
                            <div class="form-group">
                                <textarea cols="6" name="message" rows="6" placeholder="<?php echo esc_html__('Your Message', 'dwt-listing'); ?>" class="form-control" required></textarea>
                            </div>
                            <input type="hidden" name="author_id" value="<?php echo esc_attr($user_id); ?>">
                            <button type="submit" class="btn btn-theme sonu-button"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Send Message", 'dwt-listing'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>