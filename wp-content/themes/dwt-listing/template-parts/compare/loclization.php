<?php
// Theme localization Fields
if( !function_exists('dwt_short_key_options') )
{
    function dwt_short_key_options()
	{
		global $localization;
        $localization = array
	    (
		    'keyword' => esc_html__('Keyword','dwt-listing'),
	   		'dealer_name' => esc_html__('Dealer Name','dwt-listing'),
			'my_mob' => esc_html__('Mobile Number','dwt-listing'),
			'my_whatsapp' => esc_html__('WhatsApp Number','dwt-listing'),
			'my_weburl' => esc_html__('Website Url','dwt-listing'),
			'my_dealer_loc' => esc_html__('Dealer Location','dwt-listing'),
			'my_about_dealer' => esc_html__('About Dealer','dwt-listing'),
			'social_media' => esc_html__('Social Media','dwt-listing'),
			'working_hours' => esc_html__('Working Hours','dwt-listing'),
			'account_settings' => esc_html__('Account Settings','dwt-listing'),
			'desc' => esc_html__('Description Box','dwt-listing'),
			'gallery' => esc_html__('Gallery','dwt-listing'),
			'zip_code' => esc_html__('Zipcode','dwt-listing'),
			'street_location' => esc_html__('Street Address','dwt-listing'),
			'map' => esc_html__('Map','dwt-listing'),
			'coordinates' => esc_html__('Coordinates','dwt-listing'),
			'location' => esc_html__('Location (Country / State / Town)','dwt-listing'),
			'pass_required' => esc_html__('Please choose a password with at least 3-12 characters.','dwt-listing'),
			'dashboard' => esc_html__('Dashboard','dwt-listing'),
			'profile' => esc_html__('My Profile','dwt-listing'),
			'my_fb' => esc_html__('Facebook URL','dwt-listing'),
			'my_tw' => esc_html__('Twitter URL','dwt-listing'),
			'my_ln' => esc_html__('LinkedIn URL','dwt-listing'),
			'my_insta' => esc_html__('Instagram URL','dwt-listing'),
			'fav_prop' 	=>   esc_html__('Favorites Listings','dwt-listing'),
			'my_expiry' => esc_html__('Expire On','dwt-listing'),
			'my_you' => esc_html__('Youtube URL','dwt-listing'),
			'my_pint' => esc_html__('Pinterest URL','dwt-listing'),
			'my_addr' => esc_html__('Address','dwt-listing'),
			'my_coord' => esc_html__('Coordinates','dwt-listing'),
			'dealer_loc' => esc_html__('Dealer Location','dwt-listing'),
			'save_changes' => esc_html__('Save Changes','dwt-listing'),
			'request' => esc_html__('Request','dwt-listing'),
			'my_profile' => esc_html__('My Profile','dwt-listing'),
			'my_properties' => esc_html__('My Listings','dwt-listing'),
			'ad_property' => esc_html__('Add New Property','dwt-listing'),
			'pub' => esc_html__('Published','dwt-listing'),
			'pend' => esc_html__('Pending','dwt-listing'),
			'feat' => esc_html__('Featured','dwt-listing'),
			'exp' => esc_html__('Expired','dwt-listing'),
            'sold' => esc_html__('Sold','dwt-listing'),
			'a_listing' => esc_html__('Search listing','dwt-listing'),
			'action' => esc_html__('Action','dwt-listing'),
			'price' => esc_html__('Price','dwt-listing'),
			'listed_in' => esc_html__('Listed In','dwt-listing'),
			'listing' => esc_html__('Listing','dwt-listing'),
			'publish' => esc_html__('Published Listings','dwt-listing'),
			'expired' => esc_html__('Expired Listings','dwt-listing'),
			'pending' => esc_html__('Pending Listings','dwt-listing'),
			'featured' => esc_html__('Featured Listings','dwt-listing'),
            'msold' => esc_html__('Sold Listings','dwt-listing'),
			'approval' => esc_html__(' Approval Required!','dwt-listing'),
			'approval_notify' => esc_html__('Waiting for admin approval. ','dwt-listing'),
			'agents' => esc_html__('Agents','dwt-listing'),
			'agent_name' => esc_html__('Agent Name','dwt-listing'),
			'display_name' => esc_html__('Display Name','dwt-listing'),
			'add_new_agent' => esc_html__('Add New Agent','dwt-listing'),
			'view_all_agent' => esc_html__('View All Agent','dwt-listing'),
			'username' => esc_html__('Username','dwt-listing'),
			'email' => esc_html__('Email','dwt-listing'),
			'agent_type' => esc_html__('Agent Type','dwt-listing'),
			'agent_type_req' => esc_html__('Agent type is required.','dwt-listing'),
			'contact_num' => esc_html__('Mobile Number','dwt-listing'),
			'pass' => esc_html__('Password','dwt-listing'),
			'u_required' => esc_html__('Username is required.','dwt-listing'),
			'submit' => esc_html__('Submit','dwt-listing'),
			'feat_img' => esc_html__('Featured Image','dwt-listing'),
			'edit_pass' => esc_html__('Edit Password','dwt-listing'),
			'current_pass' => esc_html__('Current Password','dwt-listing'),
			'new_pass' => esc_html__('New Password','dwt-listing'),
			'conf_pass' => esc_html__('Confirm Password','dwt-listing'),
			'change_pass_btn' => esc_html__('Change My Password','dwt-listing'),
			'accn_delete' => esc_html__('Account Deletion','dwt-listing'),
			'accn_delete_msg' => esc_html__('If you want to delete your account your all data will be removed from this site.','dwt-listing'),
			'accn_delete_btn' => esc_html__('Delete My Account','dwt-listing'),
			'skype' => esc_html__('Skype','dwt-listing'),
			'working_hours' => esc_html__('Working Hours','dwt-listing'),
			'home' => esc_html__('Home','dwt-listing'),
			'page' => esc_html__('Page','dwt-listing'),
			'off' => esc_html__('of','dwt-listing'),
			'user_type' => esc_html__('User Type','dwt-listing'),
			'all_fields_error' 	=>   esc_html__('All fields are required.','dwt-listing'),
			'logout' 	=>   esc_html__('Logout','dwt-listing'),
			'signup' 	=>   esc_html__('Sign Up','dwt-listing'),
			'log' 	=>   esc_html__('Sign In','dwt-listing'),
			'or_reg' 	=>   esc_html__('Or Register With','dwt-listing'),
			'or_log' 	=>   esc_html__('Or Login With','dwt-listing'),
			'processing' 	=>   esc_html__('Processing...','dwt-listing'),
			'google' 	=>   esc_html__('Google','dwt-listing'),
			'fb' 	=>   esc_html__('Facebook','dwt-listing'),
			'details' 	=>   esc_html__('View Detials','dwt-listing'),
			'price' 	=>   esc_html__('Price','dwt-listing'),
			'mw_additional' 	=>   esc_html__('Additional Detials','dwt-listing'),
			'review_title' 	=>   esc_html__('Review Title','dwt-listing'),
			'your_review' 	=>   esc_html__('Your Review','dwt-listing'),
			'review_write' 	=>   esc_html__('Write a Review','dwt-listing'),
			'rating' 	=>   esc_html__('Rating','dwt-listing'),
			'fav' 	=>   esc_html__('Favourite','dwt-listing'),
			'favorites' 	=>   esc_html__('Favorites','dwt-listing'),
			'pkgs' 	=>   esc_html__('Packages','dwt-listing'),
			'plans' 	=>   esc_html__('Plans','dwt-listing'),
			'lplans' 	=>   esc_html__('Listing Plans','dwt-listing'),
			'pplans' 	=>   esc_html__('Profile Plans','dwt-listing'),
			'compare' 	=>   esc_html__('Compare','dwt-listing'),
			'member_since' 	=>   esc_html__('Member Since','dwt-listing'),
			'featured_listings' 	=>   esc_html__('Featured Listings ','dwt-listing'),
			'display_name' 	=>   esc_html__('Display Name','dwt-listing'),
			'displayname_popover' 	=>   esc_html__('Dealer or Buyer display name eg (Dany Motors)','dwt-listing'),
			'get_directions' 	=>   esc_html__('Get Directions','dwt-listing'),
			'working_hours' 	=>   esc_html__('Working Hours','dwt-listing'),
			'near_me' 	=>   esc_html__('Near Me','dwt-listing'),
			'verified_listing' 	=>   esc_html__('Verified Listing','dwt-listing'),
			'total_published' 	=>   esc_html__('Total Published','dwt-listing'),
			'total_pending' 	=>   esc_html__('Total Pending','dwt-listing'),
			'total_featured' 	=>   esc_html__('Total Featured','dwt-listing'),
			'total_expired' 	=>   esc_html__('Total Expired','dwt-listing'),
			'total_views' 	=>   esc_html__('Views','dwt-listing'),
			'reviews' 	=>   esc_html__('Property Reviews','dwt-listing'),
			'profile_reviews' 	=>   esc_html__('Reviews','dwt-listing'),
			'submitted' 	=>   esc_html__('Submitted Reviews','dwt-listing'),
			'received' 	=>   esc_html__('Received Reviews','dwt-listing'),
			'invoices' 	=>   esc_html__('Invoices','dwt-listing'),
			'invoice_status' 	=>   esc_html__('Status','dwt-listing'),
			'invoice_transaction' 	=>   esc_html__('Transaction ID','dwt-listing'),
			'invoice_total' 	=>   esc_html__('Total','dwt-listing'),
			'invoice_mw_id' 	=>   esc_html__('Property ID','dwt-listing'),
			'invoice_order_history' 	=>   esc_html__('Orders History','dwt-listing'),
			'invoice_method' 	=>   esc_html__('Method','dwt-listing'),
			'total_avg' 	=>   esc_html__('Total Average','dwt-listing'),
			'total_reviews' 	=>   esc_html__('Total Reviews','dwt-listing'),
			'total_stars' 	=>   esc_html__('Total Stars','dwt-listing'),
			'recommendations' 	=>   esc_html__('Recommendations','dwt-listing'),
			'welcome' 	=>   esc_html__('Welcome back,','dwt-listing'),
			'dashboard' 	=>   esc_html__('Dashboard','dwt-listing'),
			'recent_act' 	=>   esc_html__('Recent Activities','dwt-listing'),
			'stock' 	=>   esc_html__('Stock ID #','dwt-listing'),
			'manu_year' 	=>   esc_html__('Year of Manufacture ','dwt-listing'),
			'bodytype' 	=>   esc_html__('Body Type','dwt-listing'),
			'fuel' 	=>   esc_html__('Fuel','dwt-listing'),
			'make' 	=>   esc_html__('Make','dwt-listing'),
			'transmission' 	=>   esc_html__('Transmission','dwt-listing'),
			'drive' 	=>   esc_html__('Drive','dwt-listing'),
			'mileage' 	=>   esc_html__('Mileage','dwt-listing'),
			'engine' 	=>   esc_html__('Engine','dwt-listing'),
			'stock' 	=>   esc_html__('Stock #','dwt-listing'),
			'fdealers' 	=>   esc_html__('Find Dealers','dwt-listing'),
			'filter_result' 	=>   esc_html__('Filter Result','dwt-listing'),
			'offer_for' 	=>   esc_html__('Make an offer for','dwt-listing'),
			'schedule_drive' 	=>   esc_html__('Schedule test drive for','dwt-listing'),
	   );
	   return $localization;
    }
}
add_action( 'after_theme_setup', 'dwt_short_key_options' );

