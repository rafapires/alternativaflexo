<?php

/**
 * @since 2.0
 */
class FrmRegEntryController{

	/**
	 * FrmRegEntryController constructor
	 *
	 * @since 2.0
	 */
	public function __construct() {
		add_action( 'frm_entry_form', array( $this, 'insert_hidden_fields' ), 10, 1 );

		if ( isset( $_POST['frm_register'] ) ) {
			new FrmRegEntry();
		}

	}

	/**
	 * Add hidden fields for email, username, and password to registration form
	 * These posted values will help with validation
	 *
	 * @since 2.0
	 * @param object $form
	 */
	public function insert_hidden_fields( $form ) {
		$settings = FrmRegActionHelper::get_registration_settings_for_form( $form );
		if ( empty( $settings ) ) {
			return;
		}

		$hidden_fields = array( 'email', 'username', 'password' );

		foreach ( $hidden_fields as $setting ) {
			if ( isset( $settings[ 'reg_' . $setting ] ) ) {
				$value = $settings[ 'reg_' . $setting ];
				include( FrmRegAppHelper::path() . '/views/hidden_input.php' );
			}
		}

		$this->insert_hidden_subsite_fields( $settings );

	}

	/**
	 * Insert hidden fields for the subsite title and subsite domain settings
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function insert_hidden_subsite_fields( $settings ) {
		if ( isset( $settings['create_subsite'] ) ) {

			$setting = 'subsite_title';
			$value = $settings[ $setting ];
			include( FrmRegAppHelper::path() . '/views/hidden_input.php' );

			$setting = 'subsite_domain';
			$value = $settings[ $setting ];
			include( FrmRegAppHelper::path() . '/views/hidden_input.php' );
		}
	}
}