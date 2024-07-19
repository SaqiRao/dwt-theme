<?php
if ( !function_exists ( 'dwt_listing_shop_tabs' ) ) {
function dwt_listing_shop_tabs()
{
	vc_map(array(
		"name" => __("Shop With Tabs", 'dwt-listing') ,
		"base" => "d_shop_tab_base",
		"category" => __("Theme Shortcodes", 'dwt-listing') ,
		 "icon" => "vc_element-icon icon-wpb-woocommerce",
		"params" => array(
		array(
		   'group' => __( 'Shortcode Output', 'dwt-listing' ),  
		   'type' => 'custom_markup',
		   'heading' => __( 'Shortcode Output', 'dwt-listing' ),
		   'param_name' => 'order_field_key',
		   'description' => dwt_listing_VCImage('shop_tabs.png') . __( 'Ouput of the shortcode will be look like this.', 'dwt-listing' ),
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
				"group" => esc_html__("Basic", 'dwt-listing'),
				"type" => "vc_link",
				"heading" => esc_html__( "View All Products Link", 'dwt-listing' ),
				"param_name" => "main_link",
				"description" => esc_html__("Link You Want To Redirect.", 'dwt-listing'),
			),
			
			array(
				"group" => esc_html__("Products Settings", "dwt-listing"),
				"type" => "dropdown",
				"heading" => esc_html__("Number fo Products", 'dwt-listing') ,
				"param_name" => "max_limit",
				"admin_label" => true,
				"value" => range( 1, 50 ),
			),
			
			 array(
			"group" => esc_html__("Products Settings", "dwt-listing"),
			"type" => "dropdown",
			"heading" => esc_html__("Order By", 'dwt-listing') ,
			"param_name" => "ad_order",
			"admin_label" => true,
			"value" => array(
				esc_html__('Select Listing order', 'dwt-listing') => '',
				esc_html__('Oldest', 'dwt-listing') => 'asc',
				esc_html__('Latest', 'dwt-listing') => 'desc',
				esc_html__('Random', 'dwt-listing') => 'rand'
			  ) ,
		  ),
			array
			(
				'group' => esc_html__( 'Categories', 'dwt-listing' ),
				'type' => 'param_group',
				'heading' => esc_html__( 'Select Category', 'dwt-listing' ),
				'param_name' => 'cats',
				'value' => '',
				'params' => array
				(
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Category", 'dwt-listing') ,
						"param_name" => "cat",
						"admin_label" => true,
						"value" => dwt_listing_get_parests_cats('product_cat','no'),
					),
				)
			),
		),
	));
}
}
add_action('vc_before_init', 'dwt_listing_shop_tabs');
if ( !function_exists ( 'd_shop_tab_base_func' ) )
{
	function d_shop_tab_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'cats' => '',
			'ad_order' => '',
			'max_limit' => '',
			'main_link' =>'',
			'shop_type' =>'',
		) , $atts));
		$view_all_btn = '';
		require trailingslashit( get_template_directory () ) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
		$button = '';
		$button = dwt_listing_get_button($main_link, 'btn btn-theme', false , false , '');
		if($button)
		{
			$view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">'.$button.'</div>
				</div>';
		}
		$cats =	array();
		$rows = vc_param_group_parse_atts( $atts['cats'] );
		$categories_html	= '';
		$categories_contents	= '';
		$counnt = 1;

		$html = '';
  		if(!isset($atts['cats']) ) return $html;
		if( count( $rows ) > 0 )
		{
			foreach($rows as $row )
			{
				if( isset( $row['cat'] ) )
				{
					$is_active = '';
					if( $counnt == 1 )
					{
						$is_active = 'active';
						$counnt++;
					}
					$category = get_term_by('id', $row['cat'], 'product_cat');
					if(!empty($category))
					{
						if( count((array) $category ) == 0 )
							continue;
						$categories_html .= ' <li role="presentation" class="'.esc_attr( $is_active ).'">
								  <a data-toggle="tab" title="'.$category->name.'" role="tab" href="#tab-'.$category->term_id.'" aria-expanded="true">'.$category->name.'</a>
							   </li>';
						$categories_contents .= '<div id="tab-'.$category->term_id.'" role="tabpanel" class="tab-pane in fade '.esc_attr( $is_active ).'">';
						}
				}
			
				$category	=	'';
				if( count((array) $row['cat'] ) > 0 )
				{
					$category	=	array(
						array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $row['cat'],
						),
					);	
				}
				$ordering	=	'DESC';
				$order_by	=	'ID';
				if( $ad_order == 'asc' )
				{
					$ordering	=	'ASC';
				}
				else if( $ad_order == 'desc' )
				{
					$ordering	=	'DESC';
				}
				else if( $ad_order == 'rand' )
				{
					$order_by	=	'rand';
				}
				$args = array( 
					'post_type' => 'product',
					'posts_per_page' => $max_limit,
					'tax_query' => array(
						$category,
						array(	
						   'taxonomy' => 'product_type',
						   'field' => 'slug',
						   'terms' => 'dwt_listing_pkgs',
							'operator' => 'NOT IN',
						 ),
					),
					'orderby'        => $order_by,
					'order'        => $ordering,
				);
				$layout_type = 'shop_grid'; 
				$productz	=	 new dwt_listing_products_shop();
				$results = new WP_Query( $args );
				if( count((array) $results ) > 0 )
				{
						$i=0;
						while( $results->have_posts() ) 
						{ 
							$results->the_post();
							$product_id	=	get_the_ID();
							$function	=	"dwt_listing_shop_listings_$layout_type";
							$categories_contents	.= $productz->$function($product_id,'',$i);
							$i++;
						}
						wp_reset_postdata();
				}
				$categories_contents .= '</div>';
			}
		}
		
		return '<section class="woocommerce '.$class.' '.$bg_color.'" '. $style .'>
          <div class="container">
            <div class="row">
            	'. $header .'
               <div class="col-md-12 col-sm-12 col-xs-12 products">
				   <div class="row">
						<div class="recent-tab">	
						<ul class="nav nav-tabs" role="tablist">'.$categories_html.'</ul>
					</div>
					<div class="tab-content">
							'.$categories_contents.'
					</div>
                        <div class="clearfix"></div>
						'.$view_all_btn.'
						</div>
				   </div>
            </div>
          </div>
        </section>';
	}
}
if (function_exists('dwt_listing_add_code'))
{
	dwt_listing_add_code('d_shop_tab_base', 'd_shop_tab_base_func');
}