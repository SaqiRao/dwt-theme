<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else if (is_singular('listing')) {
    $listing_id = get_the_ID();
}
if (is_user_logged_in()) {
    if (isset($comment_id) && $comment_id != "") {
        $my_comment_id = $comment_id;
        $rated = $rated;
        $main_title = $main_title;
        $main_desc = $main_desc;
        $images_idz = $images_idz;
        $listing_id = $listing_id;
    } else {
        $rated = '1';
        $main_title = $my_comment_id = $main_desc = $images_idz = '';
    }
    ?>
    <div class="review-form">
        <h3><?php echo esc_html__('Write A Review', 'dwt-listing'); ?></h3>
        <div class="row">
            <form class="review-form-listing" method="get" enctype="multipart/form-data" data-disable="false">
                <?php
                if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                    ?>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <div dir="ltr">
                                <input id="input-21b" name="review_stars" value="<?php echo esc_attr($rated); ?>" type="text"  data-show-clear="false" class="rating" data-min="0" data-max="5" <?php if (is_rtl()) { ?> dir="rtl"<?php } ?> data-step="1" data-size="xs" required>
                            </div>     
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
                ?>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label><?php echo esc_html__('Review Title:', 'dwt-listing'); ?> <span class="required">*</span></label>
                        <input value="<?php echo esc_attr($main_title); ?>" placeholder="<?php echo esc_html__('Place attractive title here', 'dwt-listing'); ?>" name="review_title" class="form-control" type="text" required>
                        <div class="help-block"></div>
                    </div>
                </div>

                <?php
                if (dwt_listing_text('dwt_listing_review_enable_gallery') == '1') {
                    ?>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><?php echo esc_html__('Review Gallery:', 'dwt-listing'); ?> </label>
                            <div class="dropzone upload-ad-images reviews_dropzone<?php echo esc_attr($my_comment_id); ?>">
                                <div class="dz-message needsclick">
                                    <?php echo esc_html__('Review Gallery Images', 'dwt-listing'); ?>
                                    <br />
                                    <span class="note needsclick"><?php echo esc_html__('Drop files here or click to upload', 'dwt-listing'); ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $review_poster = get_current_user_id();
                ?>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label><?php echo esc_html__('Review Message:', 'dwt-listing'); ?> <span class="required">*</span></label>
                        <textarea cols="6" name="review_comments" rows="6" placeholder="<?php echo esc_html__('Your comments, suggestions or experience at this place.', 'dwt-listing'); ?>" class="form-control" required><?php echo esc_attr($main_desc); ?></textarea>
                        <div class="help-block"></div>
                    </div>
                </div>
                <input type="hidden" name="comment_is_dashboard" value="<?php echo esc_attr($my_comment_id); ?>" >
                <input type="hidden" name="review_listing_id" value="<?php echo esc_attr($listing_id); ?>" >
                <input type="hidden" id="review_upload_limit" value="<?php echo esc_attr($dwt_listing_options['dwt_listing_review_upload_limit']); ?>" />
                <input type="hidden" id="review_mx_limit" value="<?php echo esc_attr($dwt_listing_options['dwt_listing_review_images_size']); ?>" />
                <input type="hidden" id="review_max_upload_reach" value="<?php echo __('Maximum upload limit reached', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictDefaultMessages" value="<?php echo dwt_listing_text('dwt_listing_list_gallery_desc'); ?>" />
                <input type="hidden" id="dictFallbackMessages" value="<?php echo esc_html__('Your browser does not support drag\'n\'drop file uploads', 'dwt-listing'); ?> "/>
                <input type="hidden" id="dictFallbackTexts" value="<?php echo esc_html__('Please use the fallback form below to upload your files like in the olden days', 'dwt-listing'); ?> "/>
                <input type="hidden" id="dictFileTooBigs" value="<?php echo esc_html__('File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictInvalidFileTypes" value="<?php echo esc_html__('You can\'t upload files of this type', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictResponseErrors" value="<?php echo esc_html__('Server responded with {{statusCode}} code', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictCancelUploads" value="<?php echo esc_html__('Cancel upload', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictCancelUploadConfirmations" value="<?php echo esc_html__('Are you sure you want to cancel this upload?', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictRemoveFiles" value="<?php echo esc_html__('Remove file', 'dwt-listing'); ?>" />
                <input type="hidden" id="dictMaxFilesExceededs" value="<?php echo esc_html__('You can not upload any more files', 'dwt-listing'); ?>" />

                <div class="col-md-12 col-sm-12">
                    <?php
                    if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                        echo '<button type="button" class="btn btn-theme tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Submit Review', 'dwt-listing') . ' </button>';
                    } else {
                        ?>
                        <button type="submit" class="btn btn-theme sonu-button-review" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Submit Review", 'dwt-listing'); ?></button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <?php
} else {
    ?>

    <div class="alert custom-alert custom-alert--warning" role="alert">
        <div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
            <div class="custom-alert__body">
                <h6 class="custom-alert__heading">
                    <?php echo esc_html__('Login To Write A Review.', 'dwt-listing'); ?>
                </h6>
                <div class="custom-alert__content">
                    <?php echo esc_html__("Sorry, you don't have permisson to post a review.", 'dwt-listing'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>