<?php
	 $listing_staus ='';
	 if( isset( $_GET['l_listing_status'] ) && $_GET['l_listing_status'] != "")
	 {
		$listing_staus = $_GET['l_listing_status'];	
 	 }
?>
    <div class="listing-widget">
        <div class="form-group">
            <select data-placeholder="<?php echo esc_html__('Open or Closed','dwt-listing');?>" id="listing_status" name="l_listing_status" class="allow_clear">
              <option value=""><?php echo esc_html__('Select an option','dwt-listing'); ?></option>
              <option value="all" <?php if($listing_staus == 'all'){ echo 'selected=selected';} ?>><?php echo esc_html__('All','dwt-listing'); ?></option>
              <option value="opened" <?php if($listing_staus == 'opened'){ echo 'selected=selected';} ?>><?php echo esc_html__('Open','dwt-listing'); ?></option>
           </select>
        </div>
    </div>