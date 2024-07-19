<?php global $dwt_listing_options;
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
if( get_post_meta($listing_id, 'dwt_listing_listing_video', true ) != "" )
{
	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($listing_id, 'dwt_listing_listing_video', true ), $match);
	if( isset( $match[1] ) && $match[1] != "" )
	{
		$video_id = $match[1];
	?>
    <div class="panel panel-default" id="dlisting-video">
        <div class="panel-heading" role="tab" id="d_list_video">
          <h4 class="panel-title"> <a  href="javascript:void(0)"><i class="   ti-video-camera    "></i> <?php echo dwt_listing_text('dl_video'); ?> </a> </h4>
        </div>
        <div id="d-video-coll" class="panel-collapse" role="tabpanel" aria-labelledby="d_list_video">
          <div class="panel-body">
            <iframe width="700" height="370" src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" allowfullscreen></iframe>
          </div>
        </div>
    </div>
        <?php
	}
}