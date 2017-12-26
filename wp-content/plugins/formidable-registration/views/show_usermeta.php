<table class="form-table">
<tbody>
<?php

foreach( $meta_keys as $meta_key => $field_id){
    if(empty($profileuser->{$meta_key}))
        continue;
?>
<tr>
	<th><label><?php echo ucwords($meta_key) ?></label></th>
	<td><?php 
	    $meta_val = $profileuser->{$meta_key}; //maybe_unserialize($profileuser->{$meta_key});

		$field = FrmField::getOne($field_id);
		echo FrmEntriesHelper::display_value( $meta_val, $field, array( 'type' => $field->type, 'truncate' => false ) );
	    
	    unset( $field, $meta_key, $field_id );
	    ?>
	</td>
</tr>
<?php
}

?>

</tbody>
</table>
