<?php

/**
 * @since 2.0
 */
class FrmRegSubsiteController {

	/**
	 * Create subsite if settings are configured
	 *
	 * @since 2.0
	 *
	 * @param FrmRegUser $user
	 * @param array $settings
	 * @param stdClass $entry
	 */
	public static function maybe_create_subsite( $user, $settings, $entry ) {
		if ( self::is_create_subsite_checked( $settings ) ) {
			$subsite = new FrmRegSubsite( $user, $settings, $entry );
			$subsite->create();
		}
	}

	/**
	 * Check if a subsite needs to be created
	 *
	 * @since 2.0
	 *
	 * @param array $settings
	 * @return bool
	 */
	private static function is_create_subsite_checked( $settings ) {
		return ( is_multisite() && $settings['create_subsite'] );
	}

}