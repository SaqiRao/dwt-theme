<?php
global $dwt_listing_options;
if (!is_page_template('page-profile.php')) {
    dwt_listing_site_footer();
}
if (is_singular('listing') || is_page_template('page-reviews.php')) {
    get_template_part('template-parts/listing-detial/modals/report');
    if (is_user_logged_in()) {
        get_template_part('template-parts/listing-detial/modals/claim');
    }
    get_template_part('template-parts/listing-detial/modals/coupon');
}
get_template_part('template-parts/profile/tracking/activity');
?>
<a href="javascript:void(0)" class="scrollup"><i class="fa fa-chevron-up"></i></a>


<br>


<?php
echo dwt_listing_authorization();
echo dwt_listing_essential_inputs();
echo dwt_listing_verification_logic();

if (is_page_template('page-profile.php') && !empty($_GET['listing-type']) && $_GET['listing-type'] == 'create-menu') {
    ?>
    <div class="modal fade menu_modalz custom_modals" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="ModalLabel"><?php echo esc_html__('Create Menu Type', 'dwt-listing'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="dwt_create_menu">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo esc_html__('Menu Name', 'dwt-listing'); ?>
                                <span>*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                <input type="text" class="form-control" name="l_menu_type"
                                       placeholder="<?php echo esc_html__('Classic Burger', 'dwt-listing') ?>" value=""
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-theme sonu-button create_menu"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Save", 'dwt-listing'); ?></button>
                        <button type="button" class="btn btn-light "
                                data-dismiss="modal"><?php echo esc_html__("Close", 'dwt-listing'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade menu_modalz_itemz custom_modals" tabindex="-1" role="dialog"
         aria-labelledby="ModalLabel_items" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="ModalLabel_items"><?php echo esc_html__('Add Menu Items', 'dwt-listing'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ad_menu_listz">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label"><?php echo esc_html__('Menu Title', 'dwt-listing'); ?>
                                <span>*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-pencil"></i></span>
                                <input type="text" class="form-control" name="dwt_l_menu_title"
                                       placeholder="<?php echo esc_html__('Classic Burger', 'dwt-listing') ?>" value=""
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo esc_html__('Price', 'dwt-listing'); ?><span>*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-money"></i></span>
                                <input type="text" class="form-control" name="dwt_l_menu_price"
                                       placeholder="<?php echo esc_html__('$20', 'dwt-listing') ?>" value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo esc_html__('Description', 'dwt-listing'); ?>
                                <span>*</span></label>
                            <textarea class="form-control" name="dwt_l_menu_desc"
                                      placeholder="<?php echo esc_html__('Mexican style, chicken fajita, green pepper & onions', 'dwt-listing'); ?>"
                                      required></textarea>
                        </div>
                        <input type="hidden" id="reference_key" name="reference_key" value="">
                        <input type="hidden" id="reference_listing" name="reference_listing" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-theme sonu-button added_new_itemz"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__('Save', 'dwt-listing'); ?></button>
                        <button type="button" class="btn btn-light"
                                data-dismiss="modal"><?php echo esc_html__('Close', 'dwt-listing'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- return eidt menu type -->
    <div class="edit_modal_menu"></div>
    <!-- show inner menu eidt menu type -->
    <div class="show_inner_menuz"></div>
    <!-- show inner menu eidt menu modal -->
    <div class="show_updated_modal"></div>
    <?php
}
?>
<?php wp_footer(); ?>
</body>
</html>