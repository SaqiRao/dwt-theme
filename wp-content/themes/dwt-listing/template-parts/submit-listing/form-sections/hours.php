<?php
$flip_it = '';
$selected_val = 0;
if (get_post_meta($listing_id, 'dwt_listing_is_hours_allow', true) == 1) {
    if (get_post_meta($listing_id, 'dwt_listing_business_hours', true) == '1') {
        $selected_val = 1;
    } else {
        $selected_val = 2;
    }
}
if (is_rtl()) {
    $flip_it = 'flip';
}
if ($business_hours == "yes") {
    ?>
    <div class="submit-listing-section for-zone l_bhours_form">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group has-feedback">
                    <label class="control-label"><strong>
                            <?php echo dwt_listing_text('dwt_listing_b_h_section'); ?>
                        </strong> </label>
                    <div class="pull-right <?php echo esc_attr($flip_it); ?>">
                        <ul class="frontend_hours list-inline">
                            <li>
                                <input id="na" class="custom-checkbox" name="type_hours" value="0" <?php echo checked(0, $selected_val, false); ?> type="radio">
                                <label for="na">
                                    <?php echo esc_html__('N/A', 'dwt-listing'); ?>
                                </label>
                            </li>
                            <li>
                                <input id="open" class="custom-checkbox" name="type_hours" value="1" <?php echo checked(1, $selected_val, false); ?> type="radio">
                                <label for="open">
                                    <?php echo esc_html__('Open 24/7', 'dwt-listing'); ?>
                                </label>
                            </li>
                            <li>
                                <input id="selective" class="custom-checkbox" name="type_hours" value="2" <?php echo checked(2, $selected_val, false); ?> type="radio">
                                <label for="selective">
                                    <?php echo esc_html__('Selective Hours', 'dwt-listing'); ?>
                                </label>
                            </li>
                            <input type="hidden" id="hours_type" name="hours_type"
                                value="<?php echo esc_attr($selected_val); ?>">
                        </ul>
                    </div>
                </div>

                <div class="form-group <?php echo esc_attr($my_class); ?> my-zones" id="timezone">
                    <label class="control-label">
                        <?php echo dwt_listing_text('dwt_listing_b_h_time'); ?>
                    </label>
                    <div class="typeahead__container">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input id="timezones" autocomplete="off" type="search" class="myzones-t form-control"
                                    value="<?php echo esc_attr($listing_timezone); ?>" name="listing_timezome">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="business-hours-fields" class="<?php echo esc_attr($my_class); ?>">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="panel with-nav-tabs panel-info">
                                <div class="panel-heading">
                                    <ul class="nav nav-tabs">
                                        <?php foreach ($days as $key => $day) { ?>
                                            <li class="<?php echo ($key == 0) ? 'active' : ''; ?>">
                                                <a href="#tab1<?php echo esc_attr($key); ?>" data-toggle="tab">
                                                    <?php echo esc_attr($day['day_name']); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <?php foreach ($days as $key => $day) {
                                            //get and set the start break and end break
                                            $break_from = isset($day['break_from']) && $day['break_from'] != "" ? trim(date("g:i A", strtotime($day['break_from']))) : "";
                                            $break_to = isset($day['break_too']) && $day['break_too'] != "" ? trim(date("g:i A", strtotime($day['break_too']))) : "";
                                            $on_off_break = isset($day['break']) ? $day['break'] : "";
                                            ?>
                                            <div class="tab-pane fade <?php echo ($key == 0) ? 'in active' : ''; ?>"
                                                id="tab1<?php echo esc_attr($key); ?>">
                                                <div class="row">
                                                    <div class="col-md-5 col-xs-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo esc_html__('From', 'dwt-listing'); ?>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                <input type="text"
                                                                    class="for_specific_page form-control timepicker"
                                                                    name="from[]" id="from-<?php echo esc_attr($key); ?>"
                                                                    placeholder="<?php echo esc_html__('Select your business hours', 'dwt-listing'); ?>"
                                                                    value="<?php echo trim(date("g:i", strtotime($day['start_time']))); ?>">
                                                            </div>
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                <input type="text"
                                                                    class="for_specific_page form-control timepicker"
                                                                    name="breakfrom[]" id="from-<?php echo esc_attr($key); ?>"
                                                                    placeholder="<?php echo esc_html__('Start Break', 'dwt-listing'); ?>"
                                                                    value="<?php echo esc_attr($break_from); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-xs-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo esc_html__('To', 'dwt-listing'); ?>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                <input type="text"
                                                                    class="for_specific_page form-control timepicker"
                                                                    id="to-<?php echo esc_attr($key); ?>" name="to[]"
                                                                    placeholder="<?php echo esc_html__('Select your business hours', 'dwt-listing'); ?>"
                                                                    value="<?php echo trim(date("g:i A", strtotime($day['end_time']))); ?>">
                                                            </div>
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                <input type="text"
                                                                    class="for_specific_page form-control timepicker"
                                                                    id="to-<?php echo esc_attr($key); ?>" name="breakto[]"
                                                                    placeholder="<?php echo esc_html__('End Break', 'dwt-listing'); ?>"
                                                                    value="<?php echo esc_attr($break_to); ?>">
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-2 col-xs-12 col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo esc_html__('Closed', 'dwt-listing'); ?>
                                                            </label>
                                                            <input name="is_closed[]"
                                                                id="is_closed-<?php echo esc_attr($key); ?>"
                                                                value="<?php echo esc_attr($key); ?>" type="checkbox" <?php echo ($day['closed'] == 1) ? 'checked="checked"' : ''; ?>
                                                                class="custom-checkbox is_closed"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-xs-12 col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo esc_html__('Break', 'dwt-listing'); ?>
                                                            </label>
                                                            <input name="is_break[]" id="is_break-<?php echo esc_attr($key); ?>"
                                                                value="<?php echo esc_attr($key); ?>" type="checkbox" <?php echo ($on_off_break) ? 'checked="checked"' : ''; ?>
                                                                class="custom-checkbox is_break"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>