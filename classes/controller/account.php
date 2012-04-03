<?php

namespace Pump;

class Controller_Account extends Controller {


//	private $form_type = 'form-stacked';
	private $form_type = 'form-horizontal';

	/**
	 * Account Settings page
	 * Change email and password
	 */
    public function action_index()
    {
    	
		$user_model = \Pump\Model\Model_User::find($this->current_user->id);

        $form = \Fieldset::forge('test', array(
                             'form_attributes' => array('class' => $this->form_type)
                             ))->add_model('Pump\Model\Model_User', $user_model)->repopulate();
    	
    	//Set the password field to blank!
    	$form->populate(array('password' => ''));

    	//Add the conf password form item with validation
    	$form->add('conf_password', \Lang::get('field.conf_password'), 
    				array('type' => 'password', 'class' => 'span6'))
    				->add_rule('match_field', 'password');
    	$form->add('old_password', \Lang::get('field.old_password'),
    				array('type' => 'password', 'class' => 'span6'));

    	//Get the validation instance
		$val = $form->validation();


		$this->build_left_nav();




    	if (\Input::method() == 'POST')
    	{
			// Deal with messages
			try
			{
				if ($val->run())
				{
					//Validation was OK, so grab the values we want
					$user_data['email'] = $val->validated('email');
					
					//Is the password being changed
					if($val->validated('password'))
					{
						$user_data['old_password'] = $val->validated('old_password');
						$user_data['password'] = $val->validated('password');
					}

					if(\Auth::instance()->update_user($user_data))
					{
						// Success
						\Pump\Core\Messages::set(\Lang::get('action.edit.success'), 'S');
					}
					else
					{
						// It didnt update correctly
						\Pump\Core\Messages::set(\Lang::get('message.nothing_to_update'), 'I');	
					}
			
				}
				else
				{
					$message = '';
				
					$errors = $val->error();
					//Loop validation errors to send back as info.
					foreach($errors as $error)
					{
						$message .= $error->get_message(false, '<p>', '</p>');
					}
					\Pump\Core\Messages::set($message, 'E');
				}
			}
			catch (\Orm\ValidationFailed $e)
			{
				\Pump\Core\Messages::set(\Lang::get('action.edit.failure'), 'E');
			}
			catch (\Auth\SimpleUserUpdateException $e)
			{
				\Pump\Core\Messages::set(\Lang::get('action.edit.failure'), 'E');	
			}
			catch (\Auth\SimpleUserWrongPassword $e)
			{
				\Pump\Core\Messages::set(\Lang::get('message.old_password_incorrect'), 'E');
			}	
		}
		
		//\System\Core\Util::redirect($this->baseurl);		


		\View::set_global('form', $form);
		$this->page_title = \Lang::get('form.title');
		$this->template->content = \View::forge('account/form',null,false);

    }





    /**
     * Profile Settings Page
     */
    public function action_profile()
    {   
        $profile_model = \Pump\Model\Model_Profile::find()->where('user_id', $this->current_user->id)->get_one();
                
        $form = \Fieldset::factory('test', array(
                             'form_attributes' => array('class' => $this->form_type)
                             ))->add_model('Pump\Model\Model_Profile', $profile_model)->repopulate();
    	
    	if (\Input::method() == 'POST')
    	{
			// Deal with messages
			try
			{
				if ($profile_model->save())
				{
					\Pump\Core\Messages::set(\Lang::get('action.edit.success'), 'S');
				}
				else
				{
					\Pump\Core\Messages::set(\Lang::get('action.edit.failure'), 'E');
				}
			}
			catch (\Orm\ValidationFailed $e)
			{
				//\Debug::dump('FORM VALIDATION FAILED!', $e->getMessage());
				\Pump\Core\Messages::set(\Lang::get('action.edit.failure'), 'E');

			}

		}
		
		//\System\Core\Util::redirect($this->baseurl);		

		\View::set_global('form', $form);

		$this->page_title = \Lang::get('form.title');
		$this->template->content = \View::forge('account/form',null,false);

    }


    private function build_left_nav()
    {
		//Show the left menu?
		$this->left_menu['contents'][] = array(
			'Accounts' => array(
				array(
					'selected'	=> false,
					'title'		=> 'Settings',
					'icon'		=> 'icon-cog',
					'href'		=> '#',
				),
				array(
					'selected'	=> false,
					'title'		=> 'More',
					'icon'		=> 'icon-user',
					'href'		=> '#',
				)
			),
		);


		//What contents does it have?
		$this->left_menu['display'] = true;
		
    }

}

