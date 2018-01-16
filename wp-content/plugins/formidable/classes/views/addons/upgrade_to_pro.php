<div class="wrap upgrade_to_pro">
	<h1 class="frm_pro_heading">
		<img src="<?php echo esc_url( FrmAppHelper::plugin_url() ) ?>/images/logo.png" alt="Upgrade to Pro" />
		<span class="alignright">Save time and make life easier. Upgrade to Pro.</span>
		<span class="clear"></span>
	</h1>

	<div class="clear"></div>

	<p>Enhance your basic Formidable forms with a plethora of Pro field types and features. Create advanced forms and data-driven applications in no time at all.</p>
	<p>Are you collecting data offline? Streamline your business by using your forms to get online. Whether you need surveys, polls, client contracts, mortgage calculators, or directories, we've got you covered. Save time by allowing clients to return and make changes to their own submissions, or let them contribute content to your site. Generate more leads by adding headings and page breaks, only showing the fields you need, and letting your clients repeat a section of fields as many times as they need.</p>
	<p>Projects that once seemed impossible are within your reach with Pro. That project you’ve been dreaming of pursuing? Chances are <strong>Formidable Pro can handle it</strong>.</p><br/>

	<table class="wp-list-table widefat fixed striped frm_pricing">
		<thead>
			<tr>
				<th></th>
			<?php foreach ( $pro_pricing as $price_info ) { ?>
				<th>
					<h3><?php echo esc_attr( ucfirst( $price_info['name'] ) ) ?></h3>
					<h4>$<?php echo esc_attr( $price_info['price'] ) ?></h4>
					<a href="<?php echo esc_url( FrmAppHelper::make_affiliate_url( 'https://formidableforms.com/checkout?edd_action=add_to_cart' ) ) ?>&amp;download_id=<?php echo absint( $price_info['download'] ) ?>&amp;edd_options[price_id]=<?php echo absint( $price_info['id'] ) ?>" class="button-primary" target="_blank">
						<?php esc_html_e( 'Get Started', 'formidable' ) ?>
					</a>
				</th>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>Number of Sites</th>
				<td>1 Site</td>
				<td>3 Sites</td>
				<td>15 Sites</td>
				<td>Unlimited Sites</td>
			</tr>
			<tr>
				<th>Automatic Updates</th>
				<td>1 Year</td>
				<td>1 Year</td>
				<td>1 Year</td>
				<td>Lifetime</td>
			</tr>
			<tr>
				<th>Support Term</th>
				<td>1 Year</td>
				<td>1 Year</td>
				<td>1 Year</td>
				<td>1 Year</td>
			</tr>
			<tr>
				<th>Support Priority</th>
				<td>Standard Support</td>
				<td>Standard Support</td>
				<td>Priority Support</td>
				<td>Elite Support</td>
			</tr>
			<tr>
				<th>Included AddOns</th>
				<td>None</td>
				<td><a href="<?php echo esc_url( FrmAppHelper::make_affiliate_url('https://formidableforms.com/pricing/#addon-lists') ) ?>" target="_blank">Premium Addons</a></td>
				<td><a href="<?php echo esc_url( FrmAppHelper::make_affiliate_url('https://formidableforms.com/pricing/#addon-lists') ) ?>" target="_blank">Advanced Addons</a></td>
				<td><a href="<?php echo esc_url( FrmAppHelper::make_affiliate_url('https://formidableforms.com/pricing/#addon-lists') ) ?>" target="_blank">Enterprise Addons</a></td>
			</tr>
		</tbody>
	</table>
	<br/>

	<?php do_action( 'frm_upgrade_page' ); ?>

	<h2>Features</h2>
	<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
				<th style="width:60%"></th>
				<th><h3>Lite</h3></th>
				<th><h3>Pro</h3></th>
			</tr>
		</thead>
		<tbody>
			<tr><th colspan="3" class="frm_table_break">Form Building</th></tr>
			<tr>
				<th>Drag & Drop Form building</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Create forms from Templates</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Import and export forms with XML</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Use Placeholders in your fields that clear when typing starts</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Include text, email, url, paragraph text, radio, checkbox, and dropdown fields in your form</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Include Section headings, page breaks, rich text, number, phone number, date, time, scale, dynamic fields populated from other forms, hidden fields, user ID fields, password, HTML, and tags fields</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Save a calculated value into a field</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Allow File Uploads</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Repeat sections of fields</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Hide and show fields conditionally based on other fields or the user's role</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Confirmation fields</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Multi-paged forms</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr><th colspan="3" class="frm_table_break">Form Actions</th></tr>
			<tr>
				<th>Send multiple emails and autoresponders</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Conditionally send your email notifications based on values in your form</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Create and edit WordPress posts or custom posts from the front-end</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr><th colspan="3" class="frm_table_break">Form Appearance</th></tr>
			<tr>
				<th>Customizable layout with CSS classes</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Customize the HTML for your forms</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Style your form with the Visual Styler</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Create Multiple styles for different forms</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr><th colspan="3" class="frm_table_break">Entry Management</th></tr>
			<tr>
				<th>View form submissions from the back-end</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Export your entries to a CSV</th>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Import entries from a CSV</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Logged-in users can save drafts and return later</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Flexibly and powerfully view, edit, and delete entries from anywhere on your site</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr><th colspan="3" class="frm_table_break">Display Entries</th></tr>
			<tr>
				<th>Generate graphs and stats based on your submitted data</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
			<tr>
				<th>Virtually limitless views</th>
				<td><i class="frm_icon_font frm_cancel1_icon"></i></td>
				<td><i class="frm_icon_font frm_check_icon"></i></td>
			</tr>
		</tbody>
	</table>
</div>
