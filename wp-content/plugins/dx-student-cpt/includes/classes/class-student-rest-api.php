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
			$posts = get_posts(
				array(
					'post_type'     => 'student',
					'post_per_page' => 3,
				)
			);

			return rest_ensure_response( $posts );
		}

		/**
		 * Callback for getting data for one student
		 */
		public function dx_get_one_student_data( $request ) {
			$id = (int) $request['id'];

			$post = get_post( $id );

			if ( empty( $post ) ) {
				return rest_ensure_response( array() );
			}

			return rest_ensure_response( $post );
		}

		/**
		 * Registers the custom endpoints
		 */
		public function dx_register_api_endpoints() {
			register_rest_route(
				'/api/v1',
				'/students',
				array(
					'methods'  => 'GET',
					'callback' => array( $this, 'dx_get_all_student_data' ),
				)
			);

			register_rest_route(
				'/api/v1',
				'/students/(?P<id>[\d]+)',
				array(
					'methods'  => 'GET',
					'callback' => array( $this, 'dx_get_one_student_data' ),
				)
			);
		}
	}
}
