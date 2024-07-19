<div class="col-md-6 col-xs-12 col-sm-6 l_latt_form">
    <div class="form-group">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_lati');?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_latt" name="listing_lat" title="<?php echo dwt_listing_text('dwt_listing_list_lati_tool');?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_lati_place');?>" value="<?php echo esc_attr($listing_lattitude); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<div class="col-md-6 col-xs-12 col-sm-6 l_long_form">
    <div class="form-group">
        <label class="control-label"><?php echo dwt_listing_text('dwt_listing_list_longi');?></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="ti-map-alt"></i></span>
          <input type="text" class="form-control tool-tip" id="d_long" name="listing_long" title="<?php echo dwt_listing_text('dwt_listing_list_longi_tool');?>" placeholder="<?php echo dwt_listing_text('dwt_listing_list_longi_place');?>" value="<?php echo esc_attr($listing_longitide); ?>">
        </div>
        <div class="help-block"></div>
    </div>
</div>
<div  class="col-md-12 col-xs-12 col-sm-12 l_map_form">
  <div class="submit-post-img-container">
  <span class="my-loc">
    <a href="javascript:void(0)" class="my-current-location" id="" title="<?php echo esc_html__('You Current Location','dwt_listing'); ?>"><i class="fa fa-crosshairs"></i></a>
  </span>
    <div id="submit-listing-map"></div>
  </div>
</div>