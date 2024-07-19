<?php global $dwt_listing_options; ?>
<div class="dark-footer">   
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?php
     $layout=isset($dwt_listing_options['dwt_listing_layout-sorter-4']['enabled']) ? $dwt_listing_options['dwt_listing_layout-sorter-4']['enabled'] : '';
                if ($layout): foreach ($layout as $key => $value) {
                        switch ($key) {
                            case 'logo': get_template_part('template-parts/footer/drag-4/logo', '1');
                                break;

                            case 'countries': get_template_part('template-parts/footer/drag-4/countries');
                                break;

                            case 'cats': get_template_part('template-parts/footer/drag-4/categories');
                                break;

                            case 'links': get_template_part('template-parts/footer/drag-4/links');
                                break;
                        }
                    }
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-text"><?php echo dwt_listing_footer_copyrights(); ?></div>				
                </div>
            </div>
        </div>
    </div>
</div>