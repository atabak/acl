<?php

namespace Acl;

class Model_Access_Controller extends \Orm\Model
{

    protected static $_table_name = 'acl_users_access_controller';
    protected static $_properties = [
        'id',
        'user_id',
        'controller_id'
    ];
    protected static $_belongs_to = [
        'user'       => [
            'key_from'       => 'user_id',
            'model_to'       => 'Model_user',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
        'controller' => [
            'key_from'       => 'controller_id',
            'model_to'       => 'Model_Controller',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
    ];

}
