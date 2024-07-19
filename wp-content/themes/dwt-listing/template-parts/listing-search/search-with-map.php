<?php global $dwt_listing_options; ?>
<div class="no-container">
    <div class="left-area">
        <div id="mapid" class="map"></div>
        <div class="leaf-radius-search"><a id="loc_mez" href="javascript:void(0)"><span class="fa fa-map-marker"></span></a>
        <!-- <div class="leaf-radius-search"><a id="loc_mez" href="javascript:void(0)"><span class="fa fa-map-marker"></span></a> -->
        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 50 50"><path fill="currentColor" d="M2 15.758V2h14.299l5.262 4h-8.769L22 15.758L16.299 21L7 12.251v8.769zM33.752 2H48v13.809l-4 5.261v-8.768L33.997 21.51l-5.364-5.456L37.259 7H28.49zM48 33.752V48H33.701l-5.262-4h8.769L28 33.997l5.701-5.364L43 37.259V28.49zM16.248 48H2V33.701l4-5.262v8.769L16.003 28l5.364 5.701L12.741 43h8.769z"/></svg> -->
    </div>
        
    </div>
    <div class="right-area">
        <?php
        $my_class = 'inner-content';
        if ($results->have_posts()) {
            $my_class = 'inner-content no-right';
        }
        ?>
        <div class="<?php echo esc_attr($my_class); ?>">
            <?php require trailingslashit(get_template_directory()) . "template-parts/listing-search/widgets/map/map-widgets.php"; ?>
            <div class="ads-listing-history ">
                <?php
                //Ad slots
                if (isset($dwt_listing_options['search_ad_720_1']) && $dwt_listing_options['search_ad_720_1'] != "") {
                    ?>
                    <div class="premium-slots text-center no-top">
                        <?php echo "" . $dwt_listing_options['search_ad_720_1']; ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
                ?>
                <div class="sk-circle">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
                <?php
                //fetch featured listing in slider
                if (dwt_listing_text('feature_on_search') == 1) {
                    $tax_query = '';
                    if (is_tax()) {
                        $queried_object = get_queried_object();
                        if (!empty($queried_object) && count((array) $queried_object) > 0) {
                            $term_id = $queried_object->term_id;
                            $tax_name = $queried_object->taxonomy;
                            if (!empty($term_id)) {
                                $term_idz = get_term_by('id', $term_id, $tax_name);
                                $termName = $term_idz->name;
                                $term_ID = $term_idz->term_id;
                            }

                            $tax_query = array(
                                array(
                                    'taxonomy' => $tax_name,
                                    'field' => 'id',
                                    'terms' => $term_ID,
                                ),
                            );
                        }
                    } else {
                        $tax_query = $category;
                    }
                    echo '<div class="feat_slider">';
                    $grid_layout = 'grid2';
                    $grid_layout = dwt_listing_text('dwt_listing_feature_on_search');
                    $args = array(
                        'post_type' => 'listing',
                        'posts_per_page' => dwt_listing_text('max_ads_feature'),
                        'tax_query' => array(
                            $tax_query,
                        ),
                        'meta_query' => array(
                            array(
                                'key' => 'dwt_listing_is_feature',
                                'value' => 1,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'dwt_listing_listing_status',
                                'value' => '1',
                                'compare' => '='
                            ),
                        ),
                        'orderby' => 'date',
                    );
                    /* for wpml search */
                    $args = dwt_listing_wpml_show_all_posts_callback($args);
                    $dwt_listing_listings = new dwt_listing_listings();
                    echo ( $dwt_listing_listings->dwt_listing_featured_listing_slider($args, dwt_listing_text('feature_ads_title'), 4, $grid_layout) );
                    echo '</div>';
                }
                $grid_type = 'grid1';
                $fetch_output = '';
                if ($results->have_posts()) {
                    // check listing style
                    $grid_type = array('grid1', 'grid2', 'grid3', 'grid4');
                    if (in_array(dwt_listing_text('dwt_listing_search_layout_style'), $grid_type)) {
                        //its grid styles
                        require trailingslashit(get_template_directory()) . "template-parts/listing-search/grid-styles/grids-for-maps.php";
                        echo '' . $fetch_output;
                    } else {
                        //its listing styles
                        echo "<div class='col-md-12 col-xs-12 col-sm-12'>";
                        require trailingslashit(get_template_directory()) . "template-parts/listing-search/grid-styles/lists-for-map.php";
                        echo '' . $fetch_output;
                        echo "</div>";
                    }
                    wp_reset_postdata();
                } else {
                    if (dwt_listing_text('dwt_listing_seacrh_layout') == 'map') {
                        echo '<script>var listing_markers = [];</script>';
                    }
                    //no result found
                    echo '<div class="masonery_wrap">' . dwt_listing_ajax_no_result() . '</div>';
                }
                ?>
                <?php
                //Ad slots
                if (isset($dwt_listing_options['search_ad_720_2']) && $dwt_listing_options['search_ad_720_2'] != "") {
                    ?>
                    <div class="clearfix"></div>
                    <div class="premium-slots text-center no-top">
                        <?php echo "" . $dwt_listing_options['search_ad_720_2']; ?>
                    </div>

                    <div class="clearfix"></div>
                    <?php
                }
                ?>
                <div class="col-md-12 col-xs-12 col-sm-12" id="listing_ajax_pagination"><?php echo dwt_listing_ajax_pagination_search($results); ?></div>      
            </div>
        </div>
    </div>
</div>