<?php global $dwt_listing_options;
 $listing_id	=	get_the_ID();
if( get_post_meta($listing_id, 'dwt_listing_listing_video', true ) != "" )
{
	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($listing_id, 'dwt_listing_listing_video', true ), $match);
	if( isset( $match[1] ) && $match[1] != "" )
	{
		$video_id = $match[1];
		$iframe = 'iframe';
		echo '<div class="listing-detial-video"><h3> '.dwt_listing_text('dl_video').' </h3>';
		echo '<'.$iframe.' width="700" height="370" src="https://www.youtube.com/embed/'. esc_attr( $video_id ) . '" allowfullscreen></'.$iframe.'></div>'; 
	}
}
?>