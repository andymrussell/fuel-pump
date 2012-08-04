<?php

namespace Pump;

class Controller extends \Controller_Template {

	public $template = 'layouts/default';

	protected $view = '';
	protected $data = array();

	public $page_title;
	public $page_meta;
	



	public function before()
	{
		parent::before();

		$this->controller = strtolower(str_replace('Controller_','',\Request::active()->controller));
		$this->action = \Request::active()->action;

		//Check if there is a a specific template for this controller
		if (file_exists(APPPATH . 'views/layouts/' . $this->controller . '.php'))
		{
			$this->template = \View::forge('layouts/'.$this->controller);
		}

		// Assign current_user to the instance so controllers can use it
		$this->current_user = \Auth::check() ? \Pump\Model\Model_User::find_by_username(\Auth::get_screen_name()) : '';

		// Set a global variable so views can use it
		\View::set_global('current_user', $this->current_user);

		//Load the menu model to show auth (logged in or logged out)
		$top_menu = \Request::forge('menu/auth')->execute();
		$this->template->set('top_menu', $top_menu, false);
	}




	// After controller method has run, output the template
	public function after($response)
	{
		//Pass everything assigned to $this->data globally over all views
		foreach($this->data as $key => $value)
		{
			\View::set_global($key, $value);		
		}

		//Work out what view is being set
		if(empty($this->view))
		{
			$view = $this->controller.'/'.$this->action;
		}
		else
		{
			$view = $this->view;
		}
		
		$this->template->set('content', \View::factory($view,null,false), false);





		//Set the title name
		$this->template->set('page_title', $this->page_title, false);

		if(isset($this->page_meta) && count($this->page_meta) >0)
		{
			foreach($this->page_meta as $key => $item)
			{
				$meta_array[] = array(
					'name'		=> $key,
					'content'	=> $item
				);
			}
			$this->template->set('page_meta', $meta_array);
		}
		
		//Get the messages
		$this->_get_message();


		// If the response is a Response object, we don't want to create a new one
		if ($this->auto_render === true and ! $response instanceof \Response)
		{
			$response = $this->response; 
			$response->body = $this->template;
		}

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
			$this->template->set('message', $message, false);
		}

	}

}