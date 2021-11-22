<?php

if ( ! class_exists( 'PluginFilter' ) ) {
	/**
	 * Class PluginFilter
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345383459199/f
	 *
	 * @package    MyPluginFilter
	 * @author     Martin Nestorov
	 */
	class PluginFilter {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'dx_add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'dx_page_init' ) );
			add_action( 'wp_ajax_dx_enable_filters', array( $this, 'dx_enable_filters' ) );
		}

		public function dx_add_plugin_page() {
			add_menu_page(
				'My Onboarding Plugin',                  // This is page_title.
				'My Onboarding Plugin',                  // This is menu_title.
				'manage_options',                        // This is capability.
				'my-onboarding-plugin',                  // This is menu_slug.
				array( $this, 'dx_create_admin_page' ),  // This is function.
				'dashicons-admin-generic',               // This is icon_url.
				65                                       // This is position.
			);
		}

		public function dx_create_admin_page() {
			$this->dx_options = get_option( 'my_onboarding_plugin_option' ); ?>
			<div class="wrap">
				<h2><?php esc_html_e( 'My Onboarding Plugin', 'mypluginfilter'); ?></h2>
				<p></p>
				<?php settings_errors(); ?>
				<form method="post" action="options.php">
					<?php
						settings_fields( 'dx_option_group' );
						do_settings_sections( 'dx-admin' );
					?>
				</form>
			</div>
			<?php
		}

		public function dx_page_init() {
			register_setting(
				'dx_option_group',                   // This is option_group.
				'is_checked',                        // This is option_name.
			);
			add_settings_section(
				'dx_setting_section',                 // This is id.
				'Settings',                           // This is title.
				array( $this, 'dx_section_info' ),    // This is callback.
				'dx-admin'                            // This is page.
			);
			add_settings_field(
				'dx-checkbox',                         // This is id.
				'Filter',                              // This is title.
				array( $this, 'dx_filter_callback' ),  // This is callback.
				'dx-admin',                            // This is page.
				'dx_setting_section'                   // This is section.
			);
		}

		public function dx_section_info() {
			// Add some code in here.
		}

		public function dx_filter_callback() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You don\'t have permissions to access this page.' ) );
			} ?>
			<div>
				<input type="checkbox" id="dx_filters_checkbox" name="checkbox" <?php echo get_option( 'is_checked' ) ?? 'checked'; ?>>
				<label for="checkbox">Enabled / Disabled</label>
			</div>
			<?php
		}

		/**
		 * Handles the AJAX response from the main.js
		 */
		public function dx_enable_filters() {
			$my_onboarding_plugin_option = $_POST['is_checked'];
			update_option( 'is_checked', $my_onboarding_plugin_option );
			wp_die();
		}
	}
}
