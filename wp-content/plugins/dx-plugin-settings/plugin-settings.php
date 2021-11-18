<?php
/**
 * My Plugin Settings
 *
 * @package           MyPluginSettings
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Plugin Settings
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-plugin-settings
 * Description:       Learning how to create a plugin settings page in wp admin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Martin Nestorov
 * Author URI:        https://github.com/mnestorov
 * Text Domain:       mypluginsettings
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-plugin-settings
 */

/*
My Plugin Settings is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
My Plugin Settings is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with My Plugin Settings. If not, see {URI to Plugin License}.
*/

/**
 * If this file is called directly, then abort execution
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the bootstrap (master) class.
require_once 'includes/classes/class-bootstrap.php';

// Instantiate the bootstrap (master) class.
$bootstrap = new \MyPluginSettings\Bootstrap();
