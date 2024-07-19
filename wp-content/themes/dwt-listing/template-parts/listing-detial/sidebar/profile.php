<?php
global $dwt_listing_options;
//listing id
$get_brand_img = $profile_url = $get_user_dp = '';
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
   $listing_id = get_the_ID();
}
$profile_url = dwt_listing_listing_owner($listing_id, 'url');
 $brands_logos = get_post_meta($listing_id, 'dwt_listing_brand_img' , true);
 $user_logo   = "";
 if($brands_logos != ""){
  $get_brand_logo = wp_get_attachment_image_src($brands_logos);
  $user_logo  =   isset( $get_brand_logo [0])  ?  $get_brand_logo [0]  : ""; 
}
if($user_logo == ""){
  $get_user_dp = dwt_listing_listing_owner($listing_id, 'dp');
}
else {
  $get_user_dp   =  $user_logo ;
}

  // brand name
  $brands_name = get_post_meta($listing_id, 'dwt_listing_brand_name' , true);

 


if (get_post_meta($listing_id, 'dwt_listing_brand_name', true) != "") {
    $get_brand_img = dwt_listing_get_brand_img($listing_id, 'dwt_listing_list-view1');
  
    ?>
    <div class="contact-box">
        <div class="contact-img">
            <a href="javascript:void(0)"><img src="<?php echo esc_url($get_brand_img); ?>"
                                              class="img-circle img-responsive"
                                              alt="<?php echo esc_html__('not found', 'dwt-listing'); ?>"></a>
        </div>
        <div class="contact-caption">
            <h4>
                <a href="javascript:void(0)"><?php echo esc_attr(get_post_meta($listing_id, 'dwt_listing_brand_name', true)); ?></a>
            </h4>
            <?php if (get_post_meta($listing_id, 'dwt_listing_listing_street', true) != "") { ?>
                <span>
                <p class="street-adr"><i
                            class="ti-location-pin"></i> <?php echo get_post_meta($listing_id, 'dwt_listing_listing_street', true); ?></p>
                </span><?php } ?>
        </div>
    </div>
    <?php
    get_template_part('template-parts/listing-detial/sidebar/tabs/listing', 'tabs2');
} else {
    echo apply_filters('profile_info_filter', $listing_id, $profile_url, $get_user_dp);
    get_template_part('template-parts/listing-detial/sidebar/tabs/listing', 'tabs');
}