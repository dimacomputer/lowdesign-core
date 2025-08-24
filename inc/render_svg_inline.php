<?php

function render_svg_inline($filename, $class = 'icon') {
    // ✅ Optional: allow only known SVG filenames
    $allowed_icons = [
        'site_logo.svg',
        'chevron_close.svg',
        'chevron_burger.svg',
        'chevron_left.svg',
        'chevron_right.svg',
        'chevron_external_link.svg',
        // Add more icon filenames here
    ];

    if (!in_array($filename, $allowed_icons)) {
        echo '<span class="text-warning small">⚠️ Icon not allowed</span>';
        return;
    }

    // 🔍 Fetch attachment by filename
    $attachments = get_posts([
        'post_type'   => 'attachment',
        'post_status' => 'inherit',
        'numberposts' => 1,
        'meta_query'  => [[
            'key'     => '_wp_attached_file',
            'value'   => '/' . $filename,
            'compare' => 'LIKE',
        ]]
    ]);

    if (!empty($attachments)) {
        $svg_url = wp_get_attachment_url($attachments[0]->ID);
        $response = wp_remote_get($svg_url);

        if (!is_wp_error($response)) {
            $svg = wp_remote_retrieve_body($response);

            if (!empty($svg)) {
                // ✅ Clean XML/doctype headers
                $svg = preg_replace('/<\?xml.*?\?>/i', '', $svg);
                $svg = preg_replace('/<!DOCTYPE.*?>/i', '', $svg);

                // ✅ Remove hardcoded width and height from <svg>
                $svg = preg_replace('/(<svg[^>]*?)\swidth="[^"]*"/i', '$1', $svg);
                $svg = preg_replace('/(<svg[^>]*?)\sheight="[^"]*"/i', '$1', $svg);

                // ✅ Inject class and fill style
                $svg = preg_replace('/<svg\b/i', '<svg class="' . esc_attr($class) . '" style="fill: currentColor;"', $svg);

                // ✅ Ensure paths also inherit currentColor
                $svg = preg_replace('/fill=["\']#[a-fA-F0-9]{3,6}["\']/i', 'fill="currentColor"', $svg);

                echo $svg;
                return;
            }
        }
    }

    echo '<span class="text-muted small">⚠️ Icon not found</span>';
}
