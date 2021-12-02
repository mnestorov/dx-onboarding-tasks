<?php

if ( ! class_exists( 'Enqueue_Scripts' ) ) {
	/**
	 * Class Enqueue_Scripts
	 *
	 * @package    StudentCTP
	 * @author     Martin Nestorov
	 */
	class Enqueue_Scripts {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'dx_enqueue_scripts' ) );
		}

		/**
		 * Enqueue scripts for the child theme
		 *
		 * @return void
		 */
		public function dx_enqueue_scripts() {
			wp_enqueue_script( 'dx_enabled_filters_script', SCPT_URL_PATH . './includes/assets/js/filter.js', array( 'jquery' ), false, true );
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
