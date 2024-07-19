<?php
global $dwt_listing_options;
$listig_nid = isset($listig_nid) ? $listig_nid :"";
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID();
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
if (isset($_GET['management_id']) && $_GET['management_id'] != "") {
    $menu_listing_id = $_GET['management_id'];
    $contitional_input = '<input type="hidden" id="conditional_id" name="conditional_id" value="' . esc_attr($menu_listing_id) . '">';
    $loader = '<div class="sk-circle">
                          <div class="sk-circle1 sk-child"></div>
                          <div class="sk-circle2 sk-child"></div>
                          <div class="sk-circle3 sk-child"></div>
                          <div class="sk-circle4 sk-child"></div>
                          <div class="sk-circle5 sk-child"></div>
                          <div class="sk-circle6 sk-child"></div>
                          <div class="sk-circle7 sk-child"></div>
                          <div class="sk-circle8 sk-child"></div>
                          <div class="sk-circle9 sk-child"></div>
                          <div class="sk-circle10 sk-child"></div>
                          <div class="sk-circle11 sk-child"></div>
                          <div class="sk-circle12 sk-child"></div>
       </div>';
}
?>
<div class="container-fluid">
    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Booked Listings', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php

                    //fetch listings
                    $query_args = array(
                        'post_type' => 'listing',
                        'author' => get_current_user_id(  ), 
                        'posts_per_page'=>10,
                        'meta_query' => array(
                          array(
                            'key' => 'listings_reservations',
                            'compare' => '=',
                             'value'=>'1',
                          ),
                        ),
                       
                      );
                     
                      $the_query = new WP_Query( $query_args );
                      if ( $the_query->have_posts() ) {
                        while( $the_query->have_posts() ) {
                          $the_query->the_post();
                          $sid = get_the_ID();
                          }
                        $paged = 1;
                      
                        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                        // $post_meta = get_post_meta($sid);
                        // print_r($post_meta);
                        // die;
                        ?>
                            
                            <div class="table-responsive dwt-admin-tabelz">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__('Listing', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Category', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Views', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Expiry Date', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Action', 'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($the_query->have_posts()) {
                                        $the_query->the_post();
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
                                            <td><?php echo dwt_get_listing_expiry_date_only($listing_id); ?></td>
                                            <td>
                                                        <span class="action-icons active">
                                                            <?php
                                                            $listing_publish_edit_url = dwt_listing_set_url_params_multi(dwt_listing_pagelink('dwt_listing_header-page'), array('listing_id' => esc_attr($listing_id)));
                                                            ?>
                                                            <div >
                                                                <a class="edit-booking" data-listing-id="<?php echo esc_attr($listing_id); ?>" href="javascript:void(0)"><i class="ti-pencil-alt"></i> </a>
                                                                <!-- <a class="edit-booking" data-listing-id="<?php echo esc_attr($listing_id); ?>" href="<?php //echo esc_url(dwt_listing_page_lang_url_callback($listing_publish_edit_url)); ?>"><i class="ti-pencil-alt"></i> </a> -->
                                                            <?php
                                                            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                                                                echo '<a href="javascript:void(0)" class="tool-tip"  title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"> <i class="ti-trash text-danger"></i></a>';
                                                                echo '<a href="javascript:void(0)" class="tool-tip"  title="' . esc_html__('Disable for Demo', 'dwt-listing') . '"> <i class="ti-alert text-warning"></i></a>';
                                                                
                                                            } else {
                                                                ?>
                                                                    <a class="delete-my-reservation-listings"  href="javascript:void(0)" data-listing-id="<?php echo esc_attr($listing_id); ?>"><i class="ti-trash"></i></a>
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
                          <?php echo dwt_listing_listing_pagination($the_query); ?>
                    </div>
                </div>
            </div>

      </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="panel leads-activities">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Enable Listing Appointments', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <form id="reservations">
                        <div class="preloading" id="dwt_listing_loading"></div>
                        <div class="submit-listing-section">
                            <div class="row">
                                <?php
                                //Author Listings
                                $get_args = $profile->dwt_listing_fetch_my_listings();
                                $get_args = dwt_listing_wpml_show_all_posts_callback($get_args);
                                $my_listings = new WP_Query($get_args);

                               
                                if ($my_listings->have_posts()) {
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo esc_html__('Select Listing', 'dwt-listing'); ?><span>*</span></label>
                                            <select data-placeholder="<?php echo esc_html__('Select Your Listing', 'dwt-listing'); ?>" name="menu_parent_listing" id="menu_parent_listingz" class="custom-select" required>
                                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <?php
                                                while ($my_listings->have_posts()) {
                                                    $my_listings->the_post();
                                                    $listing_id = get_the_ID();
                                                    ?>
                                                    <option value="<?php echo esc_html($listing_id) ?>" <?php if ($listing_id == $menu_listing_id) { ?>selected="selected"<?php } ?>><?php echo esc_attr(get_the_title($listing_id));?></option>
                                                   
                                                   <?php  
                                                }
                                                wp_reset_postdata();
                                                ?>
                                            </select>
                                            <label class="control-label ads_select"><?php echo esc_html__('Select type of Ads', 'dwt-listing'); ?><span>*</span></label>
                                            <select id="subscription" class="form-control" required>
                                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <option value="free"><?php echo esc_html__('Free', 'dwt-listing'); ?></option>
                                                <option value="paid"><?php echo esc_html__('Paid', 'dwt-listing'); ?></option>
                                            </select>
                                            <div class="table_reservation_price">
                                                <label class="control-label"><?php echo esc_html__('Select Table Price', 'dwt-listing')?></label></br>
                                                <input class="form-control" type="number" id="table_price" placeholder="Price in <?php echo get_woocommerce_currency_symbol();?>"/>
                                            </div>
                                            <div class="table_reservation_slot_duration_price">
                                                <label class="control-label"><?php echo esc_html__('Add minutes, time interval of booking', 'dwt-listing')?><span>*</span></label></br>
                                                <input class="form-control" type="number" id="table_slot_duration" placeholder="Slot Duration"/>
                                            </div>
                                            <div class="datepicker-here-custom new-class disabled_dates" id="disabled_dates" data-language='en' data-multiple-dates="-1" data-multiple-dates-separator=", " data-position='top left'>
                                                <label class="control-label"><?php echo esc_html__('Select Dates You Want to Disable', 'dwt-listing'); ?></label>
                                                <?php $seected_listing_id= $menu_listing_id; ?>
                                                <input type="hidden" value="<?php echo esc_html($listig_nid) ?>" id="listing_id" <?php if ($listing_id == $menu_listing_id) { ?>selected="selected"<?php } ?><?php echo esc_attr(get_the_ID($listing_id)); ?>>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-sm-12">   
                                <label for="reservationType" class="pull-left">Select Meeting Type:</label>
    <div class="dropdown pull-left">
        <select class="form-control" id="reservationType">
        <option value="physical_meeting"><?php echo esc_html__('Physcial Meeting', 'dwt-listing'); ?></option>
        <option value="virtual_meeting"><?php echo esc_html__('Virtual Meeting', 'dwt-listing'); ?></option>
        <option value="both"><?php echo esc_html__('Both', 'dwt-listing'); ?></option>

        </select>
        <?php $id = get_the_ID(); ?>
        <input type="hidden" id="listing_id" value="<?php echo $id;?>">
    </div>
</div>
                                    <?php
                                }
                                //echo("vvv");
                                ?>

                                <div class="col-md-12 col-xs-12 col-sm-12 menu-btn">  
                                    <br>
                                    <br>                           
                                    <button type="submit" class="btn btn-admin pull-right create_menu_types"><?php echo esc_html__("Enable Reservation", 'dwt-listing'); ?></button>
                                </div>
                                    
                               
                                <div class="clearfix"></div>
                                <br>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">       
                                    <div id="append_result"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                       
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>

