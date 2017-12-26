<?php
/**
 * @since 2.01
 * @var FrmRegLoginForm $login_form
 */
?>

<div id="<?php echo esc_attr( $login_form->get_html_id() ) ?>" class="<?php echo esc_attr( $login_form->get_class() ) ?>">

	<!-- Slide HTML -->
	<?php if ( $login_form->get_slide() ) {
		?>
		<span class="frm-open-login">
		<a href="#"><?php echo $login_form->get_submit_label() ?> &rarr;</a>
		</span><?php
	} ?>
	<form method="post" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" >

		<!-- Errors -->
		<?php
		if ( $login_form->get_show_messages() && count( $login_form->get_errors() ) > 0 ) {
			?>
			<div class="frm_error_style">
				<?php foreach ( $login_form->get_errors() as $error ) : ?>
					<?php echo $error; ?>
				<?php endforeach; ?>
			</div>
			<?php
		} ?>

		<!-- Success Messages -->
		<?php
		if ( $login_form->get_show_messages() && count( $login_form->get_messages() ) > 0 ) {
			?>
			<div class="frm_message">
				<?php foreach ( $login_form->get_messages() as $message ) : ?>
					<?php echo $message; ?>
				<?php endforeach; ?>
			</div>
			<?php
		}?>
		<div class="frm_form_fields">
			<fieldset>

				<!-- Username Field -->
				<div class="<?php echo esc_attr( $login_form->get_username_class() ) ?>">
					<label for="<?php echo esc_attr( $login_form->get_username_id() ) ?>" class="frm_primary_label"><?php
						echo esc_html( $login_form->get_username_label() ) ?>
					</label>
					<input id="<?php echo esc_attr( $login_form->get_username_id() ) ?>" name="log" value="<?php echo esc_attr( $login_form->get_username_value() ) ?>" placeholder="<?php echo esc_attr( $login_form->get_username_placeholder() ) ?>" type="text">
				</div>

				<!-- Password Field -->
				<div class="<?php echo esc_attr( $login_form->get_password_class() ) ?>">
					<label for="<?php echo esc_attr( $login_form->get_password_id() ) ?>" class="frm_primary_label"><?php
						echo esc_html( $login_form->get_password_label() ) ?>
					</label>
					<input id="<?php echo esc_attr( $login_form->get_password_id() ) ?>" name="pwd" value="" type="password" placeholder="<?php echo esc_attr( $login_form->get_password_placeholder() ) ?>" >
				</div>

				<!-- Hidden Fields -->
				<input type="hidden" name="redirect_to" value="<?php echo esc_url( $login_form->get_redirect() ) ?>" />

				<?php if ( $login_form->get_layout() == 'v' ) {
					do_action( 'login_form' );
				} ?>

				<!-- Submit Button -->
				<div class="<?php echo esc_attr( $login_form->get_submit_class() ) ?>">
					<input type="submit" name="wp-submit" id="<?php echo esc_attr( $login_form->get_submit_id() ) ?>" value="<?php echo esc_attr( $login_form->get_submit_label() ) ?>" />
				</div>
				<div style="clear:both;"></div>

				<?php if ( $login_form->get_layout() == 'h' ) {
					do_action( 'login_form' );
				} ?>

				<!-- Remember Me Checkbox -->
				<?php if ( $login_form->get_show_remember() ) {
				?><div class="<?php echo esc_attr( $login_form->get_remember_class() ) ?>">
					<div class="frm_opt_container">
						<div class="frm_checkbox">
							<label for="<?php echo esc_attr( $login_form->get_remember_id() ) ?>">
							<input name="rememberme" id="<?php echo esc_attr( $login_form->get_remember_id() ) ?>" value="forever"<?php echo ( $login_form->get_remember_value() ? ' checked="checked"' : '' )?> type="checkbox"><?php
							echo esc_html( $login_form->get_remember_label() )?>
							</label>
						</div>
					</div>
				</div>
				<?php } ?>

				<!-- Lost Password Link -->
				<?php if ( $login_form->get_show_lost_password_link() ) {
				?><div class="<?php echo esc_attr( $login_form->get_lost_password_class() ) ?>">
					<a class="forgot-password" href="<?php echo esc_url( wp_lostpassword_url() ) ?>">
						<?php echo esc_html( $login_form->get_lost_password_label() ) ?>
					</a>
				</div>
				<?php } ?>

				<!-- Clear -->
				<div style="clear:both;"></div>

			</fieldset>
		</div>
	</form>
</div>
