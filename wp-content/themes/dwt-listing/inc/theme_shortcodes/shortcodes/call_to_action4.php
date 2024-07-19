<?php
if ( !function_exists ( 'call_to_action4' ) ) {
function call_to_action4()
{
	vc_map(array(
		"name" => esc_html__("Elegent Call To Action(New)", 'dwt-listing') ,
		"base" => "d_call_action_base4",
		"category" => esc_html__("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => " vc_element-icon icon-wpb-information-white",
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('call4.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),
		   array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Tagline", 'dwt-listing' ),
				"param_name" => "form_text",
			),	
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Main Title", 'dwt-listing' ),
				"param_name" => "section_title",
				"description" =>  esc_html__('Title for your section ', 'dwt-listing'). '</strong>',
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'dwt-listing' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "vc_link",
				"heading" => esc_html__( "Button Link", 'dwt-listing' ),
				"param_name" => "main_link",
				"description" => esc_html__("Link You Want To Ridirect.", 'dwt-listing'),
			),
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Background Image", 'dwt-listing' ),
				"param_name" => "bg_img",
			),
			
			array(
			"group" => esc_html__("Content Area", "dwt-listing"),
			"type" => "dropdown",
			"heading" => esc_html__("SHow Additional Image", 'dwt-listing') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				esc_html__('SHow Additional Image', 'dwt-listing') => '',
				esc_html__('Yes', 'dwt-listing') => 'yes',
				esc_html__('No', 'dwt-listing') => ''
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Image should be PNG.", 'dwt-listing'),
		),
			
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Additional Png Image", 'dwt-listing' ),
				"param_name" => "app_img",
				'dependency' => array('element' => 'section_bg','value' => array('yes')),
			),
			array(
			   'group' => esc_html__('Inspection List', 'dwt-listing') ,
			   'type' => 'param_group',
			   'heading' => esc_html__('Add Inspection List', 'dwt-listing') ,
			   'param_name' => 'inspection',
			   'value' => '',
			   'params' => array(
					
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__( "List", 'dwt-listing' ),
						"param_name" => "inspection_list",
					),
				 
			   )
			  ),
		),
	));
}
}
add_action('vc_before_init', 'call_to_action4');
if ( !function_exists ( 'd_call_action_base_func4' ) )
{
	function d_call_action_base_func4($atts, $content = '')
	{
		$add_img_html = '';
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$view_all_btn = ''; $button = '';
		$button = dwt_listing_get_button($main_link, 'btn btn-theme', false , false , '<i class="fa fa-angle-right"></i>');
		if( isset($bg_img) && $bg_img != "" )
		{
			$bgImageURL	=	dwt_listing_return_img_src( $bg_img );
			echo '<style>.car-inspection .c-img-raper::before
			 {
				background:  url('.$bgImageURL.') no-repeat;
				background-attachment: fixed;
				background-position: center top;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			</style>';
		}
		$show_pattern = '';	
		if(!empty($section_bg) && $section_bg == 'yes')
		{
			if( isset($app_img) && $app_img != "" )
			{
				if(wp_attachment_is_image($app_img))
				{
					$ad_img	=	dwt_listing_return_img_src( $app_img );
					$add_img_html = '<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
									<span class="c-auto-mechanic hidden-sm hidden-xs"><img src="'.$ad_img.'" alt="'.esc_attr__('image not found','dwt-listing').'" ></span>
								</div>';
				}
			}
		}
		$inspection_list = '';
		$rows = vc_param_group_parse_atts( $atts['inspection'] );
		if( count((array) $rows ) > 0 )
		{
			$inspection_list = '';
			foreach($rows as $row )
			{
				if(isset($row['inspection_list']))
				{
					 $inspection_list .= '<li class="col-md-4 col-sm-6 col-xs-12"> <i class="fa fa-check"></i> '.$row['inspection_list'].'</li>';
				}
			}
		}
		return '<section class="contact-section section-padding car-inspection">
                <div class="c-img-raper" '.$style.'>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="c-insp-cont">
                                    <div class="row">
                                        <h3>'.$form_text.'</h3>
                                        <h2>'.$section_title.'</h2>
                                        <p> '.$section_description.'</p>
                                        <ul>
                                           '.$inspection_list.'
                                        </ul>
										'.$button.'
                                    </div>
                                </div>
                            </div>
                            '.$add_img_html.'
                        </div> 
                    </div>
                </div>
</section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_call_action_base4', 'd_call_action_base_func4');
}