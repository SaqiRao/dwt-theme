<?php
if (!function_exists('dwt_listing_blogs')) {

    function dwt_listing_blogs() {
        vc_map(array(
            "name" => __("Blogs", 'dwt-listing'),
            "base" => "d_blog_base",
            "category" => __("Theme Shortcodes", 'dwt-listing'),
            "icon" => "icon-wpb-application-icon-large",
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'dwt-listing'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'dwt-listing'),
                    'param_name' => 'order_field_key',
                    'description' => dwt_listing_VCImage('blog.png') . __('Ouput of the shortcode will be look like this.', 'dwt-listing'),
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
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Blogs", 'dwt-listing'),
                    "param_name" => "max_limit",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Basic", 'dwt-listing'),
                    "type" => "vc_link",
                    "heading" => esc_html__("View All Blog Link", 'dwt-listing'),
                    "param_name" => "main_link",
                    "description" => esc_html__("Link You Want To Redirect.", 'dwt-listing'),
                ),
                array(
                    "group" => esc_html__("Basic", "dwt-listing"),
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => esc_html__("Show Pattern Image", 'dwt-listing'),
                    "param_name" => "pattern_chk",
                    "value" => 1,
                    'std' => '1',
                    "description" => esc_html__('Show pattern image at right side of section', 'dwt-listing') . '</strong>',
                ),
                array
                    (
                    'group' => esc_html__('Categories', 'dwt-listing'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'dwt-listing'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'dwt-listing'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => dwt_listing_get_parests_cats('category', 'no'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'dwt_listing_blogs');
if (!function_exists('d_blog_base_func')) {

    function d_blog_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/shortcode-functions/essential_values.php";
        $show_pattern = '';
        if (!empty($pattern_chk) && $pattern_chk == 'true') {
            $show_pattern = 'new-blog-section-3';
        }
        $cats = array();
        if (function_exists('vc_param_group_parse_atts')) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $is_all = false;
            $blog_category = '';
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] != 'all') {
                            if ($row['cat'] != 'all') {
                                $cats[] = $row['cat'];
                            }
                        }
                    }
                }
            }
        }
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $max_limit,
            'post_status' => 'publish',
            'category__in' => $cats,
            'orderby' => 'DATE',
            'order' => 'DESC',
        );
        $args = dwt_listing_wpml_show_all_posts_callback($args);
        $posts = new WP_Query($args);
        $blog_html = $img_show = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                $blogz_id = get_the_ID();
                if (has_post_thumbnail()) {
                    $get_img_src = '';
                    $get_img_src = dwt_listing_get_feature_image($blogz_id, 'dwt_listing_blogpost-thumb');
                    $img_show = '<div class="image">
						<div class="lazy-imagess">
							<a href="' . get_the_permalink($blogz_id) . '">
								<img src="' . esc_url($get_img_src[0]) . '" alt="' . get_the_title($blogz_id) . '" class="img-responsive">
							</a>
						</div>
					</div>';
                } else {
                    $img_show = '<div class="image">
						<div class="lazy-imagess">
							<a href="' . get_the_permalink($blogz_id) . '">
								<img src="' . esc_url(dwt_listing_defualt_img_url()) . '" alt="' . get_the_title($blogz_id) . '" class="img-responsive">
							</a>
						</div>
					</div>';
                }

                $blog_html .= '<div class="col-xs-12 col-md-4 col-sm-6">
				  <div class="blog-inner-box">
				   ' . $img_show . '
					<div class="blog-lower-box">
					  <p class="blog-date">' . get_the_date(get_option('date_format'), $blogz_id) . '</p>
					  <h3><a href="' . get_the_permalink($blogz_id) . '">' . dwt_listing_words_count(get_the_title($blogz_id), dwt_listing_text('grid_title_limit')) . '</a></h3>
					  <div class="text">' . dwt_listing_words_count(get_the_excerpt(), 90) . '</div>
					  <a href="' . get_the_permalink($blogz_id) . '" class="btn btn-theme">' . esc_html__('read more', 'dwt-listing') . '</a> </div>
				  </div>
				</div>';
            }
            wp_reset_postdata();
        }
        wp_reset_postdata();
        $button = $view_all_btn = '';
        $button = dwt_listing_get_button($main_link, 'btn btn-theme', false, false, '');
        if ($button) {
            $view_all_btn = '<div class="col-md-12 col-sm-12 col-xs-12">
				  <div class="load-btn">' . $button . '</div>
				</div>';
        }

        return '<section class="blog-section-2 ' . $show_pattern . ' ' . $class . ' ' . $bg_color . '" ' . $style . '>
          <div class="container">
            <div class="row">
            	' . $header . '
               <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			  		' . $blog_html . '
					' . $view_all_btn . '
			   </div>
            </div>
          </div>
        </section>';
    }

}
if (function_exists('dwt_listing_add_code')) {
    dwt_listing_add_code('d_blog_base', 'd_blog_base_func');
}