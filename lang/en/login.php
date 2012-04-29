<?php
/**
 * Language file for the module controller exitecms/users
 */

return array(

	'page'	=> array(
		'login'	=> array(
			'title'	=> 'Account | Login',
		),
		'create'	=> array(
			'title'	=> 'Account | Create',
		),
	),

	'form' => array(
		'title' 	=> 'Login',
		'subtitle'	=> 'Enter your login details below',
	),
		
	// form field labels
	'field' => array(
		'username' => 'Username',
		'password' => 'Password',
		'login' => 'Login',
	),



	// action information
	'action' => array(
		'login' => array(
			'failure'	=> 'Incorrect login details.',
		),
		'create' => array(
			'failure'	=> 'Cannot create an account.',
		),
	),


	// buttons
	'button' => array(
		'update' => 'Update your profile settings',
	),

	// messages
	'message' => array(
		'access-denied'	=> 'Access Denied',
	),

	// validation strings
	'validation' => array(
	),

	// other texts
	'other' => array(
		'genderlist' => array(
			'M' => 'Male',
			'F' => 'Female',
		),
	),
);

/* End of file users.php */