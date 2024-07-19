<?php global $dwt_listing_options;
$get_percentage = ''; $stars = '';
//getting listing status
if( dwt_listing_text('dwt_listing_review_enable_stars') == '1')
{
	if(isset($_GET['review_id']) && $_GET['review_id'] != "")
	{
		$listing_id = $_GET['review_id'];	
	}
	else
	{
		$listing_id	=	get_the_ID();
	}
	$listing_status = get_post_meta($listing_id,'dwt_listing_listing_status',true);
	$get_percentage = dwt_listing_fetch_reviews_average($listing_id);
	if(isset($get_percentage) && count((array)  $get_percentage['ratings']) > 0)
	{
?>
<div class="post-review">
    <div class="summary-review">
        <div class="text-summary">
            <h3><?php echo esc_attr($get_percentage['average']); ?> <?php echo esc_html__('average based on','dwt-listing') ?> (<?php echo esc_attr($get_percentage['rated_no_of_times']); ?>) <?php echo esc_html__('ratings','dwt-listing') ?>
           </h3>
        </div>
        <div class="final-rate collapsed" data-toggle="collapse" data-target="#review-box"> <i class="ti-angle-up"></i></div>
      
    </div>
    <div class="review-details collapse in"  id="review-box">
   <?php 
   $stars_title = '';
   $ad_ratings = array_reverse($get_percentage['ratings']);
    foreach($ad_ratings as $key=>$val)
    {
        $stars_title = ''; $stars = '';
        if($key == '5_star')
        {
            $stars_title .= esc_html__('5 stars','dwt-listing');
			$stars.= '<i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i>';
        }
        if($key == '4_star')
        {
            $stars_title .= esc_html__('4 stars','dwt-listing');
			$stars.= '<i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star"></i>';
        }
        if($key == '3_star')
        {
            $stars_title .= esc_html__('3 stars','dwt-listing');
			$stars.= '<i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
        }
        if($key == '2_star')
        {
            $stars_title .= esc_html__('2 stars','dwt-listing');
			$stars.= '<i class="fa fa-star color"></i><i class="fa fa-star color"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
        }
        if($key == '1_star')
        {
            $stars_title .= esc_html__('1 stars','dwt-listing');
			$stars.= '<i class="fa fa-star color"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
        }
		
		
    ?>
        <div class="progress-bar-review">
            <div class="col-sm-3 col-md-2"> <span class="progress-title"></span> <?php echo esc_attr($stars_title); ?> </div>
            <div class="col-sm-3 col-md-2">
            	<div class="review_rating_stars">
                 <?php echo ''.($stars); ?>
                </div>    
            </div>
            <div class="col-sm-4 col-md-7">
                <div class="progress">
                    <div class="progress-bar"> <span data-percent="<?php echo esc_attr($val); ?>"></span> </div>
                </div>
            </div>
            <div class="col-sm-2 col-md-1"> <span class="progress-title"><?php echo esc_attr($val); ?>%</span> </div>
        </div>
    <?php
    }
    ?>
     
    </div>
</div>
<?php
	}
}
?>