<?php

/**
 * @since 2.0
 */
class FrmRegLoginController {

	/**
	 * Redirect the user to the custom login page instead of wp-login.php
	 *
	 * @since 2.0
	 */
	public static function redirect_to_custom_login() {
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' && ! isset( $_GET['interim-login'] ) ) {

			$redirect_url = self::login_page_url( 'none' );

			if ( ! $redirect_url ) {
				return;
			}

			if ( ! empty( $_REQUEST['redirect_to'] ) ) {
				$redirect_url = add_query_arg( 'redirect_to', $_REQUEST['redirect_to'], $redirect_url );
			}

			if ( ! empty( $_REQUEST['checkemail'] ) ) {
				$redirect_url = add_query_arg( 'checkemail', $_REQUEST['checkemail'], $redirect_url );
			}

			wp_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 *
	 * @since 2.0
	 * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	public static function redirect_at_authenticate_when_error( $user ) {
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! isset( $_POST['interim-login'] ) ) {
			$login_url = self::login_page_url( 'none' );

			if ( $login_url && is_wp_error( $user ) ) {

				self::add_error_code_to_query_string( $user, $login_url );
				self::add_error_message_text_to_query_string( $user, $login_url );
				self::add_posted_redirect_to_query_string( $login_url );

				wp_redirect( $login_url );
				exit;
			}
		}

		return $user;
	}

	/**
	 * Add the error code to a URL
	 *
	 * @since 2.0
	 *
	 * @param WP_Error $error
	 * @param string $login_url
	 */
	private static function add_error_code_to_query_string( $error, &$login_url ) {
		$error_code = self::get_error_code( $error );
		$login_url = add_query_arg( 'frmreg_error', $error_code, $login_url );
	}

	/**
	 * @param WP_Error $error
	 *
	 * @return mixed
	 */
	private static function get_error_code( $error ) {
		$error_codes = $error->get_error_codes();
		return reset( $error_codes );
	}

	/**
	 * Add an error's message text to query string if it is an unknown error code
	 *
	 * @since 2.0
	 *
	 * @param WP_Error $error
	 * @param string $login_url
	 */
	private static function add_error_message_text_to_query_string( $error, &$login_url ) {
		$error_code = self::get_error_code( $error );

		if ( ! FrmRegMessagesHelper::is_known_error_code( $error_code ) ) {
			$error_message = urlencode( $error->get_error_message() );
			$login_url = add_query_arg( 'frm_message_text', $error_message, $login_url );
		}
	}

	/**
	 * Add posted redirect_to parameter to query args
	 *
	 * @since 2.0
	 * @param $login_url
	 */
	private static function add_posted_redirect_to_query_string( &$login_url ) {
		if ( isset( $_POST['redirect_to'] ) && $_POST['redirect_to'] ) {
			$login_url = add_query_arg( 'redirect_to', $_POST['redirect_to'], $login_url );
		}
	}

	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @since 2.0
	 *
	 * @param string $redirect_to URL to redirect to
	 * @param string $request URL the user is coming from
	 * @param object $user
	 *
	 * @return string
	 */
	public static function redirect_after_login( $redirect_to, $request, $user ) {
		// TODO: maybe add global setting for this

		return $redirect_to;
	}

	/**
	 * Check if a global login page is set
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function is_global_login_page_set() {
		return ( self::login_page_id() );
	}

	/**
	 * Get global login page ID
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function login_page_id() {
		$global_settings = new FrmRegGlobalSettings();
		return $global_settings->get_global_page( 'login_page' );
	}

	/**
	 * Get the login page URL. If none is selected in global settings, return default login URL or blank.
	 *
	 * @since 2.0
	 *
	 * @param string $fallback
	 *
	 * @return string
	 */
	public static function login_page_url( $fallback ) {
		$page_id = self::login_page_id();

		if ( $page_id ) {
			$login_url = get_permalink( $page_id );
		} else if ( $fallback === 'wordpress' ) {
			$login_url = wp_login_url();
		} else {
			$login_url = '';
		}

		return $login_url;
	}

	/**
	 * Redirect to the selected login page
	 * No redirect occurs if global page is not selected
	 *
	 * @param array $query_args
	 */
	public static function redirect_to_selected_login_page( $query_args = array() ) {
		$redirect_url = self::login_page_url( 'none' );

		if ( $redirect_url ) {

			foreach ( $query_args as $key => $value ) {
				$redirect_url = add_query_arg( $key, $value, $redirect_url );
			}

			wp_redirect( $redirect_url );
			exit;
		}
	}

	/**
	 * Print success message on standard wp-login page when activation link is resent
	 * This function will only apply when users do not select a global login/logout page in their global settings
	 *
	 * @since 1.11
	 *
	 * @param string $message
	 * @return string $message
	 */
	public static function print_login_messages( $message ) {
		if ( isset( $_GET['frm_message'] ) && $_GET['frm_message'] === 'activation_sent' ) {
			$message = '<p class="message">' . FrmRegMessagesHelper::activation_sent_message() . '</p>';
		} else if ( isset( $_GET['frmreg_error'] ) && $_GET['frmreg_error'] === 'invalid_key' ) {
			$message = '<div id="login_error">' . FrmRegMessagesHelper::activation_invalid_key_message() . '</div>';
		}

		return $message;
	}

	/**
	 * Prevent "pending" users from logging in
	 *
	 * @param WP_User $user
	 *
	 * @return WP_User|WP_Error
	 */
	public static function prevent_pending_login( $user ) {
		//If user has "Pending" role, don't let them in
		if ( in_array( 'pending', (array) $user->roles ) ) {
			$moderate_type = (array) get_user_meta( $user->ID, 'frmreg_moderate', 1 );

			if ( in_array( 'email', $moderate_type ) ) {
				return new WP_Error( 'resend_activation_' . $user->ID, FrmRegMessagesHelper::resend_activation_message( $user->ID ) );
			}
		}

		return $user;
	}

}