<?php

if ( ! class_exists( 'Enqueue_Scripts' ) ) {
	/**
	 * Class Enqueue_Scripts
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345383459199/f
	 *
	 * @package    MyOnboardingPlugin
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
			wp_enqueue_script( 'dx_enabled_filters_script', MOP_PATH . './includes/assets/js/main.js', array( 'jquery' ) );
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
