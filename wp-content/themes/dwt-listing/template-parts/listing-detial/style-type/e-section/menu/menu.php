<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
$typ_class = 'menu-1cols';
if (dwt_listing_text('dwt_listing_menu_type_col') == 'column_2') {
    $typ_class = 'menu-2cols';
}
global $wpdb;
$get_results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '" . $listing_id . "' AND meta_key LIKE 'dwt_listing_menutype_%' ORDER BY meta_id ASC");
if (!empty($get_results) && count($get_results) > 0) {
    ?>
    <div class="panel panel-default" id="dfoodz-menu">
        <div class="panel-heading" role="tab" >
            <h4 class="panel-title"> <a  href="javascript:void(0)"><i class=" ti-view-list-alt"></i> <?php echo dwt_listing_text('dl_menu'); ?> </a> </h4>
        </div>
        <div id="foodz-menu-coll" class="panel-collapse">
            <div class="panel-body">
                <div class="panel-group" id="accordion-menu" role="tablist" aria-multiselectable="true">	
                    <?php
                    $count = 0;
                    foreach ($get_results as $results) {
                        if (!empty($results->meta_key)) {
                            $get_menu_itemz = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '" . $listing_id . "' AND meta_key LIKE 'menu_itemz_" . $results->meta_key . "%' ORDER BY meta_id ASC");
                            if (!empty($get_menu_itemz) && count($get_menu_itemz) > 0) {
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne-<?php echo esc_attr($count); ?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion-menu" href="#collapseOne-<?php echo esc_attr($count); ?>" aria-expanded="true" aria-controls="collapseOne-<?php echo esc_attr($count); ?>">
                                                <?php echo esc_attr($results->meta_value); ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne-<?php echo esc_attr($count); ?>" class="panel-collapse collapse <?php
                                    if ($count === 0) {
                                        echo "in";
                                    }
                                    ?>" role="tabpanel" aria-labelledby="headingOne-<?php echo esc_attr($count); ?>">
                                        <div class="panel-body">
                                            <ul class="food-menu <?php echo esc_attr($typ_class); ?>">
                                                <?php
                                                foreach ($get_menu_itemz as $itemz) {
                                                    $menu_inner_items = json_decode(stripslashes($itemz->meta_value));
                                                    if (!empty($menu_inner_items) && count($menu_inner_items) > 0) {
                                                        foreach ($menu_inner_items as $men) {
                                                            ?>
                                                            <li>
                                                                <h4><span class="menu-title"><?php echo esc_attr($men->l_menu_title); ?></span><span class="menu-price"><?php echo esc_attr($men->l_menu_price); ?></span></h4>
                                                                <div class="menu-text"><p><?php echo ($men->l_menu_desc); ?></p></div>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        $count++;
                    }
                    ?>	
                </div>
            </div>
        </div>
    </div> 
    <?php
}
?>