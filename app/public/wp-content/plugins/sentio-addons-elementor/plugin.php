<?php
namespace SentioAddon;

/**
* Class Plugin
*
* Main Plugin class
* @since 1.2.0
*/
class Plugin {

/**
* Instance
*
* @since 1.2.0
* @access private
* @static
*
* @var Plugin The single instance of the class.
*/
private static $_instance = null;

/**
* Instance
*
* Ensures only one instance of the class is loaded or can be loaded.
*
* @since 1.2.0
* @access public
*
* @return Plugin An instance of the class.
*/
public static function instance() {
	if ( is_null( self::$_instance ) ) {
		self::$_instance = new self();
	}
	return self::$_instance;
}

/**
* widget_styles
*
* Load required plugin core files.
*
* @since 1.2.0
* @access public
*/
public function widget_styles() {

	wp_register_style( 'widget-1', plugins_url( '/assets/css/swiper.css', __FILE__ ) );
	wp_enqueue_style( 'widget-1', plugins_url( '/assets/css/swiper.css', __FILE__ ), false, true );
	wp_register_style( 'widget-2', plugins_url( '/assets/css/sentio-frontend.css', __FILE__ ) );
	wp_enqueue_style( 'widget-2', plugins_url( '/assets/css/sentio-frontend.css', __FILE__ ), false, true );

}

/**
* widget_scripts
*
* Load required plugin core files.
*
* @since 1.2.0
* @access public
*/
public function widget_scripts() {
	wp_register_script( 'sentio-addons-swiper', plugins_url( '/assets/js/swiper.js', __FILE__ ), [ 'jquery' ], false, true );
	wp_enqueue_script( 'sentio-addons-swiper', plugins_url( '/assets/js/swiper.js', __FILE__ ), [ 'jquery' ], 0, false, true );
	wp_register_script( 'sentio-frontend', plugins_url( '/assets/js/sentio-frontend.js', __FILE__ ), [ 'jquery' ], false, true );
	wp_enqueue_script( 'sentio-frontend', plugins_url( '/assets/js/sentio-frontend.js', __FILE__ ), [ 'jquery' ], false, true );

			$ajaxurl = '';
		if ( MICEMADE_ELEMENTS_WPML_ON ) {
			$ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
		} else {
			$ajaxurl .= admin_url( 'admin-ajax.php' );
		}

		wp_localize_script(
			'sentio-frontend',
			'sentioJsLocalize',
			array(
				'ajaxurl'      => esc_url( $ajaxurl ),
				'loadingposts' => esc_html__( 'Loading ...', 'micemade-elements' ),
				'noposts'      => esc_html__( 'No more items found', 'micemade-elements' ),
				'loadmore'     => esc_html__( 'Load more', 'micemade-elements' ),
			)
		);

}

/**
* Include Widgets files
*
* Load widgets files
*
* @since 1.2.0
* @access private
*/
private function include_widgets_files() {
	require_once( __DIR__ . '/widgets/sentio-slides.php' );
	require_once( __DIR__ . '/widgets/sentio-posts.php' );
	require_once( __DIR__ . '/widgets/sentio-testimonial.php' );
	require_once( __DIR__ . '/widgets/sentio-team.php' );
	require_once( __DIR__ . '/widgets/sentio-pricing.php' );
}

/**
* Register Widgets
*
* Register new Elementor widgets.
*
* @since 1.2.0
* @access public
*/
public function register_widgets() {
// Its is now safe to include Widgets files
	$this->include_widgets_files();

// Register Widgets
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sentio_Slides() );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sentio_Posts() );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sentio_Testimonial() );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sentio_Team() );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Sentio_Pricing() );
}

/**
* Add elementor category
*
* @since v1.0.0
*/
public function add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'sentio-addon',
		[
			'title' => __( 'Sentio Addons', 'sentio-addons' ),
			'icon' => 'fa fa-plug',
		],
		1
	);
}

/**
*  Plugin class constructor
*
* Register plugin action hooks and filters
*
* @since 1.2.0
* @access public
*/
public function __construct() {

// Register widget scripts
	add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

// Register Widget Styles
	add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

// Register widgets
	add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

// Register categories
	add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] ) ;
}


}

// Instantiate Plugin Class
Plugin::instance();
