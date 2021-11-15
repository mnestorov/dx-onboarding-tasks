<?php

/**
 * Class AdminMenu
 *
 * @package    MyOnboardingPlugin
 * @author     Martin Nestorov
 */

class AdminMenu {
	private $mop_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mop_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mop_page_init' ) );
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
			<h2>My Onboarding Plugin</h2>
			<p></p>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'mop_option_group' );
					do_settings_sections( 'mop-admin' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function mop_page_init() {
		register_setting(
			'mop_option_group',                // This is option_group.
			'my_onboarding_plugin_option',     // This is option_name.
			array( $this, 'mop_sanitize' )     // This is sanitize_callback.
		);

		add_settings_section(
			'mop_setting_section',              // This is id.
			'Settings',                         // This is title.
			array( $this, 'mop_section_info' ), // This is callback.
			'mop-admin'                         // This is page.
		);

		add_settings_field(
			'filter',                            // This is id.
			'FIlter',                            // This is title.
			array( $this, 'filter_callback' ),   // This is callback.
			'mop-admin',                         // This is page.
			'mop_setting_section'                // This is section.
		);
	}

	public function mop_sanitize( $input ) {
		$sanitary_values = array();
		if ( isset( $input['filter'] ) ) {
			$sanitary_values['filter'] = sanitize_text_field( $input['filter'] );
		}

		return $sanitary_values;
	}

	public function mop_section_info() {

	}

	public function filter_callback() {
		printf(
			'<input type="checkbox" name="my_onboarding_plugin_option[filter]" id="filter" value="filter" %s>',
			( isset( $this->mop_options['filter'] ) ? $this->mop_options['filter'] === 'filter' : '' ) ? 'checked' : ''
		);
	}
}
