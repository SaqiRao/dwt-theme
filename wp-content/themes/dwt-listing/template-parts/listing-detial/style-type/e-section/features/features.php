<?php
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
$listing_features = wp_get_object_terms($listing_id, array('l_category'), array('orderby' => 'name', 'order' => 'ASC'));
if (is_array($listing_features) && count($listing_features) > 1) {
    if (isset($listing_features) && $listing_features != "") {
        if (!is_wp_error($listing_features)) {
            ?>	 
            <div class="panel panel-default" id="listing_features">
                <div class="panel-heading" role="tab" id="d_feat">
                    <h4 class="panel-title"> <a href="javascript:void(0)"><i class="  ti-crown  "></i> <?php echo dwt_listing_text('dl_amenties'); ?> </a> </h4>
                </div>
                <div  class="panel-collapse" role="tabpanel">
                    <div class="panel-body">
                        <ul class="listing-other-features list-inline">
            <?php
            foreach ($listing_features as $term) {
                if ($term->parent == 0) {
                    continue;
                }
                echo '<li> <i class="ti-check-box"></i>' . esc_attr($term->name) . '</li>';
            }
            ?>
                        </ul>
                    </div>
                </div>
            </div>
                            <?php
                        }
                    }
                }