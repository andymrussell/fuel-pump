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
		'login' => array(
			'title' 		=> 'Login',
			'subtitle'		=> 'Enter your login details below',
			'social_title'	=> 'Or login with Facebook',
		),
		'create' => array(
			'title' 	=> 'Create your account',
			'subtitle'	=> 'Signing up is simple, and only takes a few seconds!',
		),

	),
		
	// form field labels
	'field' => array(
		'f_name' 	=> 'First Name',
		'l_name' 	=> 'Last Name',
		'username' 	=> 'Username',
		'password' 	=> 'Password',
		'country_id'=> 'Country',
		'confirm-password' => 'Confirm Password',
		'email' 	=> 'Email',
		'login'		=> '<i class="icon-signin"></i> Login',
		'create'	=> 'Create',
	),



	// action information
	'action' => array(
		'login' => array(
			'failure'	=> 'Incorrect login details.',
		),
		'create' => array(
			'failure'		=> 'Cannot create an account.',
			'validation'	=> 'Some of the fields are not valid.',
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