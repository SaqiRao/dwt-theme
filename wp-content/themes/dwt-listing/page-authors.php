<?php
/* Template Name: All Authors */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dwt listing
 */
?>
<?php get_header();
global $dwt_listing_options;
$argsz = array(
    'role__in' => array('Admin' ) 
);

$get_count = new WP_User_Query($argsz);
$result = $get_count->get_results();
$total_users = count($result);
?>
    <section class="all_authors">
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Left Colum -->

                <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
                    <div class="preloading" id="dwt_listing_loading"></div>
                    <div class="filters-option-bar">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                                <h4>
                        <span class="heading-icon">
                            <i class="fa fa-user-o"></i>
                        </span>
                                    <span class="heading">
                                        <?php echo esc_html__('Total Authors :', 'dwt-listing'); ?> 
                                        <strong><?php echo esc_attr($total_users); ?></strong></span>
                                    <span id="result_reset">
							<?php if (!empty($_GET)) {
echo '<a class="main-listing__clear" href="javascript:void(0)" id="reset_a_filterz">' . esc_html__('Reset All', 'dwt-listing') . '</a>';
                            }
                            ?>
                        </span>
                                </h4>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 col-sm-6">
                                <div class="search-area-sort">
                                    <?php
                                    $latest = '';
                                    $oldest = '';
                                    $selectedOldest = $selectedLatest = $selectedTitleAsc = $selectedTitleDesc = $selectedPriceHigh = $selectedPriceLow = '';
                                    if (isset($_GET['sort-author'])) {
                                        $selectedOldest = ($_GET['sort-author'] == 'id-asc') ? 'selected' : '';
                                        $selectedLatest = ($_GET['sort-author'] == 'id-desc') ? 'selected' : '';
                                        $selectedTitleAsc = ($_GET['sort-author'] == 'title-asc') ? 'selected' : '';
                                        $selectedTitleDesc = ($_GET['sort-author'] == 'title-desc') ? 'selected' : '';
                                    }
                                    ?>
                                    <form method="get">
                                        <select onChange="this.form.submit()" name="sort-author"
                                                data-placeholder="<?php echo esc_html__('Sort By', 'dwt-listing'); ?>"
                                                id="sort-author" class="custom-select form-control">
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
                        </div>
                    </div>


                    <div class="row">
                        <?php
                        // grab the current page number and set to 1 if no page number is set
                        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        // how many users to show per page
                        $users_per_page = isset($dwt_listing_options['users_per_page']) ? $dwt_listing_options['users_per_page'] : 12;

                        // calculate the total number of pages.
                        $total_pages = 1;
                        $offset = $users_per_page * ($page - 1);
                        $total_pages = ceil($total_users / $users_per_page);

                        $order = 'desc';
                        $orderBy = 'date';
                        if (isset($_GET['sort-author']) && $_GET['sort-author'] != "") {
                            $orde_arr = explode('-', $_GET['sort-author']);
                            $order = isset($orde_arr[1]) ? $orde_arr[1] : 'desc';
                            if (isset($orde_arr[0]) && $orde_arr[0] == 'price') {
                                $orderBy = 'meta_value_num';
                            } else {
                                $orderBy = isset($orde_arr[0]) ? $orde_arr[0] : 'ID';
                            }
                        }

                        // main user query
                        $args = array(
                            // order results by display_name
                            'order' => $order,
                            'orderby' => $orderBy,
                            'number' => $users_per_page,
                            'offset' => $offset,
                            'role__in' => array( 'Admin' ),
                        );
                        
                        // Create the WP_User_Query object
                        $args = dwt_listing_wpml_show_all_posts_callback($args);
                        $wp_user_query = new WP_User_Query($args);

                        // Get the results
                        $users = $wp_user_query->get_results();
                        foreach ($users as $user) {
                            $user_id = $user->ID;
                            $user_dp = dwt_listing_fetch_comment_poster($user_id, 'dp');
                            $user_name = dwt_listing_fetch_comment_poster($user_id, 'name');
                            $user_profile_url = dwt_listing_fetch_comment_poster($user_id, 'url');
                            $no_spacing = '12';
                            $user_loc = '';
                            $no_spacing = 'author-margin';
                            if (dwt_listing_fetch_comment_poster($user_id, 'location') != "") {
                                $no_spacing = '';
                                $user_loc = '<div class="author-loc"><span class="fa fa-map-marker"></span> ' . dwt_listing_fetch_comment_poster($user_id, 'location') . '</div>';
                            }
                            ?>
                            <!-- Agent Card -->
                            <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="cardz card-agent-6">
                                    <div class="row">
                                        <div class="col-md-2 col-xs-12 col-sm-2">
                                            <div class="card-image">
                                                <a href="<?php echo esc_url($user_profile_url); ?>">
                                                    <img class="img-responsive img-circle"
                                                         alt="<?php echo esc_html__('image not found', 'dwt-listing'); ?>"
                                                         src="<?php echo esc_url($user_dp); ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <h5 class="card-title <?php echo esc_attr($no_spacing); ?>">
                                                <a href="<?php echo esc_url($user_profile_url); ?>"><?php echo esc_attr($user_name); ?></a>
                                            </h5>
                                            <p><?php echo esc_html__('Total Listings :', 'dwt-listing'); ?><?php echo dwt_listing_get_all_listing_count($user_id); ?></p>
                                            <?php echo($user_loc); ?>
                                            <div class="agent-button">
                                                <a href="<?php echo esc_url($user_profile_url); ?>"><?php echo esc_html__('View Profile', 'dwt-listing'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php echo dwt_listing_comments_pagination($total_pages, $page); ?>
                </div>
                <?php get_sidebar('authors'); ?>
            </div>
            <!-- Row End -->
        </div>
    </section>
<?php get_footer(); ?>