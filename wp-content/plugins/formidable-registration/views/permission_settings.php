<h3><?php _e('Permissions', 'frmreg') ?></h3>
<table class="form-table">
	<tbody>
		<tr>
			<td colspan="2">
				<label>
					<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'reg_create_users' ) ) ?>" value="allow" id="reg_create_users" <?php checked( $form_action->post_content['reg_create_users'], 'allow' ); ?> />
					<?php _e('Allow logged-in users to create new users with this form', 'frmreg'); ?>
					<span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e(
						'Determine which roles can create new users with this form on the front-end of your site. The selected roles must submit entries on the back-end of your site in order to edit their own profile.', 'frmreg'
					) ?>" ></span>
				</label>
			</td>
		</tr>
		<tr class="frm_short_tr" id="reg_create_role_tr" <?php echo $form_action->post_content['reg_create_users'] == 'allow' ? '' : ' style="display:none;"';?>>
			<td style="width:275px;padding-top:0;">
				<p class="frm_indent_opt"><?php _e('Role required to create new users:', 'frmreg'); ?></p>
			</td>
			<td>
				<?php FrmAppHelper::wp_roles_dropdown( $this->get_field_name( 'reg_create_role' ) . '[]', $form_action->post_content['reg_create_role'], 'multiple' ); ?>
			</td>
		</tr>
	</tbody>
</table>