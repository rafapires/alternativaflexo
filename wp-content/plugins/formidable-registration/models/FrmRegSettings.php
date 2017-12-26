<?php

/**
 * Deprecated since 2.0
 * Class FrmRegSettings
 */
class FrmRegSettings {

	public static function format_usermeta_settings( $settings ) {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return $settings['reg_usermeta'];
	}

	public static function get_usermeta_key_for_field() {
		_deprecated_function( __FUNCTION__, '2.0', 'custom code' );
		return '';
	}
}
