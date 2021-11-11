<?php
/**
 * Plugin Name
 *
 * @package           MyOnboardingPlugin
 * @author            Martin Nestorov
 * @copyright         2021 Martin Nestorov @ DevriX
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       My Onboarding Plugin
 * Plugin URI:        https://github.com/mnestorov/wordpress/wp-content/plugins/my-onboarding-plugin
 * Description:       Learning how to create a plugin.
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
 * Register the "book" custom post type
 */
function mop_setup_post_type() {
	register_post_type( 'book', array( 'public' => true ) );
}

add_action( 'init', 'mop_setup_post_type' );

/**
 * Activation hook (activate the plugin)
 */
function mop_activate() {
	// Trigger our function that registers the custom post type plugin.
	mop_setup_post_type();
	// Clear the permalinks after the post type has been registered.
	flush_rewrite_rules();
}

/**
 * Deactivation hook (deactivate the plugin)
 */
function mop_deactivate() {
	// Unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'book' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'mop_deactivate' );
