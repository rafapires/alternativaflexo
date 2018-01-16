<?php

class FrmRegUser {

	private $email = '';
	private $username = '';
	private $password = '';
	private $first_name = '';
	private $last_name = '';
	private $display_name = '';
	private $user_url = '';
	private $user_meta = array();
	private $role = 'subscriber';
	private $user_id = 0;
	private $entry = null;
	private $form = null;

	/**
	 * FrmRegUser constructor
	 *
	 * @param array $settings
	 * @param object $form
	 * @param object $entry
	 * @param string $user_status
	 */
	public function __construct( $settings, $form, $entry, $user_status = 'new' ) {
		$this->entry = $entry;
		$this->form = $form;

		if ( $user_status == 'existing' ) {
			$this->init_user_id();
			if ( $this->user_id === 0 ) {
				return;
			}

			$user_data = get_userdata( $this->user_id );

			if ( $user_data === false ) {
				return;
			}

			$this->init_email( $settings, $user_data );
			$this->init_password( $settings, $user_status );
			$this->init_existing_user_username( $user_data );
			$this->init_first_last( $settings, $user_data );
			$this->init_display_name( $settings );
			$this->init_user_url( $settings );
			$this->init_user_meta( $settings );

		} else {
			$this->init_email( $settings );
			if ( empty( $this->email ) ) {
				return;
			}

			$this->init_password( $settings, $user_status );
			$this->init_username( $settings );
			$this->init_first_last( $settings );
			$this->init_display_name( $settings );
			$this->init_user_url( $settings );
			$this->init_role( $settings );
			$this->init_user_meta( $settings );
		}
	}

	/**
	 * Set the email property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param null|WP_User $user_data
	 */
	private function init_email( $settings, $user_data = null ) {
		if ( ! isset( $settings['reg_email'] ) ) {
			return;
		}

		$this->init_property( $settings, 'email' );

		if ( empty( $this->email ) && is_object( $user_data ) ) {
			$this->email = $user_data->user_email;
		}
	}

	/**
	 * Set the password property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param string $user_status
	 */
	private function init_password( $settings, $user_status ) {
		$this->init_property( $settings, 'password' );

		if ( ! empty( $this->password ) ) {
			$this->password = addslashes( $this->password );
		}

		if ( $user_status == 'new' && empty( $this->password ) ) {
			$this->password = wp_generate_password( 12, false );
		}
	}

	/**
	 * Set the username property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_username( $settings ) {

		if ( empty( $settings['reg_username'] ) ) {
			// Username is generated from the email
			$parts          = explode( '@', $this->email );
			$this->username = $parts[ 0 ];

		} else if ( $settings['reg_username'] == '-1' ) {
			// Username is generated from the full email
			$this->username = $this->email;

		} else {
			$this->init_property( $settings, 'username' );
		}

		if ( FrmRegAppHelper::username_exists( $this->username ) ) {
			$this->username = $this->generate_unique_username( $this->username );
		}
	}

	/**
	 * Set the username property for an existing user
	 * Username cannot be edited at this time
	 *
	 * @since 2.0
	 *
	 * @param object $user_data
	 */
	private function init_existing_user_username( $user_data ) {
		$this->username = $user_data->user_login;
	}

	/**
	 * Set the first and last name properties for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param null|WP_User $user_data
	 */
	private function init_first_last( $settings, $user_data = null ) {
		$properties = array( 'first_name', 'last_name' );

		foreach ( $properties as $property ) {
			$this->init_property( $settings, $property );

			if ( empty( $this->{$property} ) && is_object( $user_data ) ) {
				$this->{$property} = $user_data->{$property};
			}
		}
	}

	/**
	 * Set the display name property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_display_name( $settings ) {
		if ( ! isset( $settings['reg_display_name'] ) ) {
			return;
		}

		if ( empty( $settings['reg_display_name'] ) ) {
			// Display name should match username
			$this->display_name = $this->username;

		} else if ( is_numeric( $settings['reg_display_name'] ) ) {
			// Display name is set as a specific field
			$this->init_property( $settings, 'display_name' );

		} else if ( $settings['reg_display_name'] == 'display_firstlast' ) {
			// Display name is first name-last name
			$this->display_name = $this->first_name . ' ' . $this->last_name;

		} else if ( $settings['reg_display_name'] == 'display_lastfirst' ) {
			// Display name is last and first name
			$this->display_name = $this->last_name . ' ' . $this->first_name;
		}
	}

	/**
	 * Set the user_url property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_user_url( $settings ) {
		if ( ! isset( $settings['reg_user_url'] ) ) {
			return;
		}

		$this->init_property( $settings, 'user_url' );
	}

	/**
	 * Set the role property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_role( $settings ) {
		$role   = isset( $settings['reg_role'] ) ? $settings['reg_role'] : 'subscriber';

		$this->role = apply_filters( 'frmreg_new_role', $role, array( 'form' => $this->form, 'entry' => $this->entry ) );
		if ( ! $this->role ) {
			$this->role = 'subscriber';
		}
	}

	/**
	 * Set the user_id property for the FrmRegUser object
	 *
	 * @since 2.0
	 */
	private function init_user_id() {
		if ( isset( $this->entry->user_id ) && $this->entry->user_id ) {
			$this->user_id = absint( $this->entry->user_id );
		}
	}

