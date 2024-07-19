<?php
$location_icon = $check_class = $my_id = '';
if (dwt_listing_text('dwt_listing_enable_geo') == '1' && dwt_listing_text('dwt_map_selection') == 'open_street') {
    $check_class = 'get-loc';
    $location_icon = '<i class="detect-me fa fa-crosshairs"></i>';
}
?>
<div class="submit-listing-section l_placeholder_form">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="form-group <?php echo esc_attr($check_class); ?>">
                <?php
                $fields_arr_req_location = has_field_required('dwt_listing_form_location_req');
                $req_star_tlocation = isset($fields_arr_req_location['spann']) ? $fields_arr_req_location['spann'] : '';
                $req_text_location = isset($fields_arr_req_location['reqq']) ? $fields_arr_req_location['reqq'] : '';
                ?>
                <label class="control-label "><?php echo dwt_listing_text('dwt_listing_list_google_loc'); ?>
                    <span><?php echo $req_star_tlocation; ?></span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="ti-location-pin"></i></span>
                    <input type="text" class="form-control tool-tip" id="address_location" name="listing_streetAddress"
                           title="<?php echo dwt_listing_text('dwt_listing_list_google_loc_tool'); ?>"
                           placeholder="<?php echo dwt_listing_text('dwt_listing_list_google_loc_place'); ?>"
                           value="<?php echo esc_attr($listing_street); ?>" <?php echo $req_text_location; ?>>
                    <?php echo $location_icon; ?>
                </div>
                <div class="help-block"></div>
            </div>
        </div>
        <?php
        if (dwt_listing_text('dwt_listing_enable_map') == "1") {
            if (dwt_listing_text('dwt_map_selection') == "google_map" && dwt_listing_text('gmap_api_key') != "") {
                require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/google_map.php';
            } else {
                require trailingslashit(get_template_directory()) . 'template-parts/submit-listing/form-sections/open_street.php';
            }
        }
        ?>
        <?php if (dwt_listing_text('dwt_listing_allow_country_location') == '1') { ?>
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group has-feedback">
                    <label class="control-label"><?php echo esc_attr($loc_lvl_1); ?><span>*</span></label>
                    <select data-placeholder="<?php echo esc_html__('Select Your Country', 'dwt-listing'); ?>"
                            class="custom-select" id="d_country" name="d_country" required>

                        <?php echo '' . $country_html; ?>
                    </select>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6 <?php echo esc_attr($class_two); ?>" id="states">
                <div class="form-group">
                    <label class="control-label"><?php echo esc_attr($loc_lvl_2); ?></label>
                    <select data-placeholder="<?php echo esc_html__('Select Your State', 'dwt-listing'); ?>"
                            class="custom-select" id="d_state" name="d_state"><?php echo '' . $state_html; ?></select>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6 <?php echo esc_attr($class_three); ?>" id="city">
                <div class="form-group">
                    <label class="control-label"><?php echo esc_attr($loc_lvl_3); ?></label>
                    <select data-placeholder="<?php echo esc_html__('Select Your City', 'dwt-listing'); ?>"
                            class="custom-select" id="d_city" name="d_city"><?php echo '' . $cities_html; ?></select>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6 <?php echo esc_attr($class_four); ?>" id="town">
                <div class="form-group">
                    <label class="control-label"><?php echo esc_attr($loc_lvl_4); ?></label>
                    <select data-placeholder="<?php echo esc_html__('Select Your Town', 'dwt-listing'); ?>"
                            class="custom-select" id="d_town" name="d_town"><?php echo '' . $towns_html; ?></select>
                </div>
            </div>
        <?php } ?>
    </div>
</div>