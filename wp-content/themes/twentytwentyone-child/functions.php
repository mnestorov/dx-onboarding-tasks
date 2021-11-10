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
		// Extending the 'twentytwentyone-style' for the Twenty Twenty One theme.
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', false, wp_get_theme()->parent()->get( 'Version' ) );
		// Adding the child theme style.
		wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ), false, 'all' );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_styles' );
