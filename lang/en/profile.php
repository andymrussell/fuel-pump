<?php
/**
 * Language file for the module controller exitecms/users
 */

return array(


	'form' => array(
		'title' 	=> 'User profile',
		'subtitle'	=> 'Update your profile information below',
	),
		
	// form field labels
	'field' => array(
		'f_name' => 'First Name',
		'l_name' => 'Last Name',
		'gender' => 'Gender',
		'dob' => 'Date Of Birth',
		'country_id' => 'Country',
	),



	// action information
	'action' => array(
		'edit' => array(
			'form' 		=> 'Edit your profile',
			'info'		=> 'Edit Your profile information to ensure you are up to date.',
			'success' 	=> 'The profile has been updated.',
			'failure'	=> 'Error updating the profile.',
		),
	),


	// buttons
	'button' => array(
		'update' => 'Update your profile settings',
	),

	// messages
	'message' => array(
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