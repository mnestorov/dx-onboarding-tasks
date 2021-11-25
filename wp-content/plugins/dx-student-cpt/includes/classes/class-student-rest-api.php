<?php

if ( ! class_exists( 'StudentRestApi' ) ) {
	/**
	 * Class StudentRestApi handles all custom REST API requests.
	 * 
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentRestApi {

		protected $params;

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'rest_api_init', array( $this, 'dx_register_api_endpoints' ) );
			add_action( 'rest_insert_page', array( $this, 'dx_add_content_to_post_meta' ), 10, 3 );
		}

		/**
		 * Check permissions for the posts.
		 *
		 * @param WP_REST_Request $request Current request.
		 */
		public function dx_get_item_permissions_check() {
			if ( ! current_user_can( 'edit_others_posts' ) ) {
				return new \WP_Error( 'rest_forbidden', esc_html__( 'You don\'t have permission.' ), array( 'status' => $this->dx_authorization_status_code() ) );
			}
			return true;
		}

		/**
		 * Sets up the proper HTTP status code for authorization.
		 */
		public function dx_authorization_status_code() {
			$status = 401;

			if ( is_user_logged_in() ) {
				$status = 403;
			}

			return $status;
		}

		/**
		 * Callback for getting data for all students
		 */
		public function dx_get_all_student_data() {
			$args = array(
				'post_type'     => 'student',
				'p'             => $this->params['id'],
				'post_per_page' => 3,
			);

			/**
			 * Here we are usig `get_post` according to WP docs
			 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/controller-classes/
			 */
			$posts = get_posts( $args );

			if ( empty( $posts ) ) {
				return rest_ensure_response( array() );
			}

			// Return all of our response data.
			return rest_ensure_response( $posts );
		}

		/**
		 * Callback for getting data for one student
		 */
		public function dx_get_one_student_data( $request ) {
			$post_id = intval( $request['id'] );
			$post    = get_posts( $post_id );

			if ( empty( $post ) ) {
				return rest_ensure_response( array() );
			}

			return rest_ensure_response( $post );
		}

		/**
		 * Callback for adding a new student
		 */
		public function dx_add_new_student_data() {
			if ( isset( $_POST['post_title'] ) && isset( $_POST['post_content'] ) && isset( $_POST['post_excerpt'] ) ) {
				$post = array(
					'post_type'    => 'student',
					'post_title'   => sanitize_title( $_POST['post_title'] ),
					'post_content' => sanitize_text_field( $_POST['post_content'] ),
					'post_excerpt' => sanitize_text_field( $_POST['post_excerpt'] ),
					'post_status'  => 'publish',
				);

				$post_id = wp_insert_post( $post );

				return rest_ensure_response( $post_id );
			}
		}

		/**
		 * Callback for registering the update route
		 */
		public function dx_edit_student() {
			if ( isset( $_POST['post_title'] ) && isset( $_POST['post_content'] ) && isset( $_POST['post_excerpt'] ) ) {
				$post = array(
					'ID'           => $this->params['id'],
					'post_title'   => sanitize_title( $_POST['post_title'] ),
					'post_content' => sanitize_text_field( $_POST['post_content'] ),
					'post_excerpt' => sanitize_text_field( $_POST['post_excerpt'] ),
				);
		
				$post_id = wp_insert_post( $post );

				return rest_ensure_response( $post_id );
			}
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
					'methods'  			  => 'GET',
					'callback' 			  => array( $this, 'dx_get_all_student_data' ),
					'permission_callback' => '__return_true',
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
				'/students/add/',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'dx_add_new_student_data' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);

			register_rest_route( // Edit student by ID.
				'/api/v1',
				'/students/edit/(?P<id>[\d]+)',
				array(
					'methods'             => 'PUT',
					'callback'            => array( $this, 'dx_edit_student' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);

			register_rest_route( // Delete student by ID.
				'/api/v1',
				'/students/delete/(?P<id>[\d]+)',
				array(
					'methods'             => 'DELETE',
					'callback'            => array( $this, 'dx_delete_student_by_id' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);
		}
	}
}
