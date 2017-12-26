<?php
/**
 * @since 2.01
 */

class FrmRegModerationHelper {

	/**
	 * Generate an activation key and save it for user
	 *
	 * @since 2.01
	 *
	 * @param string $username
	 *
	 * @return string
	 */
	public static function generate_activation_key( $username ) {
		$key = wp_generate_password( 20, false );

		// Set the activation key for the user
		global $wpdb;
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $username ) );

		return $key;
	}
}