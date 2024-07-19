<?php global $dwt_listing_options;
//listing id
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
global $wpdb;
$get_custom_fields = $wpdb->get_results("SELECT meta_value , meta_key FROM $wpdb->postmeta WHERE post_id = '$listing_id' AND meta_key LIKE 'field_multi_%' ORDER BY meta_id ASC");
if (count($get_custom_fields) > 0) {
    ?>
    <div class="panel panel-default" id="dcustom-fields">
        <div class="panel-heading" role="tab" id="d_custom_fields">
            <h4 class="panel-title"><a href="javascript:void(0)"><i
                            class="ti-settings"></i> <?php echo dwt_listing_text('dl_custom'); ?> </a></h4>
        </div>
        <div class="panel-collapse" role="tabpanel">
            <div class="panel-body">
                <?php
                foreach ($get_custom_fields as $value) {
                    $get_exploded_idz = explode('_', $value->meta_key);
                    $get_single_id = $get_exploded_idz[3];
                    $get_data = explode('|', $value->meta_value);
                    ?>
                    <h5><?php echo get_the_title($get_single_id); ?></h5>
                    <ul class="listing-other-features additional-fields elegent-s">

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
    </div>
    <?php
}
?>