<?php

/**
 * @since 2.0
 */
class FrmRegProfileController {

	/**
	 * Show usermeta on profile page
	 */
	public static function show_user_meta() {
		global $profileuser;

		$meta_keys = array();

		// Get register user actions for all forms
		$register_actions = FrmFormAction::get_action_for_form( 'all', 'register' );

		foreach ( $register_actions as $opts ) {
			if ( ! isset( $opts->post_content['reg_usermeta'] ) || empty( $opts->post_content['reg_usermeta'] ) ) {
				continue;
			}

			foreach ( $opts->post_content['reg_usermeta'] as $user_meta_vars ) {
				$meta_keys[ $user_meta_vars['meta_name'] ] = $user_meta_vars['field_id'];
			}
		}

		//TODO: prevent duplicate user meta from showing

		if ( ! empty( $meta_keys ) ) {
			include( FrmRegAppHelper::path() . '/views/show_usermeta.php' );
		}
	}

	/**
	 * @deprecated 2.01
	 */
	public static function get_avatar( $avatar = '', $id_or_email, $size = '96', $default = '', $alt = false, $args = array() ) {
		_deprecated_function( __FUNCTION__, '2.01', 'FrmRegAvatarController::get_avatar' );
		return FrmRegAvatarController::get_avatar( $avatar, $id_or_email, $size, $default, $alt, $args );
	}

}