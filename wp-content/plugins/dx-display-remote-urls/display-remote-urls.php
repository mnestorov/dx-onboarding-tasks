<?php
/**
 * Display Remote Urls
 *
 * @package           DisplayRemoteUrls
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Display Remote Urls
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/display-remote-urls
 * Description:       This plugin provide an options to add and fetch/display html data form any site link to the plugin admin page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Martin Nestorov
 * Author URI:        https://github.com/mnestorov
 * Text Domain:       displayremoteurls
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/display-remote-urls
 */

/*
Display Remote Urls Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Display Remote Urls is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Display Remote Urls Plugin. If not, see {URI to Plugin License}.
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
if ( ! defined( 'DR_URL_PATH' ) ) {
	define( 'DR_URL_PATH', plugin_dir_url( __FILE__ ) );
}

/**
 * A slug for our plugin
 */
if ( ! defined( 'DR_URL_SLUG' ) ) {
	define( 'DR_URL_SLUG', 'displayremoteurls' );
}

// Include the bootstrap (master) class.
require_once 'includes/classes/class-bootstrap.php';

// Initiate the bootstrap (master) class.
$bootstrap = new DRURL_Bootstrap();
