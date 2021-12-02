<?php

if ( ! class_exists( 'StudentRestApi' ) ) {
	/**
	 * Class StudentRestApi handles all custom REST API requests
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentRestApi {
		/**
		 * Name space for the RestApi route
		 *
		 * @var string $namespace
		 */
		private $namespace;

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->namespace = '/api/v1';
			add_action( 'rest_api_init', array( $this, 'dx_register_api_endpoints' ) );
			add_action( 'rest_insert_page', array( $this, 'dx_add_content_to_post_meta' ), 10, 3 );
		}

		/**
		 * Check permissions for the posts
		 *
		 * @return true
		 */
		public function dx_get_item_permissions_check() {
			if ( ! current_user_can( 'edit_others_posts' ) ) {
				return new \WP_Error( 'rest_forbidden', esc_html__( 'You do not have permission to do this.' ), array( 'status' => $this->dx_authorization_status_code() ) );
			}
			return true;
		}

		/**
		 * Sets up the proper HTTP status code for authorization
		 *
		 * @var int $status
		 * @return $status
		 */
		public function dx_authorization_status_code() {
			$status = 401;

			if ( is_user_logged_in() ) {
				$status = 403;
			}

			return $status;
		}

		/**
		 * Callback for getting data for all the students
		 *
		 * @param \WP_REST_Request $request contains data from the request, to be passed to the callback.
		 * @return rest_ensure_response()
		 */
		public function dx_get_all_student_data( \WP_REST_Request $request ) {
			$page = intval( $request['page'] );

			$args = array(
				'post_type'     => 'student',
				'post_per_page' => 3,
				'paged'         => $page,
				'orderby'       => 'date',
				'order'         => 'desc',
			);

			/**
			 * For paginating query result it is not recommended to use get_posts() method
			 * but use WP_Query to get the results with pagination.
			 * @see https://developer.wordpress.org/rest-api/using-the-rest-api/pagination/
			 * @see https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters
			 */
			$query = new \WP_Query( $args );

			if ( empty( $query->posts ) ) {
				return new \WP_Error( 'no_posts', __( 'No students found.' ), array( 'status' => 404 ) );
			}

			// Set the maximum number of pages and total number of posts.
			$max_pages = $query->max_num_pages;
			$total     = $query->found_posts;

			foreach ( $query->posts as $post ) {
				$post_meta = get_post_meta( $post->ID );

				//error_log( print_r( $post_meta, true ) );

				$post_data['title']             = $post->post_title;
				$post_data['post_date']         = $post->post_date;
				$post_data['post_content']      = $post->post_content;
				$post_data['post_excerpt']      = $post->post_excerpt;
				$post_data['student_city']      = $post_meta['student_city'][0] ?? '';
				$post_data['student_address']   = $post_meta['student_address'][0] ?? '';
				$post_data['student_birthdate'] = $post_meta['student_birthdate'][0] ?? '';
				$post_data['student_grade']     = $post_meta['student_grade'][0] ?? '';
				$post_data['student_active']    = $post_meta['student_active'][0] ?? 'no';

				$data[] = $post_data;
			}

			// Prepare data for output.
			$response = new \WP_REST_Response( $data, 200 );

			// Set headers and return response.
			$response->header( 'X-WP-Total', $total );
			$response->header( 'X-WP-TotalPages', $max_pages );

			return rest_ensure_response( $response );
		}

		/**
		 * Callback for getting data for single student
		 *
		 * @param \WP_REST_Request $request retrieves merged parameters from the request.
		 * @return rest_ensure_response()
		 */
		public function dx_get_single_student_data( \WP_REST_Request $request ) {
			$post_id = $request->get_params();

			$args = array(
				'post_type'   => 'student',
				'numberposts' => 1,
				'include'     => array( $post_id['id'] ),
			);

			$post = get_posts( $args );

			if ( empty( $post ) ) {
				return new \WP_Error( 'no_posts', __( 'Please define a valid student ID.' ), array( 'status' => 404 ) );
			}

			$data['id']                = $post[0]->ID;
			$data['title']             = $post[0]->post_title;
			$data['post_content']      = $post[0]->post_content;
			$data['post_excerpt']      = $post[0]->post_excerpt;
			$data['student_city']      = $post[0]->student_city ?? '';
			$data['student_address']   = $post[0]->student_address ?? '';
			$data['student_birthdate'] = $post[0]->student_birthdate ?? '';
			$data['student_grade']     = $post[0]->student_grade ?? '';
			$data['student_active']    = $post[0]->student_active ?? 'no';

			// Prepare data for output.
			$response = new \WP_REST_Response( $data, 200 );

			return rest_ensure_response( $response );
		}

		/**
		 * Callback for adding a new student
		 *
		 * @param object $request retrieves the request body content.
		 * @return false
		 */
		public function dx_add_new_student_data( $request ) {
			$body = $request->get_body();

			//error_log( print_r( $body, true ) );

			if ( ! empty( $body ) ) {
				$body                    = json_decode( $body, true );
				$raw_title               = sanitize_text_field( $body['post_title'] );
				$raw_content             = sanitize_text_field( $body['post_content'] );
				$raw_excerpt             = sanitize_text_field( $body['post_excerpt'] );
				$raw_student_city        = sanitize_text_field( $body['student_city'] );
				$raw_student_address     = sanitize_text_field( $body['student_address'] );
				$raw_student_grade       = intval( $body['student_grade'] );
				$body['post_type']       = 'student';
				$body['post_title']      = $raw_title;
				$body['post_content']    = $raw_content;
				$body['post_excerpt']    = $raw_excerpt;
				$body['student_city']    = $raw_student_city;
				$body['student_address'] = $raw_student_address;
				$body['student_grade']   = $raw_student_grade;
				$post_id                 = wp_insert_post( $body );

				return rest_ensure_response( $post_id );
			}

			return false;
		}

		/**
		 * Callback for registering the update route
		 *
		 * @param object $request retrieves the request body content.
		 * @return false
		 */
		public function dx_edit_student( $request ) {
			$body = $request->get_body();

			// error_log( print_r( $body, true ) );

			if ( ! empty( $body ) ) {
				$body                    = json_decode( $body, true );
				$raw_title               = sanitize_text_field( $body['post_title'] );
				$raw_content             = sanitize_text_field( $body['post_content'] );
				$raw_excerpt             = sanitize_text_field( $body['post_excerpt'] );
				$raw_student_city        = sanitize_text_field( $body['student_city'] );
				$raw_student_address     = sanitize_text_field( $body['student_address'] );
				$raw_student_grade       = intval( $body['student_grade'] );
				$body['post_type']       = 'student';
				$body['post_title']      = $raw_title;
				$body['post_content']    = $raw_content;
				$body['post_excerpt']    = $raw_excerpt;
				$body['student_city']    = $raw_student_city;
				$body['student_address'] = $raw_student_address;
				$body['student_grade']   = $raw_student_grade;
				$post_id                 = wp_update_post( $body );

				return rest_ensure_response( $post_id );
			}

			return false;
		}

		/**
		 * Callback for deleting a student by ID
		 *
		 * @param object $request retrieves the request id.
		 * @return rest_ensure_response()
		 */
		public function dx_delete_student_by_id( $request ) {
			$post = wp_delete_post( $request['id'] );

			return rest_ensure_response( $post );
		}

		/**
		 * Registers the custom endpoints
		 *
		 * @return void
		 */
		public function dx_register_api_endpoints() {
			/**
			 * API Url: /api/v1/students/[page_number]
			 */
			register_rest_route( // Get all students.
				$this->namespace,
				'/students/(?P<page>[1-9]{1,2})',
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'dx_get_all_student_data' ),
					'args'                => array(
						'page' => array(
							'required' => true,
						),
					),
					'permission_callback' => '__return_true',
				)
			);

			/**
			 * API Url: /api/v1/student/[student_id]
			 */
			register_rest_route( // Get single student.
				$this->namespace,
				'/student/(?P<id>[\d]+)',
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'dx_get_single_student_data' ),
					'permission_callback' => '__return_true',
				)
			);

			/**
			 * API Url: /api/v1/student/add/
			 */
			register_rest_route( // Add new student.
				$this->namespace,
				'/student/add/',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'dx_add_new_student_data' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);

			/**
			 * API Url: /api/v1/student/edit/[student_id]
			 */
			register_rest_route( // Edit student by ID.
				$this->namespace,
				'/student/edit/(?P<id>[\d]+)',
				array(
					'methods'             => 'PUT',
					'callback'            => array( $this, 'dx_edit_student' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);

			/**
			 * API Url: /api/v1/student/delete/[student_id]
			 */
			register_rest_route( // Delete student by ID.
				$this->namespace,
				'/student/delete/(?P<id>[\d]+)',
				array(
					'methods'             => 'DELETE',
					'callback'            => array( $this, 'dx_delete_student_by_id' ),
					'permission_callback' => array( $this, 'dx_get_item_permissions_check' ),
				)
			);
		}
	}
}
