<table class="form-table">
    <tr>
        <th>
            <label><?php _e('User Email', 'frmreg') ?>
                <span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'Only Email fields will show here. An email field must be selected if you would like to register new users with this form.', 'frmreg') ?>"></span></label>
        </th>
        <td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'reg_email' ) ) ?>">
				<option value=""><?php _e( '- None -', 'frmreg' ) ?></option>
            <?php
            if ( isset( $fields ) && is_array( $fields ) ) {
                foreach ( $fields as $field ) {
                    if ( $field->type == 'email' ) { ?>
				<option value="<?php echo absint( $field->id ) ?>" <?php selected( $form_action->post_content['reg_email'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                ?></option>
                <?php
                    }
                }
                unset( $field );
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
			<label><?php _e( 'Username', 'frmreg' ) ?></label>
        </th>
        <td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'reg_username' ) ) ?>">
                <option value=""><?php _e('Automatically generate from email address', 'frmreg') ?></option>
                <option value="-1" <?php selected($form_action->post_content['reg_username'], '-1') ?>><?php _e('Use Full Email Address', 'frmreg') ?></option>
                <?php
                if(isset($fields) and is_array($fields)){
                    foreach($fields as $field){
                        if($field->type == 'text'){ ?>
					<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_username'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                    unset($field);
                    ?></option>
                    <?php
                        }
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
			<label for="reg_password"><?php _e( 'Password', 'frmreg' ) ?></label>
        </th>
        <td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'reg_password' ) ) ?>" id="reg_password">
            <option value=""><?php _e('Set with link in email notification', 'frmreg') ?></option>
            <?php
            if(isset($fields) and is_array($fields)){
            	$password_field_types = (array) apply_filters( 'frmreg_password_field_types', array( 'text', 'password' ) );
                foreach ( $fields as $field ) {
                    if ( in_array( $field->type, $password_field_types ) ) { ?>
				<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_password'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                unset($field);
                ?></option>
                <?php
                    }
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
			<label><?php _e( 'First Name', 'frmreg' ) ?></label>
        </th>
        <td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'reg_first_name' ) ) ?>">
				<option value="">- <?php _e( 'None', 'frmreg' ) ?> -</option>
            <?php
            if(isset($fields) and is_array($fields)){
                foreach($fields as $field){
                    if($field->type == 'text'){ ?>
				<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_first_name'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                unset($field);
                ?></option>
                <?php
                    }
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
       <th>
		   <label><?php _e( 'Last Name', 'frmreg' ) ?></label>
       </th>
       <td>
		   <select name="<?php echo esc_attr( $this->get_field_name( 'reg_last_name' ) ) ?>">
				<option value="">- <?php _e( 'None', 'frmreg' ) ?> -</option>
                <?php
                if(isset($fields) and is_array($fields)){
                    foreach($fields as $field){
                        if($field->type == 'text'){ ?>
					<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_last_name'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                    unset($field);
                    ?></option>
                    <?php
                        }
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
            <label><?php _e('Display Name', 'frmreg') ?></label>
        </th>
        <td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'reg_display_name' ) ) ?>">
            <option value=""><?php _e('Same as Username', 'frmreg') ?></option>
            <option value="display_firstlast" <?php selected($form_action->post_content['reg_display_name'], 'display_firstlast') ?>><?php _e('First Last', 'frmreg') ?></option>
            <option value="display_lastfirst" <?php selected($form_action->post_content['reg_display_name'], 'display_lastfirst') ?>><?php _e('Last First', 'frmreg') ?></option>
            <?php
            if(isset($fields) and is_array($fields)){
                foreach($fields as $field){
					if ( in_array( $field->type, array( 'text', 'select', 'radio' ) ) ) { ?>
				<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_display_name'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                ?></option>
                <?php
                    }
                    unset($field);
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
	    <th>
		    <label><?php _e('Website', 'frmreg') ?></label>
	    </th>
	    <td>
		    <select name="<?php echo esc_attr( $this->get_field_name( 'reg_user_url' ) ) ?>">
			    <option value=""><?php _e('- None -', 'frmreg') ?></option>
			    <?php
			    if ( isset( $fields ) && is_array( $fields ) ){
				    foreach( $fields as $field ) {
					    if ( $field->type == 'url'){ ?>
						    <option value="<?php echo absint( $field->id ) ?>" <?php selected( $form_action->post_content['reg_user_url'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
							    ?></option>
						    <?php
					    }
				    }
				    unset( $field );
			    }
			    ?>
		    </select>
	    </td>
    </tr>
    <tr>
        <th>
            <label><?php _e('User Role', 'frmreg') ?></label>
        </th>
        <td>
            <?php FrmAppHelper::wp_roles_dropdown($this->get_field_name('reg_role'), $form_action->post_content['reg_role']); ?>
        </td>
    </tr>
    <tr>
        <th>
            <label><?php _e('Avatar', 'frmreg') ?> <span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e('Only file upload fields will show here.', 'frmreg') ?>" ></span></label>
        </th>
        <td>
            <select name="<?php echo esc_attr( $this->get_field_name( 'reg_avatar' ) ) ?>">
				<option value="">- <?php _e( 'None', 'frmreg' ) ?> -</option>
            <?php
            if ( isset($fields) && is_array($fields) ) {
                foreach ( $fields as $field ) {
                    if ( $field->type == 'file' ) { ?>
				<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['reg_avatar'], $field->id ) ?>><?php echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
                ?></option>
                <?php
                    }
                    unset($field);
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr id="reg_auto_login_row"<?php echo ( $show_auto_login ) ? '' : ' style="display:none"' ?>>
        <td colspan="2">
			<label for="reg_auto_login"><input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'login' ) ) ?>" value="1" id="reg_auto_login" <?php checked( $form_action->post_content['login'], 1 ); ?> /> <?php _e( 'Automatically log in users who submit this form', 'frmreg' ); ?></label>
        </td>
    </tr>
	<tr id="reg_auto_login_msg" <?php echo ( ! $show_auto_login && $form_action->post_content['login'] == '1' ) ? ' ' : 'style="display:none"'; ?>>
		<td colspan="2">
			<span><?php _e( 'Please note: the automatic login option will appear if you map the Password setting to a Password field in your form.', 'frmreg' ); ?></span>
		</td>
	</tr>
</table>

<!--User Meta-->
<?php include( FrmRegAppHelper::path() . '/views/user_meta_settings.php' ); ?>

<!--User Moderation-->
<h3><?php _e( 'User Moderation', 'frmreg' ) ?></h3>
<table class="form-table">
    <tr><td width="250px">
        <label <?php FrmRegAppHelper::add_tooltip('mod_email'); ?>>
			<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'reg_moderate' ) ) ?>[]" value="email" id="reg_moderate_email" <?php FrmRegAppHelper::array_checked( $form_action->post_content['reg_moderate'], 'email' ); ?> /> <?php _e( 'Email confirmation', 'frmreg' ) ?>
        </label>
    </td>
    <td style="padding-top:0;">
    <span id="frmreg_redirect_to" <?php echo ($form_action->post_content['reg_moderate']) ? '' : 'style="display:none"' ?>>
        <label <?php FrmRegAppHelper::add_tooltip('mod_redirect'); ?>><?php _e('Redirect to:', 'frmreg') ?></label>
                    <?php FrmAppHelper::wp_pages_dropdown( $this->get_field_name('reg_redirect'), $form_action->post_content['reg_redirect'] ) ?>
    </span>
    </td>
    </tr>
    <tr class="frm_hidden">
        <td colspan="2">
        <label <?php FrmRegAppHelper::add_tooltip('mod_admin'); ?>>
			<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'reg_moderate' ) ) ?>[]" value="admin" <?php FrmRegAppHelper::array_checked( $form_action->post_content['reg_moderate'], 'admin' ); ?> /> <?php _e( 'Admin approval', 'frmreg' ) ?>
        </label>
        </td>
    </tr>
</table>

<!--Permissions-->
<?php include( FrmRegAppHelper::path() . '/views/permission_settings.php' ); ?>

<!--Multisite Settings-->
<?php if ( is_multisite() ) {
	include( FrmRegAppHelper::path() . '/views/multisite_settings.php' );
} ?>

<!--Email Buttons-->
<?php include( FrmRegAppHelper::path() . '/views/email_buttons.php' ); ?>

