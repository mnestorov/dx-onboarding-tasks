<?php
/**
 * Managing plugin dependencies and loading the plugin.
 *
 * @package DisplayRemoteUrls
 * @author  Martin Nestorov
 */

namespace Display_Remote_Urls {

	/**
	 * Loading all dependencies
	 */
	class Bootstrap {

		/**
		 * Registering all classes that power the plugin
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
		 * Includes all the plugin classes with priority
		 *
		 * @return void
		 */
		public function include() {
			// Include the classes.
			require_once 'class-display-remote-urls.php';
		}

		/**
		 * Instantiate our plugin classes
		 *
		 * @return void
		 */
		public function run() {
			$this->loader = new \Display_Remote_Urls();
		}
	}
}
