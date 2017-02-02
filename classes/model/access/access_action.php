<?php

namespace Acl;

class Model_Access_Action extends \Orm\Model
{

    protected static $_table_name = 'acl_users_access_actions';
    protected static $_properties = [
        'id',
        'user_id',
        'action_id'
    ];
    protected static $_belongs_to = [
        'user'   => [
            'key_from'       => 'user_id',
            'model_to'       => 'Model_user',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
        'action' => [
            'key_from'       => 'action_id',
            'model_to'       => 'Model_Actions',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
    ];

}
