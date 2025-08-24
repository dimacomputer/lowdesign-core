<?php

function render_featured_svg_inline($class = 'featured-image-svg featured-image-main', $post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    if (!get_post_status($post_id)) {
        echo '<span class="text-muted small">⚠️ Invalid post ID</span>';
        return;
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);
    if (!$thumbnail_id) {
        echo '<span class="text-muted small">⚠️ No featured image</span>';
        return;
    }

    $file_url = wp_get_attachment_url($thumbnail_id);
    $file_path = get_attached_file($thumbnail_id);
    $file_type = wp_check_filetype($file_url);

    if (!$file_url || !$file_path || !file_exists($file_path)) {
        echo '<span class="text-muted small">⚠️ Image file missing</span>';
        return;
    }

    $is_svg = $file_type['ext'] === 'svg' || str_ends_with(strtolower($file_url), '.svg');

    // Get ACF color class
    $page_color = strtolower(trim(get_field('page_color', $post_id))) ?: 'body';
    $valid_colors = ['blue','indigo','purple','pink','red','orange','yellow','green','teal','cyan','body','secondary','muted'];
    $color_class = in_array($page_color, $valid_colors) ? 'color-' . $page_color : 'color-body';

    if ($is_svg) {
        $svg = @file_get_contents($file_path);
        if (!$svg) {
            echo '<span class="text-muted small">⚠️ Failed to load SVG</span>';
            return;
        }

        // Clean SVG and apply class + currentColor
        $svg = preg_replace('/<\?xml.*?\?>/i', '', $svg);
        $svg = preg_replace('/<!DOCTYPE.*?>/i', '', $svg);
        $svg = preg_replace('/fill=["\']?(#[a-fA-F0-9]{3,6}|black|none)["\']?/i', 'fill="currentColor"', $svg);

        // Inject class into <svg>
        $svg = preg_replace('/<svg/i', '<svg class="' . esc_attr($class . ' ' . $color_class) . '"', $svg);

        echo $svg;
        return;
    }

    echo get_the_post_thumbnail($post_id, 'large', ['class' => esc_attr($class . ' ' . $color_class)]);
}