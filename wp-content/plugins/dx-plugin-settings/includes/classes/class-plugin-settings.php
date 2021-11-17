<?php

if ( ! class_exists( 'PluginSettings' ) ) {
	/**
	 * Class PluginSettings
	 *
	 * @package    MyPluginSettings
	 * @author     Martin Nestorov
	 */
	class PluginSettings {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'dx_add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'dx_page_init' ) );
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
				<h2><?php esc_html_e( 'My Onboarding Plugin', 'mop'); ?></h2>
				<p></p>
				<?php settings_errors(); ?>
				<form method="post" action="options.php">
					<?php
						settings_fields( 'dx_option_group' );
						do_settings_sections( 'dx-admin' );
						submit_button();
					?>
				</form>
			</div>
			<?php
		}
		public function dx_page_init() {
			register_setting(
				'dx_option_group',                     // This is option_group.
				'my_onboarding_plugin_option',         // This is option_name.
				array( $this, 'dx_sanitize' )          // This is sanitize_callback.
			);
			add_settings_section(
				'dx_setting_section',                  // This is id.
				'Settings',                            // This is title.
				array( $this, 'dx_section_info' ),     // This is callback.
				'dx-admin'                             // This is page.
			);
			add_settings_field(
				'dx-checkbox',                          // This is id.
				'Filter',                               // This is title.
				array( $this, 'dx_filter_callback' ),   // This is callback.
				'dx-admin',                             // This is page.
				'dx_setting_section'                    // This is section.
			);
		}	
		public function dx_sanitize( $input ) {
			$sanitary_values = array();
			if ( isset( $input['filter'] ) ) {
				$sanitary_values['filter'] = sanitize_text_field( $input['filter'] );
			}
			return $sanitary_values;
		}
		public function dx_section_info() {
		}
		public function dx_filter_callback() {
			printf(
				'<input type="checkbox" name="my_onboarding_plugin_option[filter]" id="filter" value="filter" %s>',
				( isset( $this->dx_options['filter'] ) ?? '' ) ? 'checked' : ''
			);
		}
	}
}
