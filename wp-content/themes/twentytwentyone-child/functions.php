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

if ( ! function_exists( 'twentytwentyone_child_scripts' ) ) {
	/**
	 *  Enqueue scripts for the child theme
	 */
	function twentytwentyone_child_scripts() {
		global $wp_query;

		// Register script but don't enqueue it yet.
		wp_register_script( 'child-loadmore', get_stylesheet_directory_uri() . '/assets/js/loadmore.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'child-loadmore' );

		wp_localize_script(
			'child-loadmore',
			'loadmore_params',
			array(
				'ajaxurl'      => site_url() . '/wp-admin/admin-ajax.php', // WP AJAX.
				'posts'        => wp_json_encode( $wp_query->query_vars ),    // Loop is here.
				'current_page' => get_query_var( 'paged' ) ?? 1,
				'max_page'     => $wp_query->max_num_pages,
			)
		);

		wp_register_style( 'child-main', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), false, 'all' );
		wp_enqueue_style( 'child-main' );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_scripts' );

if ( ! function_exists( 'twentytwentyone_child_loadmore_ajax_handler' ) ) {
	/**
	 *  Load More ajax handler
	 */
	function twentytwentyone_child_loadmore_ajax_handler() {

		$args                = json_decode( stripslashes( $_POST['query'] ), true );
		$args['paged']       = $_POST['page'] + 1; // Loading next page.
		$args['post_status'] = 'publish';

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
			}
		}

		die;
	}
}

add_action( 'wp_ajax_loadmore', 'twentytwentyone_child_loadmore_ajax_handler' );
add_action( 'wp_ajax_nopriv_loadmore', 'twentytwentyone_child_loadmore_ajax_handler' );

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
