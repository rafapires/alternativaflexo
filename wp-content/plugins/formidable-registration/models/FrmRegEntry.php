<?php

class FrmRegEntry {

	/**
	 * Current form ID
	 *
	 * @since 2.0
	 *
	 * @var int
	 */
	private $form_id = 0;

	/**
	 * @since 2.0
	 *
	 * @var WP_Post
	 */
	private $registration_action = null;

	/**
	 * @var string
	 */
	private $form_action = '';

	/**
	 * @var bool
	 */
	private $is_action_triggered = false;

	/**
	 * @var WP_User
	 */
	private $selected_user = null;

	/**
	 * @var array
	 */
	private $global_messages = null;

	public function __construct() {
		$this->init_form_id();

		$this->init_registration_action();
		if ( $this->registration_action === null ) {
			return;
		}

		$this->init_form_action();
		$this->init_is_action_triggered();

		if ( $this->is_action_triggered ) {
			$this->set_selected_user();
			$this->add_validation_filter();
			$this->init_global_messages();
		}
	}

	/**
	 * Set the form ID property
	 *
	 * @since 2.0
	 */
	private function init_form_id() {
		if ( isset( $_POST['form_id'] ) ) {
			$this->form_id = FrmAppHelper::get_post_param( 'form_id', '', 'absint' );
		}
	}

	/**
	 * Set the registration_action property
	 *
	 * @since 2.0
	 */
	private function init_registration_action() {
		if ( $this->form_id !== 0 ) {
			$register_action = FrmFormAction::get_action_for_form( $this->form_id, 'register', 1 );

			if ( is_object( $register_action ) ) {
				$this->registration_action = $register_action;
			}
		}
	}

	/**
	 * Set the form_action property
	 *
	 * @since 2.0
	 */
	private function init_form_action(){
		if ( ! isset( $_POST['frm_action'] ) && ! isset( $_POST['action'] ) ) {
			return;
		}

		$action_var = isset( $_POST['frm_action'] ) ? 'frm_action' : 'action';
		if ( $_POST[ $action_var ] === 'update' ) {
			$this->form_action = 'update';
		} else {
			$this->form_action = 'create';
		}
	}

	/**
	 * Set the is_action_triggered property
	 *
	 * @since 2.0
	 */
	private function init_is_action_triggered() {
		if ( $this->is_form_action_a_registration_trigger() && $this->is_action_logic_met() ) {
			$this->is_action_triggered = true;
		}
	}

	/**
	 * Set the global messages property
	 *
	 * @since 2.0
	 */
	private function init_global_messages() {
		$global_settings       = new FrmRegGlobalSettings;
		$this->global_messages = $global_settings->get_global_messages();
	}

	/**
	 * Check if the current form action will trigger the registration action
	 *
	 * @since 2.0
	 * @return bool
	 */
	private function is_form_action_a_registration_trigger() {
		return ( in_array( $this->form_action, $this->registration_action->post_content['event'] ) );
	}

	/**
	 * Check if the action logic is met
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	private function is_action_logic_met() {
		/**
		 * @var array $settings
		 */
		$settings = $this->registration_action->post_content;

		if ( ! isset( $settings['conditions'] ) || empty( $settings['conditions'] ) || count( $settings['conditions'] ) <= 2 ) {
			return true;
		}

		$outcomes = $this->get_conditional_logic_outcomes( $settings['conditions'] );

