<?php global $dwt_listing_options;?>   
 <div class="col-sm-8 col-md-8 col-xs-12">
        <div class="ft-left">
          <div class="footer-img"><?php echo dwt_listing_footer_logo(); ?></div>
          <p><?php echo dwt_listing_themeOptions("dwt_listing_footer-text"); ?></p>
          <div class="social-icons">
            <span class="text"><?php echo esc_html__("Follow Us:", "dwt-listing"); ?></span>
            <ul class="social"><?php echo dwt_listing_social_icons("dwt_listing_footer-social-media"); ?></ul>
        </div>
          <?php echo dwt_listing_footer_copyrights(); ?>
        </div>
      </div>