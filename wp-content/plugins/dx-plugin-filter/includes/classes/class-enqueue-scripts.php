<?php

if ( ! class_exists( 'EnqueueScripts' ) ) {
	/**
	 * Class EnqueueScripts
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345383459199/f
	 *
	 * @package    MyPluginFilter
	 * @author     Martin Nestorov
	 */
	class EnqueueScripts {
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
			wp_enqueue_script( 'dx_enabled_filters_script', MPF_PATH . './includes/assets/js/main.js', array( 'jquery' ) );
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
