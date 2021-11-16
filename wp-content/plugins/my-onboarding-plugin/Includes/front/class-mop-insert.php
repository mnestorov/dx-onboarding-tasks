<?php

if ( ! class_exists( 'MOP_Insert' ) ) {
	/**
	 * Class MOP_Insert
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MOP_Insert {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'mop_insert_before_content' ), 10 );
			add_filter( 'the_content', array( $this, 'mop_opening_p' ), 9 );
			add_filter( 'the_content', array( $this, 'mop_closing_p' ), 11 );
			// add_filter( 'the_content', array( $this, 'mop_text_wrapper' ) );
		}

		/**
		 * Insert before content
		 */
		public function mop_insert_before_content( $content ) {
			if ( ! is_single() ) {
				return $content;
			}

			if ( ! get_option( 'mop_is_checked' ) ) {
				return $content;
			}

			$before_content = 'Onboarding Filter: ';
			$user_name = 'Martin Nestorov';

			$content = '<p style="text-align:center;">' . $before_content . $user_name . '</p>' . $content;
			$content .= '<div></div>';

			return $content;
		}

		/**
		 * Insert open <p> tag
		 */
		public function mop_opening_p( $content ) {
			$content = $content . '<p>';
			return $content;
		}

		/**
		 * Insert closing </p> tag
		 */
		public function mop_closing_p( $content ) {
			$content = $content . '</p>';
			return $content;
		}

		/**
		 * Wrap <div> around <p> tags
		 */
		/* public function mop_text_wrapper( $content ) {
			return preg_replace_callback(
				'~<p.*?</p>~',
				function( $matches ) {
					return '<div>' . $matches[0] . '</div>';
				},
				$content
			);
		} */
	}
}