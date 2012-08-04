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
        \Response::redirect('auth/login');
    }



    public function action_login()
    {

        $view_data = array();

        if (\Input::method() == 'POST')
        {
            $val = \Validation::forge();
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
    }


    public function action_logout()
    {
        \Auth::instance()->logout();
        \Pump\Core\Util::redirect('/');
    }

    //Social Account Creation
    public function action_social()
    {
        //Check if the config allows for new account creations
        if(\Config::get('create_access') == false)
        {
            \Pump\Core\Messages::set(\Lang::get('messages.access-denied'), 'E');
            \Pump\Core\Util::redirect(\Config::get('login_url'));
        }

        $user_hash = \Session::get('ninjauth.user');
        $authentication = \Session::get('ninjauth.authentication');
        if(!$authentication)
        {
            \Pump\Core\Messages::set(\Lang::get('messages.access-denied'), 'E');
           \Pump\Core\Util::redirect(\Config::get('login_url'));
        }

        // Working with what?
        $strategy = \NinjAuth\Strategy::forge($authentication['provider']);

        $full_name = \Arr::get($user_hash, 'name');
        $split = explode(' ', $full_name);
        $f_name = (isset($split[0]) ? $split[0] : '');
        $l_name = (isset($split[1]) ? $split[1] : '');
        $username = \Arr::get($user_hash, 'nickname');
        $email = \Arr::get($user_hash, 'email');



        if (\Input::method() == 'POST')
        {
            $val = \Validation::forge();
            $val->add('username', 'Username')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 15);

            $val->add('f_name', 'First Name')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 30);

            $val->add('l_name', 'Last Name')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 30);

            $val->add('country_id', 'Country')
                ->add_rule('required')
                ->add_rule('min_length', 1)
                ->add_rule('max_length', 3);
            
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
                    //Add the Users Name to the profile field
                    $profile_model = new \Pump\Model\Model_Profile();
                    $profile_model->user_id = $create_user;
                    $profile_model->f_name = $val->validated('f_name');
                    $profile_model->l_name = $val->validated('l_name');
                    $profile_model->country_id = $val->validated('country_id');
                    $profile_model->save();
                    
                    //Now save the Social Authentication token details
                    \NinjAuth\Model_Authentication::forge(array(
                        'user_id' => $create_user,
                        'provider' => $authentication['provider'],
                        'uid' => $authentication['uid'],
                        'access_token' => $authentication['access_token'],
                        'secret' => $authentication['secret'],
                        'refresh_token' => $authentication['refresh_token'],
                        'expires' => $authentication['expires'],
                        'created_at' => time(),
                    ))->save();

                    //Forece the user login
                    if(\Config::get('after_create_login'))
                    {
                        \Auth::instance()->force_login($create_user);
                    }
                    
                    \Pump\Core\Util::redirect(\Config::get('after_create_url'));
                }
                else
                { 
                    \Pump\Core\Messages::set(\Lang::get('action.create.failure'), 'E');
                }
            }
            else{
                \Pump\Core\Messages::set(\Lang::get('action.create.validation'), 'E');
            }
        }

        //Populate the form default values to be sent to the view
        $this->data['username'] = $username;
        $this->data['f_name']   = $f_name;
        $this->data['l_name']   = $l_name;
        $this->data['email']    = $email;

        \Lang::load('countrycodes', 'countries');
        $this->data['countries'] = \Lang::get('countries');
        $this->view = 'auth/create';
        
        $this->page_title = \Lang::get('page.create.title');
    }

    public function action_create()
    {
        //Check if the config allows for new account creations
        if(\Config::get('create_access') == false)
        {
            \Pump\Core\Messages::set(\Lang::get('messages.access-denied'), 'E');
            \Pump\Core\Util::redirect(\Config::get('login_url'));
        }

        if (\Input::method() == 'POST')
        {

            $val = \Validation::forge();
            $val->add('username', 'Username')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 15);

            $val->add('f_name', 'First Name')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 30);

            $val->add('l_name', 'Last Name')
                ->add_rule('required')
                ->add_rule('min_length', 3)
                ->add_rule('max_length', 30);

            $val->add('country_id', 'Country')
                ->add_rule('required')
                ->add_rule('min_length', 1)
                ->add_rule('max_length', 3);
            
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
                    //Add the Users Name to the profile field
                    $profile_model = new \Pump\Model\Model_Profile();
                    $profile_model->user_id = $create_user;
                    $profile_model->f_name = $val->validated('f_name');
                    $profile_model->l_name = $val->validated('l_name');
                    $profile_model->country_id = $val->validated('country_id');
                    $profile_model->save();

                    //Forece the user login
                    if(\Config::get('after_create_login'))
                    {
                        \Auth::instance()->force_login($create_user);
                    }
                    \Pump\Core\Util::redirect(\Config::get('after_create_url'));
                }
                else
                { 
                    \Pump\Core\Messages::set(\Lang::get('action.create.failure'), 'E');
                }
            }
            else{
                \Pump\Core\Messages::set(\Lang::get('action.create.validation'), 'E');
            }
        }

        \Lang::load('countrycodes', 'countries');
        $this->data['countries'] = \Lang::get('countries');
        $this->page_title = \Lang::get('page.create.title');
    }

}

