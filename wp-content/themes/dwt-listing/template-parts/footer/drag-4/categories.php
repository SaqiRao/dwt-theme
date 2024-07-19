<?php
global $dwt_listing_options;
if (!empty($dwt_listing_options["dwt_listing_getpop_catz"])) {
    $selected_terms = $dwt_listing_options["dwt_listing_getpop_catz"];
}

?>
<div class=" col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="dwt-footer-widgets">
        <h2><span><?php echo dwt_listing_themeOptions("dwt_listing_pop_catz"); ?></span></h2>
        <ul class="list">
            <?php
            if (!empty($selected_terms) && is_array($selected_terms)) {
                foreach ($selected_terms as $term) {
                    $term = dwt_listing_language_page_id_callback($term);
                    $term = dwt_listing_translate_object_id($term, 'l_category');
                    $term = get_term_by('id', absint($term), 'l_category');
                    if (is_object($term) && $term != '') {
                        ?>
                        <li><a href="<?php echo(get_term_link($term->slug, 'l_category')); ?>"><i
                                        class="fa fa-angle-right"></i><?php echo esc_attr($term->name); ?></a></li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
    </div>
</div> 