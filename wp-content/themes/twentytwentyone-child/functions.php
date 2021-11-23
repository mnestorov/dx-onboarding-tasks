<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 * @package WordPress
 */

if ( ! function_exists( 'twentytwentyone_child_styles' ) ) {
	/**
	 *  Enqueue styles for the child theme
	 */
	function twentytwentyone_child_styles() {
		// Adding the child theme style.
		wp_enqueue_style( 'child-style', get_stylesheet_uri(), false, false, 'all' );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_styles' );

if ( ! function_exists( 'twentytwentyone_child_nav_menu_args' ) ) {
	/**
	 *  Display different menus to logged-in users
	 */
	function twentytwentyone_child_nav_menu_args( $args = '' ) {

		if ( is_user_logged_in() ) {
			$args['menu'] = 'Logged-In';
		} else {
			$args['menu'] = 'Primary Menu';
		}

		return $args;
	}

	add_filter( 'wp_nav_menu_args', 'twentytwentyone_child_nav_menu_args' );
}

if ( ! function_exists( 'twentytwentyone_child_user_profile_update' ) ) {
	/**
	 * Send email to admin if user updated his profile
	 */
	function twentytwentyone_child_user_profile_update( $user_id ) {

		$user_info = get_userdata( $user_id );

		$to       = get_option( 'admin_email' );
		$subject  = 'User Profile Updated';
		$message  = "Hello Administrator,\n\nThe " . $user_info->user_nicename . " (" . $user_info->user_email . ") profile has been updated! \n\n";
		$message .= "Site URL: " . get_bloginfo( 'wpurl' ) . "\n\n";
		$message .= "Regards, \n" . get_option( 'blogname' );

		wp_mail( $to, $subject, $message );
	}
}

add_action( 'profile_update', 'twentytwentyone_child_user_profile_update', 10, 2 );

/**
 *  TESTING :: email testing on local enviroment
 */
function mailtrap( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host 	 = 'smtp.mailtrap.io';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port 	 = 2525;
	$phpmailer->Username = '68b2c86d96e500';
	$phpmailer->Password = '79bcdfccbde0b5';
}

add_action( 'phpmailer_init', 'mailtrap' );
