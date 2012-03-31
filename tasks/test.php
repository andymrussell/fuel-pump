<?php
/**
 * Test task to make sure jobs are running OK!
 * oil r job:create "Pump\Tasks\Test"
 */

namespace Pump\Tasks;

class test extends Base
{

	// public static $counter_on = true;	//Turn on the counter for this API type
	// public static $api_name = 'TEST';	//Set an API name (this must be defined in the database also)

	public static function create_jobs()
	{
		echo \Cli::color("It works!! \n", 'blue');
		self::set_status('COMPLETE');	
	}
}