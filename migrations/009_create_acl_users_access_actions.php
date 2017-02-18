<?php

namespace Fuel\Migrations;

class Create_acl_users_access_actions
{

    protected $table = 'acl_users_access_actions';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'   => ['type' => 'int'],
            'action_id' => ['type' => 'int'],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'action_id', 'acl_users_access_actions_action_id');
        \DBUtil::create_index($this->table, 'user_id', 'acl_users_access_actions_user_id');
        \DBUtil::add_foreign_key($this->table, ['key' => 'action_id', 'reference' => ['table' => 'acl_users_modules_controllers_actions', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DB::insert()
                ->table($this->table)
                ->columns(['user_id', 'action_id'])
                ->values([
                        [1, 1],
                        [1, 2],
                        [1, 3],
                        [1, 4],
                        [1, 5],
                        [1, 6],
                        [1, 7],
                        [1, 8],
                        [1, 9],
                        ]
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'action_id');
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_table($this->table);
    }

}
