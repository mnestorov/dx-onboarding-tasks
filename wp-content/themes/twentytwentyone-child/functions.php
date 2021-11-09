<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 * @package WordPress
 */

/**
 *  Enqueue scripts and style from parent theme
 */
function twentytwentyone_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), false, false, 'all' );
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_styles' );
