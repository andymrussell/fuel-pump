<?php
/**
 * This class should only control basic log in / log out functionality 
 * IT DOES NOT CHECK AUTH STATUS BY DEFAULT
 */

namespace Pump;

class Controller_Auth extends Controller_Admin {

    public function before()
    {
        parent::before();
        \Lang::load('admin');
        \Config::load('admin');
    }

    public function action_index()
    {
        \Pump\Core\Util::redirect(\Config::get('login_url'));
    }



    public function action_login()
    {

        $view_data = array();

        if (\Input::method() == 'POST')
        {
            $val = \Validation::factory();
            $val->add('username', \Lang::get('field.username'))->add_rule('required');
            $val->add('password', \Lang::get('field.password'))->add_rule('required');


            if ($val->run())
            {
                $auth = \Auth::instance();
                if($auth->login($_POST['username'],$_POST['password']))
                {
                    // credentials ok, go right in
                    \Pump\Core\Util::redirect(\Config::get('main_admin_url'));
                }
                else
                {
                    // Failed login
                    \Pump\Core\Messages::set(\Lang::get('action.login.failure'), 'E');
                } 
            }
            else
            {
                // Failed login
                \Pump\Core\Messages::set(\Lang::get('action.login.failure'), 'E');
            }
        }

        $this->page_title = \Lang::get('page.login.title');
        $this->template->content = \View::forge('account/login',$view_data,false);
    }


    public function action_logout()
    {
        \Auth::instance()->logout();
        \Pump\Core\Util::redirect('/');

    }




    public function action_create()
    {
        //Check if the config allows for new account creations
        if(\Config::get('create_access') == false)
        {
            \Pump\Core\Messages::set(\Lang::get('messages.access-denied'), 'E');
            \Pump\Core\Util::redirect(\Config::get('login_url'));
        }
        else
        {

            if (\Input::method() == 'POST')
            {

                $val = \Validation::factory();
                $val->add('username', 'Username')
                    ->add_rule('required')
                    ->add_rule('min_length', 3)
                    ->add_rule('max_length', 10);
                
                $val->add('email', 'Email')
                    ->add_rule('valid_email')        
                    ->add_rule('required')
                    ->add_rule('min_length', 3);
                                            
                $val->add('password', 'Password')
                    ->add_rule('required')
                    ->add_rule('min_length', 3)
                    ->add_rule('max_length', 10);

                $val->add('conf_password', 'Confirm Password')
                    ->add_rule('required')
                    ->add_rule('match_field','password');

         
                if ($val->run())
                {
                    $create_user = \Auth::instance()->create_user( 
                        $val->validated('username'), 
                        $val->validated('password'), 
                        $val->validated('email'));

                    if($create_user)
                    {
                        \Pump\Core\Util::redirect(\Config::get('after_create_url'));
                    }
                    else
                    { 
                        \Pump\Core\Messages::set(\Lang::get('action.create.failure'), 'E');
                    }
                }
            }


            $this->page_title = \Lang::get('page.create.title');
            $this->template->content = \View::factory('account/create');  
        }
    }

}

