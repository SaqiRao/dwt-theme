<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dwt listing
 */

?>
<div class="alert custom-alert custom-alert--warning" role="alert">
  <div class="custom-alert__top-side">
    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
    <div class="custom-alert__body">
      <h6 class="custom-alert__heading">
       <?php echo esc_html__('No Invoice Found.', 'dwt-listing'); ?>
      </h6>
      <div class="custom-alert__content">
        <?php echo esc_html__("Sorry! There is no invoice generated yet!", 'dwt-listing'); ?>
      </div>
    </div>
  </div>
</div>