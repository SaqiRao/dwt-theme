<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
?>
<ul>
    <li>
        <span class="list-posted-date"><?php echo get_the_date(get_option('date_format'), $listing_id); ?></span>
    </li>

<?php
if (dwt_listing_text('dwt_listing_review_enable_stars') == '1') {
    $get_percentage = dwt_listing_fetch_reviews_average($listing_id);
    if (isset($get_percentage) && count((array) $get_percentage['ratings']) > 0 && count((array) $get_percentage['rated_no_of_times']) > 0) {
        ?>
            <li> <span class="ratings"> <?php echo '' . $get_percentage['total_stars']; ?> <i class="rating-counter"> (<?php echo esc_attr($get_percentage['rated_no_of_times']); ?> <?php echo esc_html__('ratings', 'dwt-listing'); ?>)</i> </span> </li>
            <?php
        }
    }
    ?>
        <?php
        if (isset($dwt_listing_options['enable_report_option']) && $dwt_listing_options['enable_report_option'] == true) {
            get_template_part('template-parts/listing-detial/report/report');
        }
        ?>
        <?php
        if (function_exists('pvc_get_post_views')) {
            echo '<li class="list-meta-with-icons"><a href="javascript:void(0)">' . esc_html__("Views", 'dwt-listing') . ' : ' . dwt_listing_number_format_short(pvc_get_post_views($listing_id)) . '</a></li>';
        }
        ?>    
</ul>