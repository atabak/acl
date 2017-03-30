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
        
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'action_id');
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_table($this->table);
    }

}
