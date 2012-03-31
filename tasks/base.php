<?php


namespace Pump\Tasks;


class Base
{

	private static $job_id;
	public static $counter_on = false;
	public static $api_name;
	public static $api_id;

	private static $status_map = array(
		'ERROR'		=> 0,
		'COMPLETE' 	=> 1,
		);

	private static $errors = array(
		'DEFAULT'			=> 'There was an error',
		'API_NOT_FOUND'		=> 'API not found',
		'NO_METHOD_SET'		=> 'No method set',
		'NO_API_DATA_FOUND' => 'No API data found',
		);

	/**
	 * Constructor
	 */
	public function __construct($job_id)
	{
		self::$job_id = $job_id;
		//Echo the child class that is loaded
		echo \Cli::color('Class Found: '.get_called_class(), 'green')."\n";
	}


	private static function _api_check()
	{
		if(isset(static::$api_name))
		{
			$api = \Pump\Model\Model_JobScheduleStatus::find()->where('api_name', strtoupper(static::$api_name))->get_one();
			if(isset($api->id) && (int) $api->id >0)
			{
				static::$api_id = $api->id;
				echo \Cli::color('API Found: '.static::$api_name, 'green')."\n";

				$time_stamp = \Date::time()->get_timestamp();
				if((int) $api->start_time >= (int) $time_stamp)
				{
					echo \Cli::color('Scan on hold for: '. ((int) $api->start_time - (int) $time_stamp). ' seconds' , 'red')."\n";
					//Exit here to keep the status of the jobs the same!
					exit();
				}

			}
			else
			{
				self::set_error('API_NOT_FOUND', static::$api_name);
			}
		}		
	}

	/**
	 * Initial method that gets run when a scan is called
	 */
	public static function run($data = array())
	{
		self::_api_check();

		echo 'Job ID:'.self::get_job_id()."\n";
		
		if(isset($data->method))
		{
			$method = $data->method;
			static::$method($data);		
		}
		else
		{
			static::set_error('NO_METHOD_SET');
		}
	}

	/**
	 * Set and throw an error
	 */
	public static function set_error($key, $value = '')
	{

		if(isset(self::$errors[$key]))
		{
			throw new \Pump\Tasks\Scan_Exception (self::$errors[$key].' ('.$value.')');
		}
		else
		{
			throw new \Pump\Tasks\Scan_Exception (self::$errors['DEFAULT']);
		}
	}

	/**
	 * Get the current Job ID
	 */
	public static function get_job_id()
	{
		return self::$job_id;
	}

	/**
	 * Increment the counter if it is on
	 */
	public static function counter_add($add = 1)
	{
		if(static::$counter_on)
		{
			$status = \Pump\Model\Model_JobScheduleStatus::find()
							->where('api_name', strtoupper(static::$api_name))
							->get_one();

			//If counter has reached limit then set future time
			if($status->counter >= $status->limit-1)
			{
				$time_stamp = \Date::time()->get_timestamp();
				$status->start_time = $time_stamp + (int) $status->sleep_time;
				$status->counter = 0;
				$add = 0;

				echo \Cli::color('Scan on hold for: '. ((int) $status->sleep_time). ' seconds' , 'red')."\n";
				//Exit here to keep the status of the jobs the same!
				exit();
			}

			$status->counter = $status->counter + $add;
			$status->save();

			return $status->counter;
		}
		else
		{
			return false;
		}
	}

	public static function check_apis_left()
	{
		$status = \Pump\Model\Model_JobScheduleStatus::find()
							->where('api_name', strtoupper(static::$api_name))
							->get_one();
		
		return (int) $status->limit - $status->counter;
	}

	/**
	 * Set the status of the job in the database
	 */
	public static function set_status($status = 'COMPLETE', $error_msg = '')
	{
		$job_id = self::$job_id;
		$error_num = self::$status_map[$status];

		echo "Set jobID: ".$job_id." to status({$error_num} - {$status})\n";

		$entry = \Pump\Model\Model_JobSchedule::find($job_id);
		$entry->status_id = $error_num;
		$entry->memory_usage = memory_get_peak_usage();
		
		if($status == 'ERROR' && $error_msg !='')
		{
			$entry->error = $error_msg;

			echo "Error MSG:\n".$error_msg."\n";
		}
		$entry->save();

	}

}
