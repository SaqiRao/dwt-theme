<?php
if ( !function_exists ( 'dwt_listing_testimonials' ) ) {
function dwt_listing_testimonials()
{
	vc_map(array(
		"name" => __("Testimonials", 'dwt-listing') ,
		"base" => "d_testimonials_base",
		"category" => __("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "icon-wpb-images-carousel",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('testimonials.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "dwt-listing"),
			"type" => "dropdown",
			"heading" => esc_html__("Background Color", 'dwt-listing') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select Background Color', 'dwt-listing') => '',
				esc_html__('White', 'dwt-listing') => '',
				esc_html__('Gray', 'dwt-listing') => 'bg-gray',
				esc_html__('Image', 'dwt-listing') => 'img'
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Select background color.", 'dwt-listing'),
		),
		
		array(
			"group" => esc_html__("Basic", "dwt-listing"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'dwt-listing' ),
			"param_name" => "bg_img",
			'dependency' => array(
			'element' => 'section_bg',
			'value' => array('img'),
			) ,
		),
		
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'dwt-listing' ),
				"param_name" => "section_title",
				"description" =>  esc_html__('Title for your section ', 'dwt-listing'). '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'dwt-listing' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			
			array(
		   'group' => esc_html__('Testimonials', 'dwt-listing') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('Testimonials', 'dwt-listing') ,
		   'param_name' => 'testimonials',
		   'value' => '',
		   'params' => array(
				
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "User Name", 'dwt-listing' ),
				  "param_name" => "testi_user_name",
				),
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Description", 'dwt-listing' ),
				  "param_name" => "testi_desc",
				),
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "User Desgination", 'dwt-listing' ),
				  "param_name" => "testi_user_desg",
				),
		   )
		  ),
			
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_testimonials');
if ( !function_exists ( 'd_testimonials_base_func' ) )
{
	function d_testimonials_base_func($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$testimonials = '';
		$rows = vc_param_group_parse_atts( $atts['testimonials'] );
		if( count(  $rows ) > 0 )
		{
				foreach($rows as $row )
				{
					if(isset( $row['testi_desc'] ) )
					{
						$testimonials .= '<div class="testimonial">
						<div class="testimonial-content">
							<div class="testimonial-icon">
								<i class="fa fa-quote-left"></i>
							</div>
							<p class="description">
							   '.$row['testi_desc'].'
							</p>
						</div>
						<h3 class="title">'.$row['testi_user_name'].'</h3>
						<span class="post">'.$row['testi_user_desg'].'</span>
						</div>';
				}
			}
		}
		return '<section class="testimonial-style-2 '.$class.' '.$bg_color.'" '. $style .'>
          <div class="container">
            <div class="row">
            	'. $header .'
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		<div id="testimonial-slider" class="owl-carousel owl-theme">'.$testimonials.'</div>
			   </div>
            </div>
          </div>
        </section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_testimonials_base', 'd_testimonials_base_func');
}