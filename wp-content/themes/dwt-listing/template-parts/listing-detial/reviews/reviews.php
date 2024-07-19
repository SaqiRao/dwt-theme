<?php global $dwt_listing_options;
$listing_id	=	get_the_ID();
if( get_post_status( $listing_id ) == 'publish' && get_post_meta($listing_id,'dwt_listing_listing_status',true) == 1) { ?>
<?php get_template_part( 'template-parts/listing-detial/reviews/reviews-score/score'); ?> 
<?php get_template_part( 'template-parts/listing-detial/reviews/user-reviews/fetch'); ?>                                
<?php get_template_part( 'template-parts/listing-detial/reviews/comment-form/form'); ?>
<?php }