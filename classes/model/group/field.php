<?php

namespace Acl;

class Model_Group_Field extends \Orm\Model
{

    protected static $_table_name = 'acl_users_groups_fields';
    protected static $_properties = [
        'id',
        'group_id',
        'label',
        'type_id',
        'order',
        'size',
        'is_editable',
        'is_required',
        'default_values',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    protected static $_belongs_to = [
        'group'   => [
            'key_from'       => 'group_id',
            'model_to'       => 'Model_Group',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'type'    => [
            'key_from'       => 'type_id',
            'model_to'       => 'Model_Group_Field_Type',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'creator' => [
            'key_from'       => 'created_by',
            'model_to'       => 'Model_User',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'editor'  => [
            'key_from'       => 'updated_by',
            'model_to'       => 'Model_User',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
    ];
    protected static $_observers  = [
        'Orm\\Observer_Self' => ['events' => ['before_insert', 'before_update']],
    ];

    public function _event_before_insert()
    {
        $this->created_at = \Myclasses\FNC::currentdbtime();
        $this->created_by = Acl::current_user_id();
    }

    public function _event_before_update()
    {
        $this->updated_at = \Myclasses\FNC::currentdbtime();
        $this->updated_by = Acl::current_user_id();
    }

    public static function is_duplicate($group_id, $label, $id = null)
    {
        $duplicate = static::query()
                ->where('group_id', $group_id)
                ->where('label', $label);
        if ($id) {
            $duplicate->where('id', '!=', $id);
        }
        return $duplicate->count() ? true : false;
    }

}
