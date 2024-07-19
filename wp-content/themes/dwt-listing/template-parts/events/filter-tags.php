<?php
$param = dwt_listing_query_string_func('QUERY_STRING');
$search_params = array('event_cat', 'by_title', 'by_location');
$search_label = array('event_cat' => esc_html__('Event Category', 'dwt-listing'), 'by_title' => esc_html__('By Keyword', 'dwt-listing'), 'by_location' => esc_html__('By Location', 'dwt-listing'));
if (isset($param) && $param != "") {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dwt_listing_filters">
            <ul class="dwt_listing_filter-list">
                <?php
                parse_str($param, $vars);
                foreach ($vars as $key => $val) {
                    if (!in_array($key, $search_params))
                        continue;
                    if ($_GET[$key] == '')
                        continue;
                    ?>
                    <form method="get" action="<?php echo dwt_listing_pagelink('dwt_listing_event_page'); ?>">
                        <li class="dwt_listing_main-tags">
                            <span class="dwt_listing_main-tags-label"><?php echo esc_attr($search_label[$key]); ?></span>
                            <a href="javascript:void(0)" class="dwt_listing_main-tags-close event_on_submit">&times;</a>
                        </li>
        <?php echo dwt_listing_search_params($key); ?>
                    </form>
                    <?php } ?> 
            </ul>
            <a href="<?php echo dwt_listing_pagelink('dwt_listing_event_page'); ?>" class="main-listing__clear"><?php echo esc_html__('Clear All', 'dwt-listing'); ?></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php
}