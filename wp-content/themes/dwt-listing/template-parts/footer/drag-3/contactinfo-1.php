<?php global $dwt_listing_options; ?>
<div class="col-sm-6 col-md-3 col-xs-12">
    <div class="footer_block">
        <h4><?php echo dwt_listing_themeOptions("dwt_listing_footer-address-tile"); ?></h4>
        <ul class="personal-info">
            <?php
            if (isset($dwt_listing_options["dwt_listing_footer-address"])) {
                $addresses = $dwt_listing_options["dwt_listing_footer-address"];
                $addressHTM = '';
                foreach ($addresses as $key => $val) {
                    if ($val != "" && $key == "address")
                        $addressHTM .= '<li><i class="fa fa-map-marker"></i> ' . $val . '</li>';
                    else if ($val != "" && $key == "email")
                        $addressHTM .= '<li><i class="fa fa-envelope"></i> ' . $val . '</li>';
                    else if ($val != "" && $key == "phone")
                        $addressHTM .= '<li><i class="fa fa-phone"></i> ' . $val . '</li>';
                    else if ($val != "" && $key == "clock")
                        $addressHTM .= '<li><i class="fa fa-clock-o"></i> ' . $val . '</li>';
                }
                echo '' . $addressHTM;
            }
            ?>
        </ul>
    </div>
</div>