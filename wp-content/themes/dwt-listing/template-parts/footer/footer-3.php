<?php global $dwt_listing_options; ?>
<footer class="footer-3">
    <div class="container">
        <div class="row">
            <?php
            $layout = isset($dwt_listing_options['dwt_listing_layout-sorter-3']['enabled']) ? $dwt_listing_options['dwt_listing_layout-sorter-3']['enabled'] : '';
            if ($layout): foreach ($layout as $key => $value) {
                    switch ($key) {
                        case 'logo': get_template_part('template-parts/footer/drag-3/logo', '1');
                            break;

                        case 'quciklinks': get_template_part('template-parts/footer/drag-3/quicklinks', '1');
                            break;

                        case 'post': get_template_part('template-parts/footer/drag-3/blogpost', '1');
                            break;

                        case 'info': get_template_part('template-parts/footer/drag-3/contactinfo', '1');
                            break;
                    }
                }
            endif;
            ?>
        </div>
    </div>
</footer>
<section class="footer-bottom-section light-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="footer-bottom">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php echo dwt_listing_footer_copyrights(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>