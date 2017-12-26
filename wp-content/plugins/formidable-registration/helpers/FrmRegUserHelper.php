<?php

/**
 * @since 2.0
 */
class FrmRegUserHelper {

	/**
	 * Log a user in if the "Login" option is selected and auto-generate password is not selected
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param FrmRegUser $user
	 */
	public static function log_user_in( $settings, $user ) {
		if ( ! isset( $settings['login'] ) ) {
			return;
		}

		if ( self::should_log_user_in( $settings ) && ! is_user_logged_in() ) {

			$_POST['log'] = $user->get_username();
			$_POST['pwd'] = $user->get_password();

			wp_signon();
		}
	}

	/**
	 * Check settings to see if auto login option is checked and password option is mapped to field
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public static function should_log_user_in( $settings ) {
		return ( isset( $settings['login'] ) && $settings['login']
		         && isset( $settings['reg_password'] ) && is_numeric( $settings['reg_password'] ) );
	}

}