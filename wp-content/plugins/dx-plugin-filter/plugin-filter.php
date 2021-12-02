<?php
/**
 * My Plugin Filter
 *
 * @package           MyPluginFilter
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Plugin Filter
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-plugin-filter
 * Description:       Learning how to update plugin options with ajax.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Martin Nestorov
 * Author URI:        https://github.com/mnestorov
 * Text Domain:       mypluginfilter
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-plugin-filter
 */

/*
My Plugin Filter is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
My Plugin Filter is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with My Plugin Filter. If not, see {URI to Plugin License}.
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
if ( ! defined( 'MPF_PATH' ) ) {
	define( 'MPF_PATH', plugin_dir_url( __FILE__ ) );
}

// Include the bootstrap (master) class.
require_once 'includes/classes/class-bootstrap.php';

// Instantiate the bootstrap (master) class.
$bootstrap = new \My_Plugin_Filter\Bootstrap();
