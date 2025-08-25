<?php
/**
 * Plugin Name: LowDesign Core
 * Description: MU-plugin с общими helper’ами, шорткодами, блоками и ACF JSON.
 * Author: litvinov.no
 * Version: 0.1.0
 */

if (!defined('ABSPATH')) exit;

define('LD_CORE_PATH', __DIR__);
define('LD_CORE_URL', plugins_url('', __FILE__));

// ACF Local JSON — грузим/сохраняем здесь (общие поля)
add_filter('acf/settings/save_json', function($path){ return LD_CORE_PATH . '/acf-json'; });
add_filter('acf/settings/load_json', function($paths){
  $paths[] = LD_CORE_PATH . '/acf-json';
  return $paths;
});

// Helpers / Shortcodes / Blocks
require_once LD_CORE_PATH . '/inc/helpers.php';
require_once LD_CORE_PATH . '/inc/shortcodes.php';

// Gutenberg blocks (PHP-rendered)
add_action('init', function () {
  register_block_type( LD_CORE_PATH . '/inc/blocks/ld-sample-block' );
});

// Optionally: editor styles (НЕ фронтенд)
add_action('enqueue_block_editor_assets', function(){
  wp_enqueue_style('ld-core-editor', LD_CORE_URL.'/assets/editor.css', [], '0.1.0');
});