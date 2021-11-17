<?php

/**
 * A class for managing plugin dependencies and loading the plugin.
 *
 * @package    StudentCTP
 * @author     Martin Nestorov
 */
class SCPT_Bootstrap {

	/**
	 * Registering all classes that power the plugin
	 */
	protected $loader;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'dx_include' ), 10 );
		add_action( 'init', array( $this, 'dx_run' ), 0 );
	}

	/**
	 * Includes all the plugin classes with priority
	 */
	public function dx_include() {
		// Include the classes.
		require_once 'class-student-cpt.php';
		require_once 'class-student-sidebar.php';
		require_once 'class-student-widget.php';
	}

	/**
	 * Instantiate our plugin classes
	 */
	public function dx_run() {
		$this->loader = new StudentCPT();
		$this->loader = new StudentSidebar();
		$this->loader = new StudentWidget();
	}
}
