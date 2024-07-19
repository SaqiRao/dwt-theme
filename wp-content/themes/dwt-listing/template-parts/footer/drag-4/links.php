<?php
global $dwt_listing_options;
$pages = '';
if (!empty($dwt_listing_options["dwt_listing_footer-pages"])) {
    $pages = $dwt_listing_options["dwt_listing_footer-pages"];
}
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="dwt-footer-widgets">
        <h2><span><?php echo dwt_listing_themeOptions("dwt_listing_footer-links-text"); ?></span></h2>
        <ul class="list">
            <?php
            if (is_array($pages) && count($pages) > 0) {
                foreach ($pages as $page) {
                    $page = dwt_listing_language_page_id_callback($page);
                    ?>
                    <li><a href="<?php echo esc_url(get_the_permalink($page)); ?>"><i
                                class="fa fa-angle-right"></i><?php echo esc_attr(get_the_title($page)); ?></a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>