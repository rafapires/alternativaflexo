<?php

class FrmRegUserController {

	private static $user_id_field = 0;
	private static $entry_user_id = 0;

	/**
	 * Create or update a user when an entry is created or updated
	 *
	 * @since 2.0
	 *
	 * @param WP_Post $action
	 * @param stdClass $entry
	 * @param stdClass $form
	 */
	public static function register_user( $action, $entry, $form ) {
		$entry_clone = clone $entry;

		if ( self::is_profile_update( $entry_clone ) ) {

			if ( FrmRegAppHelper::current_user_can_update_profile( self::$entry_user_id, $action ) || self::is_import() ) {

				self::update_user( $action->post_content, $entry_clone, $form );
			}

		} else if ( ! is_user_logged_in() || FrmRegAppHelper::current_user_can_create_users( $action ) || self::is_import() ) {

			self::create_user( $action->post_content, $entry_clone, $form );

		}
	}

	/**
	 * Check if a profile update should be happening
	 *
	 * @since 2.0
	 *
	 * @param object $entry
	 *
	 * @return bool
	 */
	private static function is_profile_update( $entry ) {
		$user_id_field = FrmRegEntryHelper::get_user_id_field_for_form( $entry->form_id );
		self::$user_id_field = $user_id_field;

		if ( $user_id_field && isset( $entry->metas[ $user_id_field ] ) && $entry->metas[ $user_id_field ] ) {
			$is_profile_update = true;
			self::$entry_user_id = (int) $entry->metas[ $user_id_field ];
		} else {
			$is_profile_update = false;
		}

		return $is_profile_update;
	}

	/**
	 * Create a new user with registration action and entry data
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param object $entry
	 * @param object $form
	 */
	private static function create_user( $settings, $entry, $form ) {
		self::add_post_field_values_to_entry( $form, $entry );

		$user = new FrmRegUser( $settings, $form, $entry );

		$user_id = $user->create();

		if ( ! $user_id ) {
			return;
		}

		self::after_create_user( $settings, $entry, $user );
	}

	/**
	 * Perform actions after user is created
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param stdClass $entry
	 * @param FrmRegUser $user
	 */
	private static function after_create_user( $settings, $entry, $user ) {
		FrmRegSubsiteController::maybe_create_subsite( $user, $settings, $entry );

		FrmRegEntry::update_user_id_for_entry( $user->get_form_id(), $entry, $user->get_user_id() );
		FrmRegEntry::delete_password_from_metas( $settings, $entry->id );

		// This is used in core Formidable code
		$_POST['frm_user_id'] = $user->get_user_id();
		if ( self::$user_id_field ) {
			$_POST['item_meta'][ self::$user_id_field ] = $user->get_user_id();
		}

		if ( FrmRegModerationController::needs_moderation( $settings ) ) {
			FrmRegModerationController::moderate_user( $user, $settings, $entry );
			return;
		}

		FrmRegActionController::trigger_after_registration_actions( $entry->form_id, $entry->id );

		do_action( 'frmreg_after_create_user', $user->get_user_id(), array( 'settings' => $settings, 'entry' => $entry ) );

		if ( ! self::is_import() ) {
			FrmRegUserHelper::log_user_in( $settings, $user );
		}
	}

	/**
	 * Update an existing user with registration action and entry data
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param object $entry
	 * @param object $form
	 */
	private static function update_user( $settings, $entry, $form ) {
		self::add_post_field_values_to_entry( $form, $entry );

		$user = new FrmRegUser( $settings, $form, $entry, 'existing' );

		$updated = $user->update();

		if ( $updated && $user->is_new_password_set() ) {
			FrmRegEntry::delete_password_from_metas( $settings, $entry->id );
		}
	}

	/**
	 * Add post field values to the entry object
	 *
	 * @since 2.0
	 * @param object $form
	 * @param object $entry
	 */
	private static function add_post_field_values_to_entry( $form, $entry ) {
		if ( ! $entry->post_id || ! is_callable( 'FrmProEntryMetaHelper::get_post_value' ) ) {
			return;
		}

		$post_action = FrmFormAction::get_action_for_form( $form->id, 'wppost', 1 );

		if ( empty( $post_action ) ) {
			return;
		}

		foreach ( $post_action->post_content as $setting => $selection ) {

			if ( strpos( $setting, 'post_' ) === false || $selection == '' ) {
				continue;
			}

			if ( is_numeric( $selection ) ) {

				self::maybe_add_post_value( $selection, $entry );

			} else if ( is_array( $selection ) ) {

				foreach ( $selection as $value ) {
					if ( isset( $value['field_id'] ) && is_numeric( $value['field_id'] ) ) {
						self::maybe_add_post_value( $value['field_id'], $entry );
					}
				}
			}
		}
	}

	/**
	 * Add a post value to the entry object if it is not already set
	 *
	 * @since 2.0
	 *
	 * @param int $field_id
	 * @param object $entry
	 */
	private static function maybe_add_post_value( $field_id, $entry ) {
		if ( isset( $entry->metas[ $field_id ] ) ) {
			return;
		}

		$field = FrmField::getOne( $field_id );
		if ( ! $field ) {
			return;
		}

		self::add_post_value( $field, $entry );
	}

	/**
	 * Add a post value to the entry object
	 *
	 * @since 2.0
	 * @param object $field
	 * @param object $entry
	 */
	private static function add_post_value( $field, $entry ) {
		$pass_args = array(
			'links' => false,
			'truncate' => false,
		);
		$entry->metas[ $field->id ] = FrmProEntryMetaHelper::get_post_or_meta_value( $entry, $field, $pass_args );
	}

	/**
	 * Check if import is occurring
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	private static function is_import() {
		return defined( 'WP_IMPORTING' ) && WP_IMPORTING;
	}
}