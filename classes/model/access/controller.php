<?php

namespace Acl;

class Model_Controller extends \Orm\Model
{

    protected static $_table_name = 'acl_users_modules_controller';
    protected static $_properties = [
        'id',
        'module_id',
        'name',
        'url',
        'order',
        'is_active'
    ];
    protected static $_belongs_to = [
        'module' => [
            'key_from'       => 'module_id',
            'model_to'       => 'Model_Module',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ]
    ];
    protected static $_has_many   = [
        'actions' => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Actions',
            'key_to'         => 'controller_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'access'  => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Access_Controller',
            'key_to'         => 'controller_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
    ];

    // check uniq name in module
    public static function duplicate_check($module_id, $controller, $id = null)
    {
        $result = static::query()
                ->where('module_id', $module_id)
                ->where('name', $controller);
        if ($id)
        {
            $result->where('id', '!=', $id);
        }
        $duplicate = $result->get_one();
        return $duplicate ? TRUE : FALSE;
    }

    public static function current_order($module_id)
    {
        $entry = static::query()
                ->select('order')
                ->where('module_id', $module_id)
                ->order_by('order', 'DESC')
                ->get_one();
        return $entry ? $entry->order + 1 : 1;
    }

    public static function getname($id)
    {
        $controller = static::find($id);
        return $controller ? $controller->name : '';
    }

}
