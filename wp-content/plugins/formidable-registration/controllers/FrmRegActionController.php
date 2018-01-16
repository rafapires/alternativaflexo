<?php

class FrmRegActionController{

	/**
	 * Trigger all actions that have "Successful user registration" selected as an event
	 *
	 * @since 2.01
	 *
	 * @param int $form_id
	 * @param int $entry_id
	 */
	public static function trigger_after_registration_actions( $form_id, $entry_id ) {
		FrmFormActionsController::trigger_actions( 'user_registration', $form_id, $entry_id );
	}

	/*
	 * Trigger all actions that have "Successful user registration" selected as an event
	 * For a single user
	 *
	 * @param WP_User $user
	 *
	 * @since 2.01
	 */
	public static function trigger_after_registration_actions_for_user( $user ) {
		if ( ! is_object( $user ) ) {
			return;
		}

		// Get entry ID from user meta
		$entry_id = get_user_meta( $user->ID, 'frmreg_entry_id', 1 );
		$entry    = FrmEntry::getOne( $entry_id );

		self::trigger_after_registration_actions( $entry->form_id, $entry->id );
	}

	/**
	 * Add the Register action
	 *
	 * @param array $actions
	 * @return array $actions
	 */
	public static function register_actions( $actions ) {
		$actions['register'] = 'FrmRegAction';

		return $actions;
	}

	/**
	 * Add the "User Registration" action trigger
	 *
	 * @since 2.0
	 *
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function add_registration_trigger( $triggers ) {
		$triggers['user_registration'] = __( 'Successful user registration', 'frmpp' );
		return $triggers;
	}

	/**
	 * Add the "User Registration" trigger to specific actions
	 *
	 * @since 2.0
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public static function add_trigger_to_action( $options ) {
		$options['event'][] = 'user_registration';
		return $options;
	}

	/**
	 * Add a new row of user meta
	 */
	public static function add_user_meta_row() {
		$meta_name = $meta_key = absint( $_POST['meta_name'] );
		$form_id = absint( $_POST['form_id'] );
		$field_id = 0;

		$echo = false;

		$fields = self::get_user_meta_fields( $form_id );

		// Set action ID
		$action_control = FrmFormActionsController::get_form_actions( 'register' );
		$action_control->_set( sanitize_title( $_POST['action_key'] ) );

		include( FrmRegAppHelper::path() .'/views/_usermeta_row.php' );

		die();
	}

	/**
	 * Check for userID field when registration settings are updated
	 *
	 * @param array $options
	 * @param array $values
	 * @return array $options
	 */
	public static function before_update_form( $options, $values ){
		if ( isset( $values['frm_register_action'] ) ) {

			foreach ( $values['frm_register_action'] as $register_action ) {

				if ( isset( $register_action['post_content'] ) ) {

					self::add_user_id_field_if_missing( $values['id'] );
					break;
				}
			}
		}

		return $options;
	}

	/**
	 * Customize a new email notification, if it was generated with a button in registration action
	 *
	 * @since 2.0
	 * @param object $email_action
	 *
	 * @return mixed
	 */
	public static function customize_new_email_action( $email_action ) {
		if ( ! isset( $_POST['reg_email_type'] ) || ! isset( $_POST['form_id'] ) ) {
			return $email_action;
		}

		$form_id = absint( $_POST['form_id'] );
		$email_type = sanitize_text_field( $_POST['reg_email_type'] );

		if ( $email_type == 'admin' ) {

			$email_action->post_title = self::default_title_for_admin_email();
			$email_action->post_content['email_subject'] = self::default_admin_email_subject();
			$email_action->post_content['email_message'] = self::default_admin_email_message( $form_id );
			$email_action->post_content['event'] = self::registration_email_event();

		} else if ( $email_type == 'user' ) {

			$register_action = FrmFormAction::get_action_for_form( $form_id, 'register', 1 );

			if ( ! $register_action ) {
				return $email_action;
			}

			$email_action->post_title = __( 'User Email Notification', 'frmreg' );
			$email_action->post_content['email_to'] = self::default_to_for_user_email( $register_action->post_content );
			$email_action->post_content['email_subject'] = self::default_subject_for_user_email();
			$email_action->post_content['email_message'] = self::default_message_for_user_email( $form_id, $register_action->post_content );
			$email_action->post_content['event'] = self::registration_email_event();

		}

		return $email_action;
	}

