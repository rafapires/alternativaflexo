<?php
/**
 * @since 2.01
 */
class FrmRegAvatarController{

	/**
	 * Get the avatar
	 *
	 * @since 2.01
	 *
	 * @param string $avatar
	 * @param $id_or_email
	 * @param string $size
	 * @param string $default
	 * @param bool $alt
	 * @param array $args
	 *
	 * @return string
	 */
	public static function get_avatar( $avatar = '', $id_or_email, $size = '96', $default = '', $alt = false, $args = array() ) {
		// Don't override the default, and stop here if Pro is not installed
		if ( ( isset( $args['force_default'] ) && $args['force_default'] ) ||
			 ! is_callable( 'FrmProFieldsHelper::get_displayed_file_html' ) ) {
			return $avatar;
		}

		$image_args = array(
			'size' => $size,
			'alt'  => $alt,
		);
		$avatar = new FrmRegAvatar( $id_or_email, $avatar, $image_args );

		return $avatar->get_html();
	}
}