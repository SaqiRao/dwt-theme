<?php
global $dwt_listing_options;
$user_id = get_query_var('author');
$slug = get_author_posts_url($user_id);
$html_class = 'dashboard';
if (dwt_listing_text('dwt_listing_header-layout') == '2' || dwt_listing_text('dwt_listing_header-layout') == '3') {
    $html_class = 'dashboard theme-padding';
}
$package_id = get_user_meta($user_id, 'd_user_package_id', true);
$create_event = get_post_meta($package_id, 'create_event', true);
?>
<section class="<?php echo esc_attr($html_class); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-12">
                <?php require trailingslashit(get_template_directory()) . 'template-parts/listing-detial/public-profile/sidebar-tabs.php'; ?>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-12">
                <div class="profile-detail-area">
                    <div class="profile-detail-title">
                        <h4><?php echo esc_html__('Dashboard', 'dwt-listing'); ?> </h4>
                    </div>
                    <div class="dashboard-tabs" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php
                            $listing_admin_dashboard_url = '';
                            $listing_admin_dashboard_url = dwt_listing_set_url_params_multi(esc_attr($slug), array('type' => 'listings'));
                            $event_admin_dashboard_url = '';
                            $event_admin_dashboard_url = dwt_listing_set_url_params_multi(esc_attr($slug), array('type' => 'events'));
                            ?>
                            <li class="<?php if ($_GET['type'] == "listings") { ?> active <?php } ?>"><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_admin_dashboard_url)); ?>"><?php echo esc_html__('Listings', 'dwt-listing'); ?></a></li>
                            <?php if ($create_event != 'no') { ?>
                                <li class="<?php if ($_GET['type'] == "events") { ?> active <?php } ?>"><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($event_admin_dashboard_url)); ?>"><?php echo esc_html__('Events', 'dwt-listing'); ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            if (isset($_GET['type']) && $_GET['type'] == "events") {
                                if ($create_event != 'no') {
                                    // user public events
                                    require trailingslashit(get_template_directory()) . 'template-parts/listing-detial/public-profile/events.php';
                                }
                            } else {
                                // user public listings
                                require trailingslashit(get_template_directory()) . 'template-parts/listing-detial/public-profile/listings.php';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>