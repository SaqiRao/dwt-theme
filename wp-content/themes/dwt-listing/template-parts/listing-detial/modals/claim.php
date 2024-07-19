<?php global $dwt_listing_options;
$listing_id = '';$fetch_profile = '';$user_id =''; $user_email =''; $user_contact =''; $user_name ='';
//listing id
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
$fetch_profile	= new dwt_listing_profile();
$user_id	=	$fetch_profile->user_info->ID;
$user_name	=	$fetch_profile->user_info->display_name;
$user_contact	=	$fetch_profile->user_info->d_user_contact;
?>
<!-- Claim Modal -->
<div class="modal fade claim-now"  tabindex="-1" role="dialog">
  <div class="modal-dialog login animated">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"> <?php echo esc_html__("Claim Listing", 'dwt-listing'); ?></h4>
        </div>
        <div class="modal-body">  
            <div class="box">
                <div class="content">
                 <div class="form">
                    <form method="post" id="claim-form" data-disable="false">
                    
                    <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Your Name','dwt-listing');?><span>*</span></label>
                                    <input type="text" class="form-control" name="claimer_name" placeholder="<?php echo esc_html__('Your name','dwt-listing');?>" value="<?php echo esc_attr($user_name); ?>" required>
                                    <div class="help-block"></div>
                                </div>
                    

					<div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Contact Number','dwt-listing');?><span>*</span></label>
                                    <input type="number" class="form-control" name="claimer_contact" placeholder="<?php echo esc_html__('Phone number or mobile number','dwt-listing');?>" value="<?php echo esc_attr($user_contact); ?>" required>
                                    <div class="help-block"></div>
                                </div>
                    
                    <div class="form-group">
                                    <label class="control-label"><?php echo esc_html__('Additional Proof','dwt-listing');?><span>*</span></label>
                                    <textarea cols="6" name="claimer_message" rows="6" placeholder="<?php echo esc_html__('Additional proof to expedite your claim approval...','dwt-listing');?>" class="form-control" required></textarea>
                                </div>            
                               <input type="hidden" name="claim_listing_id" id="claim_listing_id" value="<?php echo esc_attr($listing_id); ?>">                               <input type="hidden" name="claimer_id" id="claimer_id" value="<?php echo esc_attr($user_id); ?>">  
                    <button type="submit" class="btn btn-theme sonu-button-<?php echo esc_attr($listing_id); ?>"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing", 'dwt-listing'); ?>"><?php echo esc_html__("Claim Your Business Now", 'dwt-listing'); ?></button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
                
      </div>
  </div>
</div>