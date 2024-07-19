<?php if ($price_range == "yes") { ?>
    <div class="submit-listing-section l_price_form">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div id="pricing-fields">
                    <div class="row">
                        <div class="col-md-7 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <?php
                                $fields_arr_req_pricetype = has_field_required('dwt_listing_form_price_type_req');
                                $req_star_pricetype = isset($fields_arr_req_pricetype['spann']) ? $fields_arr_req_pricetype['spann'] : '';
                                $req_text_pricetype = isset($fields_arr_req_pricetype['reqq']) ? $fields_arr_req_pricetype['reqq'] : '';
                                ?>
                                <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_pricetype'); ?>
                                    <span><?php echo $req_star_pricetype; ?></span></label>
                                <select data-placeholder="<?php echo esc_html__('Select Price Type', 'dwt-listing'); ?>"
                                        class="custom-select" <?php echo $req_text_pricetype; ?>
                                        name="listing_price_type" id="listing_price_type">
                                    <option value=""><?php echo esc_html__('Select Price Type', 'dwt-listing'); ?></option>
                                    <?php echo '' . $price_type_html; ?>
                                </select>
                                <div class="help-block"></div>
                            </div>


                            <div class="form-group">
                                <?php
                                $fields_arr_req_curencytype = has_field_required('dwt_listing_form_curency_req');
                                $req_star_curencytype = isset($fields_arr_req_curencytype['spann']) ? $fields_arr_req_curencytype['spann'] : '';
                                $req_text_curencytype = isset($fields_arr_req_curencytype['reqq']) ? $fields_arr_req_curencytype['reqq'] : '';
                                ?>
                                <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_currenct'); ?>
                                    <span><?php echo $req_star_curencytype; ?></span></label>
                                <select data-placeholder="<?php echo esc_html__('Select Currency Type', 'dwt-listing'); ?>"
                                        class="custom-select"
                                        name="listing_currency_type" <?php echo $req_text_curencytype; ?>>
                                    <option value=""><?php echo esc_html__('Select Currency Type', 'dwt-listing'); ?></option>
                                    <?php echo '' . $listing_currency_html; ?>
                                </select>
                                <div class="help-block"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $fields_arr_req_curencyfrom = has_field_required('dwt_listing_form_price_from_req');
                                        $req_star_curencyfrom = isset($fields_arr_req_curencyfrom['spann']) ? $fields_arr_req_curencyfrom['spann'] : '';
                                        $req_text_curencyfrom = isset($fields_arr_req_curencyfrom['reqq']) ? $fields_arr_req_curencyfrom['reqq'] : '';
                                        ?>
                                        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_price_from'); ?>
                                            <span><?php echo $req_star_curencyfrom; ?></span></label>
                                        <input type="number" class="form-control" name="listing_pricefrom"
                                               value="<?php echo esc_attr($listing_price_from); ?>" <?php echo $req_text_curencyfrom; ?>>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $fields_arr_req_curencyto = has_field_required('dwt_listing_form_price_to_req');
                                        $req_star_curencyto = isset($fields_arr_req_curencyto['spann']) ? $fields_arr_req_curencyto['spann'] : '';
                                        $req_text_curencyto = isset($fields_arr_req_curencyto['reqq']) ? $fields_arr_req_curencyto['reqq'] : '';
                                        ?>
                                        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_price_to'); ?>
                                            <span><?php echo $req_star_curencyto; ?></span></label>
                                        <input type="number" class="form-control" name="listing_priceto"
                                               value="<?php echo esc_attr($listing_price_to); ?>" <?php echo $req_text_curencyto; ?>>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12 col-sm-12 hidden-sm">
                            <div class="submit-post-img-container">
                                <img class="img-responsive"
                                     src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/submit-post-pricing.jpg'); ?>"
                                     alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>  