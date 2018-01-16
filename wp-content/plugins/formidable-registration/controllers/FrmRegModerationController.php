<?php

/**
 * @since 2.0
 */
class FrmRegModerationController {

	/**
	 * Check if settings have any user moderation selected
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 *
	 * @return bool
	 */
	public static function needs_moderation( $settings ) {
		return ( isset ( $settings['reg_moderate'] ) && ! empty( $settings['reg_moderate'] ) );
	}

	/**
	 * Moderate a user
	 *
	 * @since 2.0
	 *
	 * @param FrmRegUser $user
	 * @param array $settings
	 * @param object $entry
	 */
	public static function moderate_user( $user, $settings, $entry ) {
		self::set_user_role_to_pending( $user->get_user_id() );

		self::add_moderation_user_meta( $settings, $user, $entry );

		// Go through the 2 different types of moderation
		self::send_activation_email( $settings, $user );
	}

	/**
	 * Set a user's role to pending
	 *
	 * @since 2.0
	 *
	 * @param int $user_id
	 */
	private static function set_user_role_to_pending( $user_id ) {
		self::add_pending_role();

		wp_update_user( array( 'ID' => $user_id, 'role' => 'pending' ) );
	}

	/**
	 * Check if Pending role exists, add it if it doesn't
	 *
	 * @since 2.0
	 */
	private static function add_pending_role() {
		global $wp_roles;

		$roles = $wp_roles->roles;
		if ( ! array_key_exists( 'pending', $roles ) ) {
			add_role( 'pending', 'Pending', array() );
		}
	}

	/**
	 * Add user meta for a moderated user
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param FrmRegUser $user
	 * @param object $entry
	 */
	private static function add_moderation_user_meta( $settings, $user, $entry ) {
		$user_id     = $user->get_user_id();
		$future_role = $user->get_role();

		//Add user meta to specify the types of moderation that user needs
		add_user_meta( $user_id, 'frmreg_moderate', $settings['reg_moderate'] );

		//Add user meta to specify the user's future role
		add_user_meta( $user_id, 'frmreg_future_role', $future_role );

		//Add user meta to store the entry ID
		add_user_meta( $user_id, 'frmreg_entry_id', $entry->id );

		// Add user meta to store the form ID
		add_user_meta( $user_id, 'frmreg_form_id', $entry->form_id );
	}

	/**
	 * If the email confirmation option is set, send the confirmation email
	 *
	 * @param array $settings
	 * @param FrmRegUser $user
	 *
	 * @since 2.0
	 */
	private static function send_activation_email( $settings, $user ) {
		// TODO: check how WordPress does this with multi-site

		if ( in_array( 'email', $settings['reg_moderate'] ) ) {

			$key = FrmRegModerationHelper::generate_activation_key( $user->get_username() );

			FrmRegEmailController::send_activation_email( $user->get_user_id(), $key );
		}
	}

	/**
	 * Check if activation link is valid. If it is, activate user.
	 *
	 * @since 2.0
	 */
	public static function do_activation_link() {
		$login_url = FrmRegLoginController::login_page_url( 'wordpress' );

		if ( is_user_logged_in() ) {
			wp_redirect( esc_url_raw( $login_url ) );
			exit();
		}

		$user_from_link = self::get_user_from_activation_link();

		if ( $user_from_link ) {

			if ( in_array( 'pending', (array) $user_from_link->roles ) ) {

				if ( self::is_activation_key_match_for_user( $user_from_link ) ) {

					// Activate user
					$moderate = self::activate_user( 'email', $user_from_link->ID );
					self::log_user_in_without_password( $user_from_link->ID );
					$redirect = self::get_redirect_for_activated_user( $user_from_link->ID, $moderate );

				} else {
					$redirect  = add_query_arg( 'frmreg_error', 'invalid_key', $login_url );
				}
			} else {
				$redirect  = add_query_arg( 'frmreg_msg', 'clicked', $login_url );
			}
		} else {
			$redirect  = add_query_arg( 'frmreg_error', 'invalid_key', $login_url );
		}

		wp_redirect( esc_url_raw( $redirect ) );
		exit();
	}

