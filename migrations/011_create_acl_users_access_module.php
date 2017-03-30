<?php

namespace Fuel\Migrations;

class Create_acl_users_access_module
{

    protected $table = 'acl_users_access_module';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'        => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'   => ['type' => 'int'],
            'module_id' => ['type' => 'int'],
                ], ['id'], true, false, false);
        
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'module_id');
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_table($this->table);
    }

}
