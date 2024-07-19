<?php if($coupon_code == "yes") { ?> 
<div class="submit-listing-section">
    <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label"><?php echo dwt_listing_text('dwt_listing_coupon_title');?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-cut"></i></span>
                      <input type="text" class="form-control" id="listing_coupon_title" name="listing_coupon_title"  placeholder="<?php echo esc_html__('Save 20%','dwt-listing');?>" value="<?php echo esc_attr($listing_coupon); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label"><?php echo dwt_listing_text('dwt_listing_coupon_code');?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class=" ti-unlock "></i></span>
                      <input type="text" class="form-control" id="listing_coupon_code" name="listing_coupon_code"  placeholder="<?php echo esc_html__('#12356-12','dwt-listing');?>" value="<?php echo esc_attr($listing_coupon_code); ?>">
                    </div>
                </div>
            </div>
    </div>        
     <div class="row">  
     
     <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label"><?php echo dwt_listing_text('dwt_listing_coupon_referral');?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-link"></i></span>
                      <input type="text" class="form-control" id="listing_coupon_referral" name="listing_coupon_referral"  value="<?php echo esc_attr($listing_coupon_referral); ?>">
                    </div>
                </div>
            </div>      
            
            
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label"><?php echo dwt_listing_text('dwt_listing_coupon_expiry_date');?></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-time"></i></span>
                        <input class="form-control" name="listing_coupon_exp" type="text" id="event_end" value="<?php echo esc_attr($listing_coupon_exp); ?>" />
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="form-group">
                    <label class="control-label"><?php echo dwt_listing_text('dwt_listing_coupon_desc');?></label>
                    <textarea class="form-control" maxlength="<?php echo dwt_listing_text('dwt_listing_coupon_desc_limit'); ?>" name="dwt_listing_coupon_desc" rows="3"><?php echo esc_textarea($listing_coupon_desc); ?></textarea>
                </div>
        </div>
    </div>
</div> 
<?php } ?>  
