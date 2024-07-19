<?php
// Register metaboxes for Country CPT
add_action('add_meta_boxes', 'sb_meta_box_for_country');

function sb_meta_box_for_country() {
    add_meta_box('sb_metabox_for_country', 'Country', 'sb_render_meta_country', 'downtown_map_address', 'normal', 'high');
}

function sb_render_meta_country($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_country', 'meta_box_nonce_country');
    ?>
    <div class="margin_top">
        <input type="text" name="country_county" class="project_meta" placeholder="<?php echo esc_attr__('Country', 'dwt-listing-framework'); ?>" size="30" value="<?php echo get_the_excerpt($post->ID); ?>" id="country_county" spellcheck="true" autocomplete="off">
        <p><?php echo __('This should be follow ISO2 like', 'dwt-listing-framework'); ?> <strong><?php echo __('US', 'dwt-listing-framework'); ?></strong> <?php echo __('for USA and', 'dwt-listing-framework'); ?> <strong><?php echo __('CA', 'dwt-listing-framework'); ?></strong> <?php echo __('for Canada', 'dwt-listing-framework'); ?>, <a href="http://data.okfn.org/data/core/country-list" target="_blank"><?php echo __('Read More.', 'dwt-listing-framework'); ?></a></p>
    </div>

    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_country');

function sb_themes_meta_save_country($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!isset($_POST['meta_box_nonce_country']) || !wp_verify_nonce($_POST['meta_box_nonce_country'], 'my_meta_box_nonce_country'))
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (isset($_POST['country_county'])) {
        $my_post = array(
            'ID' => $post_id,
            'post_excerpt' => $_POST['country_county'],
        );
        global $wpdb;
        $county = $_POST['country_county'];
        $wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$county' WHERE ID = '$post_id'");
    }
}