	/**
	 * Migrate registration settings to action after import
	 *
	 * @since 2.0
	 * @param int $form_id
	 * @param array $form
	 */
	public static function migrate_settings_to_action_after_import( $form_id, $form ) {
		if ( ! isset( $form['options']['registration'] ) || ! $form['options']['registration'] ) {
			return;
		}

		$form = FrmForm::getOne( $form_id );
		self::migrate_settings_to_action( $form, true );
	}

	/**
	 * If registration action, update it
	 *
	 * @since 2.0
	 *
	 * @param int|string $new_id
	 * @param array $action
	 */
	public static function migrate_action_after_import( $new_id, $action ) {
		if ( self::is_imported_registration_action( $action ) && self::imported_action_needs_migration( $action ) ) {

			$form = FrmForm::getOne( $action['menu_order'] );
			if ( is_object( $form ) ) {
				self::migrate_registration_actions_to_2( $form );
			}
		}
	}

	/**
	 * Check if an imported action is a registration action
	 *
	 * @since 2.0
	 *
	 * @param array $action
	 *
	 * @return bool
	 */
	private static function is_imported_registration_action( $action ) {
		return isset( $action['post_excerpt'] ) && $action['post_excerpt'] === 'register';
	}

	/**
	 * Check if an imported registration action needs migrating
	 *
	 * @since 2.0
	 *
	 * @param array $action
	 *
	 * @return bool
	 */
	private static function imported_action_needs_migration( $action ) {
		$settings = FrmAppHelper::maybe_json_decode( $action['post_content'] );

		return isset( $settings['reg_email_msg'] ) && ! empty( $settings['reg_email_msg'] );
	}

	/**
	 * Migrate registration setting to a new action
	 *
	 * @since 2.0
	 * @param object $form
	 * @param bool $switch
	 */
	public static function migrate_settings_to_action( $form, $switch = false ) {
		if ( ! isset( $form->options['registration'] ) || ! $form->options['registration'] ) {
			return;
		}

		$reg_action = new FrmRegAction();
		$reg_action->set_switch( $switch );
		$reg_action->migrate_to_2( $form, 'update' );
	}

	/**
	 * Migrate the registration action to DB version 2
	 * Create email actions, migrate user URL setting, etc
	 *
	 * @since 2.0
	 * @param object $form
	 */
	public static function migrate_registration_actions_to_2( $form ) {
		$register_action = FrmFormAction::get_action_for_form( $form->id, 'register', 1 );

		if ( $register_action ) {
			self::create_user_email_action( $form, $register_action );
			self::create_admin_email_action( $form );
			self::update_action_for_2( $register_action );
		}
	}

	/**
	 * Create an email action from the register action's settings
	 *
	 * @since 2.0
	 * @param object $form
	 * @param object $register_action
	 *
	 * @return int
	 */
	private static function create_user_email_action( $form, $register_action ) {

		// Only create email action if frm_send_new_user_notification returns true and reg_email_send is set
		if ( ! isset( $register_action->post_content['reg_email_sender'] ) ||
			apply_filters( 'frm_send_new_user_notification', true, $form, 0, $register_action ) !== true ) {
			return 0;
		}

		$title = __( 'Email Notification', 'frmreg' );
		$post_content = self::generate_post_content_for_user_email( $form->id, $register_action );

		return self::create_email_action( $form, $post_content, $title );
	}

	/**
	 * Create an admin email action
	 *
	 * @since 2.0
	 *
	 * @param object $form
	 *
	 * @return int|WP_Error|WP_Post
	 */
	private static function create_admin_email_action( $form ) {
		$title = self::default_title_for_admin_email();
		$post_content = self::generate_post_content_for_admin_email( $form->id );

		return self::create_email_action( $form, $post_content, $title );
	}

