<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); 
?>
<section class="dwt_listing_shop-container">
            <div class="container">
               <!-- Row -->
               <div class="row">
                  <!-- Middle Content Area -->
                    <div class="col-md-8 col-sm-12 col-xs-12  products nopadding">
                    <?php 
					if(dwt_listing_text('show_banners_on_product') == 1)
					{ 
					?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<?php if (isset($dwt_listing_options['opt-slides-do']) && !empty($dwt_listing_options['opt-slides-do'])){ ?>
                                <div class="shop-banner-slider owl-carousel owl-theme">
                                <?php 
									foreach($dwt_listing_options['opt-slides-do'] as $get_data){?>
                                    <div class="item">
                                        <a href="<?php echo esc_url($get_data['url']); ?>"><img class="img-responsive" alt="<?php echo esc_attr('image not found','dwt-listing'); ?>" src="<?php echo esc_url($get_data['image']); ?>"></a>
                                    </div>
                                    <?php } ?>
                                </div> 
                            <?php } ?>    
                        </div> 
                        <div class="clearfix"></div>
                    <?php }
					
						do_action( 'woocommerce_archive_description' );
					 ?>
                    
                    <?php if ( wc_get_loop_prop( 'total' ) ) { ?>
					<?php if ( have_posts() ) : ?>
                     <div class="clearfix"></div>
                    	<div class="dwt_listing_woo-filters">
                        	<div class="col-md-12 col-xs-12 col-sm-12">
								<?php do_action( 'woocommerce_before_shop_loop' ); ?>
                            </div>
                        </div>
                         <div class="clearfix"></div>
                        <div class="masonry_container">
                        <div class="masonery_wrap">
                        <?php 
						 $fetch_products ='';
						 $productz	=	 new dwt_listing_products_shop();
						 $layout_type = 'shop_grid';
						  while ( have_posts() ) : the_post();
						    $product_id	=	get_the_ID();
                            $product_type	=	wc_get_product( $product_id);
							$function	=	"dwt_listing_shop_listings_$layout_type";
						    echo ''. $fetch_products	= $productz->$function($product_id,'4');
                         ?>
                        <?php endwhile; // end of the loop. ?>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                    		<?php echo dwt_listing_pagination(); ?>
                        </div>
                        </div>
					  <?php endif; ?>
                      <?php } else {
						get_template_part( 'template-parts/content', 'none' );  
					   } ?>
                  </div>
                  <?php echo get_sidebar('shop'); ?>
               </div>
               </div>
            </div>
            <!-- Main Container End -->
         </section>
<?php get_footer(); ?>