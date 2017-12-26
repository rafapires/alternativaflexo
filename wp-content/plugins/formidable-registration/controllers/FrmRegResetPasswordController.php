<?php

/**
 * @since 2.0
 */
class FrmRegResetPasswordController {

	/**************************************************
	 * Lost Password Functions
	 **************************************************/

	/**
	 * Redirect to custom lost password page if selected in global settings
	 *
	 * @since 2.0
	 */
	public static function redirect_to_custom_lost_password() {
		if ( 'GET' == $_SERVER[ 'REQUEST_METHOD' ] ) {
			$redirect_url = self::reset_password_page_url( 'none' );

			if ( $redirect_url ) {
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}

	/**
	 * Initiates a password reset if either a global reset password page or
	 * a global login page is selected
	 *
	 * @since 2.0
	 */
	public static function do_lost_password() {
		if ( ! self::is_global_reset_password_page_set() && ! FrmRegLoginController::is_global_login_page_set() ) {
			return;
		}

		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {

			// Attempt to send reset password email
			$errors = retrieve_password();

			if ( is_wp_error( $errors ) ) {
				// Errors found
				self::lost_password_redirect_with_errors( $errors );

			} else {
				// Email sent
				self::lost_password_redirect_no_errors();
			}
		}
	}

	/**
	 * Do a redirect from the lost password page when there are errors
	 *
	 * @since 2.0
	 * @param WP_Error $errors
	 */
	private static function lost_password_redirect_with_errors( $errors ) {
		$query_args = array( 'errors' => join( ',', $errors->get_error_codes() ) );
		self::redirect_to_selected_reset_password_page( $query_args );
	}

	/**
	 * Do a redirect from the lost password page when there are no errors
	 *
	 * @since 2.0
	 */
	private static function lost_password_redirect_no_errors() {
		$redirect_url = FrmRegLoginController::login_page_url( 'wordpress' );

		if ( strpos( $redirect_url, 'wp-login.php' ) !== false ) {
			$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
		} else {
			$redirect_url = add_query_arg( 'frm_message', 'check_email', $redirect_url );
		}

		wp_redirect( $redirect_url );
		exit;
	}

	/*********************************************************
	 * Reset password
	 ********************************************************/

	/**
	 * Redirect to custom reset password page if it is selected in global settings
	 *
	 * @since 2.0
	 */
	public static function redirect_to_custom_reset_password() {
		if ( ! self::is_global_reset_password_page_set() ) {
			return;
		}

		if ( 'GET' == $_SERVER[ 'REQUEST_METHOD' ] ) {

			if ( ! isset( $_REQUEST[ 'key' ] ) || ! isset( $_REQUEST[ 'login' ] ) ) {
				self::redirect_to_selected_reset_password_page();

			} else {

				// Verify key / login combo
				$user = check_password_reset_key( $_REQUEST[ 'key' ], $_REQUEST[ 'login' ] );

				if ( ! $user || is_wp_error( $user ) ) {

					$query_args = self::get_reset_password_query_args_from_user( $user );
					self::redirect_to_selected_reset_password_page( $query_args );

				} else {

					$query_args = array(
						'login' => esc_attr( $_REQUEST[ 'login' ] ),
						'key'   => esc_attr( $_REQUEST[ 'key' ] ),
					);

					self::redirect_to_selected_reset_password_page( $query_args );
				}
			}
		}
	}

	/**
	 * Redirect to the selected reset password page
	 * No redirect occurs if global page is not selected
	 *
	 * @since 2.0
	 * @param array $query_args
	 */
	private static function redirect_to_selected_reset_password_page( $query_args = array() ) {
		$redirect_url = self::reset_password_page_url( 'none' );

		if ( $redirect_url ) {

			foreach ( $query_args as $key => $value ) {
				$redirect_url = add_query_arg( $key, $value, $redirect_url );
			}

			wp_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Get the reset password query args from the error object
	 *
	 * @since 2.0
	 *
	 * @param WP_Error $error
	 *
	 * @return array
	 */
	private static function get_reset_password_query_args_from_user( $error ) {
		if ( $error && $error->get_error_code() === 'expired_key' ) {
			$query_args = array( 'errors' => 'expiredkey' );
		} else {
			$query_args = array( 'errors' => 'invalidkey' );
		}

		return $query_args;
	}

	/**
	 * Resets the user's password if the password reset form was submitted and if global reset password page is selected
	 *
	 * @since 2.0
	 */
	public static function do_reset_password() {
		if ( ! self::is_global_reset_password_page_set() ) {
			return;
		}

		if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] && isset( $_REQUEST[ 'rp_key' ] ) && isset( $_REQUEST[ 'rp_login' ] ) ) {
			$rp_key   = $_REQUEST[ 'rp_key' ];
			$rp_login = $_REQUEST[ 'rp_login' ];

			$user = check_password_reset_key( $rp_key, $rp_login );

			if ( ! $user || is_wp_error( $user ) ) {
				$query_args = self::get_reset_password_query_args_from_user( $user );
				FrmRegLoginController::redirect_to_selected_login_page( $query_args );

			} else {
				if ( isset( $_POST[ 'pass1' ] ) ) {

					self::redirect_if_passwords_not_equal( $rp_key, $rp_login );
					self::redirect_if_empty_password( $rp_key, $rp_login );
					self::reset_password_and_redirect( $user );

				} else {
					echo __( 'Invalid request.', 'frmreg' );
				}
			}
		}
	}

	/**
	 * Redirect from reset password page when passwords are not equal
	 *
	 * @since 2.0
	 * @param string $rp_key
	 * @param string $rp_login
	 */
	private static function redirect_if_passwords_not_equal( $rp_key, $rp_login ) {
		if ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] ) {

			$query_args = array(
				'key'   => $rp_key,
				'login' => $rp_login,
				'errors' => 'password_reset_mismatch',
			);

			self::redirect_to_selected_reset_password_page( $query_args );
		}
	}