	/**
	 * Check if the current activation key matches the specified user's activation key
	 *
	 * @since 2.01.0
	 *
	 * @param WP_User $user
	 *
	 * @return bool
	 */
	private static function is_activation_key_match_for_user( $user ) {
		$is_match = false;
		$key = self::get_activation_link_parameter( 'key' );

		if ( $key === '' ) {
			return $is_match;
		}

		global $wpdb;
		$key = preg_replace( '/[^a-z0-9]/i', '', $key );

		$raw_query = "SELECT ID FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s";
		$key_user      = $wpdb->get_row( $wpdb->prepare( $raw_query, $key, $user->user_login ) );

		if ( (int) $key_user->ID === $user->ID ) {
			$is_match = true;
		}

		return $is_match;
	}

	/**
	 * Log user in if auto-login setting is checked and password is already set by user
	 *
	 * @since 2.0
	 *
	 * @param int $user_id
	 */
	private static function log_user_in_without_password( $user_id ) {
		if ( ! is_user_logged_in() ) {
			$settings = self::get_registration_settings_for_user( $user_id );

			if ( FrmRegUserHelper::should_log_user_in( $settings ) ) {
				wp_set_auth_cookie( $user_id );
			}
		}
	}

	/*
    * Create ajax URL
    *
    * Since 1.11
    *
    * @param array of URL parameters
    * @return string
    */
	public static function create_ajax_url( $params ) {
		if ( is_array( $params ) && isset( $params['action'] ) && $params['action'] ) {
			$site_url = admin_url( 'admin-ajax.php' );
			$ajax_url = add_query_arg( $params, $site_url );
		} else {
			$ajax_url = false;
		}

		return $ajax_url;
	}

	/**
	 * Get a user from the login and key parameters in activation link
	 *
	 * @since 2.0
	 *
	 * @return WP_User|boolean
	 */
	private static function get_user_from_activation_link() {
		if ( is_user_logged_in() ) {
			return false;
		}

		$login = self::get_activation_link_parameter( 'login' );

		if ( $login !== '' ) {
			$user = get_user_by( 'login', $login );
		} else {
			$user = false;
		}

		return $user;
	}

	/**
	 * Get a parameter from the activation link
	 *
	 * @since 2.0
	 *
	 * @param string $parameter
	 *
	 * @return string
	 */
	private static function get_activation_link_parameter( $parameter ) {
		return isset( $_GET[ $parameter ] ) && is_string( $_GET[ $parameter ] ) ? sanitize_text_field( $_GET[ $parameter ] ) : '';
	}

	/**
	 * Get the redirect URL for an activated, or partially activated, user from the form settings
	 *
	 * @since 2.0
	 *
	 * @param int $user_id
	 * @param array|boolean $moderation
	 *
	 * @return string
	 */
	private static function get_redirect_for_activated_user( $user_id, $moderation ) {
		// Get redirect URL from form settings
		$form_settings = self::get_registration_settings_for_user( $user_id );
		if ( isset( $form_settings['reg_redirect'] ) && $form_settings['reg_redirect'] ) {
			$redirect = get_permalink( $form_settings['reg_redirect'] );
		} else {
			$redirect = FrmRegLoginController::login_page_url( 'wordpress' );
		}

		if ( self::is_moderation_complete( $moderation ) ) {
			$params = array( 'frm_message' => 'complete', 'user' => $user_id );
			$redirect = add_query_arg( $params, $redirect );
		}

		return $redirect;
	}

	/**
	 * Check if moderation is complete
	 *
	 * @since 2.0
	 *
	 * @param array|boolean $moderation
	 *
	 * @return bool
	 */
	private static function is_moderation_complete( $moderation ) {
		return $moderation === false;
	}

	/**
	 * Activate the user partially or completely, depending on moderation needed
	 *
	 * @since 2.0
	 *
	 * @param string $moderation_type
	 * @param int $user_id
	 *
	 * @return array|bool
	 */
	private static function activate_user( $moderation_type, $user_id ) {
		$user = new WP_User( $user_id );

		// Check which moderation user needs
		$needs_moderation = (array) get_user_meta( $user_id, 'frmreg_moderate', 1 );

		if ( in_array( $moderation_type, $needs_moderation ) && count( $needs_moderation ) > 1 ) {
			// If current moderation is NOT the only moderation type needed
			$mod_key = array_search( $moderation_type, $needs_moderation );
			unset( $needs_moderation[ $mod_key ] );

			// Update moderation user meta
			update_user_meta( $user_id, 'frmreg_moderate', $needs_moderation );

		} else if ( in_array( $moderation_type, $needs_moderation ) ) {
			// If current moderation is the only moderation type left

			self::set_new_role( $user );
			self::after_activate_user( $moderation_type, $user );

			$needs_moderation = false;
		}

		return $needs_moderation;
	}

