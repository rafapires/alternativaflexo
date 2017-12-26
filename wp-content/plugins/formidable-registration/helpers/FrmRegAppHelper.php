<?php
 
class FrmRegAppHelper{

	private static $min_formidable_version = 2.0;

	/**
	 * Get the plugin path
	 *
	 * @return string
	 */
	public static function path() {
		return dirname( dirname( __FILE__ ) );
	}

	/**
	 * Get the plugin folder
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function plugin_folder() {
		return basename( self::path() );
	}

	/**
	 * Get the plugin URL
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return plugins_url( '', self::path() . '/formidable-registration.php' );
	}

	/**
	 * Check if the current version of Formidable is compatible with Registration add-on
	 *
	 * @since 2.0
	 * @return mixed
	 */
	public static function is_formidable_compatible() {
		$frm_version = is_callable( 'FrmAppHelper::plugin_version' ) ? FrmAppHelper::plugin_version() : 0;

		return version_compare( $frm_version, self::$min_formidable_version, '>=' );
	}

	/**
	 * Get the current site name
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public static function get_site_name() {
		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	/**
	 * Enqueue the admin JS file
	 *
	 * @since 2.0
	 */
	public static function enqueue_admin_js() {
		wp_register_script( 'frmreg_admin', self::plugin_url() . '/js/back_end.js' );

		wp_localize_script( 'frmreg_admin', 'frmRegGlobal', array(
			'nonce'        => wp_create_nonce( 'frm_ajax' ),
		) );

		if ( self::is_form_settings_page() ) {
			wp_enqueue_script( 'frmreg_admin' );
		}
	}

	/**
	 * Check if the current page is the form settings page
	 *
	 * @since 2.0
	 *
	 * @return bool
	 */
	private static function is_form_settings_page() {
		$is_form_settings_page = false;

		$page = FrmAppHelper::simple_get( 'page', 'sanitize_title' );
		$action = FrmAppHelper::simple_get( 'frm_action', 'sanitize_title' );

		if ( $page === 'formidable' && $action === 'settings' ) {
			$is_form_settings_page = true;
		}

		return $is_form_settings_page;
	}

	/**
	 * Echo 'checked="checked"' if a given value exists in an array
	 *
	 * @param array $array
	 * @param string $current
	 */
    public static function array_checked( $array, $current ) {
        if ( ! empty( $array ) && in_array( $current, $array ) ) {
            echo " checked='checked'";
        }
    }

	/**
	 * Check if the current user has permission to create new users with the given form action
	 *
	 * @since 2.0
	 *
	 * @param WP_Post $action
	 * @return bool
	 */
	public static function current_user_can_create_users( $action ) {
		$can_create = false;
		$capability = apply_filters( 'frmreg_required_role', '' );

		if ( FrmAppHelper::is_admin() ) {
			$can_create = true;
		} else if ( $capability !== '' ) {
			$can_create = current_user_can( $capability );
		} else {
			if ( isset( $action->post_content['reg_create_users'] ) && $action->post_content['reg_create_users'] === 'allow' ) {

				// Check if current user's role(s) is within selected roles
				foreach ( $action->post_content['reg_create_role'] as $selected_role ) {
					if ( current_user_can( $selected_role ) ) {
						$can_create = true;
						break;
					}
				}
			}
		}

		return $can_create;
	}

	/**
	 * Check if the current user can update the profile of the selected user ID
	 *
	 * @since 2.0
	 *
	 * @param int|string $profile_user_id
	 * @param WP_Post $register_action
	 *
	 * @return bool
	 */
	public static function current_user_can_update_profile( $profile_user_id, $register_action ) {
		$can_update = false;
		$profile_user_id = (int) $profile_user_id;
		$current_user_id = get_current_user_id();

		if ( current_user_can( 'administrator' ) ) {
			$can_update = true;
		} else if ( $profile_user_id && $current_user_id ) {

			if ( $profile_user_id == $current_user_id || self::current_user_can_create_users( $register_action ) ) {
				$can_update = true;
			}

		}

		return $can_update;
	}

