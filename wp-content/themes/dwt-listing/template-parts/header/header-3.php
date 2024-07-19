<?php $action = dwt_listing_pagelink('dwt_listing_seacrh_page'); ?>
<?php
global $dwt_listing_options;
$no_left = '';
if( isset( $dwt_listing_options["dwt_listing_header-btn"] ) && $dwt_listing_options["dwt_listing_header-btn"] == "0" )
{
	$no_left = 'no-left-p';
}
$by_title = '';
if( isset( $_GET['by_title'] ) && $_GET['by_title'] != "" )
{
	$by_title = $_GET['by_title'];
}
get_template_part( 'template-parts/header/topbar');
?>
<div class="header-type-3">
    <section class="header-top">
        <div class="container-fluid">
            <div class="row">
            <nav id="menu-1" class="mega-menu"> 
                     <div class="menu-list-items">
                <div class="col-md-2 col-sm-12 col-xs-12">
                    <?php echo dwt_listing_site_logo('1'); ?>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <form action="<?php echo esc_attr($action);?>" class="custom-style-search top-search-form">
                         <div class="form-group">
                             <div class="typeahead__container">
                                <div class="typeahead__field">
                                    <div class="typeahead__query">
                                         <input value="<?php echo esc_attr($by_title); ?>" autocomplete="off" type="search" class="for_sp_home dwt-search form-control" placeholder="<?php echo esc_html__('What Are You Looking For?','dwt-listing');?>">
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
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                        <ul class="menu-links"><?php dwt_listing_themeMenu( 'main_menu' ); ?> </ul>
                        <div class="header-top-profile">
                        <ul class="menu-button pull-right <?php echo esc_attr($no_left); ?>"><?php echo dwt_listing_header_profile_menu('3'); ?>
                        </ul>
                       </div>
                </div>
            </div>
             </nav>
          </div>
        </div>
    </section>
</div>