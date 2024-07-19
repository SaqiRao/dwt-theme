<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$uid = $profile->user_info->ID;
$get_user_dp = dwt_listing_get_user_dp($uid, 'dwt_listing_user-dp');
dwt_listing_google_locations();
wp_enqueue_script("google-map-callback");
if (get_user_meta($uid, 'dwt_listing_user_hours_type', true) != "" && get_user_meta($uid, 'dwt_listing_user_hours_type', true) == "24") {
    $seleted_hours = '24';
} else {
    $seleted_hours = '12';
}

/* $collection = $wpdb->get_results("
  SELECT YEAR(p.post_date) AS post_year, MONTH(p.post_date) AS post_month, p.*
  FROM {$wpdb->posts} AS p
  WHERE p.post_type = 'listing' AND p.post_status = 'publish' AND p.post_author = '".$uid."'
  ORDER BY p.post_date DESC
  ", OBJECT ); */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
            <div class="panel dashboard ">
                <div class="panel-body no-padding">
                    <div class="contact-box">
                        <div class="contact-img">
                            <img src="<?php echo esc_url($get_user_dp); ?>" class="img-circle img-responsive profile-pic" alt="<?php echo esc_html__('not found', 'dwt-listing'); ?>">
                            <form  enctype="multipart/form-data">
                                <?php
                                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                    echo '<div class="p-image"><i class="fa fa-camera tool-tip profile-upload-button" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"></i></div>';
                                } else {
                                    ?>
                                    <div class="p-image">
                                        <i class="fa fa-camera profile-upload-button" title="<?php echo esc_html__('Upload profile image', 'dwt-listing'); ?>"></i>
                                        <input class="profile-file-upload" name="my_file_upload[]" type="file" accept="image/*"/>
                                    </div>
                                <?php } ?>
                            </form> 
                        </div>
                        <div class="contact-caption">
                            <h4><?php echo esc_attr($profile->user_info->display_name); ?></h4>
                            <span><?php echo esc_attr($profile->user_info->d_user_location); ?></span>
                        </div>
                        <div id="img-upload-success" class="alert custom-alert custom-alert--success none" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon ti-face-smile "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("Profile image uploaded.", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div id="max-img-size" class="alert custom-alert custom-alert--warning none" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("Max allowd image size is 300KB", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="error-messages" class="alert custom-alert custom-alert--warning none" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-info">
                        <h4 class="heading"> <?php echo esc_html__('Basic Info', 'dwt-listing'); ?></h4>
                        <ul class="list-unstyled list-justify">
                            <li><img alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/paper-plane.png'); ?>"> <?php echo esc_attr($profile->user_info->user_email); ?></li>
                            <li><img alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/phone-receiver.png'); ?>"> <?php echo esc_attr($profile->user_info->d_user_contact); ?></li>
                            <li><img alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/destination.png'); ?>"> <?php echo esc_attr($profile->user_info->d_user_location); ?></li>
                            <li><img alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/alarm-clock.png'); ?>"> <?php echo esc_attr($profile->user_info->d_user_timezone); ?></li>
                        </ul>
                    </div>
                    <div class="profile-info">
                        <h4 class="heading"><?php echo esc_html__('About', 'dwt-listing'); ?></h4>
                        <p style="overflow-wrap: break-word;"><?php echo ($profile->user_info->d_about_user); ?></p>
                    </div>
                    <div class="profile-info">
                        <h4 class="heading"><?php echo esc_html__('Social Channels', 'dwt-listing'); ?></h4>
                        <ul style="overflow-wrap: break-word;" class="list-unstyled list-justify">
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/facebook.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_fb_link); ?>"><?php echo esc_url($profile->user_info->d_fb_link); ?></a></li>
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/twitter.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_twitter_link); ?>"><?php echo esc_url($profile->user_info->d_twitter_link); ?></a></li>
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/google-plus.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_google_link); ?>"><?php echo esc_url($profile->user_info->d_google_link); ?></a></li>
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/linkedin.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_linked_link); ?>"><?php echo esc_url($profile->user_info->d_linked_link); ?></a></li>
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/youtube.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_youtube_link); ?>"><?php echo esc_url($profile->user_info->d_youtube_link); ?></a></li>
                            <li><img width="20" alt="<?php echo esc_attr__('not found', 'dwt-listing'); ?>" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/instagram.png'); ?>"> <a href="<?php echo esc_url($profile->user_info->d_insta_link); ?>"><?php echo esc_url($profile->user_info->d_insta_link); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="panel account-deletion">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Account Deletion', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo esc_html__("If you want to delete your account your all data will be removed from this site.", 'dwt-listing'); ?></p>
                    <?php
                    if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                        echo '<button type="button" class="btn btn-warning tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Delete My Account', 'dwt-listing') . ' </button>';
                    } else {
                        ?>	
                        <a href="javascript:void(0)" data-userid="<?php echo esc_attr($uid); ?>" class="delete-my-account btn btn-warning sonu-button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__('Delete My Account', 'dwt-listing'); ?></a>    
                        <?php
                    }
                    ?>
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Profile', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <form  method="post" id="profile-update" data-disable="false">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Name', 'dwt-listing'); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="user-name" placeholder="<?php echo esc_html__('City or Write your complete name', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->display_name); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Email', 'dwt-listing'); ?> <span>*</span></label>
                                    <input disabled type="email" class="form-control" name="email" placeholder="<?php echo esc_html__('City or Write your email', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->user_email); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Phone No.', 'dwt-listing'); ?> </label>
                                    <input type="number" class="form-control" name="phon-no" placeholder="<?php echo esc_html__('Contact number', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_user_contact); ?>" >
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Location', 'dwt-listing'); ?> <span>*</span></label>
                                    <input type="text" id="address_location" class="form-control" name="location" placeholder="<?php echo esc_html__('Your Location', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_user_location); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group bhours-format">
                                    <label class="control-label lfirst"><?php echo esc_html__("Business Hours Format", 'dwt-listing') ?></label>
                                    <label class="control-label">
                                        <input class="custom-checkbox" type="radio" id="am_pm" name="my_hours_type" value="12" <?php checked('12', $seleted_hours, true); ?>>
                                        <span><?php echo esc_html__('12 Hours Format', 'dwt-listing'); ?></span>
                                    </label>
                                    <label class="control-label">
                                        <input class="custom-checkbox" type="radio" id="not_am_pm" name="my_hours_type" value="24" <?php checked('24', $seleted_hours, true); ?>>
                                        <span><?php echo esc_html__('24 Hours Format', 'dwt-listing'); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group my-zones" id="timezone">
                                    <label class="control-label"><?php echo esc_html__('Select Your Timezone', 'dwt-listing'); ?> <span>*</span></label><div class="typeahead__container">
                                        <div class="typeahead__field">
                                            <div class="typeahead__query">
                                                <input autocomplete="off" type="search" class="myzones-t form-control" value="<?php echo esc_attr($profile->user_info->d_user_timezone); ?>" name="user_timezome" required> 
                                            </div>
                                        </div>
                                    </div> 

                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('About Yourself', 'dwt-listing'); ?> <span>*</span></label>
                                    <textarea name="about-yourself" class="jqte-test" required><?php echo esc_textarea($profile->user_info->d_about_user); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="social-media-fields">
                                    <div class="row">

                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-facebook"></i></span>
                                                    <input type="url" class="form-control" name="social-facebook" placeholder="<?php echo esc_html__('Facebook URL', 'dwt-listing'); ?>" data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_fb_link); ?>">
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-twitter"></i></span>
                                                    <input type="url" class="form-control" name="social-twitter" placeholder="<?php echo esc_html__('Twitter URL', 'dwt-listing'); ?>"  data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_twitter_link); ?>">
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-google"></i></span>
                                                    <input type="url" class="form-control" name="social-google" placeholder="<?php echo esc_html__('Google Plus URL', 'dwt-listing'); ?>"  data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_google_link); ?>" >
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-linkedin"></i></span>
                                                    <input type="url" class="form-control" name="social-linkedin" placeholder="<?php echo esc_html__('LinkedIn URL', 'dwt-listing'); ?>"  data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_linked_link); ?>" >
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-youtube "></i></span>
                                                    <input type="url" class="form-control" name="social-youtube" placeholder="<?php echo esc_html__('Youtube URL', 'dwt-listing'); ?>"  data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_youtube_link); ?>" >
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-instagram"></i></span>
                                                    <input type="url" class="form-control" name="social-insta" placeholder="<?php echo esc_html__('Instagram URL', 'dwt-listing'); ?>"  data-error="<?php echo esc_html__('Please enter a valid URL', 'dwt-listing'); ?>" value="<?php echo esc_attr($profile->user_info->d_insta_link); ?>" >
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                    echo '<button type="button" class="btn btn-primary tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Update Profile', 'dwt-listing') . ' </button>';
                                } else {
                                    ?>
                                    <button type="submit" id="p_up" class="btn btn-primary sonu-button update_profile"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Update Profile", 'dwt-listing'); ?></button>
                                <?php } ?>

                                <div class="clearfix"></div>
                                <div id="success-messages" class="alert custom-alert custom-alert--success none" role="alert">
                                    <div class="custom-alert__top-side">
                                        <span class="alert-icon custom-alert__icon  ti-face-smile "></span>
                                        <div class="custom-alert__body">
                                            <h6 class="custom-alert__heading">
                                                <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                            </h6>
                                            <div class="custom-alert__content">
                                                <?php echo esc_html__("You profile has been updated successfully.", 'dwt-listing'); ?><br>
                                                <?php echo esc_html__("Redirecting please wait....", 'dwt-listing'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Change Password', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div id="password-success" class="alert custom-alert custom-alert--success none" role="alert">
                        <div class="custom-alert__top-side">
                            <span class="alert-icon custom-alert__icon  ti-face-smile "></span>
                            <div class="custom-alert__body">
                                <h6 class="custom-alert__heading">
                                    <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                </h6>
                                <div class="custom-alert__content">
                                    <?php echo esc_html__("Your Password Changed successfully.", 'dwt-listing'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" id="resetPassword" data-disable="false">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group has-feedback">
                                    <input  name="dwt_listing_mypass" data-error="<?php echo esc_html__("Please fill out this field.", 'dwt-listing'); ?>" id="dwt_listing_mypass" class="form-control" type="password" placeholder="<?php echo esc_html__("New Password", 'dwt-listing'); ?>"   required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group has-feedback">
                                    <input  name="dwt_listing_mypass_conf" data-error="<?php echo esc_html__("Please fill out this field.", 'dwt-listing'); ?>" id="dwt_listing_mypass_conf" class="form-control" type="password" placeholder="<?php echo esc_html__("Confirm New Password", 'dwt-listing'); ?>" data-match="#dwt_listing_mypass" data-match-error="<?php echo esc_html__("Whoops, these don't match", 'dwt-listing'); ?>"  required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?php
                                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                    echo '<button type="button" class="btn btn-admin sonu-button tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Save Changes', 'dwt-listing') . ' </button>';
                                } else {
                                    ?>
                                    <button type="submit" class="btn btn-admin sonu-button-reset"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Save Changes", 'dwt-listing'); ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                         