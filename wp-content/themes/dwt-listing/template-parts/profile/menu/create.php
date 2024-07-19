<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$loader = $contitional_input = $menu_listing_id = '';
$most_viewed = '';
$most_viewed = dwt_listing_fetch_dashboard($user_id, true);
if (isset($_GET['management_id']) && $_GET['management_id'] != "") {
    $menu_listing_id = $_GET['management_id'];
    $contitional_input = '<input type="hidden" id="conditional_id" name="conditional_id" value="' . esc_attr($menu_listing_id) . '">';
    $loader = '<div class="sk-circle">
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
       </div>';
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7 col-lg-7 col-xs-12 col-sm-12">
            <div class="panel leads-activities">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Create Menu', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <form id="food_menu">
                        <div class="preloading" id="dwt_listing_loading"></div>
                        <div class="submit-listing-section">
                            <div class="row">
                                <?php
                                //Author Listings
                                $get_args = $profile->dwt_listing_fetch_my_listings();
                                $get_args = dwt_listing_wpml_show_all_posts_callback($get_args);
                                $my_listings = new WP_Query($get_args);
                                if ($my_listings->have_posts()) {
                                    ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo esc_html__('Select Listing', 'dwt-listing'); ?><span>*</span></label>
                                            <select data-placeholder="<?php echo esc_html__('Select Your Listing', 'dwt-listing'); ?>" name="menu_parent_listing" id="menu_parent_listingz" class="custom-select" required>
                                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                                <?php
                                                while ($my_listings->have_posts()) {
                                                    $my_listings->the_post();
                                                    $listing_id = get_the_ID();
                                                    ?>
                                                    <option value="<?php echo esc_html($listing_id) ?>" <?php if ($listing_id == $menu_listing_id) { ?>selected="selected"<?php } ?>><?php echo esc_attr(get_the_title($listing_id)); ?></option>
                                                    <?php
                                                }
                                                wp_reset_postdata();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-md-12 col-xs-12 col-sm-12 menu-btn none">                             
                                    <button type="button" data-toggle="modal" data-target=".menu_modalz" class="btn btn-admin pull-right create_menu_types"><i class="fa fa-plus" aria-hidden="true"></i><?php echo esc_html__("Add Menu", 'dwt-listing'); ?></button>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">       
                                    <div id="append_result"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <?php echo ($loader); ?>
                    <?php echo ($contitional_input); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Most Viewed Listings', 'dwt-listing'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php
                    $fetch_output = '';
                    $my_listings = new WP_Query($most_viewed);
                    if ($my_listings->have_posts()) {
                        $list = new dwt_listing_listings();
                        ?>		
                        <ul class="list-unstyled dwt-panel-listz">
                            <?php
                            while ($my_listings->have_posts()) {
                                $fetch_output = '';
                                $my_listings->the_post();
                                $listing_id = get_the_ID();
                                $function = "dwt_listing_most_viewed";
                                echo $fetch_output .= $list->$function($listing_id);
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>