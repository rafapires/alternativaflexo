<?php

/**
 * @since 2.0
 */
class FrmRegLoginWidget extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => __( 'Add a login form anywhere on your site', 'frmreg' ) );
		parent::__construct( 'frm_reg_login', __( 'Login Form', 'frmreg' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		$shortcode_atts = array(
			'slide'          => false,
			'form_id'        => 'loginform',
			'label_username' => __( 'Username', 'frmreg' ),
			'label_password' => __( 'Password', 'frmreg' ),
			'label_remember' => __( 'Remember Me', 'frmreg' ),
			'label_log_in'   => __( 'Login', 'frmreg' ),
			'remember'       => 0,
			'show_lost_password' => false,
			'layout'         => 'v',
		);

		foreach ( $shortcode_atts as $key => $default ) {
			if ( isset( $instance[ $key ] ) ) {
				$shortcode_atts[ $key ] = $instance[ $key ];
			}
		}

		$this->apply_style_setting( $instance, $shortcode_atts );

		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
		if ( $title ) {
			echo $args['before_title'] . stripslashes( $title ) . $args['after_title'];
		}

		echo FrmRegShortcodesController::do_login_form_shortcode( $shortcode_atts );

		echo $args['after_widget'];
	}

	/**
	 * Apply the Formidable Style setting to the shortcode attributes
	 *
	 * @since 2.0
	 * @param array $instance
	 * @param array $shortcode_atts
	 */
	private function apply_style_setting( $instance, &$shortcode_atts ) {
		if ( (string) $instance['style'] === '0' ) {
			$shortcode_atts['style'] = 0;
		} else if ( (string) $instance['style'] === '1' ) {
			// Add nothing
		} else {
			$shortcode_atts['class'] = 'frm_style_' . $instance['style'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['remember'] = isset( $new_instance['remember'] ) ? 1 : 0;
		$new_instance['show_lost_password'] = isset( $new_instance['show_lost_password'] ) ? 1 : 0;

		return $new_instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title'              => false,
			'remember'           => true,
			'slide'              => false,
			'style'              => '1',
			'layout'             => 'v',
			'form_id'            => 'loginform',
			'label_username'     => __( 'Username', 'frmreg' ),
			'label_password'     => __( 'Password', 'frmreg' ),
			'label_remember'     => __( 'Remember Me', 'frmreg' ),
			'label_log_in'       => __( 'Login', 'frmreg' ),
			'show_lost_password' => false,
		) );

		include( FrmRegAppHelper::path() . '/views/login_widget_settings.php' );
	}
}