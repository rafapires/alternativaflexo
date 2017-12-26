<?php

/**
 * @since 2.0
 */
class FrmRegDb {

	private $new_db_version = 0;
	private $current_db_version = 0;
	private $option_name = 'frm_reg_db';
	private $migrations = array( 2, 3 );

	/**
	 * FrmRegDb constructor
	 * @since 2.0
	 */
	public function __construct() {
		$this->init_new_db_version();
		$this->init_current_db_version();

		if ( $this->is_initial_install() ) {
			$this->initialize_db();
		}
	}

	/**
	 * Set the new db version property
	 *
	 * @since 2.0
	 */
	private function init_new_db_version() {
		$this->new_db_version = (int) end( $this->migrations );
	}

	/**
	 * Set the current db version property
	 *
	 * @since 2.0
	 */
	private function init_current_db_version() {
		$this->current_db_version = (int) get_option( $this->option_name );
	}

	/**
	 * Determine if this is an initial install
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	private function is_initial_install() {
		$is_first_install = false;

		if ( $this->current_db_version === 0 ) {

			$saved_settings = get_option( 'frm_reg_options' );
			if ( $saved_settings === false && ! FrmRegActionHelper::registration_action_exists_in_db() ) {
				$is_first_install = true;
			}
		}

		return $is_first_install;
	}

	/**
	 * Initialize the database
	 *
	 * @since 2.0
	 */
	private function initialize_db() {
		$this->update_db_version();
		$this->update_stylesheet();
	}

	/**
	 * Save the db version to the database
	 *
	 * @since 2.0
	 */
	private function update_db_version() {
		update_option( $this->option_name, $this->new_db_version );
		$this->current_db_version = $this->new_db_version;
	}

	/**
	 * Check if registration settings need migrating
	 *
	 * @since 2.0
	 * @return bool
	 */
	public function need_to_migrate_settings() {
		return $this->current_db_version < $this->new_db_version;
	}

	/**
	 * Migrate data to current version, if needed
	 *
	 * @since 2.0
	 */
	public function migrate() {
		$this->migrate_to_new_version();
		$this->update_db_version();
	}

	/**
	 * Update the Formidable stylesheet so it includes registration add-on styling
	 *
	 * @since 2.0
	 */
	private function update_stylesheet() {
		if ( is_admin() && function_exists( 'get_filesystem_method' ) ) {
			$frm_style = new FrmStyle();
			$frm_style->update( 'default' );
		}
	}

	/**
	 * Go through all necessary migrations in order to migrate db to the current version
	 *
	 * @since 2.0
	 */
	private function migrate_to_new_version() {
		foreach ( $this->migrations as $migrate_to_version ) {
			if ( $this->current_db_version < $migrate_to_version ) {
				$function_name = 'migrate_to_' . $migrate_to_version;
				$this->$function_name();
			}
		}
	}

	/**
	 * Convert registration settings to register action
	 *
	 * @since 2.0
	 */
	private function migrate_to_2() {
		$forms = FrmForm::getAll();

		foreach ( $forms as $form ) {
			FrmRegActionController::migrate_settings_to_action( $form );
			FrmRegActionController::migrate_registration_actions_to_2( $form );
		}
	}

	/**
	 * Convert registration settings to register action
	 *
	 * @since 2.0
	 */
	private function migrate_to_3() {
		$this->update_stylesheet();
	}
}