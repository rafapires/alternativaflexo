<tr>
	<td><label><?php esc_html_e( 'Lookup value', 'formidable' ) ?></label></td>
    <td>
	    <label for="autopopulate_value_<?php echo absint( $field['id'] ) ?>">
			<input type="checkbox" value="1" name="field_options[autopopulate_value_<?php echo absint( $field['id'] ) ?>]" <?php checked($field['autopopulate_value'], 1) ?> class="autopopulate_value" id="autopopulate_value_<?php echo absint( $field['id'] ) ?>" />
	        <?php esc_html_e( 'Dynamically retrieve the value from a Lookup field', 'formidable' ) ?>
		</label>
	</td>
</tr>
<tr class="frm_autopopulate_value_section_<?php echo absint( $field['id'] ) . esc_attr( $field['autopopulate_value'] ? '' : ' frm_hidden' )?>">
	<td>
		<label><?php esc_html_e( 'Get value from', 'formidable' ) ?></label>
	</td>
	<td><?php
	require( FrmAppHelper::plugin_path() .'/pro/classes/views/lookup-fields/back-end/get-options-from.php' );
	?></td>
</tr>
<tr class="frm_autopopulate_value_section_<?php echo absint( $field['id'] ) . esc_attr( $field['autopopulate_value'] ? '' : ' frm_hidden' )?>">
	<td><label><?php esc_html_e( 'Watch Lookup fields', 'formidable' ) ?></label></td>
	<td>
	    <a href="javascript:void(0)" id="frm_add_watch_lookup_link_<?php echo absint( $field['id'] ) ?>" class="frm_add_watch_lookup_row frm_add_watch_lookup_link frm_hidden">
			<?php _e( 'Watch Lookup fields', 'formidable' ) ?>
		</a>
		<div id="frm_watch_lookup_block_<?php echo absint( $field['id'] ) ?>"><?php
			if ( empty( $field['watch_lookup'] ) ) {
				$field_id = $field['id'];
				$row_key = 0;
				$selected_field = '';
				include( FrmAppHelper::plugin_path() .'/pro/classes/views/lookup-fields/back-end/watch-row.php' );
			} else {
				$field_id = $field['id'];
				foreach ( $field['watch_lookup'] as $row_key => $selected_field ) {
					include( FrmAppHelper::plugin_path() .'/pro/classes/views/lookup-fields/back-end/watch-row.php' );
				}
			}
		?></div>
	</td>
</tr>
<tr class="frm_autopopulate_value_section_<?php echo absint( $field['id'] ) . esc_attr( $field['autopopulate_value'] ? '' : ' frm_hidden' )?>">
	<td><label><?php _e( 'Filter options', 'formidable' ) ?></label></td>
	<td>
		<label for="get_most_recent_value_<?php echo absint( $field['id'] ) ?>">
			<input type="checkbox" value="1" name="field_options[get_most_recent_value_<?php echo absint( $field['id'] ) ?>]" <?php checked($field['get_most_recent_value'], 1) ?> id="get_most_recent_value_<?php echo absint( $field['id'] ) ?>" />
			<?php esc_html_e( 'Get only the most recent value', 'formidable' ) ?>
		</label>
	</td>
</tr>