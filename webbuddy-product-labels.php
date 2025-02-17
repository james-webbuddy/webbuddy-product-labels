<?php
/**
 * Plugin Name: WebBuddy WooCommerce Product Labels
 * Plugin URI:  https://webbuddy.ie/
 * Description: Adds a custom label to WooCommerce products based on categories.
 * Version:     1.1
 * Author:      WebBuddy
 * Author URI:  https://www.webbuddy.ie/
 * License:     GPL2
 * Text Domain: webbuddy-product-labels
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/frontend-display.php';

// Ensure the plugin loads the CSS
function webbuddy_enqueue_styles() {
    wp_enqueue_style('webbuddy-product-labels', plugin_dir_url(__FILE__) . 'assets/styles.css');
}
add_action('wp_enqueue_scripts', 'webbuddy_enqueue_styles');


// Plugin activation
function webbuddy_labels_activate() {
    add_option('webbuddy_labels_settings', array());
}
register_activation_hook(__FILE__, 'webbuddy_labels_activate');

// Plugin deactivation
function webbuddy_labels_deactivate() {
    delete_option('webbuddy_labels_settings');
}

register_deactivation_hook(__FILE__, 'webbuddy_labels_deactivate');
?>