	/**
	 * Create an email action
	 *
	 * @since 2.0
	 *
	 * @param object $form
	 * @param array $post_content
	 * @param string $title
	 *
	 * @return int|WP_Error|WP_Post
	 */
	private static function create_email_action( $form, $post_content, $title ) {
		$email_action = array(
			'post_title'    => $title,
			'post_content'  => $post_content,
			'post_excerpt'  => 'email',
			'post_status'   => 'publish',
			'post_type'     => FrmFormActionsController::$action_post_type,
			'post_name'     => $form->id . '_email_0',
			'menu_order'    => $form->id,
		);

		return FrmAppHelper::save_settings( $email_action, 'frm_actions' );
	}

	/**
	 * Generate the email action post content from the registration settings
	 *
	 * @since 2.0
	 * @param int $form_id
	 * @param object $register_action
	 *
	 * @return array
	 */
	private static function generate_post_content_for_user_email( $form_id, $register_action ) {
		$register_settings  = $register_action->post_content;

		$from_name = self::get_from_name_for_user_email( $register_settings );
		$from_address = self::get_from_address_for_user_email( $register_settings );
		$subject = self::get_value_from_setting( $register_settings, 'reg_email_subject' );
		$message = self::get_message_for_user_email( $form_id, $register_settings );
		$plain_text = self::get_plain_text_setting();

		$post_content = array(
			'email_to'      => self::default_to_for_user_email( $register_settings ),
            'cc'            => '',
            'bcc'           => '',
            'from'          => $from_name . ' ' . $from_address,
            'reply_to'      => '',
            'email_subject' => $subject,
            'email_message' => $message,
            'inc_user_info' => 0,
            'plain_text'    => $plain_text,
			'event'         => self::registration_email_event(),
		);

		return $post_content;
	}

	/**
	 * Generate the post content for the admin email action
	 *
	 * @since 2.0
	 *
	 * @param int $form_id
	 *
	 * @return array
	 */
	private static function generate_post_content_for_admin_email( $form_id ) {
		$post_content = array(
			'email_to'      => '[admin_email]',
			'cc'            => '',
			'bcc'           => '',
			'from'          => '[sitename] <[admin_email]>',
			'reply_to'      => '',
			'email_subject' => self::default_admin_email_subject(),
			'email_message' => self::default_admin_email_message( $form_id ),
			'inc_user_info' => 0,
			'plain_text'    => 1,
			'event'         => self::registration_email_event(),
		);

		return $post_content;
	}

	/**
	 * Get a value from a registration setting
	 *
	 * @since 2.0
	 * @param array $register_settings
	 * @param string $item_key
	 * @param string $default
	 *
	 * @return string
	 */
	private static function get_value_from_setting( $register_settings, $item_key, $default = '' ) {
		if ( isset( $register_settings[ $item_key ] ) && $register_settings[ $item_key ] ) {
			$value = $register_settings[ $item_key ];
		} else {
			$value = $default;
		}

		return $value;
	}

	/**
	 * Get the from name for the user email action
	 *
	 * @since 2.0
	 * @param array $register_settings
	 *
	 * @return mixed|string
	 */
	private static function get_from_name_for_user_email( $register_settings ) {
		$from_name = self::get_value_from_setting( $register_settings, 'reg_email_from', '[sitename]' );

		if ( $from_name == 'WordPress' ) {
			$from_name = apply_filters( 'wp_mail_from_name', $from_name );
		}

		return $from_name;
	}

	/**
	 * Get the registration from address
	 *
	 * @since 2.0
	 * @param array $register_settings
	 *
	 * @return string
	 */
	private static function get_from_address_for_user_email( $register_settings ) {
		$from_address = self::get_value_from_setting( $register_settings, 'reg_email_sender', '[admin_email]' );

		$sitename = FrmRegAppHelper::get_site_name();
		if ( $from_address == 'wordpress@' . $sitename ) {
			$from_address = apply_filters( 'wp_mail_from', $from_address );
		}

		if ( strpos( $from_address, '<' ) !== 0 ) {
			$from_address = '<' . $from_address . '>';
		}

		return $from_address;
	}

	/**
	 * Get the registration email message
	 *
	 * @since 2.0
	 * @param int $form_id
	 * @param array $register_settings
	 *
	 * @return string
	 */
	private static function get_message_for_user_email( $form_id, $register_settings ) {
		$message = self::get_value_from_setting( $register_settings, 'reg_email_msg' );
		self::replace_shortcodes_in_message( $form_id, $register_settings, $message );

		return $message;
	}

