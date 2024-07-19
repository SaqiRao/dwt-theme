<?php
if ( !function_exists ( 'dwt_listing_faqs' ) ) {
function dwt_listing_faqs()
{
	vc_map(array(
		"name" => __("FAQs", 'dwt-listing') ,
		"base" => "d_faqs_base",
		"category" => __("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "vc_icon-vc-gitem-post-excerpt",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('faq.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
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
			array
			(
				'group' => esc_html__( 'FAQ', 'dwt-listing' ),
				'type' => 'param_group',
				'heading' => esc_html__( 'Question & Answer', 'dwt-listing' ),
				'param_name' => 'cats',
				'value' => '',
				'params' => array
				(
					array(
						"type" => "textfield",
						"heading" => esc_html__("Question", 'dwt-listing') ,
						"param_name" => "title",
						"admin_label" => true,
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__("Answer", 'dwt-listing') ,
						"param_name" => "description",
						"admin_label" => true,
					),
	
				)
			),
			
			array(
				'group' => esc_html__( 'Saftey Tips', 'dwt-listing' ),
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Title", 'dwt-listing' ),
				"param_name" => "tip_section_title",
			),	
			
			array(
				'group' => esc_html__( 'Saftey Tips', 'dwt-listing' ),
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Section Description", 'dwt-listing' ),
				"param_name" => "tips_description",
			),
		
			array
				(
					'group' => esc_html__( 'Saftey Tips', 'dwt-listing' ),
					'type' => 'param_group',
					'heading' => esc_html__( 'Add Tip', 'dwt-listing' ),
					'param_name' => 'tips',
					'value' => '',
					'params' => array
					(
						carspot_generate_type( esc_html__('Tip', 'dwt-listing' ), 'textarea', 'description' ),
					)
			),
			
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_faqs');
if ( !function_exists ( 'd_faqs_base_func' ) )
{
	function d_faqs_base_func($atts, $content = '')
	{
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		extract(shortcode_atts(array('tip_section_title' => '','tips_description' => ''),$atts));
		
		$rows = vc_param_group_parse_atts( $atts['cats'] );
		$faq_html	=	'';
		if( count((array) $rows ) > 0 )
		{
			$faq_html .= '<ul class="faqs-accordion">';
			foreach($rows as $row )
			{
				if( isset( $row['title'] ) && isset( $row['description']  ) )
				{
					$faq_html .= '<li>
                           <h3 class="faqs-accordion-title"><a href="javascript:void(0)">'.esc_html($row['title']).'</a></h3>
                           <div class="faqs-accordion-content">
                              <p>'.esc_html($row['description']).'</p>
                           </div>
                        </li>';
				}
			}
			$faq_html .= '</ul>';
		}
		
		// Making tips
		$rows_tipz = vc_param_group_parse_atts( $atts['tips'] );
		$tips	=	'';
		if( count((array) $rows_tipz ) > 0 )
		{
			foreach($rows_tipz as $row_tip)
			{
				if( isset( $row_tip['description'] ))
				{
					$tips	.=	'<li>'.$row_tip['description'].'</li>';
				}
			}
		}
		
		return '<section class="faqs-section '.$class.' '.$bg_color.'" '. $style .'>
          <div class="container">
            <div class="row">
            	'. $header .'
				    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						'.$faq_html.'
				    </div>
					<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">	
						<div class="blog-sidebar">
                       	 <div class="widget">
                           <div class="widget-heading">
                              <h4 class="panel-title"><a>'.$tip_section_title.' </a></h4>
                           </div>
                           <div class="faqs-desc">
                               <p class="lead">'.$tips_description.'</p>
                              <ol>'.$tips.' </ol>
                           </div>
                        </div>
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
	dwt_listing_add_code('d_faqs_base', 'd_faqs_base_func');
}