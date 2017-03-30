<?php

namespace Fuel\Migrations;

class Create_acl_users_groups
{

    protected $table = 'acl_users_groups';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'         => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'name'       => ['constraint' => 256, 'type' => 'varchar'],
            'created_at' => ['type' => 'int'],
            'created_by' => ['type' => 'int'],
            'updated_at' => ['type' => 'int', 'null' => true],
            'updated_by' => ['type' => 'int', 'null' => true]
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_foreign_key('acl_users', 'group_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'updated_by');
        \DBUtil::drop_table($this->table);
    }

}
