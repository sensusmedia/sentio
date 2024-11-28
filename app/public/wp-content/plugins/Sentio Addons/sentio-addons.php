<?php
/**
 * Plugin Name: Sentio Addons
 * Description: A WordPress plugin that adds custom Elementor widgets.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: sentio-addons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Check if Elementor is active
function sentio_addons_is_elementor_active() {
    return did_action('elementor/loaded');
}

// Register the "Sentio" widget category
function sentio_addons_register_category($elements_manager) {
    $elements_manager->add_category(
        'sentio',
        [
            'title' => __('Sentio', 'sentio-addons'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'sentio_addons_register_category');

// Function to register widgets
function sentio_addons_register_widgets() {
    // Check if Elementor is loaded
    if (!sentio_addons_is_elementor_active()) {
        return;
    }

    // Include widget files
    require_once plugin_dir_path(__FILE__) . 'widgets/widget-one.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/widget-two.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/widget-three.php';

    // Register widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Sentio\WidgetOne());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Sentio\WidgetTwo());
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Sentio\WidgetThree());
}

// Hook the registration function into the Elementor widget registration action
add_action('elementor/widgets/register', 'sentio_addons_register_widgets');
