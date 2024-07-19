<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$my_listing_ID = get_the_ID(  );
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$current_user = get_current_user_id();
$the_id = get_the_ID(  );

?>
<div class="container-fluid">
    <?php get_template_part('template-parts/profile/author-stats/event', 'stats'); ?>
    <div class="row">
        <?php
            $query_args = array(
                'post_type' => 'tickets',
                'posts_per_page'=>10,
                'paged' => $paged,
                'meta_query' => array(
                    array(
                        'key' => 'dwt_listing_author',
                        'compare' => '=',
                        'value'=> get_current_user_id(),
                    ),
                ),
            );
            $loop = new WP_Query( $query_args );    
        ?>
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Recieved Tickets & Amount', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                        <div class="table-responsive dwt-admin-tabelz">
                            <table class="dwt-admin-tabelz-panel table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo esc_html__('Name',   'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Sold Tickets',   'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Amount Recieved',    'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Event Name', 'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Date & Time',  'dwt-listing'); ?></th>
                                        <th><?php echo esc_html__('Ticket Status',  'dwt-listing'); ?></th>
                                    </tr>
                                </thead>
                                    <?php
                                        while( $loop->have_posts() ) : $loop->the_post(); 
                                                $the_id = get_the_ID(  );
                                        
                                            $number_of_tickets = get_post_meta($the_id, 'dwt_event_no_of_tickets', true);
                                            $grand_total = get_post_meta($the_id, 'dwt_listing_event_grand_total_price', true);
                                            $purchaser_name = get_post_meta($the_id, 'dwt_event_user_name', true );
                                            $event_name = get_post_meta($the_id, 'dwt_listing_event_name', true);
                                            $event_date = get_post_meta($the_id, 'dwt_listing_event_date', true);
                                            $order_id = get_post_meta( $the_id, 'order_id', true );
                                            $order = wc_get_order( $order_id );
                                            $order_status  =  $order->get_status();
                                            $currency = get_woocommerce_currency_symbol();
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .   $purchaser_name     . '</a>'; ?></td>
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .   $number_of_tickets  . '</a>'; ?></td>
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .   $currency . $grand_total        . '</a>'; ?></td>
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .   $event_name         . '</a>'; ?></td> 
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .esc_html(date_i18n( "F j, Y, g:i a", strtotime( $event_date )));    ?>  </td>
                                                    <td>    <?php echo  '<a href="javascript:void(0)">' .   $order_status         . '</a>'; ?></td> 
                                                   </tr>
                                                <?php
                                                 wp_reset_postdata();
                                                ?>
                                            </tbody>
                                            <?php       
                                        endwhile;
                                            ?>
                            </table>
                        </div>
                        <div class="admin-pagination">
                            <?php echo dwt_listing_listing_pagination($loop); ?>
                        </div>
                </div>
            </div>
        </div>
    </div>