<?php
global $dwt_listing_options;
$listing_id = get_the_ID();
$listing_features = wp_get_object_terms($listing_id, array('l_category'), array('orderby' => 'name', 'order' => 'ASC'));
if (is_array($listing_features) && count($listing_features) > 1) {
    if (isset($listing_features) && $listing_features != "") {
        if (!is_wp_error($listing_features)) {
            echo '<h3> ' . dwt_listing_text('dl_amenties') . ' </h3><ul class="listing-other-features">';
            foreach ($listing_features as $term) {
                if ($term->parent == 0) {
                    continue;
                }
                echo '<li> <i class="ti-check-box"></i>' . esc_attr($term->name) . '</li>';
            }
            echo '</ul>';
        }
    }
}