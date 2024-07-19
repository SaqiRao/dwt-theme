<?php global $dwt_listing_options;
	 $event_id	=	get_the_ID();
	 $media	=	 dwt_listing_fetch_event_gallery($event_id);
?>
<?php if( count((array)  $media ) > 0 ){?>
	<div class="row">
<div class="col-md-12 col-xs-12 col-sm-12">
	<div class="single-event-detials cards">
		<div class="owl-wrapper">
			<div class="event-images-loop owl-carousel owl-theme">
			<?php	
			foreach( $media as $m )
			{
				$mid	=	'';
				if ( isset( $m->ID ) )
				{
					$mid	= 	$m->ID;
				}
				else
				{
					$mid	=	$m;
				}
				$full_img  = wp_get_attachment_image_src($mid, 'full');
				$thumb_imgs  = wp_get_attachment_image_src($mid, 'dwt_listing_single-event');
			?>
				<article class="event-images-card">
					<div class="event-loop-content">
					 <span><img class="img-responsive" src="<?php echo esc_url($thumb_imgs[0]); ?>" alt="<?php echo get_the_title($event_id); ?>"></span>
					</div>
				</article>
			<?php
			}
			?>
			</div>
		</div>
	</div>
</div>
</div>
<?php } 