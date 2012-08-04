<?php

namespace Pump;

class Controller extends \Controller_Template {

	public $config = array();					//Load config files
	public $template = 'layouts/default';		//Default template
	public $layout  = '';						//Override template layout

	protected $view = '';						//Override the view to be loaded
	protected $data = array();					//Data to be set globally for all views

	public $page_title;							//Page title
	public $page_meta;							//Page meta tags
	



	public function before()
	{
		parent::before();
		\Profiler::mark('\Pump\Controller\Controller::before Start');

		if(is_array($this->config) && count($this->config))
		{
			foreach($this->config as $config)
			{
				\Config::load($config);
			}
		}

		//Get the controller and action to use for autoloading
		$this->module = \Request::active()->module;
		$this->controller = strtolower(str_replace('Controller_','',\Request::active()->controller));
		$this->action = \Request::active()->action;


		//Assign current_user to the instance so controllers can use it
		$this->current_user = \Auth::check() ? \Pump\Model\Model_User::find_by_username(\Auth::get_screen_name()) : '';

		//Set a global variable so views can use it
		\View::set_global('current_user', $this->current_user);

		//Load the menu model to show auth (logged in or logged out)
		$top_menu = \Request::forge('menu/auth')->execute();
		\View::set_global('top_menu', $top_menu, false);	
	}




	//After controller method has run, output the template
	public function after($response)
	{


		//Check if there is a a specific template for this controller
		if(isset($this->layout) && !empty($this->layout))
		{

			if (file_exists(APPPATH . 'views/layouts/' . $this->layout . '.php'))
			{
				$this->template = \View::forge('layouts/'.$this->layout);
			}
		}
		else
		{

			//With HMVC we need to default load the template in the module if it exists.
			//If not check if there is a layout file in the standard layouts folder
			if(isset($this->module))
			{
				$split = explode('\\',$this->controller);
				$layout = $split[1];

				if (file_exists(APPPATH . 'modules/'.$this->module.'/views/layouts/' . $layout . '.php'))
				{
					$this->template = \View::forge($this->module.'::layouts/'.$layout);
				}
				else
				{
					if (file_exists(APPPATH . 'views/layouts/' . $layout . '.php'))
					{
						$this->template = \View::forge('layouts/'.$layout);
					}	
				}

			}
			else
			{
				if (file_exists(APPPATH . 'views/layouts/' . $this->controller . '.php'))
				{
					$this->template = \View::forge('layouts/'.$this->controller);
				}	
			}		
		}

		//Pass everything assigned to $this->data globally over all views
		foreach($this->data as $key => $value)
		{
			\View::set_global($key, $value);
		}

		if($this->layout == 'ajax')
		{
			$this->view = 'layouts/ajax';
		}

		//Work out what view is being set
		if(empty($this->view))
		{
			$view = $this->controller.'/'.$this->action;

			//With HMVC we need to default load the view in the module
			if(isset($this->module))
			{
				$split = explode('\\',$view);
				$view = $split[1];
				$view = $this->module.'::'.$view;
			}
		}
		else
		{
			$view = $this->view;
		}
		

		\View::set_global('content', \View::forge($view,null,false), false);




		//Set the title name
		\View::set_global('page_title', $this->page_title, false);

		if(isset($this->page_meta) && count($this->page_meta) >0)
		{
			foreach($this->page_meta as $key => $item)
			{
				$meta_array[] = array(
					'name'		=> $key,
					'content'	=> $item
				);
			}
			//$this->template->set('page_meta', $meta_array);
			\View::set_global('page_meta', $meta_array, false);
		}
		
		//Get the messages
		$this->_get_message();


		//If the response is a Response object, we don't want to create a new one
		if ($this->auto_render === true and ! $response instanceof \Response)
		{
			$response = $this->response; 
			$response->body = $this->template;
		}

		\Profiler::mark_memory($this->data, 'Controller view data');
		\Profiler::mark('\Pump\Controller\Controller::after End');

		return parent::after($response);
	}

	public static function sitemap($data = array())
	{
		header('Content-Type: application/xml');
		return '<?xml version="1.0" encoding="UTF-8" ?>'."\n".\View::forge('sitemap',array('data' => $data),false);
	}

	public function _get_message()
	{
		if(\Request::main() === \Request::active())
		{
			$message = \Pump\Core\Messages::get_messages();
			\View::set_global('message', $message, false);
		}

	}

}