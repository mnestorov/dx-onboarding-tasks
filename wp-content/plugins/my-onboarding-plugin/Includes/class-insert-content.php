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
		 * Insert before content
		 */
		public function insert_before_content( $content ) {
			$before_content = 'Onboarding Filter: ';
			$user_name = 'Martin Nestorov';

			if ( is_single() ) {
				$content = '<p style="text-align:center;">' . $before_content . $user_name . '</p>' . $content;
                $content .= $this->insert_after_content();
			}

			return $content;
		}

		/**
		 * Insert after content
		 */
		public function insert_after_content() {
			$after_content = '<div></div>';

			return $after_content;
		}
	}
}