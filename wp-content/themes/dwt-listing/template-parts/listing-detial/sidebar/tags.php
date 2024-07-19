<?php global $dwt_listing_options;
//listing id
$link = $listing_tags = '';
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	$listing_id = $_GET['review_id'];	
}
else
{
	$listing_id	=	get_the_ID();
}
$listing_tags = get_the_terms($listing_id , 'l_tags');
if(!empty($listing_tags) && count((array) $listing_tags) > 0)
{
?>
<div class="widget">
 <div class="claim"> <a href="javascript:void(0)"> <img src="<?php echo esc_url(trailingslashit( get_template_directory_uri () ) . 'assets/images/icons/label.png'); ?>" alt="<?php echo esc_html__('Tags','dwt-listing'); ?>"><?php echo esc_html__('Tags','dwt-listing'); ?> </a> </div>
<div class="listing-tagcloud">
		<?php foreach($listing_tags as $tagz) {
			$link = get_term_link( $tagz->term_id );		
        ?>
        <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr( $tagz->name ); ?>">
            #<?php echo esc_attr( $tagz->name ); ?>
        </a>
    <?php } ?>
   </div>
</div>
<?php
}