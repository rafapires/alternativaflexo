<?php

class FrmRegLostPWForm extends FrmRegForm{

	protected $path = '/views/lost_password_form.php';

	public function __construct( $atts ) {
		parent::__construct( $atts );

		$this->init_description();
		$this->init_submit_text( $atts );
	}

	/**
	 * Set the form description
	 *
	 * @since 2.0
	 */
	protected function init_description() {
		$global_settings = new FrmRegGlobalSettings;
		$this->description = $global_settings->get_global_message( 'lost_password' );
	}

	/**
	 * Set the submit button text
	 *
	 * @since 2.0
	 * @param array $atts
	 */
	protected function init_submit_text( $atts ) {
		if ( isset( $atts['lostpass_button'] ) && $atts['lostpass_button'] ) {
			$this->submit_text = $atts['lostpass_button'];
		} else {
			$this->submit_text = __( 'Get New Password', 'frmreg' );
		}
	}

	/**
	 * Get the user login field ID
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_field_id() {
		return 'user_login_' . $this->form_number;
	}

	/**
	 * Get the error message for a form
	 *
	 * @since 2.0
	 * @param string $error_code
	 *
	 * @return string
	 */
	protected function get_error_message( $error_code ) {
		switch ( $error_code ) {

			case 'empty_username':
				$message = __( 'Please enter a username or email address to continue.', 'frmreg' );
				break;
			case 'invalid_email':
				$message = __( 'There are no users registered with this email address.', 'frmreg' );
				break;
			case 'invalidcombo':
				$message = __( 'Please enter a valid email address or username.', 'frmreg' );
				break;
			case 'invalidkey' :
				$message = __( 'Your password reset link appears to be invalid. Please request a new link below.', 'frmreg' );
				break;
			case 'expiredkey' :
				$message = __( 'Your password reset link has expired. Please request a new link below.', 'frmreg' );
				break;
			default:
				$message = __( 'An unknown error occurred. Please try again later.', 'frmreg' );
		}

		return $message;
	}
}