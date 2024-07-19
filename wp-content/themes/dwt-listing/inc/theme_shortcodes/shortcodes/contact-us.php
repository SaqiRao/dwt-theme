<?php
if ( !function_exists ( 'dwt_listing_contact_us' ) ) {
function dwt_listing_contact_us()
{
	vc_map(array(
		"name" => __("Contact us", 'dwt-listing') ,
		"base" => "d_contact_us_base",
		"category" => __("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "icon-wpb-contactform7",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('contact.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "dwt-listing"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Contact form 7 shortcode", 'dwt-listing' ),
			"param_name" => "contact_short_code",
		),	
		
		array(
			"group" => esc_html__("Address", "dwt-listing"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'dwt-listing' ),
			"param_name" => "con_title",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		array(
			"group" => esc_html__("Address", "dwt-listing"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Your Address", 'dwt-listing' ),
			"param_name" => "con_address",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		
		
		
		array(
			"group" => esc_html__("Working Hours", "dwt-listing"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'dwt-listing' ),
			"param_name" => "con_w_title",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		array(
			"group" => esc_html__("Working Hours", "dwt-listing"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Hours", 'dwt-listing' ),
			"param_name" => "con_w_time",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		
		
		array(
			"group" => esc_html__("Contact", "dwt-listing"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'dwt-listing' ),
			"param_name" => "con_n_title",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		array(
			"group" => esc_html__("Contact", "dwt-listing"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Contact Number", 'dwt-listing' ),
			"param_name" => "con_number",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		
		array(
			"group" => esc_html__("Email", "dwt-listing"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'dwt-listing' ),
			"param_name" => "con_email_title",
			'edit_field_class' => 'vc_col-sm-12 vc_column',
		),	
		array(
			"group" => esc_html__("Email", "dwt-listing"),
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Your Email", 'dwt-listing' ),
			"param_name" => "con_email",
		),	
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_contact_us');
if ( !function_exists ( 'd_contact_us_base_func' ) )
{
	function d_contact_us_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'contact_short_code' => '',
			'con_title' => '',
			'con_address' => '',
			'con_w_title' => '',
			'con_w_time' => '',
			'con_n_title' => '',
			'con_number' => '',
			'con_email_title' => '',
			'con_email' => '',
		) , $atts));
		$email =  $number = $hours = $address = '';
		//address
		if($con_title !='' && $con_address !='')
		{
			$address = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-book"></i>
							</div>
							<div class="content-area">
							   <h4>'.$con_title.'</h4>
							   <p>'.$con_address.'</p>
							</div>
						 </div>';
		}
		//Hours
		if($con_w_title !='' && $con_w_time !='')
		{
			$hours = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-alarm-clock"></i>
							</div>
							<div class="content-area">
							   <h4>'.$con_w_title.'</h4>
							   <p>'.$con_w_time.' </p>
							</div>
						 </div>';
		}
		//Contact No
		if($con_n_title !='' && $con_number !='')
		{
			$number = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-mobile"></i>
							</div>
							<div class="content-area">
							   <h4>'.$con_n_title.'</h4>
							   <p>'.$con_number.'</p>
							</div>
						 </div>';
		}
		//Email
		if($con_email_title !='' && $con_email !='')
		{
			$email = '<div class="contact-detail-box">
							<div class="icon-box">
							   <i class="ti-email"></i>
							</div>
							<div class="content-area">
							   <h4>'.$con_email_title.'</h4>
							   <p>'.$con_email.'</p>
							</div>
						 </div>';
		}
		
		return '<section class="contact-us">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                  <div class="col-md-8 col-sm-6 col-xs-12">
                     '.do_shortcode(dwt_listing_clean_shortcode($contact_short_code)).'
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="contact-detail">
						 '.$address.'
						 '.$hours.'
						 '.$number.'
						 '.$email.'
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_contact_us_base', 'd_contact_us_base_func');
}