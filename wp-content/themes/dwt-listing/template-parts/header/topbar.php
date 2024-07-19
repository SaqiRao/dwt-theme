<?php
global $dwt_listing_options;
$flip = '';
if (is_rtl()) {
    $flip = 'flip';
}
if (isset($dwt_listing_options["dwt_listing_topbar"]) && $dwt_listing_options["dwt_listing_topbar"] == "1") {
    $contain_class = 'container';
    if (isset($dwt_listing_options["dwt_listing_header-layout"]) && $dwt_listing_options["dwt_listing_header-layout"] == '3') {
        $contain_class = 'container-fluid';
    }
    ?>
    <div class="header-info-bar">
        <div class="<?php echo esc_attr($contain_class); ?>">
            <div class="row">
                <div class="<?php if (empty($dwt_listing_options["dwt_listing_slogan"])) {
                    echo 'col-md-3';
                } else {
                    echo 'col-md-5';
                } ?> col-sm-5 col-xs-12">
                    <?php if (!empty($dwt_listing_options["dwt_listing_slogan"])) { ?>
                        <p><?php echo esc_attr($dwt_listing_options["dwt_listing_slogan"]); ?></p>
                    <?php } ?>
                    <?php
                    if (!empty($dwt_listing_options["dwt_listing_locationz"]) && $dwt_listing_options["dwt_listing_locationz"] == '1') {
                        ?>
                        <?php
                        $active_class = $image_idz = $final_img = $sel_image_link = $selected_loc = $loc_name = $selected_cookie = $image_id = $get_valz = '';
                        if (!empty($dwt_listing_options["dwt_listing_selected_locz"]) && count($dwt_listing_options["dwt_listing_selected_locz"]) > 0) {
                            if (!empty(dwt_listing_countires_cookies())) {
                                $selected_cookie = dwt_listing_translate_object_id(dwt_listing_countires_cookies(), 'l_location');
                                /* for wpml getting correct id after switch to other language */
                                $selected_loc = get_term_by('id', $selected_cookie, 'l_location');
                                if (is_object($selected_loc) && !empty($selected_loc)) {
                                    $loc_name = $selected_loc->name;
                                    $image_idz = get_term_meta($selected_loc->term_id, 'location_term_meta_img', true);
                                }
                                $sel_image_link = wp_get_attachment_image_src($image_idz, 'dwt_listing_small_thumb');
                                $sel_image_link = isset($sel_image_link[0]) ? $sel_image_link[0] : '';
                                if ($sel_image_link != "") {
                                    $final_img = $sel_image_link;
                                } else {
                                    $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/global.png');
                                }
                            } else {
                                $loc_name = esc_html__('All Locations', 'dwt-listing');
                                $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/global.png');
                            }
                            ?>
                            <ul class="list-inline">
                                <li class="dropdown location-selector">
                                    <span class="loc"><?php echo esc_attr($loc_name); ?> :</span>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"
                                       data-close-others="true">
                                        <img src="<?php echo esc_url($final_img); ?>"
                                             alt="<?php echo esc_attr($loc_name); ?>"/>
                                    </a>
                                    <ul class="dropdown-menu pull-right <?php echo esc_attr($flip); ?>">
                                        <li>
                                            <a href="javascript:void(0)" data-loc-id="" class="top-loc-selection">
                                                <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'assets/images/global.png'); ?>"
                                                     alt="<?php echo esc_attr__('All Locations', 'dwt-listing'); ?>"/>
                                                <span><?php echo esc_html__('All Locations', 'dwt-listing'); ?></span>
                                            </a>
                                        </li>
                                        <?php
                                        $selected_cookie;
                                        foreach ($dwt_listing_options["dwt_listing_selected_locz"] as $val) {
                                            $image_link = '';
                                            $get_valz = get_term_by('id', $val, 'l_location');
                                            if (is_object($get_valz) && !empty($get_valz)) {
                                                if (get_term_meta($get_valz->term_id, 'location_term_meta_img', true) != "") {
                                                    $image_id = get_term_meta($get_valz->term_id, 'location_term_meta_img', true);
                                                    $image_link = wp_get_attachment_image_src($image_id, 'dwt_listing_small_thumb');
                                                }
                                            }
                                            if (is_object($get_valz) && !empty($get_valz)) {
                                                ?>
                                                <li <?php
                                                if ($get_valz->term_id == $selected_cookie) {
                                                    echo 'class=active';
                                                }
                                                ?>>
                                                    <a href="javascript:void(0)"
                                                       data-loc-id="<?php echo esc_attr($get_valz->term_id); ?>"
                                                       class="top-loc-selection">
                                                        <?php if (isset($image_link[0]) && $image_link[0] != "") { ?>
                                                            <img src="<?php echo esc_url($image_link[0]); ?>"
                                                                 alt="<?php echo esc_attr($get_valz->name); ?>"/>
                                                        <?php } ?>
                                                        <span><?php echo esc_attr($get_valz->name); ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                            <?php
                        }
                        ?>
                    <?php } ?>
                </div>
                <div class="<?php if (empty($dwt_listing_options["dwt_listing_slogan"])) {
                    echo 'col-md-3';
                } else {
                    echo 'col-md-2';
                } ?> col-sm-2 col-xs-12">
                    <?php if (isset($dwt_listing_options["dwt_listing_lang_switcher"]) && $dwt_listing_options["dwt_listing_lang_switcher"] == "1") { ?>
                        <?php
                        echo dwt_listing_language_switcher();
                        ?>
                    <?php } ?>
                </div>
                <div class="<?php if (empty($dwt_listing_options["dwt_listing_slogan"])) {
                    echo 'col-md-6';
                } else {
                    echo 'col-md-5';
                } ?> col-sm-5 col-xs-12">
                    <ul class="header-social pull-right <?php echo esc_attr($flip); ?>">
                        <?php
                        $socialz = '';
                        if (!empty($dwt_listing_options["dwt_listing_share"])) {
                            $socialz = '';
                            foreach ($dwt_listing_options["dwt_listing_share"] as $key => $value) {
                                if ($key == "Facebook" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-facebook'><i class='fa fa-facebook'></i></a></li>";
                                }
                                if ($key == "Skype" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-skype'><i class='fa fa-skype'></i></a></li>";
                                }
                                if ($key == "Twitter" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-twitter'><i class='fa fa-twitter'></i></a></li>";
                                }
                                if ($key == "LinkedIn" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-linkedin'><i class='fa fa-linkedin'></i></a></li>";
                                }
                                if ($key == "Youtube" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-youtube'><i class='fa fa-youtube'></i></a></li>";
                                }
                                if ($key == "GooglePlus" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-google-plus'><i class='fa fa-google-plus'></i></a></li>";
                                }
                                if ($key == "Instagram" && $value != "") {
                                    echo "<li><a href=" . esc_url($value) . " class='social-instagram'><i class='fa fa-instagram'></i></a></li>";
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <?php
}