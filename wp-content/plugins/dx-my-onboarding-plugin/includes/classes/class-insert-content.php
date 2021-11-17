<?php

if ( ! class_exists( 'InsertContent' ) ) {
	/**
	 * Class InsertContent
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class InsertContent {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'the_content', array( $this, 'dx_insert_before_content' ), 10 );
			add_filter( 'the_content', array( $this, 'dx_opening_p' ), 9 );
			add_filter( 'the_content', array( $this, 'dx_closing_p' ), 11 );
			add_filter( 'the_content', array( $this, 'dx_text_wrapper' ) );
		}
		/**
		 * Insert text before post content
		 */
		public function dx_insert_before_content( $content ) {
			if ( ! is_single() ) {
				return $content;
			}
			/**
			 * Important:
			 * 1) get_option( 'my-onboarding-plugin-option' ) comes from PluginSettings plugin
			 * 2) get_option( 'is-checked' ) comes from PluginFilter plugin
			 */
			if ( get_option( 'is_checked' ) ) {
				$before_content = 'Onboarding Filter by Martin Nestorov: ';
				$content        = '<p>' . $before_content . '</p>' . $content . '<div></div>';
			}
			return $content;
		}
		/**
		 * Insert open <p> tag after post content
		 */
		public function dx_opening_p( $content ) {
			$content = $content . '<p>';
			return $content;
		}
		/**
		 * Insert closing </p> tag tag after post content
		 */
		public function dx_closing_p( $content ) {
			$content = $content . '</p>';
			return $content;
		}
		/**
		 * Wrap <div> around all <p> tags in post content
		 * Not hooked
		 */
		public function dx_text_wrapper( $content ) {
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
