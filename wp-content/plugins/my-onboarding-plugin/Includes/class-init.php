<?php

if ( ! class_exists( 'Init' ) ) {
	/**
	 * Class Init
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class Init {

		/**
		 * Registering all classes that power the plugin.
		 */
		protected $loader;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'setup_actions' ) );
			$this->load_dependencies();
		}

		/**
		 * Setting up Hooks
		 */
		public function setup_actions() {
			register_activation_hook( MOP_DIR_PATH, array( $this, 'activate' ) );
			register_deactivation_hook( MOP_DIR_PATH, array( $this, 'deactivate' ) );
		}

		private function load_dependencies() {
			$this->loader = new Insert();
			$this->loader = new AdminMenu();
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
	}
}
