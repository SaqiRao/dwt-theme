<?php
/* ------------------------------------------------ */
/* Fun Facts */
/* ------------------------------------------------ */
if (!function_exists('dwt_listing_clients')) {

    function dwt_listing_clients() {
        vc_map(array(
            "name" => esc_html__("Clients or Brands", 'dwt-listing'),
            "base" => "clients_base",
            "category" => esc_html__("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-layer-shape-text",
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('clients.png') . esc_html__('Ouput of the shortcode will be look like this.', 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Background Color", 'dwt-listing'),
                    "param_name" => "section_bg",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Background Color', 'dwt-listing') => '',
                        esc_html__('White', 'dwt-listing') => '',
                        esc_html__('Gray', 'dwt-listing') => 'bg-gray',
                        esc_html__('Image', 'dwt-listing') => 'img'
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    "description" => esc_html__("Select background color.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "attach_image",
                    "holder" => "bg_img",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'dwt-listing'),
                    "param_name" => "bg_img",
                    'dependency' => array(
                        'element' => 'section_bg',
                        'value' => array('img'),
                    ),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'dwt-listing'),
                    "param_name" => "section_title",
                    "description" => esc_html__('Title for your section ', 'dwt-listing') . '</strong>',
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'dwt-listing'),
                    "param_name" => "section_description",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                ),
                array(
                    'group' => esc_html__('CLients Or Partner', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Add Clients', 'dwt-listing'),
                    'param_name' => 'clients',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Link Here", 'dwt-listing'),
                            "param_name" => "c_link",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "class" => "",
                            "heading" => esc_html__("CLients Images", 'dwt-listing'),
                            "param_name" => "clients_thumb",
                            "description" => esc_html__('Image Size Should Be 140x95', 'dwt-listing'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'dwt_listing_clients');

if (!function_exists('clients_base_func')) {

    function clients_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";

        $rows = vc_param_group_parse_atts($atts['clients']);
        if (count((array) $rows) > 0) {
            $href = $client_loop = $client_img = '';
            foreach ($rows as $row) {
                if (isset($row['clients_thumb']) && $row['clients_thumb'] != '') {
                    $client_img = dwt_listing_return_img_src($row['clients_thumb']);
                    if (isset($client_img) && $client_img != '') {
                        $href = '';
                        if (isset($row['c_link']) && $row['c_link'] != '') {
                            $href = esc_url($row['c_link']);
                        } else {
                            $href = 'javascript:void(0)';
                        }
                        $client_loop .= '<div class="col-lg-2 col-md-3 col-xs-12 col-sm-3">
					<div class="single-partner">
						<a href="' . $href . '"><img class="img-responsive" src="' . $client_img . '" alt="' . esc_html__("image not found", "dwt-listing") . '"></a>
					</div>
				</div>';
                    }
                }
            }
        }
        return '<section  class="partners ' . $class . ' ' . $bg_color . '" ' . $style . '>
			<div class="container">
				<div class="row">
				' . $header . '
					 <div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="row no-gutters">
								' . $client_loop . '
						</div>
					</div>
				</div>
			</div>
		</section>';
    }

}

if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('clients_base', 'clients_base_func');
}