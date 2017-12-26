<?php
if ( isset($taxonomies) && $taxonomies ) { ?>
    <option value=""><?php _e( '&mdash; Select a Taxonomy &mdash;', 'formidable' ) ?></option>
    <?php foreach ( $taxonomies as $taxonomy ) { ?>
		<option value="<?php echo esc_attr( $taxonomy ) ?>">
			<?php echo esc_html( str_replace( array( '_','-' ), ' ', ucfirst( $taxonomy ) ) ); ?>
		</option>
        <?php
        unset($taxonomy);
    }
} else { ?>
    <option value=""><?php _e( 'No taxonomies available', 'formidable' ) ?></option>
<?php
}
?>