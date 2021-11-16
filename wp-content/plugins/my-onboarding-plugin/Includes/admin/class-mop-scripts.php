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
		public function mop_enqueue_scripts() {
			wp_enqueue_script( 'mop_enabled_filters_script', plugins_url( '../../assets/js/main.js', __FILE__ ), array( 'jquery' ) );

			wp_localize_script(
				'mop_enabled_filters_script',
				'mop_enabled_filters_object',
				array(
					'mop_enabled_filters_url' => admin_url( 'admin-ajax.php' ),
					'mop_is_checked'          => get_option( 'mop_is_checked' ),
				)
			);
		}
	}
}
