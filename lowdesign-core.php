<?php
/**
 * LowDesign Core – MU plugin bootstrap
 */
if (!defined('ABSPATH')) { exit; }

error_log('[ld-core] bootstrap start');

add_action('plugins_loaded', static function () {
    error_log('[ld-core] plugins_loaded enter');
    $base = __DIR__;
    $files = [
        $base . "/inc/acf.php",
        $base . "/inc/ld_brand_asset.php",
        $base . "/inc/ld_icon_inline.php",
        $base . "/inc/get_featured_image_block.php",
        $base . "/inc/render_svg_inline.php",
        $base . "/inc/render_featured_svg_inline.php",
        $base . "/modules/add_excerpt_to_pages.php",
        $base . "/modules/post_type_config.php",
        $base . "/modules/taxonomy_ui_role.php",
    ];
    foreach ($files as $f) {
        error_log('[ld-core] try include: '.$f);
        if (is_readable($f)) {
            require_once $f;
            error_log('[ld-core] included: '.$f);
        } else {
            error_log('[ld-core] SKIP (not readable): '.$f);
        }
    }
    error_log('[ld-core] plugins_loaded done');
});

add_action("plugins_loaded", static function () {
    $base = __DIR__;
    $files = [
        // inc
        $base . "/inc/acf.php",
        $base . "/inc/ld_brand_asset.php",
        $base . "/inc/ld_icon_inline.php",
        $base . "/inc/get_featured_image_block.php",
        $base . "/inc/render_svg_inline.php",
        $base . "/inc/render_featured_svg_inline.php",
        // modules
        $base . "/modules/add_excerpt_to_pages.php",
        $base . "/modules/post_type_config.php",
        $base . "/modules/taxonomy_ui_role.php",
    ];

    foreach ($files as $f) {
        if (is_readable($f)) {
            require_once $f;
        } else {
            error_log("[lowdesign-core] Skip (not readable): " . $f);
        }
    }
});
PHP'