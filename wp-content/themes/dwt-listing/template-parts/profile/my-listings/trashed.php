<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/stats'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
                            <h3 class="panel-title"><?php echo esc_html__('Trashed Listings', 'dwt-listing'); ?></h3>
                        </div>
                        <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4">
                            <?php if ($dwt_listing_options['dwt_listing_mov_trash_to_expire'] == true) { ?>
                                <button type="button" id="move_to_exp_list" class="btn sonu-button ren-exp-btn pull-right"
                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing..."><?php echo __('Move to Expired', 'dwt-listing'); ?></button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <?php
                    //pagination
                    $paged = 1;

                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    //fetch listings
                    $listing_status = 'trash';
                    $get_args = $profile->dwt_listing_fetch_owner_listings($listing_status, $paged);
                    $my_listings = new WP_Query($get_args);
                    if ($my_listings->have_posts()) {
                        ?>
                        <div class="table-responsive dwt-admin-tabelz">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo esc_html__('Listing', 'dwt-listing'); ?></th>
                                    <th><?php echo esc_html__('Category', 'dwt-listing'); ?></th>
                                    <th><?php echo esc_html__('Views', 'dwt-listing'); ?></th>
                                    <?php if ($dwt_listing_options['dwt_listing_mov_trash_to_expire'] == true) { ?>
                                        <th><?php echo esc_html__('Move to Expired', 'dwt-listing'); ?></th>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($my_listings->have_posts()) {
                                    $my_listings->the_post();
                                    $listing_id = get_the_ID();
                                    //get media
                                    $media = dwt_listing_fetch_listing_gallery($listing_id);
                                    $web_leads = $total_leads = $total_views = $contact_leads = '0';
                                    if (get_post_meta($listing_id, '_dowtown_web_leads', true) != "") {
                                        $web_leads = get_post_meta($listing_id, '_dowtown_web_leads', true);
                                    }
                                    if (get_post_meta($listing_id, '_dowtown_contact_leads', true) != "") {
                                        $contact_leads = get_post_meta($listing_id, '_dowtown_contact_leads', true);
                                    }
                                    if ($web_leads != 0 && $contact_leads != 0) {
                                        $total_leads = $web_leads + $contact_leads;
                                    }
                                    ?>
                                    <tr class="unique-key-<?php echo esc_attr($listing_id); ?>">
                                        <td><span class="admin-listing-img"><a href="javascript:void(0);">
                                                        <img class="img-responsive"
                                                             src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_user-dp'); ?>"
                                                             alt="<?php echo get_the_title($listing_id); ?>"></a></span>
                                        </td>
                                        <td><a href="javascript:void(0);"><span
                                                        class="admin-listing-title"><?php echo get_the_title($listing_id); ?><?php echo dwt_listing_is_listing_featured($listing_id); ?></span><span
                                                        class="admin-listing-date"><i
                                                            class="lnr lnr-calendar-full"></i>  <?php echo get_the_date(get_option('date_format'), $listing_id); ?></span></a>
                                            <?php
                                            //Business Hours
                                            if (dwt_listing_business_hours_status($listing_id) != "") {
                                                $status_type = dwt_listing_business_hours_status($listing_id);
                                                if ($status_type == 0) {
                                                    echo '' . $business_hours_status = '<span class="timing"><a class="closed"><i class="lnr lnr-history"></i> ' . esc_html__('Closed', 'dwt-listing') . '</a></span>';
                                                } else if ($status_type == 2) {
                                                    echo '' . $business_hours_status = '<span class="timing"><a class="open24"><i class="lnr lnr-sync"></i> ' . esc_html__('Always Open', 'dwt-listing') . '</a></span>';
                                                } else {
                                                    echo '' . $business_hours_status = '<span class="timing"><a class="open-now"><i class="lnr lnr-bullhorn"></i> ' . esc_html__('Open Now', 'dwt-listing') . '</a></span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo dwt_listing_listing_assigned_cats($listing_id); ?></td>
                                        <td><?php if (function_exists('pvc_get_post_views')) echo pvc_get_post_views($listing_id); ?></td>
                                        <?php if ($dwt_listing_options['dwt_listing_mov_trash_to_expire'] == true) { ?>
                                            <td><input value="<?php echo $listing_id; ?>" class="trash_chk custom-checkbox" type="checkbox"></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                                wp_reset_postdata();
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        get_template_part('template-parts/profile/my-listings/content', 'none');
                    }
                    ?>
                    <div class="admin-pagination">
                        <?php echo dwt_listing_listing_pagination($my_listings); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>