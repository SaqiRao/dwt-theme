<?php
$second_long = $second_latt = $listing_long = $listing_lat = $nearby_distance = $final_distances = $nearby_distance_in = $nearby_no_listings_show = '';
$nearby_idz = $calculated_distance = array();
global $dwt_listing_options;

//covered distance for searching
$nearby_distance = 100;
if (isset($dwt_listing_options['dwt_listing_nearby_dest']) && $dwt_listing_options['dwt_listing_nearby_dest'] != '') {
    $nearby_distance = $dwt_listing_options['dwt_listing_nearby_dest'];
}

//searching area in km/mile
$nearby_distance_in = 'km';
if (isset($dwt_listing_options['dwt_listing_nearby_dest_in']) && $dwt_listing_options['dwt_listing_nearby_dest_in'] != '') {
    $nearby_distance_in = $dwt_listing_options['dwt_listing_nearby_dest_in'];
}

//how much listing show
$nearby_no_listings_show = 10;
if (isset($dwt_listing_options['dwt_listing_nearby_no_listings']) && $dwt_listing_options['dwt_listing_nearby_no_listings'] != '') {
    $nearby_no_listings_show = $dwt_listing_options['dwt_listing_nearby_no_listings'];
}
//listing id
if(isset($_GET['review_id']) && $_GET['review_id'] != "")
{
	$listing_id = $_GET['review_id'];	
}
else
{
	$listing_id	=	get_the_ID();
}
if (get_post_meta($listing_id, 'dwt_listing_listing_lat', true) != "" && get_post_meta($listing_id, 'dwt_listing_listing_long', true) != "") {
    $listing_lat = get_post_meta($listing_id, 'dwt_listing_listing_lat', true);
    $listing_long = get_post_meta($listing_id, 'dwt_listing_listing_long', true);
    //get listings
    $args = array(
        'post_type' => 'listing',
        'post_status' => 'publish',
        'posts_per_page' => $nearby_no_listings_show,
        'post__not_in' => array($listing_id),
        //'orderby' => 'post__in',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'dwt_listing_listing_status',
                'value' => '1',
                'compare' => '='
            )
        )
    );
    $near_by = new WP_Query($args);
    //first loop to get distance
    if ($near_by->have_posts()) {

        while ($near_by->have_posts()) {
            $near_by->the_post();
            $listing_idz = get_the_ID();
            if (get_post_meta($listing_idz, 'dwt_listing_listing_lat', true) != "" && get_post_meta($listing_idz, 'dwt_listing_listing_long', true) != "") {
                $second_latt = get_post_meta($listing_idz, 'dwt_listing_listing_lat', true);
                $second_long = get_post_meta($listing_idz, 'dwt_listing_listing_long', true);
                $calculated_distance = dwt_nearby_distance($listing_lat, $listing_long, $second_latt, $second_long, $nearby_distance_in);
                if (is_array($calculated_distance) && !empty($calculated_distance)) {
                    //check distance
                    if ($calculated_distance['calculated_distance'] <= $nearby_distance) {
                        //get all listing ids
                        $nearby_idz[$listing_idz] = $calculated_distance['calculated_distance'];
                    }
                }
            }
        }
    }
    wp_reset_postdata();
    if (is_array($nearby_idz) && !empty($nearby_idz)) {

        $simple_array = array();
        foreach ($nearby_idz as $key => $val) {
            $simple_array[] = $key;
        }
        $argsz = array(
            'post_type' => 'listing',
            'post_status' => 'publish',
            'posts_per_page' => $nearby_no_listings_show,
            'post__in' => $simple_array,
            'orderby' => 'post__in',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'dwt_listing_listing_status',
                    'value' => '1',
                    'compare' => '='
                )
            )
        );
        $final_result = new WP_Query($argsz);
        if ($final_result->have_posts()) {
            ?>
            <div class="custom-widget">
                <div class="widget-custom-heading"> <a href="javascript:void(0)"> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/icons/nearby.png'); ?>" alt="<?php echo __('Near By', 'dwt-listing'); ?>"><?php echo __('Near By', 'dwt-listing'); ?> </a> </div>
                <?php
                while ($final_result->have_posts()) {
                    $final_result->the_post();
                    $final_listing_id = get_the_ID();
                    $final_distances = ( isset($nearby_idz["$final_listing_id"])) ? $nearby_idz["$final_listing_id"] : '';
                    ?>
                    <ul class="list-unstyled dwt-panel-listz">
                        <li class="listing-most-viewed">
                            <div class="listing-viewed-card">
                                <?php
                                $media = dwt_listing_fetch_listing_gallery($final_listing_id);
                                $thumb_size = 'dwt_listing_recent-posts';
                                $ratings = '';
                                //listing category
                                $categories = dwt_listing_listing_assigned_cats($final_listing_id, '');
                                //Ratings
                                if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
                                    $get_percentage = dwt_listing_fetch_reviews_average($final_listing_id);
                                    if (isset($get_percentage) && count((array) $get_percentage['ratings']) > 0 && count((array) $get_percentage['rated_no_of_times']) > 0) {
                                        $ratings = '<li><div class="ratings elegent">' . $get_percentage['total_stars'] . '</div></li>';
                                    }
                                }
                                $limited_title = dwt_listing_words_count(get_the_title($final_listing_id), dwt_listing_text('grid_title_limit'));
                                $final_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", $limited_title)));
                                ?>
                                <a href="<?php echo get_the_permalink($final_listing_id); ?>"><img class="img-responsive listing-viewed-img" src="<?php echo dwt_listing_return_listing_idz($media, $thumb_size) ?>" alt="<?php echo $final_title; ?>"> </a>
                                <div class="listing-viewed-detailz">
                                    <span class="date"><?php echo $categories; ?></span>
                                    <h3 class="listing-viewed-title"><a href="<?php echo get_the_permalink($final_listing_id); ?>"><?php echo $final_title; ?></a></h3>
                                    <ul class="listing-viewed-stats">
                                        <?php echo $ratings; ?>
                                        <li class="my-active-clr"><?php echo $final_distances . " " . esc_html__($nearby_distance_in, 'dwt-listing'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </li>            
                    </ul>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
}