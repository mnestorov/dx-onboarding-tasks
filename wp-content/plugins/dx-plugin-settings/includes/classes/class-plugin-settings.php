<?php

if ( ! class_exists( 'Plugin_Settings' ) ) {
	/**
	 * Class PluginSettings
	 *
	 * @package    MyPluginSettings
	 * @author     Martin Nestorov
	 */
	class Plugin_Settings {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'page_init' ) );
		}

		/**
		 * Add the plugin settings page do WP admin
		 *
		 * @return void
		 */
		public function add_plugin_page() {
			add_menu_page(
				'My Onboarding Plugin',                  // This is page_title.
				'My Onboarding Plugin',                  // This is menu_title.
				'manage_options',                        // This is capability.
				'my-onboarding-plugin',                  // This is menu_slug.
				array( $this, 'create_admin_page' ),     // This is function.
				'dashicons-admin-generic',               // This is icon_url.
				65                                       // This is position.
			);
		}

		/**
		 * Create the structure of the plugin settings page
		 *
		 * @return void
		 */
		public function create_admin_page() {
			$this->dx_options = get_option( 'my_onboarding_plugin_option' ); ?>
			<div class="wrap">
				<h2><?php esc_html_e( 'My Onboarding Plugin', 'mop'); ?></h2>
				<p></p>
				<?php settings_errors(); ?>
				<form method="post" action="options.php">
					<?php
						settings_fields( 'option_group' );
						do_settings_sections( 'admin' );
						submit_button();
					?>
				</form>
			</div>
			<?php
		}

		/**
		 * Adds the settings fields for the plugin settings page
		 *
		 * @return void
		 */
		public function page_init() {
			register_setting(
				'option_group',                        // This is option_group.
				'my_onboarding_plugin_option',         // This is option_name.
				array( $this, 'sanitize' )             // This is sanitize_callback.
			);
			add_settings_section(
				'setting_section',                     // This is id.
				'Settings',                            // This is title.
				array( $this, 'section_info' ),        // This is callback.
				'admin'                                // This is page.
			);
			add_settings_field(
				'checkbox',                             // This is id.
				'Filter',                               // This is title.
				array( $this, 'filter_callback' ),      // This is callback.
				'admin',                                // This is page.
				'setting_section'                       // This is section.
			);
		}

		/**
		 * Sanitizes a string from user input or from the database
		 *
		 * @param array $input
		 * @return void
		 */
		public function sanitize( $input ) {
			$sanitary_values = array();
			if ( isset( $input['filter'] ) ) {
				$sanitary_values['filter'] = sanitize_text_field( $input['filter'] );
			}
			return $sanitary_values;
		}

		/**
		 * Add the section info in to the plugin settings page
		 *
		 * @return void
		 */
		public function section_info() {
			// Add some code in here.
		}

		/**
		 * Callback function
		 *
		 * @return void
		 */
		public function filter_callback() {
			printf(
				'<input type="checkbox" name="my_onboarding_plugin_option[filter]" id="filter" value="filter" %s>',
				( isset( $this->options['filter'] ) ?? '' ) ? 'checked' : ''
			);
		}
	}
}
