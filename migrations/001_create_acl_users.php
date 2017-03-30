<?php

namespace Fuel\Migrations;

class Create_acl_users
{

    protected $table = 'acl_users';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'          => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'username'    => ['type' => 'varchar', 'constraint' => 256],
            'email'       => ['type' => 'varchar', 'constraint' => 256, 'null' => true],
            'password'    => ['type' => 'varchar', 'constraint' => 512],
            'group_id'    => ['type' => 'int'],
            'is_active'   => ['type' => 'smallint', 'default' => 0, 'null' => true],
            'is_confirm'  => ['type' => 'smallint', 'default' => 0, 'null' => true],
            'unsuccess'   => ['type' => 'int', 'default' => 0, 'null' => true],
            'remember'    => ['constraint' => 512, 'type' => 'varchar', 'null' => true],
            'remember_at' => ['type' => 'int', 'null' => true],
            'is_locked'   => ['type' => 'smallint', 'default' => 0],
            'forget_code' => ['constraint' => 512, 'type' => 'varchar', 'null' => true],
            'forget_at'   => ['type' => 'int', 'null' => true],
            'lock_at'     => ['type' => 'int', 'default' => 0, 'null' => true],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
