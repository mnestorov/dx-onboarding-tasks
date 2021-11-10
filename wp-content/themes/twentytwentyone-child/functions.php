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
		wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), false, true );
	}
}

add_action( 'wp_enqueue_scripts', 'twentytwentyone_child_scripts' );

/**
 * Initial posts dispaly
 */
function twentytwentyone_child_load_more( $args = array() ) {
	// initial posts load.
	echo '<div id="ajax-primary" class="entry-content">';
		echo '<div id="ajax-content" class="entry-content">';
			twentytwentyone_child_ajax_script_load_more( $args );
		echo '</div>';
		echo '<a href="#" class="aligncenter" id="loadMore"  data-page="1" data-url="' . admin_url( "admin-ajax.php" ) . '" >Load More</a>';
	echo '</div>';
}

/**
 * Create a short code
 */
add_shortcode( 'ajax_posts', 'twentytwentyone_child_load_more' );

/**
 * Load more script call back
 */
function twentytwentyone_child_ajax_script_load_more( $args ) {
	// Init ajax.
	$ajax = false;

	// Check ajax call.
	if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$ajax = true;
	}

	// Number of posts per page default.
	$num = 2;

	// Page number.
	$paged = null;

	if ( isset( $_POST['page'] ) ) {
		$paged = $_POST['page'] + 1;
	}

	// Args array.
	$args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $num,
		'paged'          => $paged,
	);

	// WP Query.
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
				$query->the_post();
			include 'ajax-content.php';
		}
	} else {
		echo 0;
	}

	// Reset post data.
	wp_reset_postdata();

	// Check ajax call.
	if ( $ajax ) {
		die();
	}
}

/**
 * Load more script ajax hooks
 */
add_action( 'wp_ajax_nopriv_ajax_script_load_more', 'twentytwentyone_child_ajax_script_load_more' );
add_action( 'wp_ajax_ajax_script_load_more', 'twentytwentyone_child_ajax_script_load_more' );
