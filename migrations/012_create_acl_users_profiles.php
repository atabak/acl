<?php

namespace Fuel\Migrations;

class Create_acl_users_profiles
{

    protected $table = 'acl_users_profiles';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'          => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'     => ['type' => 'int'],
            'first'       => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'last'        => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'pic'         => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'cell'        => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'created_at'  => ['type' => 'int'],
            'created_by'  => ['type' => 'int'],
            'updated_at'  => ['type' => 'int', 'null' => true],
            'updated_by'  => ['type' => 'int', 'null' => true],
            'confirm_at'  => ['type' => 'int', 'null' => true],
            'confirm_by'  => ['type' => 'int', 'null' => true],
            'locked_at'   => ['type' => 'int', 'null' => true],
            'unlocked_at' => ['type' => 'int', 'null' => true],
            'unlocked_by' => ['type' => 'int', 'null' => true],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'updated_by');
        \DBUtil::drop_foreign_key($this->table, 'confirm_by');
        \DBUtil::drop_foreign_key($this->table, 'unlocked_by');
        \DBUtil::drop_table($this->table);
    }

}
