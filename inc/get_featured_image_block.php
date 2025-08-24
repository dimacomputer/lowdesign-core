<?php
/**
 * Get the featured image as either a rendered SVG or a raster <img> tag.
 *
 * @param string $context 'main' or 'sub' – affects the applied CSS classes.
 * @param int|null $post_id – fallback to current post ID.
 * @return string HTML block with featured image, or empty string if none.
 */
function get_featured_image_block($context = 'main', $post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $thumbnail_id = get_post_thumbnail_id($post_id);

    if (!$thumbnail_id) return '';

    $file_url  = wp_get_attachment_url($thumbnail_id);
    $file_path = get_attached_file($thumbnail_id);
    $file_type = wp_check_filetype($file_url);

    if (!$file_url || !$file_path || !file_exists($file_path)) return '';

    $is_svg = $file_type['ext'] === 'svg' || str_ends_with(strtolower($file_url), '.svg');
    $page_color = strtolower(trim(get_field('page_color', $post_id))) ?: 'body';
    $valid_colors = ['blue','indigo','purple','pink','red','orange','yellow','green','teal','cyan','body','secondary','muted'];
    $color_class = in_array($page_color, $valid_colors) ? 'color-' . $page_color : 'color-body';

    if ($is_svg) {
        $svg = @file_get_contents($file_path);
        if (!$svg) return '';

        // Cleanup SVG
        $svg = preg_replace('/<\?xml.*?\?>/i', '', $svg);
        $svg = preg_replace('/<!DOCTYPE.*?>/i', '', $svg);
        $svg = preg_replace('/fill=["\']?(#[a-fA-F0-9]{3,6}|black|none)["\']?/i', 'fill="currentColor"', $svg);

        // Inject classes into the opening <svg> tag
        $classes = 'featured-image-svg featured-image-' . $context . ' ' . esc_attr($color_class);
        $svg = preg_replace('/<svg\b([^>]*)>/', '<svg class="' . $classes . '"$1>', $svg);

        return $svg;
    }

    return get_the_post_thumbnail($post_id, 'full', [
        'class' => 'featured-image rounded-3 animate-in',
    ]);
}