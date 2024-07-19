<?php
//Get cats
$listing_cats = dwt_listing_categories_fetch('l_category', 0);
if (count((array)$listing_cats) > 0) {
    ?>
    <div class="listing-widget">
        <div class="form-group">
            <select data-placeholder="<?php echo esc_html__('Select Category', 'dwt-listing'); ?>" name="l_category"
                    class="allow_clear" id="l_category">
                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                <option value="all"><?php echo esc_html__('All Categories', 'dwt-listing'); ?></option>
                <?php
                //selective
                if (isset($_GET['l_category']) && $_GET['l_category'] != "") {
                    $term_ID = $_GET['l_category'];
                }
                foreach ($listing_cats as $cats) {
                    ?>
                    <option <?php if ($cats->term_id == $term_ID) { ?>selected="selected"<?php } ?>
                            value="<?php echo esc_attr($cats->term_id); ?>"><?php echo esc_html($cats->name); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div id="dynamic_fields_sidebar_on" class="dynamic_fields_sidebar_filter"></div>
    </div>
    <?php
}
?>