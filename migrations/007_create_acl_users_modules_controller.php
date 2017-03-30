<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controller
{

    protected $table = 'acl_users_modules_controller';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'module_id' => ['type' => 'int'],
            'name'      => ['type' => 'varchar', 'constraint' => 512],
            'url'       => ['type' => 'varchar', 'constraint' => 256],
            'order'     => ['type' => 'int'],
            'is_active' => ['type' => 'smallint'],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'module_id');
        \DBUtil::drop_table($this->table);
    }

}
