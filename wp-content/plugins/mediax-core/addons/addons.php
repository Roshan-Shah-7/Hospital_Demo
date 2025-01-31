<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Mediax Core Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */

final class Mediax_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';


	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */

	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}


		// Add Plugin actions

		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );


        // Register widget scripts

		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ]);


		// Specific Register widget scripts

		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'mediax_regsiter_widget_scripts' ] );
		// add_action( 'elementor/frontend/before_register_scripts', [ $this, 'mediax_regsiter_widget_scripts' ] );


        // category register

		add_action( 'elementor/elements/categories_registered',[ $this, 'mediax_elementor_widget_categories' ] );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'mediax' ),
			'<strong>' . esc_html__( 'Mediax Core', 'mediax' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'mediax' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */

			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'mediax' ),
			'<strong>' . esc_html__( 'Mediax Core', 'mediax' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'mediax' ) . '</strong>',
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
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(

			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'mediax' ),
			'<strong>' . esc_html__( 'Mediax Core', 'mediax' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'mediax' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	public function init_widgets() {

		$widget_register = \Elementor\Plugin::instance()->widgets_manager;

		// Header Include file & Widget Register
		require_once( MEDIAX_ADDONS . '/header/header.php' );

		$widget_register->register ( new \Mediax_Header() );


		// Include All Widget Files
		foreach($this->Mediax_Include_File() as $widget_file_name){
			require_once( MEDIAX_ADDONS . '/widgets/mediax-'."$widget_file_name".'.php' );
		}
		// All Widget Register
		foreach($this->Mediax_Register_File() as $name){
			$widget_register->register ( $name );
		}
		
	}

	public function Mediax_Include_File(){
		return [
			'banner', 
			'banner2', 
			'section-title', 
			'button', 
			'blog', 
			'service', 
			'testimonial', 
			'team', 
			'team-info', 
			'image', 
			'contact-info', 
			'contact-form', 
			'counterup', 
			'faq', 
			'brand-logo', 
			'cta', 
			'gallery', 
			'info-box', 
			'service-list', 
			'product',
			'product2',
			'product-filter',
			'newsletter', 
			'menu-select', 
			'offer-card', 
			'category', 

			'social',
			'gallery-filter', 
			'animated-shape', 
			'arrows', 
			'tab-builder', 
			'skill', 
			'step', 
			'features', 
			'video', 
			'price',
			'download',
			'features-v2',
			'banner3',
			'banner4',
			'work-process',
			'sliding-text',
		];
	}

	public function Mediax_Register_File(){
		return [
			new \Mediax_Banner() ,
			new \Mediax_Banner2() ,
			new \Mediax_Section_Title(),
			new \Mediax_Button(),
			new \Mediax_Blog(),
			new \Mediax_Service(),
			new \Mediax_Testimonial(),
			new \Mediax_Team(),
			new \Mediax_Team_info(),
			new \Mediax_Image(),
			new \Mediax_Contact_Info(),
			new \Mediax_Contact_Form(),
			new \Mediax_Counterup(),
			new \Mediax_Faq(),
			new \Mediax_Brand_Logo(),
			new \Mediax_Cta(),
			new \Mediax_Gallery(),
			new \Mediax_Info_Box(),
			new \mediax_Service_List(),
			new \Mediax_Product(),
			new \Mediax_Product2(),
			new \Mediax_Product_Filter(),
			new \mediax_Newsletter(),
			new \Mediax_Menu(),
			new \Mediax_Offer_Card(),
			new \Mediax_Category(),

			new \Mediax_Social(),
			new \Mediax_Gallery_Filter(),
			new \Mediax_Animated_Shape(),
			new \Mediax_Arrows(),
			new \Mediax_Tab_Builder(),
			new \mediax_Skill(),
			new \mediax_Step(),
			new \Mediax_Features(),
			new \mediax_Video(),
			new \Mediax_Price(),
			new \Mediax_Download(),
			new \Mediax_Features_V2(),
			new \mediax_Banner3(),
			new \mediax_Banner4(),
			new \Mediax_WorkProcess(),
			new \mediax_Sliding_Text(),
		];
	}

    public function widget_scripts() {

        // wp_enqueue_script(
        //     'mediax-frontend-script',
        //     MEDIAX_PLUGDIRURI . 'assets/js/mediax-frontend.js',
        //     array('jquery'),
        //     false,
        //     true
		// );

	}


    function mediax_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'mediax',
            [
                'title' => __( 'Mediax', 'mediax' ),
                'icon' 	=> 'fa fa-plug',
            ]
        );

        $elements_manager->add_category(
            'mediax_footer_elements',
            [
                'title' => __( 'Mediax Footer Elements', 'mediax' ),
                'icon' 	=> 'fa fa-plug',
            ]
		);

		$elements_manager->add_category(
            'mediax_header_elements',
            [
                'title' => __( 'Mediax Header Elements', 'mediax' ),
                'icon' 	=> 'fa fa-plug',
            ]
        );
	}
}

Mediax_Extension::instance();