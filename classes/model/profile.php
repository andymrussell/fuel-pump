<?php

namespace Pump\Model;

class Model_Profile extends \Orm\Model
{

    protected static $_belongs_to = array('user');

    protected static $_properties = array(
        'id',
        'f_name' => array(
            'data_type' => 'varchar',
            'validation' => array('required', 'min_length' => array(1), 'max_length' => array(100)),
            'form' => array('type' => 'text', 'class' => 'span6'),
        ),
        'l_name' => array(
            'data_type' => 'varchar',
            'validation' => array('required', 'min_length' => array(1), 'max_length' => array(100)),
            'form' => array('type' => 'text', 'class' => 'span6'),
        ),
        'gender' => array(
            'data_type' => 'varchar',
            'validation' => array('required', 'min_length' => array(1), 'max_length' => array(1)),
            'form' => array('type' => 'select', 'class' => 'span6'),
        ),
        'dob' => array(
            'data_type' => 'varchar',        
            'validation' => array('required', 'min_length' => array(8), 'max_length' => array(8)),
            'form' => array('type' => 'text', 'class' => 'span6'),
        ),
        // 'location' => array(
        //     'data_type' => 'varchar',
        //     'validation' => array('required', 'min_length' => array(1), 'max_length' => array(45)),
        //     'form' => array('type' => 'text', 'class' => 'span6'),
        // ),
        'country_id' => array(
            'data_type' => 'char',
            'validation' => array('required'),
            'form' => array(
                'type' => 'select',
                'options' => array(),
                'class' => 'span6',
            ),
        ),
        'user_id' => array(
            'data_type' => 'int',
            'validation' => array('required'),
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
        \Lang::load('profile');

        // load the countries by countrycode
        \Lang::load('countrycodes', 'countries');

        // load the timezones
        //\Lang::load('timezones', 'timezones');


        // set the field labels
        foreach (\Lang::get('field') as $field => $value)
        {
            isset(static::$_properties[$field]) and static::$_properties[$field]['label'] = $value;
        }

        // set the gender options
        static::$_properties['gender']['form']['options'] = \Lang::get('other.genderlist');
        
        // set the country options
        static::$_properties['country_id']['form']['options'] = \Lang::get('countries');

        //Additional bits we might need to set at a later date

        // set the locale options
        //static::$_properties['locale']['form']['options'] = \Config::get('exitecms.locales');

        // set the timezone options
        //static::$_properties['timezone']['form']['options'] = \Lang::get('timezones');
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
