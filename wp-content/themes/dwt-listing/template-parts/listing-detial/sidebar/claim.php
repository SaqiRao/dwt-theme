<?php
global $dwt_listing_options;
//listing id
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<?php
if (dwt_listing_text('dwt_listing_is_claim') == '1') {
    ?>
    <div class="widget">	

        <?php
        if (get_post_meta($listing_id, 'dwt_listing_is_claimed', true) != '' && get_post_meta($listing_id, 'dwt_listing_is_claimed', true) == '1') {
            ?>
            <div class="claim"> <a href="javascript:void(0)"> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/checked.png'); ?>" alt="<?php echo esc_html__('Claimed', 'dwt-listing'); ?>"><?php echo esc_html__('Claimed', 'dwt-listing'); ?> </a> </div>
            <?php
        } else {
            ?>
            <?php
            if (is_user_logged_in()) {
                ?>
                <div class="claim"> <a href="javascript:void(0)" data-toggle="modal" data-target=".claim-now"> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/medal.png'); ?>" alt="<?php echo esc_html__('Claim Now', 'dwt-listing'); ?>"><?php echo esc_html__('Claim Now', 'dwt-listing'); ?> <i class="ti-angle-right pull-right"></i></a></div>
                <?php
            } else {
                ?> 
                <div class="claim"> <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/medal.png'); ?>" alt="<?php echo esc_html__('Claim Now', 'dwt-listing'); ?>"><?php echo esc_html__('Claim Now', 'dwt-listing'); ?> <i class="ti-angle-right pull-right"></i></a> </div>
                        <?php
                    }
                }
                ?>
    </div>  
    <?php
}