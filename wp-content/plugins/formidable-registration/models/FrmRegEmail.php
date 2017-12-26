<?php
/**
 * @since 2.01
 */

class FrmRegEmail {

	/**
	 * @since 2.01
	 * @var WP_User
	 */
	private $user;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $activation_key;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $user_email;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $user_login;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $subject;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $message;

	/**
	 * @since 2.01
	 * @var string
	 */
	private $content_type;

	/**
	 * FrmRegEmail constructor
	 *
	 * @since 2.01
	 *
	 * @param int $user_id
	 * @param string $key
	 */
	public function __construct( $user_id, $key ) {
		$this->init_user( $user_id );
		if ( ! $this->user ) {
			return;
		}

		$this->init_user_email();
		$this->init_user_login();
		$this->init_activation_key( $key );

		$this->init_subject();
		$this->init_message();
		$this->init_content_type();
	}

	/**
	 * Initialize user property
	 *
	 * @since 2.01
	 *
	 * @param int $user_id
	 */
	private function init_user( $user_id ) {
		$this->user = new WP_User( $user_id );
	}

	/**
	 * Initialize user_email property
	 *
	 * @since 2.01
	 */
	private function init_user_email() {
		$this->user_email = stripslashes( $this->user->user_email );
	}

	/**
	 * Initialize user_login property
	 *
	 * @since 2.01
	 */
	private function init_user_login() {
		$this->user_login = stripslashes( $this->user->user_login );
	}

	/**
	 * Initialize activation_key property
	 *
	 * @since 2.01
	 *
	 * @param string $key
	 */
	private function init_activation_key( $key ) {
		if ( empty( $key ) ) {
			$this->activation_key = $this->user->user_activation_key;

			if ( empty( $this->activation_key ) ) {
				$this->activation_key = FrmRegModerationHelper::generate_activation_key( $this->user_login );
			}
		} else {
			$this->activation_key = $key;
		}
	}

	/**
	 * Initialize subject property
	 *
	 * @since 2.01
	 */
	private function init_subject() {
		$title = sprintf( __( '[%s] Activate Your Account', 'frmreg' ), FrmRegAppHelper::get_site_name() );

		$this->subject = apply_filters( 'user_activation_notification_title',   $title,   $this->user->ID );
	}

	/**
	 * Initialize message property
	 *
	 * @since 2.01
	 */
	private function init_message() {
		// Create activation URL
		$params = array('action' => 'frm_activate_user', 'key' => $this->activation_key, 'login' => rawurlencode( $this->user_login ) );
		$activation_url = FrmRegModerationController::create_ajax_url( $params );

		$blogname = FrmRegAppHelper::get_site_name();
		$message  = sprintf( __( 'Thanks for registering at %s! To complete the activation of your account please click the following link: ', 'frmreg' ), $blogname ) . "\r\n\r\n";
		$message .=  $activation_url . "\r\n";

		$this->message = apply_filters( 'user_activation_notification_message', $message, $activation_url, $this->user->ID );
	}

	/**
	 * Initialize content_type property
	 *
	 * @since 2.01
	 */
	private function init_content_type() {
		$this->content_type = apply_filters('frmreg_email_content_type', 'plain', array('email' => 'activation'));
	}

	/**
	 * Send the activation email
	 *
	 * @since 2.01
	 */
	public function send() {
		if ( ! $this->user ) {
			return;
		}

		if ( $this->content_type != 'plain' ) {
			add_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
		}

		wp_mail( $this->user_email, $this->subject, $this->message );

		remove_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
	}

	/**
	 * Set the content type to HTML for the email
	 *
	 * @since 2.01
	 *
	 * @return string
	 */
	public function set_html_content_type() {
		return 'text/html';
	}
}