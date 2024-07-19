<?php
if ( !function_exists ( 'call_to_action2' ) ) {
function call_to_action2()
{
	vc_map(array(
		"name" => esc_html__("Call To Action (New)", 'dwt-listing') ,
		"base" => "d_call_action_base2",
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
				"type" => "vc_link",
				"heading" => esc_html__( "Second Button", 'dwt-listing' ),
				"param_name" => "main_link_2",
				"description" => esc_html__("Link You Want To Redirect.", "dwt-listing"),
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
add_action('vc_before_init', 'call_to_action2');
if ( !function_exists ( 'd_call_action_base_func2' ) )
{
	function d_call_action_base_func2($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$view_all_btn = ''; $button2 = $button = '';
		$button = dwt_listing_get_button($main_link, 'btn btn-theme', false , false , '');
		$button2 = dwt_listing_get_button($main_link_2, 'btn btn-white btn-theme', false , false , '');
		if( isset($bg_img) && $bg_img != "" )
		{
			$bgImageURL	=	dwt_listing_return_img_src( $bg_img );
			$style = ( $bgImageURL != "" ) ? ' style="background-image: url('.$bgImageURL.'); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
		}
	return '<div class="s-call-action" '.$style.'>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-7 col-md-7">
                    <div class="s-call-action-content">
                        <h2>'.$form_text.'</h2>
                        <h3>'.$section_title.' </h3>
                        <p> '.$section_description.'</p>
                       '.$button.'
					   '.$button2.'
                    </div>
                </div>
            </div>
        </div>
    </div>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_call_action_base2', 'd_call_action_base_func2');
}