<?php

namespace Fuel\Migrations;

class Create_acl_users_modules
{

    protected $table = 'acl_users_modules';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'name'      => ['constraint' => 512, 'type' => 'varchar'],
            'url'       => ['constraint' => 256, 'type' => 'varchar'],
            'order'     => ['type' => 'int'],
            'icon'      => ['constraint' => 45, 'type' => 'varchar'],
            'color'     => ['constraint' => 45, 'type' => 'varchar', 'null' => true],
            'is_active' => ['type' => 'bool', 'default' => false],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'url', 'acl_users_modules_url');
        \DBUtil::create_index($this->table, 'order', 'acl_users_modules_order');
        \DBUtil::create_index($this->table, 'is_active', 'acl_users_modules_is_active');
        \DB::insert()
                ->table($this->table)
                ->columns(['name', 'url', 'order', 'icon', 'color', 'is_active'])
                ->values([['مدیریت کاربران', 'dashboard/users', 1000, 'fa-user', '', true]])
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
