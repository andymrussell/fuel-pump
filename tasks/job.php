<?php

namespace Pump\Tasks;


class Scan_Exception extends \Oil\Exception {}

class Job
{

	private static $server_id = 1;
	private static $job_id;
	private static $status_map = array(
		'ERROR'		=> 0,
		'COMPLETE' 	=> 1,
	);

	private static $errors = array(
		'DEFAULT'				=> 'There was an error',
		'CLASS_DOESNT_EXIST'	=> 'Class Doesn\'t Exist',
		'JOB_NOT_FOUND'			=> 'Job Not Found',
		);

	/**
	 * Scan jobs
	 * Call with: oil r job:scan
	 */
	public function scan()
	{
		$responce = '';
		 
		for ($i=1; $i < 10; $i++) {
			echo \Cli::color('Cycle '.$i, 'green')."\n";
			self::scan_job();
			echo "\n";
		}

		return $responce;
	}


	/**
	 * Create a new Job
	 * Use this to start adding other jobs
	 * Call with: oil r job:create "command|method"
	 */
	public static function create($value ='')
	{
		$split = explode('|',$value);

		if(!isset($split[0]))
		{
			throw new \Pump\Tasks\Scan_Exception (self::$errors['CLASS_DOESNT_EXIST']);
		}

		if(!isset($split[1]))
		{
			$split[1] = 'create_jobs';
		}

		$new = new \Pump\Model\Model_JobSchedule();
		$new->cmd = trim($split[0]);
		$new->data = json_encode(array(
			'method'		=> trim($split[1]),
			));

		$new->save();
	}
		

	/**
	 * Scan jobs - Perform individual job
	 */
	private static function scan_job()
	{

		$job = \Pump\Model\Model_JobSchedule::find()
						->where('server_id', self::$server_id)
						->where('status_id', NULL)
						->order_by('created_at', 'desc')
						->get_one();
		try{
				
			if($job)
			{
				self::$job_id = $job->id;
				$job_class = $job->cmd;

				//Check if the Tasks Class exists / If not then return message here
				if (!class_exists($job_class))
					throw new \Pump\Tasks\Scan_Exception (self::$errors['CLASS_DOESNT_EXIST'].' ('.$job_class.')');

				//Load the Jobs Class and pass in the JOB ID and DATA
				$c = new $job_class(self::$job_id);
				$c->run(json_decode($job->data));
			}
			else
			{
				self::$job_id = null;
				throw new \Pump\Tasks\Scan_Exception (self::$errors['JOB_NOT_FOUND']);
			}


		}
		catch (\Pump\Tasks\Scan_Exception $e)
		{
			$msg = $e->getMessage();
			\Log::error($msg);
			echo \Cli::color($msg."\n", 'red');

			if(isset(self::$job_id))
				self::_set_status('ERROR', $msg);
		}
	}


	/**
	 * Set the status of the job when it is complete
	 */
	private static function _set_status($status = 'COMPLETE', $error_msg = '')
	{
		if(isset(self::$job_id))
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
				//echo "Error MSG:\n".$error_msg."\n";
			}
			$entry->save();
		}
	}




}
