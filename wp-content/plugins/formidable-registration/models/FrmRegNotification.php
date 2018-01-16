<?php

class FrmRegNotification {

	/**
	 * @deprecated 2.01
	 *
	 * @param int $form_id
	 * @param int $entry_id
	 */
	public static function trigger_after_registration_actions( $form_id, $entry_id ) {
		_deprecated_function( __FUNCTION__, '2.01', 'FrmRegActionController::trigger_after_registration_actions' );
		FrmRegActionController::trigger_after_registration_actions( $form_id, $entry_id );
	}

	/**
	 * @deprecated 2.01
	 *
	 * @param integer $user_id
	 * @param string $key
	 */
	public static function new_user_activation_notification( $user_id, $key = '' ) {
		_deprecated_function( __FUNCTION__, '2.01', 'FrmRegEmailController::send_activation_email' );
		FrmRegEmailController::send_activation_email( $user_id, $key );
	}

	/**
	 * @return string
	 */
	public static function set_html_content_type() {
		_deprecated_function( __FUNCTION__, '2.01', 'custom code' );

		return 'text/html';
	}

	/**
	 * @deprecated 2.01
	 */
	public static function send_all_notifications( $user ) {
		_deprecated_function( __FUNCTION__, '2.01', 'FrmRegActionController::trigger_after_registration_actions_for_user' );
		FrmRegActionController::trigger_after_registration_actions_for_user( $user );
	}

	/**
	 * @deprecated 2.01
	 */
	public static function resend_activation_notification() {
		_deprecated_function( __FUNCTION__, '2.01', 'FrmRegEmailController::resend_activation_email' );
		FrmRegEmailController::resend_activation_email();
	}

	/**
	 * @deprecated 2.0
	 */
	public static function new_user_notification() {
		_deprecated_function( __FUNCTION__, '2.0', 'an email action' );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function send_paid_user_notification() {
		_deprecated_function( __FUNCTION__, '2.0', 'an email action' );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function stop_entry_create_emails() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}
}