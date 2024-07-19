<?php
 /* Template Name: All Reviews */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */
?>
<?php get_header();?>
<?php
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];
?>
<section class="single-post pt30">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="all-review-listing">
                    <div class="list-heading">
                        <h2><?php echo get_the_title($listing_id); ?> <?php echo dwt_listing_is_listing_featured($listing_id); ?></h2>
                    </div>
                    <div class="list-meta">
                        <?php get_template_part( 'template-parts/listing-detial/listing-meta/listing','meta'); ?>
                    </div>
                </div>
                <?php get_template_part( 'template-parts/listing-detial/reviews/reviews-score/score'); ?>     
                <?php get_template_part( 'template-parts/listing-detial/reviews/user-reviews/fetch'); ?>                                
				<?php get_template_part( 'template-parts/listing-detial/reviews/comment-form/form'); ?>
            </div>
                 <div class="col-md-4 col-sm-12 col-xs-12">
                 		<?php get_template_part( 'template-parts/listing-detial/sidebar/sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
else
{
?>
<section class="single-post pt30">
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">	
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        </div>
    </div>
 </div>
</section>
<?php     
}
?>
<?php get_footer(); ?>