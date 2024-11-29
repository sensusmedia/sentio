<?php
/**
 * Plugin Name: Custom Elementor Widgets
 * Plugin URI: https://yourwebsite.com
 * Description: Add custom Elementor widgets to your WordPress site.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-elementor-widgets
 */

namespace CustomElementorWidgets; // Define the namespace

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Include the main Elementor plugin file.
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (!is_plugin_active('elementor/elementor.php')) {
    // Elementor is not activated.
    return;
}

// Include the main class for your plugin.
require_once(plugin_dir_path(__FILE__) . 'class-custom-elementor-widgets.php');

// Initialize the plugin.
function custom_elementor_widgets_init()
{
    $plugin = new \CustomElementorWidgets\Custom_Elementor_Widgets();
    $plugin->init();
}

// Hook into Elementor to initialize the plugin.
add_action('elementor/init', 'CustomElementorWidgets\custom_elementor_widgets_init');

