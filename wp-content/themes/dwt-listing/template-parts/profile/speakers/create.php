<?php
global $dwt_listing_options;
$speaker_education = $speaker_type = $speaker_image = $is_update = $speaker_name = $speaker_email = $speaker_profession = $speaker_contact = $speaker_website = $speaker_facebook = $speaker_twitter = $speaker_instagram = $speaker_whatsapp = $speaker_linkedin = $speaker_youtube = $speaker_id = '';
if (isset($_GET['edit_speaker']) && $_GET['edit_speaker'] != "") {

    $profile = new dwt_listing_profile();
    $user_id = $profile->user_info->ID;

    $speaker_id = isset($_GET["edit_speaker"]) ? $_GET["edit_speaker"] : '';
    $is_update = isset($speaker_id) ? $speaker_id : '';
    $speaker_data = $profile->get_speaker_by_id($speaker_id);
    $speaker_name = isset($speaker_data['name']) ? $speaker_data['name'] : '';
    $speaker_email = isset($speaker_data['email']) ? $speaker_data['email'] : '';
    $speaker_profession = isset($speaker_data['profession']) ? $speaker_data['profession'] : '';
    $speaker_contact = isset($speaker_data['contact']) ? $speaker_data['contact'] : '';
    $speaker_website = isset($speaker_data['website']) ? $speaker_data['website'] : '';
    $speaker_facebook = isset($speaker_data['facebook']) ? $speaker_data['facebook'] : '';
    $speaker_twitter = isset($speaker_data['twitter']) ? $speaker_data['twitter'] : '';
    $speaker_instagram = isset($speaker_data['instagram']) ? $speaker_data['instagram'] : '';
    $speaker_whatsapp = isset($speaker_data['whatsapp']) ? $speaker_data['whatsapp'] : '';
    $speaker_linkedin = isset($speaker_data['linkedin']) ? $speaker_data['linkedin'] : '';
    $speaker_youtube = isset($speaker_data['youtube']) ? $speaker_data['youtube'] : '';
    $speaker_image = isset($speaker_data['image']) ? $speaker_data['image'] : '';
    $speaker_type = isset($speaker_data['type']) ? $speaker_data['type'] : '';
    $speaker_education = isset($speaker_data['education']) ? $speaker_data['education'] : '';
}
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/speaker', 'stats'); ?>
    <div class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php
                    echo esc_html__('Create Speaker', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <form id="create-speaker">
                        <div class="preloading" id="dwt_listing_loading"></div>
                        <div class="submit-listing-section">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Speaker Name', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <?php
                                            // if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                            //     echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Speaker Name', 'dwt-listing') . '" value="' . esc_attr($speaker_name) . '">';
                                            // } else {
                                            //     ?>
                                            <input id="speaker_name" type="text" class="form-control"
                                                name="speaker_name"
                                                placeholder="<?php echo esc_html__('Speaker Name', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($speaker_name); ?>" required>
                                            <?php //} ?>
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Profession', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <input id="speaker_profession" type="text" class="form-control"
                                                name="speaker_profession"
                                                placeholder="<?php echo esc_attr('Profession', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($speaker_profession); ?>" required>
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Education', 'dwt-listing'); ?><span></span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <input id="speaker_education" type="text" class="form-control"
                                                name="speaker_education"
                                                placeholder="<?php echo esc_attr('Education', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($speaker_education); ?>">
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label"><?php echo esc_html__('Speaker Email', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-world"></i></span>
                                            <?php
                                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Speaker Email', 'dwt-listing') . '" value="' . esc_attr($speaker_email) . '">';
                                            } else {
                                                ?>
                                                <input type="email" required class="form-control" name="speaker_email"
                                                    placeholder="<?php echo esc_attr('abc@xyz.com', 'dwt-listing'); ?>"
                                                    value="<?php echo esc_attr($speaker_email); ?>">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (isset($dwt_listing_options['dwt_add_speaker_type_switch']) && $dwt_listing_options['dwt_add_speaker_type_switch'] == 1) { ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group has-feedback">
                                            <label
                                                class="control-label"><?php echo esc_html__('Speaker Type', 'dwt-listing'); ?><span>*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="ti-user"></i></span>
                                                <select class="form-control" name="speaker_type" required>
                                                    <option value="speaker" <?php echo ($speaker_type == 'speaker') ? 'selected' : ''; ?>>
                                                        <?php echo esc_html__('Speaker', 'dwt-listing'); ?>
                                                    </option>
                                                    <option value="organizer" <?php echo ($speaker_type == 'organizer') ? 'selected' : ''; ?>>
                                                        <?php echo esc_html__('Organizer', 'dwt-listing'); ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (isset($dwt_listing_options['dwt_add_speaker_skills_switch']) && $dwt_listing_options['dwt_add_speaker_skills_switch'] == 1) {
                                      $speaker_skills = get_post_meta($speaker_id, 'dwt_listing_event_speaker_skills', true);
                                      if (is_array($speaker_skills)) {
                                        $comma_separated_skills = implode(', ', $speaker_skills);
                                    } else {
                                        $comma_separated_skills = '';
                                    }
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 l_tags_form">
                                        <div class="form-group">
                                            <label
                                                class="control-label"><?php echo esc_html__("Add Skills", 'dwt-listing'); ?></label>
                                            <textarea class="form-control"
                                            placeholder="<?php echo esc_attr('Contact Number', 'dwt-listing'); ?>"
                                                name="speaker_skills"
                                                id="listing_tags"><?php print_r($comma_separated_skills); ?></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Contact Number', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <?php
                                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Contact Number', 'dwt-listing') . '" value="' . esc_attr($speaker_contact) . '">';
                                            } else {
                                                ?>
                                                <input id="speaker_contact_no" type="number" class="form-control"
                                                    name="speaker_contact_no"
                                                    placeholder="<?php echo esc_attr('Contact Number', 'dwt-listing'); ?>"
                                                    value="<?php echo esc_attr($speaker_contact); ?>" required>
                                            <?php } ?>
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Website URL', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <?php
                                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Website URL', 'dwt-listing') . '" value="' . esc_attr($speaker_website) . '">';
                                            } else {
                                                ?>
                                                <input id="speaker_website" type="url" class="form-control"
                                                    name="speaker_website"
                                                    placeholder="<?php echo esc_attr('Website URL', 'dwt-listing'); ?>"
                                                    value="<?php echo esc_attr($speaker_website); ?>" required>
                                            <?php } ?>
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12 ">
                                    <div class="form-group">
                                        <label
                                            class="control-label"><?php echo esc_html__('Speaker Images', 'dwt-listing'); ?></label>
                                        <div id="speaker_dropzone" class="dropzone upload-ad-images event_zone">
                                            <div class="dz-message needsclick">
                                                <?php echo esc_html__('Speaker Images', 'dwt-listing'); ?>
                                                <br />
                                                <span
                                                    class="note needsclick"><?php echo esc_html__('Drop files here or click to upload', 'dwt-listing'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="listing_msgz" class="alert custom-alert custom-alert--warning none"
                                        role="alert">
                                        <div class="custom-alert__top-side">
                                            <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                            <div class="custom-alert__body">
                                                <h6 class="custom-alert__heading">
                                                    <?php echo esc_html__('Whoops.....!', 'dwt-listing'); ?>
                                                </h6>
                                                <div class="custom-alert__content"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <h4><?php echo dwt_listing_text('dwt_listing_list_socail_media'); ?></h4>
                                    <div class="social-media-fields">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="ti-facebook"></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Facebook URL', 'dwt-listing') . '" value="' . esc_attr($speaker_facebook) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="url" class="form-control" name="speaker_fb"
                                                                placeholder="<?php echo esc_attr__('Facebook URL', 'dwt-listing'); ?>"
                                                                value="<?php echo esc_attr($speaker_facebook); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="ti-twitter"></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Twitter URL', 'dwt-listing') . '" value="' . esc_attr($speaker_twitter) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="url" class="form-control" name="speaker_tw"
                                                                placeholder="<?php echo esc_html__('Twitter URL', 'dwt-listing'); ?>"
                                                                value="<?php echo esc_attr($speaker_twitter); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-whatsapp"></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('WhatsApp Number', 'dwt-listing') . '" value="' . esc_attr($speaker_whatsapp) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="text" class="form-control" name="speaker_whatsapp"
                                                                placeholder="WhatsApp Number"
                                                                value="<?php echo esc_attr($speaker_whatsapp); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="ti-linkedin"></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('LinkedIn URL', 'dwt-listing') . '" value="' . esc_attr($speaker_linkedin) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="url" class="form-control" name="speaker_in"
                                                                placeholder="<?php echo esc_html__('LinkedIn URL', 'dwt-listing'); ?>"
                                                                value="<?php echo esc_attr($speaker_linkedin); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="ti-youtube "></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Youtube URL', 'dwt-listing') . '" value="' . esc_attr($speaker_youtube) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="url" class="form-control" name="speaker_youtube"
                                                                placeholder="<?php echo esc_html__('Youtube URL', 'dwt-listing'); ?>"
                                                                value="<?php echo esc_attr($speaker_youtube); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="ti-instagram"></i></span>
                                                        <?php
                                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                            echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Instagram URL', 'dwt-listing') . '" value="' . esc_attr($speaker_instagram) . '">';
                                                        } else {
                                                            ?>
                                                            <input type="url" class="form-control" name="speaker_insta"
                                                                placeholder="<?php echo esc_html__('Instagram URL', 'dwt-listing'); ?>"
                                                                value="<?php echo esc_attr($speaker_instagram); ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="event-quereis-forms">
                                                <div class="query-input">
                                                    <?php
                                                    if (isset($dwt_listing_options['dwt_add_speaker_faqs_switch']) && $dwt_listing_options['dwt_add_speaker_faqs_switch'] == 1) {
                                                        ?>
                                                        <div class="faq_forms">
                                                            <h3><?php echo esc_html__('Frequently Asked Questions', 'dwt-listing'); ?>
                                                            </h3>
                                                            <div id="speaker_questionaire">
                                                                <?php
                                                                $questions = get_post_meta($speaker_id, 'dwt_listing_event_speaker_questions', true);
                                                                ?>
                                                                <?php
                                                                if (is_array($questions) && !empty($questions)) {
                                                                    foreach ($questions as $ques) { ?>
                                                                        <input type="text" id="question"
                                                                            name='event_question[question][]' value='<?php if (isset($ques['question']) != '')
                                                                                echo $ques['question']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Your Question Here', 'dwt-listing'); ?>">
                                                                        <input type="text" id="answer"
                                                                            name='event_question[answer][]' value='<?php if (isset($ques['answer']) != "")
                                                                                echo $ques['answer']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Your Answer Here', 'dwt-listing'); ?>">
                                                                        <button class="btn remove_added_question" id="addNameButton"
                                                                            type="button"><?php echo esc_html__('Add Question', 'dwt-listing'); ?></button>
                                                                        <?php
                                                                    } ?>
                                                                    <div class="add_new_questions">
                                                                        <button class="btn" id="addNameButton"
                                                                            type="button"><?php echo esc_html__('Add Question', 'dwt-listing'); ?></button>
                                                                    </div>
                                                                    <?php
                                                                } else { ?>
                                                                    <input type="text" id="question"
                                                                        name='event_question[question][]' value='<?php if (isset($ques['question']) != '')
                                                                            echo $ques['question']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Your Question Here', 'dwt-listing'); ?>">
                                                                    <input type="text" id="answer"
                                                                        name='event_question[answer][]' value='<?php if (isset($ques['answer']) != "")
                                                                            echo $ques['answer']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Your Answer Here', 'dwt-listing'); ?>">
                                                                    <button class="btn" id="addNameButton"
                                                                        type="button"><?php echo esc_html__('Add Question', 'dwt-listing'); ?></button>

                                                                <?php }
                                                                ?>
                                                            </div>
                                                            <div class="query-input-lists">
                                                                <ul id="listOfQuestions"></ul>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="is_update" name="is_update"
                                    value="<?php echo esc_attr($is_update); ?>">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-admin sonu-button"
                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Save Speaker", 'dwt-listing'); ?></button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="speaker_upload_limit"
                            value="<?php echo esc_attr($dwt_listing_options['dwt_listing_event_upload_limit']); ?>" />
                        <input type="hidden" id="speaker_img_size"
                            value="<?php echo esc_attr($dwt_listing_options['dwt_listing_event_images_size']); ?>" />
                        <input type="hidden" id="max_upload_reach"
                            value="<?php echo __('Maximum upload limit reached', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictDefaultMessage"
                            value="<?php echo dwt_listing_text('dwt_listing_list_gallery_desc'); ?>" />
                        <input type="hidden" id="dictFallbackMessage"
                            value="<?php echo esc_attr('Your browser does not support drag\'n\'drop file uploads', 'dwt-listing'); ?> " />
                        <input type="hidden" id="dictFallbackText"
                            value="<?php echo esc_attr('Please use the fallback form below to upload your files like in the olden days', 'dwt-listing'); ?> " />
                        <input type="hidden" id="dictFileTooBig"
                            value="<?php echo esc_attr('File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictInvalidFileType"
                            value="<?php echo esc_attr('You can\'t upload files of this type', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictResponseError"
                            value="<?php echo esc_attr('Server responded with {{statusCode}} code', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictCancelUpload"
                            value="<?php echo esc_attr('Cancel upload', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictCancelUploadConfirmation"
                            value="<?php echo esc_attr('Are you sure you want to cancel this upload?', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictRemoveFile"
                            value="<?php echo esc_attr('Remove file', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictMaxFilesExceeded"
                            value="<?php echo esc_attr('You can not upload any more files', 'dwt-listing'); ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>