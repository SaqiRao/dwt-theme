<?php
/* ------------------------------------------------ */
/* About Us Classic */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_about_us')) {
function dwt_listing_about_us()
{
	vc_map(array(
		"name" => esc_html__("About Us", 'dwt-listing') ,
		"base" => "d_about_us_base",
		"category" => esc_html__("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "icon-wpb-ui-custom_heading",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('about.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
		  
		  array(
			"group" => esc_html__("About Us", "dwt-listing"),
			"type" => "dropdown",
			"heading" => esc_html__("Background Color", 'dwt-listing') ,
			"param_name" => "section_bg",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select Background Color', 'dwt-listing') => '',
				esc_html__('White', 'dwt-listing') => '',
				esc_html__('Gray', 'dwt-listing') => 'bg-gray',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
			"description" => esc_html__("Select background color.", 'dwt-listing'),
		),

		array(
				"group" => esc_html__("About Us", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "About Heading", 'dwt-listing' ),
				"param_name" => "section_title",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),	
			
			array(
				"group" => esc_html__("About Us", "dwt-listing"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Your Tagline", 'dwt-listing' ),
				"param_name" => "section_tag_line",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			
			array(
				"group" => esc_html__("About Us", "dwt-listing"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'dwt-listing' ),
				"param_name" => "section_description",
				"value" => "",
				'edit_field_class' => 'vc_col-sm-12 vc_column',
			),
			 array(
				"group" => esc_html__("About Us", "dwt-listing"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"heading" => esc_html__( "Image", 'dwt-listing' ),
				"param_name" => "bg_img2",
				"description" => esc_html__("Recommended Size For Image should be 555x296 .png", 'dwt-listing'),
			),
			
			array(
				"group" => esc_html__("About Us", "dwt-listing"),
				"type" => "dropdown",
				"heading" => esc_html__("Select Image Position", 'dwt-listing') ,
				"param_name" => "img_postion",
				"admin_label" => true,
				"value" => array(
					esc_html__('Left', 'dwt-listing') => 'left',
					esc_html__('Right', 'dwt-listing') => 'right',
				) ,
				"description" => esc_html__("Chose image position.", 'dwt-listing'),
			),
			
			array(
		   'group' => esc_html__('Features', 'dwt-listing') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('List Features', 'dwt-listing') ,
		   'param_name' => 'about_features',
		   'value' => '',
		   'params' => array(
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Title", 'dwt-listing' ),
				  "param_name" => "features_title",
				),	
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Description", 'dwt-listing' ),
				  "param_name" => "features_desc",
				),
				array(
						 "type" => "attach_image",
						 "holder" => "bg_img",
						  "heading" => esc_html__( "Location Image", 'dwt-listing' ),
						  "param_name" => "features_img",
				),
		   )
		  ),
		),
	));
}
}

add_action('vc_before_init', 'dwt_listing_about_us');

if (!function_exists('d_about_us_base_func')) {
function d_about_us_base_func($atts, $content = '')
{	
	require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
	$img_left = $featureimg = $features =	$img_right	=	''; 
	$bg_img2	=	dwt_listing_return_img_src( $bg_img2 );
	if( isset( $bg_img2 ) && $bg_img2 !='' )
	{
		if($img_postion == '')
		{
			$img_left = '<div class="col-md-5 col-sm-12 col-xs-12"><img src="'.$bg_img2.'" class="wow center-block img-responsive" alt="'.esc_html__('Image Not Found','dwt-listing').'"></div>';
		}
		else
		{
			$img_right = '<div class="col-md-5 col-sm-12 col-xs-12"><img src="'.$bg_img2.'" class="wow  center-block img-responsive" alt="'.esc_html__('Image Not Found','dwt-listing').'"></div>';
		}
	}
	$title = '';
	if($section_title != '')
	{
		 $title = '<h2>'.$section_title.'</h2>';
	}
	$tagline = '';
	if($section_tag_line != '')
	{
		 $tagline = '<p class="large-paragraph">'.$section_tag_line.'</p>';
	}
	if (function_exists('vc_param_group_parse_atts')) {
		$rows = vc_param_group_parse_atts( $atts['about_features'] );
		if( count( $rows ) > 0 )
		{
			foreach($rows as $row )
			{
				if( isset( $row['features_title'] ) && isset( $row['features_desc'] ) )
				{
					$feature_img = '';
					if(isset($row['features_img']) && $row['features_img'] !="")
					{
						if(wp_attachment_is_image($row['features_img']))
						{
							$feature_img = dwt_listing_return_img_src($row['features_img']);
						}
						else
						{
							$feature_img	= trailingslashit( get_template_directory_uri () ) . 'assets/images/category.png';
						}
						if( isset( $feature_img ) && $feature_img !='' )
						{
							$featureimg = '<div class="icons"><img src="'.$feature_img.'" class="img-responsive" alt="'.esc_html__('Image Not Found','dwt-listing').'"></div>';
						}
					}
					$features .= '<div class="col-md-6 col-xs-12 col-sm-6">
						<!-- services grid -->
						<div class="services-grid">
							'.$featureimg.'
							<h4>'.$row['features_title'].'</h4>
						<p>'.$row['features_desc'].'</p>
						</div>
					</div>';
				}
			}
		}
	}
	
	return '<section class="about-us '.$class.' '.$bg_color.'">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			 	  '.$img_left.'
               	 	<div class="col-md-7 col-sm-12 col-xs-12">
               	 		'.$title.'
						'.$tagline.'
               	 		<p>'.$section_description.'</p>
               	 		<div class="row">
               	 			<div class="services">'.$features.'</div>
               	 		</div>
               	 	</div>
               	 	'.$img_right.'
               </div>
            </div>
         </div>
      </section>';
}
}

if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_about_us_base', 'd_about_us_base_func');
}