<?php
global $dwt_listing_options;
	extract(shortcode_atts(array(
		'ad_order' => '',
		'max_limit' => '',
		'main_link' => '',
	), $atts));

	$rows = vc_param_group_parse_atts($atts['cats']);
    $cats = array();
	if (count((array)  $rows) > 0) {
		foreach ($rows as $row) {
			if (isset($row['cat'])) {
				if ($row['cat'] == 'all') {
					break;
				} else {
					$cats[]	=	$row['cat'];
				}
			}
		}
	}
$category	=	'';
if (count((array)  $cats) > 0) {
	$category	=	array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $cats,
		),
	);
}
$order	=	'DESC';
$order_by	=	'date';
if ($ad_order == 'asc') {
	$order	=	'ASC';
} else if ($ad_order == 'desc') {
	$order	=	'DESC';
} else if ($ad_order == 'rand') {
	$order_by	=	'rand';
}

//query 
$args =	array(
	'post_type' => 'product',
	'post_status' => 'publish',
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
	'order' => $order,
	'orderby' => $order_by,
);
$layout_type = 'shop_grid';
$wrap_stater = '<div class="masonery_wrap">';
$wrap_ender = '</div>';
if ($shop_layout_type == 'slider') {
	$layout_type = 'shop_slider';
	$wrap_ender = $wrap_stater = '';
}
$fetch_products = '';
$productz	=	 new dwt_listing_products_shop();
$results = new WP_Query($args);
if ($results->have_posts()) {
	//Masonry layout
	$fetch_products	.= $wrap_stater;
	while ($results->have_posts()) {
		$results->the_post();
		$product_id	=	get_the_ID();
		$function	=	"dwt_listing_shop_listings_$layout_type";
		$fetch_products	.= $productz->$function($product_id);
	}
	$fetch_products	.= $wrap_ender;
}
wp_reset_postdata();