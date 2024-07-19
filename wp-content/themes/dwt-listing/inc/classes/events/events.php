<?php
if (!class_exists('dwt_listing_events')) {

    class dwt_listing_events {

        // user object
        var $user_info;

        public function __construct() {
            $this->user_info = get_userdata(get_current_user_id());
        }

        // Get User Events Grid
        function dwt_listing_event_type_grid($event_id, $is_ajax = '') {

            /* == set the status 0 if event end date is expired. == */
            $my_url = '';
            $my_url = dwt_listing_get_current_url();
            if (strpos($my_url, 'listing.downtown-directory.com') !== false) {
                
            } else {
                dwt_listing_check_event_ending($event_id);
            }

            $col_size = 'col-lg-4 col-sm-6 col-xs-12 masonery_item';
            $animation = 'foo';
            if (dwt_listing_text("dwt_listing_event_layout") == "map" && is_page_template('page-events.php')) {
                $col_size = 'col-lg-6 col-sm-6 col-xs-12 masonery_item';
                $animation = '';
            }
            if (!empty($_POST['map_col']) && $_POST['map_col'] == '6') {
                $col_size = 'col-lg-6 col-sm-6 col-xs-12 masonery_item';
                $animation = '';
            }
            if (is_tax(array('l_event_cat', 'l_event_tags')) && dwt_listing_text("dwt_listing_event_layout") == "map") {
                $col_size = 'col-lg-6 col-sm-6 col-xs-12 masonery_item';
                $animation = '';
            }
            $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id);
            if ($event_venue != "") {
                $event_venue_loc = '<span><i class="fa fa-location-arrow"></i>' . $event_venue . '</span>';
            }
            if ($event_start_date != "" && $event_end_date != "") {
                $event_start = date_i18n(get_option('date_format'), strtotime($event_start_date));
                $event_end = date_i18n(get_option('date_format'), strtotime($event_end_date));

                $event_dates = '<div class="event-dates">
					' . $event_start . ' - ' . $event_end . '
				</div>';
            }

            $clock_icon = '<div class="dwt_listing_timer-icon"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Event Will Begin In', 'dwt-listing') . '"></i></div>';
            $custom_color = '';
            //if event is started
            if (dwt_listing_check_event_starting($event_id) == '0') {
                $custom_color = 'eventz-statred';
                $clock_icon = '<div class="dwt_listing_timer-icon green-clock"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Event Started', 'dwt-listing') . '"></i></div>';
            }
            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');

            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));

            return '<div class="' . esc_attr($col_size) . '">
        <div class="list-contain-area ' . esc_attr($animation) . '">
          <div class="list-boxes-submit-area">
		  
            <div class="list-style-images-area"><a  href="' . get_the_permalink($event_id) . '"> 
            <img src="' . dwt_listing_return_event_idz($media, 'dwt_listing_locations-thumb') . '" alt="' . $replace_title . '" class="event-img img-responsive"></a>
			<div class="event-catz">' . $categories . '</div>  
			 <div class="profile-avtar">
				<a href="' . esc_url($get_user_url) . '"><img src="' . $get_user_dp . '" class="img-responsive" alt="' . $replace_title . '"></a>
			 </div>
			<div class="overlays list-contain-text"> 
              <h2><a  href="' . get_the_permalink($event_id) . '">' . dwt_listing_words_count($replace_title, dwt_listing_text('grid_title_limit')) . '</a></h2>
			  ' . $event_dates . '
              ' . $event_venue_loc . '
          </div>
            </div>
          <div class="list-bottom-area ' . $custom_color . '">
			  ' . $clock_icon . '
			  <div class="dwt_listing_timer-count">
					<div class="dwt_listing_countdown-timer">
						<div class="timer-countdown-box">
							<div class="countdown dwt_listing_custom-timer" data-countdown-time="' . esc_attr($event_start_date) . '"></div>
						</div>
					</div>
			  </div>
		   </div>
        </div>
      </div></div>';
        }

        // Get User Events List View
        function dwt_listing_event_type_list($event_id, $animation = '') {
            $timimgs = $time_from = $time_to = $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id, 'type_2');
            if ($event_venue != "") {
                $venue = esc_html__('Venue', 'dwt-listing');
                $event_venue_loc = '<li><i class="fa fa-location-arrow"></i> <strong>' . $venue . '</strong> : ' . $event_venue . '</li>';
            }
            if ($event_start_date != "") {
                $from = esc_html__('From', 'dwt-listing');
                $event_start = '<li><i class="fa fa-clock-o"></i> <strong>' . $from . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_start_date)) . '</li>';
            }
            if ($event_end_date != "") {
                $to = esc_html__('To', 'dwt-listing');
                $event_end = '<li><i class="fa fa-calendar" aria-hidden="true"></i> <strong>' . $to . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_end_date)) . '</li>';
            }

            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');
            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));
            return '<div class="col-lg-6 col-sm-6 events-type-list">
					<div class="ads-list-archive">
							  <div class="col-md-5 col-sm-4 col-xs-12 nopadding">
								 <div class="ad-archive-img">
									<div class="event-imagez">
										<a href="' . get_the_permalink($event_id) . '">
											<img src="' . dwt_listing_return_event_idz($media, 'dwt_listing_locations-thumb') . '" alt="' . $replace_title . '" class="img-responsive"> 
										</a>
									 </div>
								 </div>
							  </div>
							  <div class="col-md-7 col-sm-12 col-xs-12">
								 <div class="ad-archive-desc">
								 ' . $categories . '
									<h3><a href="' . get_the_permalink($event_id) . '">' . $replace_title . '</a></h3>
									<div class="clearfix visible-xs-block"></div>
									<div class="event-stats">
										<ul>
											' . $event_start . '
											' . $event_end . '
											' . $event_venue_loc . '
										</ul>
									</div>
									<div class="clearfix archive-history">
									   <div class="ad-meta">
											<a href="' . get_the_permalink($event_id) . '" class="read-more"> ' . esc_html__('View Detail', 'dwt-listing') . '</a>
									   </div>
									</div>
								 </div>
							  </div>
						   </div>
				  </div>';
        }

        // Get User Events Slider View
        function dwt_listing_event_type_slider($event_id) {
            $timimgs = $time_from = $time_to = $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id, 'type_2');
            if ($event_venue != "") {
                $event_venue_loc = '<a class="event-business-name" href="javascript:void(0)">' . $event_venue . '</a>';
            }
            if ($event_start_date != "" && $event_end_date != "") {
                $event_start = date_i18n(get_option('date_format'), strtotime($event_start_date));
                $event_end = date_i18n(get_option('date_format'), strtotime($event_end_date));
                $event_dates = $event_start . ' - ' . $event_end;
            }
            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');

            $get_user_name = dwt_listing_listing_owner($event_id, 'name');

            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));

            return '<div class="event-inner"> <span class="event-date">' . $event_dates . '</span>
              <blockquote> <a href="' . get_the_permalink($event_id) . '">' . $replace_title . '</a> </blockquote>
              <div class="event-author-box">
                <div class="tg-authorholder"> <a href="' . $get_user_url . '"><img src="' . $get_user_dp . '" class="img-responsive" alt="' . $replace_title . '"></a>
                  <div class="event-author-detail">
                    <div class="event-author">
                      <h2><a href="' . $get_user_url . '">' . $get_user_name . '</a></h2>
                      ' . $event_venue_loc . '
					  </div>
                  </div>
                </div>
              </div>
            </div>';
        }

        // Get User Events Grid
        function dwt_listing_event_type_widget($event_id, $animation = '') {
            $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id);
            if ($event_venue != "") {
                $event_venue_loc = '<span><i class="fa fa-location-arrow"></i>' . $event_venue . '</span> </div>';
            }
            if ($event_start_date != "" && $event_end_date != "") {
                $event_start = date_i18n(get_option('date_format'), strtotime($event_start_date));
                $event_end = date_i18n(get_option('date_format'), strtotime($event_end_date));
                $event_dates = '<div class="event-dates">
					' . $event_start . ' - ' . $event_end . '
				</div>';
            }

            $clock_icon = '<div class="dwt_listing_timer-icon"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Event Will Begin In', 'dwt-listing') . '"></i></div>';
            $custom_color = '';
            //if event is started
            if (dwt_listing_check_event_starting($event_id) == '0') {
                $custom_color = 'eventz-statred';
                $clock_icon = '<div class="dwt_listing_timer-icon green-clock"><i class="tool-tip fa fa-clock-o"  title="' . esc_html__('Event Started', 'dwt-listing') . '"></i></div>';
            }
            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');

            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));
            return '<div class="masonery_item">
        <div class="list-contain-area foo">
          <div class="list-boxes-submit-area">
		  
            <div class="list-style-images-area"> <a  href="' . get_the_permalink($event_id) . '"><img src="' . dwt_listing_return_event_idz($media, 'dwt_listing_locations-thumb') . '" alt="' . $replace_title . '" class="event-img img-responsive"></a>
			<div class="event-catz">' . $categories . '</div>  
			 <div class="profile-avtar">
				<a href="' . esc_url($get_user_url) . '"><img src="' . $get_user_dp . '" class="img-responsive" alt="' . $replace_title . '"></a>
			 </div>
			
			<div class="overlays list-contain-text"> 
              <h2><a  href="' . get_the_permalink($event_id) . '">' . dwt_listing_words_count($replace_title, dwt_listing_text('grid_title_limit')) . '</a></h2>
			  ' . $event_dates . '
              ' . $event_venue_loc . '
          </div>
            </div>
  
        </div>
      </div>';
        }

        // Events for map
        function dwt_listing_event_type_map($event_id, $animation = '') {
            /* == set the status 0 if event end date is expired. == */
            $my_url = '';
            $my_url = dwt_listing_get_current_url();
            if (strpos($my_url, 'listing.downtown-directory.com') !== false) {
                
            } else {
                dwt_listing_check_event_ending($event_id);
            }

            $timimgs = $time_from = $time_to = $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id, 'type_2');
            $lat = get_post_meta($event_id, 'dwt_listing_event_lat', true);
            $long = get_post_meta($event_id, 'dwt_listing_event_long', true);
            if ($event_venue != "") {
                $venue = esc_html__('Venue', 'dwt-listing');
                $event_venue_loc = '<li><i class="fa fa-location-arrow"></i> <strong>' . $venue . '</strong> : ' . $event_venue . '</li>';
            }
            if ($event_start_date != "") {
                $to = esc_html__('From', 'dwt-listing');
                $event_start = '<li><i class="fa fa-clock-o"></i> <strong>' . $to . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_start_date)) . '</li>';
            }
            if ($event_end_date != "") {
                $from = esc_html__('To', 'dwt-listing');
                $event_end = '<li><i class="fa fa-calendar" aria-hidden="true"></i> <strong>' . $from . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_end_date)) . '</li>';
            }

            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');
            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));
            return '{
						"title":"' . dwt_listing_words_count($replace_title, dwt_listing_text('grid_title_limit')) . '",
						"img":"' . dwt_listing_return_event_idz($media, 'dwt_listing_user-dp') . '",
						"event_link":"' . get_the_permalink($event_id) . '",
						"cat":\'' . $categories . '\',
						"to":\'' . $event_start . '\',
						"from":\'' . $event_end . '\',
						"venue":\'' . $event_venue_loc . '\',
						"lat":' . $lat . ',
						"lng":' . $long . '
					},';
        }

        /* Events for map ajax */

        function dwt_listing_event_type_map_ajax($event_id, $animation = '') {
            $timimgs = $time_from = $time_to = $clock_icon = $event_dates = $event_start = '';
            $event_venue_loc = $event_end = '';
            //get media
            $media = dwt_listing_fetch_event_gallery($event_id);
            $event_start_date = get_post_meta($event_id, 'dwt_listing_event_start_date', true);
            $event_end_date = get_post_meta($event_id, 'dwt_listing_event_end_date', true);
            $event_venue = get_post_meta($event_id, 'dwt_listing_event_venue', true);
            $categories = dwt_listing_events_assigned_cats($event_id, 'type_2');
            $lat = get_post_meta($event_id, 'dwt_listing_event_lat', true);
            $long = get_post_meta($event_id, 'dwt_listing_event_long', true);
            if ($event_venue != "") {
                $venue = esc_html__('Venue', 'dwt-listing');
                $event_venue_loc = '<li><i class="fa fa-location-arrow"></i> <strong>' . $venue . '</strong> : ' . $event_venue . '</li>';
            }
            if ($event_start_date != "") {
                $to = esc_html__('From', 'dwt-listing');
                $event_start = '<li><i class="fa fa-clock-o"></i> <strong>' . $to . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_start_date)) . '</li>';
            }
            if ($event_end_date != "") {
                $from = esc_html__('To', 'dwt-listing');
                $event_end = '<li><i class="fa fa-calendar" aria-hidden="true"></i> <strong>' . $from . '</strong> : ' . date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($event_end_date)) . '</li>';
            }

            //user dp
            $get_user_dp = dwt_listing_listing_owner($event_id, 'dp');
            //user dp
            $get_user_url = dwt_listing_listing_owner($event_id, 'url');

            $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($event_id))));
            return '{
						"title":"' . dwt_listing_words_count($replace_title, dwt_listing_text('grid_title_limit')) . '",
						"img":"' . dwt_listing_return_event_idz($media, 'dwt_listing_user-dp') . '",
						"event_link":"' . get_the_permalink($event_id) . '",
						"cat":\'' . $categories . '\',
						"to":\'' . $event_start . '\',
						"from":\'' . $event_end . '\',
						"venue":\'' . $event_venue_loc . '\',
						"lat":' . $lat . ',
						"lng":' . $long . '
					},';
        }

    }

}