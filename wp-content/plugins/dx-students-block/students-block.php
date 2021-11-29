<?php
/**
 * Plugin Name: Show Students
 * Plugin URI: https://github.com/WordPress/gutenberg-examples
 * Description: This is a plugin demonstrating how to register new blocks for the Gutenberg editor.
 * Requires at least: 5.8
 * Requires PHP: 7.0
 * Version: 1.0.0
 * Author: the Gutenberg Team
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: students-block
 *
 * @package gutenberg-block
 */

/**
 * If this file is called directly, then abort execution
 */
defined( 'ABSPATH' ) || exit;


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
function dx_students_block_init() {
	register_block_type( __DIR__, array( 'render_callback', 'dx_gb_load_students_settings' ) );
}

add_action( 'init', 'dx_students_block_init' );

/**
 * Load students with settings inside the Gutenberg Block.
 */
function dx_gb_load_students_settings( $block_attributes ) {
	$args = array(
		'post_type'      => 'student',
		'posts_per_page' => $block_attributes['studentsPerPage'],
		'paged'          => true,
		'meta_key'       => 'student_active',
		'meta_value'     => $block_attributes['studentStatus'],
	);

	$get_query = new \WP_Query( $args );

	$html_content = '<p>';
	while ( $get_query->have_posts() ) {
		$get_query->the_post();
		$html_content = $html_content . '[student student_id=' . get_the_ID() . ']';
	}
	$html_content = do_shortcode( $html_content );
	return $html_content . '</p>';
}

/**
 * Register students settings inside the Gutenberg Block.
 */
function dx_gb_register_students_settings() {
	$registered_blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

	foreach ( $registered_blocks as $name => $block ) {
		$block->attributes['studentStatus'] = array(
			'type'    => 'string',
			'default' => 'active',
		);

		$block->attributes['studentsPerPage'] = array(
			'type'    => 'number',
			'default' => 3,
		);
	}
}

add_action( 'wp_loaded', 'dx_gb_register_students_settings', 100 );
