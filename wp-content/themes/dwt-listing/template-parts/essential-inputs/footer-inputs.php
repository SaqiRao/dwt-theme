<?php 
global $dwt_listing_options;
if (in_array('dwt_listing_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))):
    ?>
    <input type="hidden" id="dwt_listing_ajax_url" value="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" />
    <input type="hidden" id="theme_path" value="<?php echo trailingslashit(get_template_directory_uri()); ?>" />
    <input type="hidden" id="map_lat" value="<?php echo dwt_listing_text('dwt_listing_default_lat'); ?>" />
    <input type="hidden" id="map_long" value="<?php echo dwt_listing_text('dwt_listing_default_long'); ?>" />
    <input type="hidden" id="no_s_result" value="<?php echo esc_html__("no result for ", "dwt-listing"); ?>" />
    <?php if (dwt_listing_text('dwt_listing_enable_geo') == '1') { ?>
        <input type="hidden" id="ip_type" value="<?php echo dwt_listing_text('dwt_geo_api_settings'); ?>" />
    <?php } ?>
    <?php if (is_rtl()) { ?>
        <input type="hidden" id="is_rtl" value="1" />
    <?php } else { ?>
        <input type="hidden" id="is_rtl" value="0" />
    <?php } ?>
    <?php
    if (isset($dwt_listing_options['dwt_listing_profile-page']) && $dwt_listing_options['dwt_listing_profile-page'] != ""):
        ?>
        <?php
        /* == fazal == */
        /* set the url when we use ?/'listing-type=profile-update' here */
        $listing_update_url = '';
        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink($dwt_listing_options['dwt_listing_profile-page']), array('listing-type' => 'profile-update'));
        ?>
        <input type="hidden" id="profile_page" value="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>" />
    <?php endif; ?>
    <?php
    if (isset($dwt_listing_options['fb_api_key']) && $dwt_listing_options['fb_api_key'] != "") {
        echo '<input type="hidden" id="facebook_key" value="' . esc_attr($dwt_listing_options['fb_api_key']) . '" />';
    }
    if (isset($dwt_listing_options['gmail_api_key']) && $dwt_listing_options['gmail_api_key'] != "") {
        echo '<input type="hidden" id="google_key" value="' . esc_attr($dwt_listing_options['gmail_api_key']) . '" />';
    }
    if (isset($dwt_listing_options['redirect_uri']) && $dwt_listing_options['redirect_uri'] != "") {
        echo '<input type="hidden" id="redirect_uri" value="' . esc_attr($dwt_listing_options['redirect_uri']) . '" />';
    }
    if (isset($dwt_listing_options['dwt_listing_enable_leads']) && $dwt_listing_options['dwt_listing_enable_leads'] == true) {
        echo '<input type="hidden" id="is_tracking_on" value="' . esc_attr($dwt_listing_options['dwt_listing_enable_leads']) . '" />';
    }
    ?>
<?php endif; ?>