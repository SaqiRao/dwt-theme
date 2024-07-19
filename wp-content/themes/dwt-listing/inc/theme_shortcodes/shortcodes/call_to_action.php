<?php
if ( !function_exists ( 'call_to_action' ) ) {
function call_to_action()
{
	vc_map(array(
		"name" => esc_html__("Call To Action", 'dwt-listing') ,
		"base" => "d_call_action_base",
		"category" => esc_html__("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => " vc_element-icon icon-wpb-information-white",
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('action.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
		
			array(
				"group" => esc_html__("Content Area", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'dwt-listing' ),
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
		),
	));
}
}
add_action('vc_before_init', 'call_to_action');
if ( !function_exists ( 'd_call_action_base_func' ) )
{
	function d_call_action_base_func($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$view_all_btn = ''; $button = '';
		$button = dwt_listing_get_button($main_link, 'btn btn-theme', false , false , '');

		if($button)
		{
			$view_all_btn = $button;
		}
		if( isset($bg_img) && $bg_img != "" )
		{
			$bgImageURL	=	dwt_listing_return_img_src( $bg_img );
			$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') no-repeat fixed center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
		}
		
		return '<section class="call-to-action" '.$style.'>
        	<div class="container">
                <div class="row">
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<h2> '.$section_title.' </h2>
                        <p> '.$section_description .'</p>
                        '.$view_all_btn.';
                    </div>
                </div>
             </div>                	
        </section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_call_action_base', 'd_call_action_base_func');
}