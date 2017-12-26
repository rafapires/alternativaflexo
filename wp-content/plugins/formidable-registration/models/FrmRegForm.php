<?php

/**
 * @since 2.0
 */
class FrmRegForm{

	protected $form_id_tracker = 'resetpass_form_ids';
	protected $form_number = 0;
	protected $html_id = 'frm-reset-password';
	protected $class = '';
	protected $description = '';
	protected $submit_text = '';
	protected $path = '';
	protected $errors = array();

	public function __construct( $atts ) {
		$this->init_form_number_and_id( $atts );
		$this->init_class( $atts );
		$this->init_errors();
	}

	/**
	 * Set the form number and ID
	 *
	 * @since 2.0
	 *
	 * @param array $atts
	 */
	protected function init_form_number_and_id( $atts ){
		$this->initialize_global_vars();
		global $frm_reg_vars;

		$this->form_number = count( $frm_reg_vars[ $this->form_id_tracker ] );

		if ( isset( $atts['form_id'] ) && $atts['form_id'] ) {
			$this->html_id = $atts['form_id'];
		} else {
			$this->html_id = $this->html_id . '-' . $this->form_number;
		}

		$frm_reg_vars[ $this->form_id_tracker ][] = $this->html_id;
	}

	/**
	 * Set the form class
	 *
	 * @since 2.0
	 * @param $atts
	 */
	protected function init_class( $atts ) {
		$this->class = isset( $atts['class'] ) ? $atts['class'] : 'default';

		if ( $this->class === 'default' ) {
			$this->class = $this->default_style_class();
		}

		if ( strpos( $this->class, 'frm_style_' ) !== false ) {
			$this->class = 'frm_forms with_frm_style ' . $this->class;
			$this->load_formidable_css();
		}
	}

	/**
	 * Set the errors for the form
	 *
	 * @since 2.0
	 */
	protected function init_errors() {
		if ( isset( $_REQUEST['errors'] ) ) {
			$error_codes = explode( ',', $_REQUEST['errors'] );

			foreach ( $error_codes as $error_code ) {
				$this->errors[] = $this->get_error_message( $error_code );
			}
		}
	}

	/**
	 * Set the form description
	 * Must be overridden in a sub class
	 *
	 * @since 2.0
	 */
	protected function init_description() {}

	/**
	 * Must be overridden in a child class
	 *
	 * @since 2.0
	 * @param array $atts
	 */
	protected function init_submit_text( $atts ) {}

	/**
	 * Get the form number
	 *
	 * @since 2.0
	 * @return int
	 */
	public function get_form_number() {
		return $this->form_number;
	}

	/**
	 * Get the HTML ID for the form
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_html_id() {
		return $this->html_id;
	}

	/**
	 * Get the HTML for a form
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public function get_html() {
		if ( ! $this->path ) {
			return '';
		}

		$form = $this;

		ob_start();
		include( FrmRegAppHelper::path() . $this->path );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Get the class for the form
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_class() {
		return $this->class;
	}

	/**
	 * Get the form description
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get the submit button text
	 *
	 * @since 2.0
	 * @return string
	 */
	public function get_submit_text() {
		return $this->submit_text;
	}

	/**
	 * Get the form errors
	 *
	 * @since 2.0
	 * @return array
	 */
	public function get_errors() {
		return $this->errors;
	}

	/**
	 *
	 * Must be overridden in a child class
	 *
	 * @since 2.0
	 * @param string $error_code
	 * @return string
	 */
	protected function get_error_message( $error_code ) {
		return '';
	}

	/**
	 * Return the Formidable default Style class
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	protected function default_style_class() {
		if ( is_callable( 'FrmStylesController::get_form_style_class' ) ) {
			return FrmStylesController::get_form_style_class( '', 'default' );
		} else {
			return '';
		}
	}

	/**
	 * If the Formidable styling is not loaded yet, load it now
	 *
	 * @since 2.0
	 */
	public function load_formidable_css() {
		global $frm_vars;

		if ( ! isset( $frm_vars['css_loaded'] ) || ! $frm_vars['css_loaded'] ) {
			global $frm_settings;

			if ( empty( $frm_settings ) && is_callable( 'FrmAppHelper::get_settings' ) ) {
				$frm_settings = FrmAppHelper::get_settings();
			}

			if ( $frm_settings->load_style != 'none' ) {
				wp_enqueue_style( 'formidable' );
				$frm_vars['css_loaded'] = true;
			}
		}
	}

	/**
	 * Initialize the global $frm_reg_vars and form_id_tracker array
	 *
	 * @since 2.0
	 */
	protected function initialize_global_vars() {
		global $frm_reg_vars;

		if ( ! is_array( $frm_reg_vars ) ) {
			$frm_reg_vars = array();
		}

		if ( ! isset( $frm_reg_vars[ $this->form_id_tracker ] ) ) {
			$frm_reg_vars[ $this->form_id_tracker ] = array();
		}
	}
}