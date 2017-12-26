<?php

/**
 * @since 2.0
 */
class FrmRegActionHelper {

	/**
	 * Get the default options for a new Register User action
	 *
	 * @since 2.0
	 * @return array
	 */
	public static function get_default_options() {
		return array(
			'registration'     => 0,
			'login'            => 0,
			'reg_avatar'       => '',
			'reg_username'     => '',
			'reg_email'        => '',
			'reg_password'     => '',
			'reg_last_name'    => '',
			'reg_first_name'   => '',
			'reg_display_name' => '',
			'reg_user_url'     => '',
			'reg_role'         => 'subscriber',
			'reg_usermeta'     => array(),
			'reg_moderate'     => array(),
			'reg_redirect'     => '',
			'reg_create_users' => '',
			'reg_create_role'  => array(),
			'event'            => array( 'create', 'update' ),
			'create_subsite'   => 0,
			'subsite_title'    => 'username',
			'subsite_domain'   => 'blog_title',
		);
	}

	/**
	 * Check if any registration actions exist in database
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	public static function registration_action_exists_in_db() {
		$where = array(
			'post_type'    => FrmFormActionsController::$action_post_type,
			'post_excerpt' => 'register',
			'post_status' => 'publish',
		);

		$action_id = FrmDb::get_var( 'posts', $where, 'ID', array(), 1 );

		return $action_id !== null;
	}

	/**
	 * Get the registration settings for a given form
	 *
	 * @since 2.0
	 *
	 * @param object|int|boolean $form
	 *
	 * @return array
	 */
	public static function get_registration_settings_for_form( $form ) {
		if ( is_numeric( $form ) ) {
			$form_id = $form;
		} else if ( is_object( $form ) ) {
			$form_id = $form->id;
		} else {
			return array();
		}

		global $frm_vars;
		if ( ! isset( $frm_vars['reg_settings'] ) ) {
			$frm_vars['reg_settings'] = array();
		}

		if ( isset( $frm_vars['reg_settings'][ $form_id ] ) ) {
			return $frm_vars['reg_settings'][ $form_id ];
		}

		// check for registration action
		$action = FrmFormAction::get_action_for_form( $form_id, 'register', 1 );
		if ( $action ) {
			$frm_vars['reg_settings'][ $form_id ] = $settings = $action->post_content;
		} else {
			$frm_vars['reg_settings'][ $form_id ] = $settings = array();
		}

		return $settings;
	}

	/**
	 * Check if auto login option should be visible or not
	 *
	 * @since 2.0
	 *
	 * @param object $register_action
	 *
	 * @return bool
	 */
	public static function is_auto_login_visible( $register_action ) {
		$settings = $register_action->post_content;
		$password_option = isset( $settings['reg_password'] ) ? $settings['reg_password'] : 'nothing';

		if ( $password_option === '' || $password_option === 'nothing' ) {
			$show_auto_login = false;
		} else {
			$show_auto_login = true;
		}

		return $show_auto_login;
	}
}