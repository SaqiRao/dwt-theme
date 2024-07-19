<?php
global $dwt_listing_options;
$args = '';
if (dwt_listing_text('dwt_listing_enable_mapfilters') == '1') {
    ?>
    <div class="search-banner">
        <div class="container">
            <h3 class="search-title"><?php echo esc_html__('What are you looking for?', 'dwt-listing'); ?></h3>
            <?php require trailingslashit(get_template_directory()) . "template-parts/listing-search/widgets/topbar/topbar-widgets.php"; ?>
        </div>
    </div>
<?php } ?>

<section class="listing-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="filters-option-bar">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                            <h4>
                                <span class="heading-icon">
                                    <i class="fa fa-th-large"></i>
                                </span>
                                <span class="heading"><?php echo esc_html__('Total Listings :', 'dwt-listing') ?> <strong><?php echo esc_attr($results->found_posts); ?></strong></span>
                                <span id="result_reset">
                                    <?php
                                    if (!empty($_GET)) {
                                        echo '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>';
                                    }
                                    ?>
                                </span>
                            </h4>
                        </div>
                        <?php
                        if (dwt_listing_text('donwtown_search_bysort') == '1') { ?>
                            <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                                <div class="search-area-sort">
                                    <form>
                                        <select name="sort_by"
                                                data-placeholder="<?php echo esc_html__('Sort By', 'dwt-listing'); ?>"
                                                id="order_by" class="custom-select form-control">
                                            <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                            <option value="id-desc">
                                                <?php echo esc_html__('Newest To Oldest', 'dwt-listing'); ?>
                                            </option>
                                            <option value="id-asc">
                                                <?php echo esc_html__('Oldest To New', 'dwt-listing'); ?>
                                            </option>
                                            <option value="title-asc">
                                                <?php echo esc_html__('Alphabetically [a-z]', 'dwt-listing'); ?>
                                            </option>
                                            <option value="title-desc">
                                                <?php echo esc_html__('Alphabetically [z-a]', 'dwt-listing'); ?>
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
                //Ad slots
                if (isset($dwt_listing_options['search_ad_720_1']) && $dwt_listing_options['search_ad_720_1'] != "" && $results->have_posts()) {
                    ?>
                    <div class="premium-slots text-center no-top">
                        <?php echo "" . $dwt_listing_options['search_ad_720_1']; ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                }
                ?>
                <?php
                $tax_query = '';
                if (is_tax()) {
                    $queried_object = get_queried_object();
                    if (!empty($queried_object) && count((array)$queried_object) > 0) {
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
                //fetch featured listing in slider
                if (dwt_listing_text('feature_on_search') == 1) {
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
                    echo($dwt_listing_listings->dwt_listing_featured_listing_slider($args, dwt_listing_text('feature_ads_title'), 4, $grid_layout));
                    echo '</div>';
                }

                $grid_type = 'grid1';
                $fetch_output = '';
                if ($results->have_posts()) {
                    // check listing style
                    echo '<div class="s_ajax">';
                    $grid_type = array('grid1', 'grid2', 'grid3', 'grid4');
                    if (in_array(dwt_listing_text('dwt_listing_search_layout_style'), $grid_type)) {
                        //its grid styles
                        require trailingslashit(get_template_directory()) . "template-parts/listing-search/grid-styles/grids.php";
                        echo '' . $fetch_output;
                    }
                    echo '</div>';
                    wp_reset_postdata();
                } else {
                    //no result found
                    echo '<div class="s_ajax">' . dwt_listing_ajax_no_result() . '</div>';
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
                <div id="listing_ajax_pagination"><?php echo dwt_listing_ajax_pagination_search($results); ?></div>
                <?php
                /* Ad slots */
                if (isset($dwt_listing_options['search_ad_720_2']) && $dwt_listing_options['search_ad_720_2'] != "" && $results->have_posts()) {
                    ?>
                    <div class="premium-slots text-center">
                        <?php echo "" . $dwt_listing_options['search_ad_720_2']; ?>
                    </div>

                    <div class="clearfix"></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>