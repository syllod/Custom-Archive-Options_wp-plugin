<?php
/**
 * Plugin Name: Custom Archive Options Plugin
 * Plugin URL: https://github.com/syllod/Custom-Archive-Options_wp-plugin
 * Description: This plugin allows customizing titles, intros, and images for Custom Post Types archives and blogs.
 * Version: 1.0.0
 * Author: Sylvain L - Syllod
 * Author URI: https://github.com/syllod
*/

//***********************Create the CPT options page
function custom_archive_add_options_page() {
    add_menu_page(
        'Archive Settings',
        'Archive Settings',
        'manage_options',
        'archive-settings',
        'custom_archive_options_page_html'
    );
}
add_action('admin_menu', 'custom_archive_add_options_page');

//***********************HTML for the options page
function custom_archive_options_page_html() {
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('archive-options-group');
            do_settings_sections('archive-settings');
            submit_button('Save Changes');
            ?>
        </form>
    </div>
    <?php
}

//***********************Register the settings
function custom_archive_register_settings() {
    // Dynamically retrieve the list of custom post types
    $post_types = array_keys(get_post_types(['_builtin' => false], 'names')); 

    // List of CPTs to exclude
    $exclude_post_types = [
        'elementor_library',
        'acf-taxonomy',
        'acf-post-type',
        'acf-field-group',
        'acf-field',
        'custom-css-js',
        'wpforms',
        'astra-advanced-hook'
    ];

    // Filter out the CPTs to exclude
    $post_types = array_diff($post_types, $exclude_post_types);

    // Include the blog in the post_types array
    array_push($post_types, 'blog');

    foreach ($post_types as $post_type) {
        // Register intro fields
        register_setting('archive-options-group', 'custom_archive_intro_' . $post_type);

        // Register image fields
        register_setting('archive-options-group', 'custom_archive_image_' . $post_type);

        // Register custom title fields
        register_setting('archive-options-group', 'custom_archive_title_' . $post_type);

        // Add sections
        add_settings_section(
            'custom_archive_section_' . $post_type,
            '<hr> - ' . ucfirst(str_replace('-', ' ', $post_type)), // Replace hyphens with spaces
            '',
            'archive-settings'
        );

        // Add custom title fields
        add_settings_field(
            'custom_archive_title_' . $post_type,
            'Custom Title',
            'custom_archive_title_field_html',
            'archive-settings',
            'custom_archive_section_' . $post_type,
            ['post_type' => $post_type]
        );

        // Add intro fields
        add_settings_field(
            'custom_archive_intro_' . $post_type,
            'Intro Text',
            'custom_archive_intro_field_html',
            'archive-settings',
            'custom_archive_section_' . $post_type,
            ['post_type' => $post_type]
        );

        // Add image fields
        add_settings_field(
            'custom_archive_image_' . $post_type,
            'Image URL',
            'custom_archive_image_field_html',
            'archive-settings',
            'custom_archive_section_' . $post_type,
            ['post_type' => $post_type]
        );

    }
}
add_action('admin_init', 'custom_archive_register_settings');

//***********************HTML for fields
function custom_archive_title_field_html($args) {
    $title_text = get_option('custom_archive_title_' . $args['post_type']);
    ?>
    <input type="text" name="custom_archive_title_<?= $args['post_type']; ?>" value="<?= esc_attr($title_text); ?>" size="50">
    <?php
}

function custom_archive_intro_field_html($args) {
    $intro_text = get_option('custom_archive_intro_' . $args['post_type']);
    ?>
    <textarea name="custom_archive_intro_<?= $args['post_type']; ?>" rows="5" cols="50"><?= esc_textarea($intro_text); ?></textarea>
    <?php
}

function custom_archive_image_field_html($args) {
    $image_url = get_option('custom_archive_image_' . $args['post_type']);
    ?>
    <input type="text" name="custom_archive_image_<?= $args['post_type']; ?>" value="<?= esc_url($image_url); ?>" size="50">
    <?php
}

//***********************Shortcodes
function custom_archive_image_shortcode() {
    $post_types = array_keys(get_post_types(['_builtin' => false], 'names'));
    array_push($post_types, 'blog');

    foreach ($post_types as $post_type) {
        if (is_post_type_archive($post_type) || (is_home() && $post_type == 'blog')) {
            return esc_url(get_option('custom_archive_image_' . $post_type));
        }
    }

    return '';
}
add_shortcode('custom_archive_image', 'custom_archive_image_shortcode');

function custom_archive_title_shortcode() {
    $post_types = array_keys(get_post_types(['_builtin' => false], 'names'));
    array_push($post_types, 'blog');

    foreach ($post_types as $post_type) {
        if (is_post_type_archive($post_type) || (is_home() && $post_type == 'blog')) {
            return '<h1>' . esc_html(get_option('custom_archive_title_' . $post_type)) . '</h1>';
        }
    }

    return '';
}
add_shortcode('custom_archive_title', 'custom_archive_title_shortcode');

function custom_archive_intro_shortcode() {
    $post_types = array_keys(get_post_types(['_builtin' => false], 'names'));
    array_push($post_types, 'blog');

    foreach ($post_types as $post_type) {
        if (is_post_type_archive($post_type) || (is_home() && $post_type == 'blog')) {
            return '<p>' . esc_html(get_option('custom_archive_intro_' . $post_type)) . '</p>';
        }
    }

    return '';
}
add_shortcode('custom_archive_intro', 'custom_archive_intro_shortcode');
