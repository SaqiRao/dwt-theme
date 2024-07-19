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
<section class="page-header-area-2 gray">
 <div class="container">
    <div class="row">
       <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="small-breadcrumb">
             <div class="breadcrumb-link">
                <ul>
                    <li>                       
                        <a href="<?php echo home_url( '/' ); ?>"><?php echo esc_html__('Home', 'dwt-listing' ); ?> </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0)" class="active"> <?php echo dwt_listing_page_breadcrumb(); ?></a>
                    </li>
               </ul>
             </div>
			  <div class="header-page">
                  <h1> <?php echo dwt_listing_bread_crumb_heading(); ?></h1>
             </div>
          </div>
       </div>
    </div>
 </div>
</section>