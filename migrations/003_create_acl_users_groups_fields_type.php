<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields_type
{

    protected $table = 'acl_users_groups_fields_type';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'   => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'name' => ['type' => 'varchar', 'constraint' => 256],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
