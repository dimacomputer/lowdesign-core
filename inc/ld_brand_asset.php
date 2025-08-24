// functions.php или core
function ld_brand_asset_path($file){
  $t = get_stylesheet_directory()."/assets/brand/$file";
  if (file_exists($t)) return $t;
  $c = WP_CONTENT_DIR."/mu-plugins/lowdesign-core/brand/$file";
  return file_exists($c) ? $c : null;
}
function ld_brand_asset_url($file){
  $t = get_stylesheet_directory()."/assets/brand/$file";
  if (file_exists($t)) return get_stylesheet_directory_uri()."/assets/brand/$file";
  $c = WP_CONTENT_DIR."/mu-plugins/lowdesign-core/brand/$file";
  return file_exists($c) ? content_url("mu-plugins/lowdesign-core/brand/$file") : null;
}
function ld_brand_logo($args=[]){
  $class = isset($args['class']) ? ' '.esc_attr($args['class']) : '';
  $label = isset($args['label']) ? ' aria-label="'.esc_attr($args['label']).'" role="img"' : ' aria-hidden="true"';
  $path = ld_brand_asset_path('logo.svg');
  if (!$path) return '';
  $svg  = file_get_contents($path);
  return '<span class="site-logo'.$class.'"'.$label.'>'.$svg.'</span>';
}