		return $this->do_logic_conditions_trigger_action( $settings, $outcomes );
	}

	/**
	 * Set the selected_user property
	 *
	 * @since 2.0
	 */
	private function set_selected_user() {
		$user_id = FrmRegEntryHelper::get_posted_user_id( $this->form_id );
		if ( $user_id ) {
			$this->selected_user = get_userdata( $user_id );
		}
	}

	/**
	 * Add the validation filter
	 */
	private function add_validation_filter(){
		add_filter( 'frm_validate_field_entry', array( $this, 'validate_field'), 20, 3 );
	}

	/**
	 * Validate a registration field
	 *
	 * @since 2.0
	 *
	 * @param array $errors
	 * @param stdClass $field
	 * @param string|array $value
	 *
	 * @return array
	 */
	public function validate_field( $errors, $field, $value ) {
		if ( ! $this->is_registration_field( $field->id ) || $this->is_field_hidden( $field ) ) {
			return $errors;
		}

		if ( $this->form_action === 'update' ) {
			$this->validate_entry_update( $field, $value, $errors );
		} else {
			$this->validate_entry_creation( $field, $value, $errors );
		}

		return $errors;
	}

	/**
	 * Check if registration entry validation is needed
	 *
	 * @since 2.0
	 *
	 * @param int|string $field_id
	 * @return bool
	 */
	private function is_registration_field( $field_id ) {
		return ( isset ( $_POST['frm_register'] ) && in_array( $field_id, $_POST['frm_register'] ) );
	}

	/**
	 * Check if a field is conditionally hidden
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 *
	 * @return bool
	 */
	private function is_field_hidden( $field ) {
		return ( is_callable( 'FrmProFieldsHelper::is_field_hidden' ) && FrmProFieldsHelper::is_field_hidden( $field, $_POST ) );
	}

	/**
	 * Validate registration fields when a new entry is created
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_entry_creation( $field, $value, &$errors ) {
		if ( is_user_logged_in() ) {

			if ( is_object( $this->selected_user ) ) {
				$this->validate_profile_update( $field, $value, $errors );
			} else {
				$this->validate_profile_creation( $field, $value, $errors );
			}
		} else {
			$this->validate_profile_creation( $field, $value, $errors );
		}
	}

	/**
	 * Validate registration fields when an entry is updated
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_entry_update( $field, $value, &$errors ){
		if ( is_user_logged_in() ) {

			if ( is_object( $this->selected_user ) ) {
				$this->validate_profile_update( $field, $value, $errors );
			} else {

				if ( FrmRegAppHelper::current_user_can_create_users( $this->registration_action ) ) {
					$this->validate_profile_creation( $field, $value, $errors );
				} else {
					$this->validate_profile_update( $field, $value, $errors );
				}
			}
		}
	}

	/**
	 * Validate registration fields when a profile is getting created
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_profile_creation( $field, $value, &$errors ) {
		$this->validate_password_on_profile_creation( $field, $value, $errors );
		$this->validate_email_on_profile_creation( $field, $value, $errors );
		$this->validate_username_on_profile_creation( $field, $value, $errors );

		$this->validate_subsite_title_on_profile_creation( $field, $value, $errors );
		$this->validate_subsite_domain_on_profile_creation( $field, $value, $errors );
	}

	/**
	 * Validate registration fields when a profile is getting updated
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_profile_update( $field, $value, &$errors ) {
		if ( ! is_object( $this->selected_user ) ) {
			return;
		}

		$this->validate_password_on_profile_update( $field, $value, $errors );
		$this->validate_email_on_profile_update( $field, $value, $errors );
		$this->validate_username_on_profile_update( $field, $value, $errors );
	}

	/**
	 * Validate a password on profile creation
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string $password
	 * @param array $errors
	 */
	private function validate_password_on_profile_creation( $field, $password, &$errors ) {
		if ( ! $this->field_needs_validation( $field->id, 'password', $errors ) ) {
			return;
		}

		if ( empty( $password ) ) {
			// If user is being created and the password field is empty
			$errors['field' . $field->id ] = $this->global_messages['blank_password'];

		} else {
			$errors = $this->check_for_invalid_password( $password, $field, $errors );
		}
	}

	/**
	 * Validate email on profile creation
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_email_on_profile_creation( $field, $value, &$errors ) {
		if ( ! $this->field_needs_validation( $field->id, 'email', $errors ) ) {
			return;
		}

		if ( empty( $value ) ) {
			// If user is being created and the email field is empty
			$errors['field' . $field->id ] = $this->global_messages['blank_email'];

		} else if ( $this->email_exists( $value ) ) {
			// If a new email address was entered, but it already exists
			$errors['field' . $field->id ] = $this->global_messages['existing_email'];
		}
	}

	/**
	 * Validate username on profile creation
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $username
	 * @param array $errors
	 */
	private function validate_username_on_profile_creation( $field, $username, &$errors ) {
		if ( ! $this->field_needs_validation( $field->id, 'username', $errors ) ) {
			return;
		}

		if ( empty( $username ) ) {
			// If user is being created and the username field is empty
			$errors['field' . $field->id ] = $this->global_messages['blank_username'];

		} else if ( FrmRegAppHelper::username_exists( $username ) ) {
			// Check if username already exists
			$errors['field' . $field->id ] = $this->global_messages['existing_username'];

		} else if ( ! validate_username( $username ) ) {
			// Check for invalid characters in new username
			$errors['field' . $field->id ] = $this->global_messages['illegal_username'];

		}
	}

	/**
	 * Validate subsite title on profile creation
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_subsite_title_on_profile_creation( $field, $value, &$errors ) {
		if ( ! $this->field_needs_validation( $field->id, 'subsite_title', $errors ) ) {
			return;
		}

		if ( empty( $value ) ) {
			// If user is being created and the subsite title field is empty
			$errors['field' . $field->id ] = FrmFieldsHelper::get_error_msg( $field, 'blank' );
		}
	}

	/**
	 * Validate subsite domain/directory on profile creation
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_subsite_domain_on_profile_creation( $field, $value, &$errors ) {
		if ( $this->field_needs_validation( $field->id, 'subsite_domain', $errors ) ) {

			$this->validate_subdomain_field( $field, $value, $errors );

		} else if ( $this->is_current_field_indirectly_mapped_to_subdomain( $field, $errors ) ) {

			$this->check_for_reserved_names( $field, $value, $errors );
		}

	}

	/**
	 * Validate the field directly mapped to the subdomain/subdirectory setting
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string|array $value
	 * @param array $errors
	 */
	private function validate_subdomain_field( $field, $value, &$errors ) {
		if ( empty( $value ) ) {
			// If subsite is being created and the subsite domain field is empty
			$errors['field' . $field->id ] = FrmFieldsHelper::get_error_msg( $field, 'blank' );
		} else if ( $this->subsite_exists( $value ) ) {
			// If subsite is being created, but the full path already exists
			$errors['field' . $field->id ] = $this->global_messages['existing_subsite'];

		} else {
			$this->check_for_reserved_names( $field, $value, $errors );
		}
	}

	/**
	 * Check if the current field is indirectly mapped to the subdomain/subdirectory setting
	 * This could be the username or blog title field
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param array $errors
	 *
	 * @return bool
	 */
	private function is_current_field_indirectly_mapped_to_subdomain( $field, $errors ) {
		$is_mapped = false;

		if ( isset( $_POST['frm_register']['subsite_domain'] ) ) {

			$subdomain_mapping = $_POST['frm_register']['subsite_domain'];

			if ( ( $subdomain_mapping === 'blog_title' && $this->field_needs_validation( $field->id, 'subsite_title', $errors ) ) ||
				 ( $subdomain_mapping === 'username' && $this->field_needs_validation( $field->id, 'username', $errors ) ) ) {

				$is_mapped = true;
			}
		}

		return $is_mapped;
	}

	/**
	 * Check if a subsite already exists
	 *
	 * @since 2.0
	 *
	 * @param string $subdomain
	 *
	 * @return int
	 */
	private function subsite_exists( $subdomain ) {
		$subdomain = sanitize_title( $subdomain );

		$current_site = get_current_site();

		if ( is_subdomain_install() ) {
			// If subsite.localhost.com format
			$path = $current_site->path;
			$domain = $subdomain . '.' . preg_replace( '|^www\.|', '', $current_site->domain );

		} else {
			// If localhost.com/subsite format
			$path  = $current_site->path . $subdomain . '/';
			$domain = $current_site->domain;
		}

		return domain_exists( $domain, $path, 1 );
	}

	/**
	 * Add errors if reserved names are used in subdirectory
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string $subdomain
	 * @param array $errors
	 */
	private function check_for_reserved_names( $field, $subdomain, &$errors ) {
		$subdomain = sanitize_title( $subdomain );

		if ( $this->is_reserved_name_used_in_subdirectory( $subdomain ) ) {

			$reserved_names = implode( ', ', get_subdirectory_reserved_names() );
			$errors['field' . $field->id ] = sprintf(
				__( 'The following words cannot be used as blog names: %s.', 'frmreg' ),
				$reserved_names
			);
		}
	}

	/**
	 * If not a subdomain install, check if the domain is a reserved word
	 *
	 * @since 2.0
	 * @param string $subdomain
	 *
	 * @return bool
	 */
	private function is_reserved_name_used_in_subdirectory( $subdomain ) {
		if ( ! is_subdomain_install() ) {
			return in_array( $subdomain, get_subdirectory_reserved_names() );
		} else {
			return false;
		}
	}

	/**
	 * Validate a password on profile update
	 *
	 * @since 2.0
	 *
	 * @param stdClass $password_field
	 * @param string $new_password
	 * @param array $errors
	 */
	private function validate_password_on_profile_update( $password_field, $new_password, &$errors ) {
		if ( ! $this->is_field_mapped_to_setting( $password_field->id, 'password' ) ) {
			return;
		}

		if ( $this->errors_already_set( $password_field->id, $errors ) ) {

			// Do not require password on update
			if ( empty( $new_password ) ) {
				unset( $errors['field' . $password_field->id ] );
			}

		} else if ( ! empty( $new_password ) ) {
			$errors = $this->check_for_invalid_password( $new_password, $password_field, $errors );
		}
	}

	/**
	 * Validate an email on profile update
	 *
	 * @since 2.0
	 *
	 * @param stdClass $email_field
	 * @param string $new_email
	 * @param array $errors
	 */
	private function validate_email_on_profile_update( $email_field, $new_email, &$errors ) {
		if ( ! $this->field_needs_validation( $email_field->id, 'email', $errors ) ) {
			return;
		}

		$current_email = $this->selected_user->data->user_email;

		if ( empty( $new_email ) ) {
			// Make sure a blank email isn't entered
			$errors['field' . $email_field->id ] = $this->global_messages['blank_email'];

		} else if ( self::new_value_entered( $new_email, $current_email ) && $this->email_exists( $new_email ) ) {
			// If a new email address was entered, but it already exists
			$errors['field' . $email_field->id ] = $this->global_messages['existing_email'];
		}
	}

	/**
	 * Validate a username on profile update
	 *
	 * @since 2.0
	 *
	 * @param stdClass $field
	 * @param string $new_username
	 * @param array $errors
	 */
	private function validate_username_on_profile_update( $field, $new_username, &$errors ) {
		if ( ! $this->field_needs_validation( $field->id, 'username', $errors ) ) {
			return;
		}

		$current_username = $this->selected_user->data->user_login;

		if ( empty( $new_username ) ) {
			// If user is being edited and the username field is empty
			$errors['field' . $field->id ] = $this->global_messages['blank_username'];

		} else if ( self::new_value_entered( $new_username, $current_username ) ) {
			$errors['field' . $field->id ] = $this->global_messages['update_username'];
			// TODO: Allow people to change their username
		}
	}

	/**
	 * Check if a field needs validation
	 *
	 * @since 2.0
	 *
	 * @param int|string $field_id
	 * @param string $setting
	 * @param array $errors
	 *
	 * @return bool
	 */
	private function field_needs_validation( $field_id, $setting, $errors ) {
		return $this->is_field_mapped_to_setting( (int) $field_id, $setting ) && ! $this->errors_already_set( $field_id, $errors );
	}

	/**
	 * Check if a field is mapped to a specific registration setting
	 *
	 * @since 2.0
	 *
	 * @param int|string $field_id
	 * @param string $setting
	 *
	 * @return bool
	 */
	private function is_field_mapped_to_setting( $field_id, $setting ) {
		return ( isset( $_POST['frm_register'][ $setting ] ) && (int) $_POST['frm_register'][ $setting ] === (int) $field_id );
	}


	/**
	 * Check for an invalid password in the same way WordPress does
	 *
	 * @since 2.0
	 *
	 * @param string $password
	 * @param stdClass $field
	 * @param array $errors
	 *
	 * @return array
	 */
	private function check_for_invalid_password( $password, $field, $errors ) {
		if ( false !== strpos( wp_unslash( $password ), "\\" ) ) {
			$errors['field' . $field->id ] = $this->global_messages['illegal_password'];
		}

		return $errors;
	}

	/**
	 * Get the conditional logic outcomes for a Register User action
	 *
	 * @since 2.0
	 *
	 * @param array $conditions
	 *
	 * @return array
	 */
	private function get_conditional_logic_outcomes( $conditions ) {
		$logic_outcomes = array();
		foreach ( $conditions as $k => $condition ) {
			if ( ! is_numeric( $k ) ) {
				continue;
			}

			$observed_value = $this->get_posted_field_value( $condition['hide_field'] );
			$logic_value    = $this->format_action_logic_value( $condition['hide_opt'] );
			$operator       = $condition['hide_field_cond'];

			$logic_outcomes[] = FrmFieldsHelper::value_meets_condition( $observed_value, $operator, $logic_value );
		}

		return $logic_outcomes;
	}

	/**
	 * Format an action's logic value
	 *
	 * @since 2.0
	 *
	 * @param $logic_value
	 *
	 * @return array|int|mixed
	 */
	private function format_action_logic_value( $logic_value ) {
		if ( is_array( $logic_value ) ) {
			$logic_value = reset( $logic_value );
		}

		if ( $logic_value == 'current_user' ) {
			$logic_value = get_current_user_id();
		}

		return $logic_value;
	}

	/**
	 * Check if a Register User action is triggered based on logic outcomes and settings
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param array $logic_outcomes
	 *
	 * @return bool
	 */
	private function do_logic_conditions_trigger_action( $settings, $logic_outcomes ) {
		$any_all   = $settings['conditions']['any_all'];
		$triggered = ( 'send' == $settings['conditions']['send_stop'] ) ? true : false;

		if ( 'any' == $any_all ) {
			if ( ! in_array( true, $logic_outcomes ) ) {
				$triggered = ! $triggered;
			}
		} else {
			if ( in_array( false, $logic_outcomes ) ) {
				$triggered = ! $triggered;
			}
		}

		return $triggered;
	}

	/**
	 * Compare two values to check for a non case-sensitive difference
	 *
	 * @param string $new_val
	 * @param string $old_val
	 *
	 * @return boolean
	 */
	private function new_value_entered( $new_val, $old_val ) {
		return ( ( $old_val && strtolower( $new_val ) != strtolower( $old_val ) ) || ! $old_val );
	}

	/**
	 * Check if a field has errors on it
	 *
	 * @param int $id
	 * @param array $errors
	 *
	 * @return boolean
	 */
	private function errors_already_set( $id, $errors ) {
		return isset( $errors['field' . $id ] ) && ! empty( $errors['field' . $id ] );
	}

	/**
	 * Check if email already exists
	 *
	 * @param string $email
	 *
	 * @return boolean|int
	 */
	private function email_exists( $email ) {
		if ( ! function_exists( 'email_exists' ) ) {
			require_once( ABSPATH . WPINC . '/registration.php' );
		}

		return email_exists( $email );
	}

	/**
	 * Get a posted field value
	 *
	 * @since 2.0
	 *
	 * @param int $field_id
	 *
	 * @return string
	 */
	private function get_posted_field_value( $field_id ) {
		if ( is_numeric( $field_id ) && isset( $_POST['item_meta'][ $field_id ] ) ) {
			$value = $_POST['item_meta'][ $field_id ];
		} else {
			$value = '';
		}

		return $value;
	}

	//******** Static functions *********//

	public static function delete_password_from_metas( $settings, $entry_id ) {
		if ( isset( $settings['reg_password'] ) && ! empty( $settings['reg_password'] ) ) {
			FrmEntryMeta::delete_entry_meta( $entry_id, (int) $settings['reg_password'] );
		}
	}

	/**
	 * Don't select a user in the user ID field when a new user should be created
	 *
	 * @since 2.0
	 *
	 * @param string $value
	 * @param object $field
	 *
	 * @return string $value
	 */
	public static function reset_user_id_for_user_creation( $value, $field ) {
		// TODO: allow users to select a user in UserID field in a multi-page form

		if ( $field->type == 'user_id' ) {

			$register_action = FrmFormAction::get_action_for_form( $field->form_id, 'register', 1 );

			if ( is_object( $register_action ) && FrmRegAppHelper::current_user_can_create_users( $register_action ) ) {
				$value = 0;
			}
		}

		return $value;
	}

	/**
	 * Update the user ID for an entry
	 *
	 * @since 1.11.05
	 *
	 * @param int $form_id
	 * @param object $entry
	 * @param int $user_id
	 */
	public static function update_user_id_for_entry( $form_id, $entry, $user_id ) {
		global $wpdb;

		// Get all the user ID fields in this form (and in child forms)
		$user_id_fields   = FrmField::get_all_types_in_form( $form_id, 'user_id', 999, 'include' );
		$form_to_field_id = array();
		foreach ( $user_id_fields as $u_field ) {
			$form_to_field_id[ $u_field->form_id ] = $u_field->id;

			if ( isset( $entry->metas[ $u_field->id ] ) ) {
				$entry->metas[ $u_field->id ] = $user_id;
			}
		}

		// Get all entry IDs (for parent and child entries)
		$query     = $wpdb->prepare( "SELECT id, form_id FROM " . $wpdb->prefix . "frm_items WHERE parent_item_id=%d OR id=%d", $entry->id, $entry->id );
		$entry_ids = $wpdb->get_results( $query );

		foreach ( $entry_ids as $e ) {
			// Update frm_items for parent and child entries
			self::update_user_id_frm_items( $e->id, $user_id );
			if ( isset( $form_to_field_id[ $e->form_id ] ) ) {
				self::update_user_id_frm_item_metas( $e->id, $form_to_field_id[ $e->form_id ], $user_id );
			}
		}

		wp_cache_delete( $entry->id, 'frm_entry' );
		wp_cache_delete( $entry->id .'_nometa', 'frm_entry' );
	}

	/**
	 * Update the frm_items table with new userID
	 *
	 * @since 1.11.05
	 *
	 * @param int $entry_id
	 * @param int $user_id
	 */
	private static function update_user_id_frm_items( $entry_id, $user_id ) {
		global $wpdb;

		$wpdb->update( $wpdb->prefix . 'frm_items', array(
			'user_id'    => $user_id,
			'updated_by' => $user_id
		), array( 'id' => $entry_id ) );
		wp_cache_delete( $entry_id, 'frm_entry' );
	}

	/**
	 * Update the frm_item_metas table with new userID
	 *
	 * @since 1.11.05
	 *
	 * @param int $entry_id
	 * @param int $user_field
	 * @param int $user_id
	 */
	private static function update_user_id_frm_item_metas( $entry_id, $user_field, $user_id ) {
		FrmEntryMeta::delete_entry_meta( $entry_id, $user_field );
		FrmEntryMeta::add_entry_meta( $entry_id, $user_field, '', $user_id );
	}

	/**
	 * Replace field value with the current profile value
	 *
	 * @param array $values
	 * @param object $field
	 * @param int $entry_id
	 *
	 * @return array
	 */
	public static function check_updated_user_meta( $values, $field, $entry_id ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) && isset( $_GET['page'] ) && 'formidable' == $_GET['page'] ) {
			// make sure this doesn't change settings
			return $values;
		}

		// Change field value only on initial form load
		if ( isset( $_POST['form_id'] ) || isset( $_POST['item_meta'] ) || in_array( $field->type, array(
				'data',
				'checkbox'
			) )
		) {
			return $values;
		}

		// If there is no user ID attached to this entry, do not update the fields automatically
		$user_for_entry = self::get_user_for_entry( $entry_id );
		if ( ! $user_for_entry ) {
			return $values;
		}

		$settings = FrmRegActionHelper::get_registration_settings_for_form( $field->form_id );
		if ( empty( $settings ) ) {
			return $values;
		}

		$user_meta_key = self::get_user_meta_key_for_field( $field->id, $settings );
		if ( ! $user_meta_key ) {
			return $values;
		}

		$user_data = get_userdata( $user_for_entry );

		if ( isset( $user_data->{$user_meta_key} ) ) {
			$values['value'] = $user_data->{$user_meta_key};
		} else {
			$values['value'] = get_user_meta( $user_for_entry, $user_meta_key, 1 );
		}

		return $values;
	}

	/**
	 * Get the user ID for the entry ID
	 *
	 * @since 2.0
	 *
	 * @param $entry_id int
	 *
	 * @return int $user_id
	 */
	private static function get_user_for_entry( $entry_id ) {

		// Get user ID field for the entry
		global $wpdb;
		$table    = $wpdb->prefix . 'frm_item_metas m INNER JOIN ' . $wpdb->prefix . 'frm_fields f ON m.field_id=f.id';
		$where    = array( 'm.item_id' => $entry_id, 'f.type' => 'user_id' );
		$user_val = FrmDb::get_var( $table, $where, 'm.meta_value' );

		if ( ! $user_val ) {
			return 0;
		}

		// Check if user exists
		$count = get_user_by( 'id', $user_val );

		// If user doesn't exist, don't try to autopopulate form with their info
		if ( $count ) {
			return (int) $user_val;
		} else {
			return 0;
		}
	}

	/**
	 * Get the user meta key for a given field and registration settings
	 *
	 * @since 2.0
	 *
	 * @param int $field_id
	 * @param array $settings
	 *
	 * @return string
	 */
	private static function get_user_meta_key_for_field( $field_id, $settings ) {
		$user_meta_key = '';

		$user_keys_to_check = array(
			'user_email'   => 'reg_email',
			'user_login'   => 'reg_username',
			'first_name'   => 'reg_first_name',
			'last_name'    => 'reg_last_name',
			'display_name' => 'reg_display_name',
			'user_url'     => 'reg_user_url',
		);

		foreach ( $user_keys_to_check as $wp_name => $frmreg_name ) {
			if ( isset( $settings[ $frmreg_name ] ) && $settings[ $frmreg_name ] === $field_id ) {
				$user_meta_key = $wp_name;
				break;
			}
		}

		if ( ! $user_meta_key ) {
			foreach ( $settings['reg_usermeta'] as $row ) {
				if ( isset( $row['meta_name'] ) && $row['meta_name'] && isset( $row['field_id'] ) && $row['field_id'] === $field_id ) {
					$user_meta_key = $row['meta_name'];
					break;
				}
			}
		}

		return $user_meta_key;
	}
}