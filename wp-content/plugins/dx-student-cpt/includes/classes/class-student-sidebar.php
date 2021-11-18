<?php

if ( ! class_exists( 'StudentSidebar' ) ) {
	/**
	 * Class StudentSidebar
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345346694047/f
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class StudentSidebar {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'widgets_init', array( $this, 'dx_students_sidebar' ) );
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
