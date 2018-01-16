<h3><?php _e('Multisite', 'frmreg') ?></h3>

<table class="form-table">
	<tr>
		<td colspan="2">
			<label <?php FrmRegAppHelper::add_tooltip('create_subsite'); ?>>
				<input type="checkbox" id="reg_create_subsite" name="<?php echo esc_attr( $this->get_field_name( 'create_subsite' ) ) ?>" value="1" <?php checked( $form_action->post_content['create_subsite'], 1 ); ?> /> <?php _e( 'Create subsite when user registers', 'frmreg' ) ?>
			</label>
		</td>
	</tr>
	<tr class="reg_multisite_options"<?php echo ($form_action->post_content['create_subsite']) ? '' : ' style="display:none"' ?>>
		<th>
			<label><?php _e( 'Blog title', 'frmreg' ) ?></label>
		</th>
		<td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'subsite_title' ) ) ?>">
				<option value="username"><?php _e('Automatically generate from username', 'frmreg') ?></option>
				<?php
				if ( isset ( $fields ) && is_array( $fields ) ) {
					foreach ( $fields as $field ) {
						if ( $field->type == 'text' ){ ?>
							<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['subsite_title'], $field->id ) ?>><?php
								echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
								?></option>
							<?php
						}
					}
				}
				?>
			</select>
		</td>
	</tr>
	<tr class="reg_multisite_options"<?php echo ($form_action->post_content['create_subsite']) ? '' : ' style="display:none"' ?>>
		<th>
			<label><?php _e( 'Subdirectory or subdomain', 'frmreg' ) ?></label>
		</th>
		<td>
			<select name="<?php echo esc_attr( $this->get_field_name( 'subsite_domain' ) ) ?>">
				<option value="blog_title"><?php _e('Automatically generate from blog title', 'frmreg') ?></option>
				<option value="username"><?php _e('Automatically generate from username', 'frmreg') ?></option>
				<?php
				if ( isset ( $fields ) && is_array( $fields ) ) {
					foreach ( $fields as $field ) {
						if ( in_array( $field->type, array( 'text', 'hidden' ) ) ){ ?>
							<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $form_action->post_content['subsite_domain'], $field->id ) ?>><?php
								echo substr( esc_attr( stripslashes( $field->name ) ), 0, 50 );
								?></option>
							<?php
						}
					}
				}
				?>
			</select>
		</td>
	</tr>
</table>