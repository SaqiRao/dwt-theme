<?php get_header(); ?>
<?php

if (isset($_GET['type']) && $_GET['type'] != "" && $_GET['type'] != "1") {
    if ($_GET['type'] == 'listings' || $_GET['type'] == 'events') {
        get_template_part('template-parts/listing-detial/public-profile/profile');
    }
} else {
    require trailingslashit(get_template_directory()) . 'archive.php';
}
get_footer();
?>