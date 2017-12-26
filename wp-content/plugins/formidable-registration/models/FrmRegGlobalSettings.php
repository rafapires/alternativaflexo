<?php

/**
 * @since 2.0
 * Class FrmRegGlobalSettings
 */
class FrmRegGlobalSettings extends FrmRegSettings{

	private $global_pages = array();
	private $global_messages = array();

	private $global_pages_key = 'frm_reg_global_pages';
	private $global_messages_key = 'frm_reg_global_messages';

	/**
	 * FrmRegGlobalSettings constructor
	 *
	 * @since 2.0
	 */
	public function __construct() {
		$this->init_global_pages();
		$this->init_global_messages();
	}

	/**
	 * Set the global pages properties
	 *
	 * @since 2.0
	 */
	private function init_global_pages() {
		$saved_settings = $this->get_saved_options( $this->global_pages_key, true );

		$defaults = array(
			'login_page'    => '',
			'resetpass_page' => '',
			'register_page'    => '',
		);

		if ( $saved_settings !== false ) {

			// For reverse compatibility
			if ( isset( $saved_settings['login'] ) ) {
				$saved_settings = array(
					'login_page' => $saved_settings['login'],
				);
			}

			$this->global_pages = wp_parse_args( $saved_settings, $defaults );
		} else {
			$this->global_pages = $defaults;
		}
	}

	/**
	 * Set the global message properties
	 *
	 * @since 2.0
	 */
	private function init_global_messages() {
		$saved_settings = $this->get_saved_options( $this->global_messages_key );

		$defaults = array(
			'existing_email'    => __( 'This email address is already registered.', 'frmreg' ),
			'existing_username' => __( 'This username is already registered.', 'frmreg' ),
			'blank_password'    => __( 'Please enter a valid password.', 'frmreg' ),
			'blank_email'       => __( 'Please enter a valid email address.', 'frmreg' ),
			'blank_username'    => __( 'Please enter a valid username.', 'frmreg' ),
			'illegal_username'  => __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', 'frmreg' ),
			'illegal_password'  => __( 'Passwords may not contain the character "\\".', 'frmreg' ),
			'update_username'   => __( 'Your username cannot be changed at this time.', 'frmreg' ),
			'lost_password'     => __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'frmreg' ),
			'reset_password'    => __( 'Enter your new password below.', 'frmreg' ),
			'existing_subsite'    => __( 'Sorry, that site already exists!', 'frmreg' ),
		);

