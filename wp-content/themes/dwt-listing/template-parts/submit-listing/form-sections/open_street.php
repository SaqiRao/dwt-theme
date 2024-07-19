<?php
if (isset($dwt_listing_options['dwt_listing_enable_long_lat']) && $dwt_listing_options['dwt_listing_enable_long_lat'] == 1) {
  ?> 
<div class="col-md-6 col-xs-12 col-sm-6 l_latt_form">
    <div class="form-group">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_lati'); ?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_latt" name="listing_lat" title="<?php echo dwt_listing_text('dwt_listing_list_lati_tool'); ?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>" value="<?php echo esc_attr($listing_lattitude); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<div class="col-md-6 col-xs-12 col-sm-6 l_long_form">
    <div class="form-group">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_longi'); ?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_long" name="listing_long" title="<?php echo dwt_listing_text('dwt_listing_list_longi_tool'); ?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>" value="<?php echo esc_attr($listing_longitide); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<?php }else{
?>
<div class="col-md-6 col-xs-12 col-sm-6 l_latt_form">
    <div class="form-group no_long_lat">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_lati'); ?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_latt" name="listing_lat" title="<?php echo dwt_listing_text('dwt_listing_list_lati_tool'); ?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place'); ?>" value="<?php echo esc_attr($listing_lattitude); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<div class="col-md-6 col-xs-12 col-sm-6 l_long_form">
    <div class="form-group no_long_lat">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_longi'); ?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_long" name="listing_long" title="<?php echo dwt_listing_text('dwt_listing_list_longi_tool'); ?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place'); ?>" value="<?php echo esc_attr($listing_longitide); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<?php
}
?>
<div  class="col-md-12 col-xs-12 col-sm-12 l_map_form">
  <div class="submit-post-img-container">
    <div id="submit-map-open"></div>
  </div>
</div>