	/**
	 * Set a specific property if a field is selected for the setting and that field has a value
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @param string $property
	 */
	private function init_property( $settings, $property ) {
		$opt = $settings['reg_' . $property ];
		if ( FrmRegEntryHelper::is_field_selected_and_value_saved( $this->entry, $opt ) ) {
			$this->$property = html_entity_decode( $this->entry->metas[ $opt ] );
		}
	}

	/**
	 * Set the user_meta property for the FrmRegUser object
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_user_meta( $settings ) {
		$this->init_avatar( $settings );
		$this->init_custom_meta( $settings );
	}

	/**
	 * Set the frm_avatar_id item in the user_meta property (if needed)
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 */
	private function init_avatar( $settings ) {
		if ( ! isset( $settings['reg_avatar'] ) ) {
			return;
		}

		$avatar_setting = $settings['reg_avatar'];
		if ( is_numeric( $avatar_setting ) && ! empty( $this->entry->metas[ $avatar_setting ] ) ) {
			$this->user_meta['frm_avatar_id'] = (int) $this->entry->metas[ $avatar_setting ];
		}
	}

	/**
	 * Add custom meta to the user_meta property
	 *
	 * @since 2.0
	 *
	 * @param $settings
	 */
	private function init_custom_meta( $settings ) {
		if ( ! isset( $settings['reg_usermeta'] ) || empty( $settings['reg_usermeta'] ) ) {
			return;
		}

		foreach ( $settings['reg_usermeta'] as $user_meta_row ) {

			$meta_key = $user_meta_row['meta_name'];
			$field_id = $user_meta_row['field_id'];

			$meta_val                     = isset( $this->entry->metas[ $field_id ] ) ? $this->entry->metas[ $field_id ] : '';
			$this->user_meta[ $meta_key ] = $meta_val;
		}
	}

	/**
	 * Create a new user
	 *
	 * @since 2.0
	 *
	 * @return int
	 */
	public function create() {
		if ( ! $this->email ) {
			return 0;
		}

		$user_data = $this->package_user_data( 'create' );

		$user_id = wp_insert_user( $user_data );

		$this->user_id = is_wp_error( $user_id ) ? 0 : (int) $user_id;

		if ( $this->user_id ) {
			$this->update_user_meta();
		}

		return $this->user_id;
	}

	/**
	 * Update an existing user
	 *
	 * @since 2.0
	 *
	 * @return int|WP_Error
	 */
	public function update() {
		if ( $this->user_id === 0 ) {
			return 0;
		}

		$user_data = $this->package_user_data( 'update' );

		$updated = wp_update_user( $user_data );

		if ( $updated ) {
			$this->update_user_meta();
		}

		return $updated;
	}

	/**
	 * Check if a new password is set in profile update
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	public function is_new_password_set() {
		return ( ! empty ( $this->password ) );
	}

	/**
	 * Get the password property
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_password() {
		return $this->password;
	}

	/**
	 * Get the username property
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_username() {
		return $this->username;
	}

	/**
	 * Get the role
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_role() {
		return $this->role;
	}

	/**
	 * Get the user_id property
	 *
	 * @since 2.0
	 * @return int
	 */
	public function get_user_id() {
		return $this->user_id;
	}

	/**
	 * Get the ID of the form that is registering the user
	 *
	 * @since 2.0
	 *
	 * @return int
	 */
	public function get_form_id() {
		return $this->form->id;
	}

	/**
	 * Package the data in the users table for creating/updating
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	private function package_user_data( $user_event ) {
		$user_data = array();

		$properties = array(
			'ID'           => 'user_id',
			'user_pass'    => 'password',
			'user_email'   => 'email',
			'user_login'   => 'username',
			'first_name'   => 'first_name',
			'last_name'    => 'last_name',
			'display_name' => 'display_name',
			'user_url'     => 'user_url',
		);

		if ( ! $this->user_id ) {
			// Only set the role initially - do not change the role when updating profile
			$properties['role'] = 'role';
		}

		foreach ( $properties as $user_field => $property ) {
			$user_data[ $user_field ] = $this->$property;
		}

		$user_data = apply_filters( 'frmreg_user_data', $user_data, array(
			'action' => $user_event,
			'form'   => $this->form
		) );

		return $user_data;
	}

	/**
	 * Update the user meta for the given user
	 *
	 * @since 2.0
	 */
	private function update_user_meta() {
		foreach ( $this->user_meta as $meta_key => $meta_val ) {
			update_user_meta( $this->user_id, $meta_key, $meta_val );
		}
	}

	/**
	 * Generate a unique username given a non-unique username string
	 *
	 * @since 2.0
	 *
	 * @param string $username
	 * @param int $count
	 *
	 * @return string
	 */
	private function generate_unique_username( $username, $count=0 ) {
		$count = (int) $count;
		$new_username = ($count > 0) ? $username . $count : $username;

		if ( FrmRegAppHelper::username_exists( $new_username ) ) {
			$new_username = $this->generate_unique_username( $username, $count+1 );
		}

		return sanitize_user( $new_username, true );
	}
}