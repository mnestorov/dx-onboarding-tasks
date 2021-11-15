<?php

if ( ! class_exists( 'MOP_Scripts' ) ) {
	/**
	 * Class MOP_Scripts
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MOP_Scripts {

		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'mop_enqueue_scripts' ) );
		}

		/**
		 * Enqueue scripts for the child theme
		 *
		 * @param $hook
		 */
		public function mop_enqueue_scripts( $hook ) {

			if ( 'my-onboarding-plugin.php' !== $hook ) {
				return;
			}

			wp_enqueue_script( 'ajax-script', plugins_url( '/assets/js/main.js', __FILE__ ), array( 'jquery' ), false, true );
		}
	}
}