    public static function username_exists($username){
        $username = sanitize_user($username, true);
        
        if(!function_exists('username_exists'))
            require_once(ABSPATH . WPINC . '/registration.php');
        
        return username_exists( $username );
    }

    public static function add_tooltip( $name, $class = 'closed' ) {
        $tooltips = array(
            'mod_email'     => __('Require new users to confirm their e-mail address before they may log in.', 'frmreg'),
            'mod_admin'     => __('Require new users to be approved by an administrator before they may log in.', 'frmreg'),
            'mod_redirect'  => __('Select the page where users will be redirected after clicking the activation link.', 'frmreg'),
            'create_subsite'=> __('Create a new subdomain or subdirectory when a user registers with this form.', 'frmreg'),
        );

        if ( !isset($tooltips[$name]) ) {
            return;
        }

        if ( 'open' == $class ) {
            echo ' frm_help"';
        } else {
            echo ' class="frm_help"';
        }

        echo ' title="'. esc_attr($tooltips[$name]);

        if ( 'open' != $class ) {
            echo '"';
        }
    }

	/*----------------Deprecated Functions--------------------*/

	/**
	 * @deprecated 2.0
	 */
	public static function global_login_page_id() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::login_page_id' );
		return FrmRegLoginController::login_page_id();
	}

	/**
	 * @deprecated 2.0
	 */
	public static function get_login_url( $params ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginController::login_page_url' );
		$login_url = FrmRegLoginController::login_page_url( 'wordpress' );
		$login_url = add_query_arg( $params, $login_url );

		return $login_url;
	}

	/**
	 * @deprecated 2.0
	 */
	public static function maybe_activate_user() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function create_ajax_url( $params ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegModerationController::create_ajax_url' );
		return FrmRegModerationController::create_ajax_url( $params );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function validate_activation_link() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
	}

	/**
	 * @deprecated 2.0
	 */
	public static function get_default_options(){
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegActionHelper::get_default_options' );
		return FrmRegActionHelper::get_default_options();
	}

	/**
	 * @deprecated 2.0
	 */
	public static function is_below_2() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegAppHelper::is_formidable_compatible' );
		return ! FrmRegAppHelper::is_formidable_compatible();
	}

	/**
	 * @deprecated 2.0 - Private FrmRegLoginForm::add_login_messages function replaces this
	 */
	public static function print_messages() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginForm::get_html' );
	}

	/**
	 * @deprecated 2.0 - Private FrmRegLoginForm::get_redirect_to function replaces this
	 */
	public static function get_redirect_to() {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegLoginForm::get_html' );
		return '';
	}

	/**
	 * @deprecated 2.0 - Private FrmRegUser::generate_unique_username function replaces this
	 */
	public static function generate_unique_username(){
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return '';
	}

	/**
	 * @deprecated 2.0 - Private FrmRegEntry::get_user_for_entry function replaces this
	 */
	public static function get_user_for_entry() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return 0;
	}

	/**
	 * @deprecated 2.0 - Private FrmRegModerationController::get_registration_settings_for_user function replaces this
	 */
	public static function get_form_settings() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return array();
	}

	/**
	 * @deprecated 2.0 - Private FrmRegModerationController::get_entry_for_user function replaces this
	 */
	public static function get_entry_for_user() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return false;
	}

	/**
	 * @deprecated 2.0 - Private FrmRegModerationController::get_form_for_user function replaces this
	 */
	public static function get_form_from_entry() {
		return false;
	}

	/**
	 * @deprecated 2.0 - FrmRegActionHelper::get_registration_settings_for_form() replaces this
	 *
	 * @param object|int $form
	 * @return array
	 */
	public static function get_registration_settings( $form ) {
		_deprecated_function( __FUNCTION__, '2.0', 'FrmRegActionHelper::get_registration_settings_for_form' );
		return FrmRegActionHelper::get_registration_settings_for_form( $form );
	}

}
