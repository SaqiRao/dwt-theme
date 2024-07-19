<?php if( !session_id() ){session_start();}else{}?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if (!is_page_template('page-profile.php')) {
     dwt_listing_site_spinner();
     dwt_listing_site_header();
}
if (!wp_basename(is_page_template('page-home.php')) && !wp_basename(is_page_template('page-profile.php'))) {
    echo dwt_listing_site_breadcrumb(); /* Get Breadcrumbs */
}