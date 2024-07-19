<?php
global $dwt_listing_options;
$event_id = get_the_ID();
$event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
$event_end_dateTime = (get_post_meta($event_id, 'dwt_listing_event_end_date', true));
$status_event = get_post_meta($event_id, 'dwt_listing_event_status', true);


$current_user = wp_get_current_user();
$current_users =  $current_user->user_login;
$user_id = get_post_field('post_author', $event_id);
//user info
$get_user_dp = $get_user_url = $get_user_name = $get_loc = $contact_num = $get_profile_contact = $get_event_contact = $get_profile_email = $get_email = '';
$get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
$get_user_url = dwt_listing_listing_owner($event_id, 'url');
$get_user_name = dwt_listing_listing_owner($event_id, 'name');
$get_loc = dwt_listing_listing_owner($event_id, 'location');
$get_profile_contact = dwt_listing_listing_owner($event_id, 'contact');
$get_event_contact = get_post_meta($event_id, 'dwt_listing_event_contact', true);
$get_profile_email = dwt_listing_listing_owner($event_id, 'email');
$get_event_email = get_post_meta($event_id, 'dwt_listing_event_email', true);
$get_event_question = get_post_meta( $event_id, 'event_question', true );
$events_days = get_post_meta($event_id, 'days_schedule', true);

//display contact number when profile contact not set
if (!empty($get_event_contact)) {
    $contact_num = $get_event_contact;
} else {
    $contact_num = $get_profile_contact;
}
//display email when profile email not set
if (!empty($get_event_email)) {
    $get_email = $get_event_email;
} else {
    $get_email = $get_profile_email;
}


// adding date and time format for google calendar
   
$start_date = date("Ymd", strtotime($event_start_date));  
$start_time =   date("His", strtotime($event_start_date)); 
$start_format  =   $start_date  . "T" . $start_time;

$end_date = date("Ymd", strtotime($event_end_dateTime));  
$end_time =   date("His", strtotime($event_end_dateTime)); 
$end_format  =   $end_date  . "T" . $end_time;

$google_date_url   =  $start_format . "/" .$end_format ;

$location_event = get_post_meta($event_id, 'dwt_listing_event_venue', true);
$my_content = get_the_content();

// adding date and time format for outlook calendar

$start_date_outlook_format = $event_start_date;
$start_date_outlook = date("Y-m-d", strtotime($event_start_date));  
$start_time_outlook =   date("H:i:s\Z", strtotime($event_start_date)); 
$start_format_outlook  =   $start_date_outlook  . "T" . $start_time_outlook;

$end_date_outlooks_format = $event_end_dateTime;
$end_date_outlooks = date("Y-m-d", strtotime($event_end_dateTime));  
$end_time_outlooks =   date("H:i:s\Z", strtotime($event_end_dateTime)); 
$end_format_outlooks  =   $end_date_outlooks  . "T" . $end_time_outlooks;


$outlook_date_url   =  $start_format_outlook . "/" . $end_format_outlooks ;

//google calendar event
$google_calendar_url = ( 'http://www.google.com/calendar/render?action=TEMPLATE&text=' . 
get_the_title( esc_attr( $event_id ) ) . 
( !empty( $event_start_date ) ? '&dates='  . $google_date_url. '' : '') .
( !empty( $get_loc ) ? '&location=' . esc_attr( $location_event ) . '' : '' ) . 
( !empty( $my_content ) ? '&details=' . esc_attr( $my_content ) . '' : '' ) . '' );


//outlook calendar
$outlook_calendar_url = ('https://outlook.live.com/owa/?path=/calendar/view/Month&rru=addevent&subject='.
get_the_title( ( $event_id ) ) . 
( !empty( $event_start_date ) ? '&startdt=' . ( $start_format_outlook): '') .
( !empty( $event_start_date ) ? '&dtend='   . ( $end_format_outlooks): '') .
( !empty( $get_loc ) ? '&location=' . ( $location_event ) . '' : '' ) . 
( !empty( $my_content ) ? '&body=' . ( $my_content ) . '' : '' ) . '');


