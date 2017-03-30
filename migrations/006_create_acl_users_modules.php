<?php

namespace Fuel\Migrations;

class Create_acl_users_modules
{

    protected $table = 'acl_users_modules';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'name'      => ['type' => 'varchar', 'constraint' => 512],
            'url'       => ['type' => 'varchar', 'constraint' => 256],
            'order'     => ['type' => 'int'],
            'icon'      => ['type' => 'varchar', 'constraint' => 45],
            'color'     => ['type' => 'varchar', 'constraint' => 45, 'null' => true],
            'is_active' => ['type' => 'smallint', 'default' => 0],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
