<?php

namespace Pump\Model;

class Model_JobSchedule extends \Orm\Model
{

	protected static $_table_name = 'job_schedule';

	protected static $_properties = array(
        'id',
        'cmd' => array(
            'data_type' => 'varchar',
            'label' => 'Command',
            'validation' => array('required', 'min_length' => array(3), 'max_length' => array(100)),
            'form' => array(
                'type' => false,
            ),
        ),
        'data' => array(
            'data_type' => 'textda',
            'label' => 'Command',
            'validation' => array('required', 'min_length' => array(3), 'max_length' => array(100)),
            'form' => array(
                'type' => false,
            ),
        ),
        'error_label' => array(
            'data_type' => 'varchar',
            'label' => 'Error Label',
            'form' => array(
                'type' => false,
            ),
        ),
        'error' => array(
            'data_type' => 'varchar',
            'label' => 'Command',
            'validation' => array('required', 'min_length' => array(3), 'max_length' => array(100)),
            'form' => array(
                'type' => false,
            ),
        ),
        'server_id' => array(
            'data_type' => 'int',
            'label' => 'Server ID',
            'validation' => array('required'),
            'form' => array(
                'type' => false,
            ),
            'default' => '1',
        ),
        'status_id' => array(
            'data_type' => 'int',
            'label' => 'Status',
            'form' => array(
                'type' => false,
            ),
        ),
        'memory_usage' => array(
            'data_type' => 'int',
            'label' => 'Memory Usage',
            'form' => array(
                'type' => false,
            ),
        ),
        'created_at' => array(
            'data_type' => 'int',
            'label' => 'Created At',
            'form' => array(
                'type' => false,
            ),
        ),
        'updated_at' => array(
            'data_type' => 'int',
            'label' => 'Updated At',
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

}
