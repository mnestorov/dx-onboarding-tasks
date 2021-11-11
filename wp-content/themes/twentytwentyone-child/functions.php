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
		wp_register_script( 'loadmore', get_stylesheet_directory_uri() . '/assets/js/loadmore.js', array( 'jquery' ), false, true );

		wp_localize_script(
			'loadmore',
			'loadmore_params',
			array(
				'ajaxurl'       => site_url() . '/wp-admin/admin-ajax.php', // WP AJAX.
				'posts'         => json_encode( $wp_query->query_vars ), // Loop is here.
				'current_page'  => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
				'max_page'      => $wp_query->max_num_pages,
			)
		);

		wp_enqueue_script( 'loadmore' );
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
