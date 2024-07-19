<?php
	//Get cats
	$price_type	=	dwt_listing_categories_fetch('l_price_type' , 0 );
	if( count((array)  $price_type ) > 0 )
	{
?>
    <div class="listing-widget">
        <div class="form-group">
            <select data-placeholder="<?php echo esc_html__('Select Price Type','dwt-listing');?>" id="cost_range" name="l_price_type" class="allow_clear">
            <option value=""><?php echo esc_html__('Select an option','dwt-listing'); ?></option>
            <option value="all"><?php echo esc_html__('All Prices','dwt-listing'); ?></option>
            <?php
			$l_price_type = '';
			//selective
			if( isset( $_GET['l_price_type'] ) && $_GET['l_price_type'] != "" )
			{
				$l_price_type = $_GET['l_price_type'];
			}
			
            foreach( $price_type as $type )
            {
            ?>	
              <option <?php if ($type->term_id == $l_price_type) { ?>selected="selected"<?php } ?> value="<?php echo esc_attr( $type->term_id ); ?>"><?php echo esc_html( $type->name ); ?></option>
            <?php
            }
            ?>
           </select>
        </div>
    </div>
<?php
	}
?>