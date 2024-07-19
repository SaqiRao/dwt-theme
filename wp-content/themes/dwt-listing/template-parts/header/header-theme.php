<?php
global $dwt_listing_options;
$no_left = '';
if (isset($dwt_listing_options["dwt_listing_header-btn"]) && $dwt_listing_options["dwt_listing_header-btn"] == "0") {
    $no_left = 'no-left-p';
}
?>
<section class="menu-transparent for-downtown-only">
    <nav id="menu-1" class="mega-menu transparent "> 
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="menu-list-items"> 
                        <?php echo dwt_listing_site_logo('1', 'transparent'); ?>
                        <ul class="menu-button <?php echo esc_attr($no_left); ?>"><?php echo dwt_listing_header_profile_menu(); ?></ul>
                        <ul class="menu-links"><?php dwt_listing_themeMenu('main_menu'); ?></ul>                                     
                    </div>
                </div>
            </div>
        </div>
    </nav>
</section>