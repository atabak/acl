<?php

namespace Acl;

class Model_Group extends \Orm\Model
{

    protected static $_table_name = 'acl_users_groups';
    protected static $_properties = [
        'id',
        'name'
    ];
    protected static $_has_many   = [
        'users'  => [
            'key_from'       => 'id',
            'model_to'       => 'Model_User',
            'key_to'         => 'group_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'fields' => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Group_Field',
            'key_to'         => 'group_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ]
    ];

}
