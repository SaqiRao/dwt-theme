<?php global $dwt_listing_options;
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	 $listing_id = $_GET['review_id'];	
}
else
{
	 $listing_id	=	get_the_ID();
}
if(is_singular( 'listing' ))
{
	dwt_listing_feature_listign_expiry_checker($listing_id);
}
?>
<div class="transparent-breadcrumb-listing elegent-bread"></div>