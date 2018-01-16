<?php

class FrmRegAppController{

	/**
	 * Load the translations
	 */
	public static function load_lang() {
		load_plugin_textdomain( 'frmreg', false, FrmRegAppHelper::plugin_folder() . '/languages/' );
	}

	/**
	 * Print a notice if Formidable is too old to be compatible with the registration add-on
	 */
	public static function min_version_notice() {
		if ( FrmRegAppHelper::is_formidable_compatible() ) {
			return;
		}

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
		echo '<tr class="plugin-update-tr active"><th colspan="' . absint( $wp_list_table->get_column_count() ) . '" class="check-column plugin-update colspanchange"><div class="update-message">' .
			__( 'You are running an outdated version of Formidable. This plugin will not work correctly if you do not update Formidable.', 'frmreg' ) .
			'</div></td></tr>';
	}

	/**
	 * Adds the updater
	 * Called by the admin_init hook
	 */
	public static function include_updater() {
		if ( class_exists( 'FrmAddon' ) ) {
			FrmRegUpdate::load_hooks();
		}
	}

	/**
	 * Migrate settings if needed
	 *
	 * @since 2.0
	 */
	public static function initialize() {
		if ( ! FrmRegAppHelper::is_formidable_compatible() ) {
			return;
		}

		$frm_reg_db = new FrmRegDb();
		if ( $frm_reg_db->need_to_migrate_settings() ) {
			$frm_reg_db->migrate();
		}
	}

	/**
	 * Display admin notices if Formidable is too old or registration settings need to be migrated
	 *
	 * @since 2.0
	 */
	public static function display_admin_notices(){

		// Don't display notices as we're upgrading
		$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '';
		if ( $action == 'upgrade-plugin' && ! isset( $_GET['activate'] ) ) {
			return;
		}

		// Show message if Formidable is not compatible
		if ( ! FrmRegAppHelper::is_formidable_compatible() ) {
			include( FrmRegAppHelper::path() . '/views/update_formidable.php' );
			return;
		}

		// Add Update button
		$frm_reg_db = new FrmRegDb();
		if ( $frm_reg_db->need_to_migrate_settings() ) {
			if ( is_callable( 'FrmAppHelper::plugin_url' ) ) {
				$url = FrmAppHelper::plugin_url();
			} else if ( defined( 'FRM_URL' ) ) {
				$url = FRM_URL;
			} else {
				return;
			}

			include( FrmRegAppHelper::path() . '/views/update_database.php' );
		}
	}

	/**
	 * Load the login form CSS
	 *
	 * @since 2.0
	 */
	public static function add_login_form_css() {
		include( FrmRegAppHelper::path() . '/css/login_form.css' );
	}

	/***********************************************************************
	* Deprecated Functions
	************************************************************************/

	public static function migrate_to_2() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegDb->migrate' );

