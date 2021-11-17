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
 * Text Domain:       myonboardingplugin
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
 * Define path constant for plugin hooks
 */
if ( ! defined( 'MOP_PATH' ) ) {
	define( 'MOP_PATH', plugin_dir_url( __FILE__ ) );
}

// Include the bootstrap (master) class.
require_once 'includes/classes/class-bootstrap.php';

// Initiate the bootstrap (master) class.
$bootstrap = new MOP_Bootstrap();
