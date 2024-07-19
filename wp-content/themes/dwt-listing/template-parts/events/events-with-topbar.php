<?php global $dwt_listing_options; ?>
<section class="list-section-1">
    <div class="container">
        <?php require trailingslashit(get_template_directory()) . 'template-parts/events/filters.php'; ?>
    </div>
</section>

<section class="list-boxes">
    <div class="container">
        <div class="row">
            <div class="sk-circle">
                <div class="sk-circle1 sk-child"></div>
                <div class="sk-circle2 sk-child"></div>
                <div class="sk-circle3 sk-child"></div>
                <div class="sk-circle4 sk-child"></div>
                <div class="sk-circle5 sk-child"></div>
                <div class="sk-circle6 sk-child"></div>
                <div class="sk-circle7 sk-child"></div>
                <div class="sk-circle8 sk-child"></div>
                <div class="sk-circle9 sk-child"></div>
                <div class="sk-circle10 sk-child"></div>
                <div class="sk-circle11 sk-child"></div>
                <div class="sk-circle12 sk-child"></div>
            </div>
            <?php
            if ($results->have_posts()) {
                echo '<div class="s_ajax">';
                require trailingslashit(get_template_directory()) . 'template-parts/events/event-type-grid.php';
                echo '' . ($fetch_output);
                echo '</div>';
                wp_reset_postdata();
                echo '<div class="col-md-12 cpl-xs-12 col-sm-12 clearfix" id="listing_ajax_pagination">';
                echo dwt_listing_ajax_pagination_search($results);
                echo '</div>';
            } else {
                //no result found
                echo '<div class="s_ajax">' . dwt_listing_ajax_no_result() . '</div>';
            }
            ?>
        </div>
    </div>
</section>