		if ( $saved_settings !== false ) {
			$this->global_messages = wp_parse_args( $saved_settings, $defaults );
		} else {
			$this->global_messages = $defaults;
		}
	}

	/**
	 * Get a page ID from a global page setting
	 *
	 * @since 2.0
	 *
	 * @param string $setting_name
	 *
	 * @return string
	 */
	public function get_global_page( $setting_name ) {
		return $this->get_item_from_property( 'global_pages', $setting_name );
	}

	/**
	 * Get all the global messages
	 *
	 * @since 2.0
	 * @return array
	 */
	public function get_global_messages() {
		return $this->global_messages;
	}

	/**
	 * Get a global message
	 *
	 * @since 2.0
	 *
	 * @param string $message_name
	 *
	 * @return string
	 */
	public function get_global_message( $message_name ) {
		return $this->get_item_from_property( 'global_messages', $message_name );
	}

	/**
	 * Update the global settings
	 *
	 * @since 1.11
	 *
	 * @param array $posted_values
	 */
	public function update( $posted_values ) {
		// Set the properties using the posted values
		$this->set_global_pages_from_posted_values( $posted_values );
		$this->set_global_messages_from_posted_values( $posted_values );

		// Update properties in database
		$this->update_global_pages();
		$this->update_global_messages();

		// Remove deprecated option from database
		delete_option( 'frm_reg_options' );
	}

	/**
	 * @param $posted_values
	 *
	 * @return array
	 */
	public function validate( $posted_values ) {
		$errors = array();
		$posted_pages = isset( $posted_values['frm_reg_global_pages'] ) ? (array) $posted_values['frm_reg_global_pages'] : array();

		foreach ( $this->global_pages as $key => $current_setting ) {
			if ( isset( $posted_pages[ $key ] ) && $posted_pages[ $key ] !== $current_setting ) {
				$this->check_page_content( $posted_pages[ $key ], $key, $errors );
			}
		}

		return $errors;
	}

	/**
	 * Check to make sure a specific shortcode is present in a Login or Reset Password page's content
	 *
	 * @since 2.0
	 * @param string $selected_page
	 * @param string $page_key
	 * @param array $errors
	 */
	private function check_page_content( $selected_page, $page_key, &$errors ) {
		if ( $selected_page === '' ) {
			return;
		}

		$selected_post = get_post( $selected_page );

		if ( $page_key === 'login_page' &&  strpos( $selected_post->post_content, '[frm-login' ) === false ) {
			$message = 'The selected Login/Logout page does not include a login form.';
			$message .= ' Please select a page that includes the [frm-login] shortcode.';
		} else if ( $page_key === 'resetpass_page' && strpos( $selected_post->post_content, '[frm-reset-password' ) === false ) {
			$message = 'The selected Reset Password page does not include a reset password form.';
			$message .= ' Please select a page that includes the [frm-reset-password] shortcode.';
		} else if ( $page_key === 'register_page' && strpos( $selected_post->post_content, '[formidable' ) === false ) {
			$message = 'The selected registration page does not include a registration form.';
			$message .= ' Please select a page that has a registration form published on it.';
		}

		if ( isset( $message ) ) {
			$errors[] = __( $message, 'frmreg' );
		}
	}

	/**
	 * Get a specific option saved in the database
	 *
	 * @since 2.0
	 *
	 * @param string $option_name
	 * @param boolean $check_fallback
	 *
	 * @return array|boolean
	 */
	private function get_saved_options( $option_name, $check_fallback = false ) {
		$settings = get_option( $option_name );

		if ( ! $settings && $check_fallback ) {
			$settings = get_option( 'frm_reg_options' );

			if ( is_object( $settings ) ) {
				$settings = get_object_vars( $settings );
			} else if ( $settings && ! is_object( $settings ) ) {
				//workaround for W3 total cache conflict
				$settings = unserialize( serialize( $settings ) );
			}
		}

		return $settings;
	}

	/**
	 * Get a specific item from an object property
	 *
	 * @since 2.0
	 *
	 * @param string $property
	 * @param string $item_key
	 *
	 * @return string
	 */
	private function get_item_from_property( $property, $item_key ) {
		if ( isset( $this->{$property}[ $item_key ] ) ) {
			$string = $this->{$property}[ $item_key ];
		} else {
			$string = '';
		}

		return $string;
	}

	/**
	 * Set the global pages property from the posted values
	 *
	 * @since 2.0
	 *
	 * @param array $posted_values
	 */
	private function set_global_pages_from_posted_values( $posted_values ) {
		$posted_pages = isset( $posted_values['frm_reg_global_pages'] ) ? (array) $posted_values['frm_reg_global_pages'] : array();

		foreach ( $this->global_pages as $key => $current_setting ) {
			if ( isset( $posted_pages[ $key ] ) ) {
				$this->global_pages[ $key ] = $posted_pages[ $key ];
			}
		}
	}

	/**
	 * Set the global messages property from the posted values
	 *
	 * @since 2.0
	 *
	 * @param array $posted_values
	 */
	private function set_global_messages_from_posted_values( $posted_values ) {
		$posted_messages = isset( $posted_values['frm_reg_global_messages'] ) ? (array) $posted_values['frm_reg_global_messages'] : array();

		foreach ( $this->global_messages as $key => $current_setting ) {
			if ( isset( $posted_messages[ $key ] ) && ! empty( $posted_messages[ $key ] ) ) {
				$this->global_messages[ $key ] = $this->sanitize_message( $posted_messages[ $key ] );
			}
		}
	}

	/**
	 * Update the global pages
	 *
	 * @since 2.0
	 */
	private function update_global_pages() {
		update_option( $this->global_pages_key, $this->global_pages );
	}

	/**
	 * Update the global messages
	 *
	 * @since 2.0
	 */
	private function update_global_messages() {
		update_option( $this->global_messages_key, $this->global_messages );
	}

	/**
	 * Sanitize a global message
	 * Remove PHP tags, script tags, comments, etc.
	 * Only allow line breaks, paragraph tags, links, divs, and spans
	 *
	 * @since 2.0
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	private function sanitize_message( $message ) {
		$message = (string) $message;

		// Strip slashes
		$message = stripslashes( $message );

		// Remove unwanted tags
		$allowable_tags = '<br><p><div><span><a>';
		$message        = strip_tags( $message, $allowable_tags );

		// Trim whitespace
		$message = trim( $message );

		return $message;
	}
}
