<?php
global $dwt_listing_options;
$listing_id = get_the_ID();
$user_id = get_current_user_id();
// Edit Listing
if($user_id != 0 && $user_id!= ''){

if (get_post_field('post_author', $listing_id) == get_current_user_id() || is_super_admin(get_current_user_id())) {
    ?>
    <div class="sticky-button-edit">
        <?php
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '<a href="javascript:void(0)" class="tool-tip" title=" ' . esc_html__('Edit Disable for Demo', 'dwt-listing') . '"><i class="ti-pencil-alt"></i></a>';
        } else {
            $listing_update_url = '';
            $listing_update_url = dwt_listing_set_url_params_multi(dwt_listing_pagelink('dwt_listing_header-page'), array('listing_id'=> $listing_id));
            ?>  
            <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>" class="tool-tip" title="<?php echo esc_html__('Edit Listing', 'dwt-listing'); ?>"> <i class="ti-pencil-alt"></i></a>
            <?php } ?>
    </div>
    <?php
}
}
?>