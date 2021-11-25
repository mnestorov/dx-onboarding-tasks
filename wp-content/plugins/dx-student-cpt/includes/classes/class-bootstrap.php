<?php

namespace StudentCpt {

	/**
	 * A class for managing plugin dependencies and loading the plugin.
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class Bootstrap {

		/**
		 * Registering all classes that power the plugin
		 */
		protected $loader;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'dx_include' ), 10 );
			add_action( 'init', array( $this, 'dx_run' ), 0 );
			add_action('rest_api_init', array( $this, 'init_wp_rest_multiple_post_type_endpoint' ) );
		}

		public function init_wp_rest_multiple_post_type_endpoint()
		{
			$controller = new \WpRestMultiplePostTypeController();
			$controller->register_routes();
		}

		/**
		 * Includes all the plugin classes with priority
		 */
		public function dx_include() {
			// Include the classes.
			require_once 'class-student-cpt.php';
			require_once 'class-student-sidebar.php';
			require_once 'class-student-widget.php';
			require_once 'class-student-rest-api.php';
			require_once 'class-enqueue-scripts.php';
			require_once 'class-plugin-filter.php';
			require_once 'class-loadmore.php';
			require_once 'class-wp-rest-multipleposttype-controller.php';
		}

		/**
		 * Instantiate our plugin classes
		 */
		public function dx_run() {
			$this->loader = new \StudentCPT();
			$this->loader = new \StudentSidebar();
			$this->loader = new \StudentWidget();
			$this->loader = new \StudentRestApi();
			$this->loader = new \EnqueueScripts();
			$this->loader = new \PluginFilter();
			$this->loader = new \Loadmore();
		}
	}
}