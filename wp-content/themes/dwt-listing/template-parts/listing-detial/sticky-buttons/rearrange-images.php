<?php
global $dwt_listing_options;
$listing_id = get_the_ID();
$user_id = get_current_user_id();
if($user_id != 0 && $user_id!= ''){
if (get_post_field('post_author', $listing_id) == $user_id && get_post_meta($listing_id, 'dwt_listing_listing_status', true) == '1') {
    if (get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true) != "") {
        ?>
        <div class="sticky-button-rearrange">
            <?php
            if (dwt_listing_text('dwt_listing_disable_edit') == '1' && !is_super_admin(get_current_user_id())) {
                echo '<a href="javascript:void(0)" class="tool-tip" title=" ' . esc_html__('Rearrange Disable for Demo', 'dwt-listing') . '"><i class="ti-layers"></i></a>';
            } else {
                ?>	
                <a data-toggle="modal" data-target=".sortable-images" class="tool-tip" title="<?php echo esc_html__('Rearrange Listing Images', 'dwt-listing'); ?>"> <i class="ti-layers"></i></a>
            <?php } ?>
        </div>
        <!-- =-=-=-=-=-=-= Images Sorting =-=-=-=-=-=-= -->
        <div class="modal fade login sortable-images" tabindex="-1" role="dialog" >
            <div class="modal-dialog login animated">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo esc_html__('ReArrange Listing Images', 'dwt-listing'); ?></h4>
                    </div>
                    <div class="modal-body">  
                        <div class="box">
                            <div class="content">
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <small><?php echo esc_html__('*First image will be main display image of this ad.', 'dwt-listing'); ?></small>
                                    <ul id="sortable">
                                        <?php
                                        $media = dwt_listing_fetch_listing_gallery($listing_id);
                                        $img_ids = '';
                                        if (count($media) > 0) {
                                            foreach ($media as $m) {
                                                $mid = '';
                                                if (isset($m->ID))
                                                    $mid = $m->ID;
                                                else
                                                    $mid = $m;
                                                $img = wp_get_attachment_image_src($mid, 'dwt_listing_recent-posts');
                                                if ($img != '') {
                                                    $img = esc_url($img[0]);
                                                } else {
                                                    $img = '';
                                                }
                                                if ($img == "")
                                                    continue;
                                                $img_ids = $img_ids . $mid . ',';
                                                ?>
                                                <li class="ui-state-default">
                                                    <img alt="<?php echo get_the_title(); ?>" data-img-id="<?php echo '' . $mid; ?>" draggable="false" src="<?php echo $img; ?>">
                                                </li>
                                                <?php
                                            }
                                        }
                                        $img_ids = rtrim($img_ids, ',');
                                        if (get_post_meta($listing_id, 'dwt_listing_photo_arrangement_', true) == "")
                                            update_post_meta($listing_id, 'dwt_listing_photo_arrangement_', $img_ids);
                                        ?>
                                    </ul>
                                    <input type="hidden" id="listing_img_ids" value="<?php echo esc_attr($img_ids); ?>" />
                                    <input type="hidden" id="current_listing_id" value="<?php echo esc_attr($listing_id); ?>" />
                                    <button type="button" class="btn btn-theme sonu-button  btn-block" id="listing_sort_images"  data-loading-text="<i class='fa fa-spinner fa-spin'></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Re Arrange Images", 'dwt-listing'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
}