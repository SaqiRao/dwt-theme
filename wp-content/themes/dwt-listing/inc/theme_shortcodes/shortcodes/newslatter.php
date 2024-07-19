<?php
if ( !function_exists ( 'dwt_listing_newsletter' ) )
{
	function dwt_listing_newsletter()
	{
		vc_map(array(
			"name" => __("Newsletter", 'dwt-listing') ,
			"base" => "d_newsletter_base",
			"category" => __("Theme Shortcodes", 'dwt-listing') ,
			 "icon" => "icon-wpb-ui-button",
			"params" => array(
			array(
			   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
			   'type' => 'custom_markup',
			   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
			   'param_name' => 'order_field_key',
			   'description' => dwt_listing_VCImage('notify.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
			  ),	
				array(
					"group" => esc_html__("Basic", "dwt-listing"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "News Letter Heading", 'dwt-listing' ),
					"param_name" => "section_title",
					"description" =>  esc_html__('Title for your section ', 'dwt-listing'). '</strong>',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),	
				array(
					"group" => esc_html__("Basic", "dwt-listing"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Button Text", 'dwt-listing' ),
					"param_name" => "section_description",
					"value" => "",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				
			),
		));
	}
}
add_action('vc_before_init', 'dwt_listing_newsletter');
if ( !function_exists ( 'd_newsletter_base_func' ) )
{
	function d_newsletter_base_func($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$icon = esc_url(trailingslashit(get_template_directory_uri()).'assets/images/bullhorn.png');
			return '<section class="subscribe-section">
			<div class="container">
			<div class="row">
			  <div class="col-md-12 col-xs-12 col-sm-12 nopadding">
				<div class="col-md-1 col-sm-1 col-xs-12">
				  <div class="announcement-img"> <img src="'.$icon.'" class="img-responsive" alt="'.esc_html__('not found','dwt-listing').'"> </div>
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12">
				  <div class="heading-2">
					<h3>'.$section_title.'</h3>
				  </div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <div class="subscription-form">
					<form id="dwt_listing_news_latter" data-disable="false" method="post">
					  <div class="form-group">
						<input name="news_email" id="news_email" class="form-control" type="email" required>
					  </div>
					  <div class="with-errors"></div>
					  <div class="form-group submit-btn">
						<button class="form-control sonu-button btn-theme" type="submit" data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i> '.esc_html__("Processing...", 'dwt-listing').'">'.$section_description.'</button>
					  </div>
					</form>
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
	dwt_listing_add_code('d_newsletter_base', 'd_newsletter_base_func');
}