//Yahoo calendar event
$yahoo_calendar_url = ( 'https://calendar.yahoo.com/?v=60&amp;&title=' . 
get_the_title( ( $event_id ) ) . 
( !empty( $event_start_date ) ? '&st='  . $start_format  : '') .
( !empty( $event_start_date ) ? '&et='  . $end_format  : '') .
( !empty( $get_loc ) ? '&in_loc=' . ( $location_event ) . '' : '' ) . 
( !empty( $my_content ) ? '&desc=' . ( $my_content ) . '' : '' ) . '' );
$questions = get_post_meta($event_id, 'event_question', true);
$events_days = get_post_meta($event_id, 'days_schedule', true);
?>
<section class="dwt_listing_single-event">
    <div class="container">
        <?php
        //notification for event has expired
        if (get_post_meta($event_id, 'dwt_listing_event_status', true) == '0') {
            echo dwt_listing_event_expired_notification();
        }
        ?>
        <?php get_template_part('template-parts/events/event-detial/slider'); ?>
        <div class="clearfix"></div>
        <div class="row dwt_listing_single-detial">
            <div class="col-md-8 col-xs-12 col-sm-12">
                <?php get_template_part('template-parts/admin', 'approval'); ?>
                <div class="row">
                    <?php get_template_part('template-parts/events/event-detial/short', 'info'); ?>
                    <?php get_template_part('template-parts/events/event-detial/desc'); ?>
                </div>
                <?php
                $event_type = get_post_meta($event_id, 'dwt_listing_event_type', true);
                if (isset($dwt_listing_options['dwt_event_type_switch']) && $dwt_listing_options['dwt_event_type_switch'] == 1) {
                    if (isset($event_type) && $event_type != 'webinar') {

                        get_template_part('template-parts/events/event-detial/map');
                    }
                } ?>

                <?php
                if (get_post_meta($event_id, 'dwt_listing_event_status', true) != '0') {
                    ?>
                    <div class="single-blog blog-detial">
                        <div class="blog-post">
                            <?php comments_template('', true); ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- event attendees starts here-->
                <?php
                            if (isset($dwt_listing_options['event_attendees']) && $dwt_listing_options['event_attendees'] == 1) {
                                $current_user = get_current_user_id();
                                ?>

                                <?php
                                $event_attendees = get_post_meta($event_id, 'events_attendes', true);
                                if (isset($event_attendees) && $event_attendees != '') {
                                    ?>
                                    <div class="panel panel-default eventz-comments">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <a href="javascript:void(0)"> <i
                                                        class="ti-comment-alt"></i><?php echo esc_html__('Attendees', 'dwt-listing'); ?>
                                                </a> </h4>
                                        </div>
                                        <div class="panel-collapse">
                                            <div class="panel-body">
                                                <div class="single-blog blog-detial">
                                                    <div class="events_attenders">
                                                        <div class="blog-post">
                                                            <?php
                                                                if (is_array($event_attendees) || is_object($event_attendees)) { ?>  
                                                                    <div class="listing-page-slider owl-carousel owl-theme">
                                                                        <?php
                                                                        foreach ($event_attendees as $attendee_id) {
                                                                            $attendee_data = get_userdata($attendee_id);
                                                                            $attendee_name = $attendee_data->display_name;
                                                                            $dp = dwt_listing_get_user_dp($attendee_id, 'small');
                                                                            ?>
                                                                            <div class="item event_attendees_panel">
                                                                                <div class="carosual-content">
                                                                                    <a href="<?php echo esc_url($dp); ?>" data-fancybox="group"> 
                                                                                        <img class="event_attendee_img" src="<?php echo esc_url($dp); ?>" class="img-responsive" alt="<?php echo esc_attr($attendee_name); ?> "/> 
                                                                                    </a>
                                                                                    <p><?php echo $attendee_name ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <?php 
                                                                        }?>
                                                                    </div>
                                                                <?php
                                                                } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                            <!-- event attendees ends here-->
                            <!-- event attendees ends here-->
                            <!--adding accordion for question and answer section -->
                            <?php
                                    if(isset ($dwt_listing_options['event_question']) && $dwt_listing_options['event_question'] == 1){
                                ?>   
                            <div class="panel panel-default eventz-comments">
                                
                                <div class="panel-heading">
                                    <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-comment-alt"></i><?php echo esc_html__('Frequently Asked Questions', 'dwt-listing')?></a> </h4>
                                </div>
                                <div class="panel-collapse">
                                    <div class="panel-body"> 
                                        <div class="single-blog blog-detial">
                                            <div class="accordion_for_question">
                                                <!--adding questions and answers sections--->
                                                
                                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                                                        
                                                        <div class="accordion-item">
                                                            <?php
                                                            $count  = 1;
                                                            if (is_array($questions) || is_object($questions))
                                                            {
                                                                
                                                                
                                                            foreach($questions as $ques){?>
                                                                <?php $count ++;  ?>
                                                                <h6 class="accordion-header" id="flush-headingOne">
                                                                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseOne<?php echo $count; ?>" aria-expanded="false" aria-controls="flush-headingOne">
                                                                        <b><?php echo esc_html__('Question:','dwt-listing');?> </b><?php echo $ques ['question']; ?><i class="ti-arrow-circle-down"></i>
                                                                    </button>
                                                                </h6>
                                                                <div id="flush-collapseOne<?php echo $count; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                                                    <div class="accordion-body"><b> <?php echo esc_html__('Answer:','dwt-listing');?></b> <?php echo $ques ['answer']; ?>
                                                                    </div>
                                                                </div>
                                                            <?php } }?>
                                                        </div>
                                                
                                                    </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <!--pasting for duplicate fields ends--->
                            <!--adding days and schedule section -->
                            <?php
                            if (isset($dwt_listing_options['days_schedule']) && $dwt_listing_options['days_schedule'] == 1) {
                                if (isset($events_days) && $events_days != '') {
                                    ?>
                                    <!--events days and schedule section starts here -->
                                    <div class="days_schedule_accordion">
                                        <div class="panel panel-default eventz-comments">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"> <a href="javascript:void(0)"> <i
                                                            class="ti-comment-alt"></i><?php echo esc_html__('Day Schedule', 'dwt-listing'); ?></a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse">
                                                <div class="panel-body">
                                                    <div class="single-blog blog-detial">
                                                        <div class="accordion accordion-flush" id="accordionFlushExampleSection">
                                                            <div class="accordion-item">

                                                                <?php
                                                                $counting = 1;

                                                                if (isset($events_days) && ($events_days) != '') {
                                                                    foreach ($events_days as $scheduled_days) {
                                                                        $counting++; ?>

                                                                                <h6 class="accordion-header" id="flush-headingOne_Schedules">
                                                                                    <button class="accordion-button collapsed" type="button"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#flush-collapseOneSchedule<?php echo $counting; ?>"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="flush-headingOne_Schedules">
                                                                                        <b><?php echo esc_html__('Question:', 'dwt-listing'); ?>
                                                                                        </b><?php echo $scheduled_days['newDays']; ?> <i
                                                                                            class="ti-arrow-circle-down"></i><br>
                                                                                    </button>
                                                                                </h6>

                                                                                <div id="flush-collapseOneSchedule<?php echo $counting; ?>"
                                                                                    class="accordion-collapse collapse"
                                                                                    aria-labelledby="flush-headingOne_Schedules"
                                                                                    data-parent="#accordionFlushExampleSection">
                                                                                    <div class="accordion-body">
                                                                                        <b><?php echo esc_html__('Answer:', 'dwt-listing'); ?></b>
                                                                                        <?php echo $scheduled_days['schedule_description']; ?>
                                                                                    </div>
                                                                                </div>
                                                                        <?php }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } ?>

            </div>
            
            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="blog-sidebar">
                    <?php
                    $custom_color = '';
                    $clock_icon = '<div class="dwt_listing_timer-icon"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Time Left In Event', 'dwt-listing') . '"></i></div>';
                    //if event is started
                    if (dwt_listing_check_event_starting($event_id) == '0') {
                        $custom_color = 'eventz-statred';
                        $clock_icon = '<div class="dwt_listing_timer-icon green-clock"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Event Started', 'dwt-listing') . '"></i></div>';
                    }
                    ?>
                    <?php if($status_event != '0'){  ?>
                    <div class="list-bottom-area <?php echo esc_attr($custom_color); ?>">
                        <?php echo '' . ($clock_icon); ?>
                        <div class="dwt_listing_timer-count">
                            <div class="dwt_listing_countdown-timer">
                                <div class="timer-countdown-box">
                                    <div class="countdown dwt_listing_custom-timer" data-countdown-time="<?php echo  esc_attr($event_start_date); ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php if (is_active_sidebar('dwt_listing_events-sidebar')) { ?>
                        <?php dynamic_sidebar('dwt_listing_events-sidebar'); ?>
                    <?php } ?>    
                    
                </div>
                    <div class="panel-group" id="accordion_listing_detial" role="tablist" aria-multiselectable="true">
                    </div>
                    <!--adding for event_prices--->
                    <?php
                    if(isset ($dwt_listing_options['event_ticket_system']) && $dwt_listing_options['event_ticket_system'] == 1){
                        $show_event_tickets_ = get_post_meta( $event_id, 'event_tickets_show', true ); 
                             if(isset($show_event_tickets_) && $show_event_tickets_ =='yes')
                             {

                                $event_tickets_booking = get_post_meta($event_id, 'event_tickets_boking', true);
                                $event_e_services = get_post_meta($event_id, 'event_e_services', true);
                                $event_extra_services = get_post_meta( $event_id, 'show_extra_service', true );
                            ?>
                        <div class="panel panel-default event-tickets">
                            <div class="panel-heading">
                                <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-location-pin"></i> <?php echo esc_html__('Event Tickets', 'dwt-listing'); ?> </a> </h4>
                            </div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                                <?php
                                    if (get_post_meta($event_id, 'dwt_listing_event_status', true) == '0') {
                                        echo dwt_listing_event_expired_no_more_tickets_notification();        
                                    }else{
                                ?>
                                <div class="single-blog blog-detial">
                                    <?php if($show_event_tickets_  == "yes"){ ?>
                                    <div class="accordion_for_question">
                                        <!--adding Tickets pricing and extra services--->
                                        <div class="accordion accordion-flush" id="accordionFlushExample">           
                                            <div class="accordion-item">
                                                <?php
                                                    $counts  = 1;
                                                    if (is_array($event_tickets_booking) || is_object($event_tickets_booking))
                                                    {                     
                                                    foreach($event_tickets_booking as $event_ticket_booking){
                                                ?>
                                                    <?php $counts ++;   ?>
                                                    <div class="pricing_select">
                                                    <?php $sold_tickets = get_post_meta($event_id, 'dwt_listing_event_total_tickets', true);
                                                        $number_tikcets =  $event_ticket_booking ['no_of_tickets']; 
                                                        $tickets_desc = $event_ticket_booking ['tickets_description'];
                                                        $get_tickets = get_post_meta($event_id, 'remaining_event_tickets', true);
                                                    ?>
                                                    <div class="tickets_inner price_desc">
                                                    <?php if(isset ($tickets_desc) && $tickets_desc !=''){?>
                                                        <p class="tickets_desc"><?php echo esc_html__($tickets_desc);?></p>
                                                            <?php }?>    
                                                    
                                                    </div>
                                                        <div class="tickets_inner">
                                                            <h5><?php echo esc_html__('Price Per Ticket', 'dwt-listing');?></h5>
                                                            <h5 class="price_per_ticket"><?php  $event_price = $event_ticket_booking ['ticket_price']; echo wc_price($event_price); ?></h5>
                                                            <input type="hidden" id="price_per_ticket" name="price_per_ticket" value="<?php echo $event_price = $event_ticket_booking ['ticket_price']; ?>">
                                                        </div>
                                                        <div class="tickets_inner">
                                                            <h5><?php echo esc_html__('Total Tickets', 'dwt-listing');?></h5>
                                                            <h5 class="number_of_tickets"><?php  echo esc_attr__($number_tikcets, 'dwt-listing' ); ?>  </h5>
                                                            <input type="hidden" id="number_of_tickets" name="number_of_tickets" value="<?php echo $event_ticket_booking ['no_of_tickets']; ?>">
                                                            <input type="hidden" id="total_number_of_tickets" name="total_number_of_tickets" value="<?php echo $number_tikcets; ?>">
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                <?php }
                                                    }   
                                                   ?>
                                                <div class="number_of_tickets" id="no_of_ticket">
                                                    <h5><?php echo esc_html__('No. of Tickets', 'dwt-listing');?>                                                </h5>
                                                    <form id="myform">
                                                        <input type="button" value="+" id="increase_tickets" class="add" min='1' max="5" />       
                                                        <input type="text" id="tickets_quantity" name="ticket_quantity" max="5" value="0" class="qty tickets_qty" placeholder="0" required readonly min="1" />       
                                                        <input type="button" value="-" id="decrease_ticket" class="minus" min="1"/>
                                                        <br />
                                                        <br />
                                                    </form>
                                                        
                                                </div>
                                                <input type="hidden" name="user_name"   id="current_user_name" value="<?php echo $current_users;?>">
                                                <input type="hidden" name="event_name"  id="event_name" value="<?php echo get_the_title($event_id); ?>">
                                                <input type="hidden" name="event_date"  id="event_date" value=" <?php echo $event_start_date;?>">
                                            </div>                                                        
                                        </div> 
                                    </div>
                                    <?php }?>
                                </div>
                                <!-- event prices ends here -->

                                <!-- event extra services starts here-->
                                <div class="single-blog blog-detial events-tickets">
                                    <?php if($event_extra_services == "on"){  ?>
                                    <div class="accordion_for_question">
                                        <!--adding questions and answers sections--->
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h6 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed multi-collapse pricing_collapsed " type="button" data-toggle="collapse" data-target="#flush-collapse_e_services" aria-expanded="true" aria-controls="flush-headingOne">
                                                        <div class="pricing_select">
                                                            <h5><?php echo esc_html__('Pick Extra Services', 'dwt-listing');?> <i class="ti-angle-double-down"></i></h5>
                                                        </div>
                                                    </button>
                                                </h6>
                                                    <div id="flush-collapse_e_services" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" >
                                                <?php
                                                    $count_e_services  = 1;
                                                    if (is_array($event_e_services) || is_object($event_e_services))
                                                    {                
                                                        $count = 1;     
                                                        foreach($event_e_services as $event_ques){
                                                ?>
                                                    <?php $count_e_services ++;  ?>
                                                        <div class="accordion-body">
                                                            <div class="extra_services" >
                                                                <div class="extra_services_details">
                                                                    <?php echo $event_ques ['e_services'];  ?></br>
                                                                    <?php echo $event_ques ['camping_pitch']; ?>
                                                                    <input type="hidden" name="details_of_extra_services" id="detail_of_extra_services" value="<?php echo $event_ques ['camping_pitch'];?>">
                                                                </div>
                                                                <div class="extra_services_price">
                                                                    <h5>
                                                                        <?php echo wc_price($event_ques ['camping_site']);?>
                                                                    </h5>
                                                                    <input type="hidden" id="extra_service_prices" name="extra_service_prices" value="<?php echo $event_ques ['camping_site'];?>">
                                                                    <input type="hidden" name="details_of_extra_services" id="detail_of_extra_services" value="<?php echo $event_ques ['e_services'];?>">
                                                                    <div class="add_extra_services_price" id="extra_services-<?php echo $count;?>">
                                                                        <a href="javascript:void(0)"><i class="ti-plus"></i></a>
                                                                    </div>
                                                                    <div class="remove_extra_services_price"  id="extra_services-<?php echo $count;?>">
                                                                        <a href="javascript:void(0)"><i class="ti-minus"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>               
                                                        </div>
                                                        <?php 
                                                        $count ++;
                                                        }
                                                     }?>
                                                    </div>
                                            </div>                                                
                                        </div> 
                                    </div>

                                    <?php } ?>
                                    <div class="total">
                                        <div class="total_prices">
                                            <h5><?php echo esc_html__('Price of Tickets', 'dwt-listing'); ?></h5>
                                            <?php $currency_symbol =  get_woocommerce_currency_symbol();?>
                                            <p id="inner_sum"><?php echo esc_attr__($currency_symbol);?><?php echo esc_html__('0');?></p>
                                            <input type="hidden" id="hidden_woo_currency_symbol" value="<?php echo $currency_symbol;?>"/>
                                        </div>
                                        <div class="total_prices extra_services_list" id="extra_services_list">
                                            <div class="total_price_of_services">
                                                <h5><?php echo esc_html__('Extra Services', 'dwt-listing'); ?></h5>
                                            </div>
                                            <ul id="extra_service_list"></ul>
                                            <div class="total_price_of_services">
                                                <h5><?php echo esc_html__('Price of Extra Services', 'dwt-listing'); ?></h5>
                                                <p id="addition_ES"><?php echo esc_html__('0', 'dwt-listing'); ?></p>
                                            </div>
                                        </div>
                                        <div class="total_prices">
                                            <h5><?php echo esc_html__('Grand Total', 'dwt-listing'); ?></h5>
                                            <p id="grand_total"></p>
                                            <input type="hidden" name ="grand_total_" id="grand_total_" value =""/> 
                                            <?php
                                                global $dwt_listing_options;
                                                $admin_commission_percent_emp = $dwt_listing_options['service_charges'];
                                                $percentage = $admin_commission_percent_emp/100;    
                                            ?>
                                            <input type = "hidden" name="event_admin_commision" id="event_admin_commision" valu="<?php echo $percentage; ?>"/>
                                        </div>
                                    </div>
                                    <div class="buy_ticket make_booking" id="proceed_booking">
                                        <button type="submit" ><?php echo esc_html__('Proceed With Booking ', 'dwt-listing'); ?> <i class="ti-arrow-right"></i></button>
                                        <input type="hidden" id="event_id" name="events_id" value="<?php echo get_the_ID();?>">
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        </div>
                        <?php }}
                    ?>
                        <!-- event extra services ends here -->


                    <?php if(isset ($dwt_listing_options['event_add_to_calendar']) && $dwt_listing_options['event_add_to_calendar'] == 1){?>

                    <div class="panel panel-default side-map">
                        <div class="panel-heading">
                        <?php
                            $event_type = get_post_meta($event_id, 'dwt_listing_event_type', true);
                            if (isset($dwt_listing_options['dwt_event_type_switch']) && $dwt_listing_options['dwt_event_type_switch'] == 1) {
                                if (isset($event_type) && $event_type == 'webinar') {
                                    ?>
                                                    <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-server"></i> <?php echo esc_html__('Add Webinar To Calendar', 'dwt-listing'); ?> </a> </h4>
                                      <?php } else { ?>
                                            <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-server"></i> <?php echo esc_html__('Add Event To Calendar', 'dwt-listing'); ?> </a> </h4>
                                        <?php } ?>
                            <?php } ?>
                        </div> 
                        <div class="add-to-calendar">
                            <!-- Trigger/Open The Modal -->
                            <button id="myCalendarBtns"><?php echo esc_html__('Add To Calendar', 'dwt-listing')?></button>
                            <!-- The Modal -->
                            <div id="mycalendarModal" class="modal">
                            <!-- Modal content -->
                                <div class="modal-content">
                                    <div class="modal-top">
                                        <span class="add-to-calendar"><?php echo esc_html__('Add To Calendar', 'dwt-listing'); ?></span>
                                        <span class="close">&times;</span>
                                    </div>
                                    <div class="all-calendars">
                                        <a href="<?php echo esc_url($google_calendar_url);?>" target="_blank">
                                            <div class="google-calendar">
                                                <div class="row">
                                                    <div class="col-lg-8 m-auto">
                                                        <div class="calendar-icon">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <span><?php echo esc_html__('Google Calendar', 'dwt-listing'); ?></span>
                                                        </div>
                                                    </div>      
                                                </div>
                                            
                                            </div>
                                        </a>

                                            <!--adding outlook calendar from here-->
                                            <a href="<?php echo esc_url($outlook_calendar_url);?>" target="_blank">
                                                <div class="outlook-calendars">
                                                    <div class="row">
                                                        <div class="col-lg-8 m-auto">
                                                            <div class="calendar-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                                                    <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                                </svg>
                                                                <span><?php echo esc_html__('Outlook Calendar', 'dwt-listing'); ?> </span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                </div>
                                            </a>


                                            <!--adding yahoo calendar from here-->
                                            <a href="<?php  echo esc_url($yahoo_calendar_url);?>" target="_blank">
                                                <div class="outlook-calendars yahoo-calendar">
                                                    <div class="row">
                                                        <div class="col-lg-8 m-auto">
                                                            <div class="calendar-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                                                                <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                                                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                                                            </svg>
                                                                <span><?php echo esc_html__('Yahoo Calendar', 'dwt-listing'); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <?php }?>
                    <?php
                        $current_user = get_current_user_id(); 
                        if(isset ($dwt_listing_options['event_attendees']) && $dwt_listing_options['event_attendees'] == 1){
                            if (is_user_logged_in() && $current_user == $post->post_author)  {
                            }else{
                    ?>
                    <!---attending Event or not? --->
                    <div class="panel panel-default side-map">
                           
                            <div class="panel-heading">
                                <h4 class="panel-title"> <a href="javascript:void(0)"> <i class="ti-user"></i> <?php echo esc_html__('Event Attendies', 'dwt-listing');?> </a> </h4>
                            </div> 
                            <div class="events-attending">
                                <?php
                                    $user_id = get_current_user_id();
                                    $event_id = get_the_ID();
                                    $colors = get_post_meta($event_id, 'events_attendes',true);
                                    if(is_array($colors) && !empty($colors)  && in_array($user_id , $colors)){
                                ?>
                                <button type="button" class="btn btn-primary" event-data-delete-id="<?php echo $event_id;  ?>" id="cancel_attendance"><?php echo esc_html__('Not Going?', 'dwt-listing');?> </a></button>
                                <?php   }else {
                                ?>              
                                <button type="button" class="btn btn-primary" event-data-id="<?php echo $event_id;  ?>" id="attending_event"><?php echo esc_html__('Going', 'dwt-listing');?></button>
                                <?php   }   ?>
                            </div>
                        </div> 
                    <!---attending Event or not? --->
                    <?php }
                            }?>
                </div>

            </div>
        </div>

        </div>
    </div>
</section>