	/**
	 * If password is empty, redirect to reset password page with error parameters
	 *
	 * @param $rp_key
	 * @param $rp_login
	 */
	private static function redirect_if_empty_password( $rp_key, $rp_login ) {
		if ( empty( $_POST[ 'pass1' ] ) ) {
			$query_args = array(
				'key'   => $rp_key,
				'login' => $rp_login,
				'errors' => 'password_reset_empty',
			);
			self::redirect_to_selected_reset_password_page( $query_args );
		}
	}

	/**
	 * Reset password and redirect from reset password page if no errors
	 *
	 * @since 2.0
	 *
	 * @param object $user
	 */
	private static function reset_password_and_redirect( $user ) {
		reset_password( $user, $_POST[ 'pass1' ] );

		$redirect_url = FrmRegLoginController::login_page_url( 'wordpress' );

		if ( strpos( $redirect_url, 'wp-login.php' ) === false ) {
			$redirect_url = add_query_arg( 'frm_message', 'pw_changed', $redirect_url );
		}

		wp_redirect( $redirect_url );
		exit;
	}

	/**
	 * Check of a global reset password page is set
	 *
	 * @since 2.0
	 * @return string
	 */
	private static function is_global_reset_password_page_set() {
		return ( self::reset_password_page_id() );
	}

	/**
	 * Get the global reset password page ID
	 *
	 * @since 2.0
	 * @return string
	 */
	private static function reset_password_page_id() {
		$global_settings = new FrmRegGlobalSettings;
		return $global_settings->get_global_page( 'resetpass_page' );
	}

	/**
	 * Get the reset password page URL
	 *
	 * @since 2.0
	 * @param string $fallback
	 *
	 * @return false|string
	 */
	private static function reset_password_page_url( $fallback = 'wordpress' ) {
		$page_id = self::reset_password_page_id();

		if ( $page_id ) {
			$page_url = get_permalink( $page_id );
		} else if ( $fallback === 'wordpress' ) {
			$page_url = site_url( 'wp-login.php?action=resetpass' );
		} else {
			$page_url = '';
		}

		return $page_url;
	}

	/**
	 * Prevent "pending" users from resetting their password
	 *
	 * @param bool $allow
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public static function prevent_password_reset( $allow, $user_id ) {
		$user = get_user_by( 'id', $user_id );

		if ( in_array( 'pending', (array) $user->roles ) ) {
			return false;
		}

		return $allow;
	}

}