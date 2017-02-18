<?php

namespace Fuel\Migrations;

class Create_acl_users_access_controller
{

    protected $table = 'acl_users_access_controller';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'            => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'       => ['type' => 'int'],
            'controller_id' => ['type' => 'int'],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'controller_id', 'acl_users_access_controller_controller_id');
        \DBUtil::create_index($this->table, 'user_id', 'acl_users_access_controller_user_id');
        \DBUtil::add_foreign_key($this->table, ['key' => 'controller_id', 'reference' => ['table' => 'acl_users_modules_controller', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DB::insert()
                ->table($this->table)
                ->columns(['user_id', 'controller_id'])
                ->values([
                        [1, 1],
                        [1, 2],
                        [1, 3],
                        ]
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'controller_id');
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_table($this->table);
    }

}
