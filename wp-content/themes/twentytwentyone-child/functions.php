<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 * @package WordPress
 */

if ( ! function_exists( 'twentytwentyone_child_styles' ) ) {
	/**
	 *  Enqueue scripts and style from parent theme
	 */
	function twentytwentyone_child_styles() {
		// Adding the child theme style.
		wp_enqueue_style( 'child-style', get_stylesheet_uri(), false, false, 'all' );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_styles' );
