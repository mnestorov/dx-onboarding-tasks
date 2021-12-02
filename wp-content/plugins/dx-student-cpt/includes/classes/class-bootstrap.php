<?php
/**
 * Managing plugin dependencies and loading the plugin.
 *
 * @package StudentCTP
 * @author  Martin Nestorov
 */

namespace Student_Cpt {

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
			add_action( 'plugins_loaded', array( $this, 'dx_include' ), 10 );
			add_action( 'init', array( $this, 'dx_run' ), 0 );
			add_action( 'rest_api_init', array( $this, 'init_wp_rest_multiple_post_type_endpoint' ) );
		}

		/**
		 * Custom class for querying for multiple post-types - FOR TEST ONLY!
		 *
		 * @return void
		 */
		public function init_wp_rest_multiple_post_type_endpoint() {
			$controller = new \Wp_Rest_MultiplePostType_Controller();
			$controller->register_routes();
		}

		/**
		 * Includes all the plugin classes with priority
		 *
		 * @return void
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
		 *
		 * @return void
		 */
		public function dx_run() {
			$this->loader = new \Student_CPT();
			$this->loader = new \Student_Sidebar();
			$this->loader = new \Student_Widget();
			$this->loader = new \Student_Rest_Api();
			$this->loader = new \Enqueue_Scripts();
			$this->loader = new \Plugin_Filter();
			$this->loader = new \Loadmore();
		}
	}
}
