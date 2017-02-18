<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controller
{

    protected $table = 'acl_users_modules_controller';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'auto_increment' => true],
            'module_id' => ['type' => 'int'],
            'name'      => ['constraint' => 512, 'type' => 'varchar'],
            'url'       => ['constraint' => 256, 'type' => 'varchar'],
            'order'     => ['type' => 'int'],
            'is_active' => ['type' => 'bool', 'default' => false],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'module_id', 'acl_users_modules_controller_module_id');
        \DBUtil::create_index($this->table, 'url', 'acl_users_modules_controller_url');
        \DBUtil::create_index($this->table, 'order', 'acl_users_modules_controller_order');
        \DBUtil::create_index($this->table, 'is_active', 'acl_users_modules_controller_is_active');
        \DBUtil::add_foreign_key($this->table, ['key' => 'module_id', 'reference' => ['table' => 'acl_users_modules', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DB::insert()
                ->table($this->table)
                ->columns(['module_id', 'name', 'url', 'order', 'is_active'])
                ->values([
                        [1, 'کاربران', 'user', 1, true],
                        [1, 'مدیریت گروه های کاربری', 'groups', 1, true],
                        [1, 'مدیریت دسترسی ها', 'access', 1, true],
                        ]
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'module_id');
        \DBUtil::drop_table($this->table);
    }

}
