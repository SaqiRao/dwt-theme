<?php
if (!defined('ABSPATH')) {
    exit;
}

/* Include Theme Options Tabs */
$current_dir = trailingslashit(__DIR__);
require_once $current_dir . 'option-header.php';
require_once $current_dir . 'option-typo.php';
require_once $current_dir . 'customization.php';
require_once $current_dir . 'option-admin.php';
require_once $current_dir . 'option-users.php';
require_once $current_dir . 'option-listing.php';
require_once $current_dir . 'option-profile.php';
require_once $current_dir . 'option-packages.php';
require_once $current_dir . 'option-blog.php';
require_once $current_dir . 'option-reviews.php';
require_once $current_dir . 'option-slugs.php';
require_once $current_dir . 'shop.php';
require_once $current_dir . 'option-apis.php';
require_once $current_dir . 'option-geo-api.php';
require_once $current_dir . 'option-maps.php';
require_once $current_dir . 'option-events.php';
require_once $current_dir . 'option-emails.php';
require_once $current_dir . 'option-zoom.php';
require_once $current_dir . 'compare-listings-admin.php';
if (function_exists('icl_object_id')) {
    require_once $current_dir . 'option-wpml.php';
}
require_once $current_dir . 'option-footer.php';