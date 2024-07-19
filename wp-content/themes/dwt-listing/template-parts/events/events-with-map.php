<?php
global $dwt_listing_options;
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
$by_title = '';
//selective
if (isset($_GET['by_title']) && $_GET['by_title'] != "") {
    $by_title = $_GET['by_title'];
}
$venue = '';
//selective
if (isset($_GET['by_location']) && $_GET['by_location'] != "") {
    $venue = $_GET['by_location'];
}
$term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
$queried_object = get_queried_object();
if (!empty($queried_object) && count((array)$queried_object) > 0) {
    $term_id = $queried_object->term_id;
    $tax_name = $queried_object->taxonomy;
    if (!empty($term_id)) {
        $term_idz = get_term_by('id', $term_id, $tax_name);
        $term_ID = $term_idz->term_id;
        $term_name = $term_idz->name;
    }
}
?>
<div class="event-map-section">
    <div class="map-zone">
        <div id="map_event" class="map_event"></div>
    </div> <!-- end .map-zone -->
    <div class="map-content-zone">

        <div class="result-zone">
            <div class="event-filters">
                <form method="post" id="d_events_filters">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="location-filters">
                                <label class="control-label"><?php echo esc_html__('Title', 'dwt-listing'); ?></label>
                                <div class="input-group">
                                    <div class="form-group has-icon has-clear">
                                        <input type="text" class="form-control "
                                               placeholder="<?php echo esc_html__('Seach by title', 'dwt-listing'); ?>"
                                               autocomplete="off" name="by_title"
                                               value="<?php echo esc_attr($by_title); ?>">
                                        <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
                                    </div>
                                    <span class="input-group-btn"><button id="get_title" class="btn btn-default"
                                                                          type="button"><span
                                                    class="fa fa-search"></span></button></span>
                                </div>
                            </div>
                        </div> <!-- end .col-sm-4 -->
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="location-filters">
                                <label class="control-label"><?php echo esc_html__('By Location', 'dwt-listing'); ?></label>
                                <div class="input-group">
                                    <div class="form-group has-icon has-clear">
                                        <input type="text" class="form-control"
                                               placeholder="<?php echo esc_html__('e.g. Event venues..', 'dwt-listing'); ?>"
                                               name="by_location" id="by_location"
                                               value="<?php echo esc_attr($venue); ?>">
                                        <i class="detect-me fa fa-crosshairs"></i>
                                        <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
                                    </div>
                                    <span class="input-group-btn"><button id="get_locz" class="btn btn-default"
                                                                          type="button"><span
                                                    class="fa fa-search"></span></button></span>
                                </div>
                            </div> <!-- end .form-group -->
                        </div> <!-- end .col-sm-4 -->
                        <?php
                        //Get cats
                        $event_cats = dwt_listing_categories_fetch('l_event_cat', 0);
                        if (count($event_cats) > 0) {
                            ?>
                            <div class="col-sm-6 col-xs-12 col-md-6">
                                <div class="location-filters">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo esc_html__('Category', 'dwt-listing'); ?></label>
                                        <select data-placeholder="<?php echo esc_html__('Select Event Category', 'dwt-listing'); ?>"
                                                id="event_cat" name="event_cat" class="allow_clear">
                                            <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                            <?php
                                            foreach ($event_cats as $cats) {
                                                ?>
                                                <option
                                                    <?php if ($cats->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                                                    value="<?php echo esc_attr($cats->term_id); ?>"><?php echo esc_html($cats->name); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div> <!-- end .form-group -->
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="location-filters">
                                <div class="form-group">
                                    <label><?php echo esc_html__('Sort by', 'dwt-listing'); ?></label>
                                    <select name="sort_by" id="order_by" class="custom-select event_sort_by">
                                        <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                        <option value="id-desc">
                                            <?php echo esc_html__('Newest To Oldest', 'dwt-listing'); ?>
                                        </option>
                                        <option value="id-asc">
                                            <?php echo esc_html__('Oldest To New', 'dwt-listing'); ?>
                                        </option>
                                        <option value="title-asc">
                                            <?php echo esc_html__('Alphabetically [a-z]', 'dwt-listing'); ?>
                                        </option>
                                        <option value="title-desc">
                                            <?php echo esc_html__('Alphabetically [z-a]', 'dwt-listing'); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12">
                            <div class="location-filters">
                                <div class="form-group">
                                    <label><?php echo esc_html__('By Date', 'dwt-listing'); ?></label>
                                    <div class="row row-date-start-end">
                                        <div class="col-sm-5 col-md-5 col-xs-5 date-search">
                                            <input type="text" class="form-control "
                                                   placeholder="<?php echo esc_html__('Start Date', 'dwt-listing'); ?>"
                                                   autocomplete="off" id="event_start" name="by_date_start_filter"
                                                   value="">
                                        </div>
                                        <div class="col-sm-5 col-md-5 col-xs-5 date-search">
                                            <input type="text" class="form-control "
                                                   placeholder="<?php echo esc_html__('End Date', 'dwt-listing'); ?>"
                                                   autocomplete="off" id="event_end" name="by_date_end_filter"
                                                   value="">
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xs-2 date-search">
                                            <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
                                            <span class="input-group-btn"><button id="get_start_date_filter"
                                                                                  class="btn btn-default start-end-filter"
                                                                                  type="button"><span
                                                            class="fa fa-search"></span></button></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php dwt_listing_form_lang_field_callback(true); ?>
                </form>
            </div>
            <div class="inner-padging">
                <div class="event-result-area">
                    <p class="results">
                        <strong><?php echo esc_attr($results->found_posts); ?></strong> <?php echo esc_html__('Results found', 'dwt-listing'); ?>
                        <span id="result_reset"><?php
                            if (!empty($_GET)) {
                                echo '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>';
                            }
                            ?></span></p>
                </div>
                <div class="row">
                    <div class="sk-circle">
                        <div class="sk-circle1 sk-child"></div>
                        <div class="sk-circle2 sk-child"></div>
                        <div class="sk-circle3 sk-child"></div>
                        <div class="sk-circle4 sk-child"></div>
                        <div class="sk-circle5 sk-child"></div>
                        <div class="sk-circle6 sk-child"></div>
                        <div class="sk-circle7 sk-child"></div>
                        <div class="sk-circle8 sk-child"></div>
                        <div class="sk-circle9 sk-child"></div>
                        <div class="sk-circle10 sk-child"></div>
                        <div class="sk-circle11 sk-child"></div>
                        <div class="sk-circle12 sk-child"></div>
                    </div>
                    <?php
                    if ($results->have_posts()) {
                        echo '<div class="s_ajax"><div class="list-boxes">';
                        require trailingslashit(get_template_directory()) . 'template-parts/events/event-type-grid.php';
                        echo '' . ($fetch_output);
                        echo '</div></div>';
                        wp_reset_postdata();
                        echo '<div class="col-md-12 cpl-xs-12 col-sm-12 clearfix" id="listing_ajax_pagination">';
                        echo dwt_listing_ajax_pagination_search($results);
                        echo '</div>';
                    } else {
                        //no result found
                        echo '<div class="s_ajax"><div class="masonery_wrap">' . dwt_listing_ajax_no_result() . '</div></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>