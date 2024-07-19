<?php
global $dwt_listing_options;
?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="footer-content text-center">
          <div class="footer-logo"> <?php echo dwt_listing_footer_logo(); ?> </div>
          <ul class="social-media"><?php echo dwt_listing_social_icons("dwt_listing_footer-social-media"); ?></ul>
          <div class="copyright">
            <?php echo dwt_listing_footer_copyrights(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
