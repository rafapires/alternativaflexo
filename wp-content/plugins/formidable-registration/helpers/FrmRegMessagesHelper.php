<?php

/**
 * @since 2.0
 */
class FrmRegMessagesHelper {

	/**
	 * Get the activation sent message
	 *
	 * @since 2.0
	 * @return string
	 */
	public static function activation_sent_message() {
		return  __( 'The activation e-mail has been sent to the e-mail address with which you registered. Please check your email and click on the link provided.', 'frmreg' );

	}

	/**
	 * Get the activation invalid key message
	 *
	 * @since 2.0
	 * @return string
	 */
	public static function activation_invalid_key_message() {
		return __( 'That activation link is invalid.', 'frmreg' );
	}

	/**
	 * Return the resend activation link message
	 *
	 * @since 2.0
	 *
	 * @param int $user_id
	 *
	 * @return string
	 */
	public static function resend_activation_message( $user_id ) {
		$resend_link = FrmRegModerationController::create_ajax_url( array(
			'action'  => 'resend_activation_link',
			'user_id' => $user_id,
		) );
		return sprintf( __( 'You have not confirmed your e-mail address. %1$sResend activation%2$s?', 'frmreg' ), '<a href="' . esc_url( $resend_link ) . '">', '</a>' );
	}

	/**
	 * Check if a code is a known error code
	 *
	 * @since 2.0
	 *
	 * @param string $code
	 *
	 * @return bool
	 */
	public static function is_known_error_code( $code ) {
		if ( in_array( $code, self::known_login_error_codes() ) ) {
			return true;
		} elseif ( self::is_resend_activation_link_code( $code ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if a code is a resend activation link code
	 *
	 * @since 2.0
	 *
	 * @param string $code
	 *
	 * @return bool
	 */
	public static function is_resend_activation_link_code( $code ) {
		return ( strpos( $code, 'resend_activation_' ) === 0 );
	}

	/**
	 * Return the known login error codes
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	private static function known_login_error_codes() {
		return array(
			'empty_username',
			'empty_password',
			'invalid_username',
			'incorrect_password',
		);
	}
}