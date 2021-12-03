<?php

if ( ! class_exists( 'Insert_Content' ) ) {
	/**
	 * Class Insert_Content
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class Insert_Content {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'insert_before_content' ), 10 );
			add_filter( 'the_content', array( $this, 'opening_p' ), 9 );
			add_filter( 'the_content', array( $this, 'closing_p' ), 11 );
			add_filter( 'the_content', array( $this, 'text_wrapper' ) );
		}

		/**
		 * Insert text before post content
		 *
		 * @param string $content contains the page content.
		 * @return $content
		 */
		public function insert_before_content( $content ) {
			/**
			 * Important:
			 * 1) get_option( 'my-onboarding-plugin-option' ) comes from PluginSettings plugin
			 * 2) get_option( 'is-checked' ) comes from PluginFilter plugin
			 */
			if ( get_option( 'is_checked' ) && 'student' === get_post_type() ) {
				$before_content = 'Onboarding Filter by Martin Nestorov: ';
				$content        = '<p>' . $before_content . '</p>' . $content . '<div></div>';
			}
			return $content;
		}

		/**
		 * Insert open <p> tag after post content
		 *
		 * @param string $content contains opening html <p> tag.
		 * @return $content
		 */
		public function opening_p( $content ) {
			$content = $content . '<p>';
			return $content;
		}

		/**
		 * Insert closing </p> tag tag after post content
		 *
		 * @param string $content contains closing html <p> tag.
		 * @return $content
		 */
		public function closing_p( $content ) {
			$content = $content . '</p>';
			return $content;
		}

		/**
		 * Wrap <div> around all <p> tags in post content
		 * Not hooked
		 *
		 * @param string $content contains html content of the page.
		 * @return string
		 */
		public function text_wrapper( $content ) {
			return preg_replace_callback(
				'~<p.*?</p>~',
				function( $matches ) {
					return '<div>' . $matches[0] . '</div>';
				},
				$content
			);
		}
	}
}
