<?php
add_filter('acf/settings/save_json', fn($p)=> get_stylesheet_directory().'/acf-json');
add_filter('acf/settings/load_json', function($paths){
  $paths[] = get_stylesheet_directory().'/acf-json';
  $paths[] = WP_CONTENT_DIR.'/mu-plugins/lowdesign-core/acf-json';
  return $paths;
});
