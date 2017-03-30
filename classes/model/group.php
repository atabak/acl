<?php

namespace Acl;

class Model_Group extends \Orm\Model
{

    protected static $_table_name = 'acl_users_groups';
    protected static $_properties = [
        'id',
        'name',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
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
    protected static $_observers  = [
        'Orm\\Observer_Self' => ['events' => ['before_insert', 'before_update']],
    ];

    public function _event_before_insert()
    {
        $this->created_at = \Myclasses\FNC::currentdbtime();
        $this->created_by = \Acl\Acl::current_user_id();
    }

    public function _event_before_update()
    {
        $this->updated_at = \Myclasses\FNC::currentdbtime();
        $this->updated_by = \Acl\Acl::current_user_id();
    }

}
