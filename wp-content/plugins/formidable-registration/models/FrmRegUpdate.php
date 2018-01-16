<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

class FrmRegUpdate extends FrmAddon {
	public $plugin_file;
	public $plugin_name = 'User Registration';
	public $download_id = 173984;
	public $version = '2.01.01';

	public function __construct() {
		$this->plugin_file = dirname( dirname( __FILE__ ) ) . '/formidable-registration.php';
		parent::__construct();
	}

	public static function load_hooks() {
		add_filter( 'frm_include_addon_page', '__return_true' );
		new FrmRegUpdate();
	}
}
