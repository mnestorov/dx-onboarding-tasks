<?php

if ( ! class_exists( 'Plugin_Filter' ) ) {
	/**
	 * Class Plugin_Filter
	 *
	 * @package    StudentCTP
	 * @author     Martin Nestorov
	 */
	class Plugin_Filter {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'wp_ajax_enable_filters', array( $this, 'enable_filters' ) );
		}

		/**
		 * Add the plugin settings page do WP admin
		 *
		 * @return void
		 */
		public function add_plugin_page() {
			add_menu_page(
				'Student CPT Admin',                     // This is page_title.
				'Student CPT Settings',                  // This is menu_title.
				'manage_options',                        // This is capability.
				'student-cpt',                           // This is menu_slug.
				array( $this, 'create_admin_page' ),  // This is function.
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
			$this->options = get_option( 'student_cpt_option' ); ?>
			<div class="wrap">
				<h2><?php esc_html_e( 'Student CPT Settings', 'studentcpt'); ?></h2>
				<p></p>
				<?php settings_errors(); ?>
				<form method="post" action="options.php">
					<?php
						settings_fields( 'option_group' );
						do_settings_sections( 'admin' );
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
				'option_group',                       // This is option_group.
				'is_checked',                         // This is option_name.
			);
			add_settings_section(
				'setting_section',                    // This is id.
				'Settings',                           // This is title.
				array( $this, 'section_info' ),       // This is callback.
				'admin'                               // This is page.
			);
			add_settings_field(
				'checkbox',                            // This is id.
				'Show/Hide Students',                  // This is title.
				array( $this, 'filter_callback' ),     // This is callback.
				'admin',                               // This is page.
				'setting_section'                      // This is section.
			);
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
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You don\'t have permissions to access this page.' ) );
			} ?>
			<div>
				<input type="checkbox" id="filters_checkbox" name="checkbox" <?php echo get_option( 'is_checked' ) ?? 'checked'; ?>>
				<label for="checkbox">If this option is enabled, the student list will be hidden.</label>
			</div>
			<?php
		}

		/**
		 * Handles the AJAX response from the main.js
		 *
		 * @return void
		 */
		public function enable_filters() {
			$student_cpt_option = $_POST['is_checked'];
			update_option( 'is_checked', $student_cpt_option );
			wp_die();
		}
	}
}
