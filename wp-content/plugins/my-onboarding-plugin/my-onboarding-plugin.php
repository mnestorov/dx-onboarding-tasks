<?php
/**
 * My Onboarding Plugin
 *
 * @package           MyOnboardingPlugin
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Onboarding Plugin
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-onboarding-plugin
 * Description:       Learning how to create a plugin, OOP way.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Martin Nestorov
 * Author URI:        https://github.com/mnestorov
 * Text Domain:       mop
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-onboarding-plugin
 */

/*
My Onboarding Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

My Onboarding Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with My Onboarding Plugin. If not, see {URI to Plugin License}.
*/

/**
 * If this file is called directly, then abort execution
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define DIR_PATH constant for hooks
 */
define( 'MOP_DIR_PATH', plugin_dir_path( __FILE__ ) );

if ( ! class_exists( 'MyOnboardingPlugin' ) ) {
	/**
	 * Class MyOnboardingPlugin
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MyOnboardingPlugin {

		protected $id = array( 1, 2 );

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'setup_actions' ) );
			add_filter( 'the_content', array( $this, 'isert_before_content' ) );
			add_filter( 'the_content', array( $this, 'insert_after_content' ) );
			add_filter( 'the_content', array( $this, 'insert_after_last_div' ), 20 );
		}

		/**
		 * Setting up Hooks
		 */
		public function setup_actions() {
			register_activation_hook( MOP_DIR_PATH, array( 'MyOnboardingPlugin', 'activate' ) );
			register_deactivation_hook( MOP_DIR_PATH, array( 'MyOnboardingPlugin', 'deactivate' ) );
		}

		/**
		 * Activate callback
		 */
		public static function activate() {
			// Activation code in here.
		}

		/**
		 * Deactivate callback
		 */
		public static function deactivate() {
			// Deactivation code in here.
		}

		/**
		 * Insert before content
		 */
		public function isert_before_content( $content ) {
			$before_content = 'Onboarding Filter: ';
			$user_name = 'Martin Nestorov';

			if ( is_single() ) {
				$content = '<p style="text-align:center;">' . $before_content . $user_name . '</p>' . $content;
			}

			return $content;
		}

		/**
		 * Insert after content
		 */
		public function insert_after_content( $content ) {
			$after_content = '<div id="' . $this->id[0] . '"></div>';

			if ( is_single() ) {
				$content = $content . $after_content;
			}

			return $content;
		}

		/**
		 * Insert after last div
		 */
		public function insert_after_last_div( $content ) {
			$after_last_div = '<div id="' . $this->id[1] . '"></div>';

			if ( is_single() ) {
				$content = $content . $after_last_div;
			}

			return $content;
		}
	}

	// Instantiate the plugin class.
	$wp_plugin_template = new MyOnboardingPlugin();
}
