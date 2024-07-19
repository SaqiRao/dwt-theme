<?php
global $dwt_listing_options;
$profile = new dwt_listing_profile();
$user_id = $profile->user_info->ID;
$logo = trailingslashit(get_template_directory_uri()) . 'assets/images/logo.png';

$chat_option = isset($dwt_listing_options['enable_chat_option']) ? $dwt_listing_options['enable_chat_option'] : ""; 
if (isset($dwt_listing_options["dwt_listing_logo"])) {
    $logo = $dwt_listing_options["dwt_listing_logo"]["url"];
}
$action = dwt_listing_pagelink('dwt_listing_seacrh_page');
$get_user_dp = dwt_listing_get_user_dp($user_id, 'dwt_listing_user-dp');
$icon = 'left';
$navbar = 'navbar-left';
$btn_right = 'navbar-btn-right';
$nav_right = 'navbar-right';
if (is_rtl()) {
    $icon = 'right';
    $navbar = 'navbar-right';
    $btn_right = 'navbar-btn-left';
    $nav_right = 'navbar-left';
}
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="<?php echo esc_url(home_url("/")); ?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr__('logo', 'dwt-listing'); ?>" class="img-responsive logo"></a>
    </div>
    <div class="container-fluid">

        <form action="<?php echo esc_attr($action); ?>" class="custom-style-search top-search-form navbar-form <?php echo esc_attr($navbar); ?>">
            <div class="form-group">
                <div class="typeahead__container">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input autocomplete="off" type="search" class="for_sp_home dwt-search form-control" placeholder="<?php echo esc_html__('What Are You Looking For?', 'dwt-listing'); ?>">
                        </div>
                        <div class="typeahead__button">
                            <button type="submit">
                                <span class="typeahead__search-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <input id="by_title_home" type="hidden" name="by_title" value="">
            <input id="l_category_home" type="hidden" name="l_category" value="">
            <input id="l_tag_home" type="hidden" name="l_tag" value="">
        </form>
        <div class="navbar-btn <?php echo esc_attr($btn_right); ?>">
            <?php
            if (isset($dwt_listing_options["dwt_listing_header-btn"]) && $dwt_listing_options["dwt_listing_header-btn"] == "1") {
                ?>	
                <a class="btn btn-main btn-pad" href="<?php echo esc_url(get_the_permalink($dwt_listing_options["dwt_listing_header-page"])); ?>"><i class="lnr lnr-plus-circle"></i> <span><?php echo esc_attr($dwt_listing_options["dwt_listing_header-text"]); ?></span></a>
                <?php
            }
            if (dwt_listing_text('dwt_listing_disable_submission') == '0' && $dwt_listing_options["dwt_listing_header-btn"] == "0") {
                ?>
                <a class="btn btn-main btn-pad" href="<?php echo esc_url(get_the_permalink($dwt_listing_options["dwt_listing_disable_after_page"])); ?>"><i class="lnr lnr-magnifier"></i> <span><?php echo esc_attr($dwt_listing_options["dwt_listing_disable_header_text"]); ?></span></a>
                <?php
            }
            ?>
        </div>

        <div id="navbar-menu" class="hidden-xs">
            <ul class="nav navbar-nav <?php echo esc_attr($nav_right); ?>">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo esc_url($get_user_dp); ?>" class="img-circle" alt="<?php echo esc_attr($profile->user_info->display_name); ?>"> <span><?php echo esc_attr($profile->user_info->display_name); ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li>
                            <?php
                            $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'dashboard'));
                            ?>
                            <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-home"></i> <span><?php echo esc_html__("Dashboard", 'dwt-listing'); ?></span> </a>
                        </li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'profile'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-user"></i> <span><?php echo esc_html__("Profile", 'dwt-listing'); ?></span></a></li>
                        <?php

                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'publish'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-list"></i> <span><?php echo esc_html__("Listings", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'publish-events'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-calendar-full"></i> <span><?php echo esc_html__("Events", 'dwt-listing'); ?></span></a></li>
                        <!-- Create Speaker -->
                        <li>
                        <?php 
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'create-speaker'));
                        ?>
                            <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-mic"></i> <span><?php echo esc_html__("Create Speaker", 'dwt-listing'); ?></span></a>
                        </li>
                        <li>
                        <?php 
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'all-speakers'));
                        ?>
                            <a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-mic"></i> <span><?php echo esc_html__("Event Speakers", 'dwt-listing'); ?></span></a>
                        </li>
                        <?php
                        if (dwt_listing_text('dwt_listing_disable_menu') == '1') {
                            $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'create-menu'));
                            ?>
                            <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-dinner"></i> <span><?php echo esc_html__("Menu", 'dwt-listing'); ?></span></a></li>
                        <?php } ?>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'received-reviews'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-star"></i> <span><?php echo esc_html__("Reviews", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'favourite'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-heart"></i> <span><?php echo esc_html__("Favorites", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'invoices'));
                        ?>
                        <!--Appointment-->
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-heart"></i> <span><?php echo esc_html__("Reservations", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'reservation'));
                        ?>
                        <!--Appointment ends here-->

                         <!--Funds and Deposits-->
                         <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-heart"></i> <span><?php echo esc_html__("Received Tickets", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'received-tickets'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-heart"></i> <span><?php echo esc_html__("Received Amount", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'received-amount'));
                        ?>
                        <!--Funds and Deposits ends here-->
                        
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-printer"></i> <span><?php echo esc_html__("Invoices", 'dwt-listing'); ?></span></a></li>
                        <?php
                        $listing_update_url = dwt_listing_set_url_params_multi(get_the_permalink(), array('listing-type'=> 'booking-timekit'));
                        ?>
                        <li><a href="<?php echo esc_url(dwt_listing_page_lang_url_callback($listing_update_url)); ?>"><i class="lnr lnr-calendar-full"></i> <span><?php echo esc_html__("Booking", 'dwt-listing'); ?></span></a></li>
                        
                        <li><a href="<?php echo wp_logout_url(home_url('/')); ?>"><i class="lnr lnr-exit"></i> <span><?php echo esc_html__("Logout", 'dwt-listing'); ?></span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-btn-mobz visible-xs visible-sm visible-md hidden">
            <button type="button" class="collaspe-btn-admin"><i class="lnr lnr-menu"></i></button>
        </div>
    </div>
</nav>