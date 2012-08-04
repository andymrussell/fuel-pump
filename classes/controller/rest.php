<?php

namespace Pump;

class Rest extends \Controller_Rest
{

	public $current_user;
	public $controller;
	public $action;

	public $status = array(
		'ok' 	=> 'OK',
		'error' => 'Error',
	);

	public function before()
	{
		parent::before();
		\Profiler::mark('\Pump\Controller\Rest::before Start');

		//Get the controller and action to use for autoloading
		$this->controller = strtolower(str_replace('Controller_','',\Request::active()->controller));
		$this->action = \Request::active()->action;

		//Assign current_user to the instance so controllers can use it
		$this->current_user = \Auth::check() ? \Pump\Model\Model_User::find_by_username(\Auth::get_screen_name()) : '';
	}

	function test()
	{
		echo 'test';
	}
}