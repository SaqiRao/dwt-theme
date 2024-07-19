<?php
// Password Reset Html	
if( isset( $_GET['token'] ) && $_GET['token'] != "" && !is_user_logged_in() ):?>
<!-- Forget Password Model -->
<div class="modal login  fade" id="dwt_listing_reset_password_modal" tabindex="-1" role="dialog" aria-labelledby="dwt_listing_reset_password_modal" aria-hidden="true">
  <div class="modal-dialog login  animated">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo esc_html__( 'Set your Password','dwt-listing' ) ?></h4>
        </div>
        <div class="modal-body">  
            <div class="box">
                 <div class="content">
                    <div class="form loginBox">
                        <div id="token-expire" class="alert custom-alert custom-alert--danger none" role="alert">
          			<div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
            <div class="custom-alert__body">
              <h6 class="custom-alert__heading">
               <?php echo esc_html__('Token Expired!', 'dwt-listing'); ?>
              </h6>
              <div class="custom-alert__content">
                <?php echo esc_html__("The security token included in the request is expired.", 'dwt-listing'); ?>
              </div>
            </div>
          </div>
        		</div>
                
                        <div id="password-success" class="alert custom-alert custom-alert--success none" role="alert">
          			<div class="custom-alert__top-side">
            <span class="alert-icon custom-alert__icon  ti-face-smile "></span>
            <div class="custom-alert__body">
              <h6 class="custom-alert__heading">
               <?php echo esc_html__(' Congratulation!', 'dwt-listing'); ?>
              </h6>
              <div class="custom-alert__content">
                <?php echo esc_html__("Your Password Changed successfully.", 'dwt-listing'); ?>
              </div>
            </div>
          </div>
        		</div>
                
                    
                        <form method="post" id="dwt_listing_reset-password-form" data-disable="false">
                        
                        <div class="form-group has-feedback">
                        	<input  name="dwt_listing_new_password" id="dwt_listing_new_password" class="form-control" type="password" placeholder="<?php echo esc_attr__("Enter Your New Password", 'dwt-listing'); ?>"   required>
                             <div class="with-errors"></div>
                        </div>
                        
                        <div class="form-group has-feedback">
                        	<input  name="dwt_listing_confirm_new_password" id="dwt_listing_confirm_new_password" class="form-control" type="password" placeholder="<?php echo esc_attr__("Confirm New Password", 'dwt-listing'); ?>" data-match="#dwt_listing_new_password" data-match-error="<?php echo esc_html__("Whoops, these don't match", 'dwt-listing'); ?>"  required>
                             <div class="with-errors"></div>
                        </div>
                        
                        <input type="hidden" name="token" value="<?php echo ''.$_GET['token']; ?>" />
                      
                        <button type="submit" class="btn btn-theme sonu-button  btn-block"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Change My Password", 'dwt-listing'); ?></button>
                        </form>
                    </div>
                 </div>
            </div>
            
        </div>
        <div class="modal-footer"></div>        
      </div>
  </div>
</div>
<?php endif;
// Email verificatioon	
if( isset( $_GET['verification_key'] ) && $_GET['verification_key'] != "" && !is_user_logged_in()  )
{
	function dwt_listing_load_modal()
	{
    	echo '<script>$( document ).ready(function(){$("#myModal").modal("show");});</script>';
	}
	add_action( 'wp_footer', 'dwt_listing_load_modal', 111 );
}

?>
 