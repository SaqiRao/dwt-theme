<?php
global $dwt_listing_options;
$no_left = '';
if( isset( $dwt_listing_options["dwt_listing_header-btn"] ) && $dwt_listing_options["dwt_listing_header-btn"] == "0" )
{
	$no_left = 'no-left-p';
}
get_template_part( 'template-parts/header/topbar');
?>
<div class="header-type-2">
<nav id="menu-1" class="mega-menu header2">
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12 col-xs-12 col-sm-12">
            	<div class="menu-list-items">
					<?php echo dwt_listing_site_logo('1'); ?>
                    <ul class="menu-button <?php echo esc_attr($no_left); ?>"><?php echo dwt_listing_header_profile_menu(); ?></ul>
                    <ul class="menu-links"><?php dwt_listing_themeMenu( 'main_menu' ); ?> </ul>
   				</div>
            </div>
        </div>
    </div>
</nav>
</div>