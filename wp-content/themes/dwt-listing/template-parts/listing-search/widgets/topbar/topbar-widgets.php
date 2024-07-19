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
if (isset($_GET['l_tag']) && $_GET['l_tag'] != "") {
    $term_ID = $_GET['l_tag'];
}
?>
<form method="post" id="search_form_ajax">
    <div class="row">
        <?php if (dwt_listing_text('donwtown_search_bytitle') == '1') { ?>
            <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                <div class="location-filters">
                    <div class="typeahead__container tp-bar">
                        <div class="typeahead__field">
                            <div class="typeahead__query">
                                <input name="by_title" value="<?php echo($by_title); ?>" autocomplete="off"
                                       type="search" class="for_search_pages form-control specific_search"
                                       placeholder="<?php echo esc_html__('What Are You Looking For?', 'dwt-listing'); ?>">
                            </div>
                            <div class="typeahead__button dwt-search-s">
                                <button type="button" id="get_title">
                                    <span class="typeahead__search-icon"><i class="fa fa-search"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if (dwt_listing_text('donwtown_search_bcats') == '1') {
            //Get cats
            $listing_cats = dwt_listing_categories_fetch('l_category', 0);
            if (count((array)$listing_cats) > 0) {
                ?>
                <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                    <div class="location-filters">
                        <div class="form-group">
                            <select data-placeholder="<?php echo esc_html__('Select Category', 'dwt-listing'); ?>"
                                    name="l_category" class="allow_clear" id="l_category">
                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                <option value="all"><?php echo esc_html__('All Categories', 'dwt-listing'); ?></option>
                                <?php
                                //selective
                                if (isset($_GET['l_category']) && $_GET['l_category'] != "") {
                                    $term_ID = $_GET['l_category'];
                                }
                                foreach ($listing_cats as $cats) {
                                    ?>
                                    <option <?php if ($cats->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                                            value="<?php echo esc_attr($cats->term_id); ?>"><?php echo esc_html($cats->name); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <?php
        if (dwt_listing_text('donwtown_search_bytags') == '1') {
            /* Tags */
            $l_tags = get_terms(array('l_tags'), array('hierarchical' => 1));
            if (!is_wp_error($l_tags) && !empty($l_tags)) {
                ?>
                <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                    <div class="location-filters">
                        <div class="form-group">
                            <select data-placeholder="<?php echo esc_html__('Filter By Tags', 'dwt-listing'); ?>"
                                    name="l_tag" class="allow_clear" id="l_tag">
                                <option value=""><?php echo esc_html__('Select Tag', 'dwt-listing'); ?></option>
                                <option value="all"><?php echo esc_html__('All Tags', 'dwt-listing'); ?></option>
                                <?php
                                foreach ($l_tags as $term) {
                                    ?>
                                    <option <?php if ($term->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                                            value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <?php
        if (dwt_listing_text('donwtown_search_byprice') == '1') {
            //Get cats
            $price_type = dwt_listing_categories_fetch('l_price_type', 0);
            if (count((array)$price_type) > 0) {
                ?>
                <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                    <div class="location-filters">
                        <div class="form-group">
                            <select data-placeholder="<?php echo esc_html__('Select Price Type', 'dwt-listing'); ?>"
                                    id="cost_range" name="l_price_type" class="allow_clear">
                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                <option value="all"><?php echo esc_html__('All Prices', 'dwt-listing'); ?></option>
                                <?php
                                $l_price_type = '';
                                //selective
                                if (isset($_GET['l_price_type']) && $_GET['l_price_type'] != "") {
                                    $l_price_type = $_GET['l_price_type'];
                                }
                                foreach ($price_type as $type) {
                                    ?>
                                    <option <?php if ($type->term_id == $l_price_type) { ?>selected="selected"<?php } ?>
                                            value="<?php echo esc_attr($type->term_id); ?>"><?php echo esc_html($type->name); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <?php if (dwt_listing_text('donwtown_search_byrated') == '1') { ?>
            <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                <div class="location-filters">
                    <div class="form-group">
                        <select data-placeholder="<?php echo esc_html__('Rated As', 'dwt-listing'); ?>" name="l_rating"
                                id="rated" class="allow_clear">
                            <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                            <option value="high_rated" <?php
                            if ($listing_staus == 'high_rated') {
                                echo 'selected=selected';
                            }
                            ?>><?php echo esc_html__('High to Low', 'dwt-listing'); ?></option>
                            <option value="low_rated" <?php
                            if ($listing_staus == 'low_rated') {
                                echo 'selected=selected';
                            }
                            ?>><?php echo esc_html__('Low to High', 'dwt-listing'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (dwt_listing_text('donwtown_search_byloc') == '1') { ?>
            <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                <div class="location-filters">
                    <div class="input-group">
                        <div class="form-group has-icon has-clear">
                            <input type="text" class="form-control"
                                   placeholder="<?php echo esc_html__('Address or city', 'dwt-listing'); ?>"
                                   name="street_address" id="address_location"
                                   value="<?php echo esc_attr($street_address); ?>">
                            <span class="form-control-clear glyphicon glyphicon-remove form-control-feedback hidden"></span>
                        </div>
                        <span class="input-group-btn"><button id="l_loc" class="btn btn-default" type="button"><span
                                        class="fa fa-search"></span></button></span>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (dwt_listing_text('donwtown_search_byopen') == '1') { ?>
            <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                <div class="location-filters">
                    <div class="form-group">
                        <select data-placeholder="<?php echo esc_html__('All or Open', 'dwt-listing'); ?>"
                                id="listing_status" name="l_listing_status" class="allow_clear">
                            <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                            <option value="all" <?php
                            if ($listing_staus == 'all') {
                                echo 'selected=selected';
                            }
                            ?>><?php echo esc_html__('All', 'dwt-listing'); ?></option>
                            <option value="opened" <?php
                            if ($listing_staus == 'opened') {
                                echo 'selected=selected';
                            }
                            ?>><?php echo esc_html__('Open', 'dwt-listing'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (dwt_listing_text('donwtown_search_byregion') == '1') { ?>
            <div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
                <div class="location-filters">
                    <div class="form-group">
                        <select id="region" data-placeholder="<?php echo esc_html__('Select Region', 'dwt-listing'); ?>"
                                name="l_location"> <?php echo($option); ?></select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- add dynamic field here after ajax call -->
            <div id="dynamic_fields_topbar_on" class="dynamic_fields_topbar_on_filter"></div>
        <?php } ?>
    </div>
    <?php
    if (dwt_listing_text('donwtown_search_byfeatures') == '1') {
        echo '<div class="amenties_ajax"></div>';
        if (!empty($term_ID)) {
            $terms = dwt_listing_categories_fetch('l_category', $term_ID);
            if (count((array)$terms) > 0 && !is_wp_error($terms)) {
                ?>
                <div class="amenties">
                    <h4 class="for_amenties"><?php echo esc_html__('Search By Features', 'dwt-listing'); ?></h4>
                    <div id="amenties-dropdown" class="collapse in">
                        <ul class="list-inline">
                            <?php
                            foreach ($terms as $term) {
                                ?>
                                <li>
                                    <input id="<?php echo esc_attr($term->slug); ?>" <?php echo esc_attr($selective); ?>
                                           name="amenties[]" value="<?php echo esc_attr($term->term_id); ?>"
                                           type="checkbox" class="custom-checkbox">
                                    <label for="<?php echo esc_attr($term->slug); ?>"> <?php echo esc_attr($term->name); ?> </label>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <input id="d_getfilters" class="btn btn-theme btn-sm" type="button"
                           value="<?php echo esc_html__('Search', 'dwt-listing'); ?>">
                </div>
                <?php
            }
        }
    }

    if (dwt_listing_countires_cookies() != "" && dwt_listing_text('donwtown_search_byregion') == '0') {
        echo '<input type="hidden" id="l_location" name="l_location" value="' . dwt_listing_countires_cookies() . '">';
    }
    ?>
    <?php dwt_listing_form_lang_field_callback(true); ?>
</form>