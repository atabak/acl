<?php

namespace Acl;

class Model_Access_Module extends \Orm\Model
{

    protected static $_table_name = 'acl_users_access_module';
    protected static $_properties = [
        'id',
        'user_id',
        'module_id'
    ];
    protected static $_belongs_to = [
        'user'   => [
            'key_from'       => 'user_id',
            'model_to'       => 'Model_user',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
        'module' => [
            'key_from'       => 'module_id',
            'model_to'       => 'Model_Module',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
    ];

}