// Theme Error Messages
if( !function_exists('dwt_short_key_options_msgs') )
{
    function dwt_short_key_options_msgs()
	{
		global $messages;
        $messages = array
	    (
			'name_error' => esc_html__('Name field is required.','dwt-listing'),
	   		'mob_error' => esc_html__('Please enter a valid mobile number.','dwt-listing'),
			'email_error' 	=> esc_html__('You have not given a correct e-mail address.','dwt-listing'),
			'whatsapp_error' 	=> esc_html__('Please enter a WhatsApp number.','dwt-listing'),
			'office_no_error' 	=> esc_html__('Please enter a office number.','dwt-listing'),
			'fax_error' 	=> esc_html__('Fax number is required.','dwt-listing'),
			'license_error' 	=> esc_html__('License is required.','dwt-listing'),
			'tax_error' 	=> esc_html__('Tax number is required.','dwt-listing'),
			'web_url_error' 	=> esc_html__('Please enter a valid Website URL.','dwt-listing'),
			'loc_error' 	=>   esc_html__('Location is required.','dwt-listing'),
			'about_error' 	=>   esc_html__('About field is required.','dwt-listing'),
			'fb_error' 	=>   esc_html__('Please enter a valid Facebook URL.','dwt-listing'),
			'tw_error' 	=>   esc_html__('Please enter a valid Twitter URL.','dwt-listing'),
			'ln_error' 	=>   esc_html__('Please enter a valid LinkedIn URL.','dwt-listing'),
			'insta_error' 	=>   esc_html__('Please enter a valid Instagram URL.','dwt-listing'),
			'you_error' 	=>   esc_html__('Please enter a valid Youtube URL.','dwt-listing'),
			'pin_error' 	=>   esc_html__('Please enter a valid Pinterest URL.','dwt-listing'),
			'addr_error' 	=>   esc_html__('Address field is required.','dwt-listing'),
			'all_fields_error' 	=>   esc_html__('All fields are required.','dwt-listing'),
			'type_error' 	=>   esc_html__('Type fields is required.','dwt-listing'),
			'working_hours' 	=>   esc_html__('The working hours field is required.','dwt-listing'),
			'skype' 	=>   esc_html__('The skype field is required.','dwt-listing'),
			'position' 	=>   esc_html__('The position field is required.','dwt-listing'),
			//You have not answered all required fields
	   );
	   return $messages;
    }
}
add_action( 'after_theme_setup', 'dwt_short_key_options_msgs' );