<?php

if ( ! class_exists( 'Student_Sidebar' ) ) {
	/**
	 * Class Student_Sidebar
	 *
	 * @package    StudentCPT
	 * @author     Martin Nestorov
	 */
	class Student_Sidebar {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'widgets_init', array( $this, 'students_sidebar' ) );
			add_filter( 'the_content', array( $this, 'add_sidebar_before' ), 7 );
		}

		/**
		 * Registers the students custom sidebar
		 *
		 * @return void
		 */
		public function students_sidebar() {
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
		 *
		 * @param string $content return sidebar content.
		 * @return $content
		 */
		public function add_sidebar_before( $content ) {
			if ( is_single() && is_active_sidebar( 'students_sidebar' ) ) {

				ob_start();

				dynamic_sidebar( 'students_sidebar' );

				$content .= ob_get_clean();
			}

			return $content;
		}
	}
}
