<?php
extract(shortcode_atts(array(
    'section_bg' => '',
    'bg_img' => '',
    'bg_img1' => '',
    'bg_img2' => '',
    'section_title' => '',
    'section_description' => '',
    'woo_products' => '',
    'section_tag_line' => '',
    'want_to_show' => '',
    'google_or_custom' => '',
    'event_or_listing' => '',
    'form_text' => '',
    'ad_type' => '',
    'layout_type' => '',
    'ad_order' => '',
    'no_of_ads' => '',
    'main_link' => '',
    'main_link_2' => '',
    'loc_desc' => '',
    'app_img' => '',
    'a_link' => '',
    'ios_link' => '',
    'max_limit' => '',
    'img_postion' => '',
    'shop_layout_type' => '',
    'content_custom' => '',
    'overlay_effect' => '',
    'max_tags_limit' => '',
    'is_display_tags' => '',
    'sticky_left' => '',
    'sticky_right' => '',
    'ad_720_90' => '',
    'pattern_chk' => '',
    'rotating_words' => '',
                ), $atts));

$main_title = '';
$main_title = $section_title;
$header = dwt_listing_headings($main_title, $section_description);

$style = '';
$bg_color = '';
$class = '';
if (isset($section_bg) && $section_bg == 'img') {
    $class = 'parallex';
    $bgImageURL = dwt_listing_return_img_src($bg_img);
    $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
} else {
    $style = '';
    $bg_color = $section_bg;
}
?>