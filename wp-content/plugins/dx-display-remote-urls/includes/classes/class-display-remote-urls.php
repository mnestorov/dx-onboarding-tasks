<?php

/**
 * Class DisplayRemoteUrls
 * Asana task: https://app.asana.com/0/1201345304239951/1201345383490682/f
 *
 * @package    DisplayRemoteUrls
 * @author     Martin Nestorov
 */
class DisplayRemoteUrls {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dx_sanitized_links_plugin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dx_load_scripts' ) );
		add_action( 'wp_ajax_dx_display_input_url', array( $this, 'dx_display_input_url' ) );
	}

	/**
	 * Displays the form through wchih URLs are submitted
	 */
	public function dx_sanitized_links_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have permission to access this page' );
		}
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

		<div id="output" style="margin-top: 30px;"><?php $this->dx_transient_check_and_display(); ?></div>
		<?php
	}

	/**
	 * Adds the plugin menu page to the admin sidebar
	 */
	public function dx_sanitized_links_plugin_menu() {
		add_menu_page( 'Display Remote Urls Plugin', 'Display Remote Urls', 'manage_options', DR_URL_SLUG . '/sanitized-links-admin.php', array( $this, 'dx_sanitized_links_options' ) );
	}

	/**
	 * Enqueue JavaScript to the admin page
	 */
	public function dx_load_scripts() {
		wp_register_script( 'main', DR_URL_PATH . './assets/js/main.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'main' );
		wp_localize_script( 'main', 'main_object', array( 'main_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Retrieves the HTML body from the provided URL
	 *
	 * @var array $_POST
	 */
	public function dx_display_input_url() {
		$remote_url          = sanitize_text_field( $_POST['data']['remote_url'] );
		$duration_in_seconds = sanitize_text_field( $_POST['data']['transient_duration'] );

		$this->dx_transient_duration( $remote_url, $duration_in_seconds );
		$this->dx_results_display();

		wp_die();
	}

	/**
	 * Checks if we have transient and calls the display function if we do
	 */
	public function dx_transient_check_and_display() {
		$result = get_transient( 'search_results' );

		if ( false !== $result ) {
			$this->dx_results_display();
		}
	}

	/**
	 * Sets the url and the duration in transient
	 */
	public function dx_transient_duration( $remote_url, $duration_in_seconds ) {
		if ( $remote_url !== '' ) {

			if ( ! $duration_in_seconds ) {
				$duration_in_seconds = 10;
			}

			set_transient( 'search_results', $remote_url, $duration_in_seconds );
		}
	}

	/**
	 * If there is cached HTML is displays it, otherwise displays nothing
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345383183068/f
	 */
	public function dx_results_display() {
		$url      = get_transient( 'search_results' );
		$contents = wp_remote_get( $url );
		echo wp_remote_retrieve_body( $contents );
	}
}
