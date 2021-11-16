<?php

if ( ! class_exists( 'MOP_Cpt' ) ) {
	/**
	 * Class MOP_Cpt
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MOP_Cpt {

		public function __construct() {
			add_action( 'init', array( $this, 'mop_register_student_cpt' ) );
			add_action( 'init', array( $this, 'mop_register_student_taxes' ) );
		}

		public function mop_register_student_cpt() {

			/**
			 * Post Type: Students.
			 */
			$labels = array(
				'name' 					=> __( 'Students', 'mop' ),
				'singular_name' 		=> __( 'Student', 'mop' ),
				'menu_name' 			=> __( 'Students', 'mop' ),
				'all_items' 			=> __( 'All Students', 'mop' ),
				'add_new' 				=> __( 'Add New', 'mop' ),
				'add_new_item' 			=> __( 'Add New Student', 'mop' ),
				'edit_item' 			=> __( 'Edit Student', 'mop' ),
				'new_item' 				=> __( 'New Student', 'mop' ),
				'view_item' 			=> __( 'View Student', 'mop' ),
				'view_items' 			=> __( 'View Students', 'mop' ),
				'search_items' 			=> __( 'Search Students', 'mop' ),
				'not_found' 			=> __( 'No Students found', 'mop' ),
				'not_found_in_trash' 	=> __( 'No Students found in Trash', 'mop' ),
				'set_featured_image' 	=> __( 'Set featured image for this student', 'mop' ),
				'remove_featured_image' => __( 'Remove featured image for this student', 'mop' ),
				'use_featured_image' 	=> __( 'Use as featured image for this student', 'mop' ),
				'archives' 				=> __( 'Student archives', 'mop' ),
				'name_admin_bar' 		=> __( 'Student', 'mop' ),
			);

			$args = array(
				'label' 				=> __( 'Students', 'mop' ),
				'labels' 				=> $labels,
				'description' 			=> '',
				'public' 				=> true,
				'publicly_queryable' 	=> true,
				'show_ui' 				=> true,
				'has_archive' 			=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' 	=> true,
				'delete_with_user' 		=> false,
				'exclude_from_search' 	=> false,
				'capability_type' 		=> 'post',
				'map_meta_cap' 			=> true,
				'hierarchical' 			=> false,
				'rewrite' 				=> [
					'slug' 		 => 'student',
					'with_front' => true
				],
				'query_var' 			=> true,
				'menu_icon' 			=> 'dashicons-businessman',
				'supports' 				=> [
					'title',
					'editor',
					'thumbnail',
					'excerpt'
				],
			);

			register_post_type( 'student', $args );
		}

		public function mop_register_student_taxes() {

			/**
			 * Taxonomy: Students Categories.
			 */

			$labels = array(
				'name' 						=> __( 'Students Categories', 'mop' ),
				'singular_name' 			=> __( 'Student Category', 'mop' ),
			);

			$args = array(
				'label' 					=> __( 'Students Categories', 'mop' ),
				'labels' 					=> $labels,
				'public' 					=> true,
				'publicly_queryable' 		=> true,
				'hierarchical' 				=> false,
				'show_ui' 					=> true,
				'show_in_menu' 				=> true,
				'show_in_nav_menus' 		=> true,
				'query_var' 				=> true,
				'rewrite' 					=> [
					'slug' 		 => 'student_categories',
					'with_front' => true,
				],
				'show_admin_column' 		=> false,
				'show_tagcloud' 			=> false,
				'show_in_quick_edit' 		=> false,
			);

			register_taxonomy( 'student_categories', array( 'student' ), $args );
		}
	}
}
