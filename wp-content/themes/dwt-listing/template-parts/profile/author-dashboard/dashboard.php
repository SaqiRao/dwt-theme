<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$todayz_viewed = $most_viewed = '';
//all time most viewed
$most_viewed = dwt_listing_fetch_dashboard($user_id, true, false);
//todays most viewed
$todayz_viewed = dwt_listing_fetch_dashboard($user_id, true, true);
$package_id = $package_name = $bump_listing = $featured_listing = $regular_listing = '';
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/dashboard'); ?>
    <div class="row">
        <div class="col-lg-7 col-md-7 col-xs-12 col-sm-12">
            <div class="panel leads-activities">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Recent Activities', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled dwt-recent-notification">
                        <?php echo dwt_listing_fetch_leads_activities($user_id); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12">
            <?php
            if (isset($dwt_listing_options['dwt_listing_show_pkg']) && $dwt_listing_options['dwt_listing_show_pkg'] == "1") {
                if (get_user_meta($user_id, 'd_user_package_id', true) != "") {
                    $package_id = get_user_meta($user_id, 'd_user_package_id', true);
                    $regular_listing = get_user_meta($user_id, 'dwt_listing_regular_listing', true);
                    $featured_listing = get_user_meta($user_id, 'dwt_listing_featured_listing', true);
                    $bump_listing = get_user_meta($user_id, 'dwt_listing_bump_listing', true);
                    $package_name = get_the_title($package_id);
                    //data for graph on dashboard
                    $regular_list_graph = get_post_meta($package_id, 'regular_listing', true);
                    $bump_list_graph = get_post_meta($package_id, 'bump_listing', true);
                    $featured_list_graph = get_post_meta($package_id, 'featured_listing_expiry', true);
                    ?>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo esc_html__('Your Plan:', 'dwt-listing'); ?> <a href="<?php echo dwt_listing_pagelink('dwt_listing_packages'); ?>"> <?php echo esc_html__("View More Packages", 'dwt-listing'); ?></a></h3>
                        </div>
                        <div class="panel-body user-pack-his">
                            <div id="canvas-holder">
                                <canvas id="chart-area" height="190px"></canvas>
                            </div>
                            <div class="clearfix"></div>
                            <ul class="list-unstyled list-justify">
                                <?php echo dwt_listing_user_pack_history($package_id); ?>
                            </ul>
                        </div>
                    </div>
                    <script>
                        var configz = {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                        data: [
                                                <?php echo esc_attr($regular_list_graph); ?>,
                                                <?php echo esc_attr($featured_list_graph); ?>,
                                                <?php echo esc_attr($bump_list_graph); ?>,
                                            ],
                                        backgroundColor: [
                                            '#3e95cd',
                                            '#8e5ea2',
                                            '#3cba9f',
                                        ],
                                    }],
                                labels: [
                                    "<?php echo dwt_listing_text('d_reg_listing'); ?>",
                                    "<?php echo dwt_listing_text('d_feat_listing'); ?>",
                                    "<?php echo dwt_listing_text('d_bump_listing'); ?>",
                                ]
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: "<?php echo esc_attr($package_name); ?>",
                                },
                                animation: {
                                    animateScale: true,
                                    animateRotate: true
                                }
                            }
                        };
                        window.onload = function () {
                            var ctx = document.getElementById('chart-area').getContext('2d');
                            window.myDoughnut = new Chart(ctx, configz);
                        };
                    </script>
                    <?php
                } else {
                    ?>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo esc_html__('Your Plan:', 'dwt-listing'); ?></h3>
                        </div>
                        
                        <div class="panel-body">
                            <div class="alert custom-alert custom-alert--warning" role="alert">
                                <div class="custom-alert__top-side">
                                    <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                    <div class="custom-alert__body">
                                        <h6 class="custom-alert__heading">
                                            <?php echo esc_html__('No Plan Selected.', 'dwt-listing'); ?>
                                        </h6>
                                        <div class="custom-alert__content">
                                            <?php echo esc_html__("Currenty you don't have any package. Upgrade your plan if desired!", 'dwt-listing'); ?>
                                            <a href="<?php echo dwt_listing_pagelink('dwt_listing_packages'); ?>" class="link-info link-info--bordered"> <?php echo esc_html__("Select Your Package", 'dwt-listing'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
               <?php 
                if (isset($dwt_listing_options['dwt_listing_show_remaining_pkg']) && $dwt_listing_options['dwt_listing_show_remaining_pkg'] == "1") {

            ?>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Remaining Plan', 'dwt-listing'); ?></h3>
                </div>
                <?php
                    if (get_user_meta($user_id, 'd_user_package_id', true) != "") {
                ?>
              <div class="panel-body">
                    <ul class="list-unstyled dwt-panel-listz">
                        <?php
                         $options_html = '';
                            //maximum listings =fk
                            if (get_post_meta($package_id, 'regular_listing', true) != "") {

                                $regular_listing = get_post_meta($package_id, 'regular_listing', true);
                                $posted_listings =  dwt_listing_get_listing_status_count($user_id, '1');
                                $number_of_remaining_listings = (int)$regular_listing - (int)$posted_listings;
                                $total_featured_listing = get_post_meta($package_id, 'featured_listing', true);
                                $posted_featured_listings =  dwt_listing_get_featured_count($user_id);
                                $remaining_featured_listings =  (int)$total_featured_listing - (int)$posted_featured_listings;
                                
                                $users_regular_listings_posted = $remaining_regular_listings = $users_feature_listings_posted = $users_feature_listings_remaining='';
                                echo $users_regular_listings_posted .= '<li><i class="lnr lnr-text-align-justify"></i> ' . __('Posted Regular Listings', 'dwt-listing') . ' : <span>' . esc_attr($posted_listings) . '</span></li>';
                                echo  $remaining_regular_listings   .= '<li><i class="lnr lnr-text-align-justify"></i>'. __( 'Remaining Regular Listings' ,'dwt-listing' ). ' : <span>' . esc_attr($number_of_remaining_listings) . '</span></li>';
                                echo  $users_feature_listings_posted    .= '<li><i class="lnr lnr-layers"></i>'. __( ' Total Featured Listings', 'dwt-listing') . ' : <span>' . esc_attr($posted_featured_listings) . '</span></li>';
                                echo  $users_feature_listings_remaining .= '<li><i class="lnr lnr-layers"></i>'. __( ' Remaining Featured Listings', 'dwt-listing') . ' : <span>' . esc_attr($remaining_featured_listings) . '</span></li>';

                            }
                        ?>
                    </ul>
                </div>
                <?php } else{?>
                    <div class="panel-body">
                        <div class="alert custom-alert custom-alert--warning" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading">
                                        <?php echo esc_html__('No Plan Selected.', 'dwt-listing'); ?>
                                    </h6>
                                    <div class="custom-alert__content">
                                        <?php echo esc_html__("Currenty you don't have any package. Upgrade your plan if desired!", 'dwt-listing'); ?>
                                        <a href="<?php echo dwt_listing_pagelink('dwt_listing_packages'); ?>" class="link-info link-info--bordered"> <?php echo esc_html__("Select Your Package", 'dwt-listing'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php } ?>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__("Today's Most Viewed", 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    $listz = $fetch_output1 = '';
                    $my_listings_today = new WP_Query($todayz_viewed);
                    if ($my_listings_today->have_posts()) {
                        $listz = new dwt_listing_listings();
                        ?>		
                        <ul class="list-unstyled dwt-panel-listz">
                            <?php
                            while ($my_listings_today->have_posts()) {
                                $functionz = $fetch_output1 = '';
                                $my_listings_today->the_post();
                                $listing_idz = get_the_ID();
                                $functionz = "dwt_listing_most_viewed";
                                echo $fetch_output1 .= $listz->$functionz($listing_idz);
                            }
                            ?>
                        </ul>
                        <?php
                        wp_reset_postdata();
                    } else {
                        ?>
                        <div class="alert custom-alert custom-alert--info" role="alert">
                            <div class="custom-alert__top-side">
                                <span class="alert-icon custom-alert__icon  ti-info-alt "></span>
                                <div class="custom-alert__body">
                                    <h6 class="custom-alert__heading"><?php echo esc_html__('No Views Today', 'dwt-listing'); ?></h6>
                                    <div class="custom-alert__content"><?php echo esc_html__("Today's most viewed listing will be here", 'dwt-listing'); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Most Viewed Listings', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    $fetch_output = '';
                    $my_listings = new WP_Query($most_viewed);
                    if ($my_listings->have_posts()) {
                        $list = new dwt_listing_listings();
                        ?>		
                        <ul class="list-unstyled dwt-panel-listz">
                            <?php
                            while ($my_listings->have_posts()) {
                                $function = $fetch_output = '';
                                $my_listings->the_post();
                                $listing_id = get_the_ID();
                                $function = "dwt_listing_most_viewed";
                                echo $fetch_output .= $list->$function($listing_id);
                            }
                            ?>
                        </ul>
                        <?php
                        wp_reset_postdata();
                    } else {
                        get_template_part('template-parts/profile/my-listings/content', 'none');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>