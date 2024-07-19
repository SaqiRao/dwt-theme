<?php
global $dwt_listing_options;

$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$my_events = '';
if (dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "" && dwt_listing_text('dwt_listing_enable_map') == "1") {
    dwt_listing_google_locations(true);
    wp_enqueue_script("google-map-callback");
}
$location_icon = $check_class = '';
if (dwt_listing_text('dwt_listing_enable_geo') == '1' && dwt_listing_text('dwt_map_selection') == 'open_street') {
    $check_class = 'get-loc';
    $location_icon = '<i class="detect-me fa fa-crosshairs"></i>';
}
$event_cat = $event_id = '';
$cat_name = $link = $to = $from = $cat_name = $link = $term_list = $event_start = '';
$event_venue_loc = $event_end = '';
$listing_lattitude = dwt_listing_text('dwt_listing_default_lat');
$listing_longitide = dwt_listing_text('dwt_listing_default_long');
$share_webinar_link = $webinar_link = $event_type = $event_end_date = $event_start_date = $event_cat = $selected = $event_speakers = $parent_listing = $event_venue = $event_email = $event_contact = $event_tagline = $event_desc = $event_title = $is_update = '';
if (isset($_GET['edit_event']) && $_GET['edit_event'] != "") {
    $event_id = $_GET['edit_event'];
    $is_update = $event_id;
    $post = get_post($event_id);
    $event_title = $post->post_title;
    $event_desc = $post->post_content;
    $event_contact = get_post_meta($event_id, 'dwt_listing_event_contact', true);
    $event_email = get_post_meta($event_id, 'dwt_listing_event_email', true);
    $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
    $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
    $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
    $listing_lattitude = get_post_meta($event_id, 'dwt_listing_event_lat', true);
    $listing_longitide = get_post_meta($event_id, 'dwt_listing_event_long', true);
    $parent_listing = get_post_meta($event_id, 'dwt_listing_event_listing_id', true);
    $event_question = get_post_meta($event_id, 'dwt_listing_event_question', true);
    $event_answer = get_post_meta($event_id, 'dwt_listing_event_answer', true);
    $event_days = get_post_meta($event_id, 'dwt_listing_event_days', true);
    $event_textareas = get_post_meta($event_id, 'dwt_listing_event_textareas', true);
    $event_speakers = get_post_meta($event_id, 'dwt_listing_event_speakers', true);
    $event_type = get_post_meta($event_id, 'dwt_listing_event_type', true);
    $webinar_link = get_post_meta($event_id, 'dwt_listing_webinar_link', true);
    $share_webinar_link = get_post_meta($event_id, 'dwt_listing_share_webinar_link', true);

    //event term
    $term_list = wp_get_post_terms($event_id, 'l_event_cat', array("fields" => "ids"));
    if (!empty($term_list)) {
        $event_cat = $term_list[0];
    }

}
$get_argsz = $profile->dwt_listing_fetch_owner_events_admin();
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/event', 'stats'); ?>
    <div class="row">
        <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Create Event/Webinar', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <form id="my-events">
                        <div class="preloading" id="dwt_listing_loading"></div>
                        <div class="submit-event-section">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Title', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                            <?php
                                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                echo '<input disabled type="text" class="form-control" placeholder="' . esc_html__('Title', 'dwt-listing') . '" value="' . esc_attr($event_title) . '">';
                                            } else {
                                                ?>
                                                <input id="event_title" type="text" class="form-control" name="event_title"
                                                    placeholder="<?php echo esc_html__('Title', 'dwt-listing'); ?>"
                                                    value="<?php echo esc_attr($event_title); ?>" required>
                                            <?php } ?>
                                            <div id="show-me" class="loader-field"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /* Event Type */ -->
                                <?php if (isset($dwt_listing_options['dwt_event_type_switch']) && $dwt_listing_options['dwt_event_type_switch'] == 1) { ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group has-feedback">
                                            <label
                                                class="control-label"><?php echo esc_html__('Select Type', 'dwt-listing'); ?>
                                                <span>*</span></label>
                                            <select
                                                data-placeholder="<?php echo esc_html__('Select Type', 'dwt-listing'); ?>"
                                                name="event_type" id="event_type" class="custom-select" required>
                                                <option value="">
                                                    <?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <option value="event" <?php echo ($event_type == 'event') ? ' selected' : ''; ?>><?php echo esc_html__('Event', 'dwt-listing'); ?></option>
                                                <option value="webinar" <?php echo ($event_type == 'webinar') ? ' selected' : ''; ?>><?php echo esc_html__('Webinar', 'dwt-listing'); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Webinar link checkbox -->
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group" id="webinar_link_radio_wrapper" style="display: none;">
                                            <label><?php echo esc_html__('Do you want to share the webinar link?', 'dwt-listing'); ?></label><br>
                                            <label class="radio-inline">
                                                <input type="radio" name="share_webinar_link" value="yes" <?php echo ($share_webinar_link === 'yes') ? 'checked' : ''; ?>> <?php echo esc_html__('Yes', 'dwt-listing'); ?>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="share_webinar_link" value="no" <?php echo ($share_webinar_link === 'no') ? 'checked' : ''; ?>> <?php echo esc_html__('No', 'dwt-listing'); ?>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Webinar link input -->
                                    <div class="col-md-12 col-xs-12 col-sm-12" id="webinar_link_input_wrapper"
                                        style="display: none;">
                                        <div class="form-group">
                                            <label
                                                class="control-label"><?php echo esc_html__('Webinar Link', 'dwt-listing'); ?><span>*</span></label>
                                            <input type="text" class="form-control" id="webinar_link_input"
                                                name="webinar_link"
                                                value="<?php echo isset($webinar_link) ? $webinar_link : ""; ?>"
                                                placeholder="<?php echo esc_html__('Enter Webinar Link', 'dwt-listing'); ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- /* Event Type */ -->
                                <?php
                                /* Event categories */
                                $event_cats = dwt_listing_categories_fetch('l_event_cat', 0);
                                if (!empty($event_cats) && is_array($event_cats) && count($event_cats) > 0) {
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group has-feedback">
                                            <label
                                                class="control-label"><?php echo esc_html__('Select Category', 'dwt-listing'); ?>
                                                <span>*</span></label>
                                            <select
                                                data-placeholder="<?php echo esc_html__('Select Category', 'dwt-listing'); ?>"
                                                name="event_cat" class="custom-select" required>
                                                <option value="">
                                                    <?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <?php
                                                foreach ($event_cats as $eventz) {
                                                    ?>
                                                    <option value="<?php echo esc_html($eventz->term_id) ?>" <?php if ($eventz->term_id == $event_cat) { ?>selected="selected" <?php } ?>>
                                                        <?php echo esc_attr($eventz->name) ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label"><?php echo esc_html__('Phone Number', 'dwt-listing'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-mobile"></i></span>
                                            <input type="text" class="form-control" name="event_number"
                                                placeholder="<?php echo esc_html__('+99 3331 234567', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($event_contact); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label"><?php echo esc_html__('Contact Email', 'dwt-listing'); ?><span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-world"></i></span>
                                            <input type="email" required class="form-control" name="event_email"
                                                placeholder="<?php echo esc_html__('abc@xyz.com', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($event_email); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label
                                            class="control-label"><?php echo esc_html__('Description', 'dwt-listing'); ?><span>*</span></label>
                                        <textarea name="event_desc" class="jqte-test"
                                            required><?php echo '' . $event_desc; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php echo esc_html__('Start Date', 'dwt-listing'); ?>
                                            <span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-time"></i></span>
                                            <input class="form-control" name="event_start_date" type="text"
                                                id="event_start" data-time-format='hh:ii aa' autocomplete="off"
                                                value="<?php echo esc_attr($event_start_date); ?>" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php echo esc_html__('End Date', 'dwt-listing'); ?> <span>*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-time"></i></span>
                                            <input class="form-control" name="event_end_date" type="text" id="event_end"
                                                data-time-format='hh:ii aa' autocomplete="off"
                                                value="<?php echo esc_attr($event_end_date); ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12 ">

                                    <div class="form-group">
                                        <label
                                            class="control-label"><?php echo esc_html__('Gallery', 'dwt-listing'); ?></label>
                                        <div id="event_dropzone" class="dropzone upload-ad-images event_zone">
                                            <div class="dz-message needsclick">
                                                <?php echo esc_html__('Gallery Images', 'dwt-listing'); ?>
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
                                <?php //Fetch Event Speakers
                                if (isset($dwt_listing_options['dwt_event_speakers']) && $dwt_listing_options['dwt_event_speakers'] == 1) {

                                    $args = array(
                                        'post_type' => 'speakers',
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                    );
                                    $loop = new WP_Query($args);
                                    if ($loop->have_posts()) {
                                        ?>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="form-group has-feedback">
                                                <label
                                                    class="control-label"><?php echo esc_html__('Assign Speaker/Organizer', 'dwt-listing'); ?>
                                                    <small><?php echo esc_html__('(optional)', 'dwt-listing') ?></small></label>
                                                <div class="select_speakers">
                                                    <select class="js-example-basic-multiple" name="events_speakers[]"
                                                        multiple="multiple">
                                                        <?php
                                                        while ($loop->have_posts()) {
                                                            $loop->the_post();
                                                            $speaker_ID = get_the_ID();
                                                            $selected = "";
                                                            ?>
                                                            <?php
                                                            if ($event_id != "") {
                                                                $event_speakers = get_post_meta($event_id, 'dwt_listing_event_speakers', true);
                                                                $event_speakers = is_array($event_speakers) ? $event_speakers : array();
                                                                if (!empty($event_speakers) && in_array($speaker_ID, $event_speakers)) {
                                                                    $selected = "selected";
                                                                }
                                                            }
                                                            ?>
                                                            <option value="<?php echo $speaker_ID ?>" <?php echo $selected; ?>>
                                                                <?php echo esc_attr(get_the_title($speaker_ID)); ?></option>
                                                            <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <?php wp_reset_postdata(); ?>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>

                                <div class="col-md-12 col-xs-12 col-sm-12 location_input_container">
                                    <div class="form-group <?php echo esc_attr($check_class); ?>">
                                        <label
                                            class="control-label"><?php echo esc_html__('Location', 'dwt-listing'); ?><span
                                                id="location_asterisk">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="ti-location-pin"></i></span>
                                            <input type="text" class="form-control" id="address_location"
                                                name="event_venue"
                                                placeholder="<?php echo dwt_listing_text('dwt_listing_list_google_loc_place', 'dwt-listing'); ?>"
                                                value="<?php echo esc_attr($event_venue); ?>" required>
                                            <?php echo $location_icon; ?>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>
                                </div>




                                <?php
                                if (dwt_listing_text('dwt_listing_enable_map') == "1") {
                                    $map_id = 'submit-map-open';
                                    if (dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "") {
                                        $map_id = 'submit-listing-map';
                                    }
                                    if (isset($dwt_listing_options['dwt_listing_enable_long_lat']) && $dwt_listing_options['dwt_listing_enable_long_lat'] == 1) {

                                        ?>
                                        <div class="col-md-6 col-xs-12 col-sm-6 latitude_input_container">
                                            <div class="form-group">
                                                <label
                                                    class="control-label"><?php echo esc_html__('Latitude', 'dwt-listing'); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-map-alt"></i></span>
                                                    <input type="text" class="form-control" id="d_latt" name="event_lat"
                                                        placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>"
                                                        value="<?php echo esc_attr($listing_lattitude); ?>">
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 longitude_input_container">
                                            <div class="form-group">
                                                <label
                                                    class="control-label"><?php echo esc_html__('Longitude', 'dwt-listing'); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-map-alt"></i></span>
                                                    <input type="text" class="form-control" id="d_long" name="event_long"
                                                        placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>"
                                                        value="<?php echo esc_attr($listing_longitide); ?>">
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-6 col-xs-12 col-sm-6 latitude_input_container">
                                            <div class="form-group no_long_lat">
                                                <label
                                                    class="control-label"><?php echo esc_html__('Latitude', 'dwt-listing'); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-map-alt"></i></span>
                                                    <input type="text" class="form-control" id="d_latt" name="event_lat"
                                                        placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>"
                                                        value="<?php echo esc_attr($listing_lattitude); ?>">
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-6 longitude_input_container">
                                            <div class="form-group no_long_lat">
                                                <label
                                                    class="control-label"><?php echo esc_html__('Longitude', 'dwt-listing'); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="ti-map-alt"></i></span>
                                                    <input type="text" class="form-control" id="d_long" name="event_long"
                                                        placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>"
                                                        value="<?php echo esc_attr($listing_longitide); ?>">
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <?php

                                    }
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 map_view_container">
                                        <div class="form-group">
                                            <div class="submit-post-img-container">
                                                <div id="<?php echo esc_attr($map_id); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- adding questions and answers section -->
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="event-quereis-forms">
                                                <div class="query-input">
                                                    <?php
                                                    if (isset($dwt_listing_options['event_question']) && $dwt_listing_options['event_question'] == 1) {
                                                        ?>
                                                        <div class="faq_forms">
                                                            <div class="faq_title_event" id="toggleQuestions">
                                                                <h3 class="faq_title_event">
                                                                    <?php echo esc_html__('Add Some Questions', 'dwt-listing'); ?>
                                                                </h3>
                                                                <i class="event_faq_chevron ti-angle-down"></i>
                                                            </div>
                                                            <div id="event_questionaire">
                                                                <?php
                                                                $questions = get_post_meta($event_id, 'event_question', true);
                                                                if (is_array($questions) && !empty($questions)) {
                                                                    foreach ($questions as $ques) { ?>
                                                                        <input type="text" id="question"
                                                                            name='event_question[question][]'
                                                                            value='<?php if (isset($ques['question']) != '')
                                                                                echo $ques['question']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Your Question Here', 'dwt-listing'); ?>">
                                                                        <input type="text" id="answer"
                                                                            name='event_question[answer][]'
                                                                            value='<?php if (isset($ques['answer']) != "")
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
                                                                        name='event_question[question][]'
                                                                        value='<?php if (isset($ques['question']) != '')
                                                                            echo $ques['question']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Your Question Here', 'dwt-listing'); ?>">
                                                                    <input type="text" id="answer"
                                                                        name='event_question[answer][]'
                                                                        value='<?php if (isset($ques['answer']) != "")
                                                                            echo $ques['answer']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Your Answer Here', 'dwt-listing'); ?>">
                                                                    <button class="btn" id="addNameButton"
                                                                        type="button"><?php echo esc_html__('Add New Question', 'dwt-listing'); ?></button>

                                                                <?php }
                                                                ?>
                                                            </div>
                                                            <div class="query-input-lists">
                                                                <ul id="listOfQuestions"></ul>
                                                            </div>
                                                        </div>
                                                    <?php } ?>


                                                    <?php
                                                    if (isset($dwt_listing_options['days_schedule']) && $dwt_listing_options['days_schedule'] == 1) {
                                                        ?>
                                                        <!--fields for textareas-->
                                                        <!-- <div class="add_textarea">
                                                                <div class="">
                                                                    <div class="days_title_event" id="toggleDays">
                                                                        <h3 class="days_title_event"><?php echo esc_html__('Add Schedule', 'dwt-listing'); ?></h3>
                                                                        <i class="event_days_chevron ti-angle-down"></i>
                                                                    </div>
                                                                        <div class="adding_new_days_schedule">
                                                                            <?php
                                                                            $days_schedules = get_post_meta($event_id, 'days_schedule', true);
                                                                            if (is_array($days_schedules) && !empty($days_schedules)) {
                                                                                foreach ($days_schedules as $days) { ?>
                                                                                
                                                                                <input type="text" id="newDays" name='days_schedule[newDays][]' value='<?php if (isset($days['newDays']) != "")
                                                                                    echo $days['newDays']; ?>'  placeholder="<?php echo esc_attr__('Day Name Here......', 'dwt-listing'); ?>">
                                                                                <textarea  type="text" class="jqte-primary" id="schedule_description" name='days_schedule[schedule_description][]' placeholder="<?php echo esc_attr__('Add Some Text Here ', 'dwt-listing'); ?>"><?php if (isset($days['schedule_description']) != "")
                                                                                        echo $days['schedule_description']; ?></textarea>
                                                                                <button class="btn remove_schedule_button" type="button"><?php echo esc_html__('Remove Schedule', 'dwt-listing'); ?></button>
                                                                                <button class="btn" id="addDaysButton" class="addDaysScheduleButton" type="button"><?php echo esc_html__('Add Schedule', 'dwt-listing'); ?></button>                                        
                                                                                <?php
                                                                                }
                                                                            } else { ?>
                                                                            <input type="text" id="newDays" name='days_schedule[newDays][]' value='<?php if (isset($days['newDays']) != "")
                                                                                echo $days['newDays']; ?>'  placeholder="<?php echo esc_attr__('Day Name Here......', 'dwt-listing'); ?>">
                                                                            <textarea  type="text" class="jqte-primary" id="schedule_description" name='days_schedule[schedule_description][]' placeholder="<?php echo esc_attr__('Add Some Text Here ', 'dwt-listing'); ?>"><?php if (isset($days['schedule_description']) != "")
                                                                                    echo $days['schedule_description']; ?></textarea>
                                                                            <button class="btn" id="addDaysButton" class="addDaysScheduleButton" type="button"><?php echo esc_html__('Add Schedule', 'dwt-listing'); ?></button>

                                                                            <?php
                                                                            } ?>
                                                                        </div>
                                                                </div>
                                                                <div class="events_days_schedule">
                                                                    <ul id="listOfDaysName"></ul>
                                                                </div>
                                                            </div> -->

                                                        <div class="add_textarea">
                                                            <div class="">
                                                                <div class="days_title_event" id="toggleDays">
                                                                    <h3 class="days_title_event">
                                                                        <?php echo esc_html__('Add Schedule', 'dwt-listing'); ?>
                                                                    </h3>
                                                                    <i class="event_days_chevron ti-angle-down"></i>
                                                                </div>
                                                                <div class="adding_new_days_schedule"
                                                                    id="addingNewDaysSchedule">
                                                                    <?php
                                                                    $days_schedules = get_post_meta($event_id, 'days_schedule', true);
                                                                    if (is_array($days_schedules) && !empty($days_schedules)) {
                                                                        foreach ($days_schedules as $days) { ?>
                                                                            <div class="schedule_entry">
                                                                                <input type="text" class="day_name_input"
                                                                                    name='days_schedule[newDays][]'
                                                                                    value='<?php echo isset($days['newDays']) ? $days['newDays'] : ''; ?>'
                                                                                    placeholder="<?php echo esc_attr__('Day Name Here......', 'dwt-listing'); ?>">
                                                                                <textarea rows="4"
                                                                                    class="jqte-primary schedule_description_input"
                                                                                    name='days_schedule[schedule_description][]'
                                                                                    placeholder="<?php echo esc_attr__('Add Some Text Here ', 'dwt-listing'); ?>"><?php echo isset($days['schedule_description']) ? $days['schedule_description'] : ''; ?></textarea>
                                                                                <button
                                                                                    class="btn btn-danger mb-2 remove_schedule_button"
                                                                                    type="button"><?php echo esc_html__('Remove Schedule', 'dwt-listing'); ?></button>
                                                                            </div>
                                                                        <?php }
                                                                    } ?>
                                                                </div>
                                                                <button class="btn add_schedule_button"
                                                                    type="button"><?php echo esc_html__('Add Schedule', 'dwt-listing'); ?></button>
                                                            </div>
                                                            <div class="events_days_schedule">
                                                                <ul id="listOfDaysName"></ul>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---questions and answers section ends here--->


                                <!--events payments section start here-->

                                <?php
                                if (isset($dwt_listing_options['event_ticket_system']) && $dwt_listing_options['event_ticket_system'] == 1) {
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="events_payments_booking_services">
                                            <!--bookings section starts here -->
                                            <div class="event_payments_section event_booking_section">
                                                <div class="event_payments_section_title event_booking_section_title">
                                                    <h3><?php echo esc_html__('Price and Number of Tickets', 'dwt-listing'); ?>
                                                    </h3>
                                                    <div class="switch_for_tickets_extra_services">
                                                        <label class="switch">
                                                            <?php $show_event_tickets_ = get_post_meta($event_id, 'event_tickets_show', true); ?>
                                                            <input type="checkbox" name="show_tickets_extra_services"
                                                                class="switch_for_tickets_main_checkbox" <?php if (isset($show_event_tickets_) && $show_event_tickets_ == 'yes') {
                                                                    echo 'checked';
                                                                } ?>>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="event_tickets_extra_services_wrapper">
                                                    <div class="pricing_booking_inputs booking_fields" id="booking_fields">
                                                        <div id="event_prices" class="event_prices form_input_control">
                                                            <?php
                                                            $events_tickets_booking = get_post_meta($event_id, 'event_tickets_boking', true);
                                                            if (is_array($events_tickets_booking) && !empty($events_tickets_booking)) {
                                                                foreach ($events_tickets_booking as $ques) { ?>
                                                                    <input class="form-control" type="text" id="tickets_description"
                                                                        name='event_tickets_boking[tickets_description][]'
                                                                        value='<?php if (isset($ques['tickets_description']) != '')
                                                                            ;
                                                                        echo $ques['tickets_description']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Description (Optional)', 'dwt-listing'); ?>">
                                                                    <input class="form-control" type="number" id="no_of_tickets"
                                                                        name='event_tickets_boking[no_of_tickets][]'
                                                                        value='<?php if (isset($ques['no_of_tickets']) != "")
                                                                            ;
                                                                        echo $ques['no_of_tickets']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Number of Tickets', 'dwt-listing'); ?>"
                                                                        min='1' required>
                                                                    <input class="form-control" type="number" id="ticket_price"
                                                                        name='event_tickets_boking[ticket_price][]'
                                                                        value='<?php if (isset($ques['ticket_price']) != '')
                                                                            ;
                                                                        echo $ques['ticket_price']; ?>'
                                                                        placeholder="<?php echo esc_attr__('Price of Tickets', 'dwt-listing'); ?> "
                                                                        min='1' required>

                                                                <?php
                                                                }
                                                            } else { ?>

                                                                <input class="form-control" type="text" id="tickets_description"
                                                                    name='event_tickets_boking[tickets_description][]'
                                                                    value='<?php if (isset($ques['tickets_description']) != '')
                                                                        echo $ques['tickets_description']; ?>'
                                                                    placeholder="<?php echo esc_attr__('Description (Optional)', 'dwt-listing'); ?>">
                                                                <input class="form-control" type="number" id="no_of_tickets"
                                                                    name='event_tickets_boking[no_of_tickets][]'
                                                                    value='<?php if (isset($ques['no_of_tickets']) != "") {
                                                                        echo $ques['no_of_tickets'];
                                                                    } ?>'
                                                                    placeholder="<?php echo esc_attr__('Number of Tickets', 'dwt-listing'); ?>"
                                                                    min='1'>
                                                                <input class="form-control" type="number" id="ticket_price"
                                                                    name='event_tickets_boking[ticket_price][]'
                                                                    value='<?php if (isset($ques['ticket_price']) != '') {
                                                                        echo $ques['ticket_price'];
                                                                    } ?>'
                                                                    placeholder="<?php echo esc_attr__('Price of Tickets', 'dwt-listing'); ?> "
                                                                    min='1'>
                                                                </br>

                                                            <?php
                                                            } ?>
                                                        </div>
                                                    </div>
                                                    <!--some extra fields starts here-->
                                                    <div class="event_payments_section">
                                                        <div class="event_payments_section_title">
                                                            <h3><?php echo esc_html__('Extra Services', 'dwt-listing'); ?>
                                                            </h3>
                                                            <div class="switch_for_tickets">
                                                                <label class="switch">
                                                                    <?php $event_extra_services = get_post_meta($event_id, 'show_extra_service', true);
                                                                    ?>
                                                                    <input type="checkbox" name="show_extra_services_only"
                                                                        class="switch_for_extra_services_checkbox" <?php if (isset($event_extra_services) && $event_extra_services == 'on') {
                                                                            echo 'checked';
                                                                        } ?>>
                                                                    <span class="slider"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $display_extra_services = '';
                                                        if (isset($event_extra_services) && $event_extra_services == 'yes') {
                                                            $display_extra_services = 'style=display:block;';
                                                        }
                                                        ?>
                                                        <div class="pricing_booking_inputs">
                                                            <div class="pricing_booking_inputs_inner">
                                                                <?php
                                                                $extra_services = get_post_meta($event_id, 'event_e_services', true);
                                                                if (is_array($extra_services) && !empty($extra_services)) {
                                                                    foreach ($extra_services as $e_services) { ?>
                                                                        <div class="remove_services">

                                                                            <input class="form-control" type="text" id="e_services"
                                                                                name='event_e_services[e_services][]'
                                                                                value='<?php if (isset($e_services['e_services']) != '') {
                                                                                    echo $e_services['e_services'];
                                                                                } ?>'
                                                                                placeholder="Title*">
                                                                            <input class="form-control" type="text"
                                                                                id="camping_pitch"
                                                                                name='event_e_services[camping_pitch][]'
                                                                                value='<?php if (isset($e_services['camping_pitch']) != '') {
                                                                                    echo $e_services['camping_pitch'];
                                                                                } ?>'
                                                                                placeholder="<?php echo esc_attr__('Description Here', 'dwt-listing'); ?>">
                                                                            <input class="form-control" type="Number"
                                                                                id="camping_site"
                                                                                name='event_e_services[camping_site][]'
                                                                                value='<?php if (isset($e_services['camping_site']) != "") {
                                                                                    echo $e_services['camping_site'];
                                                                                } ?>'
                                                                                placeholder="<?php echo esc_attr__('Price*', 'dwt-listing'); ?>"
                                                                                min='1'>


                                                                            <button class="btn remove_added_question"
                                                                                id="extraServicesBtn"
                                                                                type="button"><?php echo esc_html__('X', 'dwt-listing'); ?></button>

                                                                        </div>
                                                                    <?php
                                                                    } ?>
                                                                    <div class="add_new_questions">
                                                                        <button class="btn" id="extraServicesBtn"
                                                                            type="button"><?php echo esc_html__('Add Service', 'dwt-listing'); ?></button>
                                                                    </div>
                                                                <?php
                                                                } else { ?>
                                                                    <div class="form_input_control">
                                                                        <input class="form-control" type="text" id="e_services"
                                                                            name='event_e_services[e_services][]'
                                                                            value='<?php if (isset($ques['e_services']) != '')
                                                                                echo $e_services['e_services']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Title*', 'dwt-listing'); ?>">
                                                                        <input class="form-control" type="text"
                                                                            id="camping_pitch"
                                                                            name='event_e_services[camping_pitch][]'
                                                                            value='<?php if (isset($ques['camping_pitch']) != '')
                                                                                echo $e_services['camping_pitch']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Description (optional)', 'dwt-listing'); ?>">
                                                                        <input class="form-control" type="number"
                                                                            id="camping_site"
                                                                            name='event_e_services[camping_site][]'
                                                                            value='<?php if (isset($ques['camping_site']) != "")
                                                                                echo $e_services['camping_site']; ?>'
                                                                            placeholder="<?php echo esc_attr__('Price*', 'dwt-listing'); ?>"
                                                                            min='1'>
                                                                    </div>
                                                                    </br>
                                                                    <div class="booking_tickets_input">
                                                                        <ul id="listOfExtraServices"></ul>
                                                                    </div>
                                                                    <button class="btn event_prices_button"
                                                                        id="extraServicesBtn"
                                                                        type="button"><?php echo esc_html__('Add Service', 'dwt-listing'); ?></button>

                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!--events payments section ends here-->
                                <?php
                                /* Author Listings */
                                $get_args = $profile->dwt_listing_fetch_my_listings();
                                $my_listings = new WP_Query($get_args);

                                if ($my_listings->have_posts()) {
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group has-feedback">
                                            <label
                                                class="control-label"><?php echo esc_html__('Related Listing', 'dwt-listing'); ?>
                                                <small><?php echo esc_html__('(optional)', 'dwt-listing') ?></small></label>
                                            <select
                                                data-placeholder="<?php echo esc_html__('Select Your Listing', 'dwt-listing'); ?>"
                                                name="event_parent_listing" class="custom-select">
                                                <option value="">
                                                    <?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <?php
                                                while ($my_listings->have_posts()) {
                                                    $my_listings->the_post();
                                                    $listing_id = get_the_ID();
                                                    ?>
                                                    <option <?php if ($listing_id == $parent_listing) { ?>selected="selected"
                                                        <?php } ?> value="<?php echo esc_html($listing_id) ?>">
                                                        <?php echo esc_attr(get_the_title($listing_id)); ?></option>
                                                    <?php
                                                }
                                                wp_reset_postdata();
                                                ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <input type="hidden" id="is_update" name="is_update"
                                    value="<?php echo esc_attr($is_update); ?>">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="submit-post-button">
                                        <?php
                                        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                            echo '<button type="button" class="btn btn-admin tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Save & preview', 'dwt-listing') . ' </button>';
                                        } else {
                                            ?>
                                            <button type="submit" class="btn btn-admin sonu-button"
                                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Save & preview", 'dwt-listing'); ?></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="event_upload_limit"
                            value="<?php echo esc_attr($dwt_listing_options['dwt_listing_event_upload_limit']); ?>" />
                        <input type="hidden" id="event_img_size"
                            value="<?php echo esc_attr($dwt_listing_options['dwt_listing_event_images_size']); ?>" />
                        <input type="hidden" id="max_upload_reach"
                            value="<?php echo __('Maximum upload limit reached', 'dwt-listing'); ?>" />
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
                        <input type="hidden" id="dictCancelUpload"
                            value="<?php echo esc_html__('Cancel upload', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictCancelUploadConfirmation"
                            value="<?php echo esc_html__('Are you sure you want to cancel this upload?', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictRemoveFile"
                            value="<?php echo esc_html__('Remove file', 'dwt-listing'); ?>" />
                        <input type="hidden" id="dictMaxFilesExceeded"
                            value="<?php echo esc_html__('You can not upload any more files', 'dwt-listing'); ?>" />
                        <?php dwt_listing_form_lang_field_callback(true); ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Latest Events/Webinars', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    $my_events = new WP_Query($get_argsz);
                    if ($my_events->have_posts()) {
                        while ($my_events->have_posts()) {

                            $my_events->the_post();
                            $event_id = get_the_ID();
                            //get media
                            $media = dwt_listing_fetch_event_gallery($event_id);
                            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
                            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
                            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
                            $term_list = wp_get_post_terms($event_id, 'l_event_cat', array("fields" => "all"));
                            if (!empty($term_list)) {
                                $link = get_term_link($term_list[0]->term_id);
                                $cat_name = $term_list[0]->name;
                            }
                            if ($event_start_date != "") {
                                $from = date_i18n(get_option('time_format'), strtotime($event_start_date));
                                $event_start = date_i18n(get_option('date_format'), strtotime($event_start_date));
                            }
                            if ($event_end_date != "") {
                                $to = date_i18n(get_option('time_format'), strtotime($event_end_date));
                                $event_end = date_i18n(get_option('date_format'), strtotime($event_end_date));
                            }
                            ?>
                            <div class="schedule-info">
                                <div class="event_thumb_admin">
                                    <a href="<?php echo get_the_permalink($event_id); ?>"><img class="img-responsive"
                                            src="<?php echo dwt_listing_return_event_idz($media, 'dwt_listing_user-dp'); ?>"
                                            alt="<?php echo get_the_title($event_id); ?>"></a>
                                </div>
                                <div class="event_admin_detial">
                                    <h4 class="time"><?php echo ($from); ?> - <?php echo ($to); ?></h4>
                                    <h3 class="title"><a
                                            href="<?php echo get_the_permalink($event_id); ?>"><?php echo get_the_title($event_id); ?></a>
                                    </h3>
                                    <p class="author-info"><i class="lnr lnr-calendar-full"></i>
                                        <span><?php echo ($event_start); ?> - <?php echo ($event_end); ?></span></p>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                        ?>
                        <?php
                    } else {
                        get_template_part('template-parts/profile/events/content', 'none');
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
if (dwt_listing_text('dwt_listing_enable_map') == "1" && dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "") {
    echo '<script type="text/javascript">
    var markers = [
        {
			
            "title": "",
            "lat": "' . $listing_lattitude . '",
            "lng": "' . $listing_longitide . '",
        },
    ];
    window.onload = function () {
        	my_g_map(markers);
        }
		function my_g_map(markers1)
		{
			var mapOptions = {
            center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var geocoder = geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById("submit-listing-map"), mapOptions);
            var data = markers1[0]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
                google.maps.event.addListener(marker, "dragend", function (e) {
					document.getElementById("dwt_listing_loading").style.display	= "block";
                    var lat, lng, address;
                    geocoder.geocode({ "latLng": marker.getPosition() }, function (results, status) {
						
                        if (status == google.maps.GeocoderStatus.OK) {
                            lat = marker.getPosition().lat();
                            lng = marker.getPosition().lng();
                            address = results[0].formatted_address;
							document.getElementById("d_latt").value = lat;
							document.getElementById("d_long").value = lng;
							document.getElementById("address_location").value = address;
							document.getElementById("dwt_listing_loading").style.display	= "none";
                            //alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
                        }
                    });
                });
            })(marker, data);
            latlngbounds.extend(marker.position);
		}
</script>';
} else {
    dwt_listing_valuesz($event_id, 'dwt-events');
}