	/**
	 * Set the user's role so they are no longer pending
	 *
	 * @since 2.0
	 *
	 * @param WP_User $user
	 */
	private static function set_new_role( $user ) {
		$user_role = get_user_meta( $user->ID, 'frmreg_future_role', 1 );
		if ( ! $user_role ) {
			$user_role = 'subscriber';
		}

		// Officially activate user
		$user->set_role( $user_role );
	}

	/**
	 * Clean up unneeded user meta after activating user
	 *
	 * @since 2.0
	 *
	 * @param string $moderation_type
	 * @param object $user
	 */
	private static function after_activate_user( $moderation_type, $user ) {
		// Clear the activation key
		if ( $moderation_type == 'email' ) {
			global $wpdb;
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $user->user_login ) );
		}

		FrmRegActionController::trigger_after_registration_actions_for_user( $user );

		// Trigger after create user action hook
		$settings = self::get_registration_settings_for_user( $user->ID );
		$entry = FrmEntry::getOne( get_user_meta( $user->ID, 'frmreg_entry_id', true ) );
		do_action( 'frmreg_after_create_user', $user->ID, array( 'settings' => $settings, 'entry' => $entry ) );

		// Delete moderation user meta
		delete_user_meta( $user->ID, 'frmreg_future_role' );
		delete_user_meta( $user->ID, 'frmreg_moderate' );
		delete_user_meta( $user->ID, 'frmreg_entry_id' );
	}

	/**
	 * Print activation messages for fully activated user
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public static function print_activation_messages( $content ) {
		if ( ! is_singular() && is_main_query() ) {
			return $content;
		}

		if ( isset( $_GET['frm_message'] ) && $_GET['frm_message'] == 'complete'
		     && isset( $_GET['user'] ) && is_numeric( $_GET['user'] ) ) {

			$user = new WP_User( $_GET['user'] );

			$settings = self::get_registration_settings_for_user( $user->ID );
			if ( empty( $settings ) ) {
				return $content;
			}

			if ( is_user_logged_in() ) {
				$message = __( 'Your account is now active. Enjoy!', 'frmreg' );

				// If user set their own password
			} else if ( isset ( $settings['reg_password'] ) && $settings['reg_password'] ) {
				$message = __( 'Your account has been activated. You may now log in.', 'frmreg' );

				// If password is automatically generated
			} else {
				$message = __( 'Your account has been activated. Please check your e-mail for a link to set your password.', 'frmreg' );
			}

			$message = apply_filters( 'frmreg_activation_success_msg', $message );

			if ( isset( $message ) ) {
				$class       = 'frm_message';
				$style_class = 'with_frm_style';
				if ( is_callable( 'FrmStylesController::get_form_style_class' ) ) {
					$style_class = FrmStylesController::get_form_style_class( $style_class, 1 );
				}
				$content = '<div class="' . esc_attr( $style_class ) . '"><div class="' . esc_attr( $class ) . '">' . $message . '</div></div>' . $content;
			}
		}

		return $content;
	}

	/**
	 * Get form settings for a specific user
	 *
	 * @since 2.0
	 *
	 * @param string|int $user_id - User's ID number
	 *
	 * @return array $settings - Form's Registration Settings
	 */
	private static function get_registration_settings_for_user( $user_id ) {
		$form = self::get_form_for_user( $user_id );

		if ( $form ) {
			$settings = FrmRegActionHelper::get_registration_settings_for_form( $form );
		} else {
			$settings = array();
		}

		return $settings;
	}

	/**
	 * Get the form that was used to register a user
	 *
	 * @since 2.0
	 *
	 * @param int $user_id
	 *
	 * @return bool|object
	 */
	private static function get_form_for_user( $user_id ) {
		if ( ! $user_id ) {
			return false;
		}

		// Get form ID from user meta
		$form_id = get_user_meta( $user_id, 'frmreg_form_id', 1 );
		if ( $form_id && is_numeric( $form_id ) ) {
			$form = FrmForm::getOne( $form_id );
		} else {
			$form = false;
		}

		return $form;
	}
}