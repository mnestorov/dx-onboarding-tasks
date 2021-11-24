<?php

if ( ! class_exists( 'StudentRestApi' ) ) {
	/**
	 * Class StudentRestApi handles all custom REST API requests.
	 * 
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentRestApi {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'rest_api_init', array( $this, 'dx_register_api_endpoints' ) );
		}

		/**
		 * Callback for getting data for all students
		 */
		public function dx_get_all_student_data() {

			$args = array(
				'post_type'     => 'student',
				'post_per_page' => 3,
				'post_status'   => 'publish',
			);

			$posts = get_posts( $args );

			if ( empty( $posts ) ) {
				return null;
			}

			return rest_ensure_response( $posts );
		}

		/**
		 * Callback for getting data for one student
		 */
		public function dx_get_one_student_data( $request ) {
			$post_id = intval( $request['id'] );

			$post = get_post( $post_id );

			if ( empty( $post ) ) {
				return null;
			}

			return rest_ensure_response( $post );
		}

		/**
		 * Callback for adding a new student
		 */
		public function dx_add_new_student_data( $request ) {
			$post_id = wp_insert_post( json_decode( $request->get_body() ) );

			return rest_ensure_response( $post_id );
		}

		/**
		 * Callback for registering the update route
		 */
		public function dx_edit_student( $request ) {
			$post_id = wp_update_post( json_decode( $request->get_body() ) );

			return rest_ensure_response( $post_id );
		}

		/**
		 * Callback for deleting a student by ID
		 */
		public function dx_delete_student_by_id( $request ) {
			$post = wp_delete_post( $request['id'] );

			return rest_ensure_response( $post );
		}

		/**
		 * Registers the custom endpoints
		 */
		public function dx_register_api_endpoints() {
			register_rest_route( // Get all students.
				'/api/v1',
				'/students',
				array(
					'methods'  => 'GET',
					'callback' => array( $this, 'dx_get_all_student_data' ),
				)
			);

			register_rest_route( // Get single student.
				'/api/v1',
				'/students/(?P<id>[\d]+)',
				array(
					'methods'  => 'GET',
					'callback' => array( $this, 'dx_get_one_student_data' ),
				)
			);

			register_rest_route( // Add new student.
				'/api/v1',
				'/students/add',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'dx_add_new_student_data' ),
					'permission_callback' => function() {
						return current_user_can( 'edit_others_posts' );
					},
				)
			);

			register_rest_route( // Edit student by ID.
				'/api/v1',
				'/students/edit/(?P<id>[\d]+)',
				array(
					'methods'             => 'PUT',
					'callback'            => array( $this, 'dx_edit_student' ),
					'permission_callback' => function() {
						return current_user_can( 'edit_others_posts' );
					},
				)
			);

			register_rest_route( // Delete student by ID.
				'/api/v1',
				'/students/delete/(?P<id>[\d]+)',
				array(
					'methods'             => 'DELETE',
					'callback'            => array( $this, 'dx_delete_student_by_id' ),
					'permission_callback' => function() {
						return current_user_can( 'edit_others_posts' );
					},
				)
			);
		}
	}
}
