<?php
global $dwt_listing_options;
$dwt_listing_booking_time_kit = $menu_listing_id = $actual_link = '';
$timekitwidget = $select_timekitListing = $user_id = '';
$dwt_listing_booking_time_kit = $dwt_listing_options['dwt_listing_booking_time_kit'];
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$booking_status = '0';
if (isset($_GET['management_id']) && $_GET['management_id'] != "") {
    $menu_listing_id = $_GET['management_id'];
}

//pagination
$paged = 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


/* == get booking record related to user == */
$booked_listings = array(
    'key' => 'dwt-listing-timekit-booking-status',
    'value' => '1',
    'compare' => '='
);

$active_listings = array(
    'key' => 'dwt_listing_listing_status',
    'value' => '1',
    'compare' => '='
);

$user_boking_records = array(
    'author' => $user_id,
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => 'listing',
    'post_status' => 'publish',
    'meta_query' => array(
        $active_listings,
        $booked_listings,
    ),
);
?>
<div class="container-fluid">
    <?php if (isset($dwt_listing_booking_time_kit) && ($dwt_listing_booking_time_kit != 0 || $dwt_listing_booking_time_kit != false)) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php esc_html_e('Booked Listings:', 'dwt-listing'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $my_listings1 = new WP_Query($user_boking_records);
                        if ($my_listings1->have_posts()) {
                            ?>
                            <div class="table-responsive dwt-admin-tabelz">
                                <table class="dwt-admin-tabelz-panel table-hover">
                                    <thead>
                                        <tr>
                                            <th class="timekit-img"></th>
                                            <th>
                                                <?php echo esc_html__('Listing', 'dwt-listing'); ?>
                                            </th>
                                            <th>
                                                <?php echo esc_html__('Category', 'dwt-listing'); ?>
                                            </th>
                                            <th>
                                                <?php echo esc_html__('Action', 'dwt-listing'); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($my_listings1->have_posts()) {
                                            $my_listings1->the_post();
                                            $listing_id1 = get_the_ID();
                                            $media = dwt_listing_fetch_listing_gallery($listing_id1);
                                            ?>
                                            <tr class="unique-key-<?php echo esc_attr($listing_id1); ?>">
                                                <td class="timekit-img"><span class="admin-listing-img">
                                                        <img class="img-responsive"
                                                            src="<?php echo dwt_listing_return_listing_idz($media, 'dwt_listing_user-dp'); ?>"
                                                            alt="<?php echo get_the_title($listing_id1); ?>"></span>
                                                </td>
                                                <td><a href="<?php echo get_the_permalink($listing_id1); ?>"><span
                                                            class="admin-listing-title">
                                                            <?php echo get_the_title($listing_id1); ?>
                                                        </span><span class="admin-listing-date"><i
                                                                class="lnr lnr-calendar-full"></i>
                                                            <?php echo get_the_date(get_option('date_format'), $listing_id1); ?>
                                                        </span></a>
                                                </td>
                                                <td>
                                                    <?php echo dwt_listing_listing_assigned_cats($listing_id1); ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="timekit_remove_id"
                                                        value="<?php echo esc_attr($listing_id1); ?>" class="">
                                                    <span class="action-icons active">
                                                        <a class="tool-tip delete-my-listings-timekit"
                                                            title="<?php echo esc_attr__('Delete', 'dwt-listing'); ?>"
                                                            href="javascript:void(0)"
                                                            data-listing-id="<?php echo esc_attr($listing_id1); ?>"><i
                                                                class="ti-trash text-danger"></i></a>
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
                            echo dwt_listing_have_no_boking_notification();
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 created-booking">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php esc_html_e('Create Booking:', 'dwt-listing'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form id="make-boking-form">
                            <div class="preloading" id="dwt_listing_loading"></div>
                            <div class="submit-listing-section">
                                <div class="row">
                                    <?php
                                    //Author Listings
                                    $get_args = $profile->dwt_listing_fetch_my_listings();
                                    $my_listings = new WP_Query($get_args);
                                    if ($my_listings->have_posts()) {
                                        ?>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <?php echo esc_html__('Select Listing', 'dwt-listing'); ?><span>*</span>
                                                </label>
                                                <select name="select-timekitListing" id="select-timekitListing"
                                                    class="custom-select" required>
                                                    <option value="">
                                                        <?php echo esc_html__('Select an option', 'dwt-listing'); ?>
                                                    </option>
                                                    <?php
                                                    while ($my_listings->have_posts()) {
                                                        $my_listings->the_post();
                                                        $listing_id = get_the_ID();
                                                        ?>
                                                        <option value="<?php echo esc_attr($listing_id) ?>" <?php if ($listing_id == $menu_listing_id) { ?>selected="selected" <?php } ?>>
                                                            <?php echo esc_attr(get_the_title($listing_id)); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    wp_reset_postdata();
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <?php echo esc_html__('Put your Timekit widget code here:', 'dwt-listing'); ?><span>*</span>
                                            </label>
                                            <textarea class="form-control" rows="40" cols="40" required name="timekitwidget"
                                                id="timekitwidget"
                                                placeholder="<?php esc_html__('Timekit Widget Goes Here', 'dwt-listing'); ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-groups">
                                            <button
                                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php esc_html_e('Processing...', 'dwt-listing'); ?>"
                                                type="submit" id="add-timekit-btn" name="add-timekit-btn"
                                                class="btn  btn-admin sonu-button">
                                                <?php echo esc_html__('Add Booking', 'dwt-listing'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-md-12 col-xs-12 colsm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php esc_html_e('Create Booking :', 'dwt-listing'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php echo dwt_listing_booking_switch_off_notification(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
</div>