	/**
	 * Replace the username and password shortcodes in the email message
	 *
	 * @since 2.0
	 * @param int $form_id
	 * @param array $register_settings
	 * @param string $message
	 */
	private static function replace_shortcodes_in_message( $form_id, $register_settings, &$message ) {
		$user_id_field = FrmRegEntryHelper::get_user_id_field_for_form( $form_id );
		if ( ! $user_id_field ) {
			return;
		}

		if ( strpos( $message, '[username]' ) !== false ) {
			$message = str_replace( '[username]', '[' . $user_id_field . ' show=user_login]', $message );
		}

		if ( strpos( $message, '[password]' ) !== false ) {
			$password_setting = self::get_value_from_setting( $register_settings, 'reg_password' );
			if ( is_numeric( $password_setting ) ) {
				$message = str_replace( 'Password: [password]', '', $message );
				$message = str_replace( '[password]', __( 'N/A', 'frmreg' ), $message );

			} else {
				$new_password_text = self::default_set_password_message( $user_id_field );

				$message = str_replace( 'Password: [password]', $new_password_text, $message );
				$message = str_replace( '[password]', $new_password_text, $message );
			}
		}
	}

	/**
	 * Check if plain text option should be selected or not
	 *
	 * @since 2.0
	 * @return int
	 */
	private static function get_plain_text_setting() {
		$content_type = apply_filters( 'frmreg_email_content_type', 'plain' );

		if ( $content_type == 'plain' ) {
			$plain_text = 1;
		} else {
			$plain_text = 0;
		}

		return $plain_text;
	}

	/**
	 * Migrate the registration action to 2.0 settings
	 *
	 * @since 2.0
	 * @param object $register_action
	 *
	 * @return int|WP_Error|WP_Post
	 */
	private static function update_action_for_2( $register_action ) {
		self::migrate_user_url_setting( $register_action );
		self::migrate_event_settings( $register_action );

		$register_array = get_object_vars( $register_action );

		return FrmAppHelper::save_settings( $register_array, 'frm_actions' );
	}

	/**
	 * Move the user_url custom user meta to setting
	 *
	 * @since 2.0
	 *
	 * @param object $register_action
	 */
	private static function migrate_user_url_setting( &$register_action ) {
		$register_settings  = $register_action->post_content;

		if ( ! isset( $register_settings['reg_usermeta'] ) || empty( $register_settings['reg_usermeta'] ) ) {
			return;
		}

		foreach ( $register_settings['reg_usermeta'] as $meta_key => $user_meta_vars ) {
			$meta_name = $user_meta_vars['meta_name'];

			if ( $meta_name === 'user_url' ) {

				$register_settings['reg_user_url'] = $user_meta_vars['field_id'];
				unset( $register_settings['reg_usermeta'][ $meta_key ] );
				$register_action->post_content = $register_settings;

				break;
			}
		}
	}

	/**
	 * Set default events to create and update for migrated actions
	 *
	 * @since 2.0
	 *
	 * @param $register_action
	 */
	private static function migrate_event_settings( &$register_action ) {
		$register_action->post_content['event'] = array( 'create', 'update' );
	}

	/**
	 * Get the default title for an admin email notification
	 *
	 * @since 2.0
	 * @return string
	 */
	private static function default_title_for_admin_email() {
		return __( 'Admin Email Notification', 'frmreg' );
	}

	/**
	 * Get the default To settings for a user email
	 *
	 * @since 2.0
	 * @param array $register_settings
	 *
	 * @return string
	 */
	private static function default_to_for_user_email( $register_settings ) {
		$email_field_id = self::get_value_from_setting( $register_settings, 'reg_email' );

		if ( ! $email_field_id ) {
			$to = '';
		} else {
			$to = '[' . $email_field_id . ']';
		}

		return $to;
	}

	/**
	 * Get the default user email subject
	 *
	 * @since 2.0
	 * @return string
	 */
	private static function default_subject_for_user_email() {
		return sprintf( __( 'Welcome to %s', 'frmreg' ), '[sitename]' );
	}

