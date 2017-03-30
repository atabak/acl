<?php

namespace Acl;

class Model_Group_Field_Values extends \Orm\Model
{

    protected static $_table_name = 'acl_users_groups_fields_values';
    protected static $_properties = [
        'id', 
        'user_id',
        'field_id',
        'value',
        'created_at',
        'created_by'
    ];
    protected static $_belongs_to = [
        'user'    => [
            'key_from'       => 'user_id',
            'model_to'       => '\\Acl\\Model_User',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
        'field'   => [
            'key_from'       => 'field_id',
            'model_to'       => '\\Acl\\Model_Group_Field',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => true
        ],
        'creator' => [
            'key_from'       => 'created_by',
            'model_to'       => '\\Acl\\Model_User',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
    ];

}
