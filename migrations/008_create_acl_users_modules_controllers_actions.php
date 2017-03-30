<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controllers_actions
{

    protected $table = 'acl_users_modules_controllers_actions';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'            => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'controller_id' => ['type' => 'int'],
            'name'          => ['type' => 'varchar', 'constraint' => 512,],
            'uri'           => ['type' => 'varchar', 'constraint' => 256],
            'order'         => ['type' => 'int'],
            'is_active'     => ['type' => 'smallint'],
            'is_visible'    => ['type' => 'smallint'],
                ], ['id'], true, false, false);
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'controller_id');
        \DBUtil::drop_table($this->table);
    }

}
