<?php

if ( ! class_exists( 'Insert' ) ) {
	/**
	 * Class Insert
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class Insert {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'insert_before_content' ), 10 );
			add_filter( 'the_content', array( $this, 'opening_p' ), 9 );
			add_filter( 'the_content', array( $this, 'closing_p' ), 11 );
			// add_filter( 'the_content', array( $this, 'text_wrapper' ) );
		}

		/**
		 * Insert before content
		 */
		public function insert_before_content( $content ) {
			if ( ! is_single() ) {
				return $content;
			}

			$my_onboarding_plugin_option = get_option( 'my_onboarding_plugin_option' );

			if ( ! $my_onboarding_plugin_option ) {
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
		public function opening_p( $content ) {
			$content = $content . '<p>';
			return $content;
		}

		/**
		 * Insert closing </p> tag
		 */
		public function closing_p( $content ) {
			$content = $content . '</p>';
			return $content;
		}

		/**
		 * Wrap <div> around <p> tags
		 */
		/* public function text_wrapper( $content ) {
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