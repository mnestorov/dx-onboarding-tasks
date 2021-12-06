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
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Enqueue scripts for the child theme
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'enabled_filters_script', SCPT_URL_PATH . './includes/assets/js/filter.js', array( 'jquery' ), false, true );
			wp_localize_script(
				'enabled_filters_script',
				'enabled_filters_object',
				array(
					'enabled_filters_url' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
	}
}
