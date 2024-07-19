<?php 
// if 
// ($price_range == "yes") { 
    ?>
    <div class="submit-listing-section l_price_form">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div id="pricing-fields">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="list_booking_payments_booking_services">
                        <!--bookings section starts here -->
                        <div class="list_booking_payments_section list_booking_booking_section">
                        <div class="list_booking_payments_section_title list_booking_booking_section_title">
                        <h3><?php echo esc_html__('Price and Number of Book Listing', 'dwt-listing'); ?> </h3>
                        <div class="switch_for_tickets_extra_services">
                           <label class="switch">
                           <?php $show_event_tickets_ = get_post_meta( $event_id, 'event_tickets_show', true ); ?>
                               <input type="checkbox" name="show_tickets_extra_services" class="switch_for_tickets_main_checkbox" <?php if(isset($show_event_tickets_) && $show_event_tickets_ =='yes') { echo 'checked';} ?>>
                                <span class="slider"></span>
                              </label>
                          </div>
                     </div>
                            <div class="event_tickets_extra_services_wrapper" >
                                <div class="pricing_booking_inputs booking_fields" id="booking_fields">   
                                    <div  id="list_book_prices" class="list_book_prices form_input_control" >
                                        <?php    
                                        $events_tickets_booking = get_post_meta($event_id, 'event_tickets_boking', true);   
                                        if(is_array($events_tickets_booking)  && !empty($events_tickets_booking)) {
                                            foreach($events_tickets_booking as $ques){?>
                                            <input class="form-control" type="text" id="tickets_description" name='event_tickets_boking[tickets_description][]' value='<?php if(isset($ques['tickets_description']) != ''); echo $ques['tickets_description']; ?>' placeholder="<?php echo esc_attr__('Description (Optional)', 'dwt-listing'); ?>">
                                            <input class="form-control" type="number" id="no_of_tickets" name='event_tickets_boking[no_of_tickets][]' value='<?php if(isset($ques['no_of_tickets']) != ""); echo $ques ['no_of_tickets']; ?>' placeholder="<?php echo esc_attr__('Number of Booking', 'dwt-listing'); ?>" min='1' required>
                                            <input class="form-control" type="number" id="ticket_price"  name='event_tickets_boking[ticket_price][]' value='<?php if(isset($ques['ticket_price']) != ''); echo $ques['ticket_price']; ?>' placeholder="<?php echo esc_attr__('Price of Boking', 'dwt-listing'); ?> " min='1' required>
                                        
                                            <?php 
                                            }    
                                        }
                                        else 
                                        {   ?>
                                            
                                            <input class="form-control" type="text" id="tickets_description" name='event_tickets_boking[tickets_description][]' value='<?php if(isset($ques['tickets_description']) != '') echo $ques['tickets_description']; ?>' placeholder="<?php echo esc_attr__('Description (Optional)', 'dwt-listing'); ?>">
                                            <input class="form-control" type="number" id="no_of_tickets" name='event_tickets_boking[no_of_tickets][]' value='<?php if(isset($ques['no_of_tickets']) != ""){echo $ques ['no_of_tickets'];}  ?>' placeholder="<?php echo esc_attr__('Number of Booking', 'dwt-listing'); ?>" min='1'  >
                                            <input class="form-control" type="number" id="ticket_price" name='event_tickets_boking[ticket_price][]' value='<?php if(isset($ques['ticket_price']) != '') {echo $ques['ticket_price'];} ?>' placeholder="<?php echo esc_attr__('Price of Booking', 'dwt-listing'); ?> " min='1'  >
                                            </br>

                                            <?php  
                                        }   ?>
                                    </div>    
                                  </div>
                                <!--some extra fields starts here-->
                             
                               </div>
                           </div> 
                        </div>
                        <!-- <div class="col-md-5 col-xs-12 col-sm-12 hidden-sm">
                            <div class="submit-post-img-container">
                                <img class="img-responsive"
                                     src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/submit-post-pricing.jpg'); ?>"
                                     alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
//  } 
 ?>  