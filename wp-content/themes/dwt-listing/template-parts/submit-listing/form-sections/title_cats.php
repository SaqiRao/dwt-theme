<div class="submit-listing-section">
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group has-feedback">
                <?php
                $fields_arr_req_title = has_field_required('dwt_listing_form_title_req');
                $req_star_title = isset($fields_arr_req_title['spann']) ? $fields_arr_req_title['spann'] : '';
                $req_text_title = isset($fields_arr_req_title['reqq']) ? $fields_arr_req_title['reqq'] : '';
                ?>
                <label class="control-label">
                    <?php echo dwt_listing_text('dwt_listing_list_title'); ?>
                    <span>
                        <?php echo $req_star_title; ?>
                    </span>
                </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="ti-pencil"></i></span>
                    <?php
                    if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                        echo '<input value="' . esc_attr($listing_title) . '" disabled type="text" class="form-control" placeholder="' . dwt_listing_text('dwt_listing_list_place') . '">';
                    } else {
                        ?>
                        <input type="text" maxlength="<?php echo dwt_listing_text('dwt_listing_title_limit'); ?>"
                            class="form-control tool-tip" id="listing_title" name="title"
                            title="<?php echo dwt_listing_text('dwt_listing_list_tool'); ?>"
                            placeholder="<?php echo dwt_listing_text('dwt_listing_list_place'); ?>"
                            value="<?php echo esc_attr($listing_title); ?>" <?php echo $req_text_title; ?>>
                    <?php } ?>
                </div>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group has-feedback">
                <?php
                $fields_arr_req_categ = has_field_required('dwt_listing_form_categ_req');
                $req_star_categ = isset($fields_arr_req_categ['spann']) ? $fields_arr_req_categ['spann'] : '';
                $req_text_categ = isset($fields_arr_req_categ['reqq']) ? $fields_arr_req_categ['reqq'] : '';
                ?>
                <label class="control-label">
                    <?php echo dwt_listing_text('dwt_listing_list_category'); ?>
                    <span>
                        <?php echo $req_star_categ; ?>
                    </span>
                </label>
                <select data-placeholder="<?php echo esc_html__('Select Business Category', 'dwt-listing'); ?>"
                    class="custom-select" id="d_cats" name="d_cats" <?php echo $req_text_categ; ?>>
                    <option value="">
                        <?php echo esc_html__('Select an option', 'dwt-listing'); ?>
                    </option>
                    <?php echo '' . $cats_html; ?>
                </select>
                <div class="help-block"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 <?php echo esc_attr($class); ?>" id="cat_features">
            <h4>
                <?php echo dwt_listing_text('dwt_listing_list_amen'); ?>
            </h4>
            <div class="category-based-features">
                <?php echo '' . $cats_features; ?>
            </div>
        </div>
    </div>
    <!-- additional fields-->
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 <?php echo esc_attr($class_custom_fields); ?>" id="additional_fields">
            <h4>
                <?php echo dwt_listing_text('dwt_listing_list_custom'); ?>
            </h4>
            <div class="additional_field">
                <div class="additional_custom_fields">
                    <?php dwt_listing_fetch_cat_form_fields($category_id, '1', $listing_id); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-6 l_contact_form">
            <div class="form-group">
                <?php
                $fields_arr_req_phone = has_field_required('dwt_listing_form_phone_req');
                $req_star_phone = isset($fields_arr_req_phone['spann']) ? $fields_arr_req_phone['spann'] : '';
                $req_text_phone = isset($fields_arr_req_phone['reqq']) ? $fields_arr_req_phone['reqq'] : '';
                ?>
                <label class="control-label">
                    <?php echo dwt_listing_text('dwt_listing_list_contact'); ?>
                    <span>
                        <?php echo $req_star_phone; ?>
                    </span>
                </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="ti-mobile"></i></span>
                    <input type="text" class="form-control tool-tip" name="listing_contact"
                        title="<?php echo dwt_listing_text('dwt_listing_list_contact_tool'); ?>"
                        placeholder="<?php echo dwt_listing_text('dwt_listing_list_contact_place'); ?>"
                        value="<?php echo esc_attr($listing_contact); ?>" <?php echo $req_text_phone; ?>>
                </div>
                <div class="help-block"></div>
            </div>
        </div>
        <?php if ($web_link == "yes") { ?>
            <div class="col-md-6 col-xs-12 col-sm-6 l_contact_web">
                <div class="form-group">
                    <?php
                    $fields_arr_req_siteurl = has_field_required('dwt_listing_form_siteurl_req');
                    $req_star_siteurl = isset($fields_arr_req_siteurl['spann']) ? $fields_arr_req_siteurl['spann'] : '';
                    $req_text_siteurl = isset($fields_arr_req_siteurl['reqq']) ? $fields_arr_req_siteurl['reqq'] : '';
                    ?>
                    <label class="control-label">
                        <?php echo dwt_listing_text('dwt_listing_list_web'); ?>
                        <span>
                            <?php echo $req_star_siteurl; ?>
                        </span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-world"></i></span>
                        <input type="url" class="form-control tool-tip" name="website-url"
                            title="<?php echo dwt_listing_text('dwt_listing_list_web_tool'); ?>"
                            placeholder="<?php echo dwt_listing_text('dwt_listing_list_web_place'); ?>"
                            value="<?php echo esc_attr($listing_web_url); ?>" <?php echo $req_text_siteurl; ?>>
                    </div>
                    <div class="help-block"></div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<input type="hidden" value="<?php echo dwt_listing_text('dwt_listing_title_limit'); ?>" name="charLimit" id="charLimit">