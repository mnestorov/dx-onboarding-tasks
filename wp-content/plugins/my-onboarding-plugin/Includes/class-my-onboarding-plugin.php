<?php

if ( ! class_exists( 'MyOnboardingPlugin' ) ) {
	/**
	 * Class MyOnboardingPlugin
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MyOnboardingPlugin {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'setup_actions' ) );
			add_filter( 'the_content', array( $this, 'show_inserted' ) );
		}

		/**
		 * Setting up Hooks
		 */
		public function setup_actions() {
			register_activation_hook( MOP_DIR_PATH, array( 'MyOnboardingPlugin', 'activate' ) );
			register_deactivation_hook( MOP_DIR_PATH, array( 'MyOnboardingPlugin', 'deactivate' ) );
		}

		/**
		 * Activate callback
		 */
		public static function activate() {
			// Activation code in here.
		}

		/**
		 * Deactivate callback
		 */
		public static function deactivate() {
			// Deactivation code in here.
		}

		/**
		 * Show inserted custom content
		 */
		public function show_inserted( $content ) {
			$wp_insert_content = new InsertContent();
			$content = $wp_insert_content->insert_before_content( $content );
			return $content;
		}
	}

	// Instantiate the plugin class.
	$wp_plugin_template = new MyOnboardingPlugin();
}