		$frm_reg_db = new FrmRegDb();
		if ( $frm_reg_db->need_to_migrate_settings() ) {
			$frm_reg_db->migrate();
		}
	}

	public static function create_user_trigger( $action, $entry, $form ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegUserController::register_user' );
		FrmRegUserController::register_user( $action, $entry, $form );
	}

	public static function update_user_trigger( $action, $entry, $form ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegUserController::register_user' );
		FrmRegUserController::register_user( $action, $entry, $form );
	}

	public static function create_user() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegUserController::register_user' );
	}

	public static function update_user() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegUserController::register_user' );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function auto_login() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegUserHelper::log_user_in' );
	}
	
	public static function load_form_settings_hooks() {
		_deprecated_function( __FUNCTION__, '2.0', 'updated version of Formidable Pro' );
	}
	
	public static function register_actions( $actions ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegActionController::register_actions' );
		return FrmRegActionController::register_actions( $actions );
	}

	public static function add_registration_options() {
		_deprecated_function( __FUNCTION__, '2.0', 'updated version of Formidable Pro' );
	}

	public static function registration_options() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}
	
	public static function _usermeta_row() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegActionController::add_user_meta_row' );
		FrmRegActionController::add_user_meta_row();
	}
	
	public static function get_default_value( $value, $field ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegEntry::reset_user_id_for_user_creation' );
		return FrmRegEntry::reset_user_id_for_user_creation( $value, $field );
	}

	public static function setup_new_vars() {
		_deprecated_function( __FUNCTION__, '2.0', 'updated version of Formidable Pro' );
	}

	public static function setup_edit_vars() {
		_deprecated_function( __FUNCTION__, '2.0', 'updated version of Formidable Pro' );
	}

	public static function update_options( $options, $values ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegActionController::before_update_form' );
		return FrmRegActionController::before_update_form( $options, $values );
	}

	public static function hidden_form_fields($form) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegEntryController::insert_hidden_fields' );
		$entry_controller = new FrmRegEntryController();
		$entry_controller->insert_hidden_fields( $form );
	}

	public static function validate() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegEntryController::validate_entry' );
	}

	public static function prevent_pending_login( $user ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::prevent_pending_login' );
		return FrmRegLoginController::prevent_pending_login( $user );
	}

	public static function prevent_password_reset( $allow, $user_id ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegResetPasswordController::prevent_password_reset' );
		return FrmRegResetPasswordController::prevent_password_reset( $allow, $user_id );
	}

	public static function activate_url() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegModerationController::do_activation_link' );
		FrmRegModerationController::do_activation_link();
	}

	public static function print_activation_messages( $content ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegModerationController::print_activation_messages' );
		return FrmRegModerationController::print_activation_messages( $content );
	}

	public static function add_settings_section( $sections ) {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return $sections;
	}

	public static function route() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}

	public static function display_form() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}

	public static function process_form() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}

	public static function check_for_blank_login( $user ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::redirect_at_authenticate_when_error' );
		return FrmRegLoginController::redirect_at_authenticate_when_error( $user );
	}

	public static function redirect_to_login_page() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::redirect_to_selected_login_page' );
		FrmRegLoginController::redirect_to_selected_login_page();
	}

	public static function stop_the_email() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code');
	}

	public static function resend_activation_notification() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegEmailController::resend_activation_email');
		FrmRegEmailController::resend_activation_email();
	}

	public static function print_login_messages( $message ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::print_login_messages');
		FrmRegLoginController::print_login_messages( $message );
	}

	public static function check_updated_user_meta( $values, $field, $entry_id=false ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegEntry::check_updated_user_meta');
		FrmRegEntry::check_updated_user_meta( $values, $field, $entry_id );
	}

	public static function show_usermeta() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegProfileController::show_user_meta');
		FrmRegProfileController::show_user_meta();
	}

	public static function login_form( $atts ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegShortcodesController::do_login_form_shortcode');
		return FrmRegShortcodesController::do_login_form_shortcode( $atts );
	}

	public static function get_avatar( $avatar = '', $id_or_email, $size = '96', $default = '', $alt = false ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegAvatarController::get_avatar');
		FrmRegAvatarController::get_avatar( $avatar, $id_or_email, $size, $default, $alt );
	}

	public static function control_login_redirect( $redirect_to ) {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code');
		return $redirect_to;
	}

	public static function add_login_shortcode( $shortcodes ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegShortcodesController::add_login_form_to_sc_builder' );
		return FrmRegShortcodesController::add_login_form_to_sc_builder( $shortcodes );
	}

	public static function login_sc_opts( $opts, $shortcode ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegShortcodesController::get_login_form_sc_opts' );
		return FrmRegShortcodesController::get_login_form_sc_opts( $opts, $shortcode );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function widget_text_filter( $content ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegWidgetController::widget_text_filter');
		FrmRegWidgetController::widget_text_filter( $content );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function register_widgets() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegWidgetController::register_widgets' );
		FrmRegWidgetController::register_widgets();
	}

	/**
	 * @deprecated 2.0
	 */
	public static function on_frmreg_activation(){
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegAppController::initialize' );
		self::initialize();
	}

}
