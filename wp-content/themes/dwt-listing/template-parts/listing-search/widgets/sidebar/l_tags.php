<?php
//Get cats
$l_tags = get_terms(array('l_tags'), array('hierarchical' => 1));
if (!is_wp_error($l_tags) && !empty($l_tags)) {
    ?>	
    <div class="listing-widget">
        <div class="form-group">
            <select data-placeholder="<?php echo esc_html__('Filter By Tags', 'dwt-listing'); ?>" name="l_tag" class="allow_clear" id="l_tag">
                <option value=""><?php echo esc_html__('Select Tag', 'dwt-listing'); ?></option>
                <option value="all"><?php echo esc_html__('All Tags', 'dwt-listing'); ?></option>
                <?php
                foreach ($l_tags as $term) {
                    ?>	
                    <option <?php if ($term->term_id == $term_ID) { ?>selected="selected"<?php } ?> value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php
                }
                ?>
            </select>
        </div></div>
<?php } ?> 