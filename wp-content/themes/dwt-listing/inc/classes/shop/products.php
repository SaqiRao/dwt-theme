<?php
if (!class_exists('dwt_listing_products_shop')) {

    class dwt_listing_products_shop
    {

        // user object
        var $user_info;

        public function __construct()
        {
            $this->user_info = get_userdata(get_current_user_id());
        }

        // Get Shop Products
        function dwt_listing_shop_listings_shop_grid($product_id, $column_size = '', $clearfix = '')
        {
            if (empty($product_id)) {
                return;
            }

            $is_product = wc_get_product($product_id);
            $average = $review_count = $rating_count = $rating_stars = $product_img = $sale_banner = '';
            if ($is_product->is_on_sale()) {
                $sale_banner = '<span class="prod-sale-banner">' . esc_html__('Sale', 'dwt-listing') . '</span>';
            }

            $img = $is_product->get_image_id();
            $photo = wp_get_attachment_image_src($img, 'dwt_listing_woo-thumb');
            if (!empty($photo)) {
                if ($photo[0] != "") {
                    $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url($photo[0]) . '">';
                }
            } else {
                $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url(wc_placeholder_img_src()) . '">';
            }

            if ('yes' === get_option('woocommerce_enable_review_rating')) {
                $rating_count = $is_product->get_rating_count();
                $review_count = $is_product->get_review_count();
                $average = $is_product->get_average_rating();
                if ($rating_count > 0) {
                    $rating_stars = wc_get_rating_html($average, $rating_count);
                }
            }
            $additional_div = '';
            if ($column_size == '4') {
                $column_size = 'col-md-4 col-sm-4 col-xs-12';
                if ($clearfix != "") {
                    if ($clearfix++ % 3 == 0) {
                        $additional_div = '<div class="clearfix"></div>';
                    }
                }
            } else {
                $column_size = 'col-md-3 col-sm-4 col-xs-12';
                if ($clearfix != "") {
                    if ($clearfix++ % 4 == 0) {
                        $additional_div = '<div class="clearfix"></div>';
                    }
                }
            }
            return '' . $additional_div . '<div class="' . $column_size . ' masonery_item">
			 <a href="' . get_the_permalink($product_id) . '">
				<div class="dwt_listing_shop-grid foo">
				<div class="dwt_listing_shop-grid-description">
					<div class="shop-img-rapper">
						' . $sale_banner . '
						' . $product_img . '
						<div class="hover-effect">
							<div><i class="ti-eye"></i></div>
						</div>
					</div>
					<div class="title-wrapper">
						<h2 class="woocommerce-loop-product__title">' . get_the_title($product_id) . ' </h2>
					</div>
						<div class="price-wrapper">
						' . $rating_stars . '
							<span class="price">
							' . $is_product->get_price_html() . '
							</span>
						</div>
					</div>
				</div>
				</a>
			</div>';
        }

        // Get Shop Products Slider
        function dwt_listing_shop_listings_shop_slider($product_id)
        {
            if (empty($product_id)) {
                return;
            }

            $is_product = wc_get_product($product_id);
            $average = $review_count = $rating_count = $rating_stars = $product_img = $sale_banner = '';
            if ($is_product->is_on_sale()) {
                $sale_banner = '<span class="prod-sale-banner">' . esc_html__('Sale', 'dwt-listing') . '</span>';
            }

            $img = $is_product->get_image_id();
            $photo = wp_get_attachment_image_src($img, 'dwt_listing_woo-thumb');
            if ($photo != '') {
                if ($photo[0] != "") {
                    $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url($photo[0]) . '">';
                }
            } else {
                $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url(wc_placeholder_img_src()) . '">';
            }
            if ('yes' === get_option('woocommerce_enable_review_rating')) {
                $rating_count = $is_product->get_rating_count();
                $review_count = $is_product->get_review_count();
                $average = $is_product->get_average_rating();
                if ($rating_count > 0) {
                    $rating_stars = wc_get_rating_html($average, $rating_count);
                }
            }
            return '<div class="item">
			 <a href="' . get_the_permalink($product_id) . '">
				<div class="dwt_listing_shop-grid">
				<div class="dwt_listing_shop-grid-description">
					<div class="shop-img-rapper">
						' . $sale_banner . '
						' . $product_img . '
						<div class="hover-effect">
							<div><i class="ti-eye"></i></div>
						</div>
					</div>
					<div class="title-wrapper">
						<h2 class="woocommerce-loop-product__title">' . get_the_title($product_id) . ' </h2>
					</div>
						<div class="price-wrapper">
						' . $rating_stars . '
							<span class="price">
							' . $is_product->get_price_html() . '
							</span>
						</div>
					</div>
				</div>
				</a>
			</div>';
        }
    }
}