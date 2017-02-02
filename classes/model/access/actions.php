<?php

namespace Acl;

class Model_Actions extends \Orm\Model
{

    protected static $_table_name = 'acl_users_modules_controllers_actions';
    protected static $_properties = [
        'id',
        'controller_id',
        'name',
        'uri',
        'order',
        'is_active',
        'is_visible'
    ];
    protected static $_belongs_to = [
        'controller' => [
            'key_from'       => 'controller_id',
            'model_to'       => 'Model_Controller',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ]
    ];
    protected static $_has_many   = [
        'access' => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Access_Action',
            'key_to'         => 'action_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
    ];

    // check uniq name in module
    public static function duplicate_check($controller_id, $action, $id = null)
    {
        $result = static::query()
                ->where('controller_id', $controller_id)
                ->where('name', $action);
        if ($id) {
            $result->where('id', '!=', $id);
        }
        $duplicate = $result->get_one();
        return $duplicate ? TRUE : FALSE;
    }

    public static function current_order($controller)
    {
        $entry = static::query()
                ->select('order')
                ->where('controller_id', $controller)
                ->order_by('order', 'DESC')
                ->get_one();
        return $entry ? $entry->order + 1 : 1;
    }

}
