<?php
global $dwt_listing_options;
$user_id = get_current_user_id();
$zoom_client_id = get_user_meta($user_id, '_sb_zoom_client_id', true);
$zoom_client_secret = get_user_meta($user_id, '_sb_zoom_client_secret', true);
$zoom_reg_email = get_user_meta($user_id, '_sb_zoom_email', true);
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo esc_html__('Zoom Credentials', 'dwt-listing'); ?></h3>
    </div>
    <div class="panel-body">
        <form id="zoom-settings">
            <div class="preloading" id="dwt_listing_loading"></div>
            <div class="submit-listing-section">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label"><?php echo esc_html__('Zoom Email', 'dwt-listing'); ?><span>*</span><span
                                    id="zoomEmailError" class="text-danger fw-bold" style="display: none;">
                                    is required.
                                </span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-email"></i></span>
                                <input id="zoom_email" type="email" class="form-control" name="zoom_email"
                                    placeholder="<?php echo esc_attr('Zoom Email', 'dwt-listing'); ?>"
                                    value="<?php echo esc_attr($zoom_reg_email); ?>" required>
                                <div id="show-me" class="loader-field"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label"><?php echo esc_html__('Client ID', 'dwt-listing'); ?><span>*</span><span
                                    id="zoomClientIdError" class="text-danger fw-bold" style="display: none;">
                                    is required.
                                </span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-id-badge"></i></span>
                                <input id="zoom_client_id" type="text" class="form-control" name="zoom_client_id"
                                    placeholder="<?php echo esc_attr('Client ID', 'dwt-listing'); ?>"
                                    value="<?php echo esc_attr($zoom_client_id); ?>" required>
                                <div id="show-me" class="loader-field"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group has-feedback">
                            <label
                                class="control-label"><?php echo esc_html__('Client Secret', 'dwt-listing'); ?><span>*</span><span
                                    id="zoomClientSecretError" class="text-danger fw-bold" style="display: none;">
                                    is required.
                                </span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-key"></i></span>
                                <input id="zoom_client_secret" type="text" class="form-control"
                                    name="zoom_client_secret"
                                    placeholder="<?php echo esc_attr('Client Secret', 'dwt-listing'); ?>"
                                    value="<?php echo esc_attr($zoom_client_secret); ?>" required>
                                <div id="show-me" class="loader-field"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="zoomTermsAndCondition" required>
                            <label class="form-check-label" for="zoomTermsAndCondition"><span id="zoomTermsAndCondition"
                                    class="sr-style"><?php echo esc_html__('I agree to the', 'dwt-listing'); ?> <a
                                        href="<?php echo esc_url($dwt_listing_options['dwt_terms_condition_page']); ?>" target="_blank"><?php echo esc_html__('Terms and Conditions', 'dwt-listing'); ?></a></span></label>
                            <div id="zoomTermsAndConditionError" class="text-danger fw-bold" style="display: none;">
                                Please agree to the Terms and Conditions to continue.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <button type="submit" class="btn btn-admin sonu-button"
                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Saving...", 'dwt-listing'); ?>"><?php echo esc_html__("Save Settings", 'dwt-listing'); ?></button>
                        <button type="button" id="refresh_zoom_token" class="btn btn-warning refresh-token-button"
                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Refreshing Token...", 'dwt-listing'); ?>"><?php echo esc_html__("Refresh Token", 'dwt-listing'); ?></button>
                        <?php $keys_link = (isset($dwt_listing_options['dwt_zoom_keys_link']) && $dwt_listing_options['dwt_zoom_keys_link'] != "") ? $dwt_listing_options['dwt_zoom_keys_link'] : "#"; ?>
                        <p class="n_getzoom_link"
                            style="font-size: 14px;position: absolute;font-weight: 500;bottom: 20px;right: 45px;"><a
                                href="<?php echo '' . ($keys_link); ?>"
                                target="_blank"><?php echo esc_html__('How to find Zoom Keys?', 'nokri'); ?></a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>