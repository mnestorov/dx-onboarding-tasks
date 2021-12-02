<?php

namespace MyOnboardingPlugin {

	/**
	 * A class for managing plugin dependencies and loading the plugin.
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
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
			add_action( 'plugins_loaded', array( $this, 'dx_include' ), 10 );
			add_action( 'init', array( $this, 'dx_run' ), 0 );
		}

		/**
		 * Includes all the plugin classes with priority.
		 *
		 * @return void
		 */
		public function dx_include() {
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
		public function dx_run() {
			$this->loader = new \EnqueueScripts();
			$this->loader = new \InsertContent();
			$this->loader = new \PluginFilter();
		}
	}
}
