<?php
/**
 * @since 2.01
 */

class FrmRegAvatar {

	/**
	 * @var string
	 * @since 2.01
	 */
	private $default;

	/**
	 * @var int
	 * @since 2.01
	 */
	private $user_id;

	/**
	 * @var int
	 * @since 2.01
	 */
	private $avatar_id;

	/**
	 * Actual image size
	 *
	 * @var string
	 * @since 2.01
	 */
	private $img_size;

	/**
	 * @var string
	 * @since 2.01
	 */
	private $alt;

	/**
	 * @var string
	 * @since 2.01
	 */
	private $url;

	/**
	 * @var string
	 * @since 2.01
	 */
	private $css_class;

	/**
	 * FrmRegAvatar constructor
	 *
	 * @since 2.01
	 *
	 * @param int|string|object $id_or_email
	 * @param string $default
	 * @param array $args
	 */
	public function __construct( $id_or_email, $default, $args ) {
		$this->init_default( $default );

		$this->init_user_id( $id_or_email );
		if ( $this->user_id === 0 ) {
			return;
		}

		$this->init_avatar_id();
		if ( ! $this->avatar_id ) {
			return;
		}

		$this->init_img_size( $args );
		$this->init_url();
		if ( empty( $this->url ) ) {
			return;
		}

		$this->init_alt( $args );
		$this->init_css_class();
	}

	/**
	 * Initialize the default property
	 *
	 * @since 2.01
	 *
	 * @param string $default
	 */
	private function init_default( $default ) {
		$this->default = $default;
	}

	/**
	 * Initialize the user_id property
	 *
	 * @since 2.01
	 *
	 * @param mixed $user_info
	 */
	private function init_user_id( $user_info ) {
		$this->user_id = 0;

		if ( is_numeric( $user_info ) ) {
			$this->user_id = (int) $user_info;
		} else if ( is_string( $user_info ) ) {
			$user = get_user_by( 'email', $user_info );

			if ( $user ) {
				$this->user_id = (int) $user->ID;
			}
		} else if ( is_object( $user_info ) && ! empty( $user_info->user_id ) ) {
			$this->user_id = (int) $user_info->user_id;
		}
	}

	/**
	 * Initialize the avatar_id property
	 *
	 * @since 2.01
	 */
	private function init_avatar_id() {
		$this->avatar_id = get_user_meta( $this->user_id, 'frm_avatar_id', true );
	}

	/**
	 * Initialize the url property
	 *
	 * @since 2.01
	 */
	private function init_url() {
		if ( is_callable( 'FrmProFieldsHelper::get_displayed_file_html' ) ) {
			$this->url = FrmProFieldsHelper::get_displayed_file_html( (array) $this->avatar_id, $this->get_size_parameter() );
		} else {
			$this->url = '';
		}
	}

	/**
	 * Initialize the img_size property
	 *
	 * @since 2.01
	 *
	 * @param array $args
	 */
	private function init_img_size( $args ) {
		if ( ! isset( $args['size'] ) || ! is_numeric( $args['size'] ) ) {
			// ensure valid size
			$this->img_size = '96';
		} else {
			$this->img_size = $args[ 'size' ];
		}
	}

	/**
	 * Initialize the alt property
	 *
	 * @since 2.01
	 *
	 * @param array $args
	 */
	private function init_alt( $args ) {
		if ( ! isset( $args['alt'] ) || empty( $args['alt'] ) ) {
			$this->alt = get_the_author_meta( 'display_name', $this->user_id );
		} else {
			$this->alt = $args['alt'];
		}
	}

	/**
	 * Initialize the css_class property
	 *
	 * @since 2.01
	 */
	private function init_css_class() {
		$author_class = is_author( $this->user_id ) ? ' current-author' : '';
		$this->css_class = "avatar avatar-{$this->img_size}{$author_class} photo";
	}

	/**
	 * Get the size parameter
	 *
	 * @since 2.01
	 *
	 * @return string
	 */
	private function get_size_parameter() {
		if ( $this->img_size < 150 ) {
			$size = 'thumbnail';
		} else if ( $this->img_size < 250 ) {
			$size = 'medium';
		} else {
			$size = 'full';
		}

		return $size;
	}

	/**
	 * Get the HTML for an avatar
	 *
	 * @since 2.01
	 *
	 * @return string
	 */
	public function get_html() {
		if ( ! empty( $this->url ) ) {
			$avatar = "<img alt='" . esc_attr( $this->alt ) . "' src='" . $this->url . "' class='{$this->css_class}' height='{$this->img_size}' width='{$this->img_size}' />";
		} else {
			$avatar = $this->default;
		}

		return $avatar;
	}
}