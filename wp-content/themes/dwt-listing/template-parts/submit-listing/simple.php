<div class="col-md-10 col-xs-12 col-sm-12 col-md-offset-1">
    <form id="listing-form" data-disable="false" method="post">
        <div class="preloading" id="dwt_listing_loading"></div>
        <?php
        global $dwt_listing_options;
        $layout = $dwt_listing_options['dwt_listing_form-layout-manager']['enabled'];
        if ($layout):
            foreach ($layout as $key => $value) {
                switch ($key) {
                    case 'title_cat':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/title_cats.php';
                        break;
                    case 'price_type':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/price_type.php';
                        break;
                    case 'buiness_hours':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/hours.php';
                        break;
                    case 'social_links':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/social_links.php';
                        break;
                    case 'desc_sec':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/desc_sec.php';
                        break;
                    case 'coupon':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/coupon_sec.php';
                        break;
                    case 'location':
                        require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/location_sec.php';
                        break;
                }
            }
        endif;
        ?>
        <div class="submit-listing-section l_placeholder_form">
            <div class="row">
                <input type="hidden" id="is_update" name="is_update" value="<?php echo esc_attr($is_update); ?>">
                <input type="hidden" id="is_selective" name="is_selective"
                    value="<?php echo esc_attr($listing_is_opened); ?>">
                <?php
                //check user have featured ads
                if ($featured_listing == '-1' || $featured_listing > 0 && $listing_is_feature != '1') {
                    $feature_make_icon = '';
                    if (isset($dwt_listing_options['dwt_listing_make_feature_icon']) && $dwt_listing_options['dwt_listing_make_feature_icon'] != '') {
                        $feature_make_icon = "<span class='alert-icon custom-alert__icon " . $dwt_listing_options['dwt_listing_make_feature_icon'] . "'></span>";
                    }
                    echo "<div class='col-md-12 for_featured_list'><div class='alert custom-alert custom-alert--warning' role='alert'><div class='custom-alert__top-side'>" . $feature_make_icon . "<div class='custom-alert__body'><h6 class='custom-alert__heading'>" . esc_html__("Do you want to make this listing featured!", "dwt-listing") . "<input type='checkbox' name='make_listing_featured' id='make_listing_featured' value='1' class='custom-checkbox'></h6></div></div></div></div>";
                }
                // if current listing is already featured
                if ($listing_is_feature == '1') {
                    $feature_already_icon = '';
                    if (isset($dwt_listing_options['dwt_listing_already_feature_icon']) && $dwt_listing_options['dwt_listing_already_feature_icon'] != '') {
                        $feature_already_icon = "<span class='alert-icon custom-alert__icon " . $dwt_listing_options['dwt_listing_already_feature_icon'] . "'></span>";
                    }
                    echo "<div class='col-md-12 for_featured_list'><div class='alert custom-alert custom-alert--info' role='alert'><div class='custom-alert__top-side'>" . $feature_already_icon . "<div class='custom-alert__body'><h6 class='custom-alert__heading'>" . esc_html__("This listing is already featured.", "dwt-listing") . "</h6></div></div></div></div>";
                }
                ?>

                <?php
                if (isset($_GET['listing_id']) && $_GET['listing_id'] != "") {
                    //check user have bump listings
                    if ($listing_bump_amount == '-1' || $listing_bump_amount > 0) {
                        $dwt_listing_bump_up_icon = '';
                        if (isset($dwt_listing_options['dwt_listing_bump_up_icon']) && $dwt_listing_options['dwt_listing_bump_up_icon'] != '') {
                            $dwt_listing_bump_up_icon = "<span class='alert-icon custom-alert__icon " . $dwt_listing_options['dwt_listing_bump_up_icon'] . "'></span>";
                        }
                        echo "<div class='col-md-12 for_featured_list margin-10'><div class='alert custom-alert custom-alert--danger' role='alert'><div class='custom-alert__top-side'>" . $dwt_listing_bump_up_icon . "<div class='custom-alert__body'><h6 class='custom-alert__heading'>" . esc_html__("Do you want to bump this listing!", "dwt-listing") . "<input type='checkbox' name='make_listing_bump' id='make_listing_bump' value='1' class='custom-checkbox'></h6></div></div></div></div>";
                    }
                }
                ?>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="submit-post-button">
                        <?php
                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                            echo '<button type="button" class="btn btn-theme tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Save & preview', 'dwt-listing') . ' </button>';
                        } else {
                            ?>
                            <button type="submit" class="btn btn-theme sonu-button"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>">
                                <?php echo dwt_listing_text('dwt_listing_list_form_btn'); ?>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="dictDefaultMessage"
            value="<?php echo dwt_listing_text('dwt_listing_list_gallery_desc'); ?>" />
        <input type="hidden" id="dictFallbackMessage"
            value="<?php echo esc_html__('Your browser does not support drag\'n\'drop file uploads', 'dwt-listing'); ?> " />
        <input type="hidden" id="dictFallbackText"
            value="<?php echo esc_html__('Please use the fallback form below to upload your files like in the olden days', 'dwt-listing'); ?> " />
        <input type="hidden" id="dictFileTooBig"
            value="<?php echo esc_html__('File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictInvalidFileType"
            value="<?php echo esc_html__('You can\'t upload files of this type', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictResponseError"
            value="<?php echo esc_html__('Server responded with {{statusCode}} code', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictCancelUpload" value="<?php echo esc_html__('Cancel upload', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictCancelUploadConfirmation"
            value="<?php echo esc_html__('Are you sure you want to cancel this upload?', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictRemoveFile" value="<?php echo esc_html__('Remove file', 'dwt-listing'); ?>" />
        <input type="hidden" id="dictMaxFilesExceeded"
            value="<?php echo esc_html__('You can not upload any more files', 'dwt-listing'); ?>" />
        <input type="hidden" id="gallery_upload_limit" value="<?php echo esc_attr($number_of_images); ?>" />
        <input type="hidden" id="gallery_max_upload_limit" value="0" />

        <input type="hidden" id="gallery_img_size"
            value="<?php echo esc_attr($dwt_listing_options['dwt_listing_image_up_size']); ?>" />
        <input type="hidden" id="gallery_upload_reach"
            value="<?php echo __('Maximum upload limit reached', 'dwt-listing'); ?>" />
        <?php dwt_listing_form_lang_field_callback(true); ?>
    </form>
</div>