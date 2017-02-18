<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controllers_actions
{

    protected $table = 'acl_users_modules_controllers_actions';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'            => ['type' => 'int', 'auto_increment' => true],
            'controller_id' => ['type' => 'int'],
            'name'          => ['constraint' => 512, 'type' => 'varchar'],
            'uri'           => ['constraint' => 256, 'type' => 'varchar'],
            'order'         => ['type' => 'int'],
            'is_active'     => ['type' => 'bool', 'default' => true],
            'is_visible'    => ['type' => 'bool', 'default' => true],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'controller_id', 'acl_users_modules_controllers_actions_controller_id');
        \DBUtil::create_index($this->table, 'order', 'acl_users_modules_controllers_actions_order');
        \DBUtil::create_index($this->table, 'is_active', 'acl_users_modules_controllers_actions_is_active');
        \DBUtil::create_index($this->table, 'uri', 'acl_users_modules_controllers_actions_uri');
        \DBUtil::add_foreign_key($this->table, ['key' => 'controller_id', 'reference' => ['table' => 'acl_users_modules_controller', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DB::insert()
                ->table($this->table)
                ->columns(['controller_id', 'name', 'uri', 'order', 'is_active', 'is_visible'])
                ->values([
                        [1, 'ایجاد کاربر', 'create', 1, true, true],
                        [1, 'ویرایش کاربر', 'edit', 3, true, false],
                        [1, 'تایید کاربران', 'confirmusr', 3, true, false],
                        [1, 'جستجو', 'search', 1, true, true],
                        [2, 'مدیریت گروه ها', 'index', 1, true, true],
                        [2, 'مدیریت فیلد ها', 'fields', 2, true, true],
                        [3, 'ماژول', 'modules', 1, true, true],
                        [3, 'کلاس ها', 'controller', 2, true, true],
                        [3, 'توابع', 'actions', 3, true, true],
                        ]
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'controller_id');
        \DBUtil::drop_table($this->table);
    }

}
