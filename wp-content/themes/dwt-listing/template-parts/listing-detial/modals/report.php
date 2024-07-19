<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<!-- Report Modal -->
<div class="modal fade report-quote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span
                            class="sr-only"><?php echo esc_html__('Close', 'dwt-listing'); ?></span></button>
                <h4 class="modal-title"><?php echo esc_html__('Why are you reporting this listing?', 'dwt-listing'); ?></h4>
            </div>
            <div class="modal-body">
                <!-- content goes here -->
                <form id="report-form" method="post" data-disable="false">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group has-feedback">
                            <select data-placeholder="<?php echo esc_html__('Select a reason', 'dwt-listing'); ?>"
                                    class="custom-select" name="report_cat" required id="report_option">
                                <option value=""><?php echo esc_html__('Select an option', 'dwt-listing'); ?></option>
                                <?php
                                $options = explode('|', $dwt_listing_options['report_options']);
                                foreach ($options as $option) {
                                    ?>
                                    <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-xs-12  col-md-12 col-sm-12">
                        <textarea required name="report_reason"
                                  placeholder="<?php echo esc_html__('Write your comments.', 'dwt-listing'); ?>"
                                  rows="7" class="form-control" id="report_comments"></textarea>
                        <div class="with-errors"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sx-12 col-sm-12">
                        <input type="hidden" name="listing_id" id="listing_id"
                               value="<?php echo esc_attr($listing_id); ?>"/>
                        <button type="submit" class="btn btn-theme sonu-button  btn-block"
                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo esc_html__("Processing...", 'dwt-listing'); ?>"><?php echo esc_html__("Submit", 'dwt-listing'); ?></button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>