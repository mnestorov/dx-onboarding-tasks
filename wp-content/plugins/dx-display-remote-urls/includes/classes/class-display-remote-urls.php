<?php

/**
 * Class Display_Remote_Urls
 * Asana task: https://app.asana.com/0/1201345304239951/1201345383490682/f
 *
 * @package    DisplayRemoteUrls
 * @author     Martin Nestorov
 */
class Display_Remote_Urls {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dx_sanitized_links_plugin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dx_load_scripts' ) );
		add_action( 'wp_ajax_dx_get_remote_url', array( $this, 'dx_get_remote_url' ) );
	}

	/**
	 * Displays the form through wchih URLs are submitted
	 *
	 * @return void
	 */
	public function dx_sanitized_links_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have permission to access this page' );
		}

		$transient = get_transient( 'search_results' );

		?>
		<div class="wrap">
			<label for="url">Enter a URL here: </label>
			<input type="text" id="remote_url" name="remote_url">
			<hr>
			<label for="duration">Choose duration:</label>
			<select name="cache_duration" id="cache_duration">
				<option value="600">10 minutes</option>
				<option value="1800">30 minutes</option>
				<option value="3600">1 hour</option>
			</select>
			<hr>
			<button id="search">Search</button>
		</div>

		<div id="output" style="margin-top: 30px; contain:content;"><?php echo $transient ?? ''; ?></div>
		<?php
	}

	/**
	 * Adds the plugin menu page to the admin sidebar
	 *
	 * @return void
	 */
	public function dx_sanitized_links_plugin_menu() {
		add_menu_page( 'Display Remote Urls Plugin', 'Display Remote Urls', 'manage_options', DR_URL_SLUG . '/sanitized-links-admin.php', array( $this, 'dx_sanitized_links_options' ) );
	}

	/**
	 * Enqueue JavaScript to the admin page
	 *
	 * @return void
	 */
	public function dx_load_scripts() {
		wp_register_script( 'main', DR_URL_PATH . './assets/js/main.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'main' );
		wp_localize_script(
			'main',
			'main_object',
			array(
				'main_url' => admin_url( 'admin-ajax.php' )
			)
		);
	}

	/**
	 * Retrieves the HTML body from the provided URL
	 *
	 * @var array $_POST
	 */
	public function dx_get_remote_url() {
		if ( ! empty( $_POST['remote_url'] ) ) {
			$remote_url = sanitize_text_field( $_POST['remote_url'] );
			$contents   = wp_remote_get( $remote_url );
			$result     = wp_remote_retrieve_body( $contents );

			if ( ! empty( $_POST['transient_duration'] ) ) {
				$duration_in_seconds = intval( $_POST['transient_duration'] );
				set_transient( 'search_results', $result, $duration_in_seconds );
			} else {
				set_transient( 'search_results', $result );
			}

			wp_send_json_success( $result );
		}

		wp_send_json_error();
	}
}
