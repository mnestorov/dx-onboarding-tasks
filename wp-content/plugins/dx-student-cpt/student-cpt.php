<?php
/**
 * Student CTP
 *
 * @package           StudentCTP
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Student CTP
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/student-ctp
 * Description:       Learning how to create a custom post type, custom taxonomies, widgets and sidebars.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Martin Nestorov
 * Author URI:        https://github.com/mnestorov
 * Text Domain:       studentcpt
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/student-ctp
 */

/*
Student CTP is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Student CTP is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Student CTP. If not, see {URI to Plugin License}.
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
if ( ! defined( 'SCPT_URL_PATH' ) ) {
	define( 'SCPT_URL_PATH', plugin_dir_url( __FILE__ ) );
}

// Include the bootstrap (master) class.
require_once 'includes/classes/class-bootstrap.php';

// Instantiate the bootstrap (master) class.
$bootstrap = new \Student_Cpt\Bootstrap();
