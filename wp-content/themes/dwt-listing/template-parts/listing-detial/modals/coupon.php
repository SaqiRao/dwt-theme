<?php global $dwt_listing_options;
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
if(dwt_listing_check_coupon_expiry($listing_id) == '1')
{
	$listing_coupon_code	= $listing_coupon_referral	 = $listing_coupon_desc	= $listing_coupon_exp	= '';
	$listing_coupon_code	= get_post_meta($listing_id, 'dwt_listing_coupon_code', true);
	$listing_coupon_desc	= get_post_meta($listing_id, 'dwt_listing_coupon_desc', true);
	$listing_coupon_referral	= get_post_meta($listing_id, 'dwt_listing_coupon_refer', true);
	$listing_coupon_exp	= get_post_meta($listing_id, 'dwt_listing_coupon_expiry', true);
	$readable_time = new DateTime($listing_coupon_exp);
?>	
<div class="dwt_listing_modal-copun modal fade dwt_listing_coupon-deal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="ti-close"></i></span> </button>
                  <div class="dwt_listing_coupon-model-content">
                     <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                           <h2><?php echo get_the_title($listing_id); ?></h2>
                           <?php if($listing_coupon_desc != '') { ?>
                           <p><?php echo esc_attr($listing_coupon_desc); ?></p>
                           <?php } ?>
                        </div>
                     <div class="row">
                           <div class="col-sm-12 col-xs-12 col-md-12">
                             <h5 class="text-center text-uppercase text-muted"><?php echo esc_html__('Click below to get your coupon code','dwt-listing'); ?></h5>
                         </div>
                       <?php if ($listing_coupon_code !="") { ?> 
                       <div class="col-sm-12 col-xs-12 col-md-12"> 
                        <div class="hidden-code text-center">
                      <button data-copy="<?php echo esc_attr($listing_coupon_code); ?>" class="coupon-code js-tooltip js-copy coupon-clipboard" type="button"  data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html__('Copy to clipboard','dwt-listing'); ?>"><?php echo esc_attr($listing_coupon_code); ?></button>
                        <small><?php echo esc_html__('Click to Copy','dwt-listing'); ?></small>
                        </div>
                        </div>
                       <?php } ?> 
                     </div>
                       <div class="row">
                           <div class="col-sm-12 col-xs-12 col-md-12 valid-until text-center">
                              <p><?php echo esc_html__('Valid Till','dwt-listing'); ?> : <span><?php echo esc_attr($readable_time->format('dS M, Y'));?></span></p>
                           </div>
                           <?php if(dwt_listing_text('dwt_listing_coupon_admin_note') == '1' && dwt_listing_text('dwt_listing_coupon_admin_note_desc') !="") {  ?>
                            <div class="col-sm-12 col-xs-12 col-md-12 text-center admin-note">
                               <p> <strong><?php echo esc_html__('Note','dwt-listing'); ?>: </strong><?php echo dwt_listing_text('dwt_listing_coupon_admin_note_desc'); ?> </p>
                            </div>   
                            <?php } ?>                       
                        </div>
                     </div>
                  </div>
                  <?php if ($listing_coupon_referral !="") { ?> 
                    <div class="modal-footer">
                       <div class="row">
                           <div class="col-sm-12 col-xs-12 col-md-12">
                              <div class="report">
                              	<a target="_blank" href="<?php echo esc_url($listing_coupon_referral); ?>"><?php echo esc_html__('Visit Referral Link','dwt-listing'); ?></a>
                           </div>
                        </div>
      				</div>
               </div>
                  <?php } ?> 
              </div>
              </div>
			</div>
<?php
}