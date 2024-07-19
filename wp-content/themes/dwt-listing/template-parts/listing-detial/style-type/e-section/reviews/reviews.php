<?php global $dwt_listing_options;
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
if( get_post_status( $listing_id ) == 'publish' && get_post_meta($listing_id,'dwt_listing_listing_status',true) == 1) { ?>
<div class="panel panel-default" id="d-comments">
<div class="panel-heading" role="tab" id="d-reviews">
  <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="  ti-comment-alt  "></i> <?php echo esc_html__('Reviews','dwt-listing'); ?> </a> </h4>
</div>
<div class="panel-collapse">
  <div class="panel-body">
    <?php get_template_part( 'template-parts/listing-detial/style-type/e-section/reviews/reviews-score/score'); ?> 
    <?php get_template_part( 'template-parts/listing-detial/style-type/e-section/reviews/user-reviews/fetch'); ?>                                
    <?php get_template_part( 'template-parts/listing-detial/style-type/e-section/reviews/comment-form/form'); ?>
  </div>
</div>
</div>
<?php } ?>