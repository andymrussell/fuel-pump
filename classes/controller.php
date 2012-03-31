<?php

namespace Pump;

class Controller extends \Controller_Template {


	public $page_title;
	public $page_meta;
	
	public $dimensions = array(
			'left_col'		=> array(
				'display'		=> false,
				'dimensions'	=> 2,
			),
			'middle_col'	=> array(
				'display'		=> false,
				'dimensions'	=> 8,
			),
			'right_col'		=> array(
				'display'		=> false,
				'dimensions'	=> 2,
			),
		);


	public function before()
	{
		parent::before();
		
		//Autoload the account module as it contains the user access
		\Fuel::add_module("Auth");

		// Assign current_user to the instance so controllers can use it
		$this->current_user = \Auth::check() ? \Auth\Model_User::find_by_username(\Auth::get_screen_name()) : '';

		// Set a global variable so views can use it
		\View::set_global('current_user', $this->current_user);

		//Load the menu model to show auth (logged in or logged out)
		$top_menu = \Request::forge('menu/auth')->execute();
		$this->template->set('top_menu', $top_menu, false);

	}


	private function _check_menu_dimensions()
	{
		if(!isset($this->template->left_col) || empty($this->template->left_col))
		{
			$this->dimensions['middle_col']['dimensions'] = $this->dimensions['middle_col']['dimensions'] + $this->dimensions['left_col']['dimensions'];
			$this->dimensions['left_col']['dimensions'] = 0;
		}

		if(!isset($this->template->right_col) || empty($this->template->right_col))
		{
			$this->dimensions['middle_col']['dimensions'] = $this->dimensions['middle_col']['dimensions'] + $this->dimensions['right_col']['dimensions'];
			$this->dimensions['right_col']['dimensions'] = 0;
		}
	}

	// After controller method has run output the template
	public function after($response)
	{
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

		//Check the dimensions of and remove the side nav where needed
		$this->_check_menu_dimensions();
		\View::set_global('dimensions', $this->dimensions);

		// If the response is a Response object, we don't want to create a new one
		if ($this->auto_render === true and ! $response instanceof \Response)
		{
			$response = $this->response; 
			$response->body = $this->template;
		}

		return parent::after($response);
	}


	public function _get_message()
	{
	
		$message = \Pump\Core\Messages::get_messages();
		$this->template->set('message', $message, false);

	}

}