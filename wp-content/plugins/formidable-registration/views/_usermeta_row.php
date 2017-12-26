<tr id="frm_user_meta_<?php echo $meta_key ?>" class="frm_user_meta_row">
	<td class="left">
		<label class="screen-reader-text" for='meta-256-key'><?php _e( 'Name') ?></label>
		<input type="text" value="<?php echo esc_attr( ( isset( $echo ) && $echo ) ? $meta_name : '' ) ?>" name="<?php echo $action_control->get_field_name( 'reg_usermeta' ) ?>[<?php echo esc_attr( $meta_key ) ?>][meta_name]"/>
	</td>

	<td>
		<label class="screen-reader-text" for='meta-256-value'><?php _e( 'Value', 'formidable' ) ?></label>
		<select name="<?php echo esc_attr( $action_control->get_field_name( 'reg_usermeta' ) ) ?>[<?php echo $meta_key ?>][field_id]">
			<option value="">- <?php _e('Select Field', 'frmreg') ?> -</option>
			<?php
			if ( isset( $fields ) && is_array( $fields ) ) {
				foreach ( $fields as $field ) {
					if ( ! FrmField::is_no_save_field( $field->type ) ) { ?>
						<option value="<?php echo esc_attr( $field->id ) ?>" <?php selected( $field_id, $field->id ) ?>><?php echo FrmAppHelper::truncate( $field->name, 50 ) ?></option>
						<?php
					}
				}
			}
			?>
		</select>
	</td>
	<td>
		<div style="padding-top:12px">
			<a class="frm_remove_tag reg_remove_user_meta_row frm_icon_font" data-removeid="frm_user_meta_<?php echo $meta_key ?>" data-showlast="#frm_user_meta_add" data-hidelast="#frm_user_meta_table"></a>
			<a class="frm_add_tag frm_icon_font reg_add_user_meta_row" href="javascript:void(0)"></a>
		</div>
	</td>
</tr>