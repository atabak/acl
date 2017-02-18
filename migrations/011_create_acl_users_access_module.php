<?php

namespace Fuel\Migrations;

class Create_acl_users_access_module
{

    protected $table = 'acl_users_access_module';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'   => ['type' => 'int'],
            'module_id' => ['type' => 'int'],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'module_id', 'acl_users_access_module_module_id');
        \DBUtil::create_index($this->table, 'user_id', 'acl_users_access_module_user_id');
        \DBUtil::add_foreign_key($this->table, ['key' => 'module_id', 'reference' => ['table' => 'acl_users_modules', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DB::insert()
                ->table($this->table)
                ->columns(['user_id', 'module_id'])
                ->values([[1, 1]])
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'module_id');
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_table($this->table);
    }

}
