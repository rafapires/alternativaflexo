<?php
/**
 * @since 2.01
 */

class FrmRegRegistrationPageController {

	/**
	 * Redirect to custom registration page if selected in global settings
	 *
	 * @since 2.01
	 */
	public static function redirect_to_custom_registration_page() {
		if ( 'GET' == $_SERVER[ 'REQUEST_METHOD' ] ) {
			$redirect_url = self::reset_password_page_url( 'none' );

			if ( $redirect_url ) {
				wp_redirect( $redirect_url );
				exit;
			}
		}
	}

	/**
	 * Get the registration page URL
	 *
	 * @since 2.01
	 * @param string $fallback
	 *
	 * @return false|string
	 */
	private static function reset_password_page_url( $fallback = 'wordpress' ) {
		$page_id = self::registration_page_id();

		if ( $page_id ) {
			$page_url = get_permalink( $page_id );
		} else if ( $fallback === 'wordpress' ) {
			$page_url = site_url( 'wp-login.php?action=register' );
		} else {
			$page_url = '';
		}

		return $page_url;
	}

	/**
	 * Get the global reset password page ID
	 *
	 * @since 2.01
	 * @return string
	 */
	private static function registration_page_id() {
		$global_settings = new FrmRegGlobalSettings;
		return $global_settings->get_global_page( 'register_page' );
	}

}