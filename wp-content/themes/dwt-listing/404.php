<?php get_header(); ?>
<section class="error-page-section">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2  col-sm-offset-2">
                     	<div class="error-404">
                        	<h2> <?php echo esc_html__( '404', 'dwt-listing' ); ?> </h2>
                            <h4> <?php echo esc_html__( 'Oops! Page Not Found', 'dwt-listing' ); ?></h4>
                            <p><?php echo esc_html__( "We're sorry, but the page you were looking for doesn't exist.", 'dwt-listing' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-theme"><?php echo esc_html__( 'Go to Home', 'dwt-listing' ); ?></a>
                        </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
<?php get_footer(); ?>