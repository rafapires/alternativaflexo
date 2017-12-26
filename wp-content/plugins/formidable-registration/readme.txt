== Changelog ==
= 2.01.01 =
* New: Add frmreg_after_create_subsite action.
* New: Add Norwegian translation.
* New: Add frmreg_login_error filter hook.
* Fix: Make sure show lost password and layout settings apply to widget.
* Fix: Convert special characters to standard characters in subdomain.

= 2.01 =
* New: Add global registration page setting.
* Enhancement: Allow radio and select fields for display name.
* Enhancement: Show hidden field type in Subdirectory or Subdomain settings.
* Enhancement: Always allow administrators to edit profiles through registration form.
* Enhancement: Redirect to login page if activation link is clicked again after activation.
* Enhancement: Change field label in lost password form.
* Fix: Show error messages in reset password form.
* Fix: Set logout label parameter correctly in shortcode builder.
* Fix: Passwords with special characters not saving as expected.

= 2.0.01 =
* Fix: Sliding login form in IE and Edge
* Fix: Set the login form and reset password form action the same way WordPress does
* Fix: Include lostpassword_form action in lost password form
* Fix: Allow HTML in login error messages

= 2.0 =
* New: In multi-site, allow subsite creation
* New: Add global message settings
* New: Add reset and lost password forms
* New: Add option to create users on import
* New: Allow other actions to trigger registration action
* New: Add registration trigger to API action
* New: Allow selected roles to create new users with registration form
* New: Class parameter for frm-login shortcode
* New: Add parameter to set lost password text in frm-login shortcode
* New: Add lost password option to widget settings
* New: Add frmreg_password_field_types hook
* New: Add frmreg_after_create_user action that fires after a user is created
* New: Add shortcode for primary site URL
* Enhancement: Add migration for pre Formidable 2.0 settings
* Enhancement: Create new user and admin notification with migration
* Enhancement: Adjust login form HTML so it matches Formidable form HTML and classes
* Enhancement: Allow captcha addition to login form
* Fix: Validate registration fields only when registration action is triggered
* Fix: Make sure redirect option isn't lost on invalid login

= 1.11.09 =
* Fix: Fix importing usermeta

= 1.11.08 =
* Fix: Update for deprecated get_media_from_id function

= 1.11.07 =
* Fix: Adjust deprecated argument for wp_new_user_notification
* Fix: Fix undefined index error

= 1.11.06 =
* New: Add hook for customizing activation message on page
* Fix: Make sure fields linked to user meta are updated when an entry is edited
* Fix: Get updates from FormidablePro.com

= 1.11.05 =
* Fix: Address bug with userID not saving in child entries

= 1.11.04 =
* New: Added frmreg_email_content_type hook
* New: Add frmreg_new_role hook to confirmation email option
* New: Add frm-login shortcode to shortcode builder
* New: Add label_logout to login shortcode
* Enhancement: Validate username and email when a user is registered
* Fix: Login form widget
* Fix: Don't load the form css if it is turned off in the settings
* Fix: Display Name set to First Last bug
* Fix: Don't populate entries with admin details when editing

= 1.11.03 =
* Fix: Address user meta bug for Formidable 1.07.11

= 1.11.02 =
* Enhancement: Redirect user to page they were on after login
* Enhancement: Add Formidable styling to login form
* Fix: Improve Formidable 2.0 compatibility

= 1.11.01 =
* Fix: Check version number correctly

= 1.11 =
* New: Added Email confirmation option for new users
* New: Added global Login and Logout page setting
* New: Add hooks to customize email validation message
* Fix: Fixed problem some users were having with registering and creating posts with the same form

= 1.10 =
* Added functionality to work with Formidable v2.0
* Prevent passwords from getting set to blank on update
* Requires at least Formidable v1.07.02

= 1.09.01 =
* Log users in before the page is displayed after changing their password
* Check usernames and passwords for illegal characters
* Update avatars when new file is uploaded
* Fix avatars when not selected in registration settings

= 1.09 =
* Added avatar support into registration options
* Removed dropdown for inserting fields into email subject and message boxes
* Added function to send registration email after payment is received
* Updated options UI, and the way user meta is added
* Added email from options
* Automatically log users in after changing their password
* Allow frm-login short code in text widget
* Fixed default redirect after login
* Added frm_FrmRegLoginForm::login_form class to login form

= 1.08 =
* Added redirect option to frm-login shortcode
* Removed unnecessary globals and constants
* Updated for Formidable 1.07.02 compatibility
* Fixed validation for logged-out user

= 1.07 =
* Added PO file for translations
* Fixed usage of inactive registration settings when editing an entry
* Changed automatic login to use wp_ajax

= 1.06 =
* Fixed validation for editing when user ID field is not placed before other fields
* Allow admins to create new entries from back end for existing users

= 1.05 =
* Updated validation to make sure usernames and emails are still unique when editing

= 1.04 =
* Also check existence of username when an admin is creating a new user
* Make sure extra profile values like "show toolbar" are not lost if not included in a form
* Update auto-updating to work with Formidable v1.07+

= 1.03 =
* Don't require a password field when editing
* Correctly update the Website field on the user profile when using user meta "user_url"
* Added frmreg_user_data hook

= 1.02 =
* Added filter on the user role new users will be created with
* Only show user meta one time on the profile page if multiple forms are being used for the same user meta
* Fixed bug with first and last name display names

= 1.01 =
* Added option to customize welcome email
* Fixed bug causing a blank email field on edit
* Automatically add a user ID field to a registration form is there isn't one yet. This is necessary in order to update the correct user account.
* Added display name option to registration settings
* Added rich text fields to the allowed list of fields to use in registration settings

= 1.0 =
* Added login form [frm-login]
* Added login widget
* Fixed automatic login for newly created users

= 1.0rc4 =
* Moved settings for Formidable 1.6 compatibility
* Added password field support. Passwords are automatically removed from Formidable so they won't be saved in plain text.
* Check for any updated user info before showing editable profile

= 1.0rc3 =
* Fixed bug preventing the "Use Full Email Address" option from staying selected

= 1.0rc2 =
* Show the name instead of the ID for data from entries fields on the WP profile page
* Added option to use full email address as username
* Added option to not automatically log in
* Allow admins to edit and create other users from the front-end

= 1.0rc1 =
* Fixed user creation with screenname field
* Automatically log user in after submitting new form

= 1.0b3 =
* Added check boxes to user meta options
* Display user meta on profile page

= 1.0b2 =
* Updated registration to allow the entries to be edited from the backend by users other than the owner of the entry

== TODO ==
* BuddyPress integration
* allow fields to be added to registration page and save as user meta/blog meta