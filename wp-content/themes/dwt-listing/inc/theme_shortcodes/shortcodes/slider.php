<?php
if ( !function_exists ( 'dwt_listing_slider_main' ) ) {
function dwt_listing_slider_main()
{
	vc_map(array(
		"name" => esc_html__("Slider", 'dwt-listing') ,
		"base" => "d_slider_main_base",
		"category" => esc_html__("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "vc_element-icon icon-wpb-images-carousel",
		"params" => array(
array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('slider.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),
		  
		  array(
			"group" => esc_html__("Basic", "dwt-listing"),
			  "type" => "checkbox",
			  "class" => "",
			  "heading" => __( "Overlay Effect", "dwt-listing" ),
			  "param_name" => "overlay_effect",
			 'std' => '1',
		),
		  

		  
		  array(
		   'group' => esc_html__('Slides', 'dwt-listing') ,
		   'type' => 'param_group',
		   'heading' => esc_html__('Slides', 'dwt-listing') ,
		   'param_name' => 'slider_group',
		   'value' => '',
		   'params' => array(
		   
		  	  array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Slide Tagline", 'dwt-listing' ),
				  "param_name" => "slide_tagline",
				),
				
				array(
				  "type" => "textfield",
				  "holder" => "div",
				  "heading" => esc_html__( "Slide Title", 'dwt-listing' ),
				  "param_name" => "slide_title",
				),
				array(
				  "type" => "textarea",
				  "holder" => "div",
				  "heading" => esc_html__( "Slide Description", 'dwt-listing' ),
				  "param_name" => "slide_desc",
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( "Button Link & Text", 'dwt-listing' ),
					"param_name" => "slide_link",
					"description" => esc_html__("Link You Want To Redirect.", 'dwt-listing'),
				),
				array(
					 "type" => "attach_image",
					 "holder" => "bg_img",
					  "heading" => esc_html__( "Slide Image", 'dwt-listing' ),
					  "param_name" => "slide_img",
				),
		   )
		  ),	
		
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_slider_main');
if ( !function_exists ( 'd_slider_main_base_func' ) )
{
	function d_slider_main_base_func($atts, $content = '')
	{
		global $dwt_listing_options;
		$additional_class = '';
		if( isset( $dwt_listing_options['dwt_listing_header-layout'] ) &&  $dwt_listing_options['dwt_listing_header-layout'] == '1')
		{
			$additional_class = 'extra-pad';
		}
		
		$style = $img_url = $view_all_btn = $desc_div = $button = ''; $tag_line = $title_div = $slides = '';
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		
		
		$rows = vc_param_group_parse_atts( $atts['slider_group'] );
		if(isset($rows) && count((array) $rows ) > 0 )
		{
			$overlay_class= '';
			if(isset($overlay_effect) && $overlay_effect == true)
			{
				$overlay_class = 'owl-parallex';
			}
			
			foreach($rows as $row )
			{
				if(isset($row['slide_tagline'] ) && $row['slide_tagline'] !='')
				{
					$tag_line = '<h4 class="fresh-arrival">'.$row['slide_tagline'].'</h4>';
				}
				if(isset($row['slide_title'] ) && $row['slide_title'] !='')
				{
					$title_div = '<h1>'.$row['slide_title'].'</h1>';
				}
				if(isset($row['slide_desc'] ) && $row['slide_desc'] !='')
				{
					$desc_div = '<p>'.$row['slide_desc'].'</p>';
				}
				if(isset($row['slide_link'] ) && $row['slide_link'] !='')
				{
					$button = dwt_listing_get_button($row['slide_link'], 'btn btn-theme btn-shop', false , false , '');
					if($button)
					{
						$view_all_btn = $button;
					}
				}
				if(isset($row['slide_img'] ) && $row['slide_img'] !='')
				{
					$img_url =  dwt_listing_return_img_src($row['slide_img'],'full');
					$style = ( $img_url != "" ) ? ' style="background: url('.$img_url.'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
				}
				$slides .= '<div class="item '.$overlay_class.'" '.$style.'>
				  <div class="container">
					<div class="row">
					   <div class="col-sm-8 col-md-6 col-xs-12 text-white">
					    '.$tag_line.'
						'.$title_div.'
						'.$desc_div.'
						'.$view_all_btn.'
					  </div>
					</div>
				  </div>
				</div>';
			}
		}

		
		
		return '<div class="landing-carousel '.$additional_class.'">
				  <div class="landing-carousel-slider owl-carousel owl-theme">
				  		'.$slides.'
				  </div>
    		  </div>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_slider_main_base', 'd_slider_main_base_func');
}