<?php
global $dwt_listing_options;
if (isset($_GET['review_id']) && $_GET['review_id'] != "") {
    $listing_id = $_GET['review_id'];
} else {
    $listing_id = get_the_ID();
}
if (is_singular('listing')) {
    dwt_listing_feature_listign_expiry_checker($listing_id);
}
?>
<section class="transparent-breadcrumb-listing single-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <div class="short-detail">
                        <div class="list-heading">
                            <h2><?php echo dwt_listing_bread_crumb_heading(); ?> <?php echo dwt_listing_is_listing_featured($listing_id); ?></h2>
                        </div>
                        <div class="list-meta">
                            <?php get_template_part('template-parts/listing-detial/listing-meta/listing', 'meta'); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>