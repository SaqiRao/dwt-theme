<?php
global $dwt_listing_options;
$action = dwt_listing_pagelink('dwt_listing_seacrh_page');
$right_col = 'col-md-4 col-sm-12 col-sx-12';
if (dwt_listing_text('dwt_listing_sidebar_position') == 'right') {
    $right_col = 'col-md-4 col-sm-8 col-xs-12 col-md-push-8 col-sm-offset-2 col-md-offset-0';
}
?>
<div class="<?php echo esc_attr($right_col); ?>">
    <div class="search-heading-zone">
        <i class="fa fa-search" aria-hidden="true"></i>
        <span class="h4"><?php echo esc_html__('Search Filters', 'dwt-listing'); ?></span>
    </div>
    <aside class="listing-widget-sidebar">
        <form method="post" id="search_form_ajax">
            <?php
            if (is_active_sidebar('dwt_listing_search_sidebar')) {
                dynamic_sidebar('dwt_listing_search_sidebar');
            }
            ?>
            <?php
            if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
                echo '<input type="hidden" name="sort_by" value="' . $_GET['sort_by'] . '">';
            }
            ?>
            <?php dwt_listing_form_lang_field_callback(true); ?>
        </form>
    </aside>
</div>