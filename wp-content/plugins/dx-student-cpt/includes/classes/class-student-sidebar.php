<?php

if ( ! class_exists( 'StudentSidebar' ) ) {
	/**
	 * Class StudentSidebar
	 *
	 * @package    StudentCTP
	 * @author     Martin Nestorov
	 */
	class StudentSidebar {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'widgets_init', array( $this, 'ds_students_sidebar' ) );
		}

		/**
		 * Registers the students custom sidebar
		 */
		public function dx_students_sidebar() {
			register_sidebar(
				array(
					'id'          => 'students_sidebar',
					'name'        => __( 'Students Sidebar' ),
					'description' => __( 'This sidebar will display the students widget.' ),
				)
			);
		}

	}
}
