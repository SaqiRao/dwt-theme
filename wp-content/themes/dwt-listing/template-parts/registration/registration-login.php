<?php global $dwt_listing_options; ?>

<div class="modal fade login" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> <?php echo esc_html__("Login With", 'dwt-listing'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="content">
                        <input type="hidden" value="" id="pack_type" name="pack_type">
                        <input type="hidden" value="" id="pack_id" name="pack_id">
                        <div class="social-media-group">
                            <div class="social">
                                <?php
                                if (isset($dwt_listing_options['gmail_api_key']) && $dwt_listing_options['gmail_api_key'] != ""):
                                    ?>
                                    <a id="google_login" href="javascript:void(0)" class="circle google" onclick="hello('google').login({scope: 'email'})">
                                        <i class="fa fa-google-plus fa-fw"></i>
                                    </a>
                                <?php endif; ?>
                                <?php
                                if (isset($dwt_listing_options['fb_api_key']) && $dwt_listing_options['fb_api_key'] != ""):
                                    ?>
                                    <a id="facebook_login" href="javascript:void(0)" class="circle facebook" onclick="hello('facebook').login({scope: 'email'})">
                                        <i class="fa fa-facebook fa-fw"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="division">
                                <div class="line l"></div>
                                <span><?php echo esc_html__("Or", 'dwt-listing'); ?></span>
                                <div class="line r"></div>
                            </div>
                        </div>   



                        <?php
                        /* for email verification */
                        get_template_part('template-parts/registration/email', 'verification');
                        ?>

                        <div id="woo-pack" class="alert custom-alert custom-alert--warning none" role="alert">
                            <div class="custom-alert__top-side">
                                <?php
                                $dwt_listing_login_scren_icon = '';
                                if(isset($dwt_listing_options['dwt_listing_login_scren_icon']) && $dwt_listing_options['dwt_listing_login_scren_icon'] != ''){
                                    $dwt_listing_login_scren_icon = "<span class='alert-icon custom-alert__icon ".$dwt_listing_options['dwt_listing_login_scren_icon']. "'></span>";
                                }
                                echo $dwt_listing_login_scren_icon;
                                ?>

                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("You must need to logged in.", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="social-success-register" class="alert custom-alert custom-alert--success none" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon ti-face-smile "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("You're registered and logged in successfully.", 'dwt-listing'); ?>
                                        <?php echo esc_html__("Redirecting please wait....", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="social-success-login" class="alert custom-alert custom-alert--success none" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon ti-face-smile "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("You have successfully logged in.", 'dwt-listing'); ?>
                                        <?php echo esc_html__("Redirecting please wait....", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="button" id="for-social" class="btn btn-theme sonu-button none  btn-block"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"></button>

                        <div class="form loginBox">

                            <div id="login-info-messages" class="alert custom-alert custom-alert--warning none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Invalid email or password.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div id="login-success-messages" class="alert custom-alert custom-alert--success none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon ti-face-smile "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("You have successfully logged in.", 'dwt-listing'); ?>
                                            <?php echo esc_html__("Redirecting please wait....", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="login-form" data-disable="false">
                                <?php
                                if (dwt_listing_text('dwt_listing_disable_edit') == '1') {
                                    ?>	
                                    <div class="form-group has-feedback">
                                        <input id="log_email" class="form-control" type="email" placeholder="<?php echo esc_html__("Your Email", 'dwt-listing'); ?>" value="melisa@gmail.com" name="log_email"  required>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input id="log_password" class="form-control" type="password" placeholder="<?php echo esc_html__("Your Password", 'dwt-listing'); ?>" name="log_password" value="admin" required>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="form-group has-feedback">
                                        <input id="log_email" class="form-control" type="email" placeholder="<?php echo esc_html__("Your Email", 'dwt-listing'); ?>" name="log_email"  required>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input id="log_password" class="form-control" type="password" placeholder="<?php echo esc_html__("Your Password", 'dwt-listing'); ?>" name="log_password" required>
                                    </div>
                                <?php } ?>

                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-7">
                                            <span><input type="checkbox" class="custom-checkbox" name="is_remember" id="is_remember"></span>
                                            <label for="is_remember"><?php echo esc_html__('Remember Me', 'dwt-listing'); ?></label>
                                        </div>

                                        <div class="col-xs-12 col-sm-5 text-right">
                                            <a href="javascript:void(0)" id="modal_to_hide" data-target="#forget-pass" data-toggle="modal"><?php echo esc_html__('Forgot password?', 'dwt-listing'); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-theme sonu-button  btn-block"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Login", 'dwt-listing'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box">


                    <div class="content registerBox" style="display:none;">
                        <div class="form">

                            <!-- still don't not email contact admin -->
                            <div id="not-getting-emails" class="alert custom-alert custom-alert--warning none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Problem getting email', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">

                                            <div class="clearfix"></div>
                                            <?php echo esc_html__("Still not get email?", 'dwt-listing'); ?> &nbsp; <a href="<?php echo trailingslashit(get_the_permalink($dwt_listing_options['admin_contact_page'])); ?>" class="link-info link-info--bordered" id="still_not"> <?php echo esc_html__("Contact Us", 'dwt-listing'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="warning-messages" class="alert custom-alert custom-alert--info none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Verification Required!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Registered successfully. An activation email has been sent to your provided email address.", 'dwt-listing'); ?>
                                            <div class="clearfix"></div>
                                            <?php echo esc_html__("Didn't get any email?", 'dwt-listing'); ?> &nbsp; <a href="javascript:void(0)" class="link-info link-info--bordered" id="resend_email"> <?php echo esc_html__("Resend Again", 'dwt-listing'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="info-messages" class="alert custom-alert custom-alert--warning none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Email already exists', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Please try another email or signin.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="success-messages" class="alert custom-alert custom-alert--success none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-check "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("You have successfully registered.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form  method="post" id="register-form" data-disable="false">

                                <div class="form-group has-feedback">
                                    <input id="user-name" class="form-control" data-error="<?php echo esc_html__("Please fill out this field.", 'dwt-listing'); ?>" type="text" placeholder="<?php echo esc_html__("Your Name", 'dwt-listing'); ?>" name="display_name" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group has-feedback">
                                    <input id="user-email" class="form-control" data-error="<?php echo esc_html__("Please fill out this field.", 'dwt-listing'); ?>" type="email" placeholder="<?php echo esc_html__("Your Email", 'dwt-listing'); ?>" name="email" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <input data-error="<?php echo esc_html__("Please fill out this field.", 'dwt-listing'); ?>" id="inputPassword" data-minlength="5" class="form-control" type="password" placeholder="<?php echo esc_html__("Your Password", 'dwt-listing'); ?>" name="password" required>
                                    <div class=" help-block with-errors"></div>
                                </div>
                                <div class="term-conditionz form-group">
                                    <input class="custom-checkbox"  type="checkbox" id="terms_cond" name="terms_cond" data-error="<?php echo esc_html__("Term & Conditions are required.", 'dwt-listing'); ?>" required >
                                    <label for="terms_cond"><?php echo esc_html__('I agree to', 'dwt-listing'); ?> <a href="<?php echo trailingslashit(get_the_permalink($dwt_listing_options['dwt_listing_faqs-page'])); ?>" target="_blank"><?php echo esc_html__("Term & Conditions", 'dwt-listing'); ?></a></label>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="clearfix"></div>
                                <?php
                                $captcha = '<input type="hidden" value="no" name="is_captcha" />';
                                if (dwt_listing_text('dwt_listing_recaptcha') == 1 && dwt_listing_text('google_api_key') != '') {
                                    $captcha = '<div class="form-group">
					 	 <div class="g-recaptcha" data-sitekey="' . dwt_listing_text('google_api_key') . '"></div>
				   		</div><input type="hidden" value="yes" name="name_captcha" />';
                                }
                                echo ($captcha);
                                ?>

                                <div id="captcha-messages" class="alert custom-alert custom-alert--warning none" role="alert">
                                    <div class="custom-alert__top-side">
                                        <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                        <div class="custom-alert__body">
                                            <h6 class="custom-alert__heading">
                                                <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                            </h6>
                                            <div class="custom-alert__content">
                                                <?php echo esc_html__('Please Verify Captcha Code', 'dwt-listing'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-theme sonu-button  btn-block"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing", 'dwt-listing'); ?>"><?php echo esc_html__("Create an account", 'dwt-listing'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span><?php echo esc_html__("Looking to", 'dwt-listing'); ?> 
                        <a href="javascript:void(0);" class="register-form-swipe"><?php echo esc_html__("create an account", 'dwt-listing'); ?></a>
                        ?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span><?php echo esc_html__("Already have an account?", 'dwt-listing'); ?></span>
                    <a href="javascript:void(0);" class="login-form-swipe"><?php echo esc_html__("Login", 'dwt-listing'); ?></a>
                </div>
            </div>        
        </div>
    </div>
</div>

<!-- Forget Password Model -->
<div class="modal login  fade" id="forget-pass" tabindex="-1" role="dialog">
    <div class="modal-dialog login  animated">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo esc_html__('Forgot your password?', 'dwt-listing') ?></h4>
            </div>
            <div class="modal-body">  
                <div class="box">
                    <div class="content">
                        <div class="form loginBox">


                            <div id="forget-messages" class="alert custom-alert custom-alert--success none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-check-box "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Password sent on your email.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="not-responding" class="alert custom-alert custom-alert--info none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Something went wrong!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Email server not responding.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="not-exist" class="alert custom-alert custom-alert--warning none" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon ti-alert "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('Ooopsss No result found!', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Email is not resgistered with us.", 'dwt-listing'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="forget-password" data-disable="false">
                                <div class="form-group has-feedback">
                                    <input  name="dwt_listing_forgot_email" id="dwt_listing_forgot_email" class="form-control" type="email" placeholder="<?php echo esc_html__("Your Email", 'dwt-listing'); ?>" data-error="<?php echo esc_html__("Please enter an email address.", 'dwt-listing'); ?>"  required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <button type="submit" class="btn btn-theme sonu-button  btn-block"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Reset My Account", 'dwt-listing'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>