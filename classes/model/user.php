<?php

namespace Pump\Model;

class Model_User extends \Orm\Model
{

    //protected static $_has_many = array('accounts','transactions','balances');

    protected static $_has_many = array(
    // 'accounts' => array(
    //     'model_to' => '\\Model_Account',
    // ),
    // 'transactions' => array(
    //         'model_to' => '\\Model_Transaction',
    //     ),
    // 'balances' => array(
    //     'model_to' => '\\Model_Balance',
    // )
    );

    protected static $_has_one = array(
         'profile'
    );

	protected static $_properties = array(
        'id',
        'username' => array(
            'data_type' => 'varchar',
            'validation' => array('min_length' => array(6), 'max_length' => array(100)),
            'form' => array('type' => false),
        ),
        'email' => array(
            'data_type' => 'varchar',
            'validation' => array('required', 'valid_email', 'min_length' => array(6), 'max_length' => array(100)),
            'form' => array('type' => 'text', 'class' => 'span6'),
        ),
        'password' => array(
            'data_type' => 'varchar',
            'validation' => array('min_length' => array(7), 'max_length' => array(12)),
            'form' => array('type' => 'password', 'class' => 'span6'),
        ),
        'group' => array(
            'data_type' => 'int',
            'validation' => array(),
            'default' => '1',
            'form' => array(
                'type' => false,
            ),
        ),
        'last_login' => array(
            'data_type' => 'int',
            'form' => array(
                'type' => false,
            ),
        ),
        'login_hash' => array(
            'data_type' => 'varchar',
            'form' => array(
                'type' => false,
            ),
        ),
        'created_at' => array(
            'data_type' => 'int',
            'form' => array(
                'type' => false,
            ),
        ),
        'updated_at' => array(
            'data_type' => 'int',
            'form' => array(
                'type' => false,
            ),
        ),
    );


	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);


  public static function _init()
    {

        // load the language file for this model
        \Lang::load('user');

        $a = \Lang::get('field');
        // set the field labels
		foreach (\Lang::get('field') as $field => $value)
		{
			isset(static::$_properties[$field]) and static::$_properties[$field]['label'] = $value;
		}

    }


    public function populate(array $data = array())
    {
        // get the data
        empty($data) and $data = \Input::post();

        foreach ($data as $name => $value)
        {
            isset(static::$_properties[$name]) and $this->{$name} = $value;
        }
    }

}

