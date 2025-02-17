<?php
// Includes the settings page for the plugin
function webbuddy_labels_admin_menu() {
    add_submenu_page(
        'woocommerce',
        'Product Labels',
        'Product Labels',
        'manage_woocommerce',
        'webbuddy-product-labels',
        'webbuddy_labels_settings_page'
    );
}
add_action('admin_menu', 'webbuddy_labels_admin_menu');

function webbuddy_labels_settings_page() {
    ?>
    <div class="wrap">
        <h1>WebBuddy Product Labels</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('webbuddy_labels_group');
            do_settings_sections('webbuddy-product-labels');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function webbuddy_labels_register_settings() {
    register_setting('webbuddy_labels_group', 'webbuddy_labels_settings', 'webbuddy_labels_sanitize');

    add_settings_section('webbuddy_labels_main', 'Product Label Settings', '', 'webbuddy-product-labels');

    add_settings_field('label_text', 'Label Text', 'webbuddy_labels_text_field', 'webbuddy-product-labels', 'webbuddy_labels_main');
    add_settings_field('label_color', 'Label Background Color', 'webbuddy_labels_color_field', 'webbuddy-product-labels', 'webbuddy_labels_main');
    add_settings_field('label_text_color', 'Label Text Color', 'webbuddy_labels_text_color_field', 'webbuddy-product-labels', 'webbuddy_labels_main');
    add_settings_field('categories', 'Select Categories', 'webbuddy_labels_category_field', 'webbuddy-product-labels', 'webbuddy_labels_main');
}
add_action('admin_init', 'webbuddy_labels_register_settings');

// Function to render the Label Text input field
function webbuddy_labels_text_field() {
    $options = get_option('webbuddy_labels_settings');
    $label_text = isset($options['label_text']) ? esc_attr($options['label_text']) : 'Special Offer';
    echo "<input type='text' name='webbuddy_labels_settings[label_text]' value='$label_text' />";
}

// Function to render the Label Background Color input field
function webbuddy_labels_color_field() {
    $options = get_option('webbuddy_labels_settings');
    $color = isset($options['label_color']) ? esc_attr($options['label_color']) : '#d8232a';
    echo "<input type='text' class='webbuddy-color-picker' name='webbuddy_labels_settings[label_color]' value='$color' />";
}

// Function to render the Label Text Color input field
function webbuddy_labels_text_color_field() {
    $options = get_option('webbuddy_labels_settings');
    $text_color = isset($options['label_text_color']) ? esc_attr($options['label_text_color']) : '#ffffff';
    echo "<input type='text' class='webbuddy-color-picker' name='webbuddy_labels_settings[label_text_color]' value='$text_color' />";
}

// Function to render the Categories selection field
function webbuddy_labels_category_field() {
    $options = get_option('webbuddy_labels_settings');
    $selected_categories = isset($options['categories']) ? (array) $options['categories'] : array();

    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    foreach ($categories as $category) {
        $checked = in_array($category->slug, $selected_categories) ? 'checked' : '';
        echo "<label><input type='checkbox' name='webbuddy_labels_settings[categories][]' value='{$category->slug}' $checked> {$category->name}</label><br />";
    }
}

function webbuddy_labels_sanitize($input) {
    $output = array();
    $output['label_text'] = sanitize_text_field($input['label_text']);
    $output['label_color'] = sanitize_hex_color($input['label_color']);
    $output['label_text_color'] = sanitize_hex_color($input['label_text_color']);
    $output['categories'] = array_map('sanitize_text_field', (array) $input['categories']);
    $output['show_on_shop'] = isset($input['show_on_shop']) ? 'yes' : 'no';
    return $output;
}
?>
