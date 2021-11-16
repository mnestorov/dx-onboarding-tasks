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
if ( ! defined( 'MOP_DIR_PATH' ) ) {
	define( 'MOP_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! class_exists( 'MOP_Init' ) ) {
	/**
	 * Class MOP_Init
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MOP_Init {

		/**
		 * Registering all classes that power the plugin.
		 */
		protected $loader;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'mop_include_classes' ), 10 );
			add_action( 'plugins_loaded', array( $this, 'mop_setup_actions' ), 10 );
			add_action( 'init', array( $this, 'mop_load_dependencies' ), 0 );
		}

		/**
		 * This function includes all the classes/traits on the plugins_loaded with priority
		 * 10 in order to be easily overwritten.
		 */
		public function mop_include_classes() {
			// Include the classes.
			require_once MOP_DIR_PATH . 'includes/admin/class-mop-plugin-settings.php';
			require_once MOP_DIR_PATH . 'includes/admin/class-mop-scripts.php';
			require_once MOP_DIR_PATH . 'includes/admin/class-mop-cpt.php';
			require_once MOP_DIR_PATH . 'includes/front/class-mop-insert.php';
		}

		/**
		 * Load dependencies classes
		 */
		public function mop_load_dependencies() {
			$this->loader = new MOP_Cpt();
			$this->loader = new MOP_Scripts();
			$this->loader = new MOP_Insert();
			$this->loader = new MOP_PluginSettings();
		}

		/**
		 * Setting up Hooks
		 */
		public function mop_setup_actions() {
			register_activation_hook( MOP_DIR_PATH, array( $this, 'mop_activate' ) );
			register_deactivation_hook( MOP_DIR_PATH, array( $this, 'mop_deactivate' ) );
		}

		/**
		 * Activate callback
		 */
		public static function mop_activate() {
			// Activation code in here.
		}

		/**
		 * Deactivate callback
		 */
		public static function mop_deactivate() {
			// Deactivation code in here.
		}
	}

	new MOP_Init();
}
