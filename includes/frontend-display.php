<?php
// Function to display the product label on single product pages
function webbuddy_display_product_label() {
    global $product;

    if (!$product || !is_product()) {
        return; // No product, just return silently
    }

    $settings = get_option('webbuddy_labels_settings');

    if (!isset($settings['categories']) || empty($settings['categories'])) {
        return; // No categories set, just return silently
    }

    $categories = (array) $settings['categories'];

    // If product does not match selected categories, just return without logging
    if (!has_term($categories, 'product_cat', $product->get_id())) {
        return;
    }

    // If the product belongs to the selected categories, display the label
    $label_text = esc_html($settings['label_text'] ?? 'Special Offer');
    $bg_color = esc_attr($settings['label_color'] ?? '#d8232a');
    $text_color = esc_attr($settings['label_text_color'] ?? '#ffffff');

    echo "<div class='webbuddy-label' style='background:$bg_color; color:$text_color;'>$label_text</div>";
}

// Shortcode function for Breakdance compatibility (Product Page ONLY)
function webbuddy_product_label_shortcode() {
    global $product;

    // Ensure $product is set correctly
    if (!is_a($product, 'WC_Product')) {
        $product = wc_get_product(get_the_ID());
    }

    if (!$product) {
        return ''; // No product found, just return silently
    }

    $settings = get_option('webbuddy_labels_settings');

    if (!isset($settings['categories']) || empty($settings['categories'])) {
        return ''; // No categories set, just return silently
    }

    $categories = (array) $settings['categories'];

    // If product does not match selected categories, just return without logging
    if (!has_term($categories, 'product_cat', $product->get_id())) {
        return '';
    }

    // If the product belongs to the selected categories, display the label
    $label_text = esc_html($settings['label_text'] ?? 'Special Offer');
    $bg_color = esc_attr($settings['label_color'] ?? '#d8232a');
    $text_color = esc_attr($settings['label_text_color'] ?? '#ffffff');

    return "<div class='webbuddy-label' style='background:$bg_color; color:$text_color;'>$label_text</div>";
}
add_shortcode('webbuddy_product_label', 'webbuddy_product_label_shortcode');

// Add action for WooCommerce standard themes (if needed)
add_action('woocommerce_before_single_product_summary', 'webbuddy_display_product_label', 5);
