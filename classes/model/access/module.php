<?php

namespace Acl;

class Model_Module extends \Orm\Model
{

    /**
     * @property integer                        $id
     * @property string                         $name
     * @property string                         $url
     * @property integer                        $order
     * @property string                         $icon
     * @property string                         $color
     * @property bool                           $is_active
     * @property \\Acl\\Model_Controller        $controlles
     * @property \\Acl\\Model_Access_Module     $access
     */
    protected static $_table_name = 'acl_users_modules';
    protected static $_properties = [
        'id',
        'name',
        'url',
        'order',
        'icon',
        'color',
        'is_active'
    ];
    protected static $_has_many   = [
        'controlles' => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Controller',
            'key_to'         => 'module_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
        'access'     => [
            'key_from'       => 'id',
            'model_to'       => 'Model_Access_Module',
            'key_to'         => 'module_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ],
    ];

    public static function current_order()
    {
        $entry = static::query()
                ->select('order')
                ->order_by('order', 'DESC')
                ->get_one();
        return $entry->order ? $entry->order + 1 : 1;
    }

    public static function getename($id)
    {
        $module = static::find($id);
        return $module ? $module->name : '';
    }

}
