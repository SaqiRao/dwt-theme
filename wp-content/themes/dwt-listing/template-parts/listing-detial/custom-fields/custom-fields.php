<?php
global $dwt_listing_options;
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
$listing_id = get_the_ID();
global $wpdb;
$get_custom_fields = $wpdb->get_results("SELECT meta_value , meta_key FROM $wpdb->postmeta WHERE post_id = '$listing_id' AND meta_key LIKE 'field_multi_%' ORDER BY meta_id ASC");
if (count((array)$get_custom_fields) > 0) {
    ?>
    <div class="widget-custom-fields widget">
        <div class="additional-custom-fields " data-toggle="collapse" data-target="#additional-fields">
            <span><strong><?php echo dwt_listing_text('dl_custom'); ?></strong></span> <i
                    class="ti-angle-down pull-right <?php echo esc_attr($flip_it); ?>"></i></div>
        <div id="additional-fields" class="collapse in">
            <?php
            foreach ($get_custom_fields as $value) {
                $get_exploded_idz = explode('_', $value->meta_key);
                $get_single_id = $get_exploded_idz[3];
                $get_data = explode('|', $value->meta_value);
                ?>
                <h5><?php echo get_the_title($get_single_id); ?></h5>
                <ul class="listing-other-features additional-fields">
                    <?php
                    foreach ($get_data as $data) {
                        ?>
                        <li><i class="ti-check-box"></i> <?php echo esc_attr($data); ?></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}