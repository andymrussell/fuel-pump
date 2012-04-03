<?php
/**
 * Language file for the module controller exitecms/users
 */

return array(


	'form' => array(
		'title' 	=> 'Account Details',
		'subtitle'	=> 'Update your account details below',
	),

	// form field labels
	'field' => array(
		'username' => 'Username',
		'email' => 'Email',
		'old_password' => 'Old Password',
		'password' => 'Password',
		'conf_password' => 'Confirm Password',
	),



	// action information
	'action' => array(
		'edit' => array(
			'title' => 'User settings',
			'form' => 'Edit your settings',
			'info' => 'Edit Your settings information to ensure you are up to date.',
			'success' => 'Settings updated successfully.',
			'failure' => 'Error updating settings.',
		),
	),


	// buttons
	'button' => array(
		'update' => 'Update your profile settings',
	),

	// messages
	'message' => array(
		'old_password_incorrect' => 'The old password you entered is incorrect',
		'nothing_to_update'		 => 'Nothing to update'
	),

	// validation strings
	'validation' => array(
	),

	// other texts
	'other' => array(
	),
);

/* End of file users.php */