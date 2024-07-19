<?php
global $dwt_listing_options;
$option = $class1 = $class = $selective = $amenties = $price_type = $by_title = '';
//selective
if (isset($_GET['by_title']) && $_GET['by_title'] != "") {
    $by_title = $_GET['by_title'];
}
$street_address = '';
//selective
if (isset($_GET['street_address']) && $_GET['street_address'] != "") {
    $street_address = $_GET['street_address'];
    if (dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "") {
        dwt_listing_get_lat_lon_google($street_address);
    }
} else {
    $user_city_location = isset($_COOKIE['user_city_location_custom']) ? $_COOKIE['user_city_location_custom'] : '';
    $street_address = $user_city_location;
}

$lon = $lat = '';
if (isset($_GET['latitude']) && $_GET['latitude'] != "") {
    $lat = $_GET['latitude'];
}
if (isset($_GET['longitude']) && $_GET['longitude'] != "") {
    $lon = $_GET['longitude'];
}

$listing_staus = '';
if (isset($_GET['l_listing_status']) && $_GET['l_listing_status'] != "") {
    $listing_staus = $_GET['l_listing_status'];
    $class = '';
    if ($listing_staus == 'opened') {
        $class = 'active';
    }
}
$listing_rating = '';
if (isset($_GET['l_rating']) && $_GET['l_rating'] != "") {
    $listing_rating = $_GET['l_rating'];
    $class1 = '';
    if ($listing_rating == 'high_rated') {
        $class1 = 'active';
    }
}
$amenties = '';
if (isset($_GET['amenties']) && is_array($_GET['amenties'])) {
    $amenties = $_GET['amenties'];
}
if (isset($_GET['l_location']) && $_GET['l_location'] != "") {
    $loc_id = $_GET['l_location'];
    $get_valz = get_term_by('id', $loc_id, 'l_location');
    $final_id = $get_valz->term_id;
    $final_name = $get_valz->name;
    $option = '<option value="' . $final_id . '" selected="selected">' . $final_name . '</option>';
}
if (dwt_listing_countires_cookies() != "") {
    $loc_id = dwt_listing_countires_cookies();
    $get_valz = get_term_by('id', $loc_id, 'l_location');
    $final_id = $get_valz->term_id;
    $final_name = $get_valz->name;
    $option = '<option value="' . $final_id . '" selected="selected">' . $final_name . '</option>';
}

if (dwt_listing_countires_cookies() != "") {
    $loc_id = dwt_listing_countires_cookies();
    $get_valz = get_term_by('id', $loc_id, 'l_location');
    $final_id = $get_valz->term_id;
    $final_name = $get_valz->name;
    $option = '<option value="' . $final_id . '" selected="selected">' . $final_name . '</option>';
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
        //for location only
        if (is_tax('l_location')) {
            $option = '<option value="' . $term_ID . '" selected="selected">' . $term_name . '</option>';
        }
    }
}

