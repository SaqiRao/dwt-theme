<?php
$flip_it = '';
if (is_rtl()) {
    $flip_it = 'flip';
}
?>
<form class="eventzform form-join" id="d_events_filters" method="post">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="list-box-shadow">
                <div class="row">
                    <?php
                    $layout = $dwt_listing_options['dwt_listing_events-filter-manager']['enabled'];
                    if ($layout): foreach ($layout as $key => $value) {
                        switch ($key) {
                            case 'by_title':
                                get_template_part('template-parts/events/search-filters/by_title');
                                break;
                            case 'by_category':
                                get_template_part('template-parts/events/search-filters/by_category');
                                break;
                            case 'by_location':
                                get_template_part('template-parts/events/search-filters/by_location');
                                break;
                            case 'by_date':
                                get_template_part('template-parts/events/search-filters/by_date');
                                break;
                        }
                    }
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="custom-sorting-filters">
                <div class="col-md-1 col-xs-4">
                    <div class="custom-allign">
                        <ul class="list-inline">
                            <li>
                                <button type="button" name="type" value="grid"><i class="fa fa-th-large"
                                                                                  aria-hidden="true"></i></button>
                            </li>
                            <li>
                                <button type="button" name="type" value="list"><i class="fa fa-th-list"
                                                                                  aria-hidden="true"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-11 col-xs-12">
                    <span class="custom-allign">
                        <span class="listing-sort__result"><?php echo esc_html__('Total Events : ', 'dwt-listing'); ?><strong><?php echo esc_html($results->found_posts); ?></strong> </span><span
                                id="result_reset">
                            <?php
                            if (!empty($_GET)) {
                                echo '<a class="main-listing__clear" href="javascript:void(0)" id="reset_ajax_reslut">' . esc_html__('Reset All Filters', 'dwt-listing') . '</a>';
                            }
                            ?>
                        </span></span>
                    <div class="form-inline pull-right <?php echo esc_attr($flip_it); ?>">
                        <div class="form-group">
                            <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            <label><?php echo esc_html__('Sort by', 'dwt-listing'); ?></label>
                        </div>
                        <div class="form-group">
                            <select name="sort_by" id="order_by" class="common-select event_sort_by">
                                <option value="id-desc">
                                    <?php echo esc_html__('Newest To Oldest', 'dwt-listing'); ?>
                                </option>
                                <option value="id-asc">
                                    <?php echo esc_html__('Oldest To New', 'dwt-listing'); ?>
                                </option>
                                <option value="title-asc">
                                    <?php echo esc_html__('Alphabetically [a-z]', 'dwt-listing'); ?>
                                </option>
                                <option value="title-desc">
                                    <?php echo esc_html__('Alphabetically [z-a]', 'dwt-listing'); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="layout_type" value="">
    <?php dwt_listing_form_lang_field_callback(true); ?>
</form> 