	/**
	 * Get the default user email message
	 *
	 * @since 2.0
	 *
	 * @param $form_id
	 * @param $register_settings
	 *
	 * @return string
	 */
	private static function default_message_for_user_email( $form_id, $register_settings ) {
		$message = '<p>';
		$message .= sprintf( __( 'Thanks for creating an account on %s.', 'frmreg' ), '[sitename]' );

		$user_id_field = FrmRegEntryHelper::get_user_id_field_for_form( $form_id );
		if ( ! $user_id_field ) {
			$message .= "</p>\r\n";
			return $message;
		}

		$shortcode = '[' . $user_id_field . ' show=user_login]';
		$message .= sprintf( __( 'Your username is %s.', 'frmreg' ), $shortcode );
		$message .= "</p>\r\n";

		$password_setting = self::get_value_from_setting( $register_settings, 'reg_password' );
		if ( is_numeric( $password_setting ) ) {
			$string1 = '<a href="' . wp_login_url() . '">';
			$string2 = '</a>';
			$message .= '<p>';
			$message .= sprintf( __( 'You may %1$slog in here%2$s with the username and password you have created.', 'frmreg' ), $string1, $string2 );
			$message .= "</p>\r\n";
		} else {
			$message .= '<p>';
			$message .=  self::default_set_password_message( $user_id_field );
			$message .= "</p>\r\n";
		}

		return $message;
	}

	/**
	 * Get the default set password message
	 *
	 * @since 2.0
	 * @param int $user_id_field
	 *
	 * @return string
	 */
	private static function default_set_password_message( $user_id_field ) {
		$new_password_text = __( 'To set your password, please visit the following address:', 'frmreg' );
		$new_password_text .= "\r\n";
		$new_password_text .= '[frm-set-password-link user_id="[' . $user_id_field . ' show=ID]"]';

		return $new_password_text;
	}

	/**
	 * Get the default admin email subject
	 *
	 * @since 2.0
	 * @return string
	 */
	private static function default_admin_email_subject() {
		return sprintf( __( '[%s] New User Registration' ), '[sitename]' );
	}

	/**
	 * Generate the email message for the admin notification
	 *
	 * @since 2.0
	 *
	 * @param int $form_id
	 *
	 * @return string
	 */
	private static function default_admin_email_message( $form_id ) {
		$message = '<p>';
		$message .= sprintf( __( 'New user registration on your site %s:' ), '[sitename]' );
		$message .= "</p>\r\n\r\n";

		$user_id_field = FrmRegEntryHelper::get_user_id_field_for_form( $form_id );
		if ( ! $user_id_field ) {
			return $message;
		}

		$message .= '<p>';
		$message .= sprintf( __( 'Username: %s' ), '[' . $user_id_field . ' show=user_login]' );
		$message .= "</p>\r\n\<p>";
		$message .= sprintf( __( 'Email: %s' ), '[' . $user_id_field . ' show=user_email]' );
		$message .= "</p>";

		return $message;
	}

	/**
	 * Get the registration email event
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	private static function registration_email_event() {
		return array( 'user_registration' );
	}

	/**
	 * Get all the fields that should appear in user meta options
	 *
	 * @since 2.0
	 *
	 * @param int $form_id
	 *
	 * @return array $fields
	 */
	private static function get_user_meta_fields( $form_id ) {
		$where    = array(
			'fi.form_id'  => $form_id,
			'fi.type not' => FrmField::no_save_fields(),
		);
		$order_by = 'field_order';

		$fields = FrmField::getAll( $where, $order_by );

		return $fields;
	}

	/**
	 * Make sure the form includes a userID field
	 *
	 * @since 2.0
	 *
	 * @param int $form_id
	 */
	private static function add_user_id_field_if_missing( $form_id ) {
		$user_field = FrmField::get_all_types_in_form( $form_id, 'user_id', 1 );
		if ( ! $user_field ) {
			$new_values = FrmFieldsHelper::setup_new_vars( 'user_id', $form_id );
			$new_values['name'] = __( 'User ID', 'frmreg' );
			FrmField::create( $new_values );
		}
	}
}