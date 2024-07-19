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
                    <h3 class="panel-title"><?php echo esc_html__('Pending Listings', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    //pagination
                    $paged = 1;
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    //fetch listings
                    $listing_status = 'pending';
                    $get_args = $profile->dwt_listing_fetch_owner_listings($listing_status, $paged);
                    $my_listings = new WP_Query($get_args);
                    if ($my_listings->have_posts()) {
                        ?>
                        <div id="warning-messages" class="alert custom-alert custom-alert--info margin-bottom-30" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__('Approval Required!', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("Waiting for admin approval.", 'dwt-listing'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive dwt-admin-tabelz">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo esc_html__('Listing', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Category', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Views', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Action', 'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($my_listings->have_posts()) {
                                        $my_listings->the_post();
                                        $listing_id = get_the_ID();
                                        //get media
                                        $media = dwt_listing_fetch_listing_gallery($listing_id);
                                        ?>
                                        <tr class="unique-key-<?php echo esc_attr($listing_id); ?>">
                                            <td><span class="admin-listing-img"><a href="<?php echo get_the_permalink($listing_id); ?>">
                                                        <img class="img-responsive" src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_user-dp'); ?>" alt="<?php echo get_the_title($listing_id); ?>"></a></span>
                                            </td>
                                            <td><a href="<?php echo get_the_permalink($listing_id); ?>"><span class="admin-listing-title"><?php echo get_the_title($listing_id); ?><?php echo dwt_listing_is_listing_featured($listing_id); ?></span><span class="admin-listing-date"><i class="lnr lnr-calendar-full"></i>  <?php echo get_the_date(get_option('date_format'), $listing_id); ?></span></a> 
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
                                            <td>
                                                <span class="action-icons active">
                                                    <?php
                                                    $listing_pending_edit_url = dwt_listing_set_url_params_multi(dwt_listing_pagelink('dwt_listing_header-page'), array('listing_id' => esc_attr($listing_id)));
                                                    ?>
                                                    <a class="tool-tip" title="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_pending_edit_url)); ?>"><i class="ti-pencil-alt"></i></a>

                                                    <?php
                                                    if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                        echo '<a href="javascript:void(0)" class="tool-tip"  title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"> <i class="ti-trash text-danger"></i></a>';
                                                    } else {
                                                        ?>
                                                        <a class="tool-tip delete-my-listings" title="<?php echo esc_attr__('Delete', 'dwt-listing'); ?>" href="javascript:void(0)" data-listing-id="<?php echo esc_attr($listing_id); ?>"><i class="ti-trash text-danger"></i></a>

                                                        <?php
                                                    }
                                                    ?>
                                                </span>
                                            </td>
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