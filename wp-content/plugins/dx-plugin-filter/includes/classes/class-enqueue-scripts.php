<?php

if ( ! class_exists( 'Enqueue_Scripts' ) ) {
	/**
	 * Class Enqueue_Scripts
	 *
	 * @package    MyPluginFilter
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
			wp_enqueue_script( 'enabled_filters_script', MPF_PATH . './includes/assets/js/main.js', array( 'jquery' ) );
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
