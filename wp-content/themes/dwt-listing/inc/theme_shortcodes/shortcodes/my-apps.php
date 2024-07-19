<?php
if ( !function_exists ( 'dwt_listing_my_apps' ) ) {
function dwt_listing_my_apps()
{
	vc_map(array(
		"name" => __("App Section", 'dwt-listing') ,
		"base" => "d_my_apps_base",
		"category" => __("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "icon-wpb-call-to-action",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('app.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
		  ),	
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Background Image", 'dwt-listing' ),
				"param_name" => "bg_img",
				"description" => esc_html__("1280x800", 'dwt-listing'),
			),
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "attach_image",
				"holder" => "bg_img",
				"class" => "",
				"heading" => esc_html__( "Main Image", 'dwt-listing' ),
				"param_name" => "app_img",
				"description" => esc_html__("400x500", 'dwt-listing'),
			),
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Tagline", 'dwt-listing' ),
				"param_name" => "section_tag_line",
			),	
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'dwt-listing' ),
				"param_name" => "section_title",
			),	
			array(
				"group" => esc_html__("Basic", "dwt-listing"),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'dwt-listing' ),
				"param_name" => "section_description",
			),
			array(
				"group" => esc_html__("Android", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Download Link", 'dwt-listing' ),
				"param_name" => "a_link",
			),
			array(
				"group" => esc_html__("IOS", "dwt-listing"),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Download Link", 'dwt-listing' ),
				"param_name" => "ios_link",
			),		
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_my_apps');
if ( !function_exists ( 'd_my_app_base_func' ) )
{
	function d_my_app_base_func($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$locations_html = '';
		$style = '';
		if( isset($bg_img) && $bg_img != "" )
		{
			$bgImageURL	=	dwt_listing_return_img_src( $bg_img );
			$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') scroll center center / cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
		}
		$mobile_img = '';
		if( isset($app_img) && $app_img != "" )
		{
			$mobile_img = '<div class="col-md-6 col-sm-12 col-xs-12">
			<img class="img-responsive" src="'.dwt_listing_return_img_src( $app_img ).'" alt="'.esc_html__('DWT Listing app', 'dwt-listing' ).'">
			</div>';
		}
		
		$apps = '';
		if( $a_link != "" )
		{
			$apps .= '<a href="'.esc_url($a_link).'" class=" btn btn-custom">
                     	<img src="'. esc_url(trailingslashit( get_template_directory_uri () ) . 'assets/images/android.png').'" class="img-responsive" alt="'.esc_html__('android icon','dwt-listing').'"> 
                        <span class="text">'.esc_html__('Download from','dwt-listing').'</span>
                        <span class="app-name">'.esc_html__('Play Store','dwt-listing').'</span>
                     </a>';	
		}
		if( $ios_link != "" )
		{
			$apps .= '<a href="'.esc_url($ios_link).'" class="btn btn-custom">
					<img src="'. esc_url(trailingslashit( get_template_directory_uri () ) . 'assets/images/apple-store.png').'" class="img-responsive" alt="'.esc_html__('ios icon','dwt-listing').'"> 
                         <span class="text">'.esc_html__('Download from','dwt-listing').'</span>
                        <span class="app-name">'.esc_html__('App Store','dwt-listing').'</span>
                     </a>';	
		}
		
		return '<section class="app-section bg-gray" '.$style.'>
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="heading-2">
                     <h3>'.$section_tag_line.'</h3>
                     <h2>'.$section_title.'</h2>
                  </div>
                  <p>'.$section_description.'</p>
                  <div class="apps-buttons">'.$apps.'</div>
               </div>
               '.$mobile_img.'
            </div>
         </div>
      </section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_my_apps_base', 'd_my_app_base_func');
}