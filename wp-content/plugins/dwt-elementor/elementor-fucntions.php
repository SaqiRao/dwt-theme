<?php
/**
 * Get Listing Categories
 * only parent
 */
if (!function_exists('dwt_elementor_get_parests_cats')) {

    function dwt_elementor_get_parests_cats($taxonomy , $all = false) {
        $cats = array();
        if (taxonomy_exists($taxonomy)) {
            $listing_cats = dwt_listing_categories_fetch($taxonomy, 0);
            if($all){
            $cats['all'] = __('All', 'dwt-elementor');
            }
            if (count($listing_cats) > 0 && $listing_cats != "") {
                foreach ($listing_cats as $cat) {
                    $cats[$cat->term_id] = $cat->name . ' (' . $cat->count . ')';
                }
            }
        }
        return $cats;
    }

}

/**
 * Button with link
 */
if (!function_exists('dwt_elementor_button_link')) {

    function dwt_elementor_button_link($is_external = '', $nofollow = '', $btn_title = 'Button Link', $url = '', $class_css = '', $i_class = '') {
        $i_class_html = '';
        $target = $is_external ? ' target="_blank"' : '';
        $nofollow = $nofollow ? ' rel="nofollow"' : '';
        if ($i_class != '') {
            $i_class_html = '<i class="' . $i_class . '"></i>';
        }
        return '<a href="' . esc_url($url) . '" class="' . $class_css . '"' . $target . $nofollow . '>' . esc_html__($btn_title, 'dwt-elementor') . ' ' . $i_class_html . '</a>';
    }

}

/**
 * find custom locations
 */
if (!function_exists('dwt_elementor_location_data_shortcode')) {

    function dwt_elementor_location_data_shortcode($term_type = 'l_location' , $all =  false) {
        $terms = get_terms($term_type, array('hide_empty' => false));
        $result = array();
          if($all){
            $result['all'] = __('All', 'dwt-elementor');
            }

        if (count((array) $terms) > 0 && !empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $result[$term->term_id] = $term->name;
            }
        }
        return $result;
    }

}

/**
 * Getting packages from product
 */
if (!function_exists('dwt_elementor_get_packages')) {

    function dwt_elementor_get_packages() {
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists('WooCommerce')) {
            $products = array();
            $args = array(
                'post_type' => 'product',
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'dwt_listing_pkgs'
                    ),
                    array(
                        'taxonomy' => 'product_type',
                        'field' => 'slug',
                        'terms' => 'subscription'
                    ),
                ),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date'
            );
            $packages = new WP_Query($args);
            if ($packages->have_posts()) {
                while ($packages->have_posts()) {
                    $packages->the_post();
                    $products[get_the_ID()] = get_the_title();
                }
            }
            return $products;
        }
    }

}