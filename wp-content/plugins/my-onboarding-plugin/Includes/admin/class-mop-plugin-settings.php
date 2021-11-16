<?php

if ( ! class_exists( 'MOP_PluginSettings' ) ) {
	/**
	 * Class MOP_PluginSettings
	 *
	 * @package    MyOnboardingPlugin
	 * @author     Martin Nestorov
	 */
	class MOP_PluginSettings {

		public function __construct() {
			$this->mop_filters_enabled();
			add_action( 'admin_menu', array( $this, 'mop_add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'mop_page_init' ) );
			add_action( 'wp_ajax_mop_enable_filters', array( $this, 'mop_enable_filters' ) );
		}

		public function mop_add_plugin_page() {
			add_menu_page(
				'My Onboarding Plugin',                  // This is page_title.
				'My Onboarding Plugin',                  // This is menu_title.
				'manage_options',                        // This is capability.
				'my-onboarding-plugin',                  // This is menu_slug.
				array( $this, 'mop_create_admin_page' ), // This is function.
				'dashicons-lightbulb',                   // This is icon_url.
				65                                       // This is position.
			);
		}

		public function mop_create_admin_page() {
			$this->mop_options = get_option( 'my_onboarding_plugin_option' ); ?>

			<div class="wrap">
				<h2><?php esc_html_e( 'My Onboarding Plugin', 'mop'); ?></h2>
				<p></p>
				<?php settings_errors(); ?>
				<form method="post" action="options.php">
					<?php
						settings_fields( 'mop_option_group' );
						do_settings_sections( 'mop-admin' );
						//submit_button();
					?>
				</form>
			</div>
			<?php
		}

		public function mop_page_init() {
			register_setting(
				'mop_option_group',                  // This is option_group.
				'mop_is_checked',     				 // This is option_name.
			);

			add_settings_section(
				'mop_setting_section',              // This is id.
				'Settings',                         // This is title.
				array( $this, 'mop_section_info' ), // This is callback.
				'mop-admin'                         // This is page.
			);

			add_settings_field(
				'mop-checkbox',                            // This is id.
				'Filter',                            // This is title.
				array( $this, 'mop_filter_callback' ),   // This is callback.
				'mop-admin',                         // This is page.
				'mop_setting_section'                // This is section.
			);
		}

		public function mop_section_info() {
			// Add some code in here.
		}

		public function mop_filter_callback() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You don\'t have permissions to access this page.' ) );
			} ?>

			<div>
				<input type="checkbox" id="mop_filters_checkbox" name="checkbox" <?php echo esc_attr( get_option( 'mop_is_checked' ) ); ?>>
				<label for="checkbox">Filters enabled</label>
			</div><?php
		}

		/**
		 * Handles the AJAX response from the checkbox.js
		 */
		public function mop_enable_filters() {
			$mop_is_checked = $_POST['mop_is_checked'];

			update_option( 'mop_is_checked', $mop_is_checked );

			wp_die();
		}

		/**
		 * Checks if the filters in the admin menu are enabled
		 * @return bool
		 */
		public function mop_filters_enabled() {
			return get_option( 'mop_is_checked' ) === 'checked';
		}
	}
}
