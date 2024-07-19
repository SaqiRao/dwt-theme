<?php
global $dwt_listing_options;
//listing id
if ( isset( $_GET[ 'review_id' ] ) && $_GET[ 'review_id' ] != '' ) {
    $listing_id = $_GET[ 'review_id' ];
} else {
    $listing_id = get_the_ID();
}
$get_hours=$business_hours_status='';
//if busines hours allowed
if ( get_post_meta( $listing_id, 'dwt_listing_is_hours_allow', true ) == '1' ) {
    //now check if its 24/7 or selective timimgz
    if ( get_post_meta( $listing_id, 'dwt_listing_business_hours', true ) == '1' ) {
        ?>
        <div class = 'widget-opening-hours widget'>
            <div class = 'opening-hours-title tool-tip' title = "<?php echo esc_html__('Business Hours', 'dwt-listing'); ?>">
                <img src = "<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/clock.png'); ?>" alt = "<?php echo esc_html__('not found', 'dwt-listing'); ?>">
                <span><?php echo esc_html__( 'Always Open', 'dwt-listing' );
                    ?></span>
            </div>
        </div>
        <?php
    }
    else {
        $get_hours = dwt_listing_show_business_hours( $listing_id );
        $status_type = dwt_listing_business_hours_status( $listing_id );
        
        

        if ( $status_type == 0 ) {
            
            $business_hours_status = esc_html__( 'Open. ', 'dwt-listing' );
        ?>
            
            <?php
           
            $listing_timezone_for_break = get_post_meta($listing_id, 'dwt_listing_user_timezone', true);
            if(dwt_listing_checktimezone($listing_timezone_for_break) == true) {
                if ($listing_timezone_for_break != "") {
                    
                    $status = esc_html__('fsdfsd','dwt-listing'); 
                    /*current day */
                    $current_day_today = lcfirst(date("l"));
                    
                    /*current time */
                    $date_for_break = new DateTime("now", new DateTimeZone($listing_timezone_for_break));
                    $current_time_now = $date_for_break->format('H:i:s');
                    // numaric values of open time
                    $current_time_num   =    strtotime($current_time_now);
                  
                    // start day time
                    $day_start_time = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $current_day_today . '_from', true)));
                   
                    // start day numaric value
                    $day_start_time_numeric = strtotime( $day_start_time);
                                             
                    //numaric values of opening soon
                    $day_start_time_half_hour_ago = date('H:i:s', strtotime("-30 minutes", strtotime($day_start_time)));
                    $day_start_time_half_hour_ago_numeric   = strtotime($day_start_time_half_hour_ago);

                    if($current_time_num < $day_start_time_numeric && $current_time_num  > $day_start_time_half_hour_ago_numeric)
                    {
                        $business_hours_status = esc_html__( 'Opening Soon', 'dwt-listing' );

                    }
                    
                    $current_day_today = lcfirst(date("l"));
            
                     for ($i=1; $i< 7 ; $i++) 
                     { 
                        $next_date = date('l', strtotime($current_day_today  ." + $i day"));

                        $next_day   =    lcfirst($next_date);
                        
                       $is_open  =   get_post_meta(get_the_ID() ,  '_timingz_'.lcfirst($next_day).'_open' , true); 
                    
                        if( $is_open  ==  1){


                          $start_timing  =      get_post_meta(get_the_ID() ,  '_timingz_'.lcfirst($next_day).'_from' , true);
                          
                         $business_hours_status    =    $business_hours_status ;
                                              
                                           break;
                                                   }
                    }                     

                }
            }
        }
        else {
            /* timezone of selected business hours */
            $listing_timezone_for_break = get_post_meta($listing_id, 'dwt_listing_user_timezone', true);

            if(dwt_listing_checktimezone($listing_timezone_for_break) == true) {
                if ($listing_timezone_for_break != "") {
                   
                    $current_day_for_break = lcfirst(date("l"));

                    /*current time */
                    $date_for_break = new DateTime("now", new DateTimeZone($listing_timezone_for_break));
                    $current_time_now = $date_for_break->format('H:i:s');
                    //current day
                    $current_day   = strtolower(date('l'));
                    
                    //check if current day is open or not
                    $is_break_on     =    get_post_meta($listing_id, '_timingz_break_' . $current_day . '_open', true) ;
                    // get start and end time of break of current time
                    $breeak_from1     =   get_post_meta($listing_id, '_timingz_break_' . $current_day . '_breakfrom', true);
                    $breeak_tooo1     =   get_post_meta($listing_id, '_timingz_break_' . $current_day . '_breakto', true);
                    // numaric values of current day start and end break
                    $current_time_num   =    strtotime($current_time_now);
                    $break_from_num   =   strtotime($breeak_from1);
                    $break_too_num   =  strtotime($breeak_tooo1);
                    //get start and end time of current day
                    $time_to_end = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $current_day . '_to', true)));

                    // numaric values of current day
                    $end_time_numaric=strtotime($time_to_end);

                    // numaric value of closed soon
                    $endTime11 = date('H:i:s', strtotime("-30 minutes", strtotime($time_to_end)));
                    $endTime11_num   = strtotime($endTime11);

                    if($is_break_on  == '1' &&    $current_time_num >  $break_from_num  &&   $current_time_num  <     $break_too_num  )
                    {
                        $business_hours_status = esc_html__( 'Break', 'dwt-listing' );
                    }
                    elseif ( $endTime11_num < $end_time_numaric && $current_time_num > $endTime11_num)
                    {
                        $business_hours_status = esc_html__( 'Closing Soon', 'dwt-listing' );

                    }else{
                        $business_hours_status = $break_check_button = esc_html__( 'Open Now', 'dwt-listing' );
                        
                       }  
                
        }
                }
            }
        }


        $class = '';
        if ( is_rtl() ) {
            $class = 'flip';
        }
        ?>
                           
        <div class = 'widget-opening-hours widget'>
            <div class = 'opening-hours-title tool-tip' title = "<?php echo esc_html__('Business Hours', 'dwt-listing'); ?>
            "data-toggle = 'collapse' data-target = '#opening-hours'>
                <img src = "<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/clock.png'); ?>" alt = "<?php echo esc_html__('not found', 'dwt-listing'); ?>"><span>
        <?php echo esc_attr( $business_hours_status );
        if(isset($status_type) &&  $status_type == 0){
    
        //    echo  '<span class="opens_next_day"> Will open on '. $next_day .' at '.  $start_timing  .  '</span>' ;  
         
        
         }
        ?>
        
        
        <i class = "ti-angle-down pull-right <?php echo esc_attr($class); ?>"></i>
            </div>
            <div id = 'opening-hours' class = 'collapse in'>
                <?php
                if ( get_post_meta( $listing_id, 'dwt_listing_user_timezone', true ) != '' ) {

                    echo '<div class="s-timezone">' . dwt_listing_text( 'dwt_listing_timezone_txt' ) . ' : <strong>' . get_post_meta( $listing_id, 'dwt_listing_user_timezone', true ) . '</strong></div>';
                }
                ?>
                <ul>
                    <?php

                    if ( is_array( $get_hours ) && count( $get_hours ) > 0 ){


                        foreach ( $get_hours as $key => $val ) {
                            $bk_f   =     isset($val['break_from']) && $val['break_from'] !="" ?   trim(date("g:i A", strtotime($val['break_from'])))  : "";
                            $bk_to   =    isset($val['break_too']) && $val['break_too'] !="" ?      trim(date("g:i A", strtotime($val['break_too'])))  : "";
                            $break_status='';
                            if($bk_f != '' && $bk_to !='' ){
                                $break_status =  esc_attr($bk_f) . '&nbsp - &nbsp' . esc_attr($bk_to);
                            }else{
                                $break_status= "";
                            }
                            if ($break_status != "" ){
                                $break_keyword = 'break'.':';
                            }else{
                                $break_keyword = "";
                            }
                            $class = '';
                            if ( $val[ 'current_day' ] != '' ) {
                                $class = 'current_day';
                               
                            }
                            if ($val['closed'] == 1){
                                $class = 'closed';
                                echo '' . $htm_return = '<li class="' . esc_html( $class ) . '"> 
                                 <span class="day-name"> ' . $val[ 'day_name' ] . ':</span>
                                 <span class="day-timing"> ' . esc_html__( 'Closed', 'dwt-listing' ) . ' </span> </li>';
                            }
                            else {
                                echo '' . $htm_return = ' <li class="' . esc_html( $class ) . '">
                                <span class="day-name"> ' . $val[ 'day_name' ] .':</span>
                                
                                <span class="day-name"> ' .'<br>'. $break_keyword .'</span>
                                
                                <span class="day-timing" id="day_timing"> ' . esc_attr( $val[ 'start_time' ] ) . '  -  ' . esc_attr( $val[ 'end_time' ] ) . ' </span> 
                                <span class="day-timing"> ' . $break_status . ' </span> </li>';
                            }
                            
    
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php


    }
    
    ?>
