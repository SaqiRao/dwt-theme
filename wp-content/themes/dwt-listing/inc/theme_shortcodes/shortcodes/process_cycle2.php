<?php
if ( !function_exists ( 'dwt_listing_process_cycle2' ) ) {
function dwt_listing_process_cycle2()
{
	vc_map(array(
		"name" => esc_html__("How It Works (New)", 'dwt-listing') ,
		"base" => "d_process_base2",
		"category" => esc_html__("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "vc_element-icon icon-wpb-graph",
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('process2.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "dwt-listing"),
			"type" => "dropdown",
			"heading" => esc_html__("Background Color", 'dwt-listing') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select an option', 'dwt-listing') => '',
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
			
			array
			(
				'group' => esc_html__( 'Steps', 'dwt-listing' ),
				'type' => 'param_group',
				'heading' => esc_html__( 'Select Category', 'dwt-listing' ),
				'param_name' => 'process_steps',
				'value' => '',
				'params' => array
				(
				   array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__( "Process Number", 'dwt-listing' ),
						"param_name" => "count_txt",
						"description" =>  esc_html__('Example 01 ', 'dwt-listing'). '</strong>',
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),	
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__( "Title", 'dwt-listing' ),
						"param_name" => "process_title",
						"description" =>  esc_html__('Title for your section ', 'dwt-listing'). '</strong>',
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),	
					array(
						"type" => "textarea",
						"holder" => "div",
						"class" => "",
						"heading" => esc_html__( "Description", 'dwt-listing' ),
						"param_name" => "process_desc",
						"value" => "",
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),
					array(
						"type" => "attach_image",
						"holder" => "bg_img",
						"class" => "",
						"heading" => esc_html__( "Image", 'dwt-listing' ),
						"param_name" => "process_img",
						"value" => "",
						'edit_field_class' => 'vc_col-sm-12 vc_column',
						"description" => dwt_listing_make_link ( 'https://www.flaticon.com/' , esc_html__( 'Recommended Image size 64x64' , 'dwt-listing' ) ),
					),
				)
			),
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_process_cycle2');
if ( !function_exists ( 'd_process_base_func2' ) )
{
	function d_process_base_func2($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$count_txt = $img_html  = $img_url = $process_desc = $process_html = $process_title = '';
		$rows = vc_param_group_parse_atts( $atts['process_steps'] );
		if(isset($rows) && count((array) $rows ) > 0 )
		{
			foreach($rows as $row )
			{
				if(isset($row['process_title'] ) && $row['process_title'] !='')
				{
					$process_title = '<div class="hiw-heading"><h2>'.$row['process_title'].' </h2></div>';
				}
				if(isset($row['process_desc'] ) && $row['process_desc'] !='')
				{
					$process_desc = '<div class="hiw-details-text"><p>'.$row['process_desc'].'</p></div>';
				}
				if(isset($row['count_txt'] ) && $row['count_txt'] !='')
				{
					$count_txt = '<div class="hiw-count"> '.esc_attr($row['count_txt']).' </div>';
				}
				if(isset($row['process_img'] ) && $row['process_img'] !='')
				{
					if(wp_attachment_is_image($row['process_img']))
					{
						$img_url =  dwt_listing_return_img_src($row['process_img']);
					}
					else
					{
						$img_url	= trailingslashit( get_template_directory_uri () ) . 'assets/images/category.png';
					}
					$img_html  = '<div class="hiw-img-box">
									      '.$count_txt.'
									  		<img src="'.esc_url(trailingslashit( get_template_directory_uri () ) . 'assets/images/layer.png').'" class="img-responsive" alt="'.esc_html__('not found','dwt-listing').'">
									  <div class="hiw-img-2"> <img src="'.esc_url($img_url).'" class="img-responsive" alt="'.esc_html__('not found','dwt-listing').'"> </div>
            					  </div>';
				}
				$process_html .= '<div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
					  <div class="hiw-single-box">
							'.$img_html.'
							<div class="hiw-text-box">
							  '.$process_title.'
							   '.$process_desc.'
							</div>
						</div>
				</div>';
			}
		}
		return '<section class="how-it-work-section '.$class.'" '. $style .'>
		  <div class="container">
			<div class="row">
			   '. $header .'
			   <div class="clearfix"></div>
			</div>
		  </div>
		</section>
		<div class="extra-points"><div class="container"><div class="hiw-main-box"><div class="row">
					'.$process_html.'
		</div></div></div></div><div class="clearfix"></div>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_process_base2', 'd_process_base_func2');
}