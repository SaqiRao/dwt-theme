<?php
	 $listing_staus ='';
	 if( isset( $_GET['l_rating'] ) && $_GET['l_rating'] != "")
	 {
		$listing_staus = $_GET['l_rating'];	
 	 }
?>
    <div class="listing-widget">
        <div class="form-group">
            <select data-placeholder="<?php echo esc_html__('Rated As','dwt-listing');?>" name="l_rating" id="rated" class="allow_clear">
              <option value=""><?php echo esc_html__('Select an option','dwt-listing'); ?></option>
              <option value="high_rated" <?php if($listing_staus == 'high_rated'){ echo 'selected=selected';} ?>><?php echo esc_html__('High to Low','dwt-listing'); ?></option>
              <option value="low_rated" <?php if($listing_staus == 'low_rated'){ echo 'selected=selected';} ?>><?php echo esc_html__('Low to High','dwt-listing'); ?></option>
           </select>
        </div>
    </div>