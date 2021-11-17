<?php

/**
 * Class PluginMenu
 *
 * @package    DisplayRemoteUrls
 * @author     Martin Nestorov
 */
class PluginMenu {
	/**
	 * Create an nonce, and add it as a query var in a link to perform an action
	 */
	public $nonce;
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dx_sanitized_links_plugin_menu' ) );
	}
	/**
	 * Displays the form through wchih URLs are submitted
	 */
	public function dx_sanitized_links_options() {
		$this->nonce = wp_create_nonce( 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html( 'You do not have sufficient permissions to access this page.' ) );
		}
		if ( ! wp_verify_nonce( $this->nonce, 'nonce' ) ) {
			die( 'Security check' );
		} else {
			$html_form = wp_remote_get( DR_URL_PATH . './includes/templates/form.html' );
			echo wp_remote_retrieve_body( $html_form );
		}
	}
	/**
	 * Adds the plugin menu page to the admin sidebar
	 */
	public function dx_sanitized_links_plugin_menu() {
		add_menu_page( 'Display Remote Urls Plugin', 'Display Remote Urls', 'manage_options', DR_URL_SLUG . '/sanitized-links-admin.php', array( $this, 'dx_sanitized_links_options' ) );
	}
}
