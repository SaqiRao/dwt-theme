<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
?>
<div class="container-fluid">
<?php get_template_part('template-parts/profile/author-stats/event', 'stats'); ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Expired Events', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    $cat_name = $link = $to = $from = $cat_name = $link = $term_list = $event_start = '';
                    $event_venue_loc = $event_end = '';
                    $paged = 1;
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    //fetch listings
                    $listing_status = 'expired';
                    $event_edit_slug = get_the_permalink() . '?listing-type=create-events';
                    $get_args = $profile->dwt_listing_fetch_owner_events($listing_status, $paged);
                    $my_events = new WP_Query($get_args);
                    if ($my_events->have_posts()) {
                        ?>
                        <div class="table-responsive dwt-admin-tabelz">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th><?php echo esc_html__('Events', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('From', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('To', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Category', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Views', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Action', 'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($my_events->have_posts()) {
                                        $my_events->the_post();
                                        $event_id = get_the_ID();
                                        //get media
                                        $media = dwt_listing_fetch_event_gallery($event_id);
                                        $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
                                        $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
                                        $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
                                        $term_list = wp_get_post_terms($event_id, 'l_event_cat', array("fields" => "all"));
                                        if (!empty($term_list)) {
                                            $link = get_term_link($term_list[0]->term_id);
                                            $cat_name = $term_list[0]->name;
                                        }
                                        if ($event_start_date != "") {
                                            $from = date_i18n(get_option('time_format'), strtotime($event_start_date));
                                            $event_start = date_i18n(get_option('date_format'), strtotime($event_start_date));
                                        }
                                        if ($event_end_date != "") {
                                            $to = date_i18n(get_option('time_format'), strtotime($event_end_date));
                                            $event_end = date_i18n(get_option('date_format'), strtotime($event_end_date));
                                        }
                                        if ($event_venue != "") {
                                            $event_venue_loc = $event_venue;
                                        }
                                        ?>
                                        <tr>
                                            <td><span class="admin-listing-img"><a href="<?php echo get_the_permalink($event_id); ?>">
                                                        <img class="img-responsive" src="<?php echo dwt_listing_return_event_idz($media, 'dwt_listing_user-dp'); ?>" alt="<?php echo get_the_title($event_id); ?>"></a></span>
                                            </td>
                                            <td><a href="<?php echo get_the_permalink($event_id); ?>"><span class="admin-listing-title"><?php echo get_the_title($event_id); ?></span><span class="admin-listing-date"><i class="lnr lnr-calendar-full"></i>  <?php echo get_the_date(get_option('date_format'), $event_id); ?></span></a>
                                            </td>
                                            <td class="event-timingz">
                                                <span><?php echo ($from); ?></span>
                                                <span><?php echo ($event_start); ?></span>
                                            </td>
                                            <td class="event-timingz">
                                                <span><?php echo ($to); ?></span>
                                                <span><?php echo ($event_end); ?></span>
                                            </td>
                                            <td><?php echo '<a href="' . $link . '">' . $cat_name . '</a>'; ?></td>
                                            <td><?php if (function_exists('pvc_get_post_views')) echo pvc_get_post_views(); ?></td>
                                            <td>
                                                <span class="action-icons active">
        <?php
        if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
            echo '<a href="javascript:void(0)" class="tool-tip"  title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"> <i class="lnr lnr-sync text-warning"></i></a>';
            echo '<a href="javascript:void(0)" class="tool-tip"  title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"> <i class="ti-trash text-danger"></i></a>';
        } else {
            ?>
                                                        <a class="tool-tip reactive-my-events" title="<?php echo esc_attr__('Re Active Event', 'dwt-listing'); ?>" href="javascript:void(0)" data-myevent-id="<?php echo esc_attr($event_id); ?>"><i class="lnr lnr-sync text-warning"></i></a>
                                                        <a class="tool-tip delete-my-events" title="<?php echo esc_attr__('Delete', 'dwt-listing'); ?>" href="javascript:void(0)" data-myevent-id="<?php echo esc_attr($event_id); ?>"><i class="ti-trash text-danger"></i></a>

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
                                    get_template_part('template-parts/profile/events/content', 'none');
                                }
                                ?>
                    <div class="admin-pagination">
                    <?php echo dwt_listing_listing_pagination($my_events); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>