if (dwt_listing_text('dwt_listing_enable_mapfilters') == '1') {
    ?>
    <div class="filtes-with-maps ">
        <div class="seprator">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="row">
                    <form method="post" id="search_form_ajax">
                        <div class="dwt-new-filterz">
                            <?php if (dwt_listing_text('donwtown_search_bytitle') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-4">
                                    <div class="form-group dwt-for-map">
                                        <div class="typeahead__container">
                                            <div class="typeahead__field">
                                                <div class="typeahead__query">
                                                    <input name="by_title" value="<?php echo $by_title; ?>"
                                                           autocomplete="off" type="search"
                                                           class="for_search_pages form-control specific_search"
                                                           placeholder="<?php echo esc_html__('What Are You Looking For?', 'dwt-listing'); ?>">
                                                </div>
                                                <div class="typeahead__button dwt-search-s">
                                                    <button type="button" id="get_title">
                                                        <span class="typeahead__search-icon"><i
                                                                    class="fa fa-search"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (dwt_listing_text('donwtown_search_byloc') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-4">
                                    <div class="search-widget">
                                        <div class="form-group specific-search">
                                            <input class="form-control" id="address_location" name="street_address"
                                                   placeholder="<?php echo esc_html__('Address or city', 'dwt-listing'); ?>"
                                                   value="<?php echo esc_attr($street_address); ?>" type="text">
                                            <?php if (dwt_listing_text('dwt_listing_enable_geo') == '1') { ?>
                                                <i class="detect-me fa fa-crosshairs"></i>
                                                <?php if (dwt_listing_text('dwt_map_selection') == 'open_street') { ?>
                                                    <input name="latitude" type="hidden" id="search_lat"
                                                           value="<?php echo esc_attr($lat); ?>">
                                                    <input name="longitude" type="hidden" id="search_lon"
                                                           value="<?php echo esc_attr($lon); ?>">
                                                <?php } ?>
                                            <?php } ?>
                                            <button id="l_loc" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            <?php } ?>
                            <?php if (dwt_listing_text('donwtown_search_bcats') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <?php
                                    //Get cats
                                    $listing_cats = dwt_listing_categories_fetch('l_category', 0);
                                    if (count((array)$listing_cats) > 0) {
                                        ?>

                                        <div class="form-group">
                                            <select data-placeholder="<?php echo esc_html__('Select Category', 'dwt-listing'); ?>"
                                                    name="l_category" class="allow_clear" id="l_category">
                                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <option value="all"><?php echo esc_html__('All Categories', 'dwt-listing'); ?></option>
                                                <?php
                                                $get_cat_val = '';
                                                //selective
                                                if (isset($_GET['l_category']) && $_GET['l_category'] != "") {
                                                    $term_ID = $_GET['l_category'];
                                                }

                                                foreach ($listing_cats as $cats) {
                                                    ?>
                                                    <option
                                                        <?php if ($cats->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                                                        value="<?php echo esc_attr($cats->term_id); ?>"><?php echo esc_html($cats->name); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if (dwt_listing_text('donwtown_search_bytags') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <?php
                                    //Get cats
                                    $l_tags = get_terms(array('l_tags'), array('hierarchical' => 1));
                                    if (!is_wp_error($l_tags) && !empty($l_tags)) {
                                        if (isset($_GET['l_tag']) && $_GET['l_tag'] != "") {
                                            $term_ID = $_GET['l_tag'];
                                        }
                                        ?>
                                        <div class="form-group">
                                            <select data-placeholder="<?php echo esc_html__('Filter By Tags', 'dwt-listing'); ?>"
                                                    name="l_tag" class="allow_clear" id="l_tag">
                                                <option value=""><?php echo esc_html__('Select Tag', 'dwt-listing'); ?></option>
                                                <option value="all"><?php echo esc_html__('All Tags', 'dwt-listing'); ?></option>
                                                <?php
                                                foreach ($l_tags as $term) {
                                                    ?>
                                                    <option
                                                        <?php if ($term->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                                                        value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if (dwt_listing_text('donwtown_search_byregion') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <select id="region"
                                                data-placeholder="<?php echo esc_html__('Select Region', 'dwt-listing'); ?>"
                                                name="l_location"><?php echo($option); ?></select>
                                    </div>
                                </div>
                                

                                



                            <?php } ?>
                            <?php if (dwt_listing_text('donwtown_search_bysort') == '1') { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <select name="sort_by"
                                                data-placeholder="<?php echo esc_html__('Sort By', 'dwt-listing'); ?>"
                                                id="order_by" class="custom-select form-control">
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
                            <?php } ?>
                            <div id="dynamic_fields_map_on" class="dynamic_fields_map_on"></div>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="main-filters">
                                <?php if (dwt_listing_text('donwtown_search_byprice') == '1') { ?>
                                    <?php
                                    //Get cats
                                    $price_type = dwt_listing_categories_fetch('l_price_type', 0);
                                    if (count((array)$price_type) > 0) {
                                        ?>
                                        <div class="filter filter-expensive">
                                            <ul>
                                                <li class="dropdown">
                                                    <a href="javascript:void(0)" class="dropdown btn"
                                                       data-toggle="dropdown">
                                                        <span> <?php echo esc_html__('Cost Range', 'dwt-listing'); ?></span>
                                                        <span class="caret"></span>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <?php
                                                        $i = 0;
                                                        $signs = array(0 => '$', 1 => '$$', 2 => '$$$', 3 => '$$$$', 4 => '$$$$$', 5 => '$$$$$$', 6 => '$$$$$$$', 7 => '$$$$$$$$', 8 => '$$$$$$$$$', 9 => '$$$$$$$$$$');

                                                        $l_price_type = '';
                                                        //selective
                                                        if (isset($_GET['l_price_type']) && $_GET['l_price_type'] != "") {
                                                            $l_price_type = $_GET['l_price_type'];
                                                        }
                                                        foreach ($price_type as $type) {
                                                            $selective = ($type->term_id == $l_price_type) ? 'checked="checked"' : '';
                                                            ?>
                                                            <div class="list-group price-range">
                                                                <div class="list-group-item">
                                                                    <div class="desc-text">
                                                                        <span><input class="custom-checkbox cost_range"
                                                                                     name="cost_range" <?php echo esc_attr($selective); ?>  value="<?php echo esc_attr($type->term_id); ?>"
                                                                                     type="radio"></span>
                                                                        <span class="filter-text-area">
                                                                            <h4><?php echo esc_html($type->name); ?></h4>
                                                                        </span>
                                                                    </div>
                                                                    <?php
                                                                    global $sitepress;
                                                                    if (!function_exists('icl_object_id')) {
                                                                        ?>
                                                                        <div class="filter-text-erea-icon"><?php echo esc_attr($signs[$i]); ?></div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (dwt_listing_text('donwtown_search_byopen') == '1') { ?>
                                    <div class="filter filter-timing">
                                        <label for="status_success" class="btn <?php echo esc_attr($class); ?>"><i
                                                    class="ti-timer"></i><?php echo esc_html__('Open Now', 'dwt-listing'); ?>
                                            <input value="opened" name="l_listing_status" type="checkbox"
                                                   id="status_success" class="badgebox open_now"></label>
                                    </div>
                                <?php } ?>
                                <?php if (dwt_listing_text('donwtown_search_byrated') == '1') { ?>
                                    <div class="filter filter-rated">
                                        <label class="btn <?php echo esc_attr($class1); ?>"><i
                                                    class="ti-stats-up"></i><?php echo esc_html__('Highly Rated', 'dwt-listing'); ?>
                                            <input type="checkbox" value="high_rated" name="l_rating" id="rated"
                                                   class="badgebox h_rated"></label>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php
                            if (dwt_listing_text('donwtown_search_byfeatures') == '1') {
                                echo '<div class="with_sidebar amenties_ajax"></div>';
                                $active_class = '';
                                if (!empty($term_ID)) {
                                    $active_class = 'in';
                                    $terms = dwt_listing_categories_fetch('l_category', $term_ID);
                                    if (count((array)$terms) > 0 && !is_wp_error($terms)) {
                                        ?>
                                        <div class="clearfix"></div>
                                        <div class="panel-group" id="accordionz" role="tablist"
                                             aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="feat_anam">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           data-parent="#accordionz" href="#featurez"
                                                           aria-expanded="true" aria-controls="featurez">
                                                            <i class="more-less glyphicon glyphicon-plus"></i>
                                                            <?php echo esc_html__('Features', 'dwt-listing'); ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="featurez"
                                                     class="panel-collapse collapse <?php echo esc_attr($active_class); ?>"
                                                     role="tabpanel" aria-labelledby="feat_anam">
                                                    <div class="panel-body">

                                                        <div id="show_on_request">
                                                            <ul class="list-inline">
                                                                <?php
                                                                foreach ($terms as $term) {
                                                                    if ($amenties != "") {
                                                                        $selective = (in_array($term->term_id, $amenties)) ? 'checked="checked"' : '';
                                                                    }
                                                                    ?>
                                                                    <li>
                                                                        <input type="checkbox"
                                                                               id="<?php echo esc_url($term->slug); ?>"
                                                                               name="amenties[]" <?php echo esc_attr($selective); ?>
                                                                               value="<?php echo esc_attr($term->term_id); ?>"
                                                                               class="custom-checkbox">
                                                                        <label for="<?php echo esc_url($term->slug); ?>"><?php echo esc_attr($term->name); ?></label>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <input class="btn btn-theme" id="d_getfilters"
                                                                       type="button"
                                                                       value="<?php echo esc_html__('Filter', 'dwt-listing'); ?>">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php
                                    }
                                } else {
                                    echo '<div class="show_div panel-group"></div>';
                                }
                            }
                            ?>
                        </div>
                        <input type="hidden" name="l_price_type" value="">
                        <input type="hidden" id="r_map_lat" name="r_map_lat" value="">
                        <input type="hidden" id="r_map_long" name="r_map_long" value="">
                        <?php dwt_listing_form_lang_field_callback(true); ?>
                        <?php
                        if (dwt_listing_countires_cookies() != "" && dwt_listing_text('donwtown_search_byregion') == '0') {
                            echo '<input type="hidden" id="l_location" name="l_location" value="' . dwt_listing_countires_cookies() . '">';
                        }
                        ?>
                    </form>
                    <div class="result-area">
                        <?php
                        $flip = '';
                        if (is_rtl()) {
                            $flip = 'flip';
                        }
                        ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h4 class="pull-left <?php echo esc_attr($flip); ?>">
                                <strong> <?php echo esc_attr($results->found_posts); ?> </strong> <?php echo esc_html__('Results found', 'dwt-listing'); ?>
                                <span id="result_reset">
                                    <?php
                                    if (!empty($_GET)) {
                                        echo '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>';
                                    }
                                    ?>
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
<?php } ?>