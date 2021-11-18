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
		add_action( 'admin_enqueue_scripts', array( $this, 'dx_load_scripts' ) );
		add_action( 'wp_ajax_displayInputUrl', array( $this, 'dx_display_input_url' ) );
		add_action( 'wp_ajax_displayCachedHtml', array( $this, 'dx_display_cached_html' ) );
	}

	/**
	 * Enqueue JavaScript to the admin page
	 */
	public function dx_load_scripts() {
		wp_register_script( 'main', DR_URL_PATH . './assets/js/main.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'main' );
	}

	/**
	 * Retrieves the HTML body from the provided URL
	 *
	 * @var array $_POST
	 */
	public function dx_display_input_url() {
		if ( isset( $_POST['url'] ) ) {
			$html_body = wp_remote_get( sanitize_text_field( $_POST['url'] ) );
		}

		echo wp_remote_retrieve_body( $html_body );

		wp_die();
	}

	/**
	 * If there is cached HTML is displays it, otherwise displays nothing
	 * Asana task: https://app.asana.com/0/1201345304239951/1201345383183068/f
	 */
	public function dx_display_cached_html() {
		$cached_html = get_transient( 'cached_html' );

		if ( false === $cached_html ) {
			echo '';
		}

		echo $cached_html;

		wp_die();
	}
}
