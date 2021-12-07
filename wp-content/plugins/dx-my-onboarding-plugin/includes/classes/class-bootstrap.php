<?php
/**
 * Managing plugin dependencies and loading the plugin.
 *
 * @package MyOnboardingPlugin
 * @author  Martin Nestorov
 */

namespace My_Onboarding_Plugin {

	/**
	 * Loading all dependencies
	 */
	class Bootstrap {

		/**
		 * Registering all classes that power the plugin.
		 *
		 * @var object
		 */
		protected $loader;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'include' ), 10 );
			add_action( 'init', array( $this, 'run' ), 0 );
		}

		/**
		 * Includes all the plugin classes with priority.
		 *
		 * @return void
		 */
		public function include() {
			// Include the classes.
			require_once 'class-enqueue-scripts.php';
			require_once 'class-insert-content.php';
			require_once 'class-plugin-filter.php';
		}

		/**
		 * Instantiate our plugin classes.
		 *
		 * @return void
		 */
		public function run() {
			$this->loader = new \Enqueue_Scripts();
			$this->loader = new \Insert_Content();
			$this->loader = new \Plugin_Filter();
		}
	}
}
