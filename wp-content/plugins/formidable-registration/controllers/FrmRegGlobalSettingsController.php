<?php

/**
 * @since 2.0
 */
class FrmRegGlobalSettingsController{

	/**
	 * Global settings object
	 *
	 * @since 2.0
	 * @var FrmRegGlobalSettings
	 */
	private $settings;

	/**
	 * Track if form has been checked for errors
	 *
	 * @since 2.0
	 * @var boolean
	 */
	private $checked = false;

	/**
	 * Errors in global registration settings
	 *
	 * @since 2.0
	 * @var array
	 */
	private $errors = array();

	/**
	 * Current form action
	 *
	 * @since 2.0
	 * @var string
	 */
	private $action = '';

	/**
	 * Current form tab
	 *
	 * @since 2.0
	 * @var string
	 */
	private $current_tab = '';

	/**
	 * FrmRegGlobalSettingsController constructor
	 *
	 * @since 2.0
	 */
	public function __construct() {
		$page = FrmAppHelper::get_param( 'page' );
		if ( $page !== 'formidable-settings' ) {
			return;
		}

		add_action( 'frm_add_settings_section', array( $this, 'add_settings_section' ) );
		add_filter( 'frm_validate_settings', array( $this, 'get_errors' ) );

		$this->set_action();
		$this->current_tab = FrmAppHelper::get_param( 't' );
		$this->settings = new FrmRegGlobalSettings();
	}

	/**
	 * Set the action property
	 *
	 * @since 2.0
	 */
	private function set_action() {
		$action_parameter = isset( $_REQUEST['frm_action'] ) ? 'frm_action' : 'action';
		$this->action = FrmAppHelper::get_param( $action_parameter );
	}

	/**
	 * Add Registration tab in Global Settings
	 * Attach function to that tab
	 *
	 * @since 1.11
	 *
	 * @param array $sections
	 * @return array $sections
	 */
	public function add_settings_section( $sections ) {
		$sections['registration'] = array( 'class' => $this, 'function' => 'route' );
		return $sections;
	}

	/**
	 * Display global registration settings and update them, if needed
	 */
	public function route(){
		if ( $this->is_registration_tab_submitted() ) {

			if ( $this->checked === false ) {
				$this->errors = $this->settings->validate( $_POST );
			}

			if ( empty( $this->errors ) ) {
				$this->settings->update( $_POST );
			}
		}

		$this->display_form();
	}

	/**
	 * Get errors for global settings form
	 *
	 * @since 2.0
	 *
	 * @param array $errors
	 *
	 * @return array
	 */
	public function get_errors( $errors ) {
		if ( $this->is_registration_tab_submitted() ) {
			$this->errors = $this->settings->validate( $_POST );
			$errors = array_merge( $errors, $this->errors );

			$this->checked = true;
		}

		return $errors;
	}

	/**
	 * Check if registration tab is open and Update was just clicked
	 *
	 * @since 2.0
	 * @return bool
	 */
	private function is_registration_tab_submitted() {
		return ( 'process-form' === $this->action && 'registration_settings' === $this->current_tab );
	}

	/**
	 * Display form on Global Settings page
	 */
	private function display_form(){
		$global_settings = $this->settings;
		include( FrmRegAppHelper::path() . '/views/global_settings.php' );
	}
}