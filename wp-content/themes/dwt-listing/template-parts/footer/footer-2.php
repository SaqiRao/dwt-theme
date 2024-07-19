<?php global $dwt_listing_options; ?>
<div class="footer">
    <div class="container">
        <div class="row">
            <?php
            $layout = isset($dwt_listing_options['dwt_listing_layout-sorter']['enabled']) ? $dwt_listing_options['dwt_listing_layout-sorter']['enabled'] : '';
            if ($layout): foreach ($layout as $key => $value) {
                    switch ($key) {
                        case 'logo': get_template_part('template-parts/footer/drag-2/logo', '1');
                            break;

                        case 'quciklinks': get_template_part('template-parts/footer/drag-2/content', '1');
                            break;
                    }
                }
            endif;
            ?>
        </div>
    </div>
</div>