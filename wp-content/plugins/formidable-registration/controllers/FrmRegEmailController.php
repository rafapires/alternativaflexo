<?php
/**
 * @since 2.01
 */

class FrmRegEmailController {

	/**
	 * Sends activation link to pending user
	 *
	 * @since 2.01
	 *
	 * @param int $user_id
	 * @param string $key
	 */
	public static function send_activation_email( $user_id, $key = '' ) {
		$email = new FrmRegEmail( $user_id, $key );
		$email->send();
	}

	/**
	 * Resend activation link to pending user
	 *
	 * @since 2.01
	 */
	public static function resend_activation_email() {
		if ( isset( $_GET['user_id'] ) && is_numeric( $_GET['user_id'] ) ) {

			$user_id = absint( $_GET['user_id'] );

			self::send_activation_email( $user_id, '' );

			$login_url = FrmRegLoginController::login_page_url( 'wordpress' );
			$login_url = add_query_arg( 'frm_message', 'activation_sent', $login_url );

			wp_redirect( $login_url );
		}
		exit();
	}
}