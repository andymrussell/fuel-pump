<?php

namespace Pump\Model;

class Model_JobScheduleStatus extends \Orm\Model
{

	protected static $_table_name = 'job_schedule_status';

	protected static $_properties = array(
		'id',
		'live' => array(
			'data_type' => 'int',
		),
		'api_name' => array(
			'data_type' => 'varchar',
		),
		'start_time' => array(
			'data_type' => 'int',
		),
		'sleep_time' => array(
			'data_type' => 'int',
		),
		'counter' => array(
			'data_type' => 'int',
		),
		'limit' => array(
			'data_type' => 'int',
		),		
	);



}
