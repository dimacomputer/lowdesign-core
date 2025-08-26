cat > /volume1/web/margo/wp-content/mu-plugins/lowdesign-core/lowdesign-core.php <<'PHP'
<?php
/**
 * Plugin Name: LowDesign Core (MU)
 * Description: Shared core for LowDesign sites (shortcodes, helpers, ACF, CPT plumbing).
 * Version: 0.1.0
 */

if (!defined('ABSPATH')) { exit; }

if (!defined('LOWDESIGN_CORE_ACTIVE')) {
    define('LOWDESIGN_CORE_ACTIVE', true);
}

/**
 * Инициализация ядра откладывается до plugins_loaded,
 * чтобы все плагины и среда WP уже были готовы.
 */
add_action('plugins_loaded', function () {
    $base = __DIR__;

    // Список файлов для подключения (мягко, если есть)
    $files = [
        $base . '/inc/acf.php',
        $base . '/inc/render_svg_inline.php',
        $base . '/inc/render_featured_svg_inline.php',
        $base . '/inc/get_featured_image_block.php',

        $base . '/modules/add_excerpt_to_pages.php',
        $base . '/modules/post_type_config.php',
        $base . '/modules/taxonomy_ui_role.php',
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            require_once $file;
        }
    }
});
PHP