<?php

namespace Fuel\Migrations;

class Create_acl_users
{

    protected $table = 'acl_users';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'         => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'username'   => ['constraint' => 256, 'type' => 'varchar'],
            'email'      => ['constraint' => 256, 'type' => 'varchar', 'null' => true],
            'password'   => ['constraint' => 512, 'type' => 'varchar'],
            'group_id'   => ['type' => 'int'],
            'is_active'  => ['type' => 'bool', 'default' => false],
            'is_confirm' => ['type' => 'bool', 'default' => false],
            'unsuccess'  => ['type' => 'int', 'default' => 0],
            'remember'   => ['constraint' => 512, 'type' => 'varchar', 'default' => ''],
            'is_locked'  => ['type' => 'bool', 'default' => false],
            'lock_at'    => ['type' => 'int', 'default' => 0],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'username', 'acl_usersr_username', 'UNIQUE');
        \DBUtil::create_index($this->table, 'email', 'acl_users_email', 'UNIQUE');
        \DBUtil::create_index($this->table, 'group_id', 'acl_users_group_id');
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
