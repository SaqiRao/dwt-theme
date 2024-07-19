<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID(  );
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
$author_id = get_post_field( 'post_author', $my_listing_ID );
?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/event-stats'); ?>
    <div class="row">
        <?php
          $paged = 1;
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $query_args = array(
                'post_type' => 'tickets',
                'posts_per_page'=>10,
                'paged' => $paged,
                'author'=>get_current_user_id(),
            );
            $loop = new WP_Query( $query_args );
        ?>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Purchased Tickets', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive dwt-admin-tabelz">
                        <div class="recieved-booking">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__('Event Name', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('No. Of Tickets', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Tickets Price', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Extra Service Price', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Client Name', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Grand Total', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Event ID', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Status', 'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                <?php

                              
                                //fetch listings
                                $listing_status = 'publish';
                                $permalink = get_the_permalink();
                                $get_args = $profile->dwt_listing_fetch_owner_events($listing_status, $paged);
                                
                                while ( $loop->have_posts() ) : $loop->the_post(); 
                                    $theid = get_the_ID();
                                $listing_title = get_the_title();
                                $user_name = get_post_meta( $theid, 'dwt_event_user_name', true );
                                $number_of_tickets_purchased = get_post_meta( $theid, 'dwt_event_no_of_tickets', true );
                                $price_of_ticket = get_post_meta( $theid, 'dwt_event_ticket_price', true );
                                $price_of_extra_service = get_post_meta( $theid, 'dwt_event_extra_services_price', true );
                                $grand_total = get_post_meta( $theid, 'dwt_listing_event_grand_total_price', true );
                                $event_name = get_post_meta( $theid, 'dwt_listing_event_name', true );
                                $event_id = get_post_meta( $theid, 'dwt_listing_event_id', true );
                                $event_status = get_post_meta( $theid, 'event_tickets_status', true );
                                $currency_symbol = get_woocommerce_currency_symbol();

                                $order_id = get_post_meta( $theid, 'order_id', true );
                                $order = wc_get_order( $order_id );
                                $order_status  =  $order->get_status();


                                /*---------addding table for recieved booking--------------*/
                                ?>
                                <tbody>
                                    <tr class="unique-key->">
                                        <td><a href="<?php echo get_the_permalink($event_id); ?>"><span class="admin-listing-title"><?php echo get_the_title($event_id); ?></span><span class="admin-listing-date"><i class="lnr lnr-calendar-full"></i>  <?php echo get_the_date(get_option('date_format'), $event_id); ?></span></a></td>
                                        <td><?php echo esc_html__($number_of_tickets_purchased);?></td>
                                        <td><?php echo esc_html__($price_of_ticket); ?></td>
                                        <td><?php echo esc_html__($currency_symbol. $price_of_extra_service);   ?></td>
                                        <td><?php echo esc_html__($user_name);  ?></td>    
                                        <td><?php echo esc_html__($currency_symbol . $grand_total);  ?></td> 
                                        <td><?php echo esc_html__($event_id);?></td>
                                        <td><?php echo esc_html__($order_status);  ?></td> 

                                    </tr>
                                        <?php
                                    
                                    wp_reset_postdata();
                                    ?>
                                </tbody>
                                <?php    endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="admin-pagination">
                          <?php echo dwt_listing_listing_pagination($loop); ?>
                </div>

                </div>
            </div>
        </div>
    </div>
   
</div>