<?php
function register_ui_role_taxonomy() {
    $labels = array(
        'name'              => _x('UI Roles', 'taxonomy general name'),
        'singular_name'     => _x('UI Role', 'taxonomy singular name'),
        'search_items'      => __('Search UI Roles'),
        'all_items'         => __('All UI Roles'),
        'edit_item'         => __('Edit UI Role'),
        'update_item'       => __('Update UI Role'),
        'add_new_item'      => __('Add New UI Role'),
        'new_item_name'     => __('New UI Role Name'),
        'menu_name'         => __('UI Roles'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'ui-role'),
        'show_in_rest'      => true,
    );

    register_taxonomy('ui_role', ['page', 'post', 'config', 'modeling', 'fineart'], $args);
}
add_action('init', 'register_ui_role_taxonomy');