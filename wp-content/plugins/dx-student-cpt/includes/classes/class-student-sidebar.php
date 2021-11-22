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
			add_filter( 'the_content', array( $this, 'dx_add_sidebar_before' ), 7 );
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

		/**
		 * Adding the students custom sidebar before post content
		 */
		public function dx_add_sidebar_before( $content ) {
			if ( is_single() && is_active_sidebar( 'students_sidebar' ) ) {

				ob_start();

				dynamic_sidebar( 'students_sidebar' );

				$content .= ob_get_clean();
			}

			return $content;
		}
	}
}
