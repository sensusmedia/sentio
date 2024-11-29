<?php
/**
 * Plugin Name: Sentio Addons for Elementor
 * Description: Elementor sample plugin.
 * Plugin URI:  https://sentiothemes.com/
 * Version:     1.2.0
 * Author:      Sensus Media
 * Author URI:  https://sentiothemes.com/
 * Text Domain: sentio-addons
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Sentio_Addon
 *
 * The init class that runs the Sentio Addon plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Sentio_Addon {

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.2.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'sentio-addons' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'sentio-addons' ),
			'<strong>' . esc_html__( 'Sentio Addons', 'sentio-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'sentio-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sentio-addons' ),
			'<strong>' . esc_html__( 'Sentio Addons', 'sentio-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'sentio-addons' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'sentio-addons' ),
			'<strong>' . esc_html__( 'Sentio Addons', 'sentio-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'sentio-addons' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Sentio_Addon.
new Sentio_Addon();

// Define MICEMADE_ELEMENTS_PLUGIN_FILE.
if ( ! defined( 'MICEMADE_ELEMENTS_PLUGIN_FILE' ) ) {
	define( 'MICEMADE_ELEMENTS_PLUGIN_FILE', __FILE__ );
}

// Define plugin dir path.
if ( ! defined( 'MICEMADE_ELEMENTS_DIR' ) ) {
	define( 'MICEMADE_ELEMENTS_DIR', plugin_dir_path( __FILE__ ) );
}

// Define plugin url.
if ( ! defined( 'MICEMADE_ELEMENTS_URL' ) ) {
	define( 'MICEMADE_ELEMENTS_URL', plugin_dir_url( __FILE__ ) );
}



		require MICEMADE_ELEMENTS_DIR . '/includes/Parsedown.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/admin.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/ajax_posts.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/helpers.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/wc-functions.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/instagram.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/class-micemade-nav-html.php';
		require MICEMADE_ELEMENTS_DIR . '/includes/plugins.php';

	

