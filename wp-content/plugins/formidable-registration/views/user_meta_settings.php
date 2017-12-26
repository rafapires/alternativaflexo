<h3><?php _e('User Meta', 'frmreg') ?> <span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e('Add user meta to save submitted values to a user\'s profile. User meta can be retrieved with the [user_meta key="insert_name_here"] shortcode.', 'frmreg') ?>"></span></h3>
<?php $has_meta =  isset( $form_action->post_content['reg_usermeta'] ) && ! empty( $form_action->post_content['reg_usermeta'] ); ?>
<table id="frm_user_meta_add" class="form-table"<?php echo $has_meta ? ' style="display:none;"' : '' ?>>
    <tr class="frm_add_meta_link">
        <td>
            <a href="javascript:void(0)" class="button reg_user_meta_add_button">+ <?php _e( 'Add', 'frmreg' ) ?></a>
        </td>
    </tr>
</table>
<table id="frm_user_meta_table" class="frm_name_value frm_add_remove"<?php echo $has_meta ? '' : ' style="display:none;"' ?>>
    <thead>
    <tr>
        <th class="left"><?php _e( 'Name', 'frmreg' ) ?></th>
        <th><?php _e( 'Value', 'frmreg' ) ?></th>
        <th style="width:35px;"></th>
    </tr>
    </thead>
    <tbody id="frm_user_meta_rows">
    <?php
        foreach ( $form_action->post_content['reg_usermeta'] as $meta_key => $user_meta_vars ) {
            $meta_name = $user_meta_vars['meta_name'];
            $field_id = $user_meta_vars['field_id'];
            $echo = true;
            $action_control = $this;
            if ( $meta_name ) {
                include(FrmRegAppHelper::path() .'/views/_usermeta_row.php');
            }
        } ?>
    </tbody>
</table>
