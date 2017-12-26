<?php
/**
 * @since 2.01
 * @var FrmRegGlobalSettings $global_settings
 */
?>

<!-- Global Pages -->
<h3><?php _e( 'Global Pages', 'frmreg' ); ?></h3>

<p>
	<label class="frm_left_label"><?php _e('Login/Logout Page', 'frmreg'); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e(
			'Prevent logged-out users from seeing the wp-admin page. Select a page where logged-out users will be redirected when they try to access the wp-admin page or just leave this option blank. Please note that you must have a login form on the selected page.', 'frmreg'
		) ?>" ></span>
	</label>
	<?php FrmAppHelper::wp_pages_dropdown( 'frm_reg_global_pages[login_page]', $global_settings->get_global_page( 'login_page' ) ) ?>
</p>

<p>
	<label class="frm_left_label"><?php _e('Reset Password Page', 'frmreg'); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'Select the page where users can reset their password. Please note that you must have a reset password form on the selected page.', 'frmreg' ) ?>" ></span>
	</label>
	<?php FrmAppHelper::wp_pages_dropdown( 'frm_reg_global_pages[resetpass_page]', $global_settings->get_global_page( 'resetpass_page' ) ) ?>
</p>

<p>
	<label class="frm_left_label"><?php _e('Registration Page', 'frmreg'); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e(
			'Select a page where users can register for your site. Leave this option blank if you would like to allow users to register on the default WordPress registration page. Please note that you must have a registration form on the selected page.', 'frmreg'
		) ?>" ></span>
	</label>
	<?php FrmAppHelper::wp_pages_dropdown( 'frm_reg_global_pages[register_page]', $global_settings->get_global_page( 'register_page' ) ) ?>
</p>

<!-- Default Messages -->
<h3><?php _e( 'Default Messages', 'frmreg' ); ?>
	<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'Override the default registration messages.', 'frmreg' ) ?>"></span>
</h3>

<p>
	<label class="frm_left_label" for="frm_reg_existing_email"><?php _e( 'Existing Email', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when an existing email is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_existing_email" name="frm_reg_global_messages[existing_email]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'existing_email' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_existing_username"><?php _e( 'Existing Username', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when an existing username is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_existing_username" name="frm_reg_global_messages[existing_username]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'existing_username' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_blank_password"><?php _e( 'Blank Password', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when a blank password is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_blank_password" name="frm_reg_global_messages[blank_password]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'blank_password' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_blank_email"><?php _e( 'Blank Email', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when a blank email is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_blank_email" name="frm_reg_global_messages[blank_email]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'blank_email' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_blank_username"><?php _e( 'Blank Username', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when a blank username is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_blank_username" name="frm_reg_global_messages[blank_username]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'blank_username' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_illegal_username"><?php _e( 'Illegal Username', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when an illegal username is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_illegal_username" name="frm_reg_global_messages[illegal_username]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'illegal_username' ) ) ?>" />
</p>
<p>
	<label class="frm_left_label" for="frm_reg_illegal_password"><?php _e( 'Illegal Password', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when an illegal password is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_illegal_password" name="frm_reg_global_messages[illegal_password]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'illegal_password' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_existing_subsite"><?php _e( 'Existing Subsite', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when an existing subsite is entered in a registration form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_existing_subsite" name="frm_reg_global_messages[existing_subsite]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'existing_subsite' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_update_username"><?php _e( 'Update Username', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The message displayed when a logged-in user attempts to change their username.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_update_username" name="frm_reg_global_messages[update_username]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'update_username' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_lost_password"><?php _e( 'Lost Password', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The text that appears at the top of the lost password form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_lost_password" name="frm_reg_global_messages[lost_password]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'lost_password' ) ) ?>" />
</p>

<p>
	<label class="frm_left_label" for="frm_reg_reset_password"><?php _e( 'Reset Password', 'formidable' ); ?>
		<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'The text that appears at the top of the reset password form.', 'frmreg' ) ?>" ></span>
	</label>
	<input type="text" id="frm_reg_reset_password" name="frm_reg_global_messages[reset_password]" class="frm_with_left_label" value="<?php echo esc_attr( $global_settings->get_global_message( 'reset_password' ) ) ?>" />
</p>