<?php

/**
 * Class AdminMenu
 *
 * @package    MyOnboardingPlugin
 * @author     Martin Nestorov
 */
class AdminMenu {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'create_menu' ) );
	}

	public function create_menu() {
		add_submenu_page( 'options-general.php', 'My Onboarding', 'My Onboarding', 'manage_options', 'mop_page', array( $this, 'display_mop_page' ) );
	}

	public function display_mop_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		} ?>

		<div class="wrap">
			<h2><?php _e( 'My Onboarding', 'mop' ); ?></h2>
			<p>Filters Enabled:</p>
		</div>
		<?php
	}
}
