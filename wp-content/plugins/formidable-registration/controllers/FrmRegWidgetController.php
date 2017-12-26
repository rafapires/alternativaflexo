<?php

/**
 * @since 2.0
 */
class FrmRegWidgetController {

	public static function register_widgets() {
		register_widget( 'FrmRegLoginWidget' );
	}

	/**
	 * Filter login shortcode in text widgets
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public static function widget_text_filter( $content ) {
		if ( is_callable( 'FrmAppHelper::widget_text_filter_callback' ) ) {
			$callback = 'FrmAppHelper::widget_text_filter_callback';
		} else if ( is_callable( 'FrmAppController::widget_text_filter_callback' ) ) {
			$callback = 'FrmAppController::widget_text_filter_callback';
		} else {
			return $content;
		}

		$regex = '/\[\s*frm-login(\s+)?.*\]/';

		return preg_replace_callback( $regex, $callback, $content );
	}

}