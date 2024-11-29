<?php
namespace CustomElementorWidgets; // Define the namespace

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Elementor_Widgets
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Add actions or filters here if needed.
    }

    /**
     * Initialize the plugin.
     */
    public function init()
    {
        // Include additional files here if needed.
        $this->register_widgets();
    }

    /**
     * Register custom Elementor widgets.
     */
    public function register_widgets()
    {
        // Include and register each widget file.
        require_once(plugin_dir_path(__FILE__) . 'widgets/custom-widget.php'); // Example file name
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Custom_Slideshow_Widget());
    }
}

