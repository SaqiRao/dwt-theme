<?php global $listing_comparison_variable;?>
<div class="mw-breads white-bg">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url( '/' )); ?>"><i class="fa fa-home"></i> <?php echo esc_html__('Home','dwt-listing'); ?></a></li>
				  <li class="breadcrumb-item active" aria-current="page"><?php echo esc_html__('Comparison','dwt-listing'); ?></li>
				</ol>			
			</div>	
		</div>
	</div>	
</div>
<section class="section-padding single-comparison light-bg">
   <div class="container">
    <div class="row sec-heading-zone">
        <div class="col ">
            <div class="sec-heading ">
                <p><?php //echo $listing_comparison_variable('mw_compare_tagline'); ?></p>
                <h2><?php //echo $listing_comparison_variable('mw_compare_heading'); ?></h2>
            </div>
        </div>
    </div>
      <div class="row">
          <div class="col-xl-12 col-12">
                <div class="compare-table table-responsive">
                   <table>
                      <tbody>
                         <tr class="no-stripe ">
                             <th><?php echo esc_html__('Specifications','dwt-listing'); ?></th>
                             <?php echo dwt_params($img_link); ?>

                         </tr>
						  <tr>
                            <th><?php echo esc_html($localization['make']); ?></th>
                            <?php echo dwt_params($category); ?>
                         </tr>
						  <tr>
                            <th><?php echo esc_html($localization['mileage']); ?></th>
                            <?php echo dwt_params($mileage); ?>
                         </tr>
                           <tr>
                            <th><?php echo esc_html($localization['engine']); ?></th>
                            <?php echo dwt_params($enginesize); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['bodytype']); ?></th>
                            <?php echo dwt_params($bodytype); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['fuel']); ?></th>
                            <?php echo dwt_params($fueltype); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['stock']); ?></th>
                            <?php echo dwt_params($stock_id); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['transmission']); ?></th>
                            <?php echo dwt_params($my_trans); ?>
                         </tr>
                          <tr>
                            <th><?php echo esc_html($localization['drive']); ?></th>
                            <?php echo dwt_params($my_drive); ?>
                         </tr>
                          
						  
                         
                         <tr class="other-features">
                            <th><?php echo esc_html__('Other Features','dwt-listing'); ?></th>
                                <?php echo dwt_params($features_html); ?>
                         </tr>
                      </tbody>
                   </table>
                </div>
          </div>
      </div>
   </div>
</section>