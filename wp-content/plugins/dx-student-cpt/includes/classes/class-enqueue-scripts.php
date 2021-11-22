<?php

if ( ! class_exists( 'EnqueueScripts' ) ) {
	/**
	 * Class EnqueueScripts
	 *
	 * @package    StudentCTP
	 * @author     Martin Nestorov
	 */
	class EnqueueScripts {
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'dx_enqueue_scripts' ) );
		}

		/**
		 * Enqueue scripts for the child theme
		 *
		 * @param $hook
		 */
		public function dx_enqueue_scripts() {
			wp_enqueue_script( 'dx_enabled_filters_script', SCPT_URL_PATH . './includes/assets/js/filter.js', array( 'jquery' ) );
			wp_localize_script(
				'dx_enabled_filters_script',
				'dx_enabled_filters_object',
				array(
					'dx_enabled_filters_url' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
	}
}
