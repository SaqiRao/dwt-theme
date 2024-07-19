<?php
$paged = 1;
$query_args = array(
    'post_type' => 'reservation',
    'posts_per_page' => 10,
    'paged' => $paged,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'dwt_listing_author',
            'compare' => '=',
            'value' => get_current_user_id(),
        ),
        array(
            'key' => 'dwt_listing_zoom_meeting',
            'compare' => 'EXISTS',
        ),
    ),
);
$reservations = new WP_Query($query_args);
?>
<div class="container-fluid">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">All Meetings</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive dwt-admin-tabelz">
                        <table class="dwt-admin-tabelz-panel table-hover my-order-history">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Meeting Topic</th>
                                    <th>Meeting Duration</th>
                                    <th>Meeting Time</th>
                                </tr>
                            </thead>
                            <?php
                            if ($reservations->have_posts()) {
                                while ($reservations->have_posts()) {
                                    $reservations->the_post();
                                    $theid = get_the_ID();
                                    $listing_title = get_the_title();
                                    $listing = get_post_meta($theid);
                                    $meeting_info = get_post_meta($theid, 'dwt_listing_zoom_meeting', true);
                                    $meeting_start_url = get_post_meta($theid, '_dwt_meet_startURL', true);
                                    $meeting_join_url = get_post_meta($theid, '_dwt_meet_joinurl', true);
                                    $time_string = $meeting_info['_dwt_meet_time'];
                                    $date_time = new DateTime($time_string);

                                    $formatted_time = $date_time->format('M j, Y g:i a');

                                    ?>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <h3><?php echo $listing_title; ?></h3>
                                                    <div>
                                                        <a href="<?php echo esc_url($meeting_start_url, 'dwt-listing') ?>" target="_blank">
                                                            <button type="button" class="btn btn-sm btn-primary">
                                                                <i class="ti-video-camera"></i><?php echo esc_html(' Start Meeting', 'dwt-listing') ?>
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-warning delete_zoom_meeting"
                                                            id="<?php echo esc_attr($meeting_info['_dwt_meet_id']); ?>"
                                                            data-meetid="<?php echo esc_attr($meeting_info['_dwt_meet_id']); ?>"
                                                            data-res-id="<?php echo esc_attr($meeting_info['_dwt_job_id']); ?>"
                                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Deleting...", 'dwt-listing'); ?>">
                                                            <i class="ti-trash"></i><?php echo esc_html(' Delete Meeting', 'dwt-listing') ?>
                                                        </button>
                                                        <button type="button" id="" class="btn btn-sm btn-info copy_meeting_url" data-meeting-url="<?php echo esc_attr(isset($meeting_join_url) ? $meeting_join_url : ''); ?>">
                                                            <i class="ti-files"></i><?php echo esc_html(' Copy Link', 'dwt-listing') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>

                                            <td><?php echo $meeting_info['_dwt_meet_topic']; ?></td>
                                            <td><?php echo $meeting_info['_dwt_meet_duration']; ?></td>
                                            <td><?php echo $formatted_time; ?></td>
                                        </tr>
                                        <?php
                                        wp_reset_postdata();
                                        ?>
                                    </tbody>
                                <?php }
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>