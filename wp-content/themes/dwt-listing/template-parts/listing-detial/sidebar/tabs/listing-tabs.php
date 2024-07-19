<?php
global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<div class="profile-widget">
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1default"
                                      data-toggle="tab"><?php echo esc_html__('Listing Detail', 'dwt-listing'); ?></a>
                </li>
                <li><a href="#tab2default" data-toggle="tab"><?php echo esc_html__('Contact', 'dwt-listing'); ?></a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1default">
                    <ul class="widget-listing-details">
                        <?php
                        if (dwt_listing_listing_custom_location($listing_id) != "") {
                            ?>
                            <li>
                                <span> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/map.png'); ?>"
                                            alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span>
                                <span><?php echo dwt_listing_listing_custom_location($listing_id); ?></span></li>
                            <?php
                        }
                        ?>
                        <?php
                        if (get_post_meta($listing_id, 'dwt_listing_listing_contact', true) != "") {
                            ?>
                            <li class="track-me"><span> <img
                                            src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/phone.png'); ?>"
                                            alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span> <span> <a
                                            data-reaction="contact"
                                            data-listing-id="<?php echo esc_attr($listing_id); ?>"
                                            href="tel:<?php echo get_post_meta($listing_id, 'dwt_listing_listing_contact', true); ?>"><?php echo get_post_meta($listing_id, 'dwt_listing_listing_contact', true); ?></a></span>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (get_post_meta($listing_id, 'dwt_listing_listing_weburl', true) != "") {
                            ?>
                            <li class="track-me"><span> <img
                                            src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/globe.png'); ?>"
                                            alt="<?php echo esc_html__('icon', 'dwt-listing'); ?>"></span> <span> <a
                                            data-reaction="web" data-listing-id="<?php echo esc_attr($listing_id); ?>"
                                            target="_blank"
                                            href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_listing_weburl', true)); ?>"><?php echo esc_html__('View Website', 'dwt-listing'); ?></a></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                    <?php
                    if (get_post_meta($listing_id, 'dwt_listing_listing_fb', true) != "" || get_post_meta($listing_id, 'dwt_listing_listing_tw', true) != "" || get_post_meta($listing_id, 'dwt_listing_listing_google', true) != "" || get_post_meta($listing_id, 'dwt_listing_listing_in', true) != "" || get_post_meta($listing_id, 'dwt_listing_youtube', true) != "" || get_post_meta($listing_id, 'dwt_listing_insta', true) != "" || (get_post_meta($listing_id, 'dwt_listing_whatsapp', true) != "")) {
                        ?>
                        <ul class="social-media">
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_listing_fb', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_listing_fb', true)); ?>"><i
                                                class="ti-facebook"></i></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_listing_tw', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_listing_tw', true)); ?>"><i
                                                class="ti-twitter"></i></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_listing_google', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_listing_google', true)); ?>"><i
                                                class="ti-google"></i></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_listing_in', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_listing_in', true)); ?>"><i
                                                class="ti-linkedin"></i></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_youtube', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_youtube', true)); ?>"><i
                                                class="ti-youtube "></i></a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_insta', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="<?php echo esc_url(get_post_meta($listing_id, 'dwt_listing_insta', true)); ?>"><i
                                                class="ti-instagram"></i></a></li>
                                <?php
                            }
                            ?>

                            <?php
                            if (get_post_meta($listing_id, 'dwt_listing_whatsapp', true) != "") {
                                ?>
                                <li><a target="_blank"
                                       href="https://api.whatsapp.com/send?phone=<?php echo(get_post_meta($listing_id, 'dwt_listing_whatsapp', true)); ?>"><i
                                                class="fa fa-whatsapp"></i></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                    <?php
                    $chat_option = isset($dwt_listing_options['enable_chat_option']) ? $dwt_listing_options['enable_chat_option']:'';
                    
                    if(!empty($chat_option))
                    {
                    ?>
                    <br>
                        <form id="send-message-to-listing-owner" method="post" data-disable="false">
                            <input class="form-control" type="text" name="message" placeholder="Enter Message..">
                            <input type="hidden" id="posted_listing_id" name="posted_listing_id"
                                   value="<?php echo esc_attr($listing_id); ?>"/>
                            <button type="submit" class="btn btn-theme sonu-button-<?php echo esc_attr($listing_id); ?>"
                                    data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Send Message", 'dwt-listing'); ?></button>
                        </form>
                        <?php
                        }
                        ?>
                </div>
                <div class="tab-pane fade" id="tab2default">
                    <form method="post" data-disable="false" id="listing-owner-contact">
                        <div class="form-group">
                            <input placeholder="<?php echo esc_html__('Your Name', 'dwt-listing'); ?>" name="name"
                                   class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <input placeholder="<?php echo esc_html__('Email address', 'dwt-listing'); ?>" name="email"
                                   class="form-control" type="email" required>
                        </div>
                        <div class="form-group">
                            <input placeholder="<?php echo esc_html__('Phone number or mobile number', 'dwt-listing'); ?>"
                                   name="phone" class="form-control" type="number" required>
                        </div>
                        <div class="form-group">
                            <textarea cols="6" name="message" rows="6"
                                      placeholder="<?php echo esc_html__('Your Message', 'dwt-listing'); ?>"
                                      class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <input class="custom-checkbox" type="checkbox" id="terms_cond_list_admin"
                                   name="terms_cond_list_admin" class="form-control"
                                   data-error="<?php echo esc_html__("Term & Conditions are required.", 'dwt-listing'); ?>"
                                   required>
                            <label for="terms_cond_list_admin"><?php echo esc_html__('I agree to', 'dwt-listing'); ?> <a
                                        href="<?php echo trailingslashit(get_the_permalink($dwt_listing_options['dwt_listing_faqs-page'])); ?>"
                                        target="_blank"><?php echo esc_html__("Term & Conditions", 'dwt-listing'); ?></a></label>
                            <div class="help-block with-errors"></div>
                        </div>
                        <input type="hidden" id="posted_listing_id" name="posted_listing_id"
                               value="<?php echo esc_attr($listing_id); ?>"/>
                        <button type="submit" class="btn btn-theme sonu-button-<?php echo esc_attr($listing_id); ?>"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Send Message", 'dwt-listing'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>