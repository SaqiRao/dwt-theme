<?php
$option = '';
if (isset($_GET['l_location']) && $_GET['l_location'] != "") {
    $loc_id = $_GET['l_location'];
    $get_valz = get_term_by('id', $loc_id, 'l_location');
    $final_id = $get_valz->term_id;
    $final_name = $get_valz->name;
    $option = '<option value="' . $final_id . '" selected="selected">' . $final_name . '</option>';
}
if (dwt_listing_countires_cookies() != "") {
    $loc_id = dwt_listing_countires_cookies();
    $get_valz = get_term_by('id', $loc_id, 'l_location');
    $final_id = $get_valz->term_id;
    $final_name = $get_valz->name;
    $option = '<option value="' . $final_id . '" selected="selected">' . $final_name . '</option>';
}
$term_ID = $term_idz = $tax_name = $term_id = $queried_object = $term_ID = '';
$queried_object = get_queried_object();
if (!empty($queried_object) && count((array) $queried_object) > 0) {
    $term_id = $queried_object->term_id;
    $tax_name = $queried_object->taxonomy;
    if (!empty($term_id)) {
        $term_idz = get_term_by('id', $term_id, $tax_name);
        $term_ID = $term_idz->term_id;
        $term_name = $term_idz->name;
        //for location only
        if (is_tax('l_location')) {
            $option = '<option value="' . $term_ID . '" selected="selected">' . $term_name . '</option>';
        }
    }
}
?>
<div class="listing-widget">
    <div class="form-group">
        <select id="region" data-placeholder="<?php echo esc_html__('Select Region', 'dwt-listing'); ?>" name="l_location"><?php echo ($option); ?></select>
    </div>
</div>