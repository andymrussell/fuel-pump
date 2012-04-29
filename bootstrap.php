<?php
/**
 * Pump Tools for multiple applications
 */
Autoloader::add_core_namespace('Extend');

Autoloader::add_classes(array(
	'Pump\\Controller' 			    				=> __DIR__.'/classes/controller/controller.php',
	'Pump\\Controller_Auth' 			    		=> __DIR__.'/classes/controller/auth.php',
	'Pump\\Controller_Account' 			    		=> __DIR__.'/classes/controller/account.php',
	'Pump\\Controller_Admin' 			    		=> __DIR__.'/classes/controller/admin.php',
	'Pump\\Core\\Exception'  	    		    	=> __DIR__.'/core/exception.php',
	'Pump\\Core\\Messages'  		       		 	=> __DIR__.'/core/messages.php',
	'Pump\\Core\\Util' 	 		       		 		=> __DIR__.'/core/util.php',

	//Models
	'Pump\\Model\\Model_JobSchedule' 	   			=> __DIR__.'/classes/model/jobschedule.php',
	'Pump\\Model\\Model_JobScheduleStatus' 			=> __DIR__.'/classes/model/jobschedulestatus.php',
	
	'Pump\\Model\\Model_User'		 				=> __DIR__.'/classes/model/user.php',
	'Pump\\Model\\Model_Profile'		 			=> __DIR__.'/classes/model/profile.php',

	//Tasks
	'Pump\\Tasks\\Base' 	 	        			=> __DIR__.'/tasks/base.php',
	'Pump\\Tasks\\Job' 			 					=> __DIR__.'/tasks/job.php',
	'Pump\\Tasks\\Test' 			 				=> __DIR__.'/tasks/test.php',

	//Exceptions
	'Pump\\Tasks\\Scan_Exception' 			 		=> __DIR__.'/tasks/job.php',

	//Helpers
	'Pump\\Helper\\Elements' 	   					=> __DIR__.'/helpers/elements.php',

	//Other Classes
	'Pump\\Pagination' 	   							=> __DIR__.'/classes/pagination.php',
	'Pump\\Asset'									=> __DIR__.'/classes/asset.php',


	'Extend\Fieldset_Field' 						=>__DIR__.'/classes/field.php',

));


/* End of file bootstrap.php */