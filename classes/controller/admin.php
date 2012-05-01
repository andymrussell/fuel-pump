<?php

namespace Pump;

class Controller_Admin extends Controller {

	protected static $skip_auth_check = array('login','logout');

	public function before()
	{
		parent::before();
		\Lang::load('login');
		\Config::load('login');


		$segment = \Uri::segment(2);
		if(!in_array($segment,static::$skip_auth_check))
		{
			if ( ! \Auth::check())
			{
				\Pump\Core\Util::redirect(\Config::get('login_url'));

			}			
		}
	}

}
