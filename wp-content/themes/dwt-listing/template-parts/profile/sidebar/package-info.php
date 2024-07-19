<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$uid = $profile->user_info->ID;
if (isset($dwt_listing_options['dwt_listing_show_pkg']) && $dwt_listing_options['dwt_listing_show_pkg'] == "1") {
    ?>  
    <?php
    if (get_user_meta($uid, 'd_user_package_id', true) != "") {
        $package_id = get_user_meta($uid, 'd_user_package_id', true);
        ?>
        <div class="profile-packages-section">
            <h4><?php echo esc_html__('Your Plan:', 'dwt-listing'); ?></h4>
            <div class="plan-detail">
                <p><?php echo esc_html__('You are on', 'dwt-listing'); ?> <b> <?php echo get_the_title($package_id); ?></b>.<?php echo esc_html__(' Upgrade your plan if desired.', 'dwt-listing'); ?> </p>
                <?php
                if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                    echo '<button type="button" class="btn btn-theme tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('View Package Detail', 'dwt-listing') . ' </button>';
                } else {
                    ?>
                    <a href="<?php echo dwt_listing_pagelink('dwt_listing_packages'); ?>" class="btn btn-theme"><?php echo esc_html__('View Package Detail', 'dwt-listing'); ?></a>
                <?php } ?>
            </div>
        </div>
                <?php
            } else {
                ?>
        <div class="profile-packages-section">
            <h4><?php echo esc_html__('No Plan Selected', 'dwt-listing'); ?></h4>
            <div class="plan-detail">
                <p><?php echo esc_html__("Currenty you don't have any package. Upgrade your plan if desired.", 'dwt-listing'); ?></p>
        <?php
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '<button type="button" class="btn btn-theme tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Select Your Package', 'dwt-listing') . ' </button>';
        } else {
            ?>
                    <a href="<?php echo dwt_listing_pagelink('dwt_listing_packages'); ?>" class="btn btn-theme"><?php echo esc_html__('Select Your Package', 'dwt-listing'); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
                <?php
            }
            ?>
            <?php
        }
        ?>
<div class="profile-packages-section white">
    <h4><?php echo esc_html__('Account Deletion', 'dwt-listing'); ?></h4>
    <div class="plan-detail">
        <p><?php echo esc_html__("If you want to delete your account your all data will be removed from this site.", 'dwt-listing'); ?>
        </p>
<?php
if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
    echo '<button type="button" class="btn btn-warning tool-tip" title="' . esc_html__('Disable for Demo', 'dwt-listing') . '" disabled> ' . esc_html__('Delete My Account', 'dwt-listing') . ' </button>';
} else {
    ?>	
            <a href="javascript:void(0)" data-userid="<?php echo esc_attr($uid); ?>" class="delete-my-account btn btn-warning sonu-button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__('Delete My Account', 'dwt-listing'); ?></a>    
    <?php
}
?>